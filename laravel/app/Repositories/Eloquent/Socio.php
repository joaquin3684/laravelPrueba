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
    private $cobrarObjeto;
    public function __construct(Socios $socio, CobrarPorSocio $cobrar )
    {
        $this->socio = $socio;
        $this->cobrarObjeto = $cobrar;
    }

    public function buscarSocio($id)
    {
        $socio = $this->socio->find($id);
        $this->ventas = $socio->ventas;
    }

    public function cobrar($monto)
    {
        $this->cobrarObjeto($this->ventas, $monto);
    }
}