<?php
namespace App\Repositories\Eloquent\Filtros;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/06/17
 * Time: 13:14
 */
abstract class Filtro
{
    private $app;
    protected static $model;

    public function __construct() {
        $this->app = new App();
        $this->makeModel();
    }

    public function makeModel() {
        $model = $this->app->make($this->model());
        static::$model = $model;
    }

    abstract function model();

    /**
     * @param $filters
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function apply(Request $filters)
    {
        $query =
            static::applyDecoratorsFromRequest(
                $filters, (static::$model)->newQuery()
            );

        return static::getResults($query);
    }

    private static function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {

            $decorator = static::createFilterDecorator($filterName);

            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    private static function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\'.static::name().'\\' .
            str_replace(' ', '',
                ucwords(str_replace('_', ' ', $name)));
    }

    private static function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    private static function getResults(Builder $query)
    {
        return $query->get();
    }
}