<?php namespace App\Repositories\Eloquent\Repos;
use App\Repositories\Eloquent\Gateway\ProveedoresGateway;
use App\Repositories\Eloquent\Mapper\ProveedoresMapper;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 19:04
 */
class ProveedoresRepo extends Repositorio
{
    public $mapper;
    public $gateway;

    public function __construct()
    {
        $this->mapper = new ProveedoresMapper();
        $this->gateway = new ProveedoresGateway();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\ProveedoresRepo';
    }
}