<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;

require app_path().'/start/constants.php';
use Session;

class ControladorAutogestionMenuInscripcion extends Controller {

    public function index(Request $request){
        $titulo = "Menu de inscripciones";
        if(Usuario::autogestionAutenticado() == true){
        	return view('autogestion.menu-inscripcion', compact('titulo'));
        } else {
           return redirect(env('APP_URL_AUTOGESTION') . '');
        }
    }

}
