<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimientos;
use App\Cuotas;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Proovedores;
use App\Productos;
use App\Socios;

class CobrarController extends Controller
{
    public function index()
    {
        return view('cobrar');
    }

    public function datos(Request $request)
    {
        $movimientos = DB::table('movimientos')
            ->join('cuotas', 'cuotas.id_movimiento', '=', 'movimientos.id')
            ->join('socios', 'movimientos.id_asociado', '=', 'socios.id')
            ->join('productos', 'movimientos.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->where('cuotas.cobro', '=', '0')
            ->where('cuotas.pago', '=', '0')
            ->select('movimientos.*', 'socios.nombre AS socio', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'cuotas.importe', 'cuotas.nro_cuota', 'cuotas.pago', 'cuotas.fecha_pago', 'organismos.nombre AS organismo', 'organismos.id AS id_organismo', 'cuotas.id AS id_cuota');
            
	    return  $tabla =  Datatables::of($movimientos)
	           ->filter(function ($query) use ($request){
	                
	                $this->filtros($request,$query);
	            
	            })
        		->make(true);
    }

    public function traerDatosAutocomplete(Request $request)
    {
        $movimientos = DB::table('cuotas')
            ->join('movimientos', 'cuotas.id_movimiento', '=', 'movimientos.id')
            ->join('socios', function($join){
                $join->on('movimientos.id_asociado', '=', 'socios.id')->groupBy('socios.id');

            })
            ->join('productos', function($join){
                $join->on('movimientos.id_producto', '=', 'productos.id')->groupBy('productos.id');
            })
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->whereExists(function ($query) use ($request){
                $this->filtros($request,$query);
               
            })
            ->where('cuotas.cobro', '=', '0')
            ->where('cuotas.pago', '=', '0')
            ->select('movimientos.*', 'socios.nombre AS socio', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'cuotas.importe', 'cuotas.nro_cuota', 'cuotas.pago', 'cuotas.fecha_pago', 'proovedores.id AS id_proovedor', 'organismos.nombre AS organismo', 'organismos.id AS id_organismo')
     
            ->get();

            $mov = $movimientos->unique($request['groupBy']);
            if(sizeof($movimientos) == 0)
            {
                
                dd($this->filtrosNoNulos($request));
            }else {
        return ['movimientos' => $mov->values()->all(), 'pin' => $this->filtrosNoNulos($request)];
                
            }
    }

    public function cobrarCuotas(Request $request)
    {
    	foreach($request['cuotas'] as $id_cuota)
    	{
    		$cuota = Cuotas::find($id_cuota);
    		$cuota->cobro = 1;
    		$cuota->save();
    	}
    	// esto luego deberia afectar a la contabilidad
    	
    }
    // me tengo que quedar con los que no estan vacios
    // tengo que filtrar por lo que corresponde  {campo: 'proovedores.nombre', valor:'valor', operador:'='}
    public function filtros($objeto, $query)
    {
        $objetoNuevo = $this->filtrosNoNulos($objeto);
        foreach($objetoNuevo as $obj)
        {
            $query->where($obj['campo'], $obj['operador'], $obj['valor']);
        }
    }

    public function filtrosNoNulos($objeto)
    {
        $array = [];
        foreach($objeto['filtros'] as $obj)
        {
            if(!empty($obj['valor']))
            {
                array_push($array, $obj);
            }
        }

        return $array;
    }
}
