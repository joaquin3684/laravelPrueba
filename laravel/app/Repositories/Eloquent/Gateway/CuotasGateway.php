<?php namespace App\Repositories\Eloquent\Gateway;

use App\Cuotas;
use App\Repositories\Eloquent\Gateway\Gateway;
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class CuotasGateway extends Gateway
{
    function model()
    {
        return 'App\Cuotas';
    }

}