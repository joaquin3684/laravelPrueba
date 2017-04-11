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
use App\Organismos;

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
  
      $this->ventas              = Ventas::all();
      $this->organismos = Organismos::all();
      $this->cuotas              = collect();
      $this->socios              = collect();
      $this->productos           = collect();
      $this->proovedores         = collect();
      $this->movimientos         = collect();
      $this->movimientosPorVenta = collect();

      

      foreach ($this->ventas as $key => $venta) {
        $this->cuotas->push($venta->cuotas);
        $this->socios->push($venta->socio);
        $this->productos->push($venta->producto);
        $this->movimientos->push($venta->movimientos);

      }
      $this->cuotas              = $this->cuotas->collapse();
      $this->movimientos         = $this->movimientos->collapse();
      $this->movimientosPorVenta = $this->movimientos->groupBy('id_venta');


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
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->groupBy('ventas.id')
            ->select('socios.nombre AS socio', 'ventas.id AS id_servicio','proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'ventas.nro_cuotas AS cuotas', DB::raw('SUM(cuotas.importe) AS total,  SUM(cuotas.importe) - SUM(cuotas.cobro) AS deuda '))
            ->where('ventas.id_asociado', '=', $request['id']);

          return  $tabla =  Datatables::of($ventas)
                ->filter(function ($query) use ($request){
                
                    $this->filtros($request,$query);
            
                })
        ->make(true);
    }

    public function mostrarPorProducto(Request $request)
    {

        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            
            ->select('socios.nombre AS socio', 'cuotas.nro_cuota','proovedores.nombre AS proovedor', 'cuotas.importe', 'cuotas.fecha_inicio', 'cuotas.fecha_vencimiento', 'cuotas.cobro')
            ->where('ventas.id', '=', $request['id']);

          return  $tabla =  Datatables::of($ventas)
                ->filter(function ($query) use ($request){
                
                    $this->filtros($request,$query);
            
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
            Cuotas::create(['nro_cuota' => $i, 'importe' => $importeCuota, 'id_venta' => $venta->id, 'fecha_vencimiento' => $carbon->toDateString()]);
            
            $fechaHoy = Carbon::create($carbon->year, $carbon->month, $carbon->day);
            $fechaHoy->addDays(1);
            $carbon->addDays(30);
           
        }
    }

    public function mostrarPorOrganismo(Request $request)
    {

        $ventas = DB::table('ventas')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->groupBy('organismos.id')
            ->select('organismos.nombre AS organismo', 'organismos.id AS id_organismo', DB::raw('SUM(cuotas.importe) AS totalACobrar'))->get();

        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.id_venta', '=', 'ventas.id')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->groupBy('organismos.id')
            ->select('organismos.id AS id_organismo', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))->get();

            //return [$ventas, $movimientos];
            $ventasPorOrganismo = $this->unirColecciones($ventas, $movimientos, "id_organismo", ['totalCobrado' => 0]);

            $ventasPorOrganismo = $ventasPorOrganismo->each(function ($item, $key){
                $diferencia = $item['totalACobrar'] - $item['totalCobrado'];
                $item->put('diferencia', $diferencia);
                return $item;
            });
        

        return  $tabla =  Datatables::of($ventasPorOrganismo)
                /*->filter(function ($query) use ($request){
                
                    $this->filtros($request,$query);
            
                })*/
                ->filter(function ($instance) use ($request){
                    $instance->collection = $instance->collection->filter(function ($row) use ($request){
                        return $row;
                        return $row == $request['filtros']['id_organismo'] ? true : false;
                    });
                })
        ->make(true);
 
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
