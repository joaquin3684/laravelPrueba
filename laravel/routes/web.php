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

use App\Repositories\Eloquent\Cobranza\CobrarPorSocio;
use App\Repositories\Eloquent\Mapper\SociosMapper;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Repositories\Eloquent\Socio;
use App\Ventas;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});
Route::get('creacionAutomatica', function(){
    $user = Sentinel::registerAndActivate(array('usuario'=>'1', 'email'=>'1', 'password'=> '1'));
    $role = Sentinel::getRoleRepository()->createModel()->create([
        'name' => 'genio',
        'slug' => 'genio',
    ]);
    $role->permissions = ['organismos.crear' => true, 'organismos.visualizar' => true, 'organismos.editar' => true, 'organismos.borrar'=> true, 'socios.editar' => true, 'socios.visualizar' => true, 'socios.crear' => true, 'socios.borrar' => true];
    $role->save();
    $role->users()->attach($user);
    \App\Prioridades::create(['nombre' => 'alta', 'orden' => '1']);
    \App\Prioridades::create(['nombre' => 'baja', 'orden' => '2']);

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
Route::post('cobrar/mostrarPorVenta', 'CobrarController@mostrarPorVenta');
Route::post('cobrar/cobroPorVenta', 'CobrarController@cobrarPorVenta');

Route::get('prioridades/datos', 'ABM_prioridades@datos');
Route::post('prioridades/guardarConfiguracion', 'ABM_prioridades@guardarConfiguracion');
Route::get('proovedores/traerRelacionproovedores', 'ABM_proovedores@traerRelacion');
Route::get('prioridades/traerRelacionprioridades', 'ABM_prioridades@traerRelacion');
Route::get('aprobacion', 'AprobacionServiciosController@index');
Route::get('aprobacion/datos', 'AprobacionServiciosController@datos');
Route::post('aprobacion/aprobar', 'AprobacionServiciosController@aprobarServicios');
Route::get('pruebas', function(){

    $ventasRepo = new VentasRepo();
    $ventas = $ventasRepo->cuotasAPagarProovedor(2);
    $ventas->each(function ($venta) {
        $venta->pagarProovedor();
    });

});

Route::resource('cobrar', 'CobrarController');
Route::resource('proovedores_prioridades', 'PrioridadesProovedores');
Route::resource('prioridades', 'ABM_prioridades');
Route::resource('usuarios', 'ABM_usuarios');
Route::resource('organismos', 'ABM_organismos');
Route::resource('proovedores', 'ABM_proovedores');
Route::resource('asociados', 'ABM_asociados');
Route::resource('roles', 'ABM_roles');
Route::resource('ventas', 'VentasControlador');
Route::resource('productos', 'ABM_productos');
