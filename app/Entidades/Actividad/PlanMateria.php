<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class PlanMateria extends Model
{
    protected $table = 'actividades.planmaterias';
    public $timestamps = false;

    protected $fillable = [
        'fk_idplan', 'fk_idgrupo', 'fk_idmateria', 'optativa', 'fk_idnota', 'niveloptativa'
    ];

    protected $hidden = [

    ];

    public function obtenerTodosPorPlan($id) {
        $sql = "SELECT
                    A.fk_idplan, 
                    A.fk_idgrupo,
                    A.fk_idmateria,
                    A.optativa,
                    A.fk_idnota,
                    A.niveloptativa,
                    B.descmateria,
                    C.descgrupo,
                    D.nota,
                    D.notaenletras,
                    B.cargahorariaenhs,
                    C.descgrupo,
                    C.abreinscripcion
                    FROM actividades.planmaterias A
                    INNER JOIN actividades.materias B ON A.fk_idmateria = B.idmateria
                    INNER JOIN actividades.plangrupos C ON C.idgrupo = A.fk_idgrupo
                    LEFT JOIN public.notas D ON D.idnota = A.fk_idnota
                WHERE A.fk_idplan = $id";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerTodosPorGrupo($id) {
        $sql = "SELECT
                    A.fk_idplan, 
                    A.fk_idgrupo,
                    A.fk_idmateria,
                    A.optativa,
                    A.fk_idnota,
                    A.niveloptativa,
                    B.descmateria,
                    C.descgrupo
                    FROM actividades.planmaterias A
                    INNER JOIN actividades.materias B ON A.fk_idmateria = B.idmateria
                    INNER JOIN actividades.plangrupos C ON C.idgrupo = A.fk_idgrupo
                WHERE A.fk_idgrupo = $id";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function insertar() {
        DB::table($this->table)->insert([
            'fk_idplan' => $this->fk_idplan,
            'fk_idgrupo' => $this->fk_idgrupo,
            'fk_idmateria' => $this->fk_idmateria,
            'optativa' => $this->optativa,
            'niveloptativa' => $this->niveloptativa,
            'fk_idnota' => $this->fk_idnota
        ]);
    }

    public function eliminarPorPlan($planID) {
        $sql = "DELETE FROM actividades.planmaterias
                WHERE fk_idplan=$planID;";
        $deleted = DB::delete($sql);
    }

    public function obtenerCantMateriaPorModulo($idGrupo){
        $sql = "SELECT DISTINCT 
                    count(A.fk_idmateria) as cantidad
                    FROM actividades.planmaterias A
                    WHERE A.fk_idgrupo = $idGrupo";
        $lstRetorno = DB::select($sql);
        return intval($lstRetorno[0]->cantidad);
    }


}
