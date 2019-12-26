<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Tramite\Tramite;
use App\Entidades\Formularios\CalculoUtilidades;
require app_path().'/start/constants.php';
use Session;
use DateTime;

class ControladorCalculoUtlidades extends Controller{
    public function nuevo(){
        $titulo = "Calculo de Utilidades";
            return view('tramites.calculoutilidades-nuevo', compact('titulo'));
        }
        public function editar($id){
            $titulo = "Modificar Calculos de utilidades";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                    $codigo = "MENUMODIFICACION";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $calculoUtilidades = new CalculoUtilidades();
                    $calculoUtilidades->obtenerPorId($id);
    //print_r($calculoUtilidades);exit;
                    return view('tramites.calculoutilidades-nuevo', compact('calculoUtilidades', 'titulo'));
                }
            } else {
               return redirect('login');
            }
        }
    
        public function guardar(Request $request){
            try {
                //Define la entidad servicio
                $titulo = "Modificar Poder";
                $calculoUtilidades = new CalculoUtilidades();
                $calculoUtilidades->cargarDesdeRequest($request);
    
                //validaciones
                if ($calculoUtilidades->nombre == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el Nombre y Apellido del Trabajor";

            } else if ($calculoUtilidades->no_cedula == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el Número de Cédula de Indentidad del Trabajor";

            } else if ($calculoUtilidades->cargo_empresa == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el Cargo que Ocupa en la Empresa el Trabajor";

            } else if ($calculoUtilidades->fecha_ingreso == "") 
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese la Fecha de Ingreso del Trabajor";

            } else if ($calculoUtilidades->dias_bonificar == "") 
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese los dias a bonificar";

            } else if ($calculoUtilidades->nombre_solicitante == "") 
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese los datos del solicitante";

            } else if ($calculoUtilidades->calculo_ultimosalario == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Seleccione una opcion";

            } else if ($calculoUtilidades->calculo_salariopromedio == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Seleccione una opcion";
                
                    if ($_POST["id"] > 0) {
                        //Es actualizacion
                        $calculoUtilidades->guardar();
    
                        $msg["ESTADO"] = MSG_SUCCESS;
                        $msg["MSG"] = OKINSERT;
                    } else {
                        //Es nuevo tramite
                        $fechaActual = new DateTime();
                        $tramite = new Tramite();
                        $tramite->rectificativa = 0;
                        $tramite->fecha_inicio = $fechaActual;
                        $tramite->fk_idcliente = Session::get('usuario_id');//Persona q inica el tramite
                        $tramite->fk_idformulario = 2;
                        $tramite->fk_formulario_url = "/tramite/calculo_utilidades";
                        //ATENCION! debe ser insertado desde la tabla formularios
                        $tramite->fk_idtramite_estado = 1;
                        $tramite->idtramite = $tramite->insertar();
    
                        //Inserta los valores del formulario
                        $calculoUtilidades->idtramite =  $tramite->idtramite;
                        $calculoUtilidades->insertar();
    
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
    
            $id = $calculoUtilidades->idtramite;
            $calculoUtilidades = new CalculoUtilidades();
            //$calculoUtilidades->obtenerPorId($id);
    
            return view('tramites.calculoutilidades-nuevo', compact('calculoUtilidades', 'titulo')) . '?id=' . $calculoUtilidades->idvalor;
        }
    
    }

?>