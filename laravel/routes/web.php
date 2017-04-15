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
Route::post('ventas/mostrarPorOrganismo', 'VentasControlador@mostrarPorOrganismo');
Route::post('ventas/datosAutocomplete', 'VentasControlador@traerDatosAutocomplete');
Route::post('ventas/saldo', 'VentasControlador@saldo');
Route::post('ventas/mostrarPorCuotas', 'VentasControlador@mostrarPorCuotas');
Route::post('ventas/mostrarPorVenta', 'VentasControlador@mostrarPorVenta');
Route::post('ventas/mostrarPorSocio', 'VentasControlador@mostrarPorSocio');
Route::get('cobranza', 'CobranzaController@index');
Route::post('cobranza/datos', 'CobranzaController@datos');
Route::post('cobranza/datosAutocomplete', 'CobranzaController@traerDatosAutocomplete');
Route::post('cobranza/porSocio', 'CobranzaController@mostrarPorSocio');
Route::get('pago_proovedores', 'PagoProovedoresController@index');
Route::post('pago_proovedores/datos', 'PagoProovedoresController@datos');
Route::post('pago_proovedores/datosAutocomplete', 'PagoProovedoresController@traerDatosAutocomplete');
Route::post('pago_proovedores/pagarCuotas', 'PagoProovedoresController@pagarCuotas');
Route::post('cobrar/datos', 'CobrarController@datos');
Route::post('cobrar/datosAutocomplete', 'CobrarController@traerDatosAutocomplete');
Route::post('cobrar/cobrarCuotas', 'CobrarController@cobrarCuotas');
Route::post('cobrar/cobroPorPrioridad', 'CobrarController@cobrarPorPrioridad');
Route::post('cobrar/porSocio', 'CobrarController@mostrarPorSocio');
Route::get('prioridades/datos', 'ABM_prioridades@datos');
Route::post('prioridades/guardarConfiguracion', 'ABM_prioridades@guardarConfiguracion');
Route::get('proovedores/traerRelacionproovedores', 'ABM_proovedores@traerRelacion');
Route::get('prioridades/traerRelacionprioridades', 'ABM_prioridades@traerRelacion');

Route::resource('proovedores_prioridades', 'PrioridadesProovedores');
Route::resource('prioridades', 'ABM_prioridades');
Route::resource('usuarios', 'ABM_usuarios');
Route::resource('organismos', 'ABM_organismos');
Route::resource('proovedores', 'ABM_proovedores');
Route::resource('asociados', 'ABM_asociados');
Route::resource('roles', 'ABM_roles');
Route::resource('ventas', 'VentasControlador');
Route::resource('cobrar', 'CobrarController');