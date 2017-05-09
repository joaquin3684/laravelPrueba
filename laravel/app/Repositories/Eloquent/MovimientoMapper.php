<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 21:15
 */

namespace App\Repositories\Eloquent;
use App\Movimientos;
use App\Repositories\Eloquent\Movimiento;
class MovimientoMapper
{
    public function movimientosDeCuota($id)
    {
        $movimientos = Movimientos::where('id_cuota', $id)->get();
        $collection = collect();
        $movimientos->each(function ($item) use($collection){
            $a = new Movimiento($item->id, $item->id_cuota, $item->entrada, $item->salida, $item->fecha);
            $collection->push($a);
        });
        return $collection;
    }

    public function alta($movimiento)
    {
        Movimientos::create(['id_cuota' => $movimiento->getIdCuota(), 'entrada' => $movimiento->getEntrada(), 'fecha' => $movimiento->getFecha() ]);
    }
}