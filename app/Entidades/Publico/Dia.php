<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Dia extends Model
{
    protected $table = 'public.dias';
    public $timestamps = false;

    protected $fillable = [
        'iddia', 'ncdia', 'descdia'
    ];

    protected $hidden = [

    ];

    public function obtenerTodos() {
        $sql = "SELECT
                A.iddia, 
                A.ncdia,
                A.descdia
                FROM public.dias A ORDER BY A.iddia";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
