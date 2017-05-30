<?php   namespace App\Repositories\Eloquent\Repos;
use App\Repositories\Eloquent\Gateway\CuotasGateway;
use App\Repositories\Eloquent\Gateway\Gateway;
use App\Repositories\Eloquent\Mapper\CuotasMapper;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 19:03
 */
class CuotasRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new CuotasGateway();
        $this->mapper = new CuotasMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\CuotasRepo';
    }
}