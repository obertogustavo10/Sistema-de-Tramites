<?php

namespace App\Http\Controllers;

use App\Formulario;
use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;

require app_path().'/start/constants.php';
use Session;

class ControladorTramiteNuevo extends Controller
    {
        public function index()
        {
        $titulo = "Nuevo Trámite";
        if(Usuario::autenticado() == true)
        {
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                //$aTramites = \DB::table('formularios')->select('idformulario','nombre', 'descripcion', 'url')->get();
                $tramites = Formulario::all();
                return view('configuracion.tramite-nuevo', compact('tramites'));
            }
        } else {
            return redirect('login');
        }
    }
        public function nuevo()
        {
            $titulo = "Nuevo Trámite";
            $tramites = Formulario::all();
            return view('configuracion.tramite-nuevo', compact('tramites'));
            
        }

}