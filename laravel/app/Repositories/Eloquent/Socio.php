<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/05/17
 * Time: 23:20
 */

namespace App\Repositories\Eloquent;
use App\Socios;
use App\Repositories\Eloquent\CobrarPorSocio;
class Socio
{
    private $ventas;
    private $activeSocio;
    private $id;
    private $nombre;
    private $fecha_nacimiento;
    private $cuit;
    private $dni;
    private $domicilio;
    private $localidad;
    private $codigo_postal;
    private $telefono;
    private $organismo;
    private $fecha_ingreso;
    private $legajo;
    private $grupo_familiar;


    public function __construct(Socios $socio)
    {
        $this->id = $socio->id;
        $this->nombre = $socio->nombre;
        $this->fecha_nacimiento = $socio->fecha_nacimiento;
        $this->cuit = $socio->cuit;
        $this->dni = $socio->dni;
        $this->domicilio = $socio->domicilio;
        $this->localidad = $socio->localidad;
        $this->codigo_postal = $socio->codigo_postal;
        $this->telefono = $socio->telefono;
        $this->fecha_ingreso = $socio->fecha_ingreso;
        $this->legajo = $socio->legajo;
        $this->activeSocio = $socio;
        $this->setVentas($socio->ventas);
    }

    public function setVentas($ventas)
    {
        $this->ventas = $ventas->map(function ($venta) {
            return new Ventas($venta);
        });
    }

    public function getVentas()
    {
        return $this->ventas;
    }

}