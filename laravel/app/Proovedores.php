<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Proovedores extends Model
{
    use SoftDeletes;
	
    protected $fillable = [
        'nombre', 'descripcion', 'porcentaje_retencion', 'porcentaje_gastos_administrativos', 'id_prioridad'
    ];

    protected $dates = ['deleted_at'];

       public function prioridad()
    {
    	return $this->belongsTo('App\Prioridades', 'id_prioridad', 'id');
    }

    public function productos()
    {
        return $this->hasMany('App\Productos', 'id_proovedor', 'id');
    }
}
