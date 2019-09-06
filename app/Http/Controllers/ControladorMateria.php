<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Actividad\Materia;
use App\Entidades\Actividad\Actividad;
use App\Entidades\Publico\Departamento;

require app_path().'/start/constants.php';
use Session;

class ControladorMateria extends Controller{
    public function index(){
        $titulo = "Materias";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('actividad.materia-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Materia();
        $aMateria = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aMateria) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aMateria) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = $aMateria[$i]->idmateria;
                $row[] = '<a href="/actividad/materia/' . $aMateria[$i]->idmateria . '">' . $aMateria[$i]->descmateria . '</a>';
                $row[] = $aMateria[$i]->descactividad;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aMateria), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aMateria),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nueva materia";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $dpto = new Departamento();
                    $array_dpto = $dpto->obtenerTodos();

                    $actividad = new Actividad();
                    $array_actividad = $actividad->obtenerTodos();

                     return view('actividad.materia-nuevo', compact('titulo', 'array_dpto', 'array_actividad'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar materia";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $materia = new Materia();
                $materia->obtenerPorId($id);

                $dpto = new Departamento();
                $array_dpto = $dpto->obtenerTodos();

                $actividad = new Actividad();
                $array_actividad = $actividad->obtenerTodos();

                return view('actividad.materia-nuevo', compact('materia', 'titulo', 'array_dpto', 'array_actividad'));
            }
        } else {
           return redirect('login');
        }
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar materia";
            $entidad = new Materia();
            $entidad->cargarDesdeRequest($request);

            $dpto = new Departamento();
            $array_dpto = $dpto->obtenerTodos();

            $actividad = new Actividad();
            $array_actividad = $actividad->obtenerTodos();

            //validaciones
            if ($entidad->descmateria == "" || $entidad->ncmateria == "" || $entidad->fk_idactividad == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = FALTANOMBRE; //ARREGLAR
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
                $_POST["id"] = $entidad->idmateria;

                return view('actividad.materia-listado', compact('titulo', 'msg'));
                //return view('actividad.materia-nuevo', compact('msg', 'materia', 'titulo', 'array_dpto', 'array_actividad')) . '?id=' . $materia->idmateria;
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        return view('actividad.materia-nuevo', compact('msg', 'titulo', 'array_dpto', 'array_actividad'));
    }

      public function agregarMateriaAjax(Request $request){
        try {
            $descmateria = $request->input('descmateria');
            $fk_iddepto = $request->input('dpto');
            $ncmateria = $request->input('ncmateria');
            $fk_idactividad = $request->input('actividad');
            $periodo = $request->input('periodo');
            $cargahorariaendias = $request->input('hsendias');
            $cargahorariaenhs = $request->input('hsenhs');

            $entidad = new Materia();
            $entidad->descmateria = $descmateria;
            $entidad->fk_iddepto = $fk_iddepto;
            $entidad->ncmateria = $ncmateria;
            $entidad->fk_idactividad = $fk_idactividad;
            $entidad->periodo = $periodo;
            $entidad->cargahorariaendias = $cargahorariaendias;
            $entidad->cargahorariaenhs =  $cargahorariaenhs;

            //validaciones
            if ($entidad->descmateria == "" || $entidad->ncmateria == "" || $entidad->fk_idactividad == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los campos"; //ARREGLAR
            } else {
                $idMateria = $entidad->insertar();
                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                $msg["idMateria"] = $idMateria;
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        echo json_encode($msg);
    }

     public function modificarMateriaAjax(Request $request){
        try {
            $idmateria = $request->input('idmateria');
            $descmateria = $request->input('descmateria');
            $fk_iddepto = $request->input('dpto');
            $ncmateria = $request->input('ncmateria');
            $fk_idactividad = $request->input('actividad');
            $periodo = $request->input('periodo');
            $cargahorariaendias = $request->input('hsendias');
            $cargahorariaenhs = $request->input('hsenhs');

            $entidad = new Materia();

            $entidad->idmateria = $idmateria;            
            $entidad->descmateria = $descmateria;
            $entidad->fk_iddepto = $fk_iddepto;
            $entidad->ncmateria = $ncmateria;
            $entidad->fk_idactividad = $fk_idactividad;
            $entidad->periodo = $periodo;
            $entidad->cargahorariaendias = $cargahorariaendias;
            $entidad->cargahorariaenhs =  $cargahorariaenhs;

            //validaciones
            if ($entidad->idmateria == "" || $entidad->descmateria == "" || $entidad->ncmateria == "" || $entidad->fk_idactividad == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los campos"; //ARREGLAR
            } else {
                $idMateria = $entidad->guardar();
                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                $msg["idMateria"] = $idMateria;
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        echo json_encode($msg);
    }

    public function obtenerMaterias(){
        $entidad = new Materia();
        $aEntidad = $entidad->obtenerTodos();
        echo json_encode($aEntidad);
    }

    public function buscarMateria(Request $request){
        $idMateria = $request->input('materia');
        $entidad = new Materia();
        $aEntidad = $entidad->obtenerPorId($idMateria);
        echo json_encode($aEntidad);
    }

    public function obtenerTodosPorPlanAjax(Request $request){
        $id = $request->input("plan");
        $entidad = new Materia();
        $aEntidad = $entidad->obtenerTodosPorPlan($id);
        echo json_encode($aEntidad);
    }
}
