<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Formularios\Calculo_vacaciones;

require app_path().'/start/constants.php';
use Session;

class ControladorCalculoVacaciones extends Controller
    {
        public function nuevo()
        {
            $titulo = "Calculo de Vacaciones";
            return view("tramites.calculovacaciones-nuevo", compact('titulo'));
        }
    
        public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Formulario";
            $entidad = new Calculo_vacaciones();
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
                
                return view('formularios.calculo_vacaciones-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $calculo_vacaciones->idvalor;
        $calculo_vacaciones = new calculo_vacaciones();
        $calculo_vacaciones->obtenerPorId($id);

        return view('formularios.calculo_vacaciones', compact('msg', 'menu', 'titulo', 'array_menu', 'array_menu_grupo')) . '?id=' . $calculo_vacaciones->idvalor;
    }
}