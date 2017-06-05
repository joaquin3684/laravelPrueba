<?php

namespace App\Http\Controllers;

use App\EstadoVenta;
use App\Repositories\Eloquent\Filtros\OrganismoFilter;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use Sentinel;
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



       // return  $tabla =  Datatables::of($ventasPorVenta)->make(true);
        return $ventasPorVenta->toJson();
    }

    public function mostrarPorCuotas(Request $request)
    {
        $a =  Ventas::with('cuotas.movimientos', 'producto.proovedor')->find($request['id']);
                $a->cuotas->each(function ($cuota){
                    $s = $cuota->movimientos->sum(function($movimiento) {
                        return $movimiento->entrada;
                    });
                    $cuota->cobrado = $s;
                });
                return $a;


        return $ventasPorCuota->toJson();
    }

    public function store(Request $request)
    {
        $user = Sentinel::getUser();
        $req = $request->all();
        $ventaRepo = new VentasRepo();
        $venta = $ventaRepo->create($req);
        $estadoRepo = new EstadoVentaRepo();
        $estadoVenta = $estadoRepo->create(['id_venta' => $venta->getId(), 'id_responsable_estado' => $user->id, 'estado' => 'ALTA']);

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



       // return  $tabla =  Datatables::of($ventasPorSocio)->make(true);

        return $ventasPorSocio->toJson();

    }

    public function mostrarPorOrganismo(Request $request)

    {

        $filtro = OrganismoFilter::apply($request->all());

        $filtro->each(function($organismo){
            $totalCobrado = $organismo->socios->sum(function($socio){
               return $socio->ventas->sum(function($venta){
                    return $venta->cuotas->sum(function($cuota){
                       return $cuota->movimientos->sum(function($movimiento){
                            return $movimiento->entrada;
                        });
                    });
                });

            });
            $organismo->totalCobrado = $totalCobrado;
        });


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


        //return  $tabla =  Datatables::of($ventasPorOrganismo)->make(true);

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
