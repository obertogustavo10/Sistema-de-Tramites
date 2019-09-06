<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario_grupo;
use App\Entidades\Sistema\Usuario_familia;
use App\Entidades\Publico\Dependencia;
use App\Entidades\Publico\TipoDocumento;
use App\Entidades\Publico\Pais;
use App\Entidades\Publico\Provincia;
use App\Entidades\Publico\SituacionImpositiva;
use App\Entidades\Publico\TipoTelefono;
use App\Entidades\Publico\TipoDomicilio;
use App\Entidades\Legajo\Legajo;
use App\Entidades\Legajo\Domicilio;
use App\Entidades\Legajo\Telefono;
use App\Entidades\Legajo\TelefonoLegajo;
use App\Entidades\Legajo\DomicilioLegajo;

require app_path().'/start/constants.php';
use Session;

class ControladorLegajo extends Controller
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
                return view('legajo.listar-legajo', compact('titulo'));
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
                $area = new Dependencia();
                $array_area =  $area->obtenerTodos();

                $tipodocumento = new TipoDocumento();
                $array_tipodocumento = $tipodocumento->obtenerTodos();

                $pais = new Pais();
                $array_pais = $pais->obtenerTodos();

                $situacionImpositiva = new SituacionImpositiva();
                $array_situacionimpositiva = $situacionImpositiva->obtenerTodos();

                $telefono = new TipoTelefono();
                $array_tipotelefono = $telefono->obtenerTodos();

                $domicilio = new TipoDomicilio();
                $array_tipodomicilio = $domicilio->obtenerTodos();

                return view('legajo.nuevo-legajo', compact('array_area', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_tipotelefono', 'array_tipodomicilio', 'array_tipotelefono', 'array_tipodomicilio'));
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
                $legajo = new Legajo();
                $legajo->obtenerPorId($id);

                $area = new Dependencia();
                $array_area =  $area->obtenerTodos();

                $tipodocumento = new TipoDocumento();
                $array_tipodocumento = $tipodocumento->obtenerTodos();

                $pais = new Pais();
                $array_pais = $pais->obtenerTodos();

                $situacionImpositiva = new SituacionImpositiva();
                $array_situacionimpositiva = $situacionImpositiva->obtenerTodos();

                $telefono = new TipoTelefono();
                $array_tipotelefono = $telefono->obtenerTodos();

                $domicilio = new TipoDomicilio();
                $array_tipodomicilio = $domicilio->obtenerTodos();

                return view('legajo.nuevo-legajo', compact('legajo','array_area', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_tipotelefono', 'array_tipodomicilio'));
            }
        } else {
           return redirect('login');
        }
    }

    public function cargarGrilla(){
        $requestData = $_REQUEST;
        $entidad = new Legajo();

        $legajos = $entidad->obtenerGrilla();
        
        $data = array();

        if (count($legajos) > 0)
            $cont=0;
            for ($i=0; $i < count($legajos); $i++) {
                $row = array();
                $row[] = '<a href="/legajo/' . $legajos[$i]->id . '">' . $legajos[$i]->nro_documento . '</a>';
                $row[] = '<a href="/legajo/' . $legajos[$i]->id . '">' . " " . $legajos[$i]->nombre . " " . $legajos[$i]->apellido . '</a>';
                $row[] = '<a target="_blank" href="https://webmail.fmed.uba.ar/zimbra/h/search?action=compose&to=' . $legajos[$i]->email . '">' . $legajos[$i]->email . '</a>';

                $telefono = new Telefono();
                $aTelefono = $telefono->obtenerPorLegajo($legajos[$i]->id);

				$aNumero = array();
				foreach($aTelefono as $item) {
					array_push($aNumero, $item->numero . " (" . $item->tipo . ")");
				}

                $row[] = implode(", ", $aNumero);
                $row[] = $legajos[$i]->nro_documento;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($legajos),
            "recordsFiltered" => count($legajos),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function cargarGrillaDomicilio(){
        $requestData = $_REQUEST;
        $legajoID = ($_REQUEST["legajo"]);
        $entidad = new Domicilio();

        $aDomicilio = $entidad->obtenerGrilla($legajoID);
        
        $data = array();

        if (count($aDomicilio) > 0)
            $cont=0;
            for ($i=0; $i < count($aDomicilio); $i++) {
                $row = array();
                 $row[] = $aDomicilio[$i]->id;
                $row[] = '<input type="checkbox" name="chk_Domicilio[]" /><input type="hidden" name="chk_DomicilioTipo[]" value="' . $aDomicilio[$i]->fk_tipo_domicilio_id . '" /"><input type="hidden" name="chk_DomicilioProvincia[]" value="' . $aDomicilio[$i]->fk_provincia_id . '" /"><input type="hidden" name="chk_DomicilioCalleNumero[]" value="' . $aDomicilio[$i]->calle_nro . '" /"><input type="hidden" name="chk_DomicilioDpto[]" value="' . $aDomicilio[$i]->dpto . '" /"><input type="hidden" name="chk_DomicilioCodPostal[]" value="' . $aDomicilio[$i]->codigo_postal . '" /">';
                $row[] = $aDomicilio[$i]->tipo;
                $row[] = $aDomicilio[$i]->calle_nro . " " . $aDomicilio[$i]->dpto . ", (CP: " . $aDomicilio[$i]->codigo_postal . "), " . $aDomicilio[$i]->provincia . ", " . $aDomicilio[$i]->pais . "";
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

    public function cargarGrillTelefono(){
        $requestData = $_REQUEST;
        $legajoID = ($_REQUEST["legajo"]);

        $entidad = new Telefono();

        $aTelefono = $entidad->obtenerGrilla($legajoID);
        
        $data = array();

        if (count($aTelefono) > 0)
            $cont=0;
            for ($i=0; $i < count($aTelefono); $i++) {
                $row = array();
                 $row[] = $aTelefono[$i]->id;
                $row[] = '<input name="chk_Telefono[]" value="' . $aTelefono[$i]->id . '" type="checkbox" /><input type="hidden" name="chk_TelefonoTipo[]" value="' . $aTelefono[$i]->fk_panel_tipotelefono_id . '" /"><input type="hidden" name="chk_TelefonoNumero[]" value="' . $aTelefono[$i]->numero . '" /"><input type="hidden" name="chk_TelefonoObservacion[]" value="' . $aTelefono[$i]->observacion . '" /">';
                $row[] = $aTelefono[$i]->tipo;
                $row[] = $aTelefono[$i]->numero;
                $row[] = $aTelefono[$i]->observacion;
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($aTelefono),
            "recordsFiltered" => count($aTelefono),
            "data" => $data
        );
        return json_encode($json_data);
    }

     public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $entidad = new Legajo();
            $entidad->cargarDesdeRequest($request);

            $nro_documento = $request->input('txtNroDocumento');
            if($nro_documento == ""){
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Debe ingresar un numero de documento";
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
                $domicilio = new Domicilio();
                $domicilio->eliminarPorLegajo($entidad->id);

                if(isset($_POST["chk_Domicilio"]) && count($_POST["chk_Domicilio"])){
                	for($i=0; $i<count($_POST["chk_Domicilio"]); $i++){
                		$domicilio->calle_nro = $_POST["chk_DomicilioCalleNumero"][$i];
                        $domicilio->dpto = $_POST["chk_DomicilioDpto"][$i];
                        $domicilio->codigo_postal = $_POST["chk_DomicilioCodPostal"][$i];
                        $domicilio->fk_provincia_id = $_POST["chk_DomicilioProvincia"][$i];
                        $domicilio->fk_tipo_domicilio_id = $_POST["chk_DomicilioTipo"][$i];
                        $domicilio->fk_legajo_id = $entidad->id;

                        $domicilio->insertar();
                	}
                }

                //Guarda los telefonos
                $telefono = new Telefono();
                $telefono->eliminarPorLegajo($entidad->id);

                if(isset($_POST["chk_Telefono"]) && count($_POST["chk_Telefono"])){
                	for($i=0; $i<count($_POST["chk_Telefono"]); $i++){
                		$telefono->fk_panel_tipotelefono_id = $_POST["chk_TelefonoTipo"][$i];
                        $telefono->fk_legajo_id = $entidad->id;
                        $telefono->numero = $_POST["chk_TelefonoNumero"][$i];
                        $telefono->observacion = $_POST["chk_TelefonoObservacion"][$i];

                        $telefono->insertar();
                	}
                }

                $_POST["id"] = $entidad->id;
                return view('legajo.listar-legajo', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $area = new Dependencia();
        $array_area =  $area->obtenerTodos();

        $tipodocumento = new TipoDocumento();
        $array_tipodocumento = $tipodocumento->obtenerTodos();

        $pais = new Pais();
        $array_pais = $pais->obtenerTodos();

        $situacionImpositiva = new SituacionImpositiva();
        $array_situacionimpositiva = $situacionImpositiva->obtenerTodos();

        $telefono = new TipoTelefono();
        $array_tipotelefono = $telefono->obtenerTodos();

        $domicilio = new TipoDomicilio();
        $array_tipodomicilio = $domicilio->obtenerTodos();

        $legajo = new Legajo();
        $legajo->obtenerPorId($entidad->id);
        return view('legajo.nuevo-legajo', compact('msg', 'legajo','array_area', 'array_tipodocumento', 'array_pais', 'array_situacionimpositiva', 'array_tipotelefono', 'array_tipodomicilio')) . '?id' . $legajo->id;
    }    
}
