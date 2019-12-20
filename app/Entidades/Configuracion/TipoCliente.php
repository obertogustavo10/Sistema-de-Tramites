<?php

namespace app\Entidades\Cliente;

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
                nombre
                
            ) VALUES (?);";
       $result = DB::insert($sql, [
            $this->nombre    
        ]);
        return $this->idtipocliente = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE tipo_clientes SET
            nombre='$this->nombre'
         WHERE idtipocliente=?";
        $affected = DB::update($sql, [$this->idtipocliente]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM tipo_clientes WHERE 
            idtipocliente=?";
        $affected = DB::delete($sql, [$this->idtipocliente]);
    }


    
}



?>