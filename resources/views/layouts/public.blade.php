<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'El cambio empieza contigo') · Change.org</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Commissioner:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<!-- cabecera / navbar -->
<header class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-co">
        <div class="container">
            <a class="navbar-brand brand-logo me-lg-4" href="{{ route('home') }}">change.org</a>

            <div class="d-flex align-items-center gap-2 order-lg-last">
                <a href="{{ route('peticiones.create') }}" class="btn btn-outline-co btn-nav">Inicia una petición</a>
                @guest
                    <a href="{{ route('register') }}" class="d-none d-lg-inline fw-bold px-2">Registrarse</a>
                    <a href="{{ route('login') }}" class="d-none d-lg-inline fw-bold px-2">Entrar</a>
                @else
                    {{-- Logueado: solo el nombre del usuario y salir --}}
                    <span class="d-none d-lg-inline fw-bold px-2">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-none d-lg-inline">
                        @csrf
                        <button type="submit" class="btn btn-link fw-bold px-2 text-decoration-none" style="color: var(--texto)">Salir</button>
                    </form>
                @endguest
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-label="Abrir menú">
                    <i class="bi bi-list fs-2"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto gap-lg-1">
                    @auth
                        <li class="nav-item"><a class="nav-link @if(request()->routeIs('peticiones.mine')) active @endif" href="{{ route('peticiones.mine') }}">Mis peticiones</a></li>
                        <li class="nav-item"><a class="nav-link @if(request()->routeIs('peticiones.peticionesfirmadas')) active @endif" href="{{ route('peticiones.peticionesfirmadas') }}">Mis firmas</a></li>
                    @endauth
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('peticiones.index')) active @endif" href="{{ route('peticiones.index') }}"><i class="bi bi-search me-2"></i>Buscar</a></li>

                    {{-- En móvil las opciones de usuario van dentro del menú --}}
                    @guest
                        <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('login') }}">Entrar</a></li>
                    @else
                        <li class="nav-item d-lg-none"><span class="nav-link">{{ Auth::user()->name }}</span></li>
                        <li class="nav-item d-lg-none">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent">Salir</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
    @yield('content')
</main>

<!-- pie de página -->
<footer class="footer-co">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-4 col-lg">
                <h2>Participa</h2>
                <ul>
                    <li><a href="{{ route('peticiones.create') }}">Inicia una petición</a></li>
                    <li><a href="{{ route('peticiones.index') }}">Busca por tema</a></li>
                    <li><a href="{{ route('peticiones.index') }}">Busca peticiones</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <h2>Aprende</h2>
                <ul>
                    <li><a href="#">Guías para peticiones</a></li>
                    <li><a href="{{ route('peticiones.create') }}">Crea tu petición</a></li>
                    <li><a href="#">Reúne firmas</a></li>
                    <li><a href="#">Contacta con los medios</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <h2>Sobre nosotros</h2>
                <ul>
                    <li><a href="#">Sobre Change.org</a></li>
                    <li><a href="#">Visión</a></li>
                    <li><a href="#">Equipo</a></li>
                    <li><a href="#">Empleo</a></li>
                    <li><a href="#">Prensa</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <h2>Ayuda y aspectos legales</h2>
                <ul>
                    <li><a href="#">Centro de ayuda</a></li>
                    <li><a href="#">Normas de la comunidad</a></li>
                    <li><a href="#">Política de privacidad</a></li>
                    <li><a href="#">Términos de uso</a></li>
                    <li><a href="#">Política de cookies</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <h2>Síguenos</h2>
                <ul>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">X</a></li>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">TikTok</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="small">
                <strong>© {{ date('Y') }}, Change.org, PBC</strong><br>
                <span class="text-muted-co legal">Réplica de Change.org de Óscar Rubio · <a href="#">Política de privacidad</a> y <a href="#">Normas de uso</a>.</span>
            </div>
            <select class="form-select" aria-label="Idioma">
                <option selected>Español (España)</option>
                <option>English (US)</option>
                <option>Català</option>
            </select>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
