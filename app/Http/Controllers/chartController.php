<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicadores;


class chartController extends Controller
{

    
// Obtener datos de indicadores y ordenarlos por fecha
    
    public function get_data(){
        $table = Indicadores::orderBy('fechaIndicador')->get();
        $fecha = $table->pluck('fechaIndicador');
        $valor = $table->pluck('valorIndicador');
        return view('chart', compact('fecha', 'valor'));
    }
}
