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
        return view('pago_proovedores');
    }

    public function datos(Request $request)
    {

        
        $movimientos = DB::table('proovedores')
            ->join('productos', 'proovedores.id', '=', 'productos.id_proovedor')
            ->join('ventas', 'productos.id', '=', 'ventas.id_producto')
            ->join('cuotas', 'ventas.id', '=', 'cuotas.id_venta')
            ->join('movimientos', 'cuotas.id', '=', 'movimientos.id_cuota')
            ->where('movimientos.salida', '=', '0')
            ->where('movimientos.entrada', '>', '0')
            ->groupBy('proovedores.id')
            ->select('proovedores.nombre AS proovedor', 'proovedores.id AS id_proovedor', DB::raw('SUM(movimientos.entrada) - (SUM(movimientos.entrada) * (productos.ganancia + productos.gastos_administrativos) / 100) AS pagar'))->get();
            
	    return $movimientos->toJson();
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

    public function pagarCuotas(Request $request)
    {
        foreach($request['proovedores'] as $id)
        {
            $mapper = new VentasMapper();
            $ventas = $mapper->cuotasAPagarProovedor($id);
            $ventas->each(function ($venta) {
               $v = new Ventas($venta);
               $porcentaje = $venta->producto->porcentaje + $venta->producto->gastos_administrativos;
               $v->pagarProovedor($porcentaje);
            });
        }
    }


}
