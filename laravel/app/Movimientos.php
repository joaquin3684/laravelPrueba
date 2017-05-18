<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Movimientos extends Model
{
   	use SoftDeletes;

	protected $fillable = [
        'id_cuota', 'entrada', 'salida', 'fecha', 'nro_cuota', 'gastos_administrativos', 'ganancia'
    ];

    protected $dates = ['deleted_at'];

    public function cuotas()
    {
    	return $this->belongsTo('App\Cuotas', 'id_cuota', 'id');
    }
}
