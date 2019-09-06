<?php

namespace App\Entidades\Cursada;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class FormuDetalle extends Model
{
    protected $table = 'cursada.formudetalle';
    public $timestamps = false;

    protected $fillable = [
        'fk_idformu','fk_idcursada'
    ];

    protected $hidden = [

    ];

    public function insertar() {
        DB::table($this->table)->insert([
            'fk_idformu' => $this->fk_idformu,
            'fk_idcursada' => $this->fk_idcursada
        ]);
    }

    public function obtenerPorFormulario($idformu) {
        $sql = "SELECT
                    A.fk_idformu,
                    A.fk_idcursada,
                    C.descmateria,
                    D.descdia,
                    B.horainiciocursada,
                    B.horafincursada,
                    B.fechainiciocursada,
                    B.fechafincursada,
                    F.nombre,
                    F.apellido,
                    B.comentario
                    FROM cursada.formudetalle A
                    INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                    INNER JOIN actividades.materias C ON C.idmateria = B.fk_idmateria
                    INNER JOIN public.dias D ON D.iddia = B.diacursada
                    INNER JOIN legajo.personalfmed F ON F.idpersonal = B.docente
                    WHERE A.fk_idformu = $idformu";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}
