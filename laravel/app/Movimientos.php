<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Movimientos extends Model
{
   	use SoftDeletes;

	protected $fillable = [
        'id_venta', 'entrada', 'salida', 'fecha'
    ];

    protected $dates = ['deleted_at'];

    public function ventas()
    {
    	return $this->belongsTo('App\Ventas', 'id_venta', 'id');
    }
}
