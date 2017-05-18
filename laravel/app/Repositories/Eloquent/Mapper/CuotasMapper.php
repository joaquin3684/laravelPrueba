<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 19:30
 */

namespace App\Repositories\Eloquent\Mapper;
use App\Repositories\Eloquent\Movimiento;
use App\Cuotas;

class CuotasMapper
{
    private $idCuota;

    public function __construct($idCuota = null)
    {
        $this->idCuota = $idCuota;
    }

    public function movimientos()
    {
        $movimientos = Cuotas::find($this->idCuota)->movimientos();
        $collection = collect();
        $movimientos->each(function ($item) use($collection){
            $a = new Movimiento($item->id, $item->id_cuota, $item->entrada, $item->salida, $item->fecha);
            $collection->push($a);
        });
        return $collection;
    }



}