<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateTime;

class PlanDeEstudio extends Model
{
    protected $table = 'actividades.plancabecera';
    public $timestamps = false;

    protected $fillable = [
        'idplan', 'descplan', 'ncplan', 'resolucion', 'vigenciadesde', 'vigenciahasta', 'abreinscripcion', 'fk_idactividad', 'publicado',
        'inscribedesde', 'inscribehasta', 'duracion', 'eligesede'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idplan = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idplan;
        $this->descplan = isset($request["txtDescripcion"]) ? $request["txtDescripcion"] : "";
        $this->ncplan = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->fk_idactividad = isset($request["lstActividad"]) ? $request["lstActividad"] : "";
        $this->resolucion = isset($request["txtResolucion"]) ? $request["txtResolucion"] : "";
        $this->vigenciadesde = isset($request["txtVigenciaDesde"]) ? $request["txtVigenciaDesde"] : NULL;
        $this->vigenciahasta = isset($request["txtVigenciaHasta"]) ? $request["txtVigenciaHasta"] :NULL;
        $this->abreinscripcion = isset($request["lstAbreInscripcion"]) ? $request["lstAbreInscripcion"] : "";
        $this->publicado = isset($request["txtPublicado"]) && $request["txtPublicado"] != ""? $request["txtPublicado"] : 0;
        $this->inscribedesde = isset($request["txtInscribeDesde"]) ? $request["txtInscribeDesde"] : "";
        $this->inscribehasta = isset($request["txtInscribeHasta"]) ? $request["txtInscribeHasta"] : "";
        $this->duracion = isset($request["txtDuracion"]) ? $request["txtDuracion"] : "";
        $this->eligesede = isset($request["lstSede"]) ? $request["lstSede"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.ncplan',
           1 => 'A.descplan',
           2 => 'B.descactividad',
           3 => 'A.vigenciadesde',
           4 => 'A.vigenciahasta'
            );
        $sql = "SELECT DISTINCT
                    A.idplan,
                    A.descplan,
                    A.ncplan,
                    A.resolucion,
                    A.vigenciadesde,
                    A.vigenciahasta,
                    A.abreinscripcion,
                    A.publicado,
                    A.fk_idactividad,
                    B.descactividad
                FROM actividades.plancabecera A
                INNER JOIN actividades.actividades B ON B.idactividad = A.fk_idactividad WHERE B.fk_idarea=" . Session::get("grupo_id");

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.ncplan ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.descplan ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.descactividad ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY B.descactividad ASC, " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                    A.idplan,
                    A.descplan,
                    A.ncplan,
                    A.resolucion,
                    A.vigenciadesde,
                    A.vigenciahasta,
                    A.abreinscripcion,
                    A.fk_idactividad,
                    A.publicado,
                    A.inscribedesde,
                    A.inscribehasta,
                    A.duracion,
                    A.eligesede
                From actividades.plancabecera A";

        $sql .= " ORDER BY A.idplan";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerVigentesPorActividad($idActividad) {
        $fecha = new \DateTime();
        $fecha = $fecha->format('Y-m-d');
        $sql = "SELECT 
                    A.idplan,
                    A.descplan,
                    A.ncplan,
                    A.resolucion,
                    A.vigenciadesde,
                    A.vigenciahasta,
                    A.abreinscripcion,
                    A.fk_idactividad,
                    A.publicado,
                    A.inscribedesde,
                    A.inscribehasta,
                    A.duracion,
                    A.eligesede
                From actividades.plancabecera A WHERE A.fk_idactividad = $idActividad AND (A.vigenciahasta > '$fecha' OR A.vigenciahasta is null)";

        $sql .= " ORDER BY A.idplan";

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                A.idplan,
                A.descplan,
                A.ncplan,
                A.resolucion,
                A.vigenciadesde,
                A.vigenciahasta,
                A.abreinscripcion,
                A.fk_idactividad,
                A.publicado,
                A.inscribedesde,
                A.inscribehasta,
                A.duracion,
                A.eligesede
                FROM actividades.plancabecera A WHERE A.idplan = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idplan = $lstRetorno[0]->idplan;
            $this->descplan = $lstRetorno[0]->descplan;
            $this->ncplan = $lstRetorno[0]->ncplan;
            $this->resolucion = $lstRetorno[0]->resolucion;
            $this->vigenciadesde = $lstRetorno[0]->vigenciadesde;
            $this->vigenciahasta = $lstRetorno[0]->vigenciahasta;
            $this->abreinscripcion = $lstRetorno[0]->abreinscripcion;
            $this->fk_idactividad = $lstRetorno[0]->fk_idactividad;
            $this->publicado = $lstRetorno[0]->publicado;
            $this->inscribedesde = $lstRetorno[0]->inscribedesde;
            $this->inscribehasta = $lstRetorno[0]->inscribehasta;
            $this->duracion = $lstRetorno[0]->duracion;
            $this->eligesede = $lstRetorno[0]->eligesede;
            return $this;
        }
        return null;
    }

    public function guardar() {
        DB::table($this->table)
        ->where('idplan', $this->idplan)
        ->update([
            'descplan' => $this->descplan,
            'ncplan' => $this->ncplan,
            'resolucion' => $this->resolucion,
            'vigenciadesde' => $this->vigenciadesde,
            'vigenciahasta' => $this->vigenciahasta,
            'abreinscripcion' => $this->abreinscripcion,
            'fk_idactividad' => $this->fk_idactividad,
            'publicado' => $this->publicado,
            'inscribedesde' => $this->inscribedesde,
            'inscribehasta' => $this->inscribehasta,
            'duracion' => $this->duracion,
            'eligesede' => $this->eligesede
        ]);
    }

    public function insertar() {
        DB::table($this->table, 'idplan')->insert([
            'descplan' => $this->descplan,
            'ncplan' => $this->ncplan,
            'resolucion' => $this->resolucion,
            'vigenciadesde' => $this->vigenciadesde,
            'vigenciahasta' => $this->vigenciahasta,
            'abreinscripcion' => $this->abreinscripcion,
            'fk_idactividad' => $this->fk_idactividad,
            'publicado' => $this->publicado,
            'inscribedesde' => $this->inscribedesde,
            'inscribehasta' => $this->inscribehasta,
            'duracion' => $this->duracion,
            'eligesede' => $this->eligesede
        ]);
       return $this->idplan = DB::getPdo()->lastInsertId();
    } 

    public function publicado($valor) {
        DB::table($this->table)
        ->where('idplan', $this->idplan)
        ->update([
            'publicado' => $valor
        ]);
    }

}
