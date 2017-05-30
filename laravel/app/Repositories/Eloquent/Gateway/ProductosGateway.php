<?php   namespace App\Repositories\Eloquent\Gateway;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class ProductosGateway extends Gateway
{
    function model()
    {
        return 'App\Productos';
    }
}