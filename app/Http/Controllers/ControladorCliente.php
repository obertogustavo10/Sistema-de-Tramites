<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Cliente\Cliente;
use App\Entidades\Cliente\Domicilio;
use App\Entidades\Cliente\TipoDocumento;
use App\Entidades\Cliente\TipoCliente;
use App\Http\Controllers\Exception;
use App\Entidades\Cliente\TipoDomicilio;

require app_path().'/start/constants.php';
use Session;

class ControladorCliente extends Controller{

    public function nuevo(){
        $titulo = "Cliente nuevo";

        //SE CREAN EL ARRAY PARA OBTENER LAS COLUMNAS DE LA TABLA TIPO CLIENTE
        $entidadTipoCliente = new TipoCliente;
        $aTipoClientes = $entidadTipoCliente->obtenerFiltrado();

        //SE CREAN EL ARRAY PARA OBTENER LAS COLUMNAS DE LA TABLA TIPO DOMICILIO
        $entidadTipoDomicilio = new TipoDomicilio;
        $aTipoDomicilios = $entidadTipoDomicilio->obtenerFiltrado();

         //SE CREAN EL ARRAY PARA OBTENER LAS COLUMNAS DE LA TABLA TIPO DOCUMENTO
         $entidadTipoDocumento = new TipoDocumento;
         $aTipoDocumento = $entidadTipoDocumento->obtenerFiltrado();

        return view("clientes.cliente-nuevo", compact('titulo', 'aTipoClientes', 'entidadTipoCliente',
                                                      'aTipoDomicilios', 'entidadTipoDomicilio', 'aTipoDocumento', 'entidadTipoDocumento'  ));

    
    }
    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cliente";
            $entidadCliente = new Cliente();
            $entidadDomicilio = new Domicilio();
            $entidadCliente->cargarDesdeRequest($request);
            $entidadDomicilio->cargarDesdeRequest($request);

            //validaciones
            if ($entidadCliente->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = FALTANOMBRE; //ARREGLAR
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidadCliente->guardarCliente();
                    $entidadDomicilio->guardarDomicilio();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidadCliente->insertarCliente();
                    $entidadDomicilio->fk_idcliente = $entidadCliente->idcliente;
                    $entidadDomicilio->insertarDomicilio();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                return view('clientes.cliente-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidadCliente->idcliente;
        $cliente = new Cliente();
        $cliente->obtenerPorIdCliente($id);

       
        return view('clientes.cliente-nuevo', compact('msg', 'cliente', 'titulo')) . '?id=' . $cliente->idcliente;
    }
    public function index(){
        $titulo = "Listado de Clientes";
        if(Usuario::autenticado() == true){
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                
                return view ('cllientes.cliente-listar', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('clientes.cliente-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidadCliente = new Cliente();
        $aCliente = $entidadCliente->obtenerFiltradoCliente();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aCliente) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aCliente) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/cliente/listar/' . $aCliente[$i]->idcliente . '">' . $aCliente[$i]->nombre . '</a>';
                $row[] = $aCliente[$i]->razon_social;
                $row[] = $aCliente[$i]->documento;
                $row[] = $aCliente[$i]->tipodocumento;
                $row[] = $aCliente[$i]->tipodepersona;
                $row[] = $aCliente[$i]->telefono;
                $row[] = $aCliente[$i]->mail;
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