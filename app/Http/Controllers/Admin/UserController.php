<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $usuarios = User::select(['id', 'name', 'email', 'role', 'created_at', 'activo']);
            return DataTables::of($usuarios)
                ->addColumn('acciones', function ($usuario) {
                    $toggleText = $usuario->activo ? 'Inhabilitar' : 'Habilitar';
                    $toggleClass = $usuario->activo ? 'btn-warning' : 'btn-success';

                    return '
                        <a href="' . route('admin.usuarios.edit', $usuario->id) . '" class="btn btn-sm btn-primary me-1">Editar</a>
                        <form action="' . route('admin.usuarios.destroy', $usuario->id) . '" method="POST" class="d-inline eliminar-form">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                        <form action="' . route('admin.usuarios.toggle', $usuario->id) . '" method="POST" class="d-inline toggle-form ms-1">
                            ' . csrf_field() . '
                            <button type="submit" class="btn btn-sm ' . $toggleClass . '">' . $toggleText . '</button>
                        </form>';
                })
                ->rawColumns(['acciones'])
                ->make(true);
        }

        return view('admin.usuarios.index');
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:administrador,cliente,gestion',
            'documento' => 'required|string',
            'direccion' => 'required|string',
            'telefono_personal' => 'required|string',
            'tipo_sangre' => 'required|string',
            'eps' => 'required|string',
            'otra_eps' => 'nullable|string',
            'contacto_emergencia' => 'required|string',
            'telefono_contacto_emergencia' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = new User($request->only([
            'name', 'email', 'role', 'documento', 'direccion', 'telefono_personal',
            'tipo_sangre', 'eps', 'otra_eps', 'contacto_emergencia', 'telefono_contacto_emergencia'
        ]));
        $user->password = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/fotos');
            $user->foto = Storage::url($path);
        }

        $user->activo = true;
        $user->save();

        $qrContent = route('perfil.publico', $user->id);
        $qrSvg = QrCode::format('svg')->size(250)->generate($qrContent);
        $qrPath = 'public/qrcodes/qr_' . $user->id . '.svg';
        Storage::put($qrPath, $qrSvg);
        $user->ruta_qr = Storage::url($qrPath);
        $user->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'role' => 'required|in:administrador,cliente,gestion',
            'documento' => 'required|string',
            'direccion' => 'required|string',
            'telefono_personal' => 'required|string',
            'tipo_sangre' => 'required|string',
            'eps' => 'required|string',
            'otra_eps' => 'nullable|string',
            'contacto_emergencia' => 'required|string',
            'telefono_contacto_emergencia' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $usuario->fill($request->only([
            'name', 'email', 'role', 'documento', 'direccion',
            'telefono_personal', 'tipo_sangre', 'eps', 'otra_eps',
            'contacto_emergencia', 'telefono_contacto_emergencia'
        ]));

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/fotos');
            $usuario->foto = Storage::url($path);
        }

        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado');
    }

    public function toggleEstado(User $usuario)
    {
        $usuario->activo = !$usuario->activo;
        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'Estado del usuario actualizado.');
    }

    public function showPublic($id)
    {
        $usuario = User::findOrFail($id);
        return view('perfil-publico', compact('usuario'));
    }
}
