<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';
    protected $fillable = ['nombre', 'id_grupo', 'puntos', 'PJ', 'PG', 'PE', 'PP', 'GF', 'DG'];

    public function jugadores()
    {
        return $this->hasMany(Jugador::class, 'id_equipo');
    }

    public function grupos()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }
}
