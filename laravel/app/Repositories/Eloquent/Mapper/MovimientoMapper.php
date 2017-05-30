<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 21:15
 */

namespace App\Repositories\Eloquent\Mapper;
use App\Movimientos;
use App\Repositories\Eloquent\Movimiento;

class MovimientoMapper
{
    
    public function map($movimiento)
    {
        return new Movimiento($movimiento->id, $movimiento->entrada, $movimiento->id_cuota, $movimiento->salida, $movimiento->fecha, $movimiento->ganancia, $movimiento->gastos_administrativos);
    }
}