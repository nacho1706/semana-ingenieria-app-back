<?php

namespace App\Http\Controllers;

use App\Http\Requests\Grupos\CreateGruposRequest;
use App\Models\Equipo;
use App\Models\Grupo;
use Illuminate\Http\Request;

class GruposController extends Controller
{
    public function create(CreateGruposRequest $request)
    {
        $validated = $request->validated();
        
        if(Grupo::where('numero', $validated['numero'])->exists()) {
            return response()->json(['message' => 'El grupo ya existe'], 400);
        }

        $grupo = Grupo::create([
            'numero' => $validated['numero'],
            'equipos' => json_encode($validated['equipos']),
        ]);

        if($grupo){
            Equipo::whereIn('id', $validated['equipos'])->update(['id_grupo' => $grupo->id]);
        } else {
            return response()->json(['message' => 'Error al crear el grupo'], 500);
        }

        return response()->json(['message' => 'Grupo creado exitosamente', 'grupo' => $grupo], 201);
    }

    public function index(Request $request)
    {
        $query = Grupo::query();

        if ($request->has('numero')) {
            $query->where('numero', $request->input('numero'));
        }

        $grupos = $query->paginate($request->input('cantidad', 10), ['*'], 'page', $request->input('pagina', 1));

        return response()->json([
            'data' => $grupos->items(),
            'current_page' => $grupos->currentPage(),
            'total_pages' => $grupos->lastPage(),
            'total_registros' => $grupos->total(),
        ], 200);
    }
}
