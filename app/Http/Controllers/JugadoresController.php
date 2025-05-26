<?php

namespace App\Http\Controllers;

use App\Http\Requests\Jugadores\CreateJugadoresRequest;
use App\Http\Requests\Jugadores\IndexJugadoresRequest;
use App\Http\Requests\Jugadores\UpdateJugadoresRequest;
use App\Models\Jugador;
use Illuminate\Http\Request;

class JugadoresController extends Controller
{
    public function index(IndexJugadoresRequest $request)
    {
        $validated = $request->validated();
        $query = Jugador::query();

        if (isset($validated['id_equipo'])) {
            $query->where('id_equipo', $validated['id_equipo']);
        }

        if (isset($validated['goles'])) {
            $query->where('goles', $validated['goles']);
        }

        $jugadores = $query->paginate($validated['cantidad'], ['*'], 'page', $validated['pagina']);
        return response()->json([
            'data' => $jugadores->items(),
            'current_page' => $jugadores->currentPage(),
            'total_pages' => $jugadores->lastPage(),
            'total_registros' => $jugadores->total(),
        ], 200);
    }

    public function create(CreateJugadoresRequest $request)
    {
        $validated = $request->validated();
        if (isset($validated['jugadores'])) {
            $jugadores = [];
            foreach ($validated['jugadores'] as $jugadorData) {
                $jugadores[] = Jugador::create($jugadorData);
            }
            return response()->json($jugadores, 201);
        } else
            $jugador = Jugador::create($validated);
        return response()->json($jugador, 201);
    }

    public function update(UpdateJugadoresRequest $request, $id)
    {
        $validated = $request->validated();
        $jugador = Jugador::findOrFail($id);
        $jugador->update($validated);
        return response()->json($jugador, 200);
    }

    public function delete($id)
    {
        $jugador = Jugador::findOrFail($id);
        $jugador->delete();
        return response()->json($jugador, 204);
    }
}
