<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Participante extends Model
{
    protected $table = "participante";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'nombre_participante',
        'telefono',
        'correo_electronico',
        'ponente'
    ];
}
