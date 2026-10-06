<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Nutricion y Citas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <div style="display: flex; align-items: center; gap: 1rem;">
            @auth
                <button id="sidebar-toggle">Menu</button>
            @endauth
            <h2>Consultorio Nutricional</h2>
        </div>
        <div class="publicity-banner">
            Espacio de Publicidad Nutricional
        </div>
        <div>
            <button id="theme-toggle">Modo Claro/Oscuro</button>
            @auth
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Cerrar Sesion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn">Inicio de Sesion</a>
            @endauth
        </div>
    </header>

    <div class="layout-container">
        @auth
            <nav class="sidebar" id="sidebar">
                <ul style="list-style: none;">
                    @if(Auth::user()->esNutriologo())
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('nutriologo.dashboard') }}" class="btn" style="width:100%;">Calendario / Citas</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('nutriologo.pacientes') }}" class="btn" style="width:100%;">Pacientes</a></li>
                    @else
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('paciente.dashboard') }}" class="btn" style="width:100%;">Mis Citas</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="{{ route('paciente.perfil') }}" class="btn" style="width:100%;">Mi Expediente</a></li>
                    @endif
                </ul>
            </nav>
        @endauth

        <main class="content">
            @if(session('success'))
                <div class="card" style="border-color: var(--teal); background-color: var(--ash-grey); color: var(--ink-black);">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <footer>
        <p>Sistema Clinico de Nutricion &copy; 2026 - Todos los derechos reservados</p>
    </footer>
</body>
</html>