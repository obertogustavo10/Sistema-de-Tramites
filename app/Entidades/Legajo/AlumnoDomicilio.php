<?php

namespace App\Entidades\Legajo;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class AlumnoDomicilio extends Model
{
    protected $table = 'legajo.domicilios';
    public $timestamps = false;

    protected $fillable = [
        'iddomicilio', 'direccion', 'localidad', 'fk_idtidomicilio', 'fk_idprov', 'codpost', 'fk_idalumno', 'fk_idpais', 'predeterminado'
    ];

    protected $hidden = [

    ];

    public function obtenerGrilla($legajoID) {
        $columns = array(
           0 => 'B.desctidomicilio',
           1 => 'A.direccion',
           2 => 'A.observacion',
            );
        $sql = "SELECT
                A.iddomicilio,
                A.direccion,
                A.fk_idtidomicilio,
                A.fk_idprov,
                A.codpost,
                B.desctidomicilio as tipo,
                C.descprov as provincia,
                D.descpais as pais
                FROM legajo.domicilios A
                LEFT JOIN public.t_domicilios B ON B.idtidomicilio = A.fk_idtidomicilio
                LEFT JOIN public.provincias C ON C.idprov = A.fk_idprov
                LEFT JOIN public.paises D ON D.idpais = C.fk_idpais
                 WHERE A.fk_idalumno = ?";

        $lstRetorno = DB::select($sql, [$legajoID]);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                A.iddomicilio,
                A.direccion,
                A.localidad,
                A.fk_idtidomicilio,
                A.fk_idprov,
                A.codpost,
                A.fk_idalumno,
                A.fk_idpais,
                A.predeterminado
                FROM legajo.domicilios A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                    A.iddomicilio,
                    A.direccion,
                    A.localidad,
                    A.fk_idtidomicilio,
                    A.fk_idprov,
                    A.codpost,
                    A.fk_idalumno,
                    A.fk_idpais,
                    A.predeterminado
                FROM legajo.domicilios A WHERE iddomicilio = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->iddomicilio = $lstRetorno[0]->iddomicilio;
            $this->direccion = $lstRetorno[0]->direccion;
            $this->localidad = $lstRetorno[0]->localidad;
            $this->fk_idtidomicilio = $lstRetorno[0]->fk_idtidomicilio;
            $this->fk_idprov = $lstRetorno[0]->fk_idprov;
            $this->codpost = $lstRetorno[0]->codpost;
            $this->fk_idalumno = $lstRetorno[0]->fk_idalumno;
            $this->fk_idpais = $lstRetorno[0]->fk_idpais;
            $this->predeterminado = $lstRetorno[0]->predeterminado;
            return $this;
        }
        return null;
    }

    public function insertar() {
        $sql = "INSERT INTO legajo.domicilios (
                direccion,
                localidad,
                fk_idtidomicilio,
                fk_idprov,
                codpost,
                fk_idalumno,
                fk_idpais,
                predeterminado
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
        $this->direccion, 
        $this->localidad,
        $this->fk_idtidomicilio,
        $this->fk_idprov,
        $this->codpost,
        $this->fk_idalumno,
        $this->fk_idpais,
        $this->predeterminado
    ]);
       return $this->id = DB::getPdo()->lastInsertId();
    } 

    public function eliminarPorLegajo($legajoID) {
        $sql = "DELETE FROM legajo.domicilios
                WHERE fk_idalumno=$legajoID;";
        $deleted = DB::delete($sql);
    }

}
