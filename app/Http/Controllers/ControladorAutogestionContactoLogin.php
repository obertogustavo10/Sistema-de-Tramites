<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Publico\TipoDocumento;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require app_path().'/start/constants.php';
use Session;

class ControladorAutogestionContactoLogin extends Controller
{
    public function index(){
        $titulo = "Formulario de contacto";

     	$tipodocumento = new TipoDocumento();
        $array_tipodocumento = $tipodocumento->obtenerTodos();

        return view('autogestion.contacto-login', compact('titulo', 'array_tipodocumento'));
    }

    public function enviar(Request $request){
      $titulo = "Formulario de contacto";
      $tipodocumento = new TipoDocumento();
      $array_tipodocumento = $tipodocumento->obtenerTodos();
      $nombre = $request->input('txtNombre');
      $apellido = $request->input('txtApellido');
      $tipoDoc = $request->input('lstTipoDoc');
      $dni = $request->input('txtDocumento');
      $mensaje = $request->input('txtMensaje');
      $asunto = "Posgrado | Contacto desde la Web";
      $email = $request->input('txtCorreo');

   		$subject = "DePC Suite - $asunto";
      	$body = "Has recibido un mensaje de la web de alumnos de DePC Suite<br><br><strong>Usuario:</strong> $nombre $apellido<br><strong>Documento</strong>: $dni<br><strong>Correo</strong>: $email<br><br><strong>Mensaje</strong><br>$mensaje";
      	ControladorGeneral::enviarMail("info@depcsuite.com", utf8_decode($subject), utf8_decode($body), $email);
      	
      	$msg["ESTADO"] = MSG_SUCCESS;
     	  $msg["MSG"] = "Mensaje enviado, en breve te estaremos respondiendo.";
      	return view('autogestion.login-alumno', compact('titulo', 'msg'));
    }

}
