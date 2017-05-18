<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 05/05/17
 * Time: 12:43
 */

namespace App\Repositories\Eloquent\Cobranza;
use App\Repositories\Eloquent\ConsultasCuotas;
use App\Repositories\Eloquent\ConsultasMovimientos;

class CobrarPorSocio
{
    private $cuotas;
    private $movimientos;
    private $prioridad;
    public function __construct(ConsultasCuotas $cuotas, Prioridad $prioridad, ConsultasMovimientos $movimientos)
    {
        $this->cuotas = $cuotas;
        $this->movimientos = $movimientos;
        $this->prioridad = $prioridad;
    }

    public function cobrar($ventas, $monto)
    {
        $cuotasVencidas = $ventas->cuotasVencidas();

    }
}