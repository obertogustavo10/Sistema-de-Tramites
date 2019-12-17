<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Configuracion\Formulario;

require app_path().'/start/constants.php';
use Session;

class ControladorConfiguracionFormularios extends Controller
    {
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