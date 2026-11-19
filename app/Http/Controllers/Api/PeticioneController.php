<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peticione;
use Illuminate\Http\Request;

class PeticioneController extends Controller
{
    // GET /api/peticiones
    public function index()
    {
        $peticiones = Peticione::with('categoria', 'user')->get();

        return response()->json($peticiones);
    }

    // GET /api/peticiones/{id}
    public function show($id)
    {
        $peticion = Peticione::with('categoria', 'user', 'files')->findOrFail($id);

        return response()->json($peticion);
    }

    // POST /api/peticiones
    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'destinatario' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $peticion = new Peticione($datos);
        $peticion->categoria_id = $datos['categoria_id'];
        $peticion->user_id = $request->user()->id;
        $peticion->firmantes = 0;
        $peticion->estado = 'pendiente';
        $peticion->save();

        return response()->json($peticion->load('categoria'), 201);
    }

    // PUT /api/peticiones/{id}
    public function update(Request $request, $id)
    {
        $peticion = Peticione::findOrFail($id);

        if ($peticion->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No puedes editar una petición que no es tuya'], 403);
        }

        $datos = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'destinatario' => 'sometimes|required|string',
            'categoria_id' => 'sometimes|required|exists:categorias,id',
        ]);

        $peticion->fill($datos);
        if (isset($datos['categoria_id'])) {
            $peticion->categoria_id = $datos['categoria_id'];
        }
        $peticion->save();

        return response()->json($peticion->load('categoria'));
    }

    // DELETE /api/peticiones/{id}
    public function delete(Request $request, $id)
    {
        $peticion = Peticione::findOrFail($id);

        if ($peticion->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No puedes borrar una petición que no es tuya'], 403);
        }

        $peticion->firmas()->detach();
        $peticion->delete();

        return response()->json(['message' => 'Petición eliminada']);
    }

    // POST /api/peticiones/firmar/{id}
    public function firmar(Request $request, $id)
    {
        $peticion = Peticione::findOrFail($id);
        $user = $request->user();

        if ($peticion->firmas()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Ya has firmado esta petición'], 409);
        }

        $peticion->firmas()->attach($user->id);
        $peticion->firmantes = $peticion->firmantes + 1;
        $peticion->save();

        return response()->json(['message' => 'Petición firmada', 'peticion' => $peticion]);
    }

    // GET /api/mispeticiones
    public function listMine(Request $request)
    {
        $peticiones = Peticione::with('categoria')
            ->where('user_id', $request->user()->id)
            ->get();

        return response()->json($peticiones);
    }

    // GET /api/peticionesfirmadas
    public function peticionesFirmadas(Request $request)
    {
        $peticiones = $request->user()->firmas()->with('categoria')->get();

        return response()->json($peticiones);
    }
}
