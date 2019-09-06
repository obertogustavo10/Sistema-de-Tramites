<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require app_path().'/start/constants.php';
use Session;

class ControladorAutogestionContactos extends Controller
{
    public function index(){
        $titulo = "Formulario de contacto";
        return view('autogestion.contactos', compact('titulo'));
    }

    public function enviar(Request $request){
      $titulo = "Formulario de contacto";
      $nombre = Session::get('usuarioalu_nombre');
      $dni = Session::get('usuarioalu');
      $mensaje = $request->input('txtMensaje');
      $asunto = $request->input('lstAsunto');


      $entidad = new Usuario();
      $entidad->obtenerPorUsuario($dni);
      $email = $entidad->mail;

      $subject = "DePC Suite - $asunto";
      $body = "Has recibido un mensaje de la web de alumnos de DePC Suite<br><br><strong>Usuario:</strong> $nombre<br><strong>Documento</strong>: $dni<br><strong>Correo</strong>: $email<br><br><strong>Mensaje</strong><br>$mensaje";
      ControladorGeneral::enviarMail("info@depcsuite.com", utf8_decode($subject), utf8_decode($body), $email);
      	
      $msg["ESTADO"] = MSG_SUCCESS;
      $msg["MSG"] = "Mensaje enviado, en breve te estaremos respondiendo.";
      	return view('autogestion.contactos', compact('titulo', 'msg'));
    }

}
