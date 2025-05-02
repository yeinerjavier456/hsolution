<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
     
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#clienteNavbar" aria-controls="clienteNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="clienteNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('cliente.dashboard') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://hsolutions.com.co/#objetivos">Objetivos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://hsolutions.com.co/#nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://hsolutions.com.co/#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://hsolutions.com.co/#valores">Valores</a>
                    </li>
                </ul>
    
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light" type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>
    

    <main class="py-4 container">
        @yield('content')
    </main>
</body>
</html>
