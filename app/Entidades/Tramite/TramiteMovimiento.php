<?php

namespace App\Entidades\Tramite;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use DateTime;

class TramiteMovimiento extends Model
{
    protected $table = 'tramite_movimientos';
    public $timestamps = false;

    protected $fillable = [
        'idtramitemovimiento',
        'fk_idtramite',
        'fecha',
        'fk_idtramite_estado'

    ];

    protected $hidden = [

    ];

    public function insertar() {
        $fecha = new DateTime();
        $sql = "INSERT INTO tramite_movimientos (
                fk_idtramite,
                fecha,
                fk_idtramite_estado
            ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [
            $this->fk_idtramite, 
            $fecha->format("Y-m-d H:i:s"), 
            $this->fk_idtramite_estado
        ]);
       return $this->idtramite = DB::getPdo()->lastInsertId();
    }

}
