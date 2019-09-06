<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Actividad extends Model
{
    protected $table = 'actividades.actividades';
    public $timestamps = false;

    protected $fillable = [
        'idactividad', 'descactividad', 'ncactividad', 'fk_idarea', 'titulo_que_otorga', 'coordinador'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idactividad = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idactividad;
        $this->descactividad = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->ncactividad = isset($request["txtIdentificador"]) ? $request["txtIdentificador"] : "";
        $this->titulo_que_otorga = isset($request["txtTitulo"]) ? $request["txtTitulo"] : "";
        $this->coordinador = isset($request["lstCoordinador"]) ? $request["lstCoordinador"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.descactividad',
           1 => 'A.ncactividad',
           2 => 'A.titulo_que_otorga',
           3 => 'B.nombre'
            );
        $sql = "SELECT 
                  A.idactividad,
                  A.descactividad,
                  A.ncactividad,
                  A.titulo_que_otorga,
                  B.nombre,
                  B.apellido
                FROM actividades.actividades A 
                LEFT JOIN legajo.personalfmed B ON B.idpersonal = A.coordinador
                WHERE A.fk_idarea = " . Session::get("grupo_id");

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.descactividad ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.ncactividad ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.titulo_que_otorga ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nombre ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.apellido ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idactividad,
                  A.descactividad,
                  A.ncactividad,
                  A.titulo_que_otorga
                FROM actividades.actividades A
                WHERE A.fk_idarea = " . Session::get("grupo_id");

        $sql .= " ORDER BY A.idactividad";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                idactividad,
                descactividad,
                ncactividad,
                titulo_que_otorga,
                fk_idarea,
                coordinador
                FROM actividades.actividades WHERE idactividad = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idactividad = $lstRetorno[0]->idactividad;
            $this->descactividad = $lstRetorno[0]->descactividad;
            $this->ncactividad = $lstRetorno[0]->ncactividad;
            $this->titulo_que_otorga = $lstRetorno[0]->titulo_que_otorga;
            $this->fk_idarea = $lstRetorno[0]->fk_idarea;
            $this->coordinador = $lstRetorno[0]->coordinador;
            return $this;
        }
        return null;
    }

    public  function eliminar() {
        $sql = "DELETE FROM actividades.actividades WHERE 
            idactividad=?";
        $affected = DB::delete($sql, [$this->idactividad]);
    }

    public function guardar() {
        DB::table($this->table)
            ->where('idactividad', $this->idactividad)
            ->update([
                'descactividad' => $this->descactividad,
                'ncactividad' => $this->ncactividad,
                'titulo_que_otorga' => $this->titulo_que_otorga,
                'coordinador' => $this->coordinador
            ]);
    }

    public function insertar() {
        DB::table($this->table, 'idactividad')->insert([
            'descactividad' => $this->descactividad,
            'ncactividad' => $this->ncactividad,
            'titulo_que_otorga' => $this->titulo_que_otorga,
            'fk_idarea' => Session::get("grupo_id"),
            'coordinador' => $this->coordinador
        ]);
       return $this->idactividad = DB::getPdo()->lastInsertId();
    } 

}
