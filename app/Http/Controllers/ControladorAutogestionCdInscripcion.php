<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Actividad\PlanEquivalencia;
use App\Entidades\Actividad\Materia;
use App\Entidades\Actividad\PlanGrupo;
use App\Entidades\Actividad\PlanMateria;
use App\Entidades\Cursada\AlumnoInscripcion;
use App\Entidades\Cursada\OfertaCursada;
use App\Entidades\Cursada\AlumnoMateria;
use App\Entidades\Cursada\FormuCabecera;
use App\Entidades\Cursada\FormuDetalle;

require app_path().'/start/constants.php';
use Session;
use DateTime;

class ControladorAutogestionCdInscripcion extends Controller {

    public function index(Request $request){
    	if(Usuario::autogestionAutenticado() == true){
    		$array_carreraactiva = $array_oferta = $plan_cd_activo = $array_oferta_yainscripta = $array_materias_aprobadas = array();

			$entidad = new AlumnoInscripcion();
			$plan_cd_activo =  $entidad->obtenerCarreraDocenteActivaPorAlumno(Session::get('alumno_id'));

			if(isset($plan_cd_activo)){
				$titulo = "Carrera docente (Plan: " . $plan_cd_activo->descplan . ")";

				$entidad = new OfertaCursada();
				$aOferta =  $entidad->obtenerOfertaCarreraDocenteActivaPorPlan($plan_cd_activo->fk_idplan);

                //************************************************
                //Materias aprobadas
                //************************************************
				$alumateria = new AlumnoMateria();
                $aMateriasAprobadas = $alumateria->obtenerMateriasAprobadasDelAlumno(Session::get('alumno_id'));
				if(count($aMateriasAprobadas)>0)
                    foreach($aMateriasAprobadas as $materia){
                        if($materia->fk_idplan == $plan_cd_activo->fk_idplan)
                            $array_materias_aprobadas[] = $alumateria->obtenerMateriaPorPlan($materia->fk_idplan, $materia->idmateria, Session::get('alumno_id'));
                        else {
                            //Busca el nombre de la materia por equivalencia
                            $planEquivalencia = new PlanEquivalencia();
                            $aEquivalencia = $planEquivalencia->obtenerSupraEquivalenciaPorPlanPorMateria($materia->fk_idplan, $plan_cd_activo->fk_idplan, $materia->idmateria);
                            
                            if(count($aEquivalencia)>0){
                                foreach($aEquivalencia as $equivalencia){
                                    $entidadMateria = new Materia();
                                    $entidadMateria->obtenerPorId($equivalencia->fk_idmateria);

                                    $materiaAux = new AlumnoMateria();
                                    $materiaAux->idmateria = $entidadMateria->idmateria;
                                    $materiaAux->descmateria = $entidadMateria->descmateria . " (Por Equiv. ". $materia->descmateria . " )";
                                    $materiaAux->nota_alumno = $materia->nota_alumno;
                                    $materiaAux->nota_descalumno = $materia->nota_descalumno;
                                    $materiaAux->nota_minima = $materia->nota_minima;
                                    $materiaAux->fechaacta = $materia->fechaacta;
                                    $materiaAux->libro = $materia->libro;
                                    $materiaAux->folio = $materia->folio;
                                    $materiaAux->resolucionexime = $materia->resolucionexime;
                                    $materiaAux->expedienteexime = $materia->expedienteexime;
                                    $materiaAux->fecharesolexime = $materia->fecharesolexime;
                                    $materiaAux->cargahorariaenhs = $materia->cargahorariaenhs;
                                    $materiaAux->fk_idplan = $plan_cd_activo->fk_idplan;
                                    $materiaAux->resolucion = $materia->resolucion;
                                    $array_materias_aprobadas[] = $materiaAux;
                                    unset($materiaAux);
                                }
                            }
                        }
                    }

                //************************************************
                //Materias ya inscripto para esta inscripcion
                //************************************************
				$array_oferta_yainscripta = $entidad->obtenerOfertaCarreraDocenteInscriptoPorAlumno(Session::get('usuarioalu'));


                //************************************************
                //Muestra la oferta quitando las materias ya aprobadas y controla cupo
                //************************************************
         
				$array_oferta = array();
				if(count($aOferta)>0)
					foreach($aOferta as $item){
						//Agrega las materias ofertadas salvo las que ya aprobó
						$aprobada = false;
						if(count($array_materias_aprobadas)>0)
							foreach($array_materias_aprobadas as $materia){
								if($item->fk_idmateria == $materia->idmateria)
									$aprobada = true;
							}

						if(!$aprobada){
			          		//************************************************
			                //Evalua si la materia abre inscripcion como materia individual o modulo
			                //0-Automática (no abre inscripción, pega todas las materias)
			                //1-Grupo (inscribe al grupo y le pega todas las materias de ese grupo)
			                //2-Individual (inscribe a las materias)
			                //************************************************

							//Controla que haya cupo disponible para la oferta
							$entidadPlanMateria = new PlanMateria();
							$cantidadInscriptos = $entidad->cantidadDeAlumnosInscriptos($plan_cd_activo->fk_idplan, $item->idcursada);
							if($cantidadInscriptos < $item->vacantestotales){
								if(!isset($array_oferta[$item->fk_idgrupo])){
									$array_oferta[$item->fk_idgrupo] = array(
										"grupo" => $item->descgrupo,
										"abreinscripcion" => $item->abreinscripcion,
										"materia" => array(
											$item->fk_idmateria => array("descmateria" => $item->descmateria,
																		 "cursada" =>  array($item->idcursada => 
																		 					array("dia" => $item->descdia." ".$item->horainiciocursada." hs. a ".$item->horafincursada." hs. (".$item->apellido . " " . $item->nombre.") Sede: ". $item->descsede,
																							"sinvacante" => "false")
																		 					)
																						))
									);
								} else {
									//Si ya agregó no vuelve a agrear
									if(!$this->esOfertaDuplicada($array_oferta[$item->fk_idgrupo], $item->horainiciocursada, $item->horafincursada, $item->descdia, $item->nombre, $item->apellido)){
										$array_oferta[$item->fk_idgrupo]["materia"][$item->fk_idmateria]["descmateria"] = $item->descmateria;
										$array_oferta[$item->fk_idgrupo]["materia"][$item->fk_idmateria]["cursada"][$item->idcursada] =   array("dia" => $item->descdia." ".$item->horainiciocursada." hs. a ".$item->horafincursada." hs. (".$item->apellido . " " . $item->nombre.") Sede: ". $item->descsede, "sinvacante" => "false");
									}
								}
							} else {
								if(!isset($array_oferta[$item->fk_idgrupo])){
									$array_oferta[$item->fk_idgrupo] = array(
										"grupo" => $item->descgrupo,
										"abreinscripcion" => $item->abreinscripcion,
										"materia" => array(
											$item->fk_idmateria => array("descmateria" => $item->descmateria,
																		 "cursada" =>  array($item->idcursada => 
																		 					array("dia" => $item->descdia." ".$item->horainiciocursada." hs. a ".$item->horafincursada." hs. (".$item->apellido . " " . $item->nombre .") Sede: ". $item->descsede ." - SIN VACANTES", 
																							"sinvacante" => "true")
																		 					)
																		 				))
									);
								} else {
									//Si ya agregó no vuelve a agrear
									if(!$this->esOfertaDuplicada($array_oferta[$item->fk_idgrupo], $item->horainiciocursada, $item->horafincursada, $item->descdia, $item->nombre, $item->apellido)){

										$array_oferta[$item->fk_idgrupo]["materia"][$item->fk_idmateria]["descmateria"] = $item->descmateria;
										$array_oferta[$item->fk_idgrupo]["materia"][$item->fk_idmateria]["cursada"][$item->idcursada] = array("dia" => $item->descdia." ".$item->horainiciocursada." hs. a ".$item->horafincursada." hs. (".$item->apellido . " " . $item->nombre.") Sede: ". $item->descsede." - SIN VACANTES", "sinvacante" => "true");
									}
								}
							}
						}
					}	
				} else {
					$titulo = "Carrera docente";
				}

	        return view('autogestion.cd-inscripcion', compact('titulo', 'plan_cd_activo', 'array_carreraactiva', 'array_oferta', 'plan_cd_activo', 'array_oferta_yainscripta'));
	    } else {
	    	return redirect(env('APP_URL_AUTOGESTION') . '');
	    }
    }

    public function esOfertaDuplicada($oferta, $horainiciocursada, $horafincursada, $descdia, $nombre, $apellido){
        //Solo controla cuando es modulo
        if(count($oferta)>0 && $oferta["abreinscripcion"]==1){
                foreach($oferta["materia"] as $materia){
                    foreach($materia["cursada"] as $cursada){
                        $string = $descdia." ".$horainiciocursada." hs. a ".$horafincursada." hs. (".$apellido . " " . $nombre .")";
                        if(strstr($cursada["dia"], $string))
                            return true;
                    }
                }
            }
        return false;
    }

    public function inscribir(Request $request){
    	$nueva_inscripcion = array();
    	$ofertaCursada = new OfertaCursada();
    	$entidad = new AlumnoInscripcion();
		$plan_cd_activo =  $entidad->obtenerCarreraDocenteActivaPorAlumno(Session::get('alumno_id'));
    	$titulo = "Carrera docente (Plan: " . $plan_cd_activo->descplan . ")";
    	$now = new \DateTime();
    	$nueva_inscripcion = $request->input('lstOferta');

    	//Si la oferta abreinscripcion agrega en nueva_inscripcion los id de las ofertas
		if(count($nueva_inscripcion)>0)
    		foreach ($nueva_inscripcion as $idcursada) {
				$entidadPlanGrupo = new PlanGrupo();
				$entidadPlanGrupo->getAbreInscripcion($idcursada);
				if($entidadPlanGrupo->abreinscripcion== 1){
					//Obtiene todas la oferta para el ;exit;modulo
					$res = $ofertaCursada->obtenerOfertaCarreraDocenteActivaPorModulo($entidadPlanGrupo->idgrupo);
				
					if(count($res)>0)
						foreach($res as $of){
							//Agrega solo la oferta para el dia seleccionado
							$entidadCursada= new OfertaCursada();
							$resSeleccion = $entidadCursada->obtenerPorId($idcursada);

							if(isset($resSeleccion) && $of->horainiciocursada == $resSeleccion->horainiciocursada && $of->horafincursada == $resSeleccion->horafincursada && $of->descdia == $resSeleccion->descdia && $of->nombre == $resSeleccion->nombre && $of->apellido == $resSeleccion->apellido){
								$nueva_inscripcion[] = $of->idcursada;
							}
						}
				}
			}
		$nueva_inscripcion = array_unique($nueva_inscripcion);

    	//Elimina aquellas materias a las que anteriormente se inscribio y ahora se desincribio al modificar la inscripción
    	$array_oferta_yainscripta = $ofertaCursada->obtenerOfertaCarreraDocenteInscriptoPorAlumno(Session::get('usuarioalu'));

    	if(count($array_oferta_yainscripta)>0)
    		foreach($array_oferta_yainscripta as $cursada){
    			if(!in_array($cursada->idcursada, $nueva_inscripcion)){
    				$ofertaCursada->eliminaAlumnoInscripto($cursada->idcursada, Session::get('alumno_id'));
    			}
    		}
    	$fechaInscripcion = $now->format('Y-m-d H:i:s');

    	if(count($nueva_inscripcion)>0)
    		foreach ($nueva_inscripcion as $idcursada) {
    			if($idcursada > 0){
    				$vacantesTotales = $ofertaCursada->obtenerVacantesTotales($plan_cd_activo->fk_idplan, $idcursada);
    				$cantidadInscriptos = $ofertaCursada->cantidadDeAlumnosInscriptosExceptoAlumnoActual($plan_cd_activo->fk_idplan, $idcursada, Session::get('alumno_id'));

    				//Si ya está inscripto no lo vuelve a inscribir
    				if(!$ofertaCursada->existeAlumnoInscripto($idcursada, Session::get('alumno_id')) && $cantidadInscriptos < $vacantesTotales){
						$aluMateria = new AlumnoMateria();
						$aluMateria->fk_idcursada = $idcursada;
						$aluMateria->fk_idalumno = Session::get('alumno_id');
						$aluMateria->fechainsc = $fechaInscripcion;
						$aluMateria->insertar();
    				}  				
    			}
    		}

		//Obtiene las materias inscriptas y genera el comprobante
		$array_oferta_yainscripta = $ofertaCursada->obtenerOfertaCarreraDocenteInscriptoPorAlumno(Session::get('usuarioalu'));

		//Almacena los datos para el comprobante
		$formuCabecera = new FormuCabecera();
		$formuCabecera->fk_idplan = $plan_cd_activo->fk_idplan;
		$formuCabecera->documento = Session::get('usuarioalu');
		$formuCabecera->control = $fechaInscripcion;
		$idformu = $formuCabecera->insertar();

		$formuDetalle = new FormuDetalle();
		$formuDetalle->fk_idformu = $idformu;
		if(count($array_oferta_yainscripta)>0)
			foreach($array_oferta_yainscripta as $oferta){
				$formuDetalle->fk_idcursada = $oferta->idcursada;
				$formuDetalle->insertar();
			}
		
		$msg["ESTADO"] = MSG_SUCCESS;
      	$msg["MSG"] = "Incripción procesada correctamente.";
		return view('autogestion.cd-comprobante', compact('titulo', 'msg', 'idformu'));
    }
}