<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra la vista de inicio de sesión.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa la solicitud de inicio de sesión.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
       
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // ✅ Verifica si el usuario está inhabilitado
        if (! $user->activo) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tu cuenta ha sido inhabilitada. Contacta con el administrador.',
            ]);
        }

        // ✅ Redirección según el rol del usuario
        return match ($user->role) {
            'administrador' => redirect()->route('admin.dashboard'),
            'cliente'       => redirect()->route('cliente.dashboard'),
            'gestion'       => redirect()->route('gestion.dashboard'),
            default         => redirect('/dashboard'),
        };
    }

    /**
     * Cierra la sesión del usuario autenticado.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
