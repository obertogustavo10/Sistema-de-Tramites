<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Configuracion\TipoCliente;

require app_path().'/start/constants.php';
use Session;

class ControladorTipoCliente extends Controller{

    public function index()
        {
        $titulo = "Tipo de clientes";
        if(Usuario::autenticado() == true)
        {
            if(!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('configuracion.tipocliente-listar', compact('titulo'));
            }
        } else {
            return redirect('login');
        }
    }
    public function cargarGrilla()
        {
        $request = $_REQUEST;

        $entidadTipoCliente = new TipoCliente();
        $aTipoCliente = $entidadTipoCliente->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aTipoCliente) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aTipoCliente) && $cont < $registros_por_pagina; $i++) 
            {
                $row = array();
                $row[] = "<a href=/configuracion/tipodecliente/nuevo/" .$aTipoCliente[$i]->idtipocliente. ">" . $aTipoCliente[$i]->nombre . '</a>'; 
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aTipoCliente), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aTipoCliente),//cantidad total de registros en la paginacion
            "data" => $data
        );
        return json_encode($json_data);
        }
    public function nuevo () {

        $titulo ="Tipos de Clientes";
        return view('configuracion.tipocliente-nuevo', compact('titulo'));
    }
    public function editar($id){
        $titulo = "Modificar Tipo de cliente";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $tipoCliente = new TipoCliente();
                $tipoCliente->obtenerPorId($id);
                
                $entidad = new TipoCliente();
                $array_tipocliente = $entidad->obtenerTipoCliente($id);

                return view('configuracion.tipocliente-nuevo', compact('titulo', 'tipoCliente', 'array_tipocliente', 'entidad'));
            }
        } else {
           return redirect('login');
        }
    }

        public function guardar(Request $request){
            try {
                //Define la entidad servicio
                $titulo = "Modificar Cliente";
                $entidad = new TipoCliente();
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
                  
                    return view('configuracion.tipocliente-listar', compact('titulo', 'msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
    
            $id = $entidad->idtipocliente;
            $tipoCliente = new TipoCliente();
            $tipoCliente->obtenerPorId($id);
    
            
    
            return view('configuracion.tipocliente-nuevo', compact('msg', 'tipoCliente', 'titulo')) . '?id=' . $entidad->idtipocliente;
        }   
        
        public function eliminar(Request $request){
            $id = $request->input('id');
    
            if(Usuario::autenticado() == true){
                if(Patente::autorizarOperacion("MENUELIMINAR")){
    
                    $entidad = new TipoCliente();
                    $entidad->cargarDesdeRequest($request);
                    $entidad->eliminar();
    
                    $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
                    
                } else {
                    $codigo = "MENUELIMINAR";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                    $aResultado["err"] = EXIT_FAILURE; //error al elimiar
                }
                echo json_encode($aResultado);
            } else {
                return redirect('login');
            }
        }
    
    }

?>
