<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario_grupo;
use App\Entidades\Sistema\Usuario_familia;
use App\Entidades\Publico\Area;
use App\Entidades\Publico\Dependencia;
use App\Entidades\Publico\TipoDocumento;
use App\Entidades\Publico\Pais;
use App\Entidades\Publico\Provincia;
use App\Entidades\Publico\SituacionImpositiva;
use App\Entidades\Publico\TipoDomicilio;
use App\Entidades\Publico\Estado;
use App\Entidades\Legajo\Alumno;
use App\Entidades\Legajo\AlumnoDomicilio;

require app_path().'/start/constants.php';
use Session;

class ControladorLegajoAlumno extends Controller
{
    public function index(){
        $titulo = "Listado de legajos";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOCONSULTA")) {
                $codigo = "USUARIOCONSULTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('legajo.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $titulo = "Listado de legajos";
                return view('legajo.alumno-listar', compact('titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function nuevo(){
        $titulo = "Nuvo usuario";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOALTA")) {
                $codigo = "USUARIOALTA";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('legajo.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $dependencia = new Dependencia();
                $array_dependencia =  $dependencia->obtenerTodos();

                $tipodocumento = new TipoDocumento();
                $array_tipodocumento = $tipodocumento->obtenerTodos();

                $pais = new Pais();
                $array_pais = $pais->obtenerTodos();

                $situacionImpositiva = new SituacionImpositiva();
                $array_situacionimpositiva = $situacionImpositiva->obtenerTodos();

                $domicilio = new TipoDomicilio();
                $array_tipodomicilio = $domicilio->obtenerTodos();

                $estado = new Estado();
                $array_estado = $estado->obtenerTodos();

                return view('legajo.alumno-nuevo', compact('array_dependencia', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_tipodomicilio', 'array_tipodomicilio', 'array_estado'));
            }
        } else {
           return redirect('login');
        }        
    }

    public function editar($id){
        $titulo = "Modificar usuario";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("USUARIOMODIFICAR")) {
                $codigo = "USUARIOMODIFICAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('legajo.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $legajo = new Alumno();
                $legajo->obtenerPorId($id);

                $dependencia = new Dependencia();
                $array_dependencia =  $dependencia->obtenerTodos();

                $tipodocumento = new TipoDocumento();
                $array_tipodocumento = $tipodocumento->obtenerTodos();

                $situacionImpositiva = new SituacionImpositiva();
                $array_situacionimpositiva = $situacionImpositiva->obtenerTodos();

                $pais = new Pais();
                $array_pais = $pais->obtenerTodos();

                $domicilio = new TipoDomicilio();
                $array_tipodomicilio = $domicilio->obtenerTodos();

                $estado = new Estado();
                $array_estado = $estado->obtenerTodos();

                return view('legajo.alumno-nuevo', compact('legajo','array_dependencia', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_tipodomicilio', 'array_estado'));
            }
        } else {
           return redirect('login');
        }
    }

    public function cargarGrilla(){
        $request = $_REQUEST;

        $entidad = new Alumno();
        $legajos = $entidad->obtenerFiltrado();

        $data = array();

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($legajos) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($legajos) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/legajo/alumno/' . $legajos[$i]->idalumno . '">' . $legajos[$i]->documento . '</a>';
                $row[] = '<a href="/legajo/alumno/' . $legajos[$i]->idalumno . '">' . " " . $legajos[$i]->nombre . " " . $legajos[$i]->apellido . '</a>';
                $row[] = '<a target="_blank" href="https://webmail.fmed.uba.ar/zimbra/h/search?action=compose&to=' . $legajos[$i]->email . '">' . $legajos[$i]->email . '</a>';
                $row[] = $legajos[$i]->celular;
                $row[] = $legajos[$i]->estado;
                $htmlAccion = '<select id="lstAccion_' . $legajos[$i]->documento . '" class="form-control" onchange="fAccion('.$legajos[$i]->idalumno . ', '.$legajos[$i]->documento . ')"><option selected disabled>Seleccionar</option>';
                
                if (Patente::autorizarOperacion("SIMULARALUMNO")) {
                    $htmlAccion .= '<option value="simular-login">Simular login</option>';
                }
                $htmlAccion .= '<option value="constancia-inscripcion">Constancia de inscripción</option>';
                $htmlAccion .= '</select>';
                $row[] = $htmlAccion;
                
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($legajos),
            "recordsFiltered" => count($legajos),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function cargarGrillaDomicilio(){
        $requestData = $_REQUEST;
        $legajoID = ($_REQUEST["legajo"]);
        $entidad = new AlumnoDomicilio();

        $aDomicilio = $entidad->obtenerGrilla($legajoID);
        
        $data = array();

        if (count($aDomicilio) > 0)
            $cont=0;
            for ($i=0; $i < count($aDomicilio); $i++) {
                $row = array();
                 $row[] = $aDomicilio[$i]->iddomicilio;
                $row[] = '<input type="checkbox" name="chk_Domicilio[]" /><input type="hidden" name="chk_DomicilioTipo[]" value="' . $aDomicilio[$i]->fk_idtidomicilio . '" /"><input type="hidden" name="chk_DomicilioProvincia[]" value="' . $aDomicilio[$i]->fk_idprov . '" /"><input type="hidden" name="chk_DomicilioCalleNumero[]" value="' . $aDomicilio[$i]->direccion . '" /"><input type="hidden" name="chk_DomicilioCodPostal[]" value="' . $aDomicilio[$i]->codpost . '" /">';
                $row[] = $aDomicilio[$i]->tipo;
                $row[] = $aDomicilio[$i]->direccion . ", (CP: " . $aDomicilio[$i]->codpost . "), " . $aDomicilio[$i]->provincia . ", " . $aDomicilio[$i]->pais . "";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($aDomicilio),
            "recordsFiltered" => count($aDomicilio),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function validarNroDocumento(Request $request){
        $nro_documento = $request->input('nro_documento');
        $fk_legajo_id = $request->input('legajo');
        return $this->validarDocumentoLegajo($nro_documento, $fk_legajo_id);
    }

    public function validarDocumentoLegajo(String $nro_documento, String $idalumno=null){
        if($nro_documento>0){
            $legajo = new Alumno();
            return json_encode($legajo->validarNroDocumento($nro_documento, $idalumno));
        }
        return json_encode(false);
    }

    public function guardar(Request $request){
       // try {
            //Define la entidad servicio
            $now = new \DateTime();
            $entidad = new Alumno();
            $entidad->cargarDesdeRequest($request);

            $nro_documento = $request->input('txtNroDocumento');
            if($nro_documento == ""){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Debe ingresar un numero de documento";
            } else if($request->input('txtFechaNacimiento') != "" && (($entidad->fechanacimiento >= $now->format('Y-m-d H:i:s') || $entidad->fechanacimiento <= date_format(date_create("1900-08-30"), 'Y-m-d')))){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "La fecha de nacimiento es incorrecta.";
            } else if($this->validarDocumentoLegajo($request->input('txtNroDocumento'), $entidad->idalumno) == "true"){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "El número de documento ya existe.";
            } else if(strlen($request->input('txtNroDocumento'))<=7){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "El número de documento debe tener al menos 7 caracteres.";
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
             
                //Guarda los telefonos
                $domicilio = new AlumnoDomicilio();
                $domicilio->eliminarPorLegajo($entidad->idalumno);

                if(isset($_POST["chk_Domicilio"]) && count($_POST["chk_Domicilio"])){
                    for($i=0; $i<count($_POST["chk_Domicilio"]); $i++){
                        $domicilio->direccion = $_POST["chk_DomicilioCalleNumero"][$i];
                        $domicilio->codpost = $_POST["chk_DomicilioCodPostal"][$i];
                        $domicilio->fk_idprov = $_POST["chk_DomicilioProvincia"][$i];
                        $domicilio->fk_idtidomicilio = $_POST["chk_DomicilioTipo"][$i];
                        $domicilio->fk_idalumno = $entidad->idalumno;

                        $domicilio->insertar();
                    }
                }

                $_POST["id"] = $entidad->idalumno;
                return view('legajo.alumno-listar', compact('titulo', 'msg'));
            }
       /* } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }*/

        $dependencia = new Dependencia();
        $array_dependencia =  $dependencia->obtenerTodos();

        $tipodocumento = new TipoDocumento();
        $array_tipodocumento = $tipodocumento->obtenerTodos();

        $pais = new Pais();
        $array_pais = $pais->obtenerTodos();

        $situacionImpositiva = new SituacionImpositiva();
        $array_situacionimpositiva = $situacionImpositiva->obtenerTodos();

        $estado = new Estado();
        $array_estado = $estado->obtenerTodos();

        $domicilio = new TipoDomicilio();
        $array_tipodomicilio = $domicilio->obtenerTodos();

        $estado = new Estado();
        $array_estado = $estado->obtenerTodos();

        if($entidad->idalumno > 0) {
            $legajo = new Alumno();
            $legajo->obtenerPorId($entidad->idalumno);
            return view('legajo.alumno-nuevo', compact('msg', 'legajo','array_dependencia', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_estado', 'array_tipodomicilio', 'array_estado')) . '?id' . $legajo->idalumno;
        } else {
            return view('legajo.alumno-nuevo', compact('msg', 'array_dependencia', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_tipodomicilio', 'array_tipodomicilio', 'array_estado'));
        }
    }    
}
