<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 18:57
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Organismo;
use App\Organismos;

class OrganismoMapper
{
    public function map($id)
    {
        $organismo = Organismos::find($id);
        return $org = new Organismo($organismo->id, $organismo->nombre, $organismo->cuit, $organismo->cuota_social );
    }
}