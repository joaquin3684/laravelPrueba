<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 19:14
 */

namespace App\Repositories\Eloquent\Mapper;
use App\Repositories\Eloquent\Fechas;
use App\Ventas;
use App\Repositories\Eloquent\Cuota;
use App\Repositories\Eloquent\Ventas as RepoVentas;


class VentasMapper
{
    private $idVenta;

    public function __construct($idVenta = null)
    {
        $this->idVenta = $idVenta;
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

    public function find()
    {
        $venta = Ventas::find($this->idVenta);
        return new RepoVentas($venta->id, $venta->id_asociado, $venta->id_producto, $venta->alta, $venta->aprobado, $venta->descripcion, $venta->nro_cuotas, $venta->fecha);
    }

    public function cuotasVencidas()
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        return $ventas = Ventas::with(['cuotas' => function($query) use ($hoy) {
            $query->where('fecha_inicio', '<', $hoy);
            $query->with('movimientos');
        }])->find($this->idVenta);

    }

    public function cuotasAPagarProovedor($id_proovedor)
    {
        return $ventas = Ventas::with(['cuotas' => function($query) {
               $query->with(['movimientos' => function($query) {
                $query->where('entrada', '>', 0);
                $query->where('salida', '=', 0);
            }]);
        }], ['producto.proovedor' => function ($query) use ($id_proovedor){
            $query->where('id', $id_proovedor);
        }])->get();
    }
}