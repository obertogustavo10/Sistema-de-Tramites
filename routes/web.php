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


 Route::group(array('domain' => 'autogestion.localhost'), function()
{
	
Route::get('/', 'ControladorAutogestionLogin@indexLogin');
Route::post('/', 'ControladorAutogestionLogin@entrar');
Route::get('/home', 'ControladorAutogestionLogin@home');
Route::get('/sistema/simular-login/{id}', 'ControladorAutogestionLogin@simularIngreso');

Route::get('/constancia-inscripcion', 'ControladorAutogestionConstancia@index');

Route::get('/datospersonales', 'ControladorAutogestionLegajoAlumno@editar');
Route::post('/datospersonales', 'ControladorAutogestionLegajoAlumno@guardar');

Route::get('/carrerasactivas', 'ControladorAutogestionCarrerasActivas@editar');

Route::get('/contacto', 'ControladorAutogestionContactoLogin@index');
Route::post('/contacto', 'ControladorAutogestionContactoLogin@enviar');
Route::get('/contactos', 'ControladorAutogestionContactos@index');
Route::post('/contactos', 'ControladorAutogestionContactos@enviar');

Route::get('/ofertadecursada', 'ControladorAutogestionLogin@index');
Route::get('/logout', 'ControladorAutogestionLogin@logout');
Route::post('/login', 'ControladorAutogestionLogin@entrar');
Route::get('/inscripcion', 'ControladorAutogestionMenuInscripcion@index');
Route::get('/cd-consideraciones', 'ControladorAutogestionCdConsideraciones@index');

Route::get('/cd-inscripcion', 'ControladorAutogestionCdInscripcion@index');
Route::post('/cd-inscripcion', 'ControladorAutogestionCdInscripcion@inscribir');
Route::get('/cd-inscripcion/comprobante/{id}', 'ControladorAutogestionCDPDF@generarComprobante');

Route::get('/historiaacademica', 'ControladorAutogestionHistAcademica@index');
Route::post('/historiaacademica', 'ControladorAutogestionHistAcademica@index');

Route::get('/inscripcion-cd', 'ControladorAutogestionCdInscripcion@index');
Route::get('/nuevo-registro', 'ControladorAutogestionRegistroUsuario@index');
Route::post('/nuevo-registro', 'ControladorAutogestionRegistroUsuario@guardar');
Route::get('/recupero-clave', 'ControladorAutogestionRecuperoClave@index');
Route::post('/recupero-clave', 'ControladorAutogestionRecuperoClave@recuperar');
Route::get('/cambio-clave/{mail}/{id}', 'ControladorAutogestionCambioClave@index');
Route::post('/cambio-clave/{mail}/{id}', 'ControladorAutogestionCambioClave@cambiarClave');


Route::get('/legajo/alumno/cargarGrillaDomicilio', 'ControladorLegajoAlumno@cargarGrillaDomicilio')->name('legajo-alumno.cargarGrillaDomicilio');
Route::get('/publico/pais/buscarProvincia', 'ControladorPais@buscarProvincia');

});


  Route::group(array('domain' => 'admin.localhost'), function()
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
/* CONTROLADOR SISTEMA OP                        */
/* --------------------------------------------- */
Route::get('/equipo/so', 'ControladorSistemaOp@index');
Route::get('/equipo/so/nuevo', 'ControladorSistemaOp@nuevo');
Route::post('/equipo/so/nuevo', 'ControladorSistemaOp@guardar');
Route::get('/equipo/so/cargarGrilla', 'ControladorSistemaOp@cargarGrilla')->name('so.cargarGrilla');
Route::get('/equipo/so/eliminar', 'ControladorSistemaOp@eliminar');
Route::get('/equipo/so/{so}', 'ControladorSistemaOp@editar');
Route::post('/equipo/so/{so}', 'ControladorSistemaOp@guardar');

/* --------------------------------------------- */
/* CONTROLADOR DEPENDENCIA                       */
/* --------------------------------------------- */
Route::get('/publico/dependencias', 'ControladorDependencia@index');
Route::get('/publico/dependencias/cargarGrilla', 'ControladorDependencia@cargarGrilla')->name('dependencia.cargarGrilla');
Route::get('/publico/dependencia/nuevo', 'ControladorDependencia@nuevo');
Route::post('/publico/dependencia/nuevo', 'ControladorDependencia@guardar');
Route::get('/publico/dependencia/eliminar', 'ControladorDependencia@eliminar');
Route::get('/publico/dependencia/{id}', 'ControladorDependencia@editar');
Route::post('/publico/dependencia/{id}', 'ControladorDependencia@guardar');

/* --------------------------------------------- */
/* CONTROLADOR INCIDENTE                         */
/* --------------------------------------------- */
Route::get('/incidentes', 'ControladorIncidente@index');
Route::get('/incidentes/cargarGrilla', 'ControladorIncidente@cargarGrilla')->name('incidente.cargarGrilla');
Route::get('/incidente/nuevo', 'ControladorIncidente@nuevo');
Route::get('/incidente/setearIncidente', 'ControladorIncidente@setearIncidente');
Route::post('/incidente/nuevo', 'ControladorIncidente@guardar');
Route::get('/incidente/rechazar_solucion', 'ControladorIncidente@rechazarSolucion');
Route::get('/incidente/aprobar_solucion', 'ControladorIncidente@aprobarSolucion');
Route::get('/incidente/enviar_solucion', 'ControladorIncidente@enviarSolucion');
Route::get('/incidente/{idincidente}', 'ControladorIncidente@editar');
Route::post('/incidente/{idincidente}', 'ControladorIncidente@guardar');

/* --------------------------------------------- */
/* CONTROLADOR INCIDENTE CATEGORIA               */
/* --------------------------------------------- */
Route::get('/incidente_categorias', 'ControladorIncidenteCategoria@index');
Route::get('/incidente_categoria/nuevo', 'ControladorIncidenteCategoria@nuevo');
Route::post('/incidente_categoria/nuevo', 'ControladorIncidenteCategoria@guardar');
Route::get('/incidente_categorias/cargarGrilla', 'ControladorIncidenteCategoria@cargarGrilla')->name('incidentecategoria.cargarGrilla');
Route::get('/incidente_categoria/eliminar', 'ControladorIncidenteCategoria@eliminar');
Route::get('/incidente_categoria/{id}', 'ControladorIncidenteCategoria@editar');
Route::post('/incidente_categoria/{id}', 'ControladorIncidenteCategoria@guardar');

/* --------------------------------------------- */
/* CONTROLADOR CARGO                             */
/* --------------------------------------------- */
Route::get('/publico/cargo', 'ControladorCargo@index');
Route::get('/publico/cargo/nuevo', 'ControladorCargo@nuevo');
Route::post('/publico/cargo/nuevo', 'ControladorCargo@guardar');
Route::get('/publico/cargo/cargarGrilla', 'ControladorCargo@cargarGrilla')->name('cargo.cargarGrilla');
Route::get('/publico/cargo/eliminar', 'ControladorCargo@eliminar');
Route::get('/publico/cargo/{id}', 'ControladorCargo@editar');
Route::post('/publico/cargo/{id}', 'ControladorCargo@guardar');


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
/* CONTROLADOR PAISES                            */
/* --------------------------------------------- */
Route::get('/publico/paises', 'ControladorPais@index');
Route::get('/publico/pais/nuevo', 'ControladorPais@nuevo');
Route::post('/publico/pais/nuevo', 'ControladorPais@guardar');
Route::get('/publico/pais/cargarGrilla', 'ControladorPais@cargarGrilla')->name('pais.cargarGrilla');
Route::get('/publico/pais/eliminar', 'ControladorPais@eliminar');
Route::get('/publico/pais/buscarProvincia', 'ControladorPais@buscarProvincia');
Route::get('/publico/pais/{id}', 'ControladorPais@editar');
Route::post('/publico/pais/{id}', 'ControladorPais@guardar');

/* --------------------------------------------- */
/* CONTROLADOR TIPO DE DOCUMENTO                 */
/* --------------------------------------------- */
Route::get('/publico/tipodocumento', 'ControladorTipoDocumento@index');
Route::get('/publico/tipodocumento/nuevo', 'ControladorTipoDocumento@nuevo');
Route::post('/publico/tipodocumento/nuevo', 'ControladorTipoDocumento@guardar');
Route::get('/publico/tipodocumento/cargarGrilla', 'ControladorTipoDocumento@cargarGrilla')->name('tipodocumento.cargarGrilla');
Route::get('/publico/tipodocumento/eliminar', 'ControladorTipoDocumento@eliminar');
Route::get('/publico/tipodocumento/{id}', 'ControladorTipoDocumento@editar');
Route::post('/publico/tipodocumento/{id}', 'ControladorTipoDocumento@guardar');

/* --------------------------------------------- */
/* CONTROLADOR SITUACIÓN IMPOSITIVA              */
/* --------------------------------------------- */
Route::get('/publico/situacionimpositiva', 'ControladorSituacionImpositiva@index');
Route::get('/publico/situacionimpositiva/nuevo', 'ControladorSituacionImpositiva@nuevo');
Route::post('/publico/situacionimpositiva/nuevo', 'ControladorSituacionImpositiva@guardar');
Route::get('/publico/situacionimpositiva/cargarGrilla', 'ControladorSituacionImpositiva@cargarGrilla')->name('situacionimpositiva.cargarGrilla');
Route::get('/publico/situacionimpositiva/eliminar', 'ControladorSituacionImpositiva@eliminar');
Route::get('/publico/situacionimpositiva/{id}', 'ControladorSituacionImpositiva@editar');
Route::post('/publico/situacionimpositiva/{id}', 'ControladorSituacionImpositiva@guardar');

/* --------------------------------------------- */
/* CONTROLADOR LEGAJO                             */
/* --------------------------------------------- */

Route::get('/legajo/listado', 'ControladorLegajo@index');
Route::get('/legajo/nuevo', 'ControladorLegajo@nuevo');
Route::post('/legajo/nuevo', 'ControladorLegajo@guardar');
Route::get('/legajo/cargarGrilla', 'ControladorLegajo@cargarGrilla')->name('legajo.cargarGrilla');
Route::get('/legajo/cargarGrillaDomicilio', 'ControladorLegajo@cargarGrillaDomicilio')->name('legajo.cargarGrillaDomicilio');
Route::get('/legajo/cargarGrillTelefono', 'ControladorLegajo@cargarGrillTelefono')->name('legajo.cargarGrillTelefono');
Route::get('/legajo/eliminar', 'ControladorLegajo@eliminar');

Route::get('/legajo/alumnos', 'ControladorLegajoAlumno@index');
Route::get('/legajo/alumno/nuevo', 'ControladorLegajoAlumno@nuevo');
Route::post('/legajo/alumno/nuevo', 'ControladorLegajoAlumno@guardar');
Route::get('/legajo/alumno/cargarGrilla', 'ControladorLegajoAlumno@cargarGrilla')->name('legajo-alumno.cargarGrilla');
Route::get('/legajo/alumno/cargarGrillaDomicilio', 'ControladorLegajoAlumno@cargarGrillaDomicilio')->name('legajo-alumno.cargarGrillaDomicilio');
Route::get('/legajo/alumno/eliminar', 'ControladorLegajoAlumno@eliminar');
Route::get('/legajo/alumno/validarNroDocumento', 'ControladorLegajoAlumno@validarNroDocumento');

Route::get('/legajo/personal', 'ControladorLegajoPersonal@index');
Route::get('/legajo/personal/nuevo', 'ControladorLegajoPersonal@nuevo');
Route::post('/legajo/personal/nuevo', 'ControladorLegajoPersonal@guardar');
Route::get('/legajo/personal/cargarGrilla', 'ControladorLegajoPersonal@cargarGrilla')->name('legajo-personal.cargarGrilla');
Route::get('/legajo/personal/eliminar', 'ControladorLegajoPersonal@eliminar');
Route::get('/legajo/personal/validarNroDocumento', 'ControladorLegajoPersonal@validarNroDocumento');

Route::get('/legajo/{id}', 'ControladorLegajo@editar');
Route::post('/legajo/{id}', 'ControladorLegajo@guardar');
Route::get('/legajo/alumno/{id}', 'ControladorLegajoAlumno@editar');
Route::post('/legajo/alumno/{id}', 'ControladorLegajoAlumno@guardar');
Route::get('/legajo/personal/{id}', 'ControladorLegajoPersonal@editar');
Route::post('/legajo/personal/{id}', 'ControladorLegajoPersonal@guardar');

/* --------------------------------------------- */
/* ACTIVIDADES						             */
/* --------------------------------------------- */
Route::get('/actividad/actividades', 'ControladorActividad@index');
Route::get('/actividad/actividad/nuevo', 'ControladorActividad@nuevo');
Route::post('/actividad/actividad/nuevo', 'ControladorActividad@guardar');
Route::get('/actividad/actividad/cargarGrilla', 'ControladorActividad@cargarGrilla')->name('actividad.cargarGrilla');
Route::get('/actividad/actividad/cargarGrillaSedeActividad', 'ControladorActividad@cargarGrillaSedeActividad')->name('actividad.cargarGrillaSedeActividad');
Route::get('/actividad/actividad/{id}', 'ControladorActividad@editar');
Route::post('/actividad/actividad/{id}', 'ControladorActividad@guardar');

/* --------------------------------------------- */
/* REQUISITOS						             */
/* --------------------------------------------- */
Route::get('/actividad/requisitos', 'ControladorRequisito@index');
Route::get('/actividad/requisito/nuevo', 'ControladorRequisito@nuevo');
Route::post('/actividad/requisito/nuevo', 'ControladorRequisito@guardar');
Route::get('/actividad/requisito/cargarGrilla', 'ControladorRequisito@cargarGrilla')->name('requisito.cargarGrilla');
Route::get('/actividad/requisito/{id}', 'ControladorRequisito@editar');
Route::post('/actividad/requisito/{id}', 'ControladorRequisito@guardar');

/* --------------------------------------------- */
/* PLAN DE ESTUDIO					             */
/* --------------------------------------------- */
Route::get('/actividad/planes', 'ControladorPlanDeEstudio@index');
Route::get('/actividad/plan/nuevo', 'ControladorPlanDeEstudio@nuevo');
Route::post('/actividad/plan/nuevo', 'ControladorPlanDeEstudio@guardar');
Route::get('/actividad/plan/cargarGrilla', 'ControladorPlanDeEstudio@cargarGrilla')->name('plandeestudio.cargarGrilla');
Route::get('/actividad/plan/requisito/cargarGrillaRequisitosDelPlan', 'ControladorPlanRequisito@cargarGrillaRequisitosDelPlan')->name('plandeestudio.cargarGrillaRequisitosDelPlan');
Route::get('/actividad/plan/requisito/cargarGrillaRequisitosDisponibles', 'ControladorPlanRequisito@cargarGrillaRequisitosDisponibles')->name('plandeestudio.cargarGrillaRequisitosDisponibles');
Route::get('/actividad/plan/materias/cargarGrillaMateriasDelPlan', 'ControladorPlanMateria@cargarGrillaMateriasDelPlan')->name('plandeestudio.cargarGrillaMateriasDelPlan');
Route::get('/actividad/plan/materia/obtenerMateriasDelPlan', 'ControladorPlanMateria@obtenerMateriasDelPlan');
Route::get('/actividad/materia/obtenerTodosPorActividadDelPlanAjax', 'ControladorPlanMateria@obtenerTodosPorActividadDelPlanAjax');
Route::get('/actividad/plan/obtenerPlan', 'ControladorPlanDeEstudio@obtenerPlan');
Route::get('/actividad/plan/{id}/materias', 'ControladorPlanMateria@editar');
Route::get('/actividad/plan/{id}/requisitos', 'ControladorPlanRequisito@editar');
Route::get('/actividad/plan/{id}', 'ControladorPlanDeEstudio@editar');
Route::post('/actividad/plan/{id}', 'ControladorPlanDeEstudio@guardar');
Route::post('/actividad/plan/{id}/requisitos', 'ControladorPlanRequisito@guardar');
Route::post('/actividad/plan/{id}/materias', 'ControladorPlanMateria@guardar');

/* --------------------------------------------- */
/* PLAN EQUIVALENCIA					             */
/* --------------------------------------------- */
Route::get('/actividad/plan/equivalencia/cargarGrillaEquivalenciaPorMateriaPorPlan', 'ControladorPlanEquivalencia@cargarGrillaEquivalenciaPorMateriaPorPlan')->name('planequivalencia.cargarGrillaEquivalenciaPorMateriaPorPlan');

/* --------------------------------------------- */
/* MODULOS   						             */
/* --------------------------------------------- */
Route::get('/actividad/modulos', 'ControladorModulo@index');
Route::get('/actividad/modulo/nuevo', 'ControladorModulo@nuevo');
Route::post('/actividad/modulo/nuevo', 'ControladorModulo@guardar');
Route::get('/actividad/modulo/cargarGrilla', 'ControladorModulo@cargarGrilla')->name('modulo.cargarGrilla');
Route::get('/actividad/modulo/agregarModuloAjax', 'ControladorModulo@agregarModuloAjax');
Route::get('/actividad/modulo/obtenerTodosPorPlanAjax', 'ControladorModulo@obtenerTodosPorPlanAjax');
Route::get('/actividad/modulo/{id}', 'ControladorModulo@editar');
Route::post('/actividad/modulo/{id}', 'ControladorModulo@guardar');

/* --------------------------------------------- */
/* MATERIAS 						             */
/* --------------------------------------------- */
Route::get('/actividad/materias', 'ControladorMateria@index');
Route::get('/actividad/materia/nuevo', 'ControladorMateria@nuevo');
Route::post('/actividad/materia/nuevo', 'ControladorMateria@guardar');
Route::get('/actividad/materia/cargarGrilla', 'ControladorMateria@cargarGrilla')->name('materia.cargarGrilla');
Route::get('/actividad/materia/agregarMateriaAjax', 'ControladorMateria@agregarMateriaAjax');
Route::get('/actividad/materia/modificarMateriaAjax', 'ControladorMateria@modificarMateriaAjax');
Route::get('/actividad/materia/obtenerTodosPorPlanAjax', 'ControladorMateria@obtenerTodosPorPlanAjax');
Route::get('/actividad/materia/obtenerMaterias', 'ControladorMateria@obtenerMaterias');
Route::get('/actividad/materia/buscarMateria', 'ControladorMateria@buscarMateria');
Route::get('/actividad/materia/{id}', 'ControladorMateria@editar');
Route::post('/actividad/materia/{id}', 'ControladorMateria@guardar');

/* --------------------------------------------- */
/* SEDES 						                 */
/* --------------------------------------------- */
Route::get('/publico/sedes', 'ControladorSede@index');
Route::get('/publico/sede/nuevo', 'ControladorSede@nuevo');
Route::post('/publico/sede/nuevo', 'ControladorSede@guardar');
Route::get('/publico/sede/cargarGrilla', 'ControladorSede@cargarGrilla')->name('sede.cargarGrilla');
Route::get('/publico/sede/agregarSedeAjax', 'ControladorSede@agregarSedeAjax');
Route::get('/publico/sede/agregarSubSedeAjax', 'ControladorSede@agregarSubSedeAjax');
Route::get('/publico/sede/obtenerTodos', 'ControladorSede@obtenerTodos');
Route::get('/publico/sede/{id}', 'ControladorSede@editar');
Route::post('/publico/sede/{id}', 'ControladorSede@guardar');

/* --------------------------------------------- */
/* OFERTA DE CURSADA 						     */
/* --------------------------------------------- */
Route::get('/previoinscripcion/ofertadecursada', 'ControladorOfertaDeCursada@index');
Route::get('/previoinscripcion/ofertadecursada/nuevo', 'ControladorOfertaDeCursada@nuevo');
Route::post('/previoinscripcion/ofertadecursada/nuevo', 'ControladorOfertaDeCursada@guardar');
Route::get('/previoinscripcion/ofertadecursada/cargarGrilla', 'ControladorOfertaDeCursada@cargarGrilla')->name('oferta.cargarGrilla');
Route::get('/previoinscripcion/ofertadecursada/cargarGrillaOfertaPorPlan', 'ControladorOfertaDeCursada@cargarGrillaOfertaPorPlan')->name('oferta.cargarGrillaOfertaPorPlan');
Route::get('/previoinscripcion/ofertadecursada/{id}', 'ControladorOfertaDeCursada@editar');
Route::post('/previoinscripcion/ofertadecursada/{id}', 'ControladorOfertaDeCursada@guardar');

/* --------------------------------------------- */
/* INSCRIPCION  	                 			 */
/* --------------------------------------------- */
Route::get('/inscripcion/constancia/{idAlumno}', 'ControladorInscripcionConstancia@index');
Route::get('/cd-inscripcion/comprobante/{id}', 'ControladorInscripcionCDPDF@generarComprobante');
Route::get('/seguimiento/inscripciones', 'ControladorInscripciones@index');
Route::get('/seguimiento/obtenerInscripciones', 'ControladorInscripciones@obtenerInscripciones');
Route::get('/seguimiento/inscriptos/cargarGrilla', 'ControladorInscriptos@cargarGrilla')->name('inscriptos-alumnos.cargarGrilla');
Route::get('/seguimiento/inscriptos/{id}', 'ControladorInscriptos@index');
Route::get('/seguimiento/acta/{id}', 'ControladorActa@index');

/* --------------------------------------------- */
/* CERTIFICADOS  	                 			 */
/* --------------------------------------------- */
Route::get('/certificados', 'ControladorCertificado@index');
Route::get('/certificado/cargarGrilla', 'ControladorCertificado@cargarGrilla')->name('certificado.cargarGrilla');
Route::get('/certificado/guardar', 'ControladorCertificado@guardar');
Route::get('/certificado/{idCertificado}', 'ControladorCertificado@obtenerPorId');
});

