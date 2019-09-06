<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class TipoTelefono extends Model
{
    protected $table = 'panel_tipotelefono';
    public $timestamps = false;

    protected $fillable = [
        'id', 'nombre'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->id = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->id;
        $this->nombre = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre'
            );
        $sql = "SELECT 
                  A.id,
                  A.nombre
                From panel_tipotelefono A WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND A.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.id,
                  A.nombre
                From panel_tipotelefono A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                id,
                nombre
                FROM panel_tipotelefono WHERE id = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->id = $lstRetorno[0]->id;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE panel_tipotelefono SET
            nombre='$this->nombre'
            WHERE id=?";
        $affected = DB::update($sql, [$this->id]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM panel_tipotelefono WHERE 
            id=?";
        $affected = DB::delete($sql, [$this->id]);
    }

    public function insertar() {
        $sql = "INSERT INTO panel_tipotelefono (
        nombre
        ) VALUES (?);";
       $result = DB::insert($sql, [$this->nombre, $this->codigo]);
       return $this->id = DB::getPdo()->lastInsertId();
    } 

}
