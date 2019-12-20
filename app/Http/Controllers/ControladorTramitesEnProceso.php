<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;;
use App\Entidades\Tramite\Tramite;

require app_path().'/start/constants.php';
use Session;

class ControladorTramitesEnProceso extends Controller{
    public function index(){
        $titulo = "Tramites en proceso";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('estado.enproceso', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadMenu = new Tramite();
        $aMenu = $entidadMenu->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aMenu) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aMenu) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/sistema/menu/' . $aMenu[$i]->idmenu . '">' . $aMenu[$i]->nombre . '</a>';
                $row[] = $aMenu[$i]->padre;
                $row[] = $aMenu[$i]->url;
                $row[] = $aMenu[$i]->activo;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aMenu), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aMenu),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

 


  

   
    }

?>
