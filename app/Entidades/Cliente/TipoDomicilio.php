<?php

namespace App\Entidades\Cliente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class TipoDomicilio extends Model {
    protected $table = 'tipo_domicilios';
    public $timestamps = false;

    protected $fillable = [
        'idtipodomicilios', 'nombre'
    ];
    protected $hidden =[

    ];
    public function obtenerFiltrado() {
        
        $sql = "SELECT
                idtipodomicilios,
                nombre
                FROM tipo_domicilios
                ";
        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}  
