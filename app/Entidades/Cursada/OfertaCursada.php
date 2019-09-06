<?php

namespace App\Entidades\Cursada;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class OfertaCursada extends Model
{
    protected $table = 'cursada.ofertacursada';
    public $timestamps = false;

    protected $fillable = [
        'vacantestotales','fk_idsede','fk_idplan','fk_idmateria','idcursada','horainiciocursada','horafincursada','habilitado','fechainiciocursada','fechafincursada','docente','diacursada','comentario'
    ];

    protected $hidden = [

    ];

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'B.descplan',
           1 => 'B.resolucion'
            );
        $sql = "SELECT DISTINCT
                  A.fk_idplan,
                  B.descplan,
                  B.resolucion
                FROM cursada.ofertacursada A 
                INNER JOIN actividades.plancabecera B ON B.idplan = A.fk_idplan
                INNER JOIN actividades.actividades C ON B.fk_idactividad = C.idactividad
                WHERE C.fk_idarea = " . Session::get('grupo_id');

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.descplan ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.resolucion ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

      public function obtenerPorPlan($idPlan) {
        $sql = "SELECT
                    A.vacantestotales,
                    A.fk_idsede,
                    A.fk_idplan,
                    A.fk_idmateria,
                    A.idcursada,
                    A.horainiciocursada,
                    A.horafincursada,
                    A.habilitado,
                    A.fechainiciocursada,
                    A.fechafincursada,
                    A.docente,
                    A.diacursada,
                    A.comentario,
                    B.nombre as nombre_docente,
                    B.apellido as apellido_docente,
                    C.descdia as dia_cursada,
                    D.descmateria,
                    E.descsede,
                    F.fk_idgrupo,
                    G.abreinscripcion,
                    G.descgrupo,
                    A.habilitado
                FROM cursada.ofertacursada A
                LEFT JOIN legajo.personalfmed B ON B.idpersonal = A.docente
                LEFT JOIN public.dias C ON C.iddia = A.diacursada
                INNER JOIN actividades.materias D ON D.idmateria = A.fk_idmateria
                LEFT JOIN public.sedes E ON E.idsede = A.fk_idsede
                INNER JOIN actividades.planmaterias F ON F.fk_idmateria = A.fk_idmateria AND F.fk_idplan = A.fk_idplan
                INNER JOIN actividades.plangrupos G ON G.idgrupo = F.fk_idgrupo 
                WHERE A.fk_idplan = $idPlan
                ORDER BY D.idmateria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerTodos(){
        $sql = "SELECT             
                    vacantestotales,
                    fk_idsede,
                    fk_idplan,
                    fk_idmateria,
                    idcursada,
                    horainiciocursada,
                    horafincursada,
                    habilitado,
                    fechainiciocursada,
                    fechafincursada,
                    docente,
                    diacursada,
                    comentario FROM $this->table";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idCursada){
        $sql = "SELECT         
                    D.descmateria,
                    A.idcursada,
                    A.fk_idplan,
                    A.fk_idmateria,
                    A.horainiciocursada,
                    A.horafincursada,
                    E.descdia,
                    F.nombre,
                    F.apellido,
                    I.descsede
                FROM cursada.ofertacursada A
                INNER JOIN actividades.plancabecera B ON A.fk_idplan = B.idplan
                INNER JOIN actividades.actividades C ON C.idactividad = B.fk_idactividad
                INNER JOIN actividades.materias D ON D.idmateria = A.fk_idmateria
                INNER JOIN public.dias E ON E.iddia = A.diacursada
                INNER JOIN legajo.personalfmed F ON F.idpersonal = A.docente
                INNER JOIN actividades.planmaterias H ON H.fk_idmateria = A.fk_idmateria
                INNER JOIN public.sedes I ON I.idsede = A.fk_idsede
                WHERE A.idcursada = $idCursada
                ORDER BY A.fk_idmateria, D.descmateria ASC, E.iddia";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0?$lstRetorno[0]:null;
    }

    public function insertar() {
        DB::table($this->table)->insert([
            'vacantestotales' => $this->vacantestotales,
            'fk_idsede' => $this->fk_idsede,
            'fk_idplan' => $this->fk_idplan,
            'fk_idmateria' => $this->fk_idmateria,
            'horainiciocursada' => $this->horainiciocursada,
            'horafincursada' => $this->horafincursada,
            'habilitado' => $this->habilitado,
            'fechainiciocursada' => $this->fechainiciocursada,
            'fechafincursada' => $this->fechafincursada,
            'docente' => $this->docente,
            'diacursada' => $this->diacursada,
            'comentario' => $this->comentario
        ]);
    }

    public function actualizar() {
        DB::table($this->table)
        ->where('idcursada', $this->idcursada)
        ->update([
            'vacantestotales' => $this->vacantestotales,
            'fk_idsede' => $this->fk_idsede,
            'fk_idplan' => $this->fk_idplan,
            'fk_idmateria' => $this->fk_idmateria,
            'horainiciocursada' => $this->horainiciocursada,
            'horafincursada' => $this->horafincursada,
            'habilitado' => $this->habilitado,
            'fechainiciocursada' => $this->fechainiciocursada,
            'fechafincursada' => $this->fechafincursada,
            'docente' => $this->docente,
            'diacursada' => $this->diacursada,
            'comentario' => $this->comentario
        ]);
    }

    public function eliminarPorPlan($idPlan) {
        $sql = "DELETE FROM cursada.ofertacursada
                WHERE fk_idplan=$idPlan;";
        $deleted = DB::delete($sql);
    }

    public function obtenerOfertaCarreraDocenteActivaPorPlan($idplan){
          $sql = "SELECT             
                    D.descmateria,
                    A.idcursada,
                    A.fk_idmateria,
                    A.horainiciocursada,
                    A.horafincursada,
                    E.descdia,
                    F.nombre,
                    F.apellido,
                    B.descplan,
                    A.vacantestotales,
                    G.fk_idgrupo,
                    H.descgrupo,
                    H.abreinscripcion,
                    I.descsede
                FROM cursada.ofertacursada A
                INNER JOIN actividades.plancabecera B ON A.fk_idplan = B.idplan
                INNER JOIN actividades.actividades C ON C.idactividad = B.fk_idactividad
                INNER JOIN actividades.materias D ON D.idmateria = A.fk_idmateria
                INNER JOIN public.dias E ON E.iddia = A.diacursada  
                INNER JOIN legajo.personalfmed F ON F.idpersonal = A.docente
                INNER JOIN actividades.planmaterias G ON G.fk_idmateria = A.fk_idmateria AND G.fk_idplan = A.fk_idplan
                INNER JOIN actividades.plangrupos H ON H.idgrupo = G.fk_idgrupo AND H.fk_idplan = A.fk_idplan
                INNER JOIN public.sedes I ON I.idsede = A.fk_idsede
                WHERE C.fk_idarea = 1 AND A.habilitado = 1 AND A.fk_idplan = $idplan
                ORDER BY A.fk_idmateria, D.descmateria ASC, E.iddia";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

 	public function obtenerOfertaCarreraDocenteInscriptoPorAlumno($dni){
          $sql = "SELECT         
                    D.descmateria,
                    A.idcursada,
                    A.fk_idmateria,
                    A.horainiciocursada,
                    A.horafincursada,
                    E.descdia,
                    F.nombre,
                    F.apellido
                FROM cursada.ofertacursada A
                INNER JOIN actividades.plancabecera B ON A.fk_idplan = B.idplan
                INNER JOIN actividades.actividades C ON C.idactividad = B.fk_idactividad
                INNER JOIN actividades.materias D ON D.idmateria = A.fk_idmateria
                INNER JOIN public.dias E ON E.iddia = A.diacursada
                INNER JOIN legajo.personalfmed F ON F.idpersonal = A.docente
                INNER JOIN cursada.alumaterias G ON G.fk_idcursada = A.idcursada
                WHERE G.fk_idnota IS NULL AND C.fk_idarea = 1 AND A.habilitado = 1 AND G.fk_idalumno = ". Session::get('alumno_id')."
                ORDER BY A.fk_idmateria, D.descmateria ASC, E.iddia";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function existeAlumnoInscripto($idcursada, $idalumno){
    	 $sql = "SELECT             
                    D.descmateria,
                    A.idcursada,
                    A.fk_idmateria,
                    A.horainiciocursada,
                    A.horafincursada,
                    E.descdia,
                    F.nombre,
                    F.apellido
                FROM cursada.ofertacursada A
                INNER JOIN actividades.plancabecera B ON A.fk_idplan = B.idplan
                INNER JOIN actividades.actividades C ON C.idactividad = B.fk_idactividad
                INNER JOIN actividades.materias D ON D.idmateria = A.fk_idmateria
                INNER JOIN public.dias E ON E.iddia = A.diacursada
                INNER JOIN legajo.personalfmed F ON F.idpersonal = A.docente
                INNER JOIN cursada.alumaterias G ON G.fk_idcursada = A.idcursada
                WHERE A.idcursada = $idcursada AND G.fk_idalumno = $idalumno
                ORDER BY A.fk_idmateria, D.descmateria ASC, E.iddia";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0;
    }

    public function cantidadDeAlumnosInscriptos($idplan, $idcursada){
        $sql = "SELECT DISTINCT count(A.fk_idalumno) as cantidad
                FROM cursada.alumaterias A
                INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                WHERE B.fk_idplan = $idplan AND B.idcursada = $idcursada";
        $lstRetorno = DB::select($sql);
        return intval($lstRetorno[0]->cantidad);
    }

        public function cantidadDeAlumnosInscriptosExceptoAlumnoActual($idplan, $idcursada, $idalumno){
        $sql = "SELECT DISTINCT count(A.fk_idalumno) as cantidad
                FROM cursada.alumaterias A
                INNER JOIN cursada.ofertacursada B ON B.idcursada = A.fk_idcursada
                WHERE B.fk_idplan = $idplan AND B.idcursada = $idcursada AND A.fk_idalumno <> $idalumno";
        $lstRetorno = DB::select($sql);
        return intval($lstRetorno[0]->cantidad);
    }

     public function obtenerVacantesTotales($idplan, $idcursada){
        $sql = "SELECT A.vacantestotales
                FROM cursada.ofertacursada A
                WHERE A.fk_idplan = $idplan AND A.idcursada = $idcursada";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0? intval($lstRetorno[0]->vacantestotales):null;
    }

    public function eliminaAlumnoInscripto($idcursada, $idalumno){
      	$sql = "DELETE FROM cursada.alumaterias A
        WHERE A.fk_idcursada=$idcursada AND A.fk_idalumno = $idalumno AND fk_idnota IS NULL";
        $deleted = DB::delete($sql);
    }

    public function obtenerOfertaCarreraDocenteActivaPorModulo($idGrupo){
        $sql = "SELECT         
                    D.descmateria,
                    A.idcursada,
                    A.fk_idmateria,
                    A.horainiciocursada,
                    A.horafincursada,
                    E.descdia,
                    F.nombre,
                    F.apellido
                FROM cursada.ofertacursada A
                INNER JOIN actividades.plancabecera B ON A.fk_idplan = B.idplan
                INNER JOIN actividades.actividades C ON C.idactividad = B.fk_idactividad
                INNER JOIN actividades.materias D ON D.idmateria = A.fk_idmateria
                INNER JOIN public.dias E ON E.iddia = A.diacursada
                INNER JOIN legajo.personalfmed F ON F.idpersonal = A.docente
                INNER JOIN actividades.planmaterias H ON H.fk_idmateria = A.fk_idmateria
                WHERE H.fk_idgrupo = $idGrupo
                ORDER BY A.fk_idmateria, D.descmateria ASC, E.iddia";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerCupoOfertado($idPlan, $fechaDesde, $fechaHasta){
        $sql = "SELECT SUM(vacantestotales) as vacantestotales
                FROM cursada.ofertacursada A
                WHERE A.fk_idplan = $idPlan AND A.habilitado = 1";
        $lstRetorno = DB::select($sql);
        return count($lstRetorno)>0?$lstRetorno[0]->vacantestotales:null;
    }

}
