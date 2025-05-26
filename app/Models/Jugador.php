<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    protected $table = 'jugadores';
    protected $fillable = ['nombre', 'id_equipo', 'goles'];
    
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }
    
}
