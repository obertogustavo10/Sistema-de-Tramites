<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Cursada\FormuCabecera;

require app_path().'/start/constants.php';
use Session;

class ControladorAutogestionConstancia extends Controller
{
    public function index(Request $request){
        $titulo = "Constancias de Inscripción";
        $array_comprobantes = array();

        if(Usuario::autogestionAutenticado() == true){
            $dni = Session::get("usuarioalu");

            $formCabecera = new FormuCabecera();
            $array_comprobantes = $formCabecera->obtenerTodosPorAlumno($dni);


            return view('autogestion.constancias', compact('titulo', 'array_comprobantes'));
        } else {
           return redirect(env('APP_URL_AUTOGESTION') . '');
        }
    }

}
