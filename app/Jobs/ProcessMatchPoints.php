<?php
namespace App\Jobs;

use App\Models\Equipo;
use App\Models\Partido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class ProcessMatchPoints implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function handle()
    {
        // Sólo partidos jugados y no procesados
        $partidos = Partido::where('estado', 'JUGADO')
                           ->where('points_processed', false)
                           ->get();

        foreach ($partidos as $partido) {
            DB::transaction(function() use ($partido) {
                // IDs de los equipos en el orden [equipo1, equipo2]
                $equiposIds = $partido->equipos;           // ej. [1, 3]
                $resultado   = $partido->resultado;        // ej. "1-0"

                // Parsear goles a enteros
                [$goles1, $goles2] = array_map('intval', explode('-', $resultado));

                // Cargar modelos de Equipo
                $equipo1 = Equipo::findOrFail($equiposIds[0]);
                $equipo2 = Equipo::findOrFail($equiposIds[1]);

                // Calcular puntos según resultado
                if ($goles1 > $goles2) {
                    $p1 = 3; $p2 = 0;
                    $equipo1->increment('PG');
                    $equipo2->increment('PP');
                } elseif ($goles1 < $goles2) {
                    $p1 = 0; $p2 = 3;
                    $equipo2->increment('PG');
                    $equipo1->increment('PP');
                } else {
                    $p1 = 1; $p2 = 1;
                    $equipo1->increment('PE');
                    $equipo2->increment('PE');
                }

                // Incrementar puntos en la tabla equipos
                $equipo1->increment('puntos', $p1);
                $equipo2->increment('puntos', $p2);

                $equipo1->increment('GF', $goles1);
                $equipo2->increment('GF', $goles2);

                $equipo1->increment('GC', $goles2);
                $equipo2->increment('GC', $goles1);
                
                $equipo1->increment('DG', $goles1 - $goles2);
                $equipo2->increment('DG', $goles2 - $goles1);

                $equipo1->increment('PJ');
                $equipo2->increment('PJ');


                // Marcar partido como procesado
                $partido->update(['points_processed' => true]);
            });
        }
    }
}
