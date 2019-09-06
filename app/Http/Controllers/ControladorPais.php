<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Publico\Pais;
use App\Entidades\Publico\Provincia;

require app_path().'/start/constants.php';
use Session;

class ControladorPais extends Controller{
    public function index(){
        $titulo = "Países";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('publico.pais-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Pais();
        $pais = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($pais) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($pais) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/publico/pais/' . $pais[$i]->idpais . '">' . $pais[$i]->descpais . '</a>';
                $row[] = $pais[$i]->ncpais;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($pais), //cantidad total de registros sin paginar
            "recordsFiltered" => count($pais),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nuevo País";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                     return view('publico.pais-nuevo', compact('titulo'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar País";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $pais = new Pais();
                $pais->obtenerPorId($id);

                return view('publico.pais-nuevo', compact('pais', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("CARGOELIMINAR")){
                $pais = new Pais();
                $pais->cargarDesdeRequest($request);
                $pais->eliminar();
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
            $entidad = new Pais();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->descpais == "") {
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
                $_POST["id"] = $entidad->idpais;
                return view('publico.pais-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idpais;
        $pais = new Pais();
        $pais->obtenerPorId($id);

        return view('publico.pais-nuevo', compact('msg', 'pais', 'titulo')) . '?id=' . $pais->idpais;
    }

    public function buscarProvincia(Request $request){
        $aResultado = null;
        $idPais = $request->input('pais');
        if($idPais>0){
            $provincia = new Provincia();
            $aProvincia = $provincia->obtenerPorPais($idPais);
            $aResultado = $aProvincia; 
        }
        echo json_encode($aResultado);
    }
    
    
}
