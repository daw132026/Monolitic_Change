@extends('layouts.public')

@section('title', 'Editar petición')

@section('content')
    <div class="container pb-4">
        <div class="create-wrap">

            <section class="create-intro">
                <img src="{{ asset('img/ilustracion-megafono.svg') }}" alt="" class="mb-4">
                <h1 class="mb-3">Editar petición</h1>
                <p class="mb-0">Cambia lo que necesites y guarda. Si subes una imagen nueva se añadirá a la petición.</p>
            </section>

            <form action="{{ route('peticiones.update', $peticion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('peticiones._form')

                <div class="d-flex justify-content-end gap-3 pt-2">
                    <a href="{{ route('peticiones.show', $peticion->id) }}" class="btn btn-outline-co px-4">Cancelar</a>
                    <button type="submit" class="btn btn-yellow px-4">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection
