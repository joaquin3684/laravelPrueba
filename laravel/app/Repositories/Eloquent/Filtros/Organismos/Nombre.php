<?php namespace App\Repositories\Eloquent\Filtros\Organismos;

use App\Repositories\Contracts\filtros;
use Illuminate\Database\Eloquent\Builder;
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/06/17
 * Time: 13:27
 */
class Nombre implements filtros
{
    public static function apply(Builder $builder, $value)
    {
        return $builder->where('nombre', $value);
    }
}