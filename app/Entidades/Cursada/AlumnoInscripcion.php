<?php

namespace App\Entidades\Cursada;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateTime;

class AlumnoInscripcion extends Model
{
    protected $table = 'cursada.alumnosposgrado';
    public $timestamps = false;

    protected $fillable = [
        'fk_idplan','fk_idestadoalu','fk_idcategoria','fk_idalumno','fechainscripcion'
    ];

    protected $hidden = [

    ];

    public function obtenerCarrerasPorDni($dni) {
        $sql = "SELECT
                    A.fk_idplan,
                    A.fk_idestadoalu,
                    A.fk_idcategoria,
                    A.fk_idalumno,
                    A.fechainscripcion,
                    C.descplan,
                    D.descestadoalu
                FROM cursada.alumnosposgrado A
                INNER JOIN legajo.alumnos B ON B.idalumno = A.fk_idalumno
                INNER JOIN actividades.plancabecera C ON C.idplan = A.fk_idplan
                INNER JOIN public.t_estadoalumno D ON D.idestadoalu = A.fk_idestadoalu
                WHERE B.documento = '$dni' ORDER BY C.inscribedesde DESC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerCarrerasActivasPorDni($dni) {
        $sql = "SELECT
                    A.fk_idplan,
                    A.fk_idestadoalu,
                    A.fk_idcategoria,
                    A.fk_idalumno,
                    A.fechainscripcion,
                    C.descplan
                FROM cursada.alumnosposgrado A
                INNER JOIN legajo.alumnos B ON B.idalumno = A.fk_idalumno
                INNER JOIN actividades.plancabecera C ON C.idplan = A.fk_idplan
                WHERE A.fk_idestadoalu = " . ALUMNO . " AND B.documento = '$dni'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerCarreraDocenteActivaPorAlumno($idalumno) {
        $now = new DateTime();
        $fechaDesde = $now->format('Y-m-d');
        $sql = "SELECT
                    A.fk_idplan,
                    A.fk_idestadoalu,
                    A.fk_idcategoria,
                    A.fk_idalumno,
                    A.fechainscripcion,
                    C.descplan,
                    C.inscribedesde,
                    C.inscribehasta
                FROM cursada.alumnosposgrado A
                INNER JOIN legajo.alumnos B ON B.idalumno = A.fk_idalumno
                INNER JOIN actividades.plancabecera C ON C.idplan = A.fk_idplan
                INNER JOIN actividades.actividades D ON D.idactividad = C.fk_idactividad
                WHERE A.fk_idestadoalu = " . ALUMNO . " AND D.fk_idarea = 1 AND A.fk_idalumno = $idalumno AND C.publicado=1 AND '$fechaDesde' >= C.inscribedesde AND ('$fechaDesde' <= C.inscribehasta OR C.inscribehasta IS NULL)
                ORDER BY C.inscribedesde DESC";
        $lstRetorno = DB::select($sql);
        return (count($lstRetorno)>0)? $lstRetorno[0]:null;
    }

}
