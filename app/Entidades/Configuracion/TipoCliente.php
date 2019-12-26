<?php

namespace app\Entidades\Configuracion;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class TipoCliente extends Model
{
    protected $table = 'tipo_clientes';
    public $timestamps = false;

    protected $fillable = [
        'idtipocliente', 'nombre'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idtipocliente = $request->input('id')!="0" ? $request->input('id') : $this->idtipocliente;
        $this->nombre = $request->input('txtNombre');
    }

    public function insertar() {
        $sql = "INSERT INTO tipo_clientes (
                idtipocliente,
                nombre
                
            ) VALUES (?, ?);";
       $result = DB::insert($sql, [
           $this->idtipocliente,
            $this->nombre    
        ]);
        return $this->idtipocliente = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE tipo_clientes SET
            idtipocliente='$this->idtipocliente',
            nombre='$this->nombre'
         WHERE idtipocliente=?";
        $affected = DB::update($sql, [$this->idtipocliente]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM tipo_clientes WHERE 
            idtipocliente=?";
        $affected = DB::delete($sql, [$this->idtipocliente]);
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;

        $columns = array(
           0 => 'idtipocliente',
           1 => 'nombre'
            );
        $sql = "SELECT 
                idtipocliente,
                nombre
                FROM tipo_clientes
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR idtipocliente LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTipoCliente() {
        $sql = "SELECT DISTINCT
                idtipocliente,
                nombre
                FROM tipo_clientes
                ";


        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT
                idtipocliente,
                nombre,
                FROM tipo_clientes WHERE idtipocliente = '$id'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idtipocliente = $lstRetorno[0]->idtipocliente;
            $this->nombre = $lstRetorno[0]->nombre;
            return $this;
        }
        return null;
    }
}



?>