<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Tramite\Tramite;
use App\Entidades\Formularios\CalculoVacaciones;
require app_path().'/start/constants.php';
use Session;
use DateTime;


Class ControladorCalculoVacaciones extends Controller{

    public function nuevo(){
        
        $titulo= "Nuevo Calculo de Vacaciones";

        return view("tramites.calculovacaciones-nuevo", compact('titulo'));
    }

     public function editar($id){
        $titulo = "Modificar Calculo de Vacaciones";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $calculoVacaciones = new CalculoVacaciones();
                $calculoVacaciones->obtenerPorId($id);
//print_r($poderEspecial);exit;
                return view('tramites.calculovacaciones-nuevo', compact('calculoVacaciones', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Calculo de Vacaciones";
            $calculoVacaciones = new CalculoVacaciones();
            $calculoVacaciones->cargarDesdeRequest($request);

            //validaciones
            if ($calculoVacaciones->nombreyapellidodeltrabajor == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el Nombre y Apellido del Trabajor";

            } else if ($calculoVacaciones->numerodeceduladeidentidad == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el Número de Cédula de Indentidad del Trabajor";

            } else if ($calculoVacaciones->cargoqueocupaenlaempresa == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el Cargo que Ocupa en la Empresa el Trabajor";

            } else if ($calculoVacaciones->fechadeingreso == "") 
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese la Fecha de Ingreso del Trabajor";

            } else if ($calculoVacaciones->fechadesalidadevacaciones == "") 
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese la Fecha de Salida de Vacaciones del Trabajor";

            } else if ($calculoVacaciones->ultimosalariodevengado == "") 
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el Ultimo Salario Devengado del Trabajor";

            } else if ($calculoVacaciones->nombredelsolicitante == "")
            {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Ingrese el Nombre del Solicitante";

            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $calculoVacaciones->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo tramite
                    $fechaActual = new DateTime();
                    $tramite = new Tramite();
                    $tramite->rectificativa = 0;
                    $tramite->fecha_inicio = $fechaActual;
                    $tramite->fk_idcliente = Session::get('usuario_id');//Persona q inica el tramite
                    $tramite->fk_idformulario = 1; //Tabla formularios 1:Calculo de vacaciones
                    $tramite->fk_formulario_url = "/tramite/calculo_vacaciones";
                    //ATENCION! debe ser insertado desde la tabla formularios
                    $tramite->fk_idtramite_estado = 1;
                    $tramite->idtramite = $tramite->insertar();

                    //Inserta los valores del formulario
                    $calculoVacaciones->idtramite =  $tramite->idtramite;
                    $calculoVacaciones->insertar();

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

        $id = $calculoVacaciones->idtramite;
        $calculoVacaciones = new CalculoVacaciones();
        //$poderEspecial->obtenerPorId($id);

        return view('tramites.calculovacaciones-nuevo', compact('msg', 'calculovacaciones', 'titulo')) . '?id=' . $calculoVacaciones->idvalor;
    }

} 

?>