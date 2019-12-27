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
/* CONTROLADOR CALENDARIO                        */
/* --------------------------------------------- */

Route::get('/calendario', 'ControladorCalendario@index');
Route::post('fullcalendar/create','FullCalendarController@create');
Route::post('fullcalendar/update','FullCalendarController@update');
Route::post('fullcalendar/delete','FullCalendarController@destroy');

/* --------------------------------------------- */
/* TIPO DE CLIENTES                              */
/* --------------------------------------------- */

Route::get('configuracion/tipodecliente/nuevo', 'ControladorTipoCliente@nuevo');
Route::post('configuracion/tipodecliente/nuevo', 'ControladorTipoCliente@guardar');
Route::get('/configuracion/tipodeclientes', 'ControladorTipocliente@index');
Route::get('/configuracion/tipodeclientes/cargargrilla', 'ControladorTipoCliente@cargarGrilla')->name('tipodeclientes.cargarGrilla');
Route::get('/configuracion/tipodecliente/nuevo/{id}', 'ControladorTipoCliente@editar');
Route::post('/configuracion/tipodecliente/nuevo/{id}', 'ControladorTipoCliente@guardar');
Route::get('/configuracion/tipodecliente/eliminar', 'ControladorTipoCliente@eliminar');

/* --------------------------------------------- */
/* CONTROLADOR CALCULO DE VACACIONES             */
/* --------------------------------------------- */

Route::get('/tramite/calculo_vacaciones','ControladorCalculoVacaciones@nuevo');
Route::post('/tramite/calculo_vacaciones','ControladorCalculoVacaciones@guardar');
Route::get('/tramite/calculo_vacacionescargarGrilla', 'ControladorCalculoVacaciones@cargarGrilla')->name('calculovacaciones.cargarGrilla');
Route::get('/tramite/calculo_vacaciones/{id}','ControladorCalculoVacaciones@editar');


Route::get('/tramite/autorizacion_viaje', 'ControladorAutorizacionViaje@nuevo');
Route::get('/tramite/autorizacion_viaje', 'ControladorAutorizacionViaje@guardar');
Route::get('/tramite/cargarGrilla', 'ControladorAutorizacionViaje@cargarGrilla')->name('menu.cargarGrilla');
Route::get('/tramite/autorizacionviaje', 'ControladorAutorizacionViaje@nuevo');
Route::get('/tramite/autorizacionviaje', 'ControladorAutorizacionViaje@guardar');

/* --------------------------------------------- */
/* CONTROLADOR CALCULO DE UTILIDADES             */
/* --------------------------------------------- */

Route::get('/tramite/calculo_utilidades', 'ControladorCalculoUtlidades@nuevo');
Route::post('/tramite/calculo_utilidades', 'ControladorCalculoUtlidades@guardar');
Route::get('/tramite/calculo_utilidades', 'ControladorCalculoUtlidades@cargarGrilla')->name('CalculodeUtilidades.cargarGrilla');
Route::get('/tramite/calculo_utilidades/{id}','ControladorCalculoUtlidades@editar');
/* --------------------------------------------- */
/* CONTROLADOR AUTORIZACION DE VIAJE             */
/* --------------------------------------------- */

Route::get('/tramite/autorizacion_viaje', 'ControladorAutorizacionViajes@nuevo');
Route::post('/tramite/autorizacion_viaje', 'ControladorAutorizacionViajes@guardar');
Route::get('/tramite/autorizacion_viajecargarGrilla', 'ControladorAutorizacionViajes@cargarGrilla')->name('autorizacionviajes.cargarGrilla');
Route::get('/tramite/autorizacion_viaje/{id}','ControladorAutorizacionViajes@editar');


/* --------------------------------------------- */
/* CONTROLADOR CLIENTE                           */
/* --------------------------------------------- */

Route::get('/cliente/nuevo', 'ControladorCliente@nuevo');
Route::post('/cliente/nuevo', 'ControladorCliente@guardar');
Route::get('/cliente/listar', 'ControladorCliente@index');
Route::get('/cliente/listar/cargarGrilla', 'ControladorCliente@cargarGrilla')->name('cliente.cargarGrilla');
Route::get('/cliente/nuevo/{id}', 'ControladorCliente@editar');
Route::post('/cliente/nuevo/{id}', 'ControladorCliente@guardar');
Route::get('/cliente/nuevo/eliminar', 'ControladorCliente@eliminar');

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
Route::get('/configuracion/formulario/eliminar', 'ControladorConfiguracionFormularios@eliminar');

/* --------------------------------------------- */
/* CONTROLADOR PODERES ESPECIALES                */
/* --------------------------------------------- */

Route::get('/tramite/poderes_especiales','ControladorPoderesEspeciales@nuevo');
Route::post('/tramite/poderes_especiales','ControladorPoderesEspeciales@guardar');
Route::get('/tramite/poderes_especiales','ControladorPoderesEspeciales@guardar');
Route::get('/tramite/poderes_especialescargarGrilla', 'ControladorPoderesEspeciales@cargarGrilla')->name('poderesespeciales.cargarGrilla');
Route::get('/tramite/poderes_especiales/{id}','ControladorPoderesEspeciales@editar');
Route::post('/tramite/poderes_especiales/{id}','ControladorPoderesEspeciales@editar');

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

Route::get('/tramites/borrador','ControladorTramitesEnBorrador@index');
Route::get('/tramites/borrador/cargarGrilla', 'ControladorTramitesEnBorrador@cargarGrilla')->name('tramitesenborrador.cargarGrilla');

Route::get('/tramite/tramiteProcesar','ControladorTramitesIniciados@tramiteProcesar');
Route::get('/tramite/tramiteFinalizar','ControladorTramitesIniciados@tramiteFinalizar');
Route::get('/tramite/tramiteAnular','ControladorTramitesIniciados@tramiteAnular');
Route::get('/tramite/tramiteRechazar','ControladorTramitesIniciados@tramiteRechazar');



});