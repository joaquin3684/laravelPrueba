<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/05/17
 * Time: 22:08
 */

namespace App\Repositories\Eloquent\Mapper;


use App\Socios;

class SociosMapper
{
    private $idSocio;

    public function __construct($idSocio)
    {
        $this->idSocio = $idSocio;
    }

    public function ventasConCuotasVencidas()
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        return Socios::with(['ventas.cuotas' => function($q) use ($hoy){
            $q->where('fecha_inicio', '<', $hoy);
            $q->with('movimientos');
        }, 'ventas.producto.proovedor'])->find($this->idSocio);
    }

}