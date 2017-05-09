<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/04/17
 * Time: 18:34
 */

namespace App\Repositories\Eloquent;

use Cartalyst\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Ventas;

class VentasRepositorio
{

    private $arrayLoco;
    private $ventas;
    public function __construct()
    {

        $this->arrayLoco = collect(['socios' => '1', 'organismos' => 'socios', 'productos' => '1','proovedores' => 'productos', 'cuotas' => '1', 'movimientos' => '1']);
        $this->ventas = new Ventas();
    }
    public function getVentas()
    {
        return $this->ventas->all();
    }
    public function generarConsulta($select, $tabla)
    {

        $selectNuevo = $select->map(function ($item){
           return collect(explode('.',$item))->first();
        });

        $selectNuevo = $selectNuevo->except($tabla);

        $array = collect();
        $nuevo = collect();
        $selectNuevo->each(function($hijo) use (&$array, &$nuevo){
            $array->push($hijo);

            $this->buscarPadres($hijo, $array);
            $array = $array->reverse()->implode('.');
            
            $nuevo->push($array);
            $array = collect();

        });
        $nuevo = $nuevo->flatten()->unique()->implode('", "');



        return $nuevo;
    }
    public function buscarPadres($hijo, &$array)
    {
        $arr = collect();
        $padre = $this->arrayLoco->first(function ($padre, $son) use ($hijo){
           return $hijo == $son;
        });
        if($padre != 1)
        {
            $array->push($padre);
            $this->buscarPadres($padre, $array);
        }
    }
}