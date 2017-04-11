<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        public function filtros($objeto, $query)
    {
        $objetoNuevo = $this->filtrosNoNulos($objeto);
        foreach($objetoNuevo as $obj)
        {
            $query->where($obj['campo'], $obj['operador'], $obj['valor']);
        }
    }

    public function filtrosNoNulos($objeto)
    {
        $array = [];
        foreach($objeto['filtros'] as $obj)
        {
            if(!empty($obj['valor']))
            {
                array_push($array, $obj);
            }
        }

        return $array;
    }

    public function unirColecciones($array1, $array2, $parametroComparativo, $parametrosNulos)
    {
       return $unido =  $array1->map(function ($item, $key) use ($array2, $parametroComparativo, $parametrosNulos){
            $var = $array2->first(function ($item2, $key) use ($item, $parametroComparativo){
                return $item->$parametroComparativo == $item2->$parametroComparativo;
            });
            $item = collect($item);
            if($var == null)
            {
                return $item->union($parametrosNulos);
            }
            return $item->union($var);
        });

    }
}
