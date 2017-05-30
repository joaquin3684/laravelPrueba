<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 20:15
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Repos\MovimientosRepo;

class Movimiento
{
    private $id;
    private $id_cuota;
    private $entrada;
    private $salida;
    private $fecha;
    private $ganancia;
    private $gastos_administrativos;

    public function __construct($id, $entrada, $id_cuota, $salida, $fecha, $ganancia, $gastos_administrativos)
    {
        $this->id = $id;
        $this->id_cuota = $id_cuota;
        $this->entrada = $entrada;
        $this->salida = $salida;
        $this->fecha = $fecha;
        $this->ganancia = $ganancia;
        $this->gastos_administrativos = $gastos_administrativos;
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
        $entrada = $this->entrada;
        $this->salida = $entrada - ($entrada * ($gastosAdmin + $ganancia) / 100);
        $this->gastos_administrativos = $entrada * $gastosAdmin / 100;
        $this->ganancia = $entrada * $ganancia / 100;
        $this->update($this, $this->id);
    }

    public function update($arr, $id)
    {
        $repo = new MovimientosRepo();
        if(!is_array($arr))
            $arr = get_object_vars($arr);

        $repo->update($arr, $id);
    }
}