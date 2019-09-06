<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class PlanRequisito extends Model
{
    protected $table = 'actividades.planrequisitos';
    public $timestamps = false;

    protected $fillable = [
        'fk_idplan', 'fk_idrequisito', 'tiporequisito', 'obligatorio', 'fechatope', 'descapublicar'
    ];

    protected $hidden = [

    ];

    public function obtenerTodos() {
        $sql = "SELECT 
                A.fk_idplan, 
                A.fk_idrequisito,
                A.tiporequisito,
                A.obligatorio,
                A.fechatope,
                A.descapublicar
                From actividades.planrequisitos A
                ORDER BY A.fk_idrequisito";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerTodosPorPlan($id) {
        $sql = "SELECT
                A.fk_idplan, 
                A.fk_idrequisito,
                A.tiporequisito,
                A.obligatorio,
                A.fechatope,
                B.ncrequisito,
                B.descrequisito,
                A.descapublicar
                FROM actividades.planrequisitos A
                LEFT JOIN actividades.requisitos B ON B.idrequisito = A.fk_idrequisito
                WHERE fk_idplan = $id";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function guardarMasivo($idPlan, $aTipo, $aObligatorio, $aFechatope, $aDescripcionWeb){
        //Elimina masivo
        $sql = "DELETE FROM actividades.planrequisitos WHERE fk_idplan=?";
        $affected = DB::delete($sql, [$idPlan]);
        if($aObligatorio && count($aObligatorio)>0) {
            foreach($aObligatorio as $key=>$value){
                //Guarda masivo
                   DB::table($this->table, 'idplan')->insert([
                    'fk_idplan' => $idPlan,
                    'fk_idrequisito' => $key,
                    'tiporequisito' => $aTipo[$key],
                    'obligatorio' => $aObligatorio[$key],
                    'fechatope' => $aFechatope[$key],
                    'descapublicar' => $aDescripcionWeb[$key]
                ]);
            }
        }
    }

}
