<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/perfil-publico/{id}', [UserController::class, 'showPublic'])->name('perfil.publico');

/*
|--------------------------------------------------------------------------
| Redirección post-login
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::middleware('auth')->get('/redirect', [RedirectController::class, 'index'])->name('redirect');

/*
|--------------------------------------------------------------------------
| Rutas protegidas por autenticación general
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil del usuario autenticado
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Panel de Administrador
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('usuarios', UserController::class);
    Route::post('usuarios/{usuario}/toggle', [UserController::class, 'toggleEstado'])->name('usuarios.toggle');
});

/*
|--------------------------------------------------------------------------
| Panel de Cliente
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/', function () {
        $usuario = auth()->user(); // ✅ Pasamos el usuario a la vista
        return view('cliente.dashboard', compact('usuario'));
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Panel de Gestión
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:gestion'])->prefix('gestion')->name('gestion.')->group(function () {
    Route::get('/', function () {
        return view('gestion.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
