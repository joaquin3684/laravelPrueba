<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 16:10
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Cobranza\CobrarPorVenta;
use App\Repositories\Eloquent\Mapper\CuotasMapper;
use App\Repositories\Eloquent\Mapper\VentasMapper;
use App\Ventas as ModelVentas;

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
    private $activeVenta;

    public function __construct(ModelVentas $venta)
    {
        $this->id = $venta->id;
        $this->id_asociado = $venta->id_asociado;
        $this->id_producto = $venta->id_producto;
        $this->alta = $venta->alta;
        $this->aprobado = $venta->aprobado;
        $this->descripcion = $venta->descripcion;
        $this->nro_cuotas = $venta->nro_cuotas;
        $this->fecha = $venta->fecha;
        $this->setCuotas($venta->cuotas);
        $this->activeVenta = $venta;


    }

    public function cuotasVencidas()
    {
        return $this->cuotas->filter(function ($cuota){
            return $cuota->estaVencida();
        });
    }

    public function setCuotas($cuotas)
    {
        $this->cuotas = $cuotas->map(function ($cuota) {
            return new Cuota($cuota);
        });
    }

    public function getCuotas()
    {
        return $this->cuotas;
    }

    public function pagarProovedor()
    {
        $gastosAdmin = $this->activeVenta->producto->gastos_administrativos;
        $ganancia = $this->activeVenta->producto->ganancia;
        $this->cuotas->each(function ($cuota) use ($gastosAdmin, $ganancia) {
           $cuota->pagarProovedor($gastosAdmin, $ganancia);
        });
    }
}