<?php

namespace App\Entidades\Cursada;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Certificado extends Model
{
    protected $table = 'cursada.certificados';
    public $timestamps = false;

    protected $fillable = [
        'idcertificado','fecha_aprobacion','fk_idnota','fk_idalumno'

    ];

    protected $hidden = [

    ];


    public function insertar() {
        DB::table($this->table)->insert([
            'fecha_aprobacion' => $this->fecha_aprobacion,
            'fk_idnota' => $this->fk_idnota,
            'fk_idalumno' => $this->fk_idalumno
        ]);
        return $this->idcertificado = DB::getPdo()->lastInsertId();
    }

    public function actualizar() {
        DB::table($this->table)
        ->where('idcertificado', $this->idcertificado)
        ->update([
            'fecha_aprobacion' => $this->fecha_aprobacion,
            'fk_idnota' => $this->fk_idnota,
            'fk_idalumno' => $this->fk_idalumno
        ]);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                A.idcertificado,
                B.idalumno,
                B.documento,
                B.nombre,
                B.apellido,
                A.fecha_aprobacion,
                C.notaenletras
                FROM cursada.certificados A 
                INNER JOIN legajo.alumnos B ON A.fk_idalumno = B.idalumno
                INNER JOIN public.notas C ON C.idnota = A.fk_idnota
                WHERE A.idcertificado = $id";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0)
            return $lstRetorno[0];
        else
            return null;
    }

     public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idcertificado',
            1 => 'A.documento',
            2 => 'A.nombre',
            3 => 'A.fecha_aprobacion',
            4 => 'B.notaenletras'
        );
        $sql = "SELECT 
                A.idcertificado,
                B.idalumno,
                B.documento,
                B.nombre,
                B.apellido,
                A.fecha_aprobacion,
                C.notaenletras 
                FROM cursada.certificados A 
                INNER JOIN legajo.alumnos B ON A.fk_idalumno = B.idalumno
                INNER JOIN public.notas C ON C.idnota = A.fk_idnota
                WHERE 1=1";

        //Realiza el filtrado
         if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.idcertificado = '" . intval($request['search']['value']) . "' ";
            $sql.=" OR B.nombre ILIKE '%" . $request['search']['value'] . "%' ";
           // $sql.=" OR A.fecha_aprobacion ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.documento ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR C.notaenletras ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

}
