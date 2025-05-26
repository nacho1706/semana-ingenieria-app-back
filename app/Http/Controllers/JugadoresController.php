<?php

namespace App\Http\Controllers;

use App\Http\Requests\Jugadores\CreateJugadoresRequest;
use App\Http\Requests\Jugadores\IndexJugadoresRequest;
use App\Http\Requests\Jugadores\UpdateJugadoresRequest;
use App\Models\Jugador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JugadoresController extends Controller
{
    public function index(IndexJugadoresRequest $request)
    {
        $validated = $request->validated();
        $query = Jugador::query();

        if (isset($validated['id_equipo'])) {
            $query->where('id_equipo', $validated['id_equipo']);
        }

        if (isset($validated['goleador'])) {
            $query->orderBy('goles', 'desc');
        }

        if (isset($validated['equipo_goleador'])) {
            $equipoConMasGoles = DB::table('jugadores')
                ->select('equipos.nombre as nombre_equipo', DB::raw('SUM(jugadores.goles) as total_goles'))
                ->join('equipos', 'jugadores.id_equipo', '=', 'equipos.id')
                ->groupBy('equipos.id', 'equipos.nombre')
                ->orderByDesc('total_goles')
                ->first();
        }

        $jugadores = $query->paginate($validated['cantidad'], ['*'], 'page', $validated['pagina']);
        return response()->json([
            'data' => $jugadores->items(),
            'equipo_con_mas_goles' => isset($equipoConMasGoles) ? $equipoConMasGoles : null,
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
