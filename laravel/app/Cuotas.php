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

    public function movimientos()
    {
    	return $this->hasMany('App\Movimientos', 'id_cuota', 'id');
    }

     public function venta()
    {
    	return $this->belongsTo('App\Ventas', 'id_venta', 'id');
    }
}
