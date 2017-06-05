<?php

namespace App\Repositories\Eloquent\Filtros;
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/06/17
 * Time: 12:29
 */
class OrganismoFilter extends Filtro
{

    public static function name()
    {
        return 'Organismos';
    }

    function model()
    {
        return 'App\Organismos';
    }

}