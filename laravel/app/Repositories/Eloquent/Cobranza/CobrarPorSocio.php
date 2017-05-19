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
use App\Repositories\Eloquent\Socio;

class CobrarPorSocio
{

    private $socio;
    public function __construct(Socio $socio)
    {
        $this->socio = $socio;
    }

    public function cobrar($monto)
    {
        $collect = collect();
        $this->socio->getVentas()->each(function ($venta) use ($collect){
             $collect->push($venta->cuotasVencidas());
        });

    }
}