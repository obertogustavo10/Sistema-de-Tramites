<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Pais extends Model
{
    protected $table = 'public_paises';
    public $timestamps = false;

    protected $fillable = [
    	'idpais', 'descpais', 'ncpais', 'nacionalidad'
    ];

    protected $hidden = [

    ];

	function cargarDesdeRequest($request) {
        $this->idpais = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idpais;
        $this->descpais = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->ncpais = isset($request["txtCodigo"]) ? $request["txtCodigo"] : "";
        $this->nacionalidad = isset($request["txtNacionalidad"]) ? $request["txtNacionalidad"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.descpais',
           1 => 'A.ncpais',
            );
        $sql = "SELECT 
                  A.idpais,
                  A.descpais,
                  A.ncpais
                From public_paises A WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.descpais LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.ncpais LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idpais,
                  A.descpais, 
                  A.ncpais,
                  A.nacionalidad
                From public_paises A";

        $sql .= " ORDER BY A.descpais";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                idpais,
                descpais,
                ncpais,
                nacionalidad
                FROM public_paises WHERE idpais = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idpais = $lstRetorno[0]->idpais;
            $this->descpais = $lstRetorno[0]->descpais;
            $this->ncpais = $lstRetorno[0]->ncpais;
            $this->nacionalidad = $lstRetorno[0]->nacionalidad;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE public_paises SET
            descpais='$this->descpais',
            ncpais='$this->ncpais',
            nacionalidad='$this->nacionalidad'
            WHERE idpais=?";
        $affected = DB::update($sql, [$this->idpais]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM public_paises WHERE 
            idpais=?";
        $affected = DB::delete($sql, [$this->idpais]);
    }

    public function insertar() {
        $sql = "INSERT INTO public_paises (
        descpais,
        ncpais,
        nacionalidad
        ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [$this->descpais, $this->ncpais, $this->nacionalidad]);
       return $this->idpais = DB::getPdo()->lastInsertId();
    } 

}
