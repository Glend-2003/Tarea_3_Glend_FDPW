<?php

use App\Http\Controllers\ControllerParticipante;
use App\Models\Participante;
use Illuminate\Support\Facades\Route;

Route::get('/', [ControllerParticipante::class, 'index'])->name('participantes.index');

Route::resource('/participantes', ControllerParticipante::class);

// Agregar esta ruta si quieres acceder directamente a resultado
Route::get('/participantes/resultado', function() {
    return view('participantes.resultado');
})->name('participantes.resultado');
