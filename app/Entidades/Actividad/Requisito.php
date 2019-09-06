<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Requisito extends Model
{
    protected $table = 'actividades.requisitos';
    public $timestamps = false;

    protected $fillable = [
        'idrequisito', 'descrequisito', 'ncrequisito', 'comentario', 'comentariointerno'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idrequisito = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idrequisito;
        $this->descrequisito = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->ncrequisito = isset($request["txtIdentificador"]) ? $request["txtIdentificador"] : "";
        $this->comentario = isset($request["txtComentario"]) ? $request["txtComentario"] : "";
        $this->comentariointerno = isset($request["txtComentarioInterno"]) ? $request["txtComentarioInterno"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.descrequisito',
           1 => 'A.ncrequisito'
            );
        $sql = "SELECT 
                  A.idrequisito,
                  A.descrequisito,
                  A.ncrequisito
                From actividades.requisitos A WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.descrequisito ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.ncrequisito ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idrequisito,
                  A.descrequisito,
                  A.ncrequisito,
                  A.comentario,
                  A.comentariointerno,
                From actividades.requisitos A WHERE A.comentario = " . Session::get("grupo_id");

        $sql .= " ORDER BY A.idrequisito";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                idrequisito,
                descrequisito,
                ncrequisito,
                comentariointerno,
                comentario
                FROM actividades.requisitos WHERE idrequisito = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idrequisito = $lstRetorno[0]->idrequisito;
            $this->descrequisito = $lstRetorno[0]->descrequisito;
            $this->ncrequisito = $lstRetorno[0]->ncrequisito;
            $this->comentariointerno = $lstRetorno[0]->comentariointerno;
            $this->comentario = $lstRetorno[0]->comentario;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE actividades.requisitos SET
            descrequisito='$this->descrequisito',
            ncrequisito='$this->ncrequisito',
            comentario='$this->comentario',
            comentariointerno='$this->comentariointerno'
            WHERE idrequisito=?";
        $affected = DB::update($sql, [$this->idrequisito]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM actividades.requisitos WHERE 
            idrequisito=?";
        $affected = DB::delete($sql, [$this->idrequisito]);
    }

    public function insertar() {
        $sql = "INSERT INTO actividades.requisitos (
        descrequisito,
        ncrequisito,
        comentario,
        comentariointerno
        ) VALUES (?, ?, ?, ?);";
       $result = DB::insert($sql, [$this->descrequisito, $this->ncrequisito,  $this->comentario, $this->comentariointerno]);
       return $this->idrequisito = DB::getPdo()->lastInsertId();
    } 

}
