<?php

namespace App\Http\Controllers;

use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Grupo;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Menu;
use App\Entidades\Legajo\Legajo;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session;

class ControladorAutogestionRecuperoClave extends Controller
{
    public function index(Request $request){
        $titulo = 'Recuperar clave';
        return view('autogestion.recupero-clave', compact('titulo'));
    }

    public function recuperar(Request $request){
        $titulo='Recupero de clave';
        $email= $request->input('txtMail');

        $usuario = new Usuario();
        if($usuario->verificarExistenciaMail($email)){
            //Envia  mail con las instrucciones

            $data = "Instrucciones";

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                $token = csrf_token();

                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = env('MAIL_HOST');  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = env('MAIL_USERNAME');                 // SMTP username
                $mail->Password = env('MAIL_PASSWORD');                           // SMTP password
                $mail->SMTPSecure = env('MAIL_ENCRYPTION');                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = env('MAIL_PORT');                                    // TCP port to connect to

                //Recipients
                $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $mail->addAddress($email);              
                $mail->addReplyTo('no-reply@fmed.uba.ar');

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Recupero de clave';
                $mail->Body    = "Haz clic en el siguiente enlace para cambiar la clave: 

                ". env("APP_URL_AUTOGESTION") ."/cambio-clave/$email/" . $token;


                //Almacenar token
                $usuario->guardarToken($email, $token);

                $mail->send();

                $mensaje = "Te hemos enviado las instrucciones al correo.";
                return view('autogestion.recupero-clave', compact('titulo', 'mensaje'));

            } catch (Exception $e) {
                $mensaje = "Hubo un error al enviar el correo.";
                return view('autogestion.recupero-clave', compact('titulo', 'mensaje'));
            }  
        } else {
            return view('autogestion.recupero-clave', compact('titulo', 'mensaje'));
        }
    }

}