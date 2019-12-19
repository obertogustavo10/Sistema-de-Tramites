<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Tramite\Tramite;

require app_path().'/start/constants.php';
use Session;

class ControladorTramiteNuevo extends Controller
    {
        public function index()
        {
        $titulo = "Nuevo Trámite";
        if(Usuario::autenticado() == true)
        {
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('configuracion.tramite-nuevo', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadFormulario = new Formulario();
        $aFormulario = $entidadFormulario->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aFormulario) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aFormulario) && $cont < $registros_por_pagina; $i++) 
            {
                $row = array();
                $row[] = '<a href="/cofiguracion/formularios/' . $aFormulario[$i]->idformulario . '">' . $aFormulario[$i]->nombre . '</a>';
                $row[] = $aFormulario[$i]->nombre;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aFormulario), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aFormulario),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }
        public function nuevo()
        {
            $titulo = "Nuevo Formulario";
            return view("configuracion.formulario-nuevo", compact('titulo'));
        }
    
        public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Formulario";
            $entidad = new Formulario();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {
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
                
                return view('configuracion.formularios-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idformulario;
        $formulario = new Formulario();
        $formulario->obtenerPorId($id);

        return view('configuracion.formulario-nuevo', compact('msg', 'menu', 'titulo', 'array_menu', 'array_menu_grupo')) . '?id=' . $formulario->idformulario;
    }
}