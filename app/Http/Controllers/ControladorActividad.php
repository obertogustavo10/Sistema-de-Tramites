<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Actividad\Actividad;
use App\Entidades\Legajo\Personal;
use App\Entidades\Publico\Sede;
use App\Entidades\Actividad\SedeActividad;

require app_path().'/start/constants.php';
use Session;

class ControladorActividad extends Controller{
    public function index(){
        $titulo = "Actividades";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('actividad.actividad-listado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Actividad();
        $aActividad = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aActividad) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aActividad) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/actividad/actividad/' . $aActividad[$i]->idactividad . '">' . $aActividad[$i]->descactividad . '</a>';
                $row[] = $aActividad[$i]->ncactividad;
                $row[] = $aActividad[$i]->titulo_que_otorga;
                $row[] = $aActividad[$i]->nombre . " " . $aActividad[$i]->apellido;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aActividad), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aActividad),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function nuevo(){
            $titulo = "Nueva actividad";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $personal = new Personal();
                    $array_personal = $personal->obtenerTodos();

                    $sede = new Sede();
                    $array_sede = $sede->obtenerTodos();

                     return view('actividad.actividad-nuevo', compact('titulo', 'array_sede', 'array_personal'));
                }
            } else {
               return redirect('login');
            }   
    }

    public function editar($id){
        $titulo = "Modificar actividad";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $actividad = new Actividad();
                $actividad->obtenerPorId($id);

                $personal = new Personal();
                $array_personal = $personal->obtenerTodos();

                $sede = new Sede();
                $array_sede = $sede->obtenerTodos();

                return view('actividad.actividad-nuevo', compact('actividad', 'titulo', 'array_personal', 'array_sede'));
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
                $actividad->cargarDesdeRequest($request);
                $actividad->eliminar();
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
            $titulo = "Modificar actividad";
            $entidad = new Actividad();
            $entidad->cargarDesdeRequest($request);

            $personal = new Personal();
            $array_personal = $personal->obtenerTodos();

            if($request->input('txtSede') && count($request->input('txtSede'))>0){
                $sedeActividad = new SedeActividad();
                $sedeActividad->eliminarPorActividad($entidad->idactividad);
                $pos=0;
                foreach($request->input('txtSede') as $key=>$valor){
                    $sedeActividad->subdirector = $request->input('txtSubDirector')[$pos] != "undefined"? $request->input('txtSubDirector')[$pos] : NULL;
                    $sedeActividad->fk_idsedepadre = $request->input('txtSubSede')[$pos] != "undefined"? $request->input('txtSubSede')[$pos] : NULL;
                    $sedeActividad->fk_idsede = $request->input('txtSede')[$pos] != "undefined"? $request->input('txtSede')[$pos] : NULL;
                  //  $sedeActividad->fk_iddepartamento = $request->input('txtDpto') && $request->input('txtDpto')[$pos] != "undefined" ? $request->input('txtDpto')[$pos] : NULL;
                    $sedeActividad->fk_idactividad = $entidad->idactividad;
                    $sedeActividad->director = $request->input('txtDirector')[$pos] != "undefined"? $request->input('txtDirector')[$pos] : NULL;
                    $sedeActividad->insertar();
                    $pos++;
                }
            }

            //validaciones
            if ($entidad->descactividad == "") {
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
                $_POST["id"] = $entidad->idactividad;

                //return view('actividad.actividad-nuevo', compact('msg', 'actividad', 'titulo')) . '?id=' . $actividad->idactividad;
                return view('actividad.actividad-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        return view('actividad.actividad-nuevo', compact('msg', 'titulo', 'array_personal'));
    }

    function cargarGrillaSedeActividad(){
        $request = $_REQUEST;
        $idactividad = ($_REQUEST["idactividad"]);

        $entidad = new SedeActividad();
        $aSedeActividad = $entidad->obtenerTodosPorActividad($idactividad);

        $data = array();

        if (count($aSedeActividad) > 0)
            $cont=0;
            for ($i=0; $i < count($aSedeActividad); $i++) {
                $row = array();
                //$row[] = "<button type='button' title='Editar' class='btn btn fa fa-pencil' onclick='abrirEditar(". $aSedeActividad[$i]->idsedeactividad .")'></button> ";
                $row[] = $aSedeActividad[$i]->sede . "<input type='hidden' name='txtSede[]' value='" . $aSedeActividad[$i]->fk_idsede . "'>";
                $row[] = $aSedeActividad[$i]->subsede . "<input type='hidden' name='txtSubSede[]' value='" . $aSedeActividad[$i]->fk_idsedepadre . "'>";
                $row[] = '';
                $row[] = $aSedeActividad[$i]->director_nombre . " " . $aSedeActividad[$i]->director_apellido . "<input type='hidden' name='txtDirector[]' value='" . $aSedeActividad[$i]->director . "'>";
                $row[] = $aSedeActividad[$i]->subdirector_nombre . " " . $aSedeActividad[$i]->subdirector_apellido . "<input type='hidden' name='txtSubDirector[]' value='" . $aSedeActividad[$i]->subdirector . "'>";
                $row[] = "<button type='button' class='btn btn-secondary fa fa-minus-circle' onclick='eliminar(this)'></button>";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($aSedeActividad),
            "recordsFiltered" => count($aSedeActividad),
            "data" => $data
        );
        return json_encode($json_data);  
    }

}
