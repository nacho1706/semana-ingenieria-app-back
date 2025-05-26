<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $fillable = [
        'numero',
        'equipos'
    ];
    protected $casts = [
        'equipos' => 'array',
    ];

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id', 'equipos');
    }
}
