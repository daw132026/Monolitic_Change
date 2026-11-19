@extends('layouts.public')

@section('title', $peticion->titulo)

@php
    // ¿El usuario logueado ya ha firmado? ¿Es el creador?
    $yaFirmada = Auth::check() && $peticion->firmas()->where('user_id', Auth::id())->exists();
    $esCreador = Auth::check() && Auth::id() == $peticion->user_id;
    // Objetivo de firmas: la siguiente potencia de 10 (10, 100, 1.000...)
    $objetivo = max(10, (int) pow(10, ceil(log10($peticion->firmantes + 1))));
    $porcentaje = min(100, round($peticion->firmantes * 100 / $objetivo));
@endphp

@section('content')
    <!-- imagen principal con el título -->
    <section class="petition-hero">
        <img src="{{ $peticion->imagen_url }}" alt="{{ $peticion->titulo }}">
        <div class="hero-text">
            <span class="bar"></span>
            <h1>{{ $peticion->titulo }}</h1>
        </div>
    </section>

    <div class="petition-body">
        <div class="container">
            <div class="row g-4 g-lg-5">

                <!-- tarjeta de firma (arriba en móvil, flotante a la derecha en escritorio) -->
                <aside class="col-lg-4 order-lg-2 sign-col">
                    <div class="sign-card" id="firmar">
                        @if (session('ok'))
                            <div class="alert alert-success small"><i class="bi bi-check-circle-fill me-1"></i> {{ session('ok') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger small"><i class="bi bi-exclamation-circle-fill me-1"></i> {{ session('error') }}</div>
                        @endif

                        <div class="text-center mb-3">
                            <div class="sign-total">{{ number_format($peticion->firmantes, 0, ',', '.') }} <i class="bi bi-patch-check-fill" title="Verificadas"></i></div>
                            <div class="small text-muted-co mt-1">Firmas · objetivo {{ number_format($objetivo, 0, ',', '.') }}</div>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="width: {{ $porcentaje }}%; background: var(--azul);"></div>
                        </div>

                        @auth
                            @if ($yaFirmada)
                                <div class="alert alert-success mb-0 small">
                                    <i class="bi bi-check-circle-fill me-1"></i> Ya has firmado esta petición. ¡Compártela para conseguir más apoyos!
                                </div>
                            @else
                                <form action="{{ route('peticiones.firmar', $peticion->id) }}" method="POST">
                                    @csrf
                                    <h2 class="h5 fw-bold mb-3">Firma esta petición</h2>
                                    <p class="small mb-3">Vas a firmar como <strong>{{ Auth::user()->name }}</strong>.</p>
                                    <button type="submit" class="btn btn-yellow w-100"><i class="bi bi-pen me-2"></i>Firma la petición</button>
                                </form>
                            @endif

                            {{-- Solo el creador puede editar o borrar --}}
                            @if ($esCreador)
                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('peticiones.edit', $peticion->id) }}" class="btn btn-outline-co btn-sm flex-fill"><i class="bi bi-pencil me-1"></i> Editar</a>
                                    <form action="{{ route('peticiones.delete', $peticion->id) }}" method="POST" class="flex-fill"
                                          onsubmit="return confirm('¿Seguro que quieres borrar la petición?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-co btn-sm w-100"><i class="bi bi-trash me-1"></i> Borrar</button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <h2 class="h5 fw-bold mb-3">Firma esta petición</h2>
                            <p class="small mb-3">Para firmar necesitas una cuenta.</p>
                            <a href="{{ route('login') }}" class="btn btn-yellow w-100 mb-2"><i class="bi bi-box-arrow-in-right me-2"></i>Entra para firmar</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-co w-100">Crear una cuenta</a>
                        @endauth

                        <p class="text-muted-co mt-3 mb-0" style="font-size: .75rem;">Procesamos tus datos personales de acuerdo con nuestra <a href="#" class="text-decoration-underline">Política de privacidad</a> y los <a href="#" class="text-decoration-underline">Términos de uso</a>.</p>
                    </div>
                </aside>

                <!-- contenido de la petición -->
                <div class="col-lg-8 order-lg-1">
                    <!-- datos de la petición -->
                    <div class="stats-box mt-lg-4 mb-5">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <div class="small text-muted-co">Dirigida a</div>
                                <div class="fw-bold">{{ $peticion->destinatario }}</div>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                                <div class="small text-muted-co">Tema</div>
                                <div class="fw-bold">{{ $peticion->categoria?->nombre }}</div>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                                <div class="small text-muted-co">Estado</div>
                                @if ($peticion->estado == 'aceptada')
                                    <span class="badge text-bg-success">¡Victoria!</span>
                                @else
                                    <span class="badge badge-dark-co">En curso</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- El problema -->
                    <article class="story">
                        <h2>El problema</h2>
                        <p style="white-space: pre-line">{{ $peticion->descripcion }}</p>
                        <a href="#" class="small text-muted-co text-decoration-underline"><i class="bi bi-flag me-1"></i>Denunciar una infracción de las normas</a>
                    </article>

                    <!-- Creador/a (sin foto: solo el nombre) -->
                    <div class="creator d-flex gap-3 align-items-center mt-4">
                        <span class="milestone-icon"><i class="bi bi-person"></i></span>
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $peticion->user?->name ?? 'Anónimo' }}</div>
                            <div class="small text-muted-co">Creador/a de la petición</div>
                        </div>
                    </div>

                    <!-- compartir -->
                    <section class="mt-5">
                        <h2 class="section-title mb-3">Compartir esta petición</h2>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn btn-outline-co btn-sm"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
                            <a href="#" class="btn btn-outline-co btn-sm"><i class="bi bi-facebook me-1"></i> Facebook</a>
                            <a href="#" class="btn btn-outline-co btn-sm"><i class="bi bi-twitter-x me-1"></i> X</a>
                            <a href="#" class="btn btn-outline-co btn-sm"><i class="bi bi-envelope me-1"></i> Email</a>
                            <a href="#" class="btn btn-outline-co btn-sm"><i class="bi bi-link-45deg me-1"></i> Copiar enlace</a>
                        </div>
                    </section>

                    <hr class="my-4">
                    <p class="small">Petición creada el {{ $peticion->created_at?->format('d/m/Y') }}</p>
                    <nav>
                        <ol class="breadcrumb small mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-underline">Change.org</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('peticiones.index') }}" class="text-decoration-underline">Tema</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('peticiones.index', ['categoria' => $peticion->categoria_id]) }}" class="text-decoration-underline">{{ $peticion->categoria?->nombre }}</a></li>
                        </ol>
                    </nav>
                    <p class="small mb-5">{{ $peticion->titulo }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
