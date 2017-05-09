<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 20:15
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Fechas;
use App\Repositories\Eloquent\MovimientoMapper;
class Movimiento
{
    private $id;
    private $id_cuota;
    private $entrada;
    private $salida;
    private $fecha;
    private $movimientoMapper;

    /**
     * Movimiento constructor.
     * @param $id
     * @param $id_cuota
     * @param $entrada
     * @param $salida
     * @param $fecha
     */
    public function __construct($id = null, $id_cuota = null, $entrada = null, $salida = null, $fecha = null)
    {
        $this->id = $id;
        $this->id_cuota = $id_cuota;
        $this->entrada = $entrada;
        $this->salida = $salida;
        $this->fecha = $fecha;
        $movimiento = new MovimientoMapper();
        $this->movimientoMapper = $movimiento;
    }

    public function movimientosDeCuota($id)
    {
        return $this->movimientoMapper->movimientosDeCuota($id);
    }

    public function totalEntradaDeCuota($id)
    {
        $cuotas = $this->movimientosDeCuota($id);
        $totalEntrada = $cuotas->sum(function($cuota){ return $cuota->entrada;});
        return $totalEntrada;
    }
    public function agregarEntrada($entrada)
    {
        $fecha = new Fechas();
        $this->entrada = $entrada;
        $this->fecha = $fecha->getFechaHoy();
        $this->movimientoMapper->alta($this);
    }

    public function getIdCuota()
    {
        return $this->id_cuota;
    }

    public function getEntrada()
    {
        return $this->entrada;
    }

    public function getFecha()
    {
        return $this->fecha;
    }
}