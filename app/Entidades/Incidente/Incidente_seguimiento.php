<?php

namespace App\Entidades\Incidente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Incidente_seguimiento extends Model
{
    protected $table = 'incidente_seguimiento';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'fecha',
        'fk_usuario_id',
        'tipo',
        'descripcion',
        'fk_incidente_id'
    ];

    public function cargarDesdeRequest($request) {
        $this->descripcion = $request->input('txtSeguimiento');
    }

    public function obtenerPorId($id) {
       $sql ="SELECT 
                id,
                fecha,
                fk_usuario_id,
                tipo,
                descripcion,
                fk_incidente_id
                FROM incidente_seguimiento A
                WHERE A.id = '$id'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->id =$lstRetorno[0]->id;
            $this->fecha = date_format(date_create($lstRetorno[0]->fecha), 'Y-m-d H:i');
            $this->fk_usuario_id = $lstRetorno[0]->fk_usuario_id;
            $this->tipo =$lstRetorno[0]->tipo;
            $this->descripcion =$lstRetorno[0]->descripcion;
            $this->fk_incidente_id =$lstRetorno[0]->fk_incidente_id;
            return $lstRetorno[0];
        }
        return null;
    }

    public function insertar() {
        $now = new \DateTime();

        $sql = "INSERT INTO incidente_seguimiento (
                fecha,
                fk_usuario_id,
                tipo,
                descripcion,
                fk_incidente_id
        ) VALUES (?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [ $now->format('Y-m-d H:i:s'),
                                    Session::get('usuario_id'),
                                    $this->tipo,
                                    $this->descripcion,
                                    $this->fk_incidente_id
                                ]);
       $this->id = DB::getPdo()->lastInsertId();
    }

    public function obtenerPorIncidente($idIncidente) {
       $sql ="SELECT
                A.id,
                A.fecha,
                A.fk_usuario_id,
                A.tipo,
                A.descripcion,
                A.fk_incidente_id,
                C.nombre,
                C.apellido
            FROM
                incidente_seguimiento A
            INNER JOIN incidente_incidente B ON A.fk_incidente_id = B.id
            INNER JOIN sistema_usuario C ON C.id = A.fk_usuario_id
            WHERE A.fk_incidente_id = $idIncidente
            ORDER BY A.fecha DESC";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno>0))
            foreach($lstRetorno as $entidad){
                $entidad->fecha = date_format(date_create($entidad->fecha), 'Y-m-d H:i');
            }


        return $lstRetorno;
    }

    public function obtenerPorIncidenteParaUsuarioSolicitante($idIncidente) {
        //Obtiene las soluciones, rechazos, aprobados y el propio seguimiento del usuario solicitante
       $sql ="SELECT
                A.id,
                A.fecha,
                A.fk_usuario_id,
                A.tipo,
                A.descripcion,
                A.fk_incidente_id,
                C.nombre,
                C.apellido
            FROM
                incidente_seguimiento A
            INNER JOIN incidente_incidente B ON A.fk_incidente_id = B.id
            INNER JOIN sistema_usuario C ON C.id = A.fk_usuario_id
            WHERE A.fk_incidente_id = $idIncidente AND (A.tipo = '" . INCIDENTE_SEGUIMIENTO_APROBADO ."' OR A.tipo = '" . INCIDENTE_SEGUIMIENTO_SOLUCION . "' OR A.tipo = '" . INCIDENTE_SEGUIMIENTO_INFORMATIVO . "' OR A.tipo = '" . INCIDENTE_SEGUIMIENTO_RECHAZADO . "' OR A.fk_usuario_id = '". Session::get('usuario_id') ."') ORDER BY A.fecha DESC";
        $lstRetorno = DB::select($sql);


        if(count($lstRetorno>0))
            foreach($lstRetorno as $entidad){
                $entidad->fecha = date_format(date_create($entidad->fecha), 'Y-m-d H:i');
            }


        return $lstRetorno;
    }

}
