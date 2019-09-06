<?php

namespace App\Entidades\Incidente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Prioridad extends Model
{
    protected $table = 'incidente_estado';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function obtenerTodos() {
        $sql ="SELECT id, nombre FROM incidente_prioridad";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
