<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Procesa el registro del usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'documento' => ['required', 'string'],
            'direccion' => ['required', 'string'],
            'telefono_personal' => ['required', 'string'],
            'tipo_sangre' => ['required', 'string'],
            'eps' => ['required', 'string'],
            'otra_eps' => ['nullable', 'string'],
            'contacto_emergencia' => ['required', 'string'],
            'telefono_contacto_emergencia' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cliente', // Rol por defecto
            'documento' => $request->documento,
            'direccion' => $request->direccion,
            'telefono_personal' => $request->telefono_personal,
            'tipo_sangre' => $request->tipo_sangre,
            'eps' => $request->eps,
            'otra_eps' => $request->otra_eps,
            'contacto_emergencia' => $request->contacto_emergencia,
            'telefono_contacto_emergencia' => $request->telefono_contacto_emergencia,
        ]);

        // Guardar foto si se sube
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/fotos');
            $user->foto = Storage::url($path); // /storage/fotos/archivo.jpg
        }

        $user->save();

        // Generar QR SVG
        $qrContent = route('perfil.publico', $user->id);
        $qrSvg = QrCode::format('svg')->size(250)->generate($qrContent);
        $qrPath = 'public/qrcodes/qr_' . $user->id . '.svg';
        Storage::put($qrPath, $qrSvg);
        $user->ruta_qr = Storage::url($qrPath);

        $user->save();

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
