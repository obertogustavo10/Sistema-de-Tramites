<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Actividad\Actividad;
use App\Entidades\Actividad\PlanDeEstudio;
use App\Entidades\Actividad\PlanRequisito;
use App\Entidades\Actividad\PlanMateria;

require app_path().'/start/constants.php';
use Session;

class ControladorPlanDeEstudio extends Controller{
    public function index(){
        $titulo = "Planes de estudio";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('actividad.plandeestudio-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new PlanDeEstudio();
        $aPlan = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aPlan) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aPlan) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = $aPlan[$i]->descactividad;
                if($aPlan[$i]->publicado == 1)
                    $titulo = $row[] = '<a href="/actividad/plan/' . $aPlan[$i]->idplan . '">' . $aPlan[$i]->descplan . '</a> -publicado';
                else
                    $titulo = $row[] = '<a href="/actividad/plan/' . $aPlan[$i]->idplan . '">' . $aPlan[$i]->descplan . '</a> -borrador';
                $row[] = $aPlan[$i]->ncplan;
                $row[] = $aPlan[$i]->vigenciadesde != ""? date_format(date_create($aPlan[$i]->vigenciadesde), 'd/m/Y'):"";
                $row[] = $aPlan[$i]->vigenciahasta != ""?date_format(date_create($aPlan[$i]->vigenciahasta), 'd/m/Y'):"";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPlan), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPlan),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nuevo plan de estudio";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $actividad = new Actividad();
                    $array_actividad = $actividad->obtenerTodos();

                    return view('actividad.plandeestudio-nuevo', compact('titulo', 'array_actividad'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar plan de estudio";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $actividad = new Actividad();
                $array_actividad = $actividad->obtenerTodos();

                $plandeestudio = new PlanDeEstudio();
                $plandeestudio->obtenerPorId($id);
                if($plandeestudio->publicado)
                    $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
                else
                    $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";

                return view('actividad.plandeestudio-nuevo', compact('plandeestudio', 'titulo', 'array_actividad'));
            }
        } else {
           return redirect('login');
        }
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar plan de estudio";
            $plandeestudio = new PlanDeEstudio();
            $plandeestudio->cargarDesdeRequest($request);

            $actividad = new Actividad();
            $array_actividad = $actividad->obtenerTodos();

            //validaciones
            if ($plandeestudio->ncplan == "" || $plandeestudio->fk_idactividad == "" || $plandeestudio->descplan == "" || $plandeestudio->resolucion == "" || $plandeestudio->abreinscripcion == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los campos"; //ARREGLAR
            } else {

                $cantRequisito = $cantMateria = 0;
                if($plandeestudio->publicado == 1){
                    //Valida que tenga al menos una materia y un requisito para publicar
                    $planRequisito = new PlanRequisito();
                    $cantRequisito = count($planRequisito->obtenerTodosPorPlan($plandeestudio->idplan));

                    $planRequisito = new PlanMateria();
                    $cantMateria = count($planRequisito->obtenerTodosPorPlan($plandeestudio->idplan));
                    
                    if($cantMateria == 0){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "El plan debe tener al menos una Materia para ser publicado";
                        $plandeestudio->publicado = 0;
                    }
                    if($cantRequisito == 0){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "El plan debe tener al menos un Requisito para ser publicado";
                        $plandeestudio->publicado = 0;
                    }
                }

                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $plandeestudio->guardar();
                } else {
                    //Es nuevo
                    $plandeestudio->insertar();
                }
                if(!isset($msg["MSG"]) || $msg["MSG"] == ""){
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }

                $_POST["id"] = $plandeestudio->idplan;

                $actividad = new Actividad();
                $array_actividad = $actividad->obtenerTodos();

                $plandeestudio = new PlanDeEstudio();
                $plandeestudio->obtenerPorId($_POST["id"]);
    
                if($plandeestudio->publicado)
                    $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
                else
                    $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";
                
                return view('actividad.plandeestudio-nuevo', compact('titulo', 'msg', 'array_actividad', 'plandeestudio'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        if($plandeestudio->publicado)
            $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
        else
            $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";

        return view('actividad.plandeestudio-nuevo', compact('msg', 'titulo', 'array_actividad'));
    }

      public function obtenerPlan(Request $request){
        $array_materia_modulo = array();
        $idPlan = $request->input('idPlan');
        $plandeestudio = new PlanDeEstudio();
        $resultado["plan"] = $plandeestudio->obtenerPorId($idPlan);

        $materia = new PlanMateria();
        $aMateria = $materia->obtenerTodosPorPlan($idPlan);

        if(count($aMateria)>0)
            foreach($aMateria as $item){
                //Si se inscribe al modulo
                if($item->abreinscripcion == 1){
                    //Se posiciona en el array donde está definido el modulo y agrega la materia allí
                    $encontrado = false;
                    for($i=0; $i<count($array_materia_modulo) && !$encontrado; $i++) {
                        if($array_materia_modulo[$i]["idModulo"] == $item->fk_idgrupo){
                            $array_materia_modulo[$i]["materia"][] = array("idmateria" => $item->fk_idmateria,"descmateria" => $item->descmateria);
                            $encontrado = true;
                        }

                    }
                    if(!$encontrado){
                        //Si la materia no habia sido ingresada al array la agrega
                        $array_materia_modulo[] = array("idModulo" => $item->fk_idgrupo,
                                                        "modulo" => $item->descgrupo,
                                                        "abreinscripcion" => 1,
                                                        "materia" => array(array("idmateria" => $item->fk_idmateria,"descmateria" => $item->descmateria)));
                    }
                } else if($item->abreinscripcion == 2){
                    //Si se inscribe a todas las materias
                    $array_materia_modulo[] = array("idModulo" => $item->fk_idgrupo,
                                                    "modulo" => $item->descgrupo,
                                                    "abreinscripcion" => 2,
                                                    "materia" => array(array("idmateria" => $item->fk_idmateria,"descmateria" => $item->descmateria)));
                }
                
            }
        $resultado["materias"] = $array_materia_modulo;
        echo json_encode($resultado);
    }
}
