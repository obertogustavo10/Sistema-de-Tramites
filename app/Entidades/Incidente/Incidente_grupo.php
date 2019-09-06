<?php

namespace App\Entidades\Incidente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Incidente_grupo extends Model
{
    protected $table = 'incidente_grupo';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'fk_grupo_id',
        'fk_incidente_id',
        'tipo'
    ];

    public function obtenerPorId($id) {
       $sql ="SELECT
                    A.id,
                    A.fk_grupo_id,
                    A.fk_incidente_id,
                    A.tipo
            FROM incidente_grupo A
            WHERE A.id = '$id'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorIncidente($idIncidente){
        $sql ="SELECT
                    A.id,
                    A.fk_grupo_id,
                    A.fk_incidente_id,
                    A.tipo
            FROM incidente_grupo A
            WHERE A.fk_incidente_id = '$idIncidente'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;   
    }

    public function insertarMasivo() {
        $sql = "INSERT INTO incidente_grupo (
                fk_grupo_id,
                fk_incidente_id,
                tipo
        ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [ $this->fk_grupo_id,
                                    $this->fk_incidente_id,
                                    $this->tipo
                                ]);
       $this->id = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE incidente_grupo SET
        fk_grupo_id = '$this->fk_grupo_id',
        fk_incidente_id = $this->fk_incidente_id,
        tipo = $this->tipo
        WHERE id='$this->id';";
        $affected = DB::update($sql, [$this->id]);
    }

    public function borrarMasivoPorIncidente($idIncidente){
        $sql = "DELETE FROM incidente_grupo WHERE 
            fk_incidente_id=?";
        $affected = DB::delete($sql, [$idIncidente]);
    }

}
