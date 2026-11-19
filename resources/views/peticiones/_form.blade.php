{{-- Campos compartidos por crear y editar (diseño de crear.html). Necesita $categorias y opcionalmente $peticion --}}
@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- 1. Título -->
<section class="create-step">
    <span class="step-label">Paso 1 de 5</span>
    <h2>Escribe el título de tu petición</h2>
    <p class="lead-co">Es lo primero que verá la gente. Hazlo breve y concreto.</p>
    <label for="titulo" class="form-label">Título</label>
    <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" maxlength="255"
           placeholder="Ej.: Paso de peatones seguro frente al colegio"
           value="{{ old('titulo', $peticion->titulo ?? request('titulo')) }}" required>
    @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    <div class="text-end small text-muted-co mt-1"><span id="titulo-count">0</span>/255</div>
    <div class="tip mt-2"><i class="bi bi-lightbulb me-1 text-blue"></i> Los títulos que empiezan con un verbo de acción («Protejamos», «Instalad», «Recuperemos») consiguen más firmas.</div>
</section>

<!-- 2. Tema -->
<section class="create-step">
    <span class="step-label">Paso 2 de 5</span>
    <h2>¿Sobre qué tema?</h2>
    <p class="lead-co">Así se la mostraremos a las personas a las que más les importa.</p>
    <div class="d-flex flex-wrap gap-2">
        @foreach ($categorias as $categoria)
            <input type="radio" class="btn-check" name="categoria" id="cat-{{ $categoria->id }}" value="{{ $categoria->id }}"
                   @checked(old('categoria', $peticion->categoria_id ?? '') == $categoria->id) required>
            <label class="chip chip-lg" for="cat-{{ $categoria->id }}">{{ $categoria->nombre }}</label>
        @endforeach
    </div>
    @error('categoria') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
</section>

<!-- 3. Destinatario -->
<section class="create-step">
    <span class="step-label">Paso 3 de 5</span>
    <h2>¿Quién puede hacer realidad el cambio?</h2>
    <p class="lead-co">Dirige la petición a la persona u organización con capacidad de decisión.</p>
    <label for="destinatario" class="form-label">Destinatario</label>
    <input type="text" class="form-control @error('destinatario') is-invalid @enderror" id="destinatario" name="destinatario"
           placeholder="Ej.: Ayuntamiento de Sevilla"
           value="{{ old('destinatario', $peticion->destinatario ?? '') }}" required>
    @error('destinatario') <div class="invalid-feedback">{{ $message }}</div> @enderror
</section>

<!-- 4. Historia -->
<section class="create-step">
    <span class="step-label">Paso 4 de 5</span>
    <h2>Cuenta tu historia</h2>
    <p class="lead-co">Explica el problema, por qué te afecta y qué solución propones.</p>
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="8"
              placeholder="Cada mañana cientos de niños cruzan una avenida con mucho tráfico para llegar al colegio..." required>{{ old('descripcion', $peticion->descripcion ?? '') }}</textarea>
    @error('descripcion') <div class="invalid-feedback">{{ $message }}</div> @enderror
</section>

<!-- 5. Imagen -->
<section class="create-step">
    <span class="step-label">Paso 5 de 5</span>
    <h2>Añade una imagen</h2>
    <p class="lead-co">Las peticiones con foto consiguen muchas más firmas. Es opcional.</p>
    <label for="file" class="upload-zone">
        <i class="bi bi-image d-block mb-2"></i>
        <span class="fw-bold">Sube una foto</span><br>
        <span class="small text-muted-co">JPG o PNG · horizontal · máximo 4 MB</span><br>
        <span id="file-name" class="small text-blue fw-bold"></span>
    </label>
    <input type="file" id="file" name="file" class="visually-hidden" accept="image/*">
    @error('file') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
</section>
