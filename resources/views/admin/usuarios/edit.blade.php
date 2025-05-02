@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Editar Usuario</h4>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form id="editUserForm" action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $usuario->name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email', $usuario->email) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="role" class="form-select" required>
                        <option value="administrador" {{ $usuario->role === 'administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="cliente" {{ $usuario->role === 'cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="gestion" {{ $usuario->role === 'gestion' ? 'selected' : '' }}>Gestión</option>
                    </select>
                </div>

                <!-- Datos médicos y de emergencia -->
                <div class="mb-3">
                    <label class="form-label">Documento</label>
                    <input type="text" name="documento" class="form-control" required value="{{ old('documento', $usuario->documento) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" required value="{{ old('direccion', $usuario->direccion) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono Personal</label>
                    <input type="text" name="telefono_personal" class="form-control" required value="{{ old('telefono_personal', $usuario->telefono_personal) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de Sangre</label>
                    <select name="tipo_sangre" class="form-select" required>
                        @foreach (['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'] as $tipo)
                            <option value="{{ $tipo }}" {{ $usuario->tipo_sangre === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">EPS</label>
                    <input type="text" name="eps" class="form-control" required value="{{ old('eps', $usuario->eps) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Otra EPS (opcional)</label>
                    <input type="text" name="otra_eps" class="form-control" value="{{ old('otra_eps', $usuario->otra_eps) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contacto de Emergencia</label>
                    <input type="text" name="contacto_emergencia" class="form-control" required value="{{ old('contacto_emergencia', $usuario->contacto_emergencia) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono de Contacto de Emergencia</label>
                    <input type="text" name="telefono_contacto_emergencia" class="form-control" required value="{{ old('telefono_contacto_emergencia', $usuario->telefono_contacto_emergencia) }}">
                </div>

                <!-- Mostrar foto actual si existe -->
                @if ($usuario->foto)
                    <div class="mb-3 text-center">
                        <label class="form-label d-block">Foto Actual</label>
                        <img src="{{ asset($usuario->foto) }}" alt="Foto del usuario" class="img-thumbnail" width="150">
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Actualizar Foto (opcional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Actualizar</button>
                    <button type="button" class="btn btn-secondary" id="cancelarBtn">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('editUserForm').addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se actualizará la información del usuario.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    document.getElementById('cancelarBtn').addEventListener('click', function () {
        Swal.fire({
            title: '¿Deseas cancelar?',
            text: "Perderás los cambios no guardados.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, volver',
            cancelButtonText: 'Seguir editando'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.usuarios.index') }}";
            }
        });
    });
</script>
@endsection
