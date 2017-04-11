<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Cuotas extends Model
{
    use SoftDeletes;

	protected $fillable = [
        'id_venta', 'importe', 'pago', 'fecha_pago', 'nro_cuota', 'fecha_vencimiento', 'fecha_inicio'
    ];

    protected $dates = ['deleted_at'];

    public function movimiento()
    {
    	return $this->belongsTo('App\Movimientos', 'id_movimiento', 'id');
    }

     public function venta()
    {
    	return $this->belongsTo('App\Ventas', 'id_venta', 'id');
    }
}
