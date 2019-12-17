<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;

require app_path().'/start/constants.php';
use Session;


class ControladorCalculoUtlidades extends Controller{
    public function nuevo(){
        $titulo = "datos del cliente";
            return view('formulario.calculoutilidades-nuevo', compact('titulo'));
        }
public function guardar(Request $request){
            try {
                //Define la entidad servicio
                $titulo = "Modificar Calculo de utilidades";
                $entidad = new Menu();
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
                    return view('formulario.Calculoutilidades-listar', compact('titulo', 'msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
    
            $id = $entidad->idvalor;
            $calculoUtilidades = new Calculoutilidades();
            $calculoUtilidades->obtenerPorId($id);
    
            return view('formulario.Calculoutilidades-nuevo', compact('msg', 'calculoUtilidades', 'titulo')) . '?id=' . $calculoUtilidades->idvalor;
        }
    }

?>