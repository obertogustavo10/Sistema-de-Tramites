<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Publico\Sede;

require app_path().'/start/constants.php';
use Session;

class ControladorSede extends Controller{
    public function index(){
        $titulo = "Sedes";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('publico.sede-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Sede();
        $sede = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($sede) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($sede) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/publico/sede/' . $sede[$i]->idsede . '">' . $sede[$i]->ncsede . '</a>';
                $row[] = $sede[$i]->descsede;
                $row[] = $sede[$i]->domicilio;
                $row[] = $sede[$i]->telefono;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($sede), //cantidad total de registros sin paginar
            "recordsFiltered" => count($sede),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nueva Sede";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                     return view('publico.sede-nuevo', compact('titulo'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar Sede";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $sede = new Sede();
                $sede->obtenerPorId($id);

                return view('publico.sede-nuevo', compact('sede', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("CARGOELIMINAR")){
                $sede = new Sede();
                $sede->cargarDesdeRequest($request);
                $sede->eliminar();
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
            $titulo = "Modificar Sede";
            $entidad = new Sede();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->descsede == "" && $entidad->ncsede == "") {
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
                $_POST["id"] = $entidad->idsede;
                return view('publico.sede-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idsede;
        $sede = new Sede();
        if($id>0)
        	$sede->obtenerPorId($id);

        return view('publico.sede-nuevo', compact('msg', 'sede', 'titulo')) . '?id=' . $sede->id;
    }

     public function agregarSedeAjax(Request $request){
        try {
            $descripcion = $request->input('descripcion');
            $nombre = $request->input('nombre');
            $domicilio = $request->input('domicilio');
            $url = $request->input('url');
            $telefono = $request->input('telefono');
            $contacto = $request->input('contacto');
            $comentario = $request->input('comentario');

            $entidad = new Sede();
            $entidad->descsede = $descripcion;
            $entidad->ncsede = $nombre;
            $entidad->domicilio = $domicilio;
            $entidad->urlweb = $url;
            $entidad->telefono = $telefono;
            $entidad->contacto = $contacto;
            $entidad->comentarios = $comentario;

            //validaciones
            if ($entidad->descsede == "" || $entidad->ncsede == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los campos";
            } else {
                $idSede = $entidad->insertar();
                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
                $msg["idModulo"] = $idSede;
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        echo json_encode($msg);
    }

    public function obtenerTodos(Request $request){
        $entidad = new Sede();
        $aEntidad = $entidad->obtenerTodos();
        echo json_encode($aEntidad);
    }

    public function obtenerSubSede(Request $request){
        $idSede = $request->input("idSede");
        $entidad = new Sede();
        $aEntidad = $entidad->obtenerSubSede($idSede);
        echo json_encode($aEntidad);
    }
    
    
}
