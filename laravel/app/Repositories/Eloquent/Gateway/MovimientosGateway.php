<?php   namespace App\Repositories\Eloquent\Gateway;

use App\Movimientos;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class MovimientosGateway extends Gateway
{
    function model()
    {
        return 'App\Movimientos';
    }


}