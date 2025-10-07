<?php

use App\Http\Controllers\ControllerParticipante;
use App\Models\Participante;
use Illuminate\Support\Facades\Route;

Route::get('/', [ControllerParticipante::class, 'index'])->name('participantes.index');

Route::resource('/participantes', ControllerParticipante::class);