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
Route::post('productos/TraerProductos', 'ABM_productos@traerProductos');
Route::get('login', 'Login@index');
Route::post('login', 'Login@login');
Route::get('logout', 'Login@logout');
Route::get('roles/traerRelacionroles', 'ABM_roles@traerRelacionpantallas');
Route::get('roles/traerRoles', 'ABM_roles@traerRoles');
Route::get('proovedores/datos', 'ABM_proovedores@datos');
Route::post('movimientos/datos', 'MovimientosControlador@datos');
Route::post('movimientos/datosAutocomplete', 'MovimientosControlador@traerDatosAutocomplete');
Route::post('movimientos/saldo', 'MovimientosControlador@saldo');
Route::get('cobranza', 'CobranzaController@index');
Route::post('cobranza/datos', 'CobranzaController@datos');
Route::post('cobranza/datosAutocomplete', 'CobranzaController@traerDatosAutocomplete');
Route::get('pago_proovedores', 'PagoProovedoresController@index');
Route::post('pago_proovedores/datos', 'PagoProovedoresController@datos');
Route::post('pago_proovedores/datosAutocomplete', 'PagoProovedoresController@traerDatosAutocomplete');
Route::post('pago_proovedores/pagarCuotas', 'PagoProovedoresController@pagarCuotas');
Route::post('cobrar/datos', 'CobrarController@datos');
Route::post('cobrar/datosAutocomplete', 'CobrarController@traerDatosAutocomplete');
Route::post('cobrar/cobrarCuotas', 'CobrarController@cobrarCuotas');


Route::resource('usuarios', 'ABM_usuarios');
Route::resource('organismos', 'ABM_organismos');
Route::resource('proovedores', 'ABM_proovedores');
Route::resource('asociados', 'ABM_asociados');
Route::resource('roles', 'ABM_roles');
Route::resource('movimientos', 'MovimientosControlador');
Route::resource('cobrar', 'CobrarController');