<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;

require app_path().'/start/constants.php';
use Session;

class ControladorAutorizacionViajes extends Controller{
	public function nuevo(){
		$titulo = "Datos Autorización de Viajes";
		return view ("formulario.autorizacionviaje-nuevo", compact('titulo'));
	}
    public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Modificar Autorizacion de Viaje";
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
            return view('formulario.autorizacionviaje-listar', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }

    $id = $entidad->idvalor;
    $autorizacionViaje = new AutorizacionViaje();
    $autorizacionViaje->obtenerPorId($id);


    return view('formulario.autorizacionviaje-nuevo', compact('msg', 'autorizacionviaje', 'titulo')) . '?id=' . $autorizacionViaje->idvalor;
    }
}

 ?>
