<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Cargo;

require app_path().'/start/constants.php';
use Session;

class ControladorCargo extends Controller {
	public function index(){
		$titulo = "Cargos";
		if(Usuario::autenticado() == true){
    		if(!Patente::autorizarOperacion("CARGOCONSULTA")) {
    			$codigo = "CARGOCONSULTA";
    			$mensaje = "No tiene permisos para la operaci&oacute;n.";
    			return view ('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
    		} else {
    			return view('panel.cargo-listado', compact('titulo'));
    		}
    	} else {
    		return redirect('login');
    	}
	}

	public function cargarGrilla(){
		$request = $_REQUEST;

		$entidadCargo = new Cargo();
		$cargo = $entidadCargo->obtenerGrilla();

		$data = array();

		if(count($cargo) > 0)
			$cont = 0;
			for ($i=0; $i < count($cargo); $i++) { 
				$row = array();
				$row[] = '<a href="/panel/cargo/' . $cargo[$i]->id. '">' . $cargo[$i]->nombre . '</a>';

				$cont++;
				$data[] = $row;
			}

			$json_data = array(
				"recordsTotal" => count($cargo), //cantidad total de registros sin paginar
                "recordsFiltered" => count($cargo),//cantidad total de registros en la paginacion
                "data" => $data
            );
            return json_encode($json_data);
	}

    public function nuevo(){
            $titulo = "Nuevo Cargo";
            if(Usuario::autenticado() == true){
                if (!Patente::autorizarOperacion("CARGOALTA")) {
                    $codigo = "CARGOALTA";
                    $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                     return view('panel.cargo-nuevo', compact('titulo'));
                }
            } else {
               return redirect('login');
            }   
    }

	public function editar($id){
        $titulo = "Modificar Cargo";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $cargos = new Cargo();
                $cargos->obtenerPorId($id);
                return view('panel.cargo-nuevo', compact('cargos', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function eliminar(Request $request){
        $id = $request->input('id');

        if(Usuario::autenticado() == true){
            if(Patente::autorizarOperacion("CARGOELIMINAR")){
                $cargos = new Cargo();
                $cargos->cargarDesdeRequest($request);
                $cargos->eliminar();
                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "CARGOELIMINAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                $aResultado["err"] = EXIT_FAILURE; //error al elimiar
            }
            echo json_encode($aResultado);
        } else {
            return redirect('login');
        }
    }

    public function guardar(Request $request){
        try {
            //Define la entidad servicio
            $titulo = "Modificar Cargo";
            $entidad = new Cargo();
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
                $_POST["id"] = $entidad->id;
                 return view('panel.cargo-listado', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        $cargos = new Cargo();
        $cargos->obtenerPorId($entidad->id);
        
        return view('panel.cargo-nuevo', compact('msg', 'cargos', 'titulo')) . '?id=' . $cargos->id;
    }
}	
?>