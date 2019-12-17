<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Cliente\Cliente;

require app_path().'/start/constants.php';
use Session;

class ControladorCliente extends Controller{

    public function nuevo(){
        $titulo = "Cliente nuevo";
        return view("Cliente.cliente-nuevo", compact('titulo'));

        
    
    }
    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cliente";
            $entidad = new Cliente();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = FALTANOMBRE; //ARREGLAR
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                return view('cliente.cliente-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idcliente;
        $cliente = new Cliente();
        $cliente->obtenerPorId($id);

        return view('Cliente.cliente-nuevo', compact('msg', 'cliente', 'titulo')) . '?id=' . $cliente->idcliente;
    }
    public function index(){
        $titulo = "Listado de Clientes";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('cliente.cliente-listar', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('cliente.cliente-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadCliente = new Cliente();
        $aCliente = $entidadCliente->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aCliente) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aCliente) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/sistema/menu/' . $aCliente[$i]->idcliente . '">' . $aCliente[$i]->nombre . '</a>';
                $row[] = $aCliente[$i]->padre;
                $row[] = $aCliente[$i]->url;
                $row[] = $aCliente[$i]->activo;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCliente), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCliente),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
    }

}