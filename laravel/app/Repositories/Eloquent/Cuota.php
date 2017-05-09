<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 17:39
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Movimiento;
use App\Repositories\Eloquent\Fechas;
use App\Repositories\Eloquent\CuotasMapper;

class Cuota
{
    private $movimientos;
    private $id;
    private $id_venta;
    private $importe;
    private $fecha_vencimiento;
    private $fecha_inicio;
    private $nro_cuota;
    private $hoy;
    private $cuotasMapper;
    private $movimiento;

    public function __construct($id = null, $id_venta = null, $importe = null, $fecha_vencimiento = null, $fecha_inicio = null, $nro_cuota = null)
    {
        $this->id = $id;
        $this->id_venta = $id_venta;
        $this->importe = $importe;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->fecha_inicio = $fecha_inicio;
        $this->nro_cuota = $nro_cuota;
        $this->movimiento = new Movimiento(null, $this->id);
        $cuotasMapper = new CuotasMapper();
        $this->cuotasMapper = $cuotasMapper;

    }
    public function cobrar(&$monto)
    {
        $montoACobrar = $this->importe - $this->movimiento->totalEntradaDeCuota($this->id);
        $cobrado = $montoACobrar <= $monto && $monto > 0 ? $montoACobrar : $monto;
            $this->movimiento->agregarEntrada($cobrado);
        $monto = $monto - $cobrado;
    }
    public function cuotasDeVenta($id)
    {
        return $this->cuotasMapper->cuotasDeVenta($id);
    }

    public function setMovimientos()
    {
        $this->movimientos = $this->movimiento->movimientosDeCuota($this->id);
    }

    public function estaVencida()
    {
        $fecha = new Fechas();
        $hoy = $fecha->getFechaHoy();
        if($this->fecha_inicio < $hoy)
        {
           return $this->importe != $this->movimiento->totalEntradaDeCuota($this->id);
        }
    }
}