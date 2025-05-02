@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>Ficha Médica</h1>
    <div class="card shadow mt-4 p-4">
        @if($usuario->foto)
            <img src="{{ $usuario->foto }}" alt="Foto" class="img-thumbnail mb-3" style="max-width: 200px;">
        @endif
        <h4>{{ $usuario->name }}</h4>
        <p><strong>Documento:</strong> {{ $usuario->documento }}</p>
        <p><strong>Dirección:</strong> {{ $usuario->direccion }}</p>
        <p><strong>Teléfono:</strong> {{ $usuario->telefono_personal }}</p>
        <p><strong>Tipo de Sangre:</strong> {{ $usuario->tipo_sangre }}</p>
        <p><strong>EPS:</strong> {{ $usuario->eps }}</p>
        <hr>
        <p><strong>Contacto de Emergencia:</strong> {{ $usuario->contacto_emergencia }}</p>
        <p><strong>Teléfono Emergencia:</strong> {{ $usuario->telefono_contacto_emergencia }}</p>
    </div>
</div>
@endsection
