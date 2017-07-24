<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        public function filtrosQueryBuilder($objeto, $query)
        {
            $objetoNuevo = $this->filtrosNoNulos($objeto);
            foreach($objetoNuevo as $obj)
            {
                $query->where($obj['campo'], $obj['operador'], $obj['valor']);
            }
        }

    public function filtrosColecciones($objeto, $row)
    {
        $objeto = $this->filtrosNoNulos($objeto);
        $objeto = collect($objeto);
        $resultado = $objeto->each(function ($item, $key) use($row) {
            $item = collect($item);
           // return $item->get('valor') == $row->get('id_organismo');
        });
        return $resultado;
    }

    public function filtrosNoNulos($objeto)
    {
        $array = collect();
        foreach($objeto['filtros'] as $obj)
        {
            if(!empty($obj['valor']))
            {
                $array->push($obj);
            }
        }

        return $array;
    }


    public function unirColecciones($array1, $array2, $parametrosComparativo, $parametrosNulos = null)
    {
        $unido =  $array1->map(function ($item) use ($array2, $parametrosComparativo, $parametrosNulos){
            $var = $array2->first(function ($item2) use ($item, $parametrosComparativo){
               foreach ($parametrosComparativo as $parametro){
                    if($item->$parametro != $item2->$parametro){
                        return false;
                    }
                }
                return true;
            });
            $item = collect($item);
            if($var == null)
            {
                return $item->union($parametrosNulos);
            }
            return $item->union($var);
        });
       return $unido;

    }

    public function filtrarPorOrganismo($item, $organismo)
    {
        return $item['id_organismo'] == $organismo;
    }

    public function filtrarPorProducto($item, $producto)
    {
        return $item['id_producto'] == $producto;
    }
    /**
     * @param $arrayDeFiltros [{funcion: filtrarPorOrganismo, valor:1}, {funcion: filtrarPorAsociado, 2}]
     * @param $arrayAFiltrar [{id_organismo : 1, id_asociado:2}, {id_organismo:3, id_asociado:2}]
     * @return un array para seguir filtrando
     */
    public function recursionPorFiltros($arrayDeFiltros, &$arrayAFiltrar)
    {
        if($arrayDeFiltros->count() > 0)
        {
            $filtro = $arrayDeFiltros->shift();
            $funcion = $filtro['funcion'];
            $valor = $filtro['valor'];
            $arrayAFiltrar =  $arrayAFiltrar->filter(function ($item, $key) use ($funcion, $valor){
                return $this->$funcion($item, $valor);
            });
            $this->recursionPorFiltros($arrayDeFiltros, $arrayAFiltrar);
        }


    }

    public function aplicarFiltros($arrayDeFiltros, $array)
    {
        $this->recursionPorFiltros($arrayDeFiltros, $array);
        return $array;
    }

}

