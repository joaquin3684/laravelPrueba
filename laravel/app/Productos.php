<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Productos extends Model
{
    use SoftDeletes;
	//TODO: hay que agregarle el tipo de producto (credito o producto) y cambiarlo en la base de datos
    protected $fillable = [
        'id_proovedor', 'descripcion', 'gastos_administrativos', 'ganancia', 'nombre'
    ];

    protected $dates = ['deleted_at'];

    public function proovedor()
    {
        return $this->belongsTo('App\Proovedores', 'id_proovedor', 'id');
    }

    public function movimientos()
    {
    	return $this->hasMany('App\Movimientos', 'id_producto', 'id');
    }
}
