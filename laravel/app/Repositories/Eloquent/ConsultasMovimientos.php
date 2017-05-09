<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 04/05/17
 * Time: 19:55
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\Fechas as Fechas;
use Illuminate\Support\Facades\DB;

class ConsultasMovimientos
{
    private $hoy;

    public function __construct(Fechas $fecha)
    {
        $this->hoy = $fecha->getFechaHoy();
    }

    public function movimientosHastaHoyDeOrganismos()
    {
        $hoy = $this->hoy;
        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('organismos.id')
            ->select('organismos.id AS id_organismo', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))
                        ->get();

        return $movimientos;
    }
    public function movimientosHastaHoyDeSociosDelOrganismo($id)
    {
        $hoy = $this->hoy;
        $movimientos = DB::table('ventas')
            ->join('socios', 'ventas.id_asociado', '=', 'socios.id')
            ->join('cuotas', 'cuotas.id_venta', '=', 'ventas.id')
            ->join('organismos', 'organismos.id', '=', 'socios.id_organismo')
            ->join('movimientos', 'movimientos.id_cuota', '=', 'cuotas.id')
            ->groupBy('socios.id')
            ->select('socios.id AS id_socio', DB::raw('SUM(movimientos.entrada) AS totalCobrado'))
            ->where('organismos.id', '=', $id)
            ->get();
        return $movimientos;
    }
}