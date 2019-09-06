<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session, Hash;

require app_path().'/start/constants.php';

class ControladorAutogestionCambioClave extends Controller
{
    public function index($mail, $token){
        $titulo = 'Cambio clave';
        $token = $token;
        $mail = $mail;

        $usuario = new Usuario();
        if($usuario->validarToken($mail, $token)){
            return view('autogestion.cambio-clave', compact('titulo', 'token', 'mail'));
        } else {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "El link para el cambio de clave no es válido.";
            return view('autogestion.login-alumno', compact('titulo', 'msg'));
        }
    }

    public function cambiarClave(Request $request){
        $titulo='Cambio clave';
        $mail= $request->input('_mail');
        $token= $request->input('_tokenmail');
        $clave= $request->input('txtClave');
        $confirmPassword= $request->input('confirmPassword');

        if($clave == $confirmPassword){
            $claveHash= Hash::make($clave);
            $usuario = new Usuario();
            if($usuario->validarToken($mail, $token)){
                $usuario->obtenerPorMail($mail);
                $usuario->guardarClave($usuario->idusuario, $claveHash);
                $dni = $usuario->usuario;

                try {
                    $token = csrf_token();
                    $usuario->guardarToken($mail, '');

                    $subject = 'UBA Posgrado | Nueva clave generada';
                    $body = "Se ha generado nuevos datos de acceso para el sistema de posgrado, los datos son:<br><br>Usuario: $dni<br>Clave: $clave<br><br>http://posgrado.fmed.uba.ar";
                    ControladorGeneral::enviarMail($mail, $subject, $body);

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = "Clave cambiada, te llegará un correo electrónico con los datos generados.";
                    return view('autogestion.login-alumno', compact('titulo', 'msg'));  

                } catch (Exception $e) {
                    $msg["ESTADO"] = MSG_ERROR;
                    $msg["MSG"] = "Hubo un error al enviar el correo, intenta nuevamente.";
                    return view('autogestion.cambio-clave', compact('titulo', 'token', 'mail', 'msg'));
                }  
            } else {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "El link para el cambio de clave no es válido.";
                return view('autogestion.login-alumno', compact('titulo', 'msg'));
            }
        } else {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Su nueva clave y confirmación no coinciden.";
            return view('autogestion.cambio-clave', compact('titulo',  'token', 'mail', 'msg'));
        }
    }

}