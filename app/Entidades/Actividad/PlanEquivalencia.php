<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class PlanEquivalencia extends Model
{
    protected $table = 'actividades.planequivalencias';
    public $timestamps = false;

    protected $fillable = [
        'fk_idplanequivalencia', 'fk_idplan', 'fk_idmateriaequivalencia', 'fk_idmateria', 'nivelequivalencia'
    ];

    protected $hidden = [

    ];

    public function obtenerMateriasEquivalentePorPlan($id) {
        $sql = "SELECT 
				A.idmateria, A.descmateria
				FROM actividades.materias A
				INNER JOIN actividades.planequivalencias B ON A.idmateria = B.fk_idmateria AND B.fk_idplan = $id";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerEquivalenciasPorPlanPorMateria($idPlan, $idMateria) {
        $sql = "SELECT 
                A.fk_idplanequivalencia, A.fk_idmateriaequivalencia
                FROM actividades.planequivalencias A
                WHERE A.fk_idplan = $idPlan AND A.fk_idmateria = $idMateria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerSupraEquivalenciaPorPlanPorMateria($idPlanAnterior, $idPlanActual, $idMateria) {
        $sql = "SELECT 
                A.fk_idplan, A.fk_idmateria, A.fk_idplanequivalencia, A.fk_idmateriaequivalencia
                FROM actividades.planequivalencias A
                WHERE A.fk_idplanequivalencia = $idPlanAnterior AND A.fk_idmateriaequivalencia = $idMateria AND A.fk_idplan = $idPlanActual";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function insertar() {
        DB::table($this->table)->insert([
            'fk_idplan' => $this->fk_idplan,
            'fk_idmateria' => $this->fk_idmateria,
            'fk_idplanequivalencia' => $this->fk_idplanequivalencia,
            'fk_idmateriaequivalencia' => $this->fk_idmateriaequivalencia,
            'nivelequivalencia' => $this->nivelequivalencia
        ]);
    }

    public function eliminarPorPlan($planID) {
        $sql = "DELETE FROM actividades.planequivalencias
                WHERE fk_idplan=$planID";
        $deleted = DB::delete($sql);
    }

    public function eliminarPorPlanMateria($planID, $idMateria) {
        $sql = "DELETE FROM actividades.planequivalencias
                WHERE fk_idplan=$planID AND fk_idmateria=$idMateria;";
        $deleted = DB::delete($sql);
    }


}

?>