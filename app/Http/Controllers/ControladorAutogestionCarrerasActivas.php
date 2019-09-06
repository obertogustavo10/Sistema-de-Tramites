<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario_grupo;
use App\Entidades\Sistema\Usuario_familia;
use App\Entidades\Cursada\AlumnoInscripcion;

require app_path().'/start/constants.php';
use Session;

class ControladorAutogestionCarrerasActivas extends Controller
{

    public function editar(){
        $titulo = "Datos personales";
        if(Usuario::autogestionAutenticado() == true){
            $dni = Session::get("usuarioalu");

            $entidad = new AlumnoInscripcion();
            $array_carreraactiva =  $entidad->obtenerCarrerasActivasPorDni(Session::get('usuarioalu'));

            return view('autogestion.carrerasactivas', compact('titulo', 'array_carreraactiva'));
        } else {
           return redirect(env('APP_URL_AUTOGESTION') . '');
        }
    }

}
