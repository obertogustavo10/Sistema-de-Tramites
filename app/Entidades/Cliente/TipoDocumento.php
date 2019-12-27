<?php

namespace App\Entidades\Cliente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class TipoDocumento extends Model{
    protected $table = 'tipo_documentos';
    public $timestamps = false;

    protected $fillable = [
        'idtipodocumento', 'nombre'
    ];
    protected $hidden =[

    ];
    public function obtenerFiltrado() {
      
        $sql = "SELECT
                    A.idtipodocumento,
                    A.nombre
                    FROM tipo_documentos A
                ";

        
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}