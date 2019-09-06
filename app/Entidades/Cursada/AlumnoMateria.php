<?php

namespace App\Entidades\Cursada;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class AlumnoMateria extends Model
{
    protected $table = 'cursada.alumaterias';
    public $timestamps = false;

    protected $fillable = [
        'resolucionexime','libro','folio','fk_idnota','fk_idcursada','fk_idalumno','fecharesolexime','fechainsc','fechaacta','expedienteexime'
    ];

    protected $hidden = [

    ];

    public function insertar() {
        DB::table($this->table)->insert([
            'resolucionexime' => $this->resolucionexime,
            'libro' => $this->libro,
            'folio' => $this->folio,
            'fk_idnota' => $this->fk_idnota,
            'fk_idcursada' => $this->fk_idcursada,
            'fk_idalumno' => $this->fk_idalumno,
            'fecharesolexime' => $this->fecharesolexime,
            'fechainsc' => $this->fechainsc,
            'fechaacta' => $this->fechaacta,
            'expedienteexime' => $this->expedienteexime
        ]);
    }
    public function obtenerMateriaPorPlan($idPlan, $idMateria, $idAlumno){
         $sql = "SELECT
                    C.idmateria,
                    C.descmateria,
                    A.fk_idnota as nota_alumno,
                    E.nota as nota_descalumno,
                    D.fk_idnota as nota_minima,
                    E.notaenletras,
                    A.fechaacta,
                    A.libro,
                    A.folio,
                    A.resolucionexime,
                    A.expedienteexime,
                    A.fecharesolexime,
                    C.cargahorariaenhs,
                    B.fk_idplan
                FROM cursada.alumaterias A
                INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                INNER JOIN actividades.materias C ON C.idmateria = B.fk_idmateria
                INNER JOIN actividades.planmaterias D ON D.fk_idmateria = B.fk_idmateria
                LEFT JOIN public.notas E ON E.idnota = A.fk_idnota
                WHERE B.fk_idplan = $idPlan AND D.fk_idplan = $idPlan AND B.fk_idmateria = $idMateria AND A.fk_idalumno = $idAlumno
                ORDER BY fechaacta DESC NULLS LAST";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0?$lstRetorno[0]:null;
    }
    public function obtenerTodosPorAlumnoPorPlan($idalumno, $idPlan){
         $sql = "SELECT
                    C.idmateria,
                    C.descmateria,
                    A.fk_idnota as nota_alumno,
                    E.nota as nota_descalumno,
                    D.fk_idnota as nota_minima,
                    E.notaenletras,
                    A.fechaacta,
                    A.libro,
                    A.folio,
                    A.resolucionexime,
                    A.expedienteexime,
                    A.fecharesolexime,
                    C.cargahorariaenhs
                FROM cursada.alumaterias A
                INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                INNER JOIN actividades.materias C ON C.idmateria = B.fk_idmateria
                INNER JOIN actividades.planmaterias D ON D.fk_idmateria = B.fk_idmateria
                LEFT JOIN public.notas E ON E.idnota = A.fk_idnota
                WHERE A.fk_idalumno = $idalumno AND B.fk_idplan = $idPlan AND D.fk_idplan = $idPlan";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerMateriasAprobadasDelAlumno($idAlumno){
        $alumateria = new AlumnoMateria();
        $aAlumateria = $alumateria->obtenerMateriasDelAlumno($idAlumno);


        $array_materias_aprobadas = array();
        if(count($aAlumateria)>0)
            foreach($aAlumateria as $materia){
                if($materia->nota_alumno == NOTA_EX){
                    $array_materias_aprobadas[] = $materia;
                } else {
                    if($materia->nota_minima == NOTA_UNO && $materia->nota_alumno >= NOTA_UNO  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_DOS && $materia->nota_alumno >= NOTA_DOS  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_TRES && $materia->nota_alumno >= NOTA_TRES  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_CUATRO && $materia->nota_alumno >= NOTA_CUATRO  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_CINCO && $materia->nota_alumno >= NOTA_CINCO  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_SEIS && $materia->nota_alumno >= NOTA_SEIS  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_SIETE && $materia->nota_alumno >= NOTA_SIETE  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_OCHO && $materia->nota_alumno >= NOTA_OCHO  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_NUEVE && $materia->nota_alumno >= NOTA_NUEVE  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_DIEZ && $materia->nota_alumno >= NOTA_DIEZ  && $materia->nota_alumno <= NOTA_DIEZ)
                        $array_materias_aprobadas[] = $materia;
                    if($materia->nota_minima == NOTA_AP && $materia->nota_alumno == NOTA_AP)
                        $array_materias_aprobadas[] = $materia;
                }
            }
        return $array_materias_aprobadas;
    }

    public function obtenerMateriasAusentesDesaprobadasDelAlumno($idAlumno, $idPlan){
        $alumateria = new AlumnoMateria();
        $aAlumateria = $alumateria->obtenerMateriasDelAlumno($idAlumno, $idPlan);

        $array_materias_ausentesdesaprobadas = array();
        if(count($aAlumateria)>0)
            foreach($aAlumateria as $materia){
                if($materia->nota_alumno == NOTA_AU || $materia->nota_alumno == NOTA_RE || $materia->nota_alumno == NOTA_NOINFORMADO){
                    $array_materias_ausentesdesaprobadas[] = $materia;
                }
            }
        return $array_materias_ausentesdesaprobadas;
    }

    public function obtenerMateriasEnCurso($idalumno, $idPlan){
         $sql = "SELECT DISTINCT
                    C.idmateria,
                    C.descmateria,
                    B.idcursada,
                    G.descdia,
                    B.horainiciocursada,
                    B.horafincursada,
                    B.fechainiciocursada,
                    B.fechafincursada,
                    E.nombre,
                    E.apellido,
                    F.descsede,
                    C.cargahorariaenhs
                FROM cursada.alumaterias A
                INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                INNER JOIN actividades.materias C ON C.idmateria = B.fk_idmateria
                INNER JOIN actividades.planmaterias D ON D.fk_idmateria = B.fk_idmateria
                LEFT JOIN legajo.personalfmed E ON E.idpersonal = B.docente
                LEFT JOIN public.sedes F ON F.idsede = B.fk_idsede
                LEFT JOIN public.dias G ON G.iddia = B.diacursada
                WHERE A.fk_idalumno = $idalumno AND B.fk_idplan = $idPlan AND D.fk_idplan = $idPlan AND A.fk_idnota IS NULL";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

  /*  public function obtenerMateriasQueRestanCursar($idalumno, $idplan){
         $sql = "SELECT DISTINCT
                    C.idmateria,
                    C.descmateria,
                    B.idcursada,
                    G.descdia,
                    B.horainiciocursada,
                    B.horafincursada,
                    B.fechainiciocursada,
                    B.fechafincursada,
                    E.nombre,
                    E.apellido,
                    F.descsede,
                    C.cargahorariaenhs
                FROM cursada.alumaterias A
                INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                INNER JOIN actividades.materias C ON C.idmateria = B.fk_idmateria
                INNER JOIN actividades.planmaterias D ON D.fk_idmateria = B.fk_idmateria
                LEFT JOIN legajo.personalfmed E ON E.idpersonal = B.docente
                LEFT JOIN public.sedes F ON F.idsede = B.fk_idsede
                LEFT JOIN public.dias G ON G.iddia = B.diacursada
                WHERE A.fk_idalumno = $idalumno AND B.fk_idplan = $idplan AND A.fk_idnota IS NULL";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }*/

    public function obtenerMateriasDelAlumno($idalumno, $idPlan=null){
         $sql = "SELECT DISTINCT
                    C.idmateria,
                    C.descmateria,
                    A.fk_idnota as nota_alumno,
                    E.nota as nota_descalumno,
                    D.fk_idnota as nota_minima,
                    E.notaenletras,
                    A.fechaacta,
                    A.libro,
                    A.folio,
                    A.resolucionexime,
                    A.expedienteexime,
                    A.fecharesolexime,
                    C.cargahorariaenhs,
                    B.fk_idplan,
                    F.resolucion
                FROM cursada.alumaterias A
                INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                INNER JOIN actividades.materias C ON C.idmateria = B.fk_idmateria
                INNER JOIN actividades.planmaterias D ON D.fk_idmateria = B.fk_idmateria
                LEFT JOIN public.notas E ON E.idnota = A.fk_idnota
                INNER JOIN actividades.plancabecera F ON F.idplan = B.fk_idplan
                WHERE A.fk_idalumno = $idalumno";
                if($idPlan)
                    $sql .= " AND B.fk_idplan = $idPlan AND D.fk_idplan = $idPlan";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerUltimaMateriaPorAlumnoPorPlan($idalumno, $idplan){
         $sql = "SELECT
                    C.descmateria,
                    D.nota,
                    A.fechaacta,
                    A.libro,
                    A.folio,
                    A.resolucionexime,
                    A.expedienteexime,
                    A.fecharesolexime
                FROM cursada.alumaterias A
                INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                INNER JOIN actividades.materias C ON C.idmateria = B.fk_idmateria
                INNER JOIN public.notas D ON D.idnota = A.fk_idnota
                WHERE A.fk_idalumno = $idalumno AND B.fk_idplan = $idplan
                ORDER BY A.fechaacta";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0)
            return $lstRetorno[0];
        else
            return null;
    }

    public function obtenerCantidadDeInscriptos($idPlan, $fechaDesde, $fechaHasta){
         $sql = "SELECT count(fk_idalumno) as cant_alumnos
                    FROM cursada.alumaterias A
                    INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                    WHERE B.fk_idplan = $idPlan";
                    if($fechaDesde != "") $sql .= " AND A.fechainsc >= '$fechaDesde'";
                    if($fechaHasta != "") $sql .= " AND A.fechainsc <= '$fechaHasta'";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0?$lstRetorno[0]->cant_alumnos:null;
    }

    public function obtenerCantidadDeInscriptosPorPlan($idPlan){
         $sql = "SELECT count(DISTINCT A.fk_idalumno) as cantidad
                    FROM cursada.alumaterias A 
                    INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                    INNER JOIN cursada.formudetalle C ON C.fk_idcursada = B.idcursada
                    WHERE B.fk_idplan = $idPlan";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0?$lstRetorno[0]->cantidad:null;
    }

}
