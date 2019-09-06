<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Nota extends Model
{
    protected $table = 'public.notas';
    public $timestamps = false;

    protected $fillable = [
        'idnota', 'nota', 'notaenletras'
    ];

    protected $hidden = [

    ];

    public function obtenerTodos() {
        $sql = "SELECT
                A.idnota, 
                A.nota,
                A.notaenletras
                FROM public.notas A";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
