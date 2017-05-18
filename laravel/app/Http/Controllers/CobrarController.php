<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Mapper\CuotasMapper;
use App\Repositories\Eloquent\Mapper\VentasMapper;
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
use App\Movimientos;
use Debugbar;
use App\Repositories\Eloquent\ConsultasCuotas;
use App\Repositories\Eloquent\ConsultasMovimientos;
use App\Repositories\Eloquent\Filtros;
use App\Repositories\Eloquent\Tabla;
use App\Repositories\Eloquent\Ventas as RepoVentas;
use App\Repositories\Eloquent\Cobranza\CobrarPorVenta;


class CobrarController extends Controller
{
    private $cuotas;
    private $movimientos;
    private $filtros;
    private $tabla;
    private $cobrar;

    public function __construct(ConsultasCuotas $cuotas, Tabla $tabla, ConsultasMovimientos $movimientos, Filtros $filtros)
    {
        $this->cuotas = $cuotas;
        $this->movimientos = $movimientos;
        $this->filtros = $filtros;
        $this->tabla = $tabla;

    }

    public function index()
    {
        
        return view('cobrar');

    }
    public function datos(Request $request)
    {

        $cuotas = $this->cuotas->cuotasVencidasDeOrganismos();
        $movimientos = $this->movimientos->movimientosHastaHoyDeOrganismos();
        $cobrado = $this->unirColecciones($cuotas, $movimientos, ['id_organismo'], ['totalCobrado' => 0]);

        $cobrado = $cobrado->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $cobrado = $cobrado->filter(function ($item) {
            return $item['diferencia'] > 0;
        });

        return $this->tabla->generarTabla($request, $cobrado);

    }
    public function mostrarPorSocio(Request $request)
    {
        $cuotas = $this->cuotas->cuotasVencidasDeSociosDelOrganismo($request['id']);
        $movimientos = $this->movimientos->movimientosHastaHoyDeSociosDelOrganismo($request['id']);
        $cobrado = $this->unirColecciones($cuotas, $movimientos, ['id_socio'], ['totalCobrado' => 0]);

        $cobrado = $cobrado->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $cobrado = $cobrado->filter(function ($item) {
           return $item['diferencia'] > 0;
        });

        return $this->tabla->generarTabla($request, $cobrado);
    }
    public function mostrarPorVenta(Request $request)
    {
        $hoy = Carbon::today()->toDateString();
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->groupBy('ventas.id')
            ->where(function($query) use ($hoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $hoy)
                    ->orWhere(function($query2) use ($hoy){
                        $query2->where('cuotas.fecha_vencimiento', '>=', $hoy)
                            ->where('cuotas.fecha_inicio', '<=', $hoy);
                    });
            })
            ->where('socios.id', '=', $request['id'])
            ->select('socios.nombre AS socio', 'ventas.id AS id_venta', 'proovedores.nombre AS proovedor', DB::raw('SUM(cuotas.importe) AS totalACobrar'))->get();

        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('ventas.id')
            ->where('socios.id', '=', $request['id'])
            ->select('ventas.id AS id_venta', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))->get();

        $cobrado = $this->unirColecciones($ventas, $movimientos, ["id_venta"], ['totalCobrado' => 0]);

        $cobrado = $cobrado->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $cobrado = $cobrado->filter(function ($item) {
            return $item['diferencia'] > 0;
        });

        return $this->tabla->generarTabla($request, $cobrado);


    }
    public function cobrarPorPrioridad(Request $request)
    {

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
            ->select('socios.nombre AS socio', 'cuotas.id AS id_cuota', 'cuotas.nro_cuota', 'prioridades.orden', 'socios.id AS id_socio', 'cuotas.importe', 'ventas.id AS id_venta')
            ->where(function($query) use ($fechaHoy){
                $query->where('cuotas.fecha_vencimiento', '<=', $fechaHoy)
                      ->orWhere(function($query2) use ($fechaHoy){
                            $query2->where('cuotas.fecha_vencimiento', '>=', $fechaHoy)
                                   ->where('cuotas.fecha_inicio', '<=', $fechaHoy);
                        });
            })
            ->where('socios.id', '=', $socio['id_socio'])->get();

            $movimientos = DB::table('ventas')
                ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
                ->join('productos', 'ventas.id_producto', '=', 'productos.id')
                ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
                ->join('movimientos', 'movimientos.id_venta', '=', 'ventas.id')
                ->groupBy('movimientos.id_venta')
                ->groupBy('movimientos.nro_cuota')
                ->where('movimientos.fecha', '<=', $fechaHoy)
                ->where('socios.id', '=', $socio['id_socio'])
                ->select('ventas.id AS id_venta', 'movimientos.nro_cuota', 'movimientos.id AS id_movimiento', DB::raw('SUM(movimientos.entrada) AS entrada'))
                ->get();




            $cuotas = $this->unirColecciones($cuotas, $movimientos, ["id_venta", "nro_cuota"], ['entrada' => 0]);
            $cuotas = $cuotas->map(function ($item){
                $diferencia = $item['importe'] - $item['entrada'];
                $item->put('diferencia', $diferencia);
                return $item;
            });
            $cuotas = $cuotas->filter(function ($item){
                return $item['diferencia'] > 0;
            });

            $cuotas = $cuotas->groupBy('id_venta');
            $i = 0;
            $cuotas = $cuotas->map(function ($item) use(&$i){
               $cantidad = $item->count();
               if($cantidad > $i)
               {
                   $i = $cantidad;
               }
               $item->put('cantidad', $cantidad);
               return $item;
            });

            $cuotas->sortBy('cantidad');
            $cuotas = $cuotas->map(function ($item) use ($i){
                if($item['cantidad'] == $i)
                {
                    $item->forget('cantidad');
                    $minimaCuota = $item->min('nro_cuota');
                   $pum = $item->first(function ($item2) use ($minimaCuota){
                       return $item2['nro_cuota'] == $minimaCuota;
                    });
                   return $pum;
                }
            });

            $cuotas = $cuotas->filter(function ($item){
                return $item != null;
            });




            $cuotas = $cuotas->groupBy('orden');
         
            $plataDisponible = $socio['cobro'];
            $deudores = collect();
            $cuotas->each(function ($item) use (&$plataDisponible, &$deudores, $fechaHoy) {
                $plataTotal = $plataDisponible / $item->count();
                $item->each(function ($item2) use (&$plataTotal, &$plataDisponible, &$deudores, $fechaHoy){
                 // el tema de la cuota total esta mal!!! presta atencion joaquin no seas boludo
                    if($item2['diferencia'] <= $plataTotal)
                    {
                        $cuotaTotal = $item2['diferencia'];
                        $plataDisponible -= ($item2['diferencia']);

                    } else if($item2['diferencia'] > $plataTotal)
                    {
                        $cuotaTotal = $plataTotal;
                        $plataDisponible -= $plataTotal;
                        $deudores->push($item2);
                    }
                    $cuota = Movimientos::Create(['entrada' => $cuotaTotal, 'fecha' => $fechaHoy, 'nro_cuota' => $item2['nro_cuota'], 'id_venta' => $item2['id_venta'] ]);

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
                    ->select('socios.nombre AS socio', 'cuotas.id AS id_cuota', 'cuotas.nro_cuota', 'ventas.id AS id_venta', 'prioridades.orden', 'socios.id AS id_asociado', 'cuotas.importe')
                    ->where('cuotas.fecha_inicio', '>=', $fechaHoy)
                    ->where('socios.id', '=', $socio['id_socio'])
                    ->orderBy('cuotas.fecha_inicio')->get();

                $movimientos = DB::table('ventas')
                    ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
                    ->join('productos', 'ventas.id_producto', '=', 'productos.id')
                    ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
                    ->join('movimientos', 'movimientos.id_venta', '=', 'ventas.id')
                    ->groupBy('movimientos.id_venta')
                    ->groupBy('movimientos.nro_cuota')
                    ->where('movimientos.fecha', '>=', $fechaHoy)
                    ->where('socios.id', '=', $socio['id_socio'])
                    ->select('ventas.id AS id_venta', 'movimientos.nro_cuota', 'movimientos.id AS id_movimiento', DB::raw('SUM(movimientos.entrada) AS entrada'))
                    ->get();


                $cuotasTardias = $this->unirColecciones($cuotasTardias, $movimientos, ["id_venta", "nro_cuota"], ['entrada' => 0]);
                $cuotasTardias = $cuotasTardias->map(function ($item){
                    $diferencia = $item['importe'] - $item['entrada'];
                    $item->put('diferencia', $diferencia);
                    return $item;
                });
                $cuotasTardias = $cuotasTardias->filter(function ($item){
                    return $item['diferencia'] > 0;
                });

                    $cuotasTardias = $cuotasTardias->groupBy('orden');
                $cuotasTardias->each(function ($item, $key) use (&$plataDisponible, &$deudores, $fechaHoy) {
                    $plataTotal = $plataDisponible / $item->count();
                    $item->each(function ($item2, $key) use (&$plataTotal, &$plataDisponible, &$deudores, $fechaHoy){
                     
                        if($item2['diferencia'] <= $plataTotal)
                        {
                            $cuotaTotal = $item2['diferencia'];
                            $plataDisponible -= ($item2['diferencia']);

                        } else if($item2['diferencia'] > $plataTotal)
                        {
                            $cuotaTotal = $plataTotal;
                            $plataDisponible -= $plataTotal;
                            $deudores->push($item2);
                        }
                       Movimientos::Create(['entrada' => $cuotaTotal, 'fecha' => $fechaHoy, 'nro_cuota' => $item2['nro_cuota'], 'id_venta' => $item2['id_venta'] ]);


                    });
                    $this->repasarDeudores($deudores, $plataDisponible);
            });

            }

         
        }
        return $request->all();
    }
    public function repasarDeudores($deudores, &$plataDisponible)
    {
        $fechaHoy = Carbon::today();
        if($deudores->count() > 0 && $plataDisponible > 0)
        {
            $deudores2 = collect();
            $plataTotal2 = $plataDisponible / $deudores->count();
                    $deudores->each(function ($item, $key) use (&$plataTotal2, &$plataDisponible, &$deudores2, $fechaHoy) {
                        $entrada = Movimientos::where('nro_cuota', $item['nro_cuota'])
                                                    ->where('id_venta', $item['id_venta'])->get()->sum('entrada');
                        $diferencia = $item['importe'] - $entrada;
                        if($diferencia <= $plataTotal2)
                        {
                            $cuotaTotal = $diferencia;
                            $plataDisponible -= ($diferencia);
                        }
                        else if($diferencia > $plataTotal2)
                        {
                            $cuotaTotal = $plataTotal2;
                            $plataDisponible -= $plataTotal2;
                            $deudores2->push($item);
                        }
                        $cuota = Movimientos::Create(['entrada' => $cuotaTotal, 'fecha' => $fechaHoy, 'nro_cuota' => $item['nro_cuota'], 'id_venta' => $item['id_venta'] ]);

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
    public function cobrarPorVenta(Request $request)
    {
        foreach($request->all() as $venta)
        {

            $ventasMapper = new VentasMapper($venta['id_venta']);
            $ventasCuotasVencidas = $ventasMapper->cuotasVencidas();
            $ventaObj = new RepoVentas($ventasCuotasVencidas);

            $cobrar = new CobrarPorVenta();
            $cobrar->cobrar($ventaObj, $venta['cobro']);
        }
    }

}
