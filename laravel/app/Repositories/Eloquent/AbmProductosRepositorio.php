<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/04/17
 * Time: 15:59
 */

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\abmInterface;
use App\Repositories\Eloquent\RepositorioAbm;


class AbmProductosRepositorio extends RepositorioAbm
{
    function model()
    {
        return 'App\Productos';
    }
}