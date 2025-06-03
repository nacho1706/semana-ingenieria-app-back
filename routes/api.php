<?php

use App\Http\Controllers\EquiposController;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\JugadoresController;
use App\Http\Controllers\PartidosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('partidos')->group(function () {
    Route::post('create', [PartidosController::class, 'create']);
    Route::get('index', [PartidosController::class, 'index']);
    Route::put('update/{id}', [PartidosController::class, 'update']);
    Route::delete('delete/{id}', [PartidosController::class, 'delete']);
});

Route::prefix('jugadores')->group(function () {
    Route::post('create', [JugadoresController::class, 'create']);
    Route::get('index', [JugadoresController::class, 'index']);
    Route::put('update/{id}', [JugadoresController::class, 'update']);
    Route::delete('delete/{id}', [JugadoresController::class, 'delete']);
});

Route::prefix('equipos')->group(function () {
    Route::post('create', [EquiposController::class, 'create']);
    Route::get('index', [EquiposController::class, 'index']);
    Route::put('update/{id}', [EquiposController::class, 'update']);
    // Route::delete('delete/{id}', [EquiposController::class, 'delete']);
    Route::get('show/{id}', [EquiposController::class, 'show']);
    Route::get('actualizarPuntos', [EquiposController::class, 'actualizarPuntos']);
});

Route::prefix('grupos')->group(function () {
    Route::post('create', [GruposController::class, 'create']);
    Route::get('index', [GruposController::class, 'index']);
    // Route::put('update/{id}', [GruposController::class, 'update']);
    // Route::delete('delete/{id}', [GruposController::class, 'delete']);
});

