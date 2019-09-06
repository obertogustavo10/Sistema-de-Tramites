<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Cursada\OfertaCursada;
use App\Entidades\Actividad\PlanDeEstudio;
use App\Entidades\Actividad\PlanMateria;
use App\Entidades\Cursada\AlumnoMateria;
use App\Entidades\Cursada\AlumnoPosgrado;
use App\Entidades\Legajo\Personal;
use App\Entidades\Publico\Dia;
use App\Entidades\Publico\Sede;


require app_path().'/start/constants.php';
use Session;

class ControladorInscripciones extends Controller{
    public function index(Request $request){
        $titulo = "Inscripciones";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $plan_seleccionado = "";

                $planDeEstudio = new PlanDeEstudio();
                $array_plan = $planDeEstudio->obtenerVigentesPorActividad(Session::get("grupo_id"));
                $array_oferta = array();

                if(count($array_plan)>0)$plan_seleccionado = $array_plan[0]->idplan;

                return view('inscripcion.inscripciones', compact('titulo', 'array_plan', 'plan_seleccionado'));
            }
        } else {
            return redirect('login');
        }
    }

  /*  public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new OfertaCursada();
        $aOferta = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aOferta) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aOferta) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/previoinscripcion/ofertadecursada/' . $aOferta[$i]->fk_idplan . '">' . $aOferta[$i]->descplan . '</a>';
                $row[] = $aOferta[$i]->resolucion;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aOferta), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aOferta),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }*/

 /*   public function cargarGrillaOfertaPorPlan(){
        $request = $_REQUEST;
        $idPlan = $request['idplan'];
        $array_materia_modulo = array();

	if($idPlan > 0){
    	$entidad = new OfertaCursada();
        $entidadPlanMateria = new PlanMateria();
        $aOferta = $entidad->obtenerPorPlan($idPlan);

        if(count($aOferta)>0)
            foreach($aOferta as $item){
                //Si se inscribe al modulo
                if($item->abreinscripcion == 1){
                    //Se posiciona en el array donde está definido el modulo y agrega la materia allí
                    $encontrado = false;
                    for($i=0; $i<count($array_materia_modulo) && !$encontrado; $i++) {
                        if($array_materia_modulo[$i]["idModulo"] == $item->fk_idgrupo){
                            $array_materia_modulo[$i]["materia"][] = array(
                                "idmateria" => $item->fk_idmateria,
                                "descmateria" => $item->descmateria, 
                                "cantMateriaPorModulo" => $entidadPlanMateria->obtenerCantMateriaPorModulo($item->fk_idgrupo),
                                "oferta" => array(array("vacantestotales" => $item->vacantestotales,
                                                                        "fk_idsede" => $item->fk_idsede,
                                                                        "idcursada" => $item->idcursada,
                                                                        "habilitado" => $item->habilitado,
                                                                        "horainiciocursada" => $item->horainiciocursada,
                                                                        "horafincursada" => $item->horafincursada,
                                                                        "fechainiciocursada" => $item->fechainiciocursada,
                                                                        "fechafincursada" => $item->fechafincursada,
                                                                        "docente" => $item->docente,
                                                                        "diacursada" => $item->diacursada,
                                                                        "comentario" => $item->comentario,
                                                                        "nombre_docente" => $item->nombre_docente,
                                                                        "apellido_docente" => $item->apellido_docente,
                                                                        "dia_cursada" => $item->dia_cursada,
                                                                        "descsede" => $item->descsede)));
                            $encontrado = true;
                        }

                    }
                    if(!$encontrado){
                        //Si la materia no habia sido ingresada al array la agrega
                        $array_materia_modulo[] = array(
                            "idModulo" => $item->fk_idgrupo,
                            "modulo" => $item->descgrupo,
                            "cantMateriaPorModulo" => $entidadPlanMateria->obtenerCantMateriaPorModulo($item->fk_idgrupo),
                            "abreinscripcion" => 1,
                            "materia" => array(array(
                                "idmateria" => $item->fk_idmateria,
                                "descmateria" => $item->descmateria, 
                                "oferta" => array(array("vacantestotales" => $item->vacantestotales,
                                                    "fk_idsede" => $item->fk_idsede,
                                                    "idcursada" => $item->idcursada,
                                                    "habilitado" => $item->habilitado,
                                                    "horainiciocursada" => $item->horainiciocursada,
                                                    "horafincursada" => $item->horafincursada,
                                                    "fechainiciocursada" => $item->fechainiciocursada,
                                                    "fechafincursada" => $item->fechafincursada,
                                                    "docente" => $item->docente,
                                                    "diacursada" => $item->diacursada,
                                                    "comentario" => $item->comentario,
                                                    "nombre_docente" => $item->nombre_docente,
                                                    "apellido_docente" => $item->apellido_docente,
                                                    "dia_cursada" => $item->dia_cursada,
                                                    "descsede" => $item->descsede
                                                )))));
                        
                    }
                } else if($item->abreinscripcion == 2){
                    //Si se inscribe a todas las materias
                    $array_materia_modulo[] = array(
                        "idModulo" => $item->fk_idgrupo,
                        "modulo" => $item->descgrupo,
                        "abreinscripcion" => 2,
                        "materia" => array(array("idmateria" => $item->fk_idmateria,"descmateria" => $item->descmateria, "oferta" => array(array("vacantestotales" => $item->vacantestotales,
                                                "fk_idsede" => $item->fk_idsede,
                                                "idcursada" => $item->idcursada,
                                                "habilitado" => $item->habilitado,
                                                "horainiciocursada" => $item->horainiciocursada,
                                                "horafincursada" => $item->horafincursada,
                                                "fechainiciocursada" => $item->fechainiciocursada,
                                                "fechafincursada" => $item->fechafincursada,
                                                "docente" => $item->docente,
                                                "diacursada" => $item->diacursada,
                                                "comentario" => $item->comentario,
                                                "nombre_docente" => $item->nombre_docente,
                                                "apellido_docente" => $item->apellido_docente,
                                                "dia_cursada" => $item->dia_cursada,
                                                "descsede" => $item->descsede
                                            )))));
                }
                
            }

        $data = array();
//print_r($array_materia_modulo);exit;

        $pos=0;
        for ($i=0; $i < count($array_materia_modulo); $i++) {
            if($array_materia_modulo[$i]["abreinscripcion"] == 1){
                
                $idModulo = $array_materia_modulo[$i]["idModulo"];
                $nombreModulo = $array_materia_modulo[$i]["modulo"];
                $cantMateriaPorModulo = $array_materia_modulo[$i]["cantMateriaPorModulo"];; 
                $cantMateria = 0;
                $idMateria = array();
                //Recorro cada materia y renombro su nombre con el nombre del modulo
                foreach($array_materia_modulo[$i]["materia"] as $materia){

                 
     
                
                    foreach($materia["oferta"] as $oferta){
                      //print_r($array_materia_modulo[$i]["materia"][$j]["oferta"]);

                        //Si la materia ya fue ingresada en la oferta la anexa solo al array
                        if($cantMateria < $cantMateriaPorModulo){
                            $idMateria[] = array("idMateria" => $materia["idmateria"], 
                                                "idCursada" => $oferta["idcursada"]);
                        } else {//Cuando $cantMateria == $cantMateriaPorModulo
                            $idMateria[] = array("idMateria" => $materia["idmateria"], 
                                                "idCursada" => $oferta["idcursada"]);
                            $row = array();
                            $hora = explode(':', $oferta["horainiciocursada"]);
                            $hrIni = isset($hora[0])? $hora[0]:"";
                            $minIni = isset($hora[1])?$hora[1]:"";
                            if(strlen($minIni)==1)
                                $minIni .= 0;
                            $hora = explode(':', $oferta["horafincursada"]);
                            $hrFin = isset($hora[0])?$hora[0]:"";
                            $minFin = isset($hora[1])?$hora[1]:"";

                            $habilitado = $oferta["habilitado"] == 1? "Si":"No";
                            $html = "";
                            $html = "<a class='data-toggle' data-toggle='collapse' href='#collapse". $pos ."' role='button' aria-expanded='false' aria-controls='collapse". $pos ."'>[+]</a> " . $nombreModulo . " - ".$oferta["apellido_docente"] . " " . $oferta["nombre_docente"] ." - ".  $oferta["dia_cursada"] . " de " . $hrIni . ":" .  $minIni . " a " . $hrFin . ":" . $minFin . " hs." . "<input type='text' id='txtModulo_". $pos ."' name='txtModulo[]' value='" . $idModulo . "'><input type='text' id='txtMateria_". $pos ."' name='txtMateria[]' value='".json_encode($idMateria)."'><div class='collapse' id='collapse". $pos ."'><label>Horario:</label> " . $oferta["dia_cursada"] . " de " . $hrIni . ":" .  $minIni . " a " . $hrFin . ":" . $minFin . " hs." . "<input type='hidden' name='hdnDia[". $pos ."]' value='" . $oferta["diacursada"] . "'><input type='hidden' name='hdnHrIni[". $pos ."]' value='" . $hrIni . "'><input type='hidden' name='hdnMinIni[". $pos ."]' value='" . $minIni . "'><input type='hidden' name='hdnHrFin[". $pos ."]' value='" . $hrFin . "'><input type='hidden' name='hdnMinFin[". $pos ."]' value='" . $minFin . "'><br><label>Docente:</label> " . $oferta["nombre_docente"] . " ". $oferta["apellido_docente"] . "<input type='hidden' name='hdnDocente[". $pos ."]' value='" . $oferta["docente"] ."'><br><label>Lugar de cursada:</label> " .$oferta["descsede"] . "<input type='hidden' name='hdnLugarCursada[". $pos ."]' value='" . $oferta["fk_idsede"] . "'><br><label>Vacantes:</label> " . $oferta["vacantestotales"] . "<input type='hidden' name='hdnVacante[". $pos ."]' value='" . $oferta["vacantestotales"] . "'><br><label>Período de cursada:</label> ";
                            $periodo = "";
                            if($oferta["fechainiciocursada"] != "")
                                $periodo = date_format(date_create($oferta["fechainiciocursada"]), 'd/m/Y') . " a " . date_format(date_create($oferta["fechafincursada"]), 'd/m/Y');

                            $html .= "$periodo<input type='hidden' name='hdnFechaIniCursada[". $pos ."]' value='"  . $oferta["fechainiciocursada"] . "'><input type='hidden' name='hdnFechaFinCursada[". $pos ."]' value='"  . $oferta["fechafincursada"] . "'><br><label>Habilitado:</label> " . $habilitado . "<input type='hidden' name='hdnHabilitado[". $pos ."]' value='" . $oferta["habilitado"] . "'><br><label>Comentario:</label> " . $oferta["comentario"] . "<input type='hidden' name='hdnComentario[". $pos ."]' value='" . $oferta["comentario"] . "'></div>";
                            $row[] = $html;
                            $row[] = '<button type="button" class="btn btn-secondary fa fa-pencil" value="'.$pos.'" onclick="abrirEditarMateria(\''.$pos.'\')"></button>';
                            $data[] = $row;
                            $pos++;
                            $cantMateria = 0;
                                  $idMateria = array();
                        }
                        $cantMateria++;
                    }

                }
            }
            if($array_materia_modulo[$i]["abreinscripcion"] == 2){
                $idModulo = $array_materia_modulo[$i]["idModulo"];
                foreach($array_materia_modulo[$i]["materia"] as $materia){
                    $nombreMateria = $materia["descmateria"];
                    $idMateria = array();
                    foreach($materia["oferta"] as $oferta){
                        $idMateria[] = array("idMateria" => $materia["idmateria"], 
                                                "idCursada" => $oferta["idcursada"]);
                        $row = array();
                        $hora = explode(':', $oferta["horainiciocursada"]);
                        $hrIni = isset($hora[0])? $hora[0]:"";
                        $minIni = isset($hora[1])?$hora[1]:"";
                        if(strlen($minIni)==1)
                            $minIni .= 0;
                        $hora = explode(':', $oferta["horafincursada"]);
                        $hrFin = isset($hora[0])?$hora[0]:"";
                        $minFin = isset($hora[1])?$hora[1]:"";

                        $habilitado = $oferta["habilitado"] == 1? "Si":"No";
                        $html = "";
                        $html = "<a class='data-toggle' data-toggle='collapse' href='#collapse". $pos ."' role='button' aria-expanded='false' aria-controls='collapse". $pos ."'>[+]</a> " . $nombreMateria . " - ".$oferta["apellido_docente"] . " " . $oferta["nombre_docente"] ." - ".  $oferta["dia_cursada"] . " de " . $hrIni . ":" .  $minIni . " a " . $hrFin . ":" . $minFin . " hs." . "<input type='text' id='txtModulo_". $pos ."' name='txtModulo[]' value='" . $idModulo . "'><input type='text' id='txtMateria_". $pos ."' name='txtMateria[]' value='".json_encode($idMateria)."'><div class='collapse' id='collapse". $pos ."'><label>Horario:</label> " . $oferta["dia_cursada"] . " de " . $hrIni . ":" .  $minIni . " a " . $hrFin . ":" . $minFin . " hs." . "<input type='hidden' name='hdnDia[". $pos ."]' value='" . $oferta["diacursada"] . "'><input type='hidden' name='hdnHrIni[". $pos ."]' value='" . $hrIni . "'><input type='hidden' name='hdnMinIni[". $pos ."]' value='" . $minIni . "'><input type='hidden' name='hdnHrFin[". $pos ."]' value='" . $hrFin . "'><input type='hidden' name='hdnMinFin[". $pos ."]' value='" . $minFin . "'><br><label>Docente:</label> " . $oferta["nombre_docente"] . " ". $oferta["apellido_docente"] . "<input type='hidden' name='hdnDocente[". $pos ."]' value='" . $oferta["docente"] ."'><br><label>Lugar de cursada:</label> " .$oferta["descsede"] . "<input type='hidden' name='hdnLugarCursada[". $pos ."]' value='" . $oferta["fk_idsede"] . "'><br><label>Vacantes:</label> " . $oferta["vacantestotales"] . "<input type='hidden' name='hdnVacante[". $pos ."]' value='" . $oferta["vacantestotales"] . "'><br><label>Período de cursada:</label> ";
                        $periodo = "";
                        if($oferta["fechainiciocursada"] != "")
                            $periodo = date_format(date_create($oferta["fechainiciocursada"]), 'd/m/Y') . " a " . date_format(date_create($oferta["fechafincursada"]), 'd/m/Y');

                        $html .= "$periodo<input type='hidden' name='hdnFechaIniCursada[". $pos ."]' value='"  . $oferta["fechainiciocursada"] . "'><input type='hidden' name='hdnFechaFinCursada[". $pos ."]' value='"  . $oferta["fechafincursada"] . "'><br><label>Habilitado:</label> " . $habilitado . "<input type='hidden' name='hdnHabilitado[". $pos ."]' value='" . $oferta["habilitado"] . "'><br><label>Comentario:</label> " . $oferta["comentario"] . "<input type='hidden' name='hdnComentario[". $pos ."]' value='" . $oferta["comentario"] . "'></div>";
                        $row[] = $html;
                        $row[] = '<button type="button" class="btn btn-secondary fa fa-pencil" value="'.$pos.'" onclick="abrirEditarMateria(\''.$pos.'\')"></button>';
                        $data[] = $row;
                        $pos++;
                    }
                }
            }
        }    
        $json_data = array(
            "recordsTotal" => $pos, //cantidad total de registros sin paginar
            "recordsFiltered" => $pos,//cantidad total de registros en la paginacion
            "data" => $data);
    } else {
        $json_data = array(
            "recordsTotal" => 0, //cantidad total de registros sin paginar
            "recordsFiltered" => 0,//cantidad total de registros en la paginacion
            "data" => "");
    }
    return json_encode($json_data);
    }
*/
     public function obtenerInscripciones(Request $request){
        $array_periodo = $array_oferta = array();
        $idPlan = $request->input('idPlan');
        $fechaDesde = $request->input('fechaDesde');
        $fechaHasta = $request->input('fechaHasta');
        $cant_inscriptos = $vacantes_totales = $cupo_ocupado = $alumnos_activos = 0;

        $plandeestudio = new PlanDeEstudio();
        $resultado["plan"] = $plandeestudio->obtenerPorId($idPlan);

        $materia = new AlumnoMateria();
        $cant_inscriptos = $materia->obtenerCantidadDeInscriptos($idPlan, $fechaDesde, $fechaHasta);

        $oferta = new OfertaCursada();
        $vacantes_totales = $oferta->obtenerCupoOfertado($idPlan, $fechaDesde, $fechaHasta);

        if($cant_inscriptos <= $vacantes_totales){
            if($vacantes_totales>0)
                $cupo_ocupado = round((($vacantes_totales - $cant_inscriptos)*100)/$vacantes_totales, 2);
        } else {
            $cupo_ocupado = "";
        }

        $alumno = new AlumnoMateria();
        $alumnos_activos = $alumno->obtenerCantidadDeInscriptosPorPlan($idPlan);

        $entidad = new OfertaCursada();
        //$aOferta = $entidad->obtenerPorPlan($idPlan);

        $aOferta =  $entidad->obtenerOfertaCarreraDocenteActivaPorPlan($idPlan);

                if(count($aOferta)>0){
                    foreach($aOferta as $item){

                        //************************************************
                        //Evalua si la materia abre inscripcion como materia individual o modulo
                        //0-Automática (no abre inscripción, pega todas las materias)
                        //1-Grupo (inscribe al grupo y le pega todas las materias de ese grupo)
                        //2-Individual (inscribe a las materias)
                        //************************************************

                        //Controla que haya cupo disponible para la oferta
                        $entidadPlanMateria = new PlanMateria();
                        $cantidadInscriptos = $entidad->cantidadDeAlumnosInscriptos($idPlan, $item->idcursada);


                        if($cantidadInscriptos < $item->vacantestotales){
                            if(!isset($array_oferta[$item->fk_idgrupo])){
                                $array_oferta[$item->fk_idgrupo] = array(
                                    "grupo" => $item->fk_idgrupo,
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
                                    "grupo" => $item->fk_idgrupo,
                                    "descgrupo" => $item->descgrupo,
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
                                    $array_oferta[$item->fk_idgrupo]["materia"][$item->fk_idmateria]["cursada"][$item->idcursada] = array("dia" => $item->descdia." ".$item->horainiciocursada." hs. a ".$item->horafincursada." hs. (".$item->apellido . " " . $item->nombre.") Sede: ". $item->descsede . " - SIN VACANTES", "sinvacante" => "true");
                                }
                            }
                        }  
                    } 
                }   
//print_r($array_oferta);exit;
        $resultado["periodo"] = $array_periodo;
        $resultado["alumnos_activos"] = $alumnos_activos;
        $resultado["cant_inscriptos"] = $cant_inscriptos;
        $resultado["cupo_ocupado"] = $cupo_ocupado;
        $resultado["array_oferta"] = $array_oferta;
        echo json_encode($resultado);
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
}
