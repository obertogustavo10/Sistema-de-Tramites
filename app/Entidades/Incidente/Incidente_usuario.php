<?php

namespace App\Entidades\Incidente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Incidente_usuario extends Model
{
    protected $table = 'incidente_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'fk_usuario_id',
        'fk_incidente_id',
        'tipo'
    ];

    public function obtenerPorId($id) {
       $sql ="SELECT
                    A.id,
                    A.fk_usuario_id,
                    A.fk_incidente_id,
                    A.tipo
            FROM incidente_usuario A
            WHERE A.id = '$id'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorIncidente($idIncidente){
        $sql ="SELECT
                    A.id,
                    A.fk_usuario_id,
                    A.fk_incidente_id,
                    A.tipo
            FROM incidente_usuario A
            INNER JOIN incidente_incidente B ON A.fk_incidente_id = B.id AND  B.fk_sistema_grupo_id = ". Session::get('grupo_id');
            $sql .= " WHERE A.fk_incidente_id = '$idIncidente'";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;   
    }

    public function insertarMasivo() {
        $sql = "INSERT INTO incidente_usuario (
                fk_usuario_id,
                fk_incidente_id,
                tipo
        ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [ $this->fk_usuario_id,
                                    $this->fk_incidente_id,
                                    $this->tipo
                                ]);
       $this->id = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE incidente_usuario SET
        fk_usuario_id = '$this->fk_usuario_id',
        fk_incidente_id = $this->fk_incidente_id,
        tipo = $this->tipo
        WHERE id='$this->id';";
        $affected = DB::update($sql, [$this->id]);
    }

    public function borrarMasivoPorIncidente($idIncidente){
        $sql = "DELETE FROM incidente_usuario WHERE 
            fk_incidente_id=?";
        $affected = DB::delete($sql, [$idIncidente]);
    }

}
