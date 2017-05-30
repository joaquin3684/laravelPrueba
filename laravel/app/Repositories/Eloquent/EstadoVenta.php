<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/05/17
 * Time: 20:07
 */

namespace App\Repositories\Eloquent;


class EstadoVenta
{
    private $id;
    private $id_venta;
    private $id_responsable_estado;
    private $estado;
    private $observacion;

    public function __construct($id, $id_venta, $id_responsable_estado, $estado, $observacion)
    {
        $this->id = $id;
        $this->id_venta = $id_venta;
        $this->id_responsable_estado = $id_responsable_estado;
        $this->estado = $estado;
        $this->observacion = $observacion;
    }

    public function aprobar()
    {

    }
}