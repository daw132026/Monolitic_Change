@extends('layouts.public')

@section('content')
    <!-- hero con degradado -->
    <div class="hero-gradient">
        <section class="hero" id="hero">
            <div class="container">
                <h1>El cambio<br>empieza contigo<span class="dot">.</span></h1>
                <p class="hero-sub mb-4">Te acompañamos para conseguir el cambio que quieres ver.</p>

                <p class="fw-bold mb-3">Iniciar una petición para...</p>
                {{-- Lo que se escriba aquí se pasa como título al formulario de crear --}}
                <form class="start-box" action="{{ route('peticiones.create') }}" method="GET">
                    <label for="idea" class="visually-hidden">¿Qué quieres cambiar?</label>
                    <textarea id="idea" name="titulo" class="form-control" rows="2" placeholder="Que el barrio tenga un centro de salud abierto también por las tardes"></textarea>
                    <button type="submit" class="btn btn-yellow btn-arrow" aria-label="Empezar"><i class="bi bi-arrow-right"></i></button>
                </form>
                <a href="{{ route('peticiones.create') }}" class="d-inline-block mt-3 small text-decoration-underline">Ya tengo el borrador de mi petición <i class="bi bi-arrow-right"></i></a>
            </div>
        </section>

        <!-- personas reales -->
        <section class="pb-4" id="personas">
            <div class="container">
                <h2 class="h5 fw-bold text-center mb-4">Personas reales que están mejorando sus comunidades.</h2>
                <div class="people-row">
                    <a href="{{ route('peticiones.index') }}" class="person">
                        <img src="{{ asset('img/peticion-1.jpg') }}" alt="Petición sobre el litoral">
                        <span class="pill"><span class="lbl">¡Tendencia!</span><br>164.210 firmas</span>
                    </a>
                    <a href="{{ route('peticiones.index') }}" class="person">
                        <img src="{{ asset('img/peticion-2.jpg') }}" alt="Petición sobre un parque">
                        <span class="pill"><span class="lbl">¡Victoria!</span><br>48.112 firmas</span>
                    </a>
                    <a href="{{ route('peticiones.index') }}" class="person">
                        <img src="{{ asset('img/peticion-8.jpg') }}" alt="Petición sobre colegios">
                        <span class="pill"><span class="lbl">¡Tendencia!</span><br>96.034 firmas</span>
                    </a>
                    <a href="{{ route('peticiones.index') }}" class="person">
                        <img src="{{ asset('img/peticion-4.jpg') }}" alt="Petición sobre un refugio">
                        <span class="pill"><span class="lbl">¡Victoria!</span><br>15.903 firmas</span>
                    </a>
                    <a href="{{ route('peticiones.index') }}" class="person">
                        <img src="{{ asset('img/peticion-10.jpg') }}" alt="Petición sobre un bosque">
                        <span class="pill"><span class="lbl">¡Tendencia!</span><br>22.580 firmas</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- cómo funciona: 3 pasos -->
        <section class="py-5" id="como-funciona">
            <div class="container">
                <h2 class="section-title text-center mb-5">Crear tu petición es muy fácil</h2>
                <div class="row g-4 steps">
                    <div class="col-md-4 step">
                        <span class="step-circle">1</span>
                        <h3>Crea una petición en pocos minutos</h3>
                        <p>Miles de peticiones nuevas cada semana</p>
                    </div>
                    <div class="col-md-4 step">
                        <span class="step-circle">2</span>
                        <h3>Reúne apoyos de toda la comunidad</h3>
                        <p>Cientos de miles de firmas al día</p>
                    </div>
                    <div class="col-md-4 step">
                        <span class="step-circle">3</span>
                        <h3>Haz llegar tu voz a quien decide</h3>
                        <p>Responsables notificados cada día</p>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button class="btn btn-outline-co tips-toggle mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#consejos">
                        Consulta nuestros consejos y guías para crear una petición <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="collapse" id="consejos">
                        <div class="row g-3 justify-content-center mt-2 text-start">
                            <div class="col-md-4"><div class="p-3 bg-white border rounded-3 h-100"><strong>Elige un buen título</strong><br><span class="small text-muted-co">Corto, concreto y que explique el cambio.</span></div></div>
                            <div class="col-md-4"><div class="p-3 bg-white border rounded-3 h-100"><strong>Cuenta tu historia</strong><br><span class="small text-muted-co">Explica por qué te afecta personalmente.</span></div></div>
                            <div class="col-md-4"><div class="p-3 bg-white border rounded-3 h-100"><strong>Compártela</strong><br><span class="small text-muted-co">Las primeras firmas llegan de tu entorno.</span></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- causas que te importan -->
    <section class="section" id="causas">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3 mb-3">
                <div>
                    <h2 class="section-title mb-1">Apoya las causas que te importan</h2>
                    <p class="mb-0">Encuentra peticiones que afectan a tu comunidad.</p>
                </div>
                <a href="{{ route('peticiones.index') }}" class="btn btn-outline-co align-self-start">Ver todos los temas</a>
            </div>

            <ul class="nav nav-pills nav-pills-co mb-4">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#c-medio" type="button">Medio ambiente</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#c-educacion" type="button">Educación</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#c-animales" type="button">Animales</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="c-medio">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                        <div class="col"><a href="{{ route('peticiones.index') }}" class="card cause-card"><img src="{{ asset('img/peticion-1.jpg') }}" alt=""><div class="card-body"><h3 class="card-title">Protejamos el litoral de la construcción masiva</h3><p class="small mb-0"><i class="bi bi-pen text-blue"></i> <span class="firmas">164.210 firmas</span></p></div></a></div>
                        <div class="col"><a href="{{ route('peticiones.index') }}" class="card cause-card"><img src="{{ asset('img/peticion-10.jpg') }}" alt=""><div class="card-body"><h3 class="card-title">Recuperar el bosque quemado de la sierra</h3><p class="small mb-0"><i class="bi bi-pen text-blue"></i> <span class="firmas">22.580 firmas</span></p></div></a></div>
                        <div class="col"><a href="{{ route('peticiones.index') }}" class="card cause-card"><img src="{{ asset('img/peticion-6.jpg') }}" alt=""><div class="card-body"><h3 class="card-title">Limpieza y vigilancia del río a su paso por el pueblo</h3><p class="small mb-0"><i class="bi bi-pen text-blue"></i> <span class="firmas">8.341 firmas</span></p></div></a></div>
                        <div class="col"><a href="{{ route('peticiones.index') }}" class="card cause-card"><img src="{{ asset('img/peticion-11.jpg') }}" alt=""><div class="card-body"><h3 class="card-title">Más frecuencia de autobús en las zonas rurales</h3><p class="small mb-0"><i class="bi bi-pen text-blue"></i> <span class="firmas">3.004 firmas</span></p></div></a></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="c-educacion">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                        <div class="col"><a href="{{ route('peticiones.index') }}" class="card cause-card"><img src="{{ asset('img/peticion-8.jpg') }}" alt=""><div class="card-body"><h3 class="card-title">Aulas climatizadas en todos los colegios públicos</h3><p class="small mb-0"><i class="bi bi-pen text-blue"></i> <span class="firmas">96.034 firmas</span></p></div></a></div>
                        <div class="col"><a href="{{ route('peticiones.index') }}" class="card cause-card"><img src="{{ asset('img/peticion-12.jpg') }}" alt=""><div class="card-body"><h3 class="card-title">Carril bici seguro hasta la universidad</h3><p class="small mb-0"><i class="bi bi-pen text-blue"></i> <span class="firmas">1.820 firmas</span></p></div></a></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="c-animales">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                        <div class="col"><a href="{{ route('peticiones.index') }}" class="card cause-card"><img src="{{ asset('img/peticion-4.jpg') }}" alt=""><div class="card-body"><h3 class="card-title">Financiación estable para el refugio comarcal</h3><p class="small mb-0"><i class="bi bi-pen text-blue"></i> <span class="firmas">15.903 firmas</span></p></div></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- impulsado por personas -->
    <section class="pb-5" id="impulsado">
        <div class="container">
            <div class="people-powered">
                <div class="row align-items-center g-4">
                    <div class="col-md-6">
                        <h2 class="mb-3">Movido por personas,<br>no por beneficios</h2>
                        <p class="mb-4">Una plataforma independiente, sostenida por las aportaciones de sus miembros en todo el mundo: sin anuncios ni intereses particulares.</p>
                        <a href="#" class="btn btn-outline-co px-3">Contribuir</a>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('img/ilustracion-comunidad.svg') }}" alt="" style="max-width: 320px; width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
