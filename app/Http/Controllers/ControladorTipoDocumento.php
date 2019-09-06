<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Publico\TipoDocumento;

require app_path().'/start/constants.php';
use Session;

class ControladorTipoDocumento extends Controller{
    public function index(){
        $titulo = "Tipos de documentos";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('publico.tipodocumento-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new TipoDocumento();
        $tipodocumento = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($tipodocumento) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($tipodocumento) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/publico/tipodocumento/' . $tipodocumento[$i]->idtidoc . '">' . $tipodocumento[$i]->desctidoc . '</a>';
                $row[] = $tipodocumento[$i]->nctidoc;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($tipodocumento), //cantidad total de registros sin paginar
            "recordsFiltered" => count($tipodocumento),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nueva Tipo de documento";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                     return view('publico.tipodocumento-nuevo', compact('titulo'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar Tipo de documento";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $tipodocumento = new TipoDocumento();
                $tipodocumento->obtenerPorId($id);

                return view('publico.tipodocumento-nuevo', compact('tipodocumento', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("CARGOELIMINAR")){
                $tipodocumento = new TipoDocumento();
                $tipodocumento->cargarDesdeRequest($request);
                $tipodocumento->eliminar();
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
            $titulo = "Modificar Tipo de documento";
            $entidad = new TipoDocumento();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->desctidoc == "") {
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
                $_POST["id"] = $entidad->idtidoc;
                return view('publico.tipodocumento-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idtidoc;
        $tipodocumento = new TipoDocumento();
        $tipodocumento->obtenerPorId($id);

        return view('publico.tipodocumento-nuevo', compact('msg', 'tipodocumento', 'titulo')) . '?id=' . $tipodocumento->id;
    }

    
    
}
