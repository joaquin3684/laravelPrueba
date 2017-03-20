<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Movimientos extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'id_asociado', 'id_producto', 'descripcion', 'nro_cuotas', 'fecha'
    ];

    protected $dates = ['deleted_at'];

    public function cuotas()
    {
    	return $this->hasMany('App\Cuotas', 'id_movimiento', 'id');
    }

    public function socio()
    {
    	return $this->belongsTo('App\Socios', 'id_asociado', 'id');
    }

    public function producto()
    {
    	return $this->belongsTo('App\Productos', 'id_producto', 'id');
    }
}
