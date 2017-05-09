<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 19:30
 */

namespace App\Repositories\Eloquent;
use App\Cuotas;

class CuotasMapper
{
    public function cuotasDeVenta($id)
    {
        $cuotas = Cuotas::where('id_venta', $id)->orderBy('nro_cuota')->get();
        $coleccion = collect();
        $cuotas->each(function($cuota) use ($coleccion){
            $a = new Cuota($cuota->id, $cuota->id_venta, $cuota->importe, $cuota->fecha_vencimiento, $cuota->fecha_inicio, $cuota->nro_cuota);
            $coleccion->push($a);
        });
        return $coleccion;
    }
}