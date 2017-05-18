<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 17:39
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Mapper\MovimientoMapper;
use App\Cuotas;

class Cuota
{
    private $movimientos;
    private $id;
    private $id_venta;
    private $importe;
    private $fecha_vencimiento;
    private $fecha_inicio;
    private $nro_cuota;
    private $activeCuota;


    public function __construct(Cuotas $cuota)
    {
        $this->id = $cuota->id;
        $this->id_venta = $cuota->id_venta;
        $this->importe = $cuota->importe;
        $this->fecha_vencimiento = $cuota->fecha_vencimiento;
        $this->fecha_inicio = $cuota->fecha_inicio;
        $this->nro_cuota = $cuota->nro_cuota;
        $this->setMovimientos($cuota->movimientos);
        $this->activeCuota = $cuota;

    }

    public function cobrar(&$monto)
    {
        $montoACobrar = $this->importe - $this->totalEntradaDeMovimientosDeCuota();
        $cobrado = $montoACobrar <= $monto && $monto > 0 ? $montoACobrar : $monto;
        $mapperMovimiento = new MovimientoMapper();
        $fecha = new Fechas();
        $mapperMovimiento->alta($this->id, $cobrado, $fecha->getFechaHoy());
        $monto = $monto - $cobrado;
    }

    public function setMovimientos($movimientos)
    {
        $this->movimientos =  $movimientos->map(function ($movimiento) {
            return new Movimiento($movimiento);
        });
    }

    public function estaVencida()
    {
           return $this->importe > $this->totalEntradaDeMovimientosDeCuota();
    }

    public function totalEntradaDeMovimientosDeCuota()
    {
        return $this->movimientos->sum(function($movimiento){
            return $movimiento->getEntrada();
        });
    }

    public function pagarProovedor($gastosAdmin, $ganancia)
    {
        $this->movimientos->each(function ($movimiento) use ($gastosAdmin, $ganancia){
            $movimiento->pagarProovedor($gastosAdmin, $ganancia);
        });
    }
}