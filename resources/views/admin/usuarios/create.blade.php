@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Crear Usuario</h1>

    <div id="alert-container"></div>

    <form id="crearUsuarioForm" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nombre:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Confirmar Contraseña:</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Rol:</label>
            <select name="role" class="form-select" required>
                <option value="">Selecciona un rol</option>
                <option value="administrador">Administrador</option>
                <option value="cliente">Cliente</option>
                <option value="gestion">Gestión</option>
            </select>
        </div>

        <!-- Campos adicionales -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Documento:</label>
                <input type="text" name="documento" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Dirección:</label>
                <input type="text" name="direccion" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Teléfono Personal:</label>
                <input type="text" name="telefono_personal" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tipo de Sangre:</label>
                <select name="tipo_sangre" class="form-select" required>
                    <option value="">Seleccionar</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>EPS:</label>
                <input type="text" name="eps" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Contacto de Emergencia:</label>
                <input type="text" name="contacto_emergencia" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Teléfono de Contacto de Emergencia:</label>
                <input type="text" name="telefono_contacto_emergencia" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Foto (opcional):</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="d-grid mt-3">
            <button type="submit" class="btn btn-success">Guardar Usuario</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
    <!-- jQuery (debe ir antes que cualquier uso de $) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle JS (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('form').on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.usuarios.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario creado exitosamente',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('admin.usuarios.index') }}";
                        });
                    },
                    error: function (xhr) {
                        let errores = '';
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            errores += `• ${value[0]}<br>`;
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Error al crear usuario',
                            html: errores
                        });
                    }
                });
            });
        });
    </script>
@endsection
