<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Grupo extends Model
{
    protected $table = 'actividades.plangrupos';
    public $timestamps = false;

    protected $fillable = [
        'idgrupo', 'ncgrupo', 'descgrupo', 'fk_idplan', 'abreinscripcion'
    ];

    protected $hidden = [

    ];

     function cargarDesdeRequest($request) {
        $this->idgrupo = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idgrupo;
        $this->ncgrupo = $request->input("txtDescripcion");
        $this->descgrupo = $request->input("txtNombre");
        $this->fk_idplan = $request->input("lstPlan") != ""? $request->input("lstPlan") : 0;
        $this->abreinscripcion =  $request->input("lstAbreInscripcion");
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.ncgrupo',
           1 => 'A.descgrupo',
           2 => 'B.descplan',
           3 => 'B.ncplan'
            );
        $sql = "SELECT 
                  A.idgrupo,
                  A.ncgrupo,
                  A.descgrupo,
                  B.descplan,
                  B.ncplan
                FROM actividades.plangrupos A
                INNER JOIN actividades.plancabecera B ON B.idplan = A.fk_idplan WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.ncgrupo = '" . intval($request['search']['value']) . "' ";
            $sql.=" OR A.descgrupo ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.descplan ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.ncplan ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idgrupo,
                  A.ncgrupo,
                  A.descgrupo,
                  A.fk_idplan,
                  A.abreinscripcion
                From actividades.plangrupos A";

        $sql .= " ORDER BY A.idgrupo";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                A.idgrupo,
                A.ncgrupo,
                A.descgrupo,
                A.fk_idplan,
                A.abreinscripcion
                FROM actividades.plangrupos A WHERE idgrupo = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idgrupo = $lstRetorno[0]->idgrupo;
            $this->ncgrupo = $lstRetorno[0]->ncgrupo;
            $this->descgrupo = $lstRetorno[0]->descgrupo;
            $this->fk_idplan = $lstRetorno[0]->fk_idplan;
            $this->abreinscripcion = $lstRetorno[0]->abreinscripcion;
            return $this;
        }
        return null;
    }

    public function guardar() {
        DB::table($this->table)
            ->where('idgrupo', $this->idgrupo)
            ->update([
                'ncgrupo' => $this->ncgrupo,
                'descgrupo' => $this->descgrupo,
                'fk_idplan' => $this->fk_idplan,
                'abreinscripcion' => $this->abreinscripcion
            ]);
    }

    public function insertar() {
        DB::table($this->table, 'idgrupo')->insert([
            'ncgrupo' => $this->ncgrupo,
            'descgrupo' => $this->descgrupo,
            'fk_idplan' => $this->fk_idplan,
            'abreinscripcion' => $this->abreinscripcion
        ]);
       return $this->idgrupo = DB::getPdo()->lastInsertId();
    } 

    public function obtenerTodosPorPlan($id) {
        $sql = "SELECT
                A.idgrupo, 
                A.ncgrupo,
                A.descgrupo,
                A.fk_idplan,
                A.abreinscripcion
                FROM actividades.plangrupos A
                WHERE fk_idplan = $id";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
