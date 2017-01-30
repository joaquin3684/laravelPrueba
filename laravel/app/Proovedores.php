<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Proovedores extends Model
{
    use SoftDeletes;
	
    protected $fillable = [
        'nombre', 'descripcion', 'porcentaje_retencion', 'porcentaje_gastos_administrativos'
    ];

    protected $dates = ['deleted_at'];
}
