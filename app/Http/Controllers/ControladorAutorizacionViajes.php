<?php 

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Tramite\Tramite;
use App\Entidades\Formularios\AutorizacionViaje;
require app_path().'/start/constants.php';
use Session;
use DateTime;

class ControladorAutorizacionViajes extends Controller{
	
    public function nuevo(){
		$titulo = "Datos Autorización de Viajes";
		return view ("tramites.autorizacionviaje-nuevo", compact('titulo'));
	}

    public function editar($id){
        $titulo = "Modificar Autorización de Viaje";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $autorizacionViaje = new AutorizacionViaje();
                $autorizacionViaje->obtenerPorId($id);
//print_r($poderEspecial);exit;
                return view('tramites.autorizacionviaje-nuevo', compact('autorizacionViaje', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }
    public function guardar(Request $request){
    try {
        //Define la entidad servicio
        $titulo = "Nueva Autorización de Viaje";
        $autorizacionViaje = new AutorizacionViaje();
        $autorizacionViaje->cargarDesdeRequest($request);

        //validaciones
        if ($autorizacionViaje->nombremadre == "") {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Ingrese Nombre de la Madre o Tutora"; //ARREGLAR
        } else {
            if ($_POST["id"] > 0) {
                //Es actualizacion
                $autorizacionViaje->guardar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
            } else {
                //Es nuevo
                 $fechaActual = new DateTime();
                    $tramite = new Tramite();
                    $tramite->rectificativa = 0;
                    $tramite->fecha_inicio = $fechaActual;
                    $tramite->fk_idcliente = Session::get('usuario_id');//Persona q inica el tramite
                    $tramite->fk_idformulario = 5;
                    $tramite->fk_idtramite_estado = 1;
                    $tramite->idtramite = $tramite->insertar();

                    //Inserta los valores del formulario
                    $autorizacionViaje->idtramite =  $tramite->idtramite;
                $autorizacionViaje->insertar();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
            }
            $titulo = "Listado de trámites";
            return view('estado.iniciados', compact('titulo', 'msg'));
        }
    } catch (Exception $e) {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = ERRORINSERT;
    }

    $id = $autorizacionViaje->idtramite;
    $autorizacionViaje = new AutorizacionViaje();
    //$autorizacionViaje->obtenerPorId($id);
    

    return view('tramites.autorizacionviaje-nuevo', compact('msg', 'autorizacionviaje', 'titulo')) . '?id=' . $autorizacionViaje->idvalor;
    }
}

 ?>
