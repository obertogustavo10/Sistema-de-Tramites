<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Legajo\Alumno;
use App\Entidades\Cursada\OfertaCursada;


require app_path().'/start/constants.php';
use Session;

class ControladorActa extends Controller{
    public function index($idCursada, Request $request){
        $titulo = "Listado de inscriptos: ";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
                $codigo = "CARGOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $oferta = new OfertaCursada();
                $cursada = $oferta->obtenerPorId($idCursada);
                $titulo .= $cursada->descmateria;


                $cant_inscriptos = $oferta->cantidadDeAlumnosInscriptos($cursada->fk_idplan, $idCursada);


                return view('inscripcion.inscriptos-acta', compact('titulo', 'cursada', 'cant_inscriptos'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(Request $request){
        $request = $_REQUEST;
        $idOferta = $_REQUEST["oferta"];

        $entidad = new Alumno();
        $legajos = $entidad->obtenerGrillaPorOferta($idOferta);

        $data = array();
        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($legajos) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($legajos) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/legajo/alumno/' . $legajos[$i]->idalumno . '">' . $legajos[$i]->documento . '</a>';
                $row[] = '<a href="/legajo/alumno/' . $legajos[$i]->idalumno . '">' . " " . $legajos[$i]->nombre . " " . $legajos[$i]->apellido . '</a>';
                $row[] = '<a target="_blank" href="https://webmail.fmed.uba.ar/zimbra/h/search?action=compose&to=' . $legajos[$i]->email . '">' . $legajos[$i]->email . '</a>';
                $row[] = $legajos[$i]->celular;
                $row[] = $legajos[$i]->estado;
                $htmlAccion = '<select id="lstAccion_' . $legajos[$i]->documento . '" class="form-control" onchange="fAccion('.$legajos[$i]->idalumno . ', '.$legajos[$i]->documento . ')"><option selected disabled>Seleccionar</option>';
                
                if (Patente::autorizarOperacion("SIMULARALUMNO")) {
                    $htmlAccion .= '<option value="simular-login">Simular login</option>';
                }
                $htmlAccion .= '<option value="constancia-inscripcion">Constancia de inscripción</option>';
                $htmlAccion .= '</select>';
                $row[] = $htmlAccion;
                
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($legajos),
            "recordsFiltered" => count($legajos),
            "data" => $data
        );
        return json_encode($json_data);
    }
}