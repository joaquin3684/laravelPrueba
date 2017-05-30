<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AprobacionServiciosController extends Controller
{
    public function index()
    {
        return view('aprobacion_servicios');
    }

    public function datos()
    {
        return $ventas = Ventas::with('estados', 'cuotas', 'producto.proovedor', 'socio')->whereDoesntHave('estados', function($q){
            $q->where('estado', '=', 'APROBADO');
            $q->orWhere('estado', '=', 'RECHAZADO');
        })->get();
    }

    public function aprobarServicios(Request $request)
    {
        $user = Sentinel::getUser()->id;
        foreach ($request->all() as $servicio)
        {

            $id = $servicio['id'];
            $estado = $servicio['estado'];
            $observacion = $servicio['observacion'];
            $estadoRepo = new EstadoVentaRepo();
            $estadoRepo->create(['id_venta' => $id, 'id_responsable_estado' => $user->id, 'estado' => $estado, 'observacion' => $observacion]);
            if($estado == 'APROBADO')
            {
                $cuotaRepo = new CuotasRepo();
                $ventasRepo = new VentasRepo();
                $venta = $ventasRepo->find($id);
                $fecha = $venta->getFechaVencimiento();
                $carbon = Carbon::createFromFormat('Y-m-d', $fecha);
                $fechaHoy = Carbon::today();
                $importeCuota = $venta->getImporte() / $venta->getNroCuotas();

                for($i=1; $venta->getNroCuotas() >= $i; $i++)
                {
                    $cuotaRepo->create(['nro_cuota' => $i, 'importe' => $importeCuota, 'id_venta' => $venta->getId(), 'fecha_vencimiento' => $carbon->toDateString(), 'fecha_inicio' => $fechaHoy->toDateString()]);

                    $fechaHoy = Carbon::create($carbon->year, $carbon->month, $carbon->day);
                    $carbon->addMonth();
                }

            }


        }
    }
}
