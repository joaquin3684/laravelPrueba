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
use App\Repositories\Eloquent\Repos\MovimientosRepo;

class Cuota
{
    private $movimientos;
    private $id;
    private $importe;
    private $fecha_vencimiento;
    private $fecha_inicio;
    private $nro_cuota;

    public function __construct($id, $importe, $fecha_vencimiento, $fecha_inicio, $nro_cuota)
    {
        $this->id = $id;
        $this->importe = $importe;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->fecha_inicio = $fecha_inicio;
        $this->nro_cuota = $nro_cuota;
    }


    public function cobrar($monto)
    {
        $montoACobrar = $this->importe - $this->totalEntradaDeMovimientosDeCuota();
        $cobrado = $montoACobrar <= $monto && $monto > 0 ? $montoACobrar : $monto;
        $fecha = new Fechas();
        $array = array('id_cuota' => $this->id, 'entrada' => $cobrado, 'fecha' => $fecha->getFechaHoy());
        $this->addMovimiento($array);
        return $cobrado;
    }

    public function setMovimientos($movimientos)
    {
        $this->movimientos =  $movimientos;
    }

    public function addMovimiento($array)
    {
        $movimientoRepo = new MovimientosRepo();
        $mov = $movimientoRepo->create($array);
        $this->movimientos->push($mov);
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

    public function getMovimientos()
    {
        return $this->movimientos;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdVenta()
    {
        return $this->id_venta;
    }

    public function getImporte()
    {
        return $this->importe;
    }

    public function getFechaVencimiento()
    {
        return $this->fecha_vencimiento;
    }

    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    public function getNroCuota()
    {
        return $this->nro_cuota;
    }

}