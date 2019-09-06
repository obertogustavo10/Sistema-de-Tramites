<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class SituacionImpositiva extends Model
{
    protected $table = 'public.situimpositiva';
    public $timestamps = false;

    protected $fillable = [
        'idiva', 'desciva', 'nciva'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idiva = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idiva;
        $this->desciva = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->nciva = isset($request["txtIdentificador"]) ? $request["txtIdentificador"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.desciva',
           0 => 'A.nciva',
            );
        $sql = "SELECT 
                  A.idiva,
                  A.desciva,
                  A.nciva
                From public.situimpositiva A WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.desciva ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.nciva ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idiva,
                  A.desciva,
                  A.nciva
                From public.situimpositiva A";

        $sql .= " ORDER BY A.idiva";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                idiva,
                desciva,
                nciva
                FROM public.situimpositiva WHERE idiva = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idiva = $lstRetorno[0]->idiva;
            $this->desciva = $lstRetorno[0]->desciva;
            $this->nciva = $lstRetorno[0]->nciva;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE public.situimpositiva SET
            desciva='$this->desciva',
            nciva='$this->nciva'
            WHERE idiva=?";
        $affected = DB::update($sql, [$this->idiva]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM public.situimpositiva WHERE 
            idiva=?";
        $affected = DB::delete($sql, [$this->idiva]);
    }

    public function insertar() {
        $sql = "INSERT INTO public.situimpositiva (
        desciva,
        nciva
        ) VALUES (?, ?);";
       $result = DB::insert($sql, [$this->desciva, $this->nciva]);
       return $this->idiva = DB::getPdo()->lastInsertId();
    } 

}
