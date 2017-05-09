<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Movimientos extends Model
{
   	use SoftDeletes;

	protected $fillable = [
        'id_cuota', 'entrada', 'salida', 'fecha', 'nro_cuota'
    ];

    protected $dates = ['deleted_at'];

    public function ventas()
    {
    	return $this->belongsTo('App\Cuotas', 'id_cuota', 'id');
    }
}
