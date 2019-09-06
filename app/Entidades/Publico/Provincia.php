<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Provincia extends Model
{
    protected $table = 'public.provincias';
    public $timestamps = false;

    protected $fillable = [
    	'idprov', 'descprov', 'ncprov', 'fk_idpais'
    ];

    protected $hidden = [

    ];

	function cargarDesdeRequest($request) {
        $this->idprov = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idprov;
        $this->descprov = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->ncprov = isset($request["txtCodigo"]) ? $request["txtCodigo"] : "";
        $this->fk_idpais = isset($request["lstPais"]) ? $request["lstPais"] : "";
    }

    public function obtenerPorPais($idPais){
        $sql = "SELECT 
                A.idprov,
                A.descprov
                FROM public.provincias A
                WHERE A.fk_idpais = '$idPais'";
        $sql .= " ORDER BY A.descprov";
        $resultado = DB::select($sql);
        return $resultado;
    }

}
