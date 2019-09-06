<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Actividad\Grupo;
use App\Entidades\Actividad\PlanDeEstudio;

require app_path().'/start/constants.php';
use Session;

class ControladorModulo extends Controller{
    public function index(){
        $titulo = "Módulos";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('actividad.modulo-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Grupo();
        $aGrupo = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aGrupo) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aGrupo) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/actividad/modulo/' . $aGrupo[$i]->idgrupo . '">' . $aGrupo[$i]->descgrupo . '</a>';
                $row[] = $aGrupo[$i]->ncgrupo;
                $row[] = $aGrupo[$i]->descplan;
                $row[] = $aGrupo[$i]->ncplan;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aGrupo), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aGrupo),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nuevo módulo";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $plan = new PlanDeEstudio();
                    $array_plan = $plan->obtenerTodos();

                     return view('actividad.modulo-nuevo', compact('titulo', 'array_plan'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar módulo";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $grupo = new Grupo();
                $grupo->obtenerPorId($id);

                $plan = new PlanDeEstudio();
                $array_plan = $plan->obtenerTodos();

                return view('actividad.modulo-nuevo', compact('grupo', 'titulo', 'array_plan'));
            }
        } else {
           return redirect('login');
        }
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar módulo";
            $entidad = new Grupo();
            $entidad->cargarDesdeRequest($request);

            $plan = new PlanDeEstudio();
            $array_plan = $plan->obtenerTodos();

            //validaciones
            if ($entidad->ncgrupo == "" || $entidad->abreinscripcion == "" || $entidad->fk_idplan == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los campos"; //ARREGLAR
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $_POST["id"] = $entidad->idgrupo;

                return view('actividad.modulo-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        return view('actividad.modulo-nuevo', compact('msg', 'titulo', 'array_plan', 'array_actividad'));
    }

    public function agregarModuloAjax(Request $request){
        try {
            $modulo = $request->input('modulo');
            $descripcion = $request->input('descripcion');
            $plan = $request->input('plan');
            $abre = $request->input('abre') != ""?  $request->input('abre') : "0";

            $entidad = new Grupo();
            $entidad->ncgrupo = $modulo;
            $entidad->descgrupo = $descripcion;
            $entidad->fk_idplan = $plan;
            $entidad->abreinscripcion = $abre;

            //validaciones
            if ($entidad->ncgrupo == "" || $entidad->abreinscripcion == "" || $entidad->fk_idplan == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los campos"; //ARREGLAR
            } else {
                $idModulo = $entidad->insertar();
                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                $msg["idModulo"] = $idModulo;
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        echo json_encode($msg);
    }

    public function obtenerTodosPorPlanAjax(Request $request){
        $id = $request->input("plan");
        $entidad = new Grupo();
        $aEntidad = $entidad->obtenerTodosPorPlan($id);
        echo json_encode($aEntidad);
    }
}
