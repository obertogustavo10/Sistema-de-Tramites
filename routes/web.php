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
/* CONTROLADOR LOGIN                           */
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
/* CONFIGURACION                             */
/* --------------------------------------------- */
Route::get('/configuracion/formularios', 'ControladorConfiguracionFormularios@index');
Route::get('/configuracion/formulario/nuevo', 'ControladorConfiguracionFormularios@nuevo');
Route::post('/configuracion/formulario/nuevo', 'ControladorConfiguracionFormularios@guardar');
Route::get('/configuracion/formulario/cargarGrilla', 'ControladorconfiguracionFormularios@cargarGrilla')->name('formulario.cargarGrilla');

/* --------------------------------------------- */
/* CONTROLADOR NUEVO TRAMITE (PODER ESPECIAL)                           */
/* --------------------------------------------- */

Route::get('/tramite/poderes_especiales','ControladorPoderesEspeciales@nuevo');
Route::post('/tramite/poderes_especiales','ControladorPoderesEspeciales@guardar');
Route::get('/tramite/cargarGrilla', 'ControladorPoderesEspeciales@cargarGrilla')->name('poderesespeciales.cargarGrilla');

});

