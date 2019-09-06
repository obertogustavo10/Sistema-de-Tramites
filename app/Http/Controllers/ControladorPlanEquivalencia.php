<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Actividad\PlanEquivalencia;

require app_path().'/start/constants.php';
use Session;

class ControladorPlanEquivalencia extends Controller{

    public function cargarGrillaEquivalenciaPorMateriaPorPlan(){
        $request = $_REQUEST;
        $idPlan = $request["idplan"];
        $idMateria = $request["idMateria"];

        $entidad = new PlanEquivalencia();
        $aEntidad = $entidad->obtenerMateriasEquivalentePorPlan($idPlan, $idMateria);

        $data = array();

        if (count($aEntidad) > 0)
            $cont=0;
            for ($i=0; $i < count($aEntidad); $i++) {
                $row = array();
                $row[] = $aEntidad[$i]->fk_idplan;
                $row[] = $aEntidad[$i]->desmateria;
                $row[] = "<button type='button' class='btn btn-secondary fa fa-minus-circle' onclick='eliminar(". $aEntidad[$i]->fk_idplanequivalencia .")'></button>";
                $cont++;
                $data[] = $row;
            }

        $json_data = array(
            "recordsTotal" => count($aEntidad),
            "recordsFiltered" => count($aEntidad),
            "data" => $data
        );
        return json_encode($json_data);  
    }

}
