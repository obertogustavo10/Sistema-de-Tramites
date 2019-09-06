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

class ControladorAutogestionLegajoAlumno extends Controller
{

    public function editar(){
        $titulo = "Datos personales";
        if(Usuario::autogestionAutenticado() == true){
            $dni = Session::get("usuarioalu");
            $legajo = new Alumno();

            $legajo->obtenerPorDni($dni);

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

            return view('autogestion.datospersonales', compact('titulo', 'legajo','array_dependencia', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_tipodomicilio', 'array_estado'));
        } else {
           return redirect(env('APP_URL_AUTOGESTION') . '');
        }
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
            $titulo = "Datos personales";
            $now = new \DateTime();
            $entidad = new Alumno();
            $entidad->cargarDesdeRequest($request);
            $entidad->idalumno = session::get('alumno_id');

            if($request->input('txtFechaNacimiento') != "" && (($entidad->fechanacimiento >= $now->format('Y-m-d H:i:s') || $entidad->fechanacimiento <= date_format(date_create("1900-08-30"), 'Y-m-d')))){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "La fecha de nacimiento es incorrecta.";
            } else {
                $entidad->guardarDesdeAutogestion();

                $msg["ESTADO"] = MSG_SUCCESS;
                $msg["MSG"] = OKINSERT;
             
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
                //return view('autogestion.datospersonales', compact('titulo', 'msg'));
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

        $legajo = new Alumno();
        $legajo->obtenerPorId($entidad->idalumno);

        return view('autogestion.datospersonales', compact('msg', 'titulo', 'legajo','array_dependencia', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_estado', 'array_tipodomicilio', 'array_estado')) . '?id' . $legajo->idalumno;
    }    
}
