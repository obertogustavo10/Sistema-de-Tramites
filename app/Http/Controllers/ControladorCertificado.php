<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario_grupo;
use App\Entidades\Sistema\Usuario_familia;
use App\Entidades\Publico\TipoDocumento;
use App\Entidades\Legajo\Alumno;
use App\Entidades\Cursada\Certificado;

require app_path().'/start/constants.php';
use Session;

class ControladorCertificado extends Controller
{
    public function index(){
        $titulo = "Listado de certificados";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOCONSULTA")) {
                $codigo = "USUARIOCONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('certificado.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de certificados";

                $alumno = new Alumno();
                $array_alumno  = $alumno->obtenerTodos();

                return view('certificado.certificado-listar', compact('titulo', 'array_alumno'));
            }
        } else {
           return redirect('login');
        }
    }
   

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Certificado();
        $certificado = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($certificado) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($certificado) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = $certificado[$i]->idcertificado;
                $row[] = '<a href="/legajo/alumno/' . $certificado[$i]->idalumno . '">' . $certificado[$i]->documento . '</a>';
                $row[] = '<a href="/legajo/alumno/' . $certificado[$i]->idalumno . '">' . " " . $certificado[$i]->nombre . " " . $certificado[$i]->apellido . '</a>';
                $row[] = $certificado[$i]->fecha_aprobacion;
                $row[] = $certificado[$i]->notaenletras;
                   
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($certificado),
            "recordsFiltered" => count($certificado),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request){
        //$idCertificado = $request->input('idCertificado');
        $idAlumno = $request->input('idAlumno');
        $calificacion = $request->input('calificacion');
        $fecha = $request->input('fecha');

        if ($idAlumno > 0) {
            $entidad = new Certificado();
            $entidad->fk_idalumno = $idAlumno;
            $entidad->fk_idnota = $calificacion;
            $entidad->fecha_aprobacion = $fecha;
            $entidad->insertar();

            $msg["ESTADO"] = MSG_SUCCESS;
            $msg["MSG"] = OKINSERT;
        }
        return json_encode($msg);
    }

    public function obtenerPorId($idCertificado){
        $entidad = new Certificado();
        $resultado = $entidad->obtenerPorId($idCertificado);
        return json_encode($resultado);
    }    
}
