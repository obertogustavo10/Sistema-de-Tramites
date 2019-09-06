<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Publico\Dependencia;
use App\Entidades\Legajo\Legajo;

require app_path().'/start/constants.php';
use Session;

class ControladorDependencia extends Controller{
    public function index(){
        $titulo = "Areas";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('publico.dependencia-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Dependencia();
        $aDependencia = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aDependencia) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aDependencia) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/publico/dependencia/' . $aDependencia[$i]->iddependencia . '">' . $aDependencia[$i]->descdependencia . '</a>';
                $row[] = $aDependencia[$i]->ncdependencia;
                $row[] = $aDependencia[$i]->interno;
                $row[] = $aDependencia[$i]->nombre_responsable . " " . $aDependencia[$i]->apellido_responsable;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aDependencia), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aDependencia),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nueva Área";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $legajo = new Legajo();
                    $array_legajo = $legajo->obtenerTodos();

                    $entidad = new Dependencia();
                    $array_dependencia = $entidad->obtenerSubDependencias();

                     return view('publico.dependencia-nuevo', compact('titulo', 'array_legajo', 'array_dependencia'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar Área";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $dependencia = new Dependencia();
                $dependencia->obtenerPorId($id);

                $legajo = new Legajo();
                $array_legajo = $legajo->obtenerTodos();

                $entidad = new Dependencia();
                $array_dependencia = $entidad->obtenerSubDependencias($id);

                return view('publico.dependencia-nuevo', compact('dependencia', 'titulo', 'array_legajo', 'array_dependencia'));
            }
        } else {
           return redirect('login');
        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("CARGOELIMINAR")){
                $dependencia = new Dependencia();
                $dependencia->cargarDesdeRequest($request);
                $dependencia->eliminar();
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
            $titulo = "Modificar Área";
            $entidad = new Dependencia();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->descdependencia == "") {
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
                $_POST["id"] = $entidad->iddependencia;
                return view('publico.dependencia-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $dependencia = new Dependencia();
        $dependencia->obtenerPorId($entidad->iddependencia);

        $legajo = new Legajo();
        $array_legajo = $legajo->obtenerTodos();

        $entidad = new Dependencia();
        $array_dependencia = $entidad->obtenerSubDependencias($entidad->iddependencia);

        return view('publico.dependencia-nuevo', compact('msg', 'dependencia', 'titulo', 'array_legajo', 'array_dependencia')) . '?id=' . $dependencia->iddependencia;
    }

    
    
}
