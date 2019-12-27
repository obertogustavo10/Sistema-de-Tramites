<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Tramite\Tramite;
use App\Entidades\Formularios\PoderEspecial;
require app_path().'/start/constants.php';
use Session;
use DateTime;


Class ControladorPoderesEspeciales extends Controller{

    public function nuevo(){
        
        $titulo= "Poder Especial";

        return view("tramites.poderesespeciales-nuevo", compact('titulo'));
    }

     public function editar($id){
        $titulo = "Modificar Poderes especiales";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $poderEspecial = new PoderEspecial();
                $poderEspecial->obtenerPorId($id);
//print_r($poderEspecial);exit;
                return view('tramites.poderesespeciales-nuevo', compact('poderEspecial', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Poder";
            $poderEspecial = new PoderEspecial();
            $poderEspecial->cargarDesdeRequest($request);

            //validaciones
            if ($poderEspecial->nombrepoderdante == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el nombre del apoderante";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $poderEspecial->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo tramite
                    $fechaActual = new DateTime();
                    $tramite = new Tramite();
                    $tramite->rectificativa = 0;
                    $tramite->fecha_inicio = $fechaActual;
                    $tramite->fk_idcliente = Session::get('usuario_id');//Persona q inica el tramite
                    $tramite->fk_idformulario = 4;
                    $tramite->fk_formulario_url = "/tramite/poderes_especiales";
                    //ATENCION! debe ser insertado desde la tabla formularios
                    $tramite->fk_idtramite_estado = 1;
                    $tramite->idtramite = $tramite->insertar();

                    //Inserta los valores del formulario
                    $poderEspecial->idtramite =  $tramite->idtramite;
                    $poderEspecial->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                $titulo = "Listado de trámites";
                return view('estado.iniciados', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $poderEspecial->idtramite;
        $poderEspecial = new PoderEspecial();
        $poderEspecial->obtenerPorId($id);

        return view('tramites.poderesespeciales-nuevo', compact('msg', 'poderesespeciales', 'titulo')) . '?id=' . $poderEspecial->idvalor;
    }

} 

?>