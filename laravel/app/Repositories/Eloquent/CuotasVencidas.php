<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 16/05/17
 * Time: 22:11
 */

namespace App\Repositories\Eloquent;


class CuotasVencidas
{
    private $cuotasVencidas;

    public function __construct($cuotas)
    {
        $this->cuotasVencidas = $this->filtrarVencidas($cuotas);
    }

    public function filtrarVencidas($cuotas)
    {
        return $cuotas->filter(function ($cuota){
           return $this->estaVencida($cuota);
        });
    }

    public function estaVencida($cuota)
    {
           return $cuota->importe != $this->totalEntradaDeMovimientosDeCuota($cuota);
    }

    public function totalEntradaDeMovimientosDeCuota($cuota)
    {
        return $cuota->movimientos->sum('entrada');
    }

    public function getCuotasVencidas()
    {
        return $this->cuotasVencidas;
    }


}