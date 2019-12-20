<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
require app_path().'/start/constants.php';
use Session;
use Date;


Class ControladorPoderesEspeciales extends Controller{

    public function nuevo(){
        
        $titulo= "Poder Especial";

        return view("tramites.poderesespeciales-nuevo", compact('titulo'));
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Poder";
            $entidad = new Menu();
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
                    $fechaActual = new Date();
                    $tramite = new Tramite();
                    $tramite->rectificativa = 0;
                    $tramite->fecha_inicio = $fechaActual;
                    $tramite->fk_idcliente = Session::get('usuario_id');
                    $tramite->fk_idformulario = 4;
                    $tramite->fk_idtramite_estado = 2; //Iniciado
                    $tramite->insertar();

                    $entidad->insertar($tramite->idtramite);

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                
                return view('Formulario.poderesespeciales-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idvalor;
        $poderEspecial = new PoderEspecial();
        $poderEspecial->obtenerPorId($id);

        return view('Formulario.poderesespeciales-nuevo', compact('msg', 'poderesespeciales', 'titulo')) . '?id=' . $poderEspecial->idvalor;
    }

} 

?>