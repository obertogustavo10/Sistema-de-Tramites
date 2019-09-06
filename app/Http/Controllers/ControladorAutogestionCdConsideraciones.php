<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Cursada\AlumnoInscripcion;

require app_path().'/start/constants.php';
use Session;

class ControladorAutogestionCdConsideraciones extends Controller {

    public function index(Request $request){
        $titulo = "Carrera docente";
        $plan_cd_activo = null;

        if(Usuario::autogestionAutenticado() == true){
            if(Session::get('alumno_id') != ""){
        		$entidad = new AlumnoInscripcion();
    			$plan_cd_activo =  $entidad->obtenerCarreraDocenteActivaPorAlumno(Session::get('alumno_id'));
            }
            return view('autogestion.cd-consideraciones', compact('titulo', 'plan_cd_activo'));
        } else {
           return redirect(env('APP_URL_AUTOGESTION') . '');
        }
    }

}
