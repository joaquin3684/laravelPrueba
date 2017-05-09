<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/04/17
 * Time: 15:14
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\abmInterface;
use App\Repositories\Eloquent\RepositorioAbm;

class AbmOrganismosRepositorio extends RepositorioAbm
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Organismos';
    }





}