<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Publico\TipoDocumento;
use App\Entidades\Cursada\FormuCabecera;
use App\Entidades\Legajo\Alumno;

require app_path().'/start/constants.php';
use Session;

class ControladorInscripcionConstancia extends Controller
{
    public function index($idAlumno, Request $request){
        $titulo = "Constancia de Inscripción";
        $array_comprobantes = null;

        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $legajo = new Alumno();
                $legajo->obtenerPorId($idAlumno);

                $formCabecera = new FormuCabecera();
                $array_comprobantes = $formCabecera->obtenerTodosPorAlumno($legajo->documento);
                if(count($array_comprobantes)==0)
                    $array_comprobantes = null;

                $tipodocumento = new TipoDocumento();
                $array_tipodocumento = $tipodocumento->obtenerTodos();

                return view('inscripcion.constancia', compact('titulo', 'array_tipodocumento', 'array_comprobantes', 'legajo'));
            }
        } else {
            return redirect('login');
        }
    }

}
