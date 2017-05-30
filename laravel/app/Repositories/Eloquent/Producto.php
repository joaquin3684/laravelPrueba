<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/05/17
 * Time: 02:39
 */

namespace App\Repositories\Eloquent;


class Producto
{
    private $id;
    private $nombre;
    private $gastos_administrativos;
    private $ganancia;
    private $tipo;
    private $proveedor;

    public function __construct($id, $nombre, $gastos_administrativos, $ganancia, $tipo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->gastos_administrativos = $gastos_administrativos;
        $this->ganancia = $ganancia;
        $this->tipo = $tipo;
    }

    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }

    public function getPrioridad()
    {
        return $this->proveedor->getPrioridad();
    }

    /**
     * @return mixed
     */
    public function getGastosAdministrativos()
    {
        return $this->gastos_administrativos;
    }

    /**
     * @return mixed
     */
    public function getGanancia()
    {
        return $this->ganancia;
    }


}