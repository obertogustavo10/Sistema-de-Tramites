<?php

namespace App\Entidades\Incidente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Categoria extends Model
{
    protected $table = 'incidente_categoria';
    public $timestamps = false;

    protected $fillable = [
        'id', 'nombre', 'activo'
    ];

    public function cargarDesdeRequest($request) {
        $this->id = $request->input('id')!= "0" ? $request->input('id') : $this->id;
        $this->nombre =$request->input('txtNombre');
        $this->activo = $request->input('lstEstado');
    }


    public function obtenerTodos() {
        $sql ="SELECT id, nombre, activo FROM incidente_categoria WHERE activo = 1";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
       $sql ="SELECT
            id,
            nombre,
            activo
            FROM incidente_categoria WHERE id = '$id'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->id =$lstRetorno[0]->id;
            $this->nombre =$lstRetorno[0]->nombre;
            $this->activo =$lstRetorno[0]->activo;
            return $lstRetorno[0];
        }
        return null;
    }

    public function insertar() {
        $sql = "INSERT INTO incidente_categoria (
        nombre,
        activo
        ) VALUES (?, ?);";
       $result = DB::insert($sql, [$this->nombre, $this->activo]);
       $this->id = DB::getPdo()->lastInsertId();
    }

    public  function eliminar() {
        $sql = "DELETE FROM incidente_categoria WHERE 
            id='$this->id'";
        $affected = DB::delete($sql, [$this->id]);
    }

    public function guardar() {
        $sql = "UPDATE incidente_categoria SET
            nombre='$this->nombre',
            activo='$this->activo'
            WHERE id='$this->id';";
        $affected = DB::update($sql, [$this->id]);
    }

    public function obtenerGrilla() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'nombre',
            1 => 'activo');
        $sql = "SELECT 
                    id,
                    nombre,
                    activo
                FROM incidente_categoria  WHERE 1=1";

        if (!empty($requestData['search']['value'])) {
            // if there is a search parameter, $requestData['search']['value'] contains search parameter            
            $sql.=" AND ( nombre LIKE '%" . $requestData['search']['value'] . "%' )";
        }

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


}
