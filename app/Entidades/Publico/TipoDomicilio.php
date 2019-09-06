<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class TipoDomicilio extends Model
{
    protected $table = 'public.t_domicilios';
    public $timestamps = false;

    protected $fillable = [
        'idtidomicilio', 'desctidomicilio', 'nctidomicilio'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idtidomicilio = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idtidomicilio;
        $this->desctidomicilio = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->nctidomicilio = isset($request["txtIdentificador"]) ? $request["txtIdentificador"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.desctidomicilio'
            );
        $sql = "SELECT 
                  A.idtidomicilio,
                  A.desctidomicilio,
                  A.nctidomicilio
                From public.t_domicilios A WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.desctidomicilio LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.nctidomicilio LIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idtidomicilio,
                  A.desctidomicilio,
                  A.nctidomicilio
                From public.t_domicilios A";

        $sql .= " ORDER BY A.desctidomicilio";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                idtidomicilio,
                desctidomicilio,
                nctidomicilio
                FROM public.t_domicilios WHERE idtidomicilio = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idtidomicilio = $lstRetorno[0]->idtidomicilio;
            $this->desctidomicilio = $lstRetorno[0]->desctidomicilio;
            $this->nctidomicilio = $lstRetorno[0]->nctidomicilio;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE public.t_domicilios SET
            desctidomicilio='$this->desctidomicilio',
            nctidomicilio='$this->nctidomicilio'
            WHERE idtidomicilio=?";
        $affected = DB::update($sql, [$this->idtidomicilio]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM public.t_domicilios WHERE 
            idtidomicilio=?";
        $affected = DB::delete($sql, [$this->idtidomicilio]);
    }

    public function insertar() {
        $sql = "INSERT INTO public.t_domicilios (
        desctidomicilio,
        nctidomicilio
        ) VALUES (?, ?);";
       $result = DB::insert($sql, [$this->desctidomicilio, $this->nctidomicilio]);
       return $this->idtidomicilio = DB::getPdo()->lastInsertId();
    } 

}
