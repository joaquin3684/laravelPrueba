<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Mapper\VentasMapper;
use App\Repositories\Eloquent\Ventas;
use Illuminate\Http\Request;
use App\Movimientos;
use App\Cuotas;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Proovedores;
use App\Productos;
use App\Socios;

class PagoProovedoresController extends Controller
{
   public function index()
    {
        $this->pagarCuotas();
        return view('pago_proovedores');
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
            ->where('cuotas.cobro', '=', '1')
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
            ->where('cuotas.cobro', '=', '1')
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

    public function pagarCuotas()
    {
        //TODO: volver a poner el Parametro Request en la funcion
       /* foreach($request['cuotas'] as $id)
        {*/
            $mapper = new VentasMapper();
            $ventas = $mapper->cuotasAPagarProovedor(5);
            $ventas->each(function ($venta) {
               $v = new Ventas($venta);
               $porcentaje = $venta->producto->porcentaje + $venta->producto->gastos_administrativos;
               $v->pagarProovedor($porcentaje);
            });
        //}
    }


}
