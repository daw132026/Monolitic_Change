<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Peticione;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeticioneController extends Controller
{
    /**
     * Usuario logueado (las rutas que lo usan llevan el middleware 'auth').
     */
    private function usuario()
    {
        return Auth::user();
    }

    public function index(Request $request)
    {
        return $this->listado($request, Peticione::query(), 'Peticiones');
    }

    public function listMine(Request $request)
    {
        $query = Peticione::where('user_id', $this->usuario()->id);

        return $this->listado($request, $query, 'Mis peticiones');

        /*
         * try {
         *  $user = Auth::user();
         *  $petitions = Peticione::where('user_id', $user->id)->paginate(5);
         * } catch (\Exception $exception){
         *  return back()-> withError($exception->getMessage())->withInput();
         * }
         * return view('peticione.index', compact)*/
    }

    public function peticionesFirmadas(Request $request)
    {
        return $this->listado($request, $this->usuario()->firmas(), 'Peticiones firmadas');
    }

    /**
     * Aplica los filtros del buscador (texto, tema y estado) y pinta la vista index.
     * Lo usan index, mis peticiones y mis firmas.
     */
    private function listado(Request $request, $query, string $titulo)
    {
        if ($request->filled('q')) {
            $texto = '%' . $request->input('q') . '%';
            $query->where(function ($q) use ($texto) {
                $q->where('titulo', 'like', $texto)->orWhere('descripcion', 'like', $texto);
            });
        }
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->input('categoria'));
        }
        if (in_array($request->input('estado'), ['aceptada', 'pendiente'])) {
            $query->where('estado', $request->input('estado'));
        }

        $peticiones = $query->with('categoria', 'files')->latest('peticiones.created_at')->get();
        $categorias = Categoria::all();

        return view('peticiones.index', compact('peticiones', 'titulo', 'categorias'));
    }

    public function show($id)
    {
        $peticion = Peticione::with('categoria', 'user', 'files')->findOrFail($id);

        return view('peticiones.show', compact('peticion'));
    }

    public function create()
    {
        $categorias = Categoria::all();

        return view('peticiones.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'destinatario' => 'required',
            'categoria' => 'required|exists:categorias,id',
            'file' => 'nullable|image|max:4096',
        ]);

        $user = $this->usuario();
        if (! $user) {
            return back()->withInput()->withErrors(['titulo' => 'No hay ningún usuario. Ejecuta php artisan db:seed']);
        }

        $peticion = new Peticione($request->only('titulo', 'descripcion', 'destinatario'));
        $peticion->categoria_id = $request->input('categoria');
        $peticion->user_id = $user->id;
        $peticion->firmantes = 0;
        $peticion->estado = 'pendiente';
        $peticion->save();

        if ($request->hasFile('file')) {
            $this->guardarImagen($request, $peticion);
        }

        return redirect()->route('peticiones.show', $peticion->id)->with('ok', 'Petición creada');
    }

    public function edit($id)
    {
        $peticion = Peticione::findOrFail($id);
        abort_if($peticion->user_id != Auth::id(), 403, "Solo el creador puede editar esta petición");
        $categorias = Categoria::all();

        return view('peticiones.edit', compact('peticion', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $peticion = Peticione::findOrFail($id);
        abort_if($peticion->user_id != Auth::id(), 403, "Solo el creador puede editar esta petición");

        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'destinatario' => 'required',
            'categoria' => 'required|exists:categorias,id',
            'file' => 'nullable|image|max:4096',
        ]);

        $peticion->fill($request->only('titulo', 'descripcion', 'destinatario'));
        $peticion->categoria_id = $request->input('categoria');
        $peticion->save();

        if ($request->hasFile('file')) {
            $this->guardarImagen($request, $peticion);
        }

        return redirect()->route('peticiones.show', $peticion->id)->with('ok', 'Petición actualizada');
    }

    public function delete($id)
    {
        $peticion = Peticione::findOrFail($id);
        abort_if($peticion->user_id != Auth::id(), 403, "Solo el creador puede borrar esta petición");
        $peticion->firmas()->detach();
        $peticion->delete(); // los files se borran en cascada

        return redirect()->route('peticiones.index')->with('ok', 'Petición eliminada');
    }

    public function firmar($id)
    {
        $peticion = Peticione::findOrFail($id);
        $user = $this->usuario();

        if (! $user) {
            return back()->with('error', 'No hay ningún usuario para firmar');
        }

        if ($peticion->firmas()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Ya has firmado esta petición');
        }

        $peticion->firmas()->attach($user->id);
        $peticion->firmantes = $peticion->firmantes + 1;
        $peticion->save();

        return back()->with('ok', '¡Gracias por firmar!');
    }

    private function guardarImagen(Request $request, Peticione $peticion): void
    {
        $archivo = $request->file('file');
        $ruta = $archivo->store('peticiones', 'public');

        $peticion->files()->create([
            'name' => $archivo->getClientOriginalName(),
            'file_path' => $ruta,
        ]);
    }
}
