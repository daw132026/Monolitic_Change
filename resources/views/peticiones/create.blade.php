@extends('layouts.public')

@section('title', 'Inicia una petición')

@section('content')
    <div class="container pb-4">
        <div class="create-wrap">

            <!-- introducción -->
            <section class="create-intro">
                <img src="{{ asset('img/ilustracion-megafono.svg') }}" alt="" class="mb-4">
                <h1 class="mb-3">Te ayudamos a crear una petición que se haga oír</h1>
                <p class="mb-0">Rellena los apartados de esta página y tendrás lista tu petición en pocos minutos. Podrás editarla después de publicarla.</p>
            </section>

            @if ($categorias->isEmpty())
                <div class="alert alert-warning">No hay categorías. Ejecuta <code>php artisan db:seed</code>.</div>
            @endif

            <form action="{{ route('peticiones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('peticiones._form')

                <div class="d-flex justify-content-end gap-3 pt-2">
                    <a href="{{ route('home') }}" class="btn btn-outline-co px-4">Volver</a>
                    <button type="submit" class="btn btn-yellow px-4">Publicar petición</button>
                </div>
            </form>
        </div>
    </div>
@endsection
