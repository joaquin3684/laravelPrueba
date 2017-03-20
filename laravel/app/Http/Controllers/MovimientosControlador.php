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

class MovimientosControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('CuentasCorrientes');
    }


    public function store(Request $request)
    {
       $movimiento = Movimientos::create($request->all());
        $importeCuota = $request['importe'] / $request['nro_cuotas'];
        for($i=1; $request['nro_cuotas']>= $i; $i++)
        {
            Cuotas::create(['nro_cuota' => $i, 'importe' => $importeCuota, 'id_movimiento' => $movimiento->id]);
        }
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
            
            ->select('movimientos.*', 'socios.nombre AS socio', 'proovedores.nombre AS proovedor', 'productos.nombre AS producto', 'cuotas.importe', 'cuotas.nro_cuota', 'cuotas.pago', 'cuotas.fecha_pago', 'organismos.nombre AS organismo', 'organismos.id AS id_organismo');
            
     return  $tabla =  Datatables::of($movimientos)
           ->filter(function ($query) use ($request){
                
                $this->filtros($request,$query);
            
            })
        ->make(true);

        
        //return $this->filtrosNoNulos($request);
    }
   /* public function datos(Request $request)
    {
        $movimientos = DB::table('movimientos')
            ->join('cuotas', 'cuotas.id_movimiento', '=', 'movimientos.id')
            ->join('socios', 'movimientos.id_asociado', '=', 'socios.id')
            ->join('productos', 'movimientos.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id');
            })
            ->groupBy('socios.id')
            ->where('cuotas.cobro', '=', '1')
            ->select('socios.nombre AS socio', 'organismos.nombre AS organismo', DB::raw('SUM(cuotas.importe) AS totalPagado'))
            ->get();

        $movimientos2 = DB::table('movimientos')
            ->join('cuotas', 'cuotas.id_movimiento', '=', 'movimientos.id')
            ->join('socios', 'movimientos.id_asociado', '=', 'socios.id')
            ->join('productos', 'movimientos.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id');
            })
            ->groupBy('socios.id')
            ->where('cuotas.cobro', '=', '0')
            ->select('socios.nombre AS socio', 'organismos.nombre AS organismo', DB::raw('SUM(cuotas.importe) AS totalDeuda'))
            ->get();

           $merged = $movimientos->merge($movimientos2);
            dd($merged->all());
            
    return  $tabla =  Datatables::of($movimientos2)
           ->filter(function ($query) use ($request){
                
                $this->filtros($request,$query);
            
            })
        ->make(true);
    }*/

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

    public function saldo(Request $request)
    {
       $debe = DB::table('movimientos')
            ->join('cuotas', 'cuotas.id_movimiento', '=', 'movimientos.id')
            ->join('socios', 'movimientos.id_asociado', '=', 'socios.id')
            ->join('productos', 'movimientos.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->whereExists(function ($query) use ($request){
                $this->filtros($request,$query);
            })
            ->where('cuotas.cobro', '=', '0')
            ->select(DB::raw('SUM(cuotas.importe) AS debe'))
            ->first();

        $pago = DB::table('movimientos')
            ->join('cuotas', 'cuotas.id_movimiento', '=', 'movimientos.id')
            ->join('socios', 'movimientos.id_asociado', '=', 'socios.id')
            ->join('productos', 'movimientos.id_producto', '=', 'productos.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('proovedores', function($join){
                $join->on('productos.id_proovedor', '=', 'proovedores.id')->groupBy('proovedores.id');
            })
            ->whereExists(function ($query) use ($request){
                $this->filtros($request,$query);
            })
            ->where('cuotas.cobro', '=', '1')
            ->select(DB::raw('SUM(cuotas.importe) AS pago'))
            ->first();

       return $saldo = 10000 - floatval($debe->debe) + floatval($pago->pago);
      // return [$debe, $pago];
        
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
