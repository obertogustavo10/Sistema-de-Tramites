<?php

namespace App\Entidades\Incidente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Estado extends Model
{
    protected $table = 'incidente_estado';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'activo'
    ];

    public function obtenerTodos() {
        $sql ="SELECT id, nombre, activo FROM incidente_estado WHERE activo = 1";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
