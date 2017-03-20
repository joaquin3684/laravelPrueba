<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Productos extends Model
{
    use SoftDeletes;
	
    protected $fillable = [
        'id_proovedor', 'descripcion', 'precio', 'retencion', 'nombre'
    ];

    protected $dates = ['deleted_at'];

     public function movimientos()
    {
    	return $this->hasMany('App\Movimientos', 'id_asociado', 'id');
    }
}