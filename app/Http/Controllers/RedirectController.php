<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function index(): RedirectResponse
    {
        $user = Auth::user();

        return match ($user->role) {
            'administrador' => redirect('/admin'),
            'cliente' => redirect('/cliente'),
            'gestion' => redirect('/gestion'),
            default => redirect('/dashboard'),
        };
    }
}
