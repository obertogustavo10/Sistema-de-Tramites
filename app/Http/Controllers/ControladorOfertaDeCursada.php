<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Cursada\OfertaCursada;
use App\Entidades\Actividad\PlanDeEstudio;
use App\Entidades\Actividad\PlanMateria;
use App\Entidades\Legajo\Personal;
use App\Entidades\Publico\Dia;
use App\Entidades\Publico\Sede;


require app_path().'/start/constants.php';
use Session;

class ControladorOfertaDeCursada extends Controller{
    public function index(){
        $titulo = "Oferta de cursada";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('previoinscripcion.ofertadecursada-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function nuevo(){
            $titulo = "Nueva Oferta de cursada";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $planDeEstudio = new PlanDeEstudio();
                    $array_plan = $planDeEstudio->obtenerVigentesPorActividad(Session::get("grupo_id"));

                    $personal = new Personal();
                    $array_personal = $personal->obtenerTodos();

                    $dia = new Dia();
                    $array_dia = $dia->obtenerTodos();

                    $sede = new Sede();
                    $array_sede = $sede->obtenerTodos();

                     return view('previoinscripcion.ofertadecursada-nuevo', compact('titulo', 'array_plan', 'array_personal', 'array_dia', 'array_sede'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($idPlan){
        $titulo = "Modificar Oferta de cursada";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $oferta = new OfertaCursada();
                $array_materiacursada = $oferta->obtenerPorPlan($idPlan);

                $planDeEstudio = new PlanDeEstudio();
                $plan = $planDeEstudio->obtenerPorId($idPlan);
                $array_plan = $planDeEstudio->obtenerVigentesPorActividad(Session::get("grupo_id"));

                $personal = new Personal();
                $array_personal = $personal->obtenerTodos();

                $dia = new Dia();
                $array_dia = $dia->obtenerTodos();

                $sede = new Sede();
                $array_sede = $sede->obtenerTodos();

                return view('previoinscripcion.ofertadecursada-nuevo', compact('plan', 'titulo', 'array_plan', 'array_personal', 'array_dia', 'array_materiacursada', 'array_sede'));
            }
        } else {
           return redirect('login');
        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("CARGOELIMINAR")){
                $actividad = new Actividad();
                $ofertadecursada->cargarDesdeRequest($request);
                $ofertadecursada->eliminar();
                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "CARGOELIMINAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                $aResultado["err"] = EXIT_FAILURE; //error al elimiar
            }
            echo json_encode($aResultado);
        } else {
            return redirect('login');
        }
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Oferta de cursada";
            $idPlan = $request->input('lstPlan');

            $oferta = new OfertaCursada();
            $array_materiacursada = $oferta->obtenerPorPlan($idPlan);

            $planDeEstudio = new PlanDeEstudio();
            $plan = $planDeEstudio->obtenerPorId($idPlan);
            $array_plan = $planDeEstudio->obtenerVigentesPorActividad(Session::get("grupo_id"));

            $personal = new Personal();
            $array_personal = $personal->obtenerTodos();

            $sede = new Sede();
            $array_sede = $sede->obtenerTodos();

            $dia = new Dia();
            $array_dia = $dia->obtenerTodos();

            if($idPlan != ""){
                for($i=0;$i<count($request->input('txtModulo'));$i++){
                    $idModulo = $request->input('txtModulo')[$i];

                    for($j=0;$j<count($request->input('txtMateria'));$j++){
                        $idMateria = $request->input('txtMateria')[$j];

                        $entidad = new OfertaCursada();
                        //$entidad->eliminarPorPlan($request->input('lstPlan'));

                        $entidad->vacantestotales = $request->input('hdnVacante')[$i] != ""? $request->input('hdnVacante')[$i] : NULL;
                        $entidad->fk_idsede = $request->input('hdnLugarCursada')[$i] != ""? $request->input('hdnLugarCursada')[$i] : NULL;
                        $entidad->fk_idplan = $idPlan;
                        $entidad->fk_idmateria = $idMateria;
                        $entidad->horainiciocursada = $request->input('hdnHrIni')[$i] != "undefined"? $request->input('hdnHrIni')[$i] : "0";
                        $entidad->horainiciocursada .= $request->input('hdnMinIni')[$i] != "undefined"? ":".$request->input('hdnMinIni')[$i] : ":00";
                        $entidad->horafincursada = $request->input('hdnHrFin')[$i] != "undefined"? $request->input('hdnHrFin')[$i] : "0";
                        $entidad->horafincursada .= $request->input('hdnMinFin')[$i] != "undefined"? ":".$request->input('hdnMinFin')[$i] : ":00";
                        $entidad->habilitado = $request->input('hdnHabilitado')[$i] != ""? $request->input('hdnHabilitado')[$i] : 0;
                        $entidad->fechainiciocursada = $request->input('hdnFechaIniCursada')[$i] != ""? $request->input('hdnFechaIniCursada')[$i] : NULL;
                        $entidad->fechafincursada = $request->input('hdnFechaFinCursada')[$i] != ""? $request->input('hdnFechaFinCursada')[$i] : NULL;
                        $entidad->docente = $request->input('hdnDocente')[$i] != ""? $request->input('hdnDocente')[$i] : NULL;
                        $entidad->diacursada = $request->input('hdnDia')[$i] != ""? $request->input('hdnDia')[$i] : NULL;
                        $entidad->comentario = $request->input('hdnComentario')[$i] != ""? $request->input('hdnComentario')[$i] : NULL;

                        $entidad->idcursada = $idCursada;

                        //Si ya existe actualiza, sino inserta
                        if($entidad->idcursada>0){
                            $entidad->actualizar();
                        } else {
                            $entidad->insertar();
                        }
                    }                
                }
                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                $_POST["lstPlan"] = $idPlan;

                return view('previoinscripcion.ofertadecursada-nuevo', compact('msg', 'plan', 'titulo', 'array_plan', 'array_personal', 'array_dia', 'array_materiacursada', 'array_sede')) . '?id=' . $idPlan;
            } else {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Seleccione un plan";
            }        
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        return view('previoinscripcion.ofertadecursada-nuevo', compact('msg', 'titulo', 'array_plan', 'array_personal', 'array_dia', 'array_sede'));
    }

    public function cargarGrilla(){
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
    }

    public function cargarGrillaOfertaPorPlan(){
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
}
