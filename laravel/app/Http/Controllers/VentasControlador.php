<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ventas;
use App\Cuotas;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Organismos;
use App\Repositories\Eloquent\Ventas as RepoVentas;
class VentasControlador extends Controller
{
    private $ventas;              
    private $cuotas;          
    private $socios;           
    private $productos;      
    private $proovedores;         
    private $movimientos;       
    private $movimientosPorVenta;
    private $organismos;         

    public function __construct()
    {

    }

    public function index()
    {
        return view('CuentasCorrientes');
    }

    public function mostrarPorVenta(Request $request)
    {

        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->groupBy('ventas.id')
            ->where('socios.id', '=', $request['id'])
            ->select('socios.nombre AS socio', 'ventas.id AS id_venta', 'ventas.fecha', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'ventas.nro_cuotas', DB::raw('SUM(cuotas.importe) AS totalACobrar'))->get();

        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('ventas.id')
            ->where('socios.id', '=', $request['id'])
            ->select('ventas.id AS id_venta', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))->get();

        $ventasPorVenta = $this->unirColecciones($ventas, $movimientos, ["id_venta"], ['totalCobrado' => 0]);

        $ventasPorVenta = $ventasPorVenta->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $arrayDeFiltros = $this->filtrosNoNulos($request);
        $arrayDeFiltros = collect($arrayDeFiltros);

        return  $tabla =  Datatables::of($ventasPorVenta)
            ->filter(function ($instance) use ($arrayDeFiltros){
                $instance->collection = $this->aplicarFiltros($arrayDeFiltros, $instance->collection);

            })
            ->make(true);
    }

    public function mostrarPorCuotas(Request $request)
    {

        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', 'proovedores.id', '=', 'productos.id_proovedor')
            ->where('ventas.id', '=', $request['id'])
            ->select('cuotas.id AS id_cuota', 'socios.nombre AS socio', 'cuotas.fecha_vencimiento', 'cuotas.id', 'cuotas.nro_cuota', 'ventas.fecha', 'proovedores.nombre AS proovedor', 'cuotas.importe AS totalACobrar')->get();

        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('movimientos.id_cuota')
            ->where('ventas.id', '=', $request['id'])
            ->select('movimientos.id_cuota', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))->get();

        $ventasPorCuota = $this->unirColecciones($ventas, $movimientos, ["id_cuota"], ['totalCobrado' => 0]);

        $ventasPorCuota= $ventasPorCuota->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $arrayDeFiltros = $this->filtrosNoNulos($request);
        $arrayDeFiltros = collect($arrayDeFiltros);

        return  $tabla =  Datatables::of($ventasPorCuota)
            ->filter(function ($instance) use ($arrayDeFiltros){
                $instance->collection = $this->aplicarFiltros($arrayDeFiltros, $instance->collection);

            })
            ->make(true);
    }

    public function store(Request $request)
    {
       $venta = Ventas::create($request->all());
        $importeCuota = $request['importe'] / $request['nro_cuotas'];
        $fecha = explode('-', $request['vencimiento']);
        $carbon = Carbon::create($fecha[0], $fecha[1], $fecha[2], 0);
        $fechaHoy = Carbon::today();
        
        for($i=1; $request['nro_cuotas']>= $i; $i++)
        {
            Cuotas::create(['nro_cuota' => $i, 'importe' => $importeCuota, 'id_venta' => $venta->id, 'fecha_vencimiento' => $carbon->toDateString(), 'fecha_inicio' => $fechaHoy->toDateString()]);
            
            $fechaHoy = Carbon::create($carbon->year, $carbon->month, $carbon->day);
            $fechaHoy->addDays(1);
            $carbon->addDays(30);
           //TODO: cuando se da de aprobado una venta es cuando recien toma vigencia para poder seguir con el proceso
        }
    }

    public function mostrarPorSocio(Request $request)
    {
        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->groupBy('socios.id')
            ->where('organismos.id', '=', $request['id'])
            ->select('socios.nombre AS socio', 'socios.id AS id_socio',  DB::raw('SUM(cuotas.importe) AS totalACobrar'))->get();

        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('socios.id')
            ->where('organismos.id', '=', $request['id'])
            ->select('socios.id AS id_socio', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))->get();

        $ventasPorSocio = $this->unirColecciones($ventas, $movimientos, ["id_socio"], ['totalCobrado' => 0]);

        $ventasPorSocio = $ventasPorSocio->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $arrayDeFiltros = $this->filtrosNoNulos($request);
        $arrayDeFiltros = collect($arrayDeFiltros);

        return  $tabla =  Datatables::of($ventasPorSocio)
                ->filter(function ($instance) use ($arrayDeFiltros){
                   $instance->collection = $this->aplicarFiltros($arrayDeFiltros, $instance->collection);

                })
               ->make(true);

    }

    public function mostrarPorOrganismo(Request $request)

    {
        /*$ventas = new RepoVentas(2);
        $ventas->cobrar(20);*/

        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->groupBy('organismos.id')
            ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', 'productos.id As id_producto', DB::raw('SUM(cuotas.importe) AS totalACobrar'))->get();

        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')

            ->groupBy('organismos.id')
            ->select('organismos.id AS id_organismo', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))->get();

        //return [$ventas, $movimientos];
        $ventasPorOrganismo = $this->unirColecciones($ventas, $movimientos, ["id_organismo"], ['totalCobrado' => 0]);

        $ventasPorOrganismo = $ventasPorOrganismo->each(function ($item, $key){
            $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
            $item->put('diferencia', $diferencia);
            return $item;
        });

        $arrayDeFiltros = $this->filtrosNoNulos($request);
        $arrayDeFiltros = collect($arrayDeFiltros);

        /*return  $tabla =  Datatables::of($ventasPorOrganismo)
            ->filter(function ($instance) use ($arrayDeFiltros){
                $instance->collection = $this->aplicarFiltros($arrayDeFiltros, $instance->collection);

            })
            ->make(true);*/

        return $ventasPorOrganismo->toJson();


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
                $this->filtrosQueryBuilder($request,$query);
               
            })
            ->select('ventas.*', 'socios.nombre AS socio', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'proovedores.id AS id_proovedor', 'organismos.nombre AS organismo', 'organismos.id AS id_organismo')
     
            ->get();

            $mov = $ventas->unique($request['groupBy']);
            if(sizeof($ventas) == 0)
            {
                
                dd($this->filtrosNoNulos($request));
            }else {
        return ['ventas' => $mov->values()->all(), 'pin' => $this->filtrosNoNulos($request)];
                
            }
    }

}