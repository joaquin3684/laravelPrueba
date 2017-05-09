<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/05/17
 * Time: 22:41
 */

namespace App\Repositories\Eloquent;


class CobrarPorVenta
{
    public function cobrar($cuotas, $monto)
    {
        $cuotas->each(function ($cuota) use (&$monto){
            if($monto == 0)
                return false;
           $cuota->cobrar($monto);
        });
    }
}