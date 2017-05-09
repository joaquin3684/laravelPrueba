<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 19:14
 */

namespace App\Repositories\Eloquent;
use App\Ventas;
use App\Repositories\Eloquent\Ventas as RepositorioVentas;

class VentasMapper
{
    public function map($id)
    {
        $organismo = Ventas::find($id);
        return $org = new RepositorioVentas($organismo->id, $organismo->nombre, $organismo->cuit, $organismo->cuota_social );
    }
}