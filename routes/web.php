<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

  Route::group(array('domain' => 'sistema'), function()
{

Route::get('/', 'ControladorHome@index');
Route::get('/home', 'ControladorHome@index');

/* --------------------------------------------- */
/* CONTROLADOR LOGIN                             */
/* --------------------------------------------- */

Route::get('/login', 'ControladorLogin@index');
Route::get('/logout', 'ControladorLogin@logout');
Route::post('/logout', 'ControladorLogin@entrar');
Route::post('/login', 'ControladorLogin@entrar');


/* --------------------------------------------- */
/* CONTROLADOR RECUPERO CLAVE                    */
/* --------------------------------------------- */

Route::get('/recupero-clave', 'ControladorRecuperoClave@index');
Route::post('/recupero-clave', 'ControladorRecuperoClave@recuperar');

/* --------------------------------------------- */
/* CONTROLADOR PERMISO                           */
/* --------------------------------------------- */

Route::get('/usuarios/cargarGrillaFamiliaDisponibles', 'ControladorPermiso@cargarGrillaFamiliaDisponibles')->name('usuarios.cargarGrillaFamiliaDisponibles');
Route::get('/usuarios/cargarGrillaFamiliasDelUsuario', 'ControladorPermiso@cargarGrillaFamiliasDelUsuario')->name('usuarios.cargarGrillaFamiliasDelUsuario');
Route::get('/permisos', 'ControladorPermiso@index');
Route::get('/permisos/cargarGrilla', 'ControladorPermiso@cargarGrilla')->name('permiso.cargarGrilla');
Route::get('/permiso/nuevo', 'ControladorPermiso@nuevo');
Route::get('/permiso/cargarGrillaPatentesPorFamilia', 'ControladorPermiso@cargarGrillaPatentesPorFamilia')->name('permiso.cargarGrillaPatentesPorFamilia');
Route::get('/permiso/cargarGrillaPatentesDisponibles', 'ControladorPermiso@cargarGrillaPatentesDisponibles')->name('permiso.cargarGrillaPatentesDisponibles');
Route::get('/permiso/{idpermiso}', 'ControladorPermiso@editar');
Route::post('/permiso/{idpermiso}', 'ControladorPermiso@guardar');

/* --------------------------------------------- */
/* CONTROLADOR GRUPO                             */
/* --------------------------------------------- */

Route::get('/grupos', 'ControladorGrupo@index');
Route::get('/usuarios/cargarGrillaGruposDelUsuario', 'ControladorGrupo@cargarGrillaGruposDelUsuario')->name('usuarios.cargarGrillaGruposDelUsuario'); //otra cosa
Route::get('/usuarios/cargarGrillaGruposDisponibles', 'ControladorGrupo@cargarGrillaGruposDisponibles')->name('usuarios.cargarGrillaGruposDisponibles'); //otra cosa
Route::get('/grupos/cargarGrilla', 'ControladorGrupo@cargarGrilla')->name('grupo.cargarGrilla');
Route::get('/grupo/nuevo', 'ControladorGrupo@nuevo');
Route::get('/grupo/setearGrupo', 'ControladorGrupo@setearGrupo');
Route::post('/grupo/nuevo', 'ControladorGrupo@guardar');
Route::get('/grupo/{idgrupo}', 'ControladorGrupo@editar');
Route::post('/grupo/{idgrupo}', 'ControladorGrupo@guardar');

/* --------------------------------------------- */
/* CONTROLADOR USUARIO                           */
/* --------------------------------------------- */

Route::get('/usuarios', 'ControladorUsuario@index');
Route::get('/usuarios/nuevo', 'ControladorUsuario@nuevo');
Route::post('/usuarios/nuevo', 'ControladorUsuario@guardar');
Route::post('/usuarios/{usuario}', 'ControladorUsuario@guardar');
Route::get('/usuarios/cargarGrilla', 'ControladorUsuario@cargarGrilla')->name('usuarios.cargarGrilla');
Route::get('/usuarios/buscarUsuario', 'ControladorUsuario@buscarUsuario');
Route::get('/usuarios/{usuario}', 'ControladorUsuario@editar');

/* --------------------------------------------- */
/* CONTROLADOR MENU                             */
/* --------------------------------------------- */

Route::get('/sistema/menu', 'ControladorMenu@index');
Route::get('/sistema/menu/nuevo', 'ControladorMenu@nuevo');
Route::post('/sistema/menu/nuevo', 'ControladorMenu@guardar');
Route::get('/sistema/menu/cargarGrilla', 'ControladorMenu@cargarGrilla')->name('menu.cargarGrilla');
Route::get('/sistema/menu/eliminar', 'ControladorMenu@eliminar');
Route::get('/sistema/menu/{id}', 'ControladorMenu@editar');
Route::post('/sistema/menu/{id}', 'ControladorMenu@guardar');
Route::get('/sistema/menu/{id}', 'ControladorMenu@editar');

/* --------------------------------------------- */
/* TIPOS DE CLIENTES- NUEVO TIPO DE CLIENTES                             */
/* --------------------------------------------- */
Route::get('configuracion/cliente/nuevo', 'ControladorTipoCliente@nuevo');
Route::post('configuracion/cliente/nuevo', 'ControladorTipoCliente@guardar');
Route::get('/configuracion/clientes', 'ControladorTipoCliente@cargarGrilla')->name('TipoCliente.cargarGrilla');

/* CONTROLADOR CALCULO DE UTILIDADES             */
/* --------------------------------------------- */

Route::get('/tramite/calculo_utilidades', 'ControladorCalculoUtlidades@nuevo');
Route::post('/tramite/calculo_utilidades', 'ControladorCalculoUtlidades@guardar');

/* --------------------------------------------- */
/* CONTROLADOR AUTORIZACION DE VIAJE             */
/* --------------------------------------------- */

Route::get('/tramite/autorizacion_viaje', 'ControladorAutorizacionViajes@nuevo');
Route::post('/tramite/autorizacion_viaje', 'ControladorAutorizacionViajes@guardar');
Route::get('/tramite/cargarGrilla', 'ControladorAutorizacionViajes@cargarGrilla')->name('autorizacionviaje.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR CLIENTE                           */
/* --------------------------------------------- */

Route::get('/cliente/nuevo', 'ControladorCliente@nuevo');
Route::post('/cliente/nuevo', 'ControladorCliente@guardar');
Route::get('/cliente/listar', 'ControladorCliente@index');
Route::get('/cliente/listar/cargarGrilla', 'ControladorCliente@cargarGrilla')->name('cliente.cargarGrilla');
Route::get('/clientes', 'ControladorCliente@cargarGrilla')->name('clientes.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR CONFIGURACION                     */
/* --------------------------------------------- */

Route::get('/configuracion/formularios', 'ControladorConfiguracionFormularios@index');
Route::get('/configuracion/formulario/nuevo', 'ControladorConfiguracionFormularios@nuevo');
Route::post('/configuracion/formulario/nuevo', 'ControladorConfiguracionFormularios@guardar');
Route::get('/configuracion/formulario/cargarGrilla', 'ControladorconfiguracionFormularios@cargarGrilla')->name('formulario.cargarGrilla');
Route::get('/configuracion/formulario/nuevo/eliminar', 'ControladorConfiguracionFormularios@eliminar');
Route::get('/configuracion/formulario/nuevo/{id}', 'ControladorConfiguracionFormularios@editar');
Route::post('/configuracion/formulario/nuevo/{id}', 'ControladorConfiguracionFormularios@guardar');
Route::get('/configuracion/formulario/nuevo/{id}', 'ControladorConfiguracionFormularios@editar');


/* --------------------------------------------- */
/* CONTROLADOR PODERES ESPECIALES                */
/* --------------------------------------------- */

Route::get('/tramite/poderes_especiales','ControladorPoderesEspeciales@nuevo');
Route::post('/tramite/poderes_especiales','ControladorPoderesEspeciales@guardar');
Route::get('/tramite/poderes_especialescargarGrilla', 'ControladorPoderesEspeciales@cargarGrilla')->name('poderesespeciales.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR NUEVO TRAMITE                     */
/* --------------------------------------------- */

Route::get('/tramite/nuevo', 'ControladorTramiteNuevo@index');
Route::get('/tramite/nuevo', 'ControladorTramiteNuevo@nuevo');

/* --------------------------------------------- */
/* CONTROLADOR ESTADO DE TRAMITE                 */
/* --------------------------------------------- */

Route::get('/tramites/iniciados', 'ControladorTramitesIniciados@index');
Route::get('/tramites/iniciados/cargarGrilla', 'ControladorTramitesIniciados@cargarGrilla')->name('tramitesiniciados.cargarGrilla');

Route::get('/tramites/finalizados', 'ControladorTramitesFinalizados@index');
Route::get('/tramites/finalizados/cargarGrilla', 'ControladorTramitesFinalizados@cargarGrilla')->name('tramitesfinalizados.cargarGrilla');

Route::get('/tramites/enproceso','ControladorTramitesEnProceso@index');
Route::get('/tramites/enproceso/cargarGrilla', 'ControladorTramitesEnProceso@cargarGrilla')->name('tramitesenproceso.cargarGrilla');

});