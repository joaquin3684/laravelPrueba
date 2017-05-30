<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/05/17
 * Time: 19:34
 */

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Gateway\EstadoVentaGateway;
use App\Repositories\Eloquent\Mapper\EstadoVentaMapper;

class EstadoVentaRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new EstadoVentaGateway();
        $this->mapper = new EstadoVentaMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\EstadoVentaRepo';
    }
}