<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Cuotas extends Model
{
    use SoftDeletes;

	protected $fillable = [
        'id_movimiento', 'importe', 'pago', 'fecha_pago', 'nro_cuota'
    ];

    protected $dates = ['deleted_at'];

    public function movimiento()
    {
    	return $this->belongsTo('App\Movimientos', 'id_movimiento', 'id');
    }
}
