<?php

namespace App\Http\Controllers;

use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Grupo;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Menu;
use App\Entidades\Legajo\Legajo;
use App\Entidades\Legajo\Alumno;
use App\Entidades\Publico\TipoDocumento;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Session, Hash;

require app_path().'/start/constants.php';

class ControladorAutogestionRegistroUsuario extends Controller
{
    public function index(Request $request){
        $titulo = 'Nuevo usuario';

        $tipodocumento = new TipoDocumento();
        $array_tipodocumento = $tipodocumento->obtenerTodos();

        return view('autogestion.registro-usuario', compact('titulo', 'array_tipodocumento'));
    }

 	public function guardar(Request $request){
   		$titulo = 'Acceso';
   		$nombre = $request->input('txtNombre');
   		$apellido = $request->input('txtApellido');
   		$dni = $request->input('txtDNI');
   		$celular = $request->input('txtCelular');
   		$mail = $request->input('txtEmail');
   		$clave = $request->input('txtClave');
      $confirmPassword = $request->input('confirmPassword');
    	$tipoDoc = $request->input('lstTipoDoc');

    	$tipodocumento = new TipoDocumento();
      $array_tipodocumento = $tipodocumento->obtenerTodos();


    if($clave == $confirmPassword){
   		 //Busca que ya no exista el usuario por mail o dni
   		 $usuario = new Usuario();
     		if($usuario->verificarExistenciaMail($mail)){
          $msg["ESTADO"] = MSG_ERROR;
          $msg["MSG"] = "El mail ya existe.";
          return view('autogestion.registro-usuario', compact('titulo', 'msg', 'array_tipodocumento'));
     		}
     		if($usuario->obtenerPorUsuario($dni)){
          $msg["ESTADO"] = MSG_ERROR;
          $msg["MSG"] = "El usuario ya se encuentra registrado.";
          return view('autogestion.registro-usuario', compact('titulo', 'msg', 'array_tipodocumento'));
     		}
     		//Si no existe busca si hay datos del alumnos ya cargado y lo asocia con el usuario
     		$alumno = new Alumno();
     		$alumno->obtenerPorDni($dni);

     		if($alumno->idalumno>0){
  	        $usuario->nombre = $alumno->nombre;
  	        $usuario->apellido = $alumno->apellido;
            $alumno->celular = $celular;
            $alumno->email = $mail;
            $alumno->guardar();
     		} else {
          //Lo da de alta en el legajo
          $usuario->nombre = $request->input('txtNombre');
          $usuario->apellido = $request->input('txtApellido');

          $alumno->nombre = $usuario->nombre;
          $alumno->apellido = $usuario->apellido;
          $alumno->fk_idtidoc = $tipoDoc;
          $alumno->documento = $dni;
          $alumno->celular = $celular;
          $alumno->email = $mail;
          $alumno->insertar();
  		  }
        $usuario->mail = $mail;
        $usuario->cantidad_bloqueo = 0;
        $usuario->usuario = $dni;
        $usuario->clave = Hash::make($clave);
        $usuario->insertar();

     		//Envia al correo para verificar la cuenta de usuario
     		$subject = 'DePC Suite';
        $body = "Te has registrado en el sistema de alumnos de DePC Suite, los datos de acceso son:<br><br>Usuario: $dni<br>Clave: $clave<br><br>https://autogestion.depcsuite.com";
        ControladorGeneral::enviarMail($usuario->mail, $subject, $body);

        $msg["ESTADO"] = MSG_SUCCESS;
        $msg["MSG"] = "Registro exitoso, te llegará un correo electrónico con los datos generados.";
  		  return view('autogestion.login-alumno', compact('titulo', 'msg'));       

      } else {
        $msg["ESTADO"] = MSG_ERROR;
        $msg["MSG"] = "Su nueva clave y confirmación no coinciden.";
        return view('autogestion.registro-usuario', compact('titulo', 'array_tipodocumento', 'msg'));
      }         
    }


}