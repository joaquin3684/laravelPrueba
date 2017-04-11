<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ventas;
use App\Cuotas;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use App\Proovedores;
use App\Productos;
use App\Socios;
use Carbon\Carbon;
use App\Prioridades;
use Debugbar;

class CobrarController extends Controller
{
    public function index()
    {
        
        return view('cobrar');

    }

    public function datos(Request $request)
    {
        $fechaHoy = Carbon::today();
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->groupBy('organismos.id')
            ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', DB::raw('SUM(cuotas.importe) - SUM(cuotas.cobro) AS importe'))
            ->where(function($query) use ($fechaHoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $fechaHoy)
                      ->orWhere(function($query2) use ($fechaHoy){
                            $query2->where('cuotas.fecha_vencimiento', '>=', $fechaHoy)
                                   ->where('cuotas.fecha_inicio', '<=', $fechaHoy);
                        });
            })
            ->whereColumn('cuotas.cobro', '<', 'cuotas.importe');
            
        return  $tabla =  Datatables::of($ventas)
           ->filter(function ($query) use ($request){
                
                $this->filtros($request,$query);
            
            })
        ->make(true);
    }

    public function mostrarPorSocio(Request $request)
    {
        $fechaHoy = Carbon::today();
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->groupBy('socios.id')
            ->select('socios.nombre AS socio', 'socios.id AS id_asociado', DB::raw('SUM(cuotas.importe) - SUM(cuotas.cobro) AS importe'))
            ->where(function($query) use ($fechaHoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $fechaHoy)
                      ->orWhere(function($query2) use ($fechaHoy){
                            $query2->where('cuotas.fecha_vencimiento', '>=', $fechaHoy)
                                   ->where('cuotas.fecha_inicio', '<=', $fechaHoy);
                        });
            })
            ->whereColumn('cuotas.cobro', '<', 'cuotas.importe')
            ->where('organismos.id', '=', $request['id']);
            
        return  $tabla =  Datatables::of($ventas)
           ->filter(function ($query) use ($request){
                
                $this->filtros($request,$query);
            
            })
        ->make(true);
    }
    public function cobrarPorPrioridad(Request $request)
    {
        $fechaHoy = Carbon::today();
        foreach($request->all() as $socio)
        {
            $cuotas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->join('prioridades', 'prioridades.id', '=', 'proovedores.id_prioridad')
            ->select('socios.nombre AS socio', 'cuotas.id AS id_cuota', 'prioridades.orden', 'socios.id AS id_asociado', 'cuotas.cobro', 'cuotas.importe', DB::raw('cuotas.importe - cuotas.cobro AS diferencia'))
            ->where(function($query) use ($fechaHoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $fechaHoy)
                      ->orWhere(function($query2) use ($fechaHoy){
                            $query2->where('cuotas.fecha_vencimiento', '>=', $fechaHoy)
                                   ->where('cuotas.fecha_inicio', '<=', $fechaHoy);
                        });
            })
            ->whereColumn('cuotas.cobro', '<', 'cuotas.importe')
            ->where('socios.id', '=', $socio['id_asociado'])->get();

            $cuotas = $cuotas->groupBy('orden');
         
            $plataDisponible = $socio['cobro'];
            $deudores = collect();
            $cuotas->each(function ($item, $key) use (&$plataDisponible, &$deudores) {
                $plataTotal = $plataDisponible / $item->count();
                $item->each(function ($item2, $key) use (&$plataTotal, &$plataDisponible, &$deudores){
                 
                    if($item2->diferencia <= $plataTotal)
                    {
                        $cuotaTotal = $item2->importe;
                        $plataDisponible -= ($item2->importe - $item2->cobro);

                    } else if($item2->diferencia > $plataTotal)
                    {
                        $cuotaTotal = $item2->cobro + $plataTotal;
                        $plataDisponible -= $plataTotal;
                        $deudores->push($item2);
                    }
                    $cuot = Cuotas::find($item2->id_cuota);
                    $cuot->cobro = $cuotaTotal;
                    $cuot->save();

                });
                $this->repasarDeudores($deudores, $plataDisponible);
            });

            if($plataDisponible > 0)
            {
                $cuotasTardias = DB::table('ventas')
                    ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
                    ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
                    ->join('productos', 'ventas.id_producto', '=', 'productos.id')
                    ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
                    ->join('proovedores', function($join){
                        $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
                    })
                    ->join('prioridades', 'prioridades.id', '=', 'proovedores.id_prioridad')
                    ->select('socios.nombre AS socio', 'cuotas.id AS id_cuota', 'prioridades.orden', 'socios.id AS id_asociado', 'cuotas.cobro', 'cuotas.importe', DB::raw('cuotas.importe - cuotas.cobro AS diferencia'))
                    ->where('cuotas.fecha_inicio', '>=', $fechaHoy)
                        
        
                    ->whereColumn('cuotas.cobro', '<', 'cuotas.importe')
                    ->where('socios.id', '=', $socio['id_asociado'])
                    ->orderBy('cuotas.fecha_inicio')->get();

                    $cuotasTardias = $cuotasTardias->groupBy('orden');
                $cuotasTardias->each(function ($item, $key) use (&$plataDisponible, &$deudores) {
                    $plataTotal = $plataDisponible / $item->count();
                    $item->each(function ($item2, $key) use (&$plataTotal, &$plataDisponible, &$deudores){
                     
                        if($item2->diferencia <= $plataTotal)
                        {
                            $cuotaTotal = $item2->importe;
                            $plataDisponible -= ($item2->importe - $item2->cobro);

                        } else if($item2->diferencia > $plataTotal)
                        {
                            $cuotaTotal = $item2->cobro + $plataTotal;
                            $plataDisponible -= $plataTotal;
                            $deudores->push($item2);
                        }
                        $cuot = Cuotas::find($item2->id_cuota);
                        $cuot->cobro = $cuotaTotal;
                        $cuot->save();

                    });
                    $this->repasarDeudores($deudores, $plataDisponible);
            });

            }

         
        }
        return $request->all();
    }

    public function repasarDeudores($deudores, &$plataDisponible)
    {
        if($deudores->count() > 0 && $plataDisponible > 0)
        {
            $deudores2 = collect();
            $plataTotal2 = $plataDisponible / $deudores->count();
                    $deudores->each(function ($item, $key) use (&$plataTotal2, &$plataDisponible, &$deudores2) {
                        $cuota = Cuotas::find($item->id_cuota);
                        $diferencia = $cuota->importe - $cuota->cobro;
                        if($diferencia <= $plataTotal2)
                        {
                            $cuotaTotal = $cuota->importe;
                            $plataDisponible -= ($cuota->importe - $cuota->cobro);
                        }
                        else if($diferencia > $plataTotal2)
                        {
                            $cuotaTotal = $cuota->cobro + $plataTotal2;
                            $plataDisponible -= $plataTotal2;
                            $deudores2->push($item);
                        }
                          $cuota->cobro = $cuotaTotal;
                          $cuota->save();
            });
        $this->repasarDeudores($deudores2, $plataDisponible);
        }

    }

    public function traerDatosAutocomplete(Request $request)
    {
        $ventas = DB::table('cuotas')
            ->join('ventas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', function($join){
                $join->on('ventas.id_asociado', '=', 'socios.id')->groupBy('socios.id');

            })
            ->join('productos', function($join){
                $join->on('ventas.id_producto', '=', 'productos.id')->groupBy('productos.id');
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
            ->select('ventas.*', 'socios.nombre AS socio', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'cuotas.importe', 'cuotas.nro_cuota', 'cuotas.pago', 'cuotas.fecha_pago', 'proovedores.id AS id_proovedor', 'organismos.nombre AS organismo', 'organismos.id AS id_organismo')
     
            ->get();

            $mov = $ventas->unique($request['groupBy']);
            if(sizeof($ventas) == 0)
            {
                
                dd($this->filtrosNoNulos($request));
            }else {
        return ['ventas' => $mov->values()->all(), 'pin' => $this->filtrosNoNulos($request)];
                
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

}
