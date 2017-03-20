<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Socios extends Model
{
 	use SoftDeletes;
	
    protected $fillable = [
        'nombre', 'fecha_nacimiento', 'cuit', 'dni', 'domicilio', 'localidad', 'codigo_postal', 'telefono', 'id_organismo', 'legajo', 'fecha_ingreso', 'grupo_familiar'];

    protected $dates = ['deleted_at'];

    public function organismo()
    {
    	return $this->belongsTo('App\Organismos', 'id_organismo', 'id')->withTrashed();
    }

    public function movimientos()
    {
    	return $this->hasMany('App\Movimientos', 'id_asociado', 'id');
    }
}
