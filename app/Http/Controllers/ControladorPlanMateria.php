<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Actividad\PlanGrupo;
use App\Entidades\Actividad\Materia;
use App\Entidades\Actividad\PlanRequisito;
use App\Entidades\Actividad\PlanMateria;
use App\Entidades\Actividad\PlanCorrelativa;
use App\Entidades\Actividad\PlanEquivalencia;
use App\Entidades\Actividad\PlanDeEstudio;
use App\Entidades\Actividad\Actividad;
use App\Entidades\Publico\Nota;
use App\Entidades\Publico\Departamento;

require app_path().'/start/constants.php';
use Session;

class ControladorPlanMateria extends Controller{

    public function editar($id){
        $titulo = "Modificar plan de estudio";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $modulo = new PlanGrupo();
                $array_modulo = $modulo->obtenerTodosPorPlan($id);

                $plandeestudio = new PlanDeEstudio();
                $plandeestudio->obtenerPorId($id);
                if($plandeestudio->publicado)
                    $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
                else
                    $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";

                $materia = new Materia();
                $array_materia = $materia->obtenerTodosPorActividad($plandeestudio->fk_idactividad);

                $nota = new Nota();
                $array_notas = $nota->obtenerTodos();

                $plan = new PlanDeEstudio();
                $array_plan = $plan->obtenerTodos();

                $dpto = new Departamento();
                $array_dpto = $dpto->obtenerTodos();

                $actividad = new Actividad();
                $array_actividad = $actividad->obtenerTodos();

                return view('actividad.plandeestudio-materias', compact('titulo', 'plandeestudio', 'array_modulo', 'array_materia', 'array_notas', 'array_plan', 'array_dpto', 'array_actividad'));
            }
        } else {
           return redirect('login');
        }
    }

    public function cargarGrillaMateriasDelPlan(){
        $request = $_REQUEST;
        $idplan = ($_REQUEST["idplan"]);

        $entidadRequisito = new PlanMateria();
        $aRequisito = $entidadRequisito->obtenerTodosPorPlan($idplan);

        $nota = new Nota();
        $aNotas = $nota->obtenerTodos();
        

        $data = array();

        if (count($aRequisito) > 0)
            $cont=0;
            for ($i=0; $i < count($aRequisito); $i++) {
                $row = array();
                $idGrupoMateria = $aRequisito[$i]->fk_idgrupo . "_" . $aRequisito[$i]->fk_idmateria;
                $row[] = $aRequisito[$i]->descgrupo . " - <label><input type='checkbox' name='grupo[" . $aRequisito[$i]->fk_idgrupo . "]' " . ($aRequisito[$i]->abreinscripcion==1?"checked":'')  . "> Inscribe al módulo completo</label>";
                $row[] = "<button type='button' title='Editar materia' class='btn btn fa fa-pencil' onclick='abrirEditarMateria(". $aRequisito[$i]->fk_idmateria .")'></button> " . $aRequisito[$i]->fk_idmateria . " - " . ($aRequisito[$i]->descmateria);
                if($aRequisito[$i]->optativa == "1")
                    $row[] = "<select id='lstOptativa_" .$aRequisito[$i]->fk_idmateria  . "' name='optativa[" .$idGrupoMateria . "]' class='form-control'><option selected value='1'>Si</option><option value='0'>No</option>";
                else
                    $row[] = "<select name='optativa[" .$idGrupoMateria . "]' class='form-control'><option value='1'>Si</option><option selected value='0'>No</option>";
                $html = "<select required name='nota[" .$idGrupoMateria . "]' class='form-control'><option value='' disabled selected>Seleccionar</option>";
                foreach($aNotas as $item){
                    if($item->idnota == $aRequisito[$i]->fk_idnota)
                        $html .= "<option selected value='". $item->idnota ."'>". $item->notaenletras ."</option>";    
                    else
                        $html .= "<option value='". $item->idnota ."'>" . $item->notaenletras ."</option>";    
                }
                $html .= "</select>";
                $row[] = $html;
                $planCorrelativa = new PlanCorrelativa();
                $aCorrelativa = $planCorrelativa->obtenerPorPlanMateria($idplan, $aRequisito[$i]->fk_idmateria);
                $htmlCorrelativa="";
                if(count($aCorrelativa)>0)
                    foreach($aCorrelativa as $obj){
                        if($htmlCorrelativa == "")
                            $htmlCorrelativa = $obj->fk_idmateriacorrelativa;
                        else
                            $htmlCorrelativa .= ", " . $obj->fk_idmateriacorrelativa;
                    }
                $row[] = "<input type='hidden' id='txtCorrelativa_" .$aRequisito[$i]->fk_idmateria  . "' name='correlativa[" .$idGrupoMateria . "]' value='".$htmlCorrelativa."'><button type='button' class='btn btn-secondary fa fa-pencil-square-o' onclick='abrirEditarCorrelativa(". $aRequisito[$i]->fk_idmateria .");'></button> <span id='divCorrelativa_" .$aRequisito[$i]->fk_idmateria  . "'>$htmlCorrelativa</span>";
                
                $htmlEquivalencia="";
                $planEquivalencia = new PlanEquivalencia();
                $aEquivalencia = $planEquivalencia->obtenerEquivalenciasPorPlanPorMateria($idplan, $aRequisito[$i]->fk_idmateria);
                if(count($aEquivalencia)>0){
                    foreach($aEquivalencia as $obj){
                        if($htmlEquivalencia == "")
                            $htmlEquivalencia = '["'.$obj->fk_idplanequivalencia . ',' . $obj->fk_idmateriaequivalencia.'"';
                        else
                            $htmlEquivalencia .= "," . '"'.$obj->fk_idplanequivalencia . ',' . $obj->fk_idmateriaequivalencia.'"';
                    }
                    $htmlEquivalencia.="]";
                }
                if($htmlEquivalencia)
                    $row[] = "<button type='button' id='btnEquivalencia_" .$aRequisito[$i]->fk_idmateria  . "' class='btn btn-primary fa fa-th-large' onclick='abrirEditarEquivalencia(". $aRequisito[$i]->fk_idmateria .");' value=''></button><input type='hidden' id='txtEquivalencia_" .$aRequisito[$i]->fk_idmateria  . "' name='equivalencia[" .$idGrupoMateria . "]' value='$htmlEquivalencia'>";
                else
                    $row[] = "<button type='button' id='btnEquivalencia_" .$aRequisito[$i]->fk_idmateria  . "' class='btn btn-secondary fa fa-th-large' onclick='abrirEditarEquivalencia(". $aRequisito[$i]->fk_idmateria .");' value=''></button><input type='hidden' id='txtEquivalencia_" .$aRequisito[$i]->fk_idmateria  . "' name='equivalencia[" .$idGrupoMateria . "]' value='$htmlEquivalencia'>";
                $row[] = "<button type='button' class='btn btn-secondary fa fa-minus-circle' onclick='eliminar(". $aRequisito[$i]->fk_idmateria .")'></button>";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($aRequisito),
            "recordsFiltered" => count($aRequisito),
            "data" => $data
        );
        return json_encode($json_data);  
    }

    public function guardar(Request $request){
        $id = $request->input("id");

        $plandeestudio = new PlanDeEstudio();
        $plandeestudio->obtenerPorId($id);

        $modulo = new PlanGrupo();
        $array_modulo = $modulo->obtenerTodosPorPlan($id);

        $planMateria = new PlanMateria();
        $planMateria->eliminarPorPlan($id);

        $planCorrelativa = new PlanCorrelativa();
        $planCorrelativa->eliminarPorPlan($id);
 
        $planEquivalencia = new PlanEquivalencia();
        $planEquivalencia->eliminarPorPlan($id);
 
        $materia = new Materia();
        $array_materia = $materia->obtenerTodosPorActividad($plandeestudio->fk_idactividad);

        $nota = new Nota();
        $array_notas = $nota->obtenerTodos();

        $dpto = new Departamento();
        $array_dpto = $dpto->obtenerTodos();

        $plan = new PlanDeEstudio();
        $array_plan = $plan->obtenerTodos();

        $actividad = new Actividad();
        $array_actividad = $actividad->obtenerTodos();

        try {
            if ($_POST["id"] > 0) {
                if($request->input('optativa')){
                    foreach($request->input('optativa') as $key=>$valor){
                        $aKey = explode('_', $key);
                        $idGrupo = $aKey[0];
                        $idMateria = $aKey[1];
                        $planMateria->fk_idplan = $id;
                        $planMateria->fk_idgrupo = $idGrupo;
                        $planMateria->fk_idmateria = $idMateria;
                        $planMateria->optativa = $request->input('optativa')[$key];
                        $aCorrelativa = explode(',', $request->input('correlativa')[$key]);
                        if(count($aCorrelativa)>0) {
                            $planCorrelativa = new PlanCorrelativa();
                            foreach($aCorrelativa as $item) {
                                if($item>0){
                                    $planCorrelativa->fk_idplan = $id;
                                    $planCorrelativa->fk_idmateriacorrelativa = $item;
                                    $planCorrelativa->fk_idmateria = $idMateria;
                                    $planCorrelativa->insertar();
                                }
                            }
                        }

                        if(isset($request->input('equivalencia')[$key]) != ""){
                            $jsonEquivalencia = $request->input('equivalencia')[$key];
                            if($jsonEquivalencia != "")
                               // print_r($request->input('equivalencia'));exit;
                                foreach(json_decode($jsonEquivalencia) as $itemEquivalencia){
                                    $aEquivalencia = explode(',', $itemEquivalencia);
                                    $planEquivalencia = new PlanEquivalencia();
                                    $planEquivalencia->fk_idplan = $id;
                                    $planEquivalencia->fk_idmateria = $idMateria;
                                    $planEquivalencia->fk_idplanequivalencia = $aEquivalencia[0];
                                    $planEquivalencia->fk_idmateriaequivalencia = $aEquivalencia[1];
                                    $planEquivalencia->nivelequivalencia = 0;
                                    $planEquivalencia->insertar();
                                }
                        }
                        $planMateria->fk_idnota = isset($request->input('nota')[$key])?$request->input('nota')[$key]:"";
                        $planMateria->insertar();                      
                    }
                    //Actualiza grupos
                    $grupo = new PlanGrupo;
                    $grupo->setAbreinscripcionMasivoPorPlan($id, 2);
    
                    if($request->input('grupo'))
                        foreach($request->input('grupo') as $idGrupo=>$valor){
                            $grupo = new PlanGrupo;                     
                            $grupo->setAbreinscripcion($idGrupo, 1);
                        }
                }

                $cantRequisito = $cantMateria = 0;

                if($request->input("txtPublicado") == 1){
                    //Valida que tenga al menos una materia y un requisito para publicar
                    $planRequisito = new PlanRequisito();
                    $cantRequisito = count($planRequisito->obtenerTodosPorPlan($plandeestudio->idplan));

                    $planRequisito = new PlanMateria();
                    $cantMateria = count($planRequisito->obtenerTodosPorPlan($plandeestudio->idplan));

                    if($cantMateria == 0){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "El plan debe tener al menos una Materia para ser publicado";
                        $plandeestudio->publicado(false);
                    } else if($cantRequisito == 0){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "El plan debe tener al menos un Requisito para ser publicado";
                        $plandeestudio->publicado(false);
                    } else {
                        //Guarda en publicado
                        $plandeestudio->publicado(true);
                    }
                } else {
                	$plandeestudio->publicado(false);
                }

                if(!isset($msg["MSG"]) || $msg["MSG"] == ""){
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }

				$plandeestudio = new PlanDeEstudio();
                $plandeestudio->obtenerPorId($_POST["id"]);
                if($plandeestudio->publicado)
                    $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
                else
                    $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";
        
                return view('actividad.plandeestudio-materias', compact('msg', 'titulo', 'plandeestudio', 'array_modulo', 'array_materia', 'array_notas', 'array_plan', 'array_dpto', 'array_actividad'));
            } else {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        if($plandeestudio->publicado)
            $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
        else
            $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";

        return view('actividad.plandeestudio-materias', compact('msg', 'titulo', 'plandeestudio', 'array_modulo', 'array_materia', 'array_notas', 'array_plan', 'array_dpto', 'array_actividad')) . '?id=' . $id;
    }

    public function obtenerMateriasDelPlan(Request $request){
        $idPlan = $request->input('plan');
        $entidad = new PlanMateria();
        $aEntidad = $entidad->obtenerTodosPorPlan($idPlan);
        echo json_encode($aEntidad);
    }

    public function obtenerTodosPorActividadDelPlanAjax(Request $request){
        $idPlan = $request->input('plan');
        $plandeestudio = new PlanDeEstudio();
        $plandeestudio->obtenerPorId($idPlan);

        $materia = new Materia();
        $aEntidad = $materia->obtenerTodosPorActividad($plandeestudio->fk_idactividad);
        echo json_encode($aEntidad);
    }
}
