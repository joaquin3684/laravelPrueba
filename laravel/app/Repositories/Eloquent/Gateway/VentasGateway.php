<?php   namespace App\Repositories\Eloquent\Gateway;
use App\Repositories\Eloquent\Fechas;
use App\Ventas;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class VentasGateway extends Gateway
{
    function model()
    {
        return 'App\Ventas';
    }

    public function cuotas()
    {
        $cuotas = Ventas::find($this->idVenta)->cuotas();
        $coleccion = collect();
        $cuotas->each(function($cuota) use ($coleccion){
            $a = new Cuota($cuota->id, $cuota->id_venta, $cuota->importe, $cuota->fecha_vencimiento, $cuota->fecha_inicio, $cuota->nro_cuota);
            $coleccion->push($a);
        });
        return $coleccion;
    }

    public function cuotasVencidas($id)
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        return $ventas = Ventas::with(['cuotas' => function($query) use ($hoy) {
            $query->where('fecha_inicio', '<', $hoy);
            $query->with('movimientos');
        }])->find($id);
    }

    public function cuotasAPagarProovedor($id_proovedor)
    {
        return $ventas = Ventas::with(['cuotas' => function($query) {
            $query->with(['movimientos' => function($query) {
                $query->where('entrada', '>', 0);
                $query->where('salida', '=', 0);
            }]);
        }, 'producto.proovedor'])->has('movimientos')->whereHas('producto.proovedor', function($query) use ($id_proovedor){
            $query->where('id', $id_proovedor);
        })->get();
    }
}