<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 20:15
 */

namespace App\Repositories\Eloquent;

use App\Movimientos;
class Movimiento
{
    private $id;
    private $id_cuota;
    private $entrada;
    private $salida;
    private $fecha;
    private $activeMovimiento;

    /**
     * Movimiento constructor.
     * @param $id
     * @param $id_cuota
     * @param $entrada
     * @param $salida
     * @param $fecha
     */
    public function __construct(Movimientos $movimiento)
    {
        $this->id = $movimiento->id;
        $this->id_cuota = $movimiento->id_cuota;
        $this->entrada = $movimiento->entrada;
        $this->salida = $movimiento->salida;
        $this->fecha = $movimiento->fecha;
        $this->activeMovimiento = $movimiento;
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

    public function pagarProovedor($gastosAdmin, $ganancia)
    {
        $entrada = $this->activeMovimiento->entrada;
        $this->activeMovimiento->salida = $entrada - ($entrada * ($gastosAdmin + $ganancia) / 100);
        $this->activeMovimiento->gastos_administrativos = $entrada * $gastosAdmin / 100;
        $this->activeMovimiento->ganancia = $entrada * $ganancia / 100;

        $this->activeMovimiento->save();
    }
}