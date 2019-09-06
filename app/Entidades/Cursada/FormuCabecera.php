<?php

namespace App\Entidades\Cursada;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class FormuCabecera extends Model
{
    protected $table = 'cursada.formucabecera';
    public $timestamps = false;

    protected $fillable = [
        'idformu','fk_idplan','documento','control'
    ];

    protected $hidden = [

    ];

    public function insertar() {
        DB::table($this->table)->insert([
            'fk_idplan' => $this->fk_idplan,
            'documento' => $this->documento,
            'control' => $this->control
        ]);
        return $this->idformu = DB::getPdo()->lastInsertId();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                    A.idformu,
                    A.fk_idplan,
                    A.documento,
                    A.control,
                    B.idalumno
                FROM cursada.formucabecera A
                INNER JOIN legajo.alumnos B ON B.documento = A.documento 
                WHERE A.idformu = $id";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0)
            return $lstRetorno[0];
        else
            return null;
    }

    public function obtenerTodosPorAlumno($dni) {
        $sql = "SELECT
                    MAX(A.idformu) as idformu,
                    A.fk_idplan,
                    B.descplan,
                    B.resolucion,
                    C.idalumno
                FROM cursada.formucabecera A
                INNER JOIN actividades.plancabecera B ON B.idplan = A.fk_idplan
                INNER JOIN legajo.alumnos C ON C.documento = A.documento 
                WHERE A.documento = '$dni'
                GROUP BY A.fk_idplan, B.descplan, B.resolucion, C.idalumno
                ORDER BY idformu DESC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerUltimoComprobantePorPlanPorAlumno($dni, $idPlan) {
        $sql = "SELECT
                    MAX(A.idformu) as idformu,
                    A.fk_idplan,
                    B.descplan,
                    B.resolucion
                FROM cursada.formucabecera A
                INNER JOIN actividades.plancabecera B ON B.idplan = A.fk_idplan
                WHERE A.documento = '$dni' AND A.fk_idplan = $idPlan
                GROUP BY A.fk_idplan, B.descplan, B.resolucion
                ORDER BY idformu DESC";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0)
            return $lstRetorno[0];
        else
            return null;
    }

}
