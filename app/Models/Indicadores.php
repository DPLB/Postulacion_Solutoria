<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Indicadores extends Model
{
    use HasFactory;

    protected $dates=[
        'fechaIndicador'
    ];

    protected $fillable=[
        'nombreIndicador',
        'codigoIndicador',
        'unidadMedidaIndicador',
        'valorIndicador',
        'fechaIndicador',
        'tiempoIndicador',
        'origenIndicador'
    ];

    public $timestamps = false;
}
