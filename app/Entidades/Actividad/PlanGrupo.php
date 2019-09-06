<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class PlanGrupo extends Model
{
    protected $table = 'actividades.plangrupos';
    public $timestamps = false;

    protected $fillable = [
        'fk_idplan', 'idgrupo', 'ncgrupo', 'descgrupo', 'abreinscripcion'
    ];

    protected $hidden = [

    ];

    public function obtenerTodosPorPlan($id) {
        $sql = "SELECT
                A.fk_idplan, 
                A.idgrupo,
                A.ncgrupo,
                A.descgrupo,
                A.abreinscripcion
                FROM actividades.plangrupos A
                WHERE fk_idplan = $id";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

      public function obtenerGrupoPorPlanPorMateria($idPlan, $idMateria) {
        $sql = "SELECT
                    A.fk_idplan, 
                    A.idgrupo,
                    A.ncgrupo,
                    A.descgrupo,
                    A.abreinscripcion
                FROM actividades.plangrupos A
                INNER JOIN actividades.planmaterias B ON B.fk_idgrupo = A.idgrupo
                WHERE A.fk_idplan = $idPlan AND B.fk_idmateria = $idMateria";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0?$lstRetorno[0]:null;
    }

    public function setAbreinscripcion($idGrupo, $valor){
        DB::table($this->table)
        ->where('idgrupo', $idGrupo)
        ->update([
            'abreinscripcion' => $valor
        ]);
    }

    public function setAbreinscripcionMasivoPorPlan($idPlan, $valor){
        DB::table($this->table)
        ->where('fk_idplan', $idPlan)
        ->update([
            'abreinscripcion' => $valor
        ]);
    }

    public function getAbreInscripcion($idCursada) {
        $sql = "SELECT idgrupo, abreinscripcion
                    FROM actividades.plangrupos A
                    INNER JOIN actividades.planmaterias B ON B.fk_idgrupo = A.idgrupo 
                    INNER JOIN cursada.ofertacursada C ON C.fk_idmateria = B.fk_idmateria
                    WHERE C.idcursada = $idCursada";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0){
            $this->idgrupo = $lstRetorno[0]->idgrupo;
            $this->abreinscripcion = $lstRetorno[0]->abreinscripcion;
        }
    }

}
