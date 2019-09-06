<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Departamento extends Model
{
    protected $table = 'public.departamentos';
    public $timestamps = false;

    protected $fillable = [
        'iddepto', 'descdepto', 'ncdepto'
    ];

    protected $hidden = [

    ];

    public function obtenerTodos() {
        $sql = "SELECT
                A.iddepto, 
                A.descdepto,
                A.ncdepto
                FROM public.departamentos A";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

}
