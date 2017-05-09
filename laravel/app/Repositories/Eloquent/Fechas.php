<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/05/17
 * Time: 19:26
 */

namespace App\Repositories\Eloquent;
use Carbon\Carbon;

class Fechas
{
    private $hoy;

    public function __construct()
    {
        $carbon = new Carbon();
        $this->hoy = $carbon->today()->toDateString();
    }

    public function getFechaHoy()
    {
        return $this->hoy;
    }
}