@extends('layouts.public')

@section('title', $titulo ?? 'Peticiones')

@section('content')
    <div class="container">
        {{-- Un solo formulario GET para el buscador y los filtros. Se usa también en Mis peticiones y Mis firmas --}}
        <form action="{{ url()->current() }}" method="GET">
            <!-- buscador -->
            <div class="search-bar d-flex gap-2 py-4 py-md-5">
                <div class="input-icon">
                    <i class="bi bi-search"></i>
                    <label for="q" class="visually-hidden">Buscar peticiones</label>
                    <input type="search" id="q" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar peticiones">
                </div>
                <button class="btn btn-yellow px-4" type="submit">Buscar</button>
            </div>

            @if (session('ok'))
                <div class="alert alert-success"><i class="bi bi-check-circle-fill me-1"></i> {{ session('ok') }}</div>
            @endif

            <!-- cabecera de resultados -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <h1 class="h4 fw-normal mb-0">
                    <strong>{{ $titulo ?? 'Peticiones' }}</strong> · {{ $peticiones->count() }} {{ $peticiones->count() == 1 ? 'resultado' : 'resultados' }}
                </h1>
                <button class="btn btn-outline-co btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtros">
                    <i class="bi bi-sliders me-1"></i> Filtros
                </button>
            </div>

            <div class="row g-4 g-lg-5">
                <!-- filtros (barra lateral en escritorio, offcanvas en móvil) -->
                <aside class="col-lg-4 col-xl-3">
                    <div class="offcanvas-lg offcanvas-start filters" tabindex="-1" id="filtros">
                        <div class="offcanvas-header border-bottom">
                            <h2 class="offcanvas-title h5 mb-0">Filtros</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filtros"></button>
                        </div>
                        <div class="offcanvas-body flex-column">
                            <section class="mb-4">
                                <h2>Estado</h2>
                                @foreach (['' => 'Todas las peticiones', 'aceptada' => 'Solo victorias', 'pendiente' => 'Pendientes'] as $valor => $texto)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="estado" id="e-{{ $valor ?: 'todas' }}" value="{{ $valor }}"
                                               @checked(request('estado', '') == $valor) onchange="this.form.submit()">
                                        <label class="form-check-label small" for="e-{{ $valor ?: 'todas' }}">{{ $texto }}</label>
                                    </div>
                                @endforeach
                            </section>

                            <section class="mb-4">
                                <h2>Temas</h2>
                                <div class="chips">
                                    <input type="radio" class="btn-check" name="categoria" id="cat-todas" value=""
                                           @checked(!request('categoria')) onchange="this.form.submit()">
                                    <label class="chip" for="cat-todas">Todos</label>
                                    @foreach ($categorias as $categoria)
                                        <input type="radio" class="btn-check" name="categoria" id="cat-{{ $categoria->id }}" value="{{ $categoria->id }}"
                                               @checked(request('categoria') == $categoria->id) onchange="this.form.submit()">
                                        <label class="chip" for="cat-{{ $categoria->id }}">{{ $categoria->nombre }}</label>
                                    @endforeach
                                </div>
                            </section>

                            <a href="{{ url()->current() }}" class="link-underline-co ms-2">Borrar filtros</a>
                        </div>
                    </div>
                </aside>

                <!-- resultados -->
                <div class="col-lg-8 col-xl-9">
                    @forelse ($peticiones as $peticion)
                        <a href="{{ route('peticiones.show', $peticion->id) }}" class="result">
                            <div class="flex-grow-1">
                                <h2>{{ $peticion->titulo }}</h2>
                                <p class="excerpt">{{ Str::limit($peticion->descripcion, 180) }}</p>
                                <p class="meta mb-0">
                                    <span class="firmas"><i class="bi bi-pen"></i> {{ number_format($peticion->firmantes, 0, ',', '.') }} {{ $peticion->firmantes == 1 ? 'firma' : 'firmas' }}</span>
                                    <span class="ms-3">{{ $peticion->categoria?->nombre }}</span>
                                    @if ($peticion->estado == 'aceptada')
                                        · <span class="text-success fw-bold">¡Victoria!</span>
                                    @endif
                                    · Creada el {{ $peticion->created_at?->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="thumb"><img src="{{ $peticion->imagen_url }}" alt=""><span class="arrow"><i class="bi bi-arrow-right"></i></span></div>
                        </a>
                    @empty
                        <div class="text-center py-5">
                            <img src="{{ asset('img/ilustracion-megafono.svg') }}" alt="" style="width: 140px" class="mb-3">
                            <p class="fs-5 mb-3">No hay peticiones que mostrar.</p>
                            <a href="{{ route('peticiones.create') }}" class="btn btn-yellow px-4">Inicia una petición</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </form>
    </div>
@endsection
