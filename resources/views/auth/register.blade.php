@extends('layouts.guest')

@section('content')
<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h4>Registro de Usuario</h4>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <input type="hidden" name="role" value="cliente">

            </div>

            <!-- Campos adicionales -->
            <div class="mb-3">
                <label class="form-label">Documento</label>
                <input type="text" name="documento" class="form-control" required value="{{ old('documento') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" required value="{{ old('direccion') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono Personal</label>
                <input type="text" name="telefono_personal" class="form-control" required value="{{ old('telefono_personal') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de Sangre</label>
                <select name="tipo_sangre" class="form-select" required>
                    <option value="">Selecciona</option>
                    @foreach (['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo_sangre') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">EPS</label>
                <input type="text" name="eps" class="form-control" required value="{{ old('eps') }}">
            </div>
            <div class="mb-3">
               
                <input type="hidden"  name="otra_eps" class="form-control" value="{{ old('otra_eps') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Contacto de Emergencia</label>
                <input type="text" name="contacto_emergencia" class="form-control" required value="{{ old('contacto_emergencia') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono de Contacto de Emergencia</label>
                <input type="text" name="telefono_contacto_emergencia" class="form-control" required value="{{ old('telefono_contacto_emergencia') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Foto (opcional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Registrarse</button>
            </div>
        </form>
    </div>
</div>
@endsection
