<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Indicadores;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;


class IndicadoresController extends Controller
{
    
// Solicitud a la API de autenticación recuperando un token de acceso.
    public function token_generator()
    {
        $response = Http::post('https://postulaciones.solutoria.cl/api/acceso', [
            'userName' => 'diego.leal94@outlook.com',
            'flagJson' => true
        ]);
        $data = json_decode($response->getBody());
        $token = $data->token;
        return $token;
    }

    
// Obtiene valor actualizado de indicador desde la API retornando el valor en un array.
    public function extract_uf()
    {
        $token = $this->token_generator();
        $response = Http::withtoken($token)
        ->get('https://postulaciones.solutoria.cl/api/indicadores');
        $collection = collect($response->json());
        $uf_filter = $collection->whereIn('codigoIndicador', 'UF');
        return $uf_filter->all();
    }

    
/* Actualiza la BD eliminando registros existentes y agregando nuevos registros para 
cada elemento en la tabla.*/
    public function fill_DB()
    {
        Indicadores::truncate();
        $data = $this->extract_uf();
        foreach($data as $data)
        {
            Indicadores::create($data);
        }
        Session::put('success', 'Base de datos actualizada con éxito.');
        return view('home');
    }


    
// Muestra los datos de la tabla utilizando Datatables, permite editar y eliminar registros.
   public function index(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Indicadores::get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editIndicadores"> Editar </a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deleteIndicadores"> Eliminar </a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('IndicadoresAjax');
    }
       

// Almacena un nuevo indicador en la base de datos o actualiza uno existente.
    public function store(Request $request)
    {
        Indicadores::updateOrCreate([
                    'id' => $request->Indicadores_id
                ],
                [
                    'nombreIndicador' => $request->NombreIndicador, 
                    'codigoIndicador' => $request->CodigoIndicador,
                    'unidadMedidaIndicador' => $request->UnidadMedidaIndicador,
                    'valorIndicador' => $request->ValorIndicador,
                    'fechaIndicador' => $request->FechaIndicador,
                    'tiempoIndicador' => $request->TiempoIndicador,
                    'origenIndicador' => $request->OrigenIndicador
                ]);        
     
        return response()->json(['success'=>'Indicador Guardado Exitosamente.']);
    }


// Devuelve los detalles del registro de la tabla cuyo ID es proporcionado como parámetro.
    public function edit($id)
    {
        $Indicadores = Indicadores::find($id);
        return response()->json($Indicadores);
    }
    
// Encuentra el registro con el ID proporcionado y lo elimina de la BD.
    public function destroy($id)
    {
        Indicadores::find($id)->delete();
      
        return response()->json(['success'=>'Indicador Eliminado Existosamente.']);
    }
}
