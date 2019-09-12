<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Estado extends Model
{
    protected $table = 'public_estado';
    public $timestamps = false;

    protected $fillable = [
    	'idestado', 'descestado', 'ncestado'
    ];

    protected $hidden = [

    ];

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idestado,
                  A.descestado,
                  A.ncestado
                From public_estado A";

        $sql .= " ORDER BY A.descestado";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idestado) {
        $sql = "SELECT
                idestado,
                descestado,
                ncestado
                FROM public_estado WHERE idestado = '$idestado'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idestado = $lstRetorno[0]->idestado;
            $this->descestado = $lstRetorno[0]->descestado;
            $this->ncestado = $lstRetorno[0]->ncestado;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE public_estado SET
            descestado='$this->descestado',
            ncestado='$this->ncestado'
            WHERE idestado=?";
        $affected = DB::update($sql, [$this->idestado]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM public_estado WHERE 
            idestado=?";
        $affected = DB::delete($sql, [$this->idestado]);
    }

    public function insertar() {
        $sql = "INSERT INTO public_estado (
        descestado,
        ncestado
        ) VALUES (?, ?);";
       $result = DB::insert($sql, [$this->descestado, $this->ncestado]);
       return $this->idestado = DB::getPdo()->lastInsertId();
    } 

}
