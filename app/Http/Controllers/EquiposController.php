<?php

namespace App\Http\Controllers;

use App\Http\Requests\Equipos\CreateEquiposRequest;
use App\Http\Requests\Equipos\IndexEquiposRequest;
use App\Models\Equipo;
use App\Models\Grupo;
use Illuminate\Http\Request;

class EquiposController extends Controller
{
    public function index(IndexEquiposRequest $request)
    {
        $validated = $request->validated();
        $query = Equipo::query();

        if (isset($validated['nombre'])) {
            $query->where('nombre', 'like', '%' . $validated['nombre'] . '%');
        }

        if (isset($validated['grupo'])) {
            $id_grupo = Grupo::where('numero', $validated['grupo'])->value('id');
            if ($id_grupo) {
                $query->where('id_grupo', $id_grupo);
            }
            else {
                return response()->json(['message' => 'Grupo no encontrado'], 404);
            }
        }

        if (isset($validated['puntero'])) {
            $query->orderBy('puntos', 'desc');
        }

        $equipos = $query->paginate($validated['cantidad'], ['*'], 'page', $validated['pagina']);

        return response()->json([
            'data' => $equipos->items(),
            'current_page' => $equipos->currentPage(),
            'total_pages' => $equipos->lastPage(),
            'total_registros' => $equipos->total(),
        ], 200);
    }

    public function create(CreateEquiposRequest $request)
    {
        $validated = $request->validated();
        $equipo = Equipo::create($validated);
        return response()->json($equipo, 201);
    }

    public function update(CreateEquiposRequest $request, $id)
    {
        $validated = $request->validated();
        $equipo = Equipo::findOrFail($id);
        $equipo->update($validated);
        return response()->json($equipo, 200);
    }

    public function delete($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();
        return response()->json(null, 204);
    }

    public function show($id)
    {
        $equipo = Equipo::findOrFail($id);
        return response()->json($equipo, 200);
    }
}
