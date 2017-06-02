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
    protected $model;
    private $namespace;

    public function __construct() {
        $this->app = new App();
        $this->makeModel();
    }

    public function makeModel() {
        $model = $this->app->make($this->model());
        return $this->model = $model;
    }

    abstract function model();

    /**
     * @param $filters
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function apply(Request $filters)
    {
        $query =
            $this->applyDecoratorsFromRequest(
                $filters, ($this->model)->newQuery()
            );

        return $this->getResults($query);
    }

    private function applyDecoratorsFromRequest(Request $request, Builder $query)
    {
        foreach ($request->all() as $filterName => $value) {

            $decorator = $this->createFilterDecorator($filterName);

            if ($this->isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }
        return $query;
    }

    private function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\'.$this->name().'\\' .
            str_replace(' ', '',
                ucwords(str_replace('_', ' ', $name)));
    }

    private function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    private function getResults(Builder $query)
    {
        return $query->get();
    }
}