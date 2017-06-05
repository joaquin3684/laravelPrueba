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

use App\Cuotas;
use App\Repositories\Eloquent\Cobranza\CobrarPorSocio;
use App\Repositories\Eloquent\Cobranza\CobrarPorVenta;
use App\Repositories\Eloquent\Repos\Mapper\SociosMapper;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Repositories\Eloquent\Socio;
use App\Ventas;
use Carbon\Carbon;
use App\Repositories\Eloquent\Filtros\OrganismoFilter;

//--------- INICIO ----------

Route::get('/', function () {
    return view('welcome');
});

//-------------- Creacion automatica de cosas para cuando se hace una migracion ----
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

//-------------- ORGANISMOS -----------

Route::get('organismos/traerRelacionorganismos', 'ABM_organismos@traerRelacionorganismos');
Route::resource('organismos', 'ABM_organismos');

//--------------- SOCIOS -----------------------

Route::resource('asociados', 'ABM_asociados');
Route::get('asociados/traerDatos', 'ABM_asociados@traerDatos');

//---------------- PROVEEDORES ------------------------

Route::resource('proovedores', 'ABM_proovedores');
Route::get('proovedores/datos', 'ABM_proovedores@datos');
Route::get('proovedores/traerRelacionproovedores', 'ABM_proovedores@traerRelacion');

//---------------- PRODUCTOS ----------------

Route::resource('productos', 'ABM_productos');
Route::post('productos/TraerProductos', 'ABM_productos@traerProductos');

//---------------- PRIORIDADES -------------

Route::resource('prioridades', 'ABM_prioridades');
Route::get('prioridades/datos', 'ABM_prioridades@datos');
Route::get('prioridades/traerRelacionprioridades', 'ABM_prioridades@traerRelacion');
Route::post('prioridades/guardarConfiguracion', 'ABM_prioridades@guardarConfiguracion');

//-------------- ROLES --------------------

Route::resource('roles', 'ABM_roles');
Route::get('roles/traerRelacionroles', 'ABM_roles@traerRelacionpantallas');
Route::get('roles/traerRoles', 'ABM_roles@traerRoles');

//---------------- USUARIOS --------------------

Route::resource('usuarios', 'ABM_usuarios');

//-------------- APROBACION SERVICIOS -------------

Route::get('aprobacion', 'AprobacionServiciosController@index');
Route::get('aprobacion/datos', 'AprobacionServiciosController@datos');
Route::post('aprobacion/aprobar', 'AprobacionServiciosController@aprobarServicios');

//------------- DAR SERVICIO -------------------
Route::get('dar_servicio', 'Dar_Servicio@index');
Route::post('dar_servicio/filtroSocios', 'Dar_Servicio@sociosQueCumplenConFiltro');
Route::post('dar_servicio/filtroProovedores', 'Dar_Servicio@proovedoresQueCumplenConFiltro');

//------------ LOGIN ----------------------
Route::get('login', 'Login@index');
Route::get('logout', 'Login@logout');
Route::post('login', 'Login@login');

//-------------- VENTAS -------------------

Route::resource('ventas', 'VentasControlador');
Route::post('ventas/mostrarPorOrganismo', 'VentasControlador@mostrarPorOrganismo');
Route::post('ventas/datosAutocomplete', 'VentasControlador@traerDatosAutocomplete');
Route::post('ventas/saldo', 'VentasControlador@saldo');
Route::post('ventas/mostrarPorCuotas', 'VentasControlador@mostrarPorCuotas');
Route::post('ventas/mostrarPorVenta', 'VentasControlador@mostrarPorVenta');
Route::post('ventas/mostrarPorSocio', 'VentasControlador@mostrarPorSocio');

//-------------- COBRANZA --------------------

Route::get('cobranza', 'CobranzaController@index');
Route::post('cobranza/datos', 'CobranzaController@datos');
Route::post('cobranza/datosAutocomplete', 'CobranzaController@traerDatosAutocomplete');
Route::post('cobranza/porSocio', 'CobranzaController@mostrarPorSocio');

//-------------- PAGO PROVEEDORES -----------

Route::get('pago_proovedores', 'PagoProovedoresController@index');
Route::post('pago_proovedores/datos', 'PagoProovedoresController@datos');
Route::post('pago_proovedores/datosAutocomplete', 'PagoProovedoresController@traerDatosAutocomplete');
Route::post('pago_proovedores/pagarCuotas', 'PagoProovedoresController@pagarCuotas');

//----------------- COBRAR VENTAS ---------------

Route::resource('cobrar', 'CobrarController');
Route::post('cobrar/datos', 'CobrarController@datos');
Route::post('cobrar/datosAutocomplete', 'CobrarController@traerDatosAutocomplete');
Route::post('cobrar/cobrarCuotas', 'CobrarController@cobrarCuotas');
Route::post('cobrar/cobroPorPrioridad', 'CobrarController@cobrarPorPrioridad');
Route::post('cobrar/porSocio', 'CobrarController@mostrarPorSocio');
Route::post('cobrar/mostrarPorVenta', 'CobrarController@mostrarPorVenta');
Route::post('cobrar/cobroPorVenta', 'CobrarController@cobrarPorVenta');

//----------------- CC CUOTAS SOCIALES ----------------

Route::get('cc_cuotasSociales', 'CC_CuotasSocialesController@index');
Route::post('cc_cuotasSociales/mostrarOrganismos', 'CC_CuotasSocialesController@mostrarPorOrganismos');
Route::post('cc_cuotasSociales/mostrarSocios', 'CC_CuotasSocialesController@mostrarPorSocios');
Route::post('cc_cuotasSociales/mostrarCuotas', 'CC_CuotasSocialesController@mostrarPorCuotas');

//----------------- COBRO CUOTAS SOCIALES ----------------------

Route::get('cobroCuotasSociales', 'CobroCuotasSocialesController@index');
Route::post('cobroCuotasSociales/cobrar', 'CobroCuotasSocialesController@cobrar');

//---------------- PRUEBAS ------------------------------

Route::get('pruebas', function(){


   // $cu = Cuotas::with('movimientos')->has('movimientos')->get();
    $ventasRepo = new VentasRepo();
    $ventaCuotasVencidas = $ventasRepo->cuotasVencidas(1);

    $cobrar = new CobrarPorVenta();
    $cobrar->cobrar($ventaCuotasVencidas, 30);
    return 1;

/*
    $request = ['nombre' => ''];
    $organismo = new OrganismoFilter();
    $organismo = $organismo->apply($request);
        


   /* $user = Sentinel::getUser()->id;


        $estadoRepo = new EstadoVentaRepo();
        $estadoRepo->create(['id_venta' => 6, 'id_responsable_estado' => 1, 'estado' => 'APROBADO', 'observacion' => 'HOLA']);

            $cuotaRepo = new CuotasRepo();
            $ventasRepo = new VentasRepo();
            $venta = $ventasRepo->find(6);
            $fecha = $venta->getFechaVencimiento();
            $carbon = Carbon::createFromFormat('Y-m-d', $fecha);
            $fechaHoy = Carbon::today();
            $importeCuota = $venta->getImporte() / $venta->getNroCuotas();

            for ($i = 1; $venta->getNroCuotas() >= $i; $i++) {
                $cuotaRepo->create(['nro_cuota' => $i, 'importe' => $importeCuota, 'id_venta' => $venta->getId(), 'fecha_vencimiento' => $carbon->toDateString(), 'fecha_inicio' => $fechaHoy->toDateString()]);

                $fechaHoy = Carbon::create($carbon->year, $carbon->month, $carbon->day);
                $carbon->addMonth();
            }




*/
/*
    $ventasRepo = new VentasRepo();
    $ventas = $ventasRepo->cuotasAPagarProovedor(2);
    $ventas->each(function ($venta) {
        $venta->pagarProovedor();
    });*/

});


