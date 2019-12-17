<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;;
use App\Entidades\Tramite\Tramite;

require app_path().'/start/constants.php';
use Session;

class ControladorTramite extends Controller{
    public function index(){
        $titulo = "tramites finalizados";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('tramite.finalizado', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadTramite = new Tramite();
        $aTramite = $entidadTramite->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aTramite) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aTramite) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="' . $aTramite[$i]->idtramite. '">' . $aTramite[$i]->nombre_tramite . '</a>';
                $row[] = $aTramite[$i]->estado;
                $row[] = $aTramite[$i]->fecha_inicio;
                $row[] = $aTramite[$i]->rectificativa;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aTramite), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aTramite),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

    }