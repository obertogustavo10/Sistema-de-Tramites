<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class PlanCorrelativa extends Model
{
    protected $table = 'actividades.plancorrelativas';
    public $timestamps = false;

    protected $fillable = [
        'fk_idplan', 'fk_idmateriacorrelativa', 'fk_idmateria'
    ];

    protected $hidden = [

    ];

    public function obtenerPorPlanMateria($idPlan, $idMateria){
            $sql = "SELECT
                    A.fk_idplan, 
                    A.fk_idmateriacorrelativa,
                    A.fk_idmateria
                    FROM actividades.plancorrelativas A
                WHERE A.fk_idplan = $idPlan AND A.fk_idmateria = $idMateria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function insertar() {
        DB::table($this->table)->insert([
            'fk_idplan' => $this->fk_idplan,
            'fk_idmateriacorrelativa' => $this->fk_idmateriacorrelativa,
            'fk_idmateria' => $this->fk_idmateria
        ]);
    }

    public function eliminarPorPlan($planID) {
        $sql = "DELETE FROM actividades.plancorrelativas
                WHERE fk_idplan=$planID;";
        $deleted = DB::delete($sql);
    }

}
