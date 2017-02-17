<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('abm/mostrarRegistros', 'Prueba@mostrarRegistros');
Route::get('organismos/traerRelacionorganismos', 'ABM_organismos@traerRelacionorganismos');
Route::get('asociados/traerDatos', 'ABM_asociados@traerDatos');
Route::get('dar_servicio', 'Dar_Servicio@index');
Route::post('dar_servicio/filtroSocios', 'Dar_Servicio@sociosQueCumplenConFiltro');
Route::post('dar_servicio/filtroProovedores', 'Dar_Servicio@proovedoresQueCumplenConFiltro');


Route::resource('organismos', 'ABM_organismos');
Route::resource('proovedores', 'ABM_proovedores');
Route::resource('asociados', 'ABM_asociados');