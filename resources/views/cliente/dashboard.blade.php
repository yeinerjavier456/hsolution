@extends('layouts.cliente')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            <!-- Sección lateral con foto -->
            <div class="col-md-4 bg-primary text-white text-center d-flex flex-column justify-content-center align-items-center p-4">
                @if (!empty($usuario->foto))
                    <img src="{{ asset($usuario->foto) }}" alt="Foto del usuario" class="rounded-circle mb-3 shadow" style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <img src="https://img.freepik.com/psd-gratis/ilustracion-3d-avatar-o-perfil-humano_23-2150671142.jpg" alt="Default User image" class="rounded-circle mb-3 shadow" style="width: 120px; height: 120px; object-fit: cover;">
                @endif
                <h5 class="fw-bold">{{ $usuario->name }}</h5>
             
            </div>

            <!-- Contenido del usuario -->
            <div class="col-md-8 bg-light p-4 position-relative">
                <h5 class="mb-3 text-secondary">Información Personal</h5>

                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>Tipo de Sangre:</strong> {{ $usuario->tipo_sangre }}</li>
                    <li class="list-group-item"><strong>Documento:</strong> {{ $usuario->documento }}</li>
                    <li class="list-group-item"><strong>EPS:</strong> {{ $usuario->eps }}</li>
                    @if (!empty($usuario->observaciones))
                        <li class="list-group-item bg-warning-subtle"><strong>Importante:</strong> {{ $usuario->observaciones }}</li>
                    @endif
                </ul>

                <h6 class="text-secondary">Contacto de Emergencia</h6>
                <p><strong>{{ $usuario->contacto_emergencia }}</strong> - {{ $usuario->telefono_contacto_emergencia }}</p>

                @if (!empty($usuario->ruta_qr))
                    <div class="position-absolute bottom-0 end-0 m-3 bg-white p-2 rounded-3 shadow">
                        <img src="{{ asset($usuario->ruta_qr) }}" alt="Código QR" height="80">
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
