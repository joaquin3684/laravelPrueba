<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/05/17
 * Time: 02:23
 */

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Gateway\MovimientosGateway;
use App\Repositories\Eloquent\Mapper\MovimientoMapper;

class MovimientosRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new MovimientosGateway();
        $this->mapper = new MovimientoMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\MovimientosRepo';
    }

}