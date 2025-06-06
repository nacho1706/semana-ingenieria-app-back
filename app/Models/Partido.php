<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $table = 'partidos';
    protected $fillable = ['equipos', 'fecha', 'cancha', 'resultado', 'estado', 'points_processed'];
    protected $casts = [
        'fecha' => 'datetime',
        'equipos' => 'array',
    ];

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id', 'equipos');
    }
}
