<?php

namespace App\Entidades\Tramite;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class MensajeTramite extends Model{
    protected $table = 'mensajes_tramites';
    public $timestamps = false;

    protected $fillable = [
        'idmensaje',
        'fk_idtramite',
        'mensaje',
        'fecha',
        'fk_idusuario'
    ];

    protected $hidden = [

    ];

    public  function eliminar() {
        $sql = "DELETE FROM mensajes_tramites WHERE 
            idmensaje=?";
        $affected = DB::delete($sql, [$this->idmensaje]);
    }

    public function insertar() {
        $sql = "INSERT INTO mensajes_tramites (
               fk_idtramite,
               mensaje,
               fecha,
               fk_idusuario
            ) VALUES (?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->fk_idtramite, 
            $this->mensaje, 
            $this->fecha, 
            Session::get("usuario_id")
        ]);
       return $this->idmensaje = DB::getPdo()->lastInsertId();
    }

}
