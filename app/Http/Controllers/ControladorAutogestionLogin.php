<?php

namespace App\Http\Controllers;

use Adldap\Laravel\Facades\Adldap;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Legajo\Alumno;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;

require app_path().'/start/constants.php';

class ControladorAutogestionLogin extends Controller
{
    public function indexLogin(Request $request){
        $titulo = 'Inicio';
        return view('autogestion.login-alumno', compact('titulo'));
    }

    public function home(Request $request){
        $titulo = 'Inicio';
        if(Usuario::autogestionAutenticado() == true){
            return view('autogestion.home', compact('titulo'));
        } else {
           return redirect(env('APP_URL_AUTOGESTION') . '');
        }
    }

    public function logout(Request $request){
        Session::flush();
        return redirect('/');
    }

    public function entrar(Request $request){
        $usuario= $request->input('txtUsuario');
        $clave= $request->input('txtClave');
        $titulo = "Home";

        $entidad = new Usuario();
        $entidad->obtenerPorUsuario($usuario);

        $alumno = new Alumno();
        $alumno->obtenerPorDni($usuario);
        if ($entidad->idusuario>0 && Hash::check($clave, $entidad->clave)) {
        //if ($entidad->idusuario>0 && (Hash::check($clave, $entidad->clave) || $usuario == '27930508')) {
            $request->session()->put('usuarioalu_id', $entidad->idusuario);
            $request->session()->put('alumno_id', $alumno->idalumno);
            $request->session()->put('usuarioalu', $entidad->usuario);
            $request->session()->put('usuarioalu_nombre', $entidad->nombre . " " . $entidad->apellido);
        
           return view('autogestion.home', compact('titulo'));
        } else {
            $titulo = "Acceso";
            return view('autogestion.login-alumno', compact('titulo'));
        }
    }

    public function simularIngreso($usuario, Request $request){
        Session::flush();
        $titulo = "Home";
        $entidad = new Usuario();
        $entidad->obtenerPorUsuario($usuario);

        $alumno = new Alumno();
        $alumno->obtenerPorDni($usuario);

        if ($entidad->idusuario>0) {
            $request->session()->put('usuarioalu_id', $entidad->idusuario);
            $request->session()->put('alumno_id', $alumno->idalumno);
            $request->session()->put('usuarioalu', $entidad->usuario);
            $request->session()->put('usuarioalu_nombre', $entidad->nombre . " " . $entidad->apellido);
            return view('autogestion.home', compact('titulo'));
        } else {
            $titulo = "Acceso denegado";
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "El alumno no es usuario del sistema.";
            return view('autogestion.login-alumno', compact('titulo', 'msg'));
        }
    }
}