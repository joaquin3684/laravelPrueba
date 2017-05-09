<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 16:10
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\CobrarPorVenta;
use App\Repositories\Eloquent\Cuota;


class Ventas
{
    private $cuotas;
    private $id;
    private $id_asociado;
    private $id_producto;
    private $alta;
    private $aprobado;
    private $descripcion;
    private $nro_cuotas;
    private $fecha;
    private $cobrarObjeto;

    public function __construct($id, $id_asociado = null, $id_producto = null, $alta = null, $aprobado = null, $descripcion = null, $nro_cuotas = null, $fecha = null)
    {
        $this->id = $id;
        $this->id_asociado = $id_asociado;
        $this->id_producto = $id_producto;
        $this->alta = $alta;
        $this->aprobado = $aprobado;
        $this->descripcion = $descripcion;
        $this->nro_cuotas = $nro_cuotas;
        $this->fecha = $fecha;
        $cuota = new Cuota();
        $this->cobrarObjeto = new CobrarPorVenta();
        $this->cuotas = $cuota->cuotasDeVenta($this->id);
    }

    public function cobrar($monto)
    {
        $this->cobrarObjeto->cobrar($this->cuotasVencidas(), $monto);
    }

    public function cuotasVencidas()
    {
        return $this->cuotas->filter(function ($cuota){
            return $cuota->estaVencida();
        });
    }

    public function setCuotas(Cuota $cuotas)
    {
        $this->cuotas = $cuotas;
    }
}