<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Cliente\TipoCliente;

require app_path().'/start/constants.php';
use Session;

class ControladorTipoCliente extends Controller{
    public function nuevo () {

        $titulo ="Tipos de Clientes";
        return view('configuracion.tipocliente-nuevo', compact('titulo'));
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
                  
                    return view('clientes.tipocliente-listar', compact('titulo', 'msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
    
            $id = $entidad->idmenu;
            $tipoCliente = new TipoCliente();
            $tipoCliente->obtenerPorId($id);
    
            
    
            return view('clientes.tipocliente-nuevo', compact('msg', 'TipoCliente', 'titulo')) . '?id=' . $menu->idmenu;
        }    
    }

?>
