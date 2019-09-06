<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Publico\SituacionImpositiva;

require app_path().'/start/constants.php';
use Session;

class ControladorSituacionImpositiva extends Controller{
    public function index(){
        $titulo = "Situación impositiva";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('publico.situacionimpositiva-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new SituacionImpositiva();
        $situacionImpositiva = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($situacionImpositiva) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($situacionImpositiva) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/publico/situacionimpositiva/' . $situacionImpositiva[$i]->idiva . '">' . $situacionImpositiva[$i]->desciva . '</a>';
                $row[] = $situacionImpositiva[$i]->nciva;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($situacionImpositiva), //cantidad total de registros sin paginar
            "recordsFiltered" => count($situacionImpositiva),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nueva Situacion Impositiva";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                     return view('publico.situacionimpositiva-nuevo', compact('titulo'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar Situación Impositiva";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $situacionImpositiva = new SituacionImpositiva();
                $situacionImpositiva->obtenerPorId($id);

                return view('publico.situacionimpositiva-nuevo', compact('situacionImpositiva', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("CARGOELIMINAR")){
                $situacionImpositiva = new SituacionImpositiva();
                $situacionImpositiva->cargarDesdeRequest($request);
                $situacionImpositiva->eliminar();
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
            $titulo = "Modificar Situación impositiva";
            $entidad = new SituacionImpositiva();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->desciva == "") {
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
                $_POST["id"] = $entidad->idiva;
                return view('publico.situacionimpositiva-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idiva;
        $situacionImpositiva = new SituacionImpositiva();
        $situacionImpositiva->obtenerPorId($id);

        return view('publico.situacionimpositiva-nuevo', compact('msg', 'situacionImpositiva', 'titulo')) . '?id=' . $situacionImpositiva->idiva;
    }

    
    
}
