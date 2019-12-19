<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Configuracion\Formulario;

require app_path().'/start/constants.php';
use Session;

class ControladorConfiguracionFormularios extends Controller
    {
        public function index()
        {
        $titulo = "Listado de Formularios";
        if(Usuario::autenticado() == true)
        {
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('configuracion.formulario-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidadFormulario = new Formulario();
        $aFormulario = $entidadFormulario->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aFormulario) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aFormulario) && $cont < $registros_por_pagina; $i++) 
            {
                $row = array();
                $row[] = '<a href="/cofiguracion/formularios/' . $aFormulario[$i]->idformulario . '">' . $aFormulario[$i]->nombre . '</a>';
                $row[] = $aFormulario[$i]->nombre;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aFormulario), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aFormulario),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }
        public function nuevo()
        {
            $titulo = "Nuevo Formulario";
            return view("configuracion.formulario-nuevo", compact('titulo'));
        }
    
