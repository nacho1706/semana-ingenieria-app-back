<?php

namespace App\Http\Controllers;

use App\Http\Requests\Partidos\CreatePartidosRequest;
use App\Http\Requests\Partidos\IndexPartidosRequest;
use App\Models\Grupo;
use App\Models\Partido;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PartidosController extends Controller
{
    public function index(IndexPartidosRequest $request)
    {
        $validated = $request->validated();
        $query = Partido::query();

        if (isset($validated['fecha'])) {
            $query->whereDate('fecha', $validated['fecha']);
        }

        if (isset($validated['grupo'])) {
            $query->where(function ($subQuery) use ($validated) {
                $grupo = Grupo::where('numero', $validated['grupo'])->first();
                if ($grupo && !empty($grupo->equipos)) {
                    $equipos = json_decode($grupo->equipos, true);
                    foreach ($equipos as $equipoId) {
                        $subQuery->orWhereJsonContains('equipos', $equipoId);
                    }
                }
            });
        }
        $partidos = $query->paginate($validated['cantidad'], ['*'], 'page', $validated['pagina']);

        return response()->json([
            'data' => $partidos->items(),
            'current_page' => $partidos->currentPage(),
            'total_pages' => $partidos->lastPage(),
            'total_registros' => $partidos->total(),
        ], 200);
    }

    public function create(CreatePartidosRequest $request)
    {
        $validated = $request->validated();

        $partido = Partido::create($validated);

        return response()->json([
            'message' => 'Partido creado exitosamente',
            'data' => $partido,
        ], 201);
    }

    public function update(CreatePartidosRequest $request, $id)
    {
        $validated = $request->validated();
        $partido = Partido::findOrFail($id);
        $partido->update($validated);

        return response()->json([
            'message' => 'Partido actualizado exitosamente',
            'data' => $partido,
        ], 200); {
        }
    }

    public function delete($id)
    {
        $partido = Partido::findOrFail($id);
        $partido->delete();

        return response()->json([
            'message' => 'Partido eliminado exitosamente',
        ], 204);
    }
}
