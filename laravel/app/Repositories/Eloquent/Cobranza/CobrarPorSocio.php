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
use App\Repositories\Eloquent\Ventas;

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
             $orden = $venta->getOrdenPrioridad();
             $cuotasVencidas = $venta->cuotasVencidas();
             $cantidadCuotas = $venta->cuotasVencidas()->count();
             $a = collect(['orden' => $orden, 'cuotas' => $cuotasVencidas, 'cantidad' => $cantidadCuotas]);
             $collect->push($a);
        });
        $max = $collect->max('cantidad');
        $ventasConMayorPrioridad = $collect->filter(function($item) use ($max){
            return $item['cantidad'] == $max;
        })->sortBy('orden');
        $ventaPrioritaria = $ventasConMayorPrioridad->first();
        $cuota = $ventaPrioritaria['cuotas']->shift();
        $ventaPrioritaria['cantidad']
        $montoCuota = $monto / $ventasConMayorPrioridad->count();
        $cuota->cobrar($montoCuota);

    }
}