<?php

namespace App\Entidades\Cliente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class TipoCliente extends Model {
    protected $table = 'tipo_clientes';
    public $timestamps = false;

    protected $fillable = [
        'idtipocliente', 'nombre'
    ];
    protected $hidden =[

    ];
    public function obtenerFiltrado() {
        
        $sql = "SELECT
                idtipocliente,
                nombre
                FROM tipo_clientes
                ";
        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}  
