<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 21:15
 */

namespace App\Repositories\Eloquent\Mapper;
use App\Movimientos;

class MovimientoMapper
{

    public function alta($id_cuota, $entrada, $fecha)
    {
        Movimientos::create(['id_cuota' => $id_cuota, 'entrada' => $entrada, 'fecha' => $fecha ]);
    }
}