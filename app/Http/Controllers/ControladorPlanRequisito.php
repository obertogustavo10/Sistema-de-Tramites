<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Actividad\Actividad;
use App\Entidades\Actividad\Requisito;
use App\Entidades\Actividad\PlanDeEstudio;
use App\Entidades\Actividad\PlanRequisito;
use App\Entidades\Actividad\PlanMateria;

require app_path().'/start/constants.php';
use Session;

class ControladorPlanRequisito extends Controller{

    public function cargarGrillaRequisitosDelPlan() {
        $request = $_REQUEST;
        $idplan = ($_REQUEST["idplan"]);

        $entidadRequisito = new PlanRequisito();
        $aRequisito = $entidadRequisito->obtenerTodosPorPlan($idplan);

        $data = array();

        if (count($aRequisito) > 0)
            $cont=0;
            for ($i=0; $i < count($aRequisito); $i++) {
                $row = array();
                $row[] = $aRequisito[$i]->ncrequisito;
                $row[] = $aRequisito[$i]->descrequisito;
                $row[] = "<textarea id='descripcionweb_" . $aRequisito[$i]->fk_idrequisito . "' name='descripcionweb[" . $aRequisito[$i]->fk_idrequisito . "]' class='form-control' style='height: 6rem !important'>". $aRequisito[$i]->descapublicar;
                $tipo =  "<select id='tiporequisito_" . $aRequisito[$i]->fk_idrequisito . "' name='tiporequisito[" . $aRequisito[$i]->fk_idrequisito . "]' class='form-control'><option value='' disabled selected>Seleccionar</option>";
                if($aRequisito[$i]->tiporequisito == "0")
                    $tipo .= "<option selected value='0'>Previo</option>";
                else
                    $tipo .= "<option value='0'>Previo</option>";
                if($aRequisito[$i]->tiporequisito == "1")
                    $tipo .= "<option selected value='1'>De cursada</option>";
                else
                    $tipo .= "<option value='1'>De cursada</option>";
                if($aRequisito[$i]->tiporequisito == "2")
                    $tipo .= "<option selected value='2'>Posterior</option>";
                else
                    $tipo .= "<option value='2'>Posterior</option>";
                $row[] = $tipo;
                if($aRequisito[$i]->obligatorio == "1")
                    $row[] = "<select id='obligatorio_" . $aRequisito[$i]->fk_idrequisito . "' name='obligatorio[" . $aRequisito[$i]->fk_idrequisito . "]' class='form-control'><option value='' disabled selected>Seleccionar</option><option selected value='1'>Si</option><option value='0'>No</option>";
                else
                    $row[] = "<select id='obligatorio_" . $aRequisito[$i]->fk_idrequisito . "' name='obligatorio[" . $aRequisito[$i]->fk_idrequisito . "]' class='form-control'><option value='1'>Si</option><option selected value='0'>No</option>";
                $fecha = $aRequisito[$i]->fechatope != ""? date_format(date_create($aRequisito[$i]->fechatope), 'Y-m-d') : "";
				$row[] = "<input type='date' name='fecha[". $aRequisito[$i]->fk_idrequisito ."]' class='form-control' value='$fecha'/>";
				$row[] = "<button type='button' class='btn btn-secondary fa fa-minus-circle' onclick='eliminarRequisito(". $aRequisito[$i]->fk_idrequisito .")'></button>";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($aRequisito),
            "recordsFiltered" => count($aRequisito),
            "data" => $data
        );
        return json_encode($json_data);  
    }

    public function cargarGrillaRequisitosDisponibles() {
        $request = $_REQUEST;
        $familiaID = ($_REQUEST["idplan"]);

        $entidadFamilia = new Requisito();

        $aRequisito = $entidadFamilia->obtenerFiltrado();

        $data = array();
        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];

        if (count($aRequisito) > 0)
            $cont=0;
            for ($i=$inicio; $i < count($aRequisito) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = $aRequisito[$i]->idrequisito;
                $row[] = "<input id='chk_FamiliaAdd_" . $aRequisito[$i]->idrequisito . "' type='checkbox' />";
                $row[] = $aRequisito[$i]->descrequisito;
                $row[] = $aRequisito[$i]->ncrequisito;
     
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aRequisito),
            "recordsFiltered" => count($aRequisito),
            "data" => $data
        );
        return json_encode($json_data);
    }

    public function editar($id){
        $titulo = "Modificar plan de estudio";
        if(Usuario::autenticado() == true){
            if (!Patente::autorizarOperacion("CARGOMODIFICACION")) {
                $codigo = "CARGOMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $plandeestudio = new PlanDeEstudio();
                $plandeestudio->obtenerPorId($id);

                if($plandeestudio->publicado)
                    $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
                else
                    $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";

                return view('actividad.plandeestudio-requisitos', compact('plandeestudio', 'titulo'));
            }
        } else {
           return redirect('login');
        }
    }

    public function guardar(Request $request){
      	$idPlan = $request->input('id')>0 ? $request->input('id') : 0;
      	$aTipo = $request->input('tiporequisito');
      	$aObligatorio = $request->input('obligatorio');
      	$aFechatope = $request->input('fecha');
        $aDescripcionWeb = $request->input('descripcionweb');

        $plandeestudio = new PlanDeEstudio();
        $plandeestudio->obtenerPorId($idPlan);
        try {
            if ($idPlan > 0) {
	            $entidad = new PlanRequisito();
                $entidad->guardarMasivo($idPlan, $aTipo, $aObligatorio, $aFechatope, $aDescripcionWeb);
                $_POST["id"] = $idPlan;

                $cantRequisito = $cantMateria = 0;
                if($request->input("txtPublicado") == 1){
                    //Valida que tenga al menos una materia y un requisito para publicar
                    $planRequisito = new PlanRequisito();
                    $cantRequisito = count($planRequisito->obtenerTodosPorPlan($plandeestudio->idplan));

                    $planRequisito = new PlanMateria();
                    $cantMateria = count($planRequisito->obtenerTodosPorPlan($plandeestudio->idplan));

                    if($cantMateria == 0){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "El plan debe tener al menos una Materia para ser publicado";
                        $plandeestudio->publicado(false);
                    } else if($cantRequisito == 0){
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "El plan debe tener al menos un Requisito para ser publicado";
                        $plandeestudio->publicado(false);
                    } else {
                        //Guarda en publicado
                        $plandeestudio->publicado(true);
                    }
                } else {
                    $plandeestudio->publicado(false);
                }

                if(!isset($msg["MSG"]) || $msg["MSG"] == ""){
                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }

                $plandeestudio = new PlanDeEstudio();
                $plandeestudio->obtenerPorId($_POST["id"]);
                if($plandeestudio->publicado)
                    $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
                else
                    $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";
	            return view('actividad.plandeestudio-requisitos', compact('msg', 'plandeestudio', 'titulo'));
            } else {
				$msg["ESTADO"] = MSG_ERROR;
				$msg["MSG"] = ERRORINSERT;
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        if($plandeestudio->publicado)
            $titulo = "Editando: " . $plandeestudio->descplan . " (publicado)";
        else
            $titulo = "Editando: " . $plandeestudio->descplan . " (borrador)";

        return view('actividad.plandeestudio-requisitos', compact('msg', 'plandeestudio', 'titulo')) . '?id=' . $idPlan;
    }

    
    
}
