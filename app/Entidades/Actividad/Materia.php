<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Materia extends Model
{
    protected $table = 'actividades.materias';
    public $timestamps = false;

    protected $fillable = [
        'idmateria', 'descmateria', 'fk_iddepto', 'ncmateria', 'fk_idactividad', 'periodo', 'cargahorariaendias', 'cargahorariaenhs'
    ];

    protected $hidden = [

    ];

     function cargarDesdeRequest($request) {
        $this->idmateria = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idmateria;
        $this->descmateria = $request->input("txtDescripcion");
        $this->fk_iddepto = $request->input("lstDpto") != ""? $request->input("lstDpto") : 0;
        $this->ncmateria = $request->input("txtNombre");
        $this->fk_idactividad =  $request->input("lstActividad") != ""? $request->input("lstActividad") : 0;
        $this->periodo =  $request->input("txtPeriodo") != ""? $request->input("txtPeriodo") : 0;
        $this->cargahorariaendias =  $request->input("txtHsEnDias") != ""? $request->input("txtHsEnDias") : 0;
        $this->cargahorariaenhs =  $request->input("txtHsEnHs") != ""? $request->input("txtHsEnHs") : 0;
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.idmateria',
           1 => 'A.descmateria',
           2 => 'B.descactividad'
            );
        $sql = "SELECT 
                  A.idmateria,
                  A.descmateria,
                  B.descactividad
                From actividades.materias A
                INNER JOIN actividades.actividades B ON B.idactividad = A.fk_idactividad
                WHERE B.fk_idarea = " . Session::get("grupo_id");
        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.idmateria = '" . intval($request['search']['value']) . "' ";
            $sql.=" OR A.descmateria ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.descactividad ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idmateria,
                  A.descmateria,
                  A.fk_iddepto,
                  A.ncmateria,
                  A.fk_idactividad,
                  A.periodo,
                  A.cargahorariaendias,
                  A.cargahorariaenhs
                From actividades.materias A
                INNER JOIN actividades.actividades B ON A.fk_idactividad = B.idactividad
                WHERE B.fk_idarea = " . Session::get("grupo_id");

        $sql .= " ORDER BY A.idmateria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerTodosPorPlan($idPlan) {
        $sql = "SELECT 
                A.idmateria, A.descmateria
                FROM actividades.materias A
                INNER JOIN actividades.planmaterias B ON A.idmateria = B.fk_idmateria
                WHERE B.fk_idplan = $idPlan";

        $sql .= " ORDER BY A.descmateria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                A.idmateria,
                A.descmateria,
                A.fk_iddepto,
                A.ncmateria,
                A.fk_idactividad,
                A.periodo,
                A.cargahorariaendias,
                A.cargahorariaenhs
                FROM actividades.materias A WHERE idmateria = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idmateria = $lstRetorno[0]->idmateria;
            $this->descmateria = $lstRetorno[0]->descmateria;
            $this->fk_iddepto = $lstRetorno[0]->fk_iddepto;
            $this->ncmateria = $lstRetorno[0]->ncmateria;
            $this->fk_idactividad = $lstRetorno[0]->fk_idactividad;
            $this->periodo = $lstRetorno[0]->periodo;
            $this->cargahorariaendias = $lstRetorno[0]->cargahorariaendias;
            $this->cargahorariaenhs = $lstRetorno[0]->cargahorariaenhs;
            return $this;
        }
        return null;
    }

    public function guardar() {
        DB::table($this->table)
            ->where('idmateria', $this->idmateria)
            ->update([
                'descmateria' => $this->descmateria,
                'fk_iddepto' => $this->fk_iddepto,
                'ncmateria' => $this->ncmateria,
                'fk_idactividad' => $this->fk_idactividad,
                'periodo' => $this->periodo,
                'cargahorariaendias' => $this->cargahorariaendias,
                'cargahorariaenhs' => $this->cargahorariaenhs
            ]);
    }

    public function insertar() {
        DB::table($this->table, 'idmateria')->insert([
            'descmateria' => $this->descmateria,
            'fk_iddepto' => $this->fk_iddepto,
            'ncmateria' => $this->ncmateria,
            'fk_idactividad' => $this->fk_idactividad,
            'periodo' => $this->periodo,
            'cargahorariaendias' => $this->cargahorariaendias,
            'cargahorariaenhs' => $this->cargahorariaenhs
        ]);
       return $this->idmateria = DB::getPdo()->lastInsertId();
    } 

    public function obtenerTodosPorActividad($id) {
        $sql = "SELECT
                A.idmateria, 
                A.descmateria,
                A.fk_iddepto,
                A.ncmateria,
                A.fk_idactividad,
                A.periodo,
                A.cargahorariaendias,
                A.cargahorariaenhs
                FROM actividades.materias A
                WHERE fk_idactividad = $id
                ORDER BY A.descmateria";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}
