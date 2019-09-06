<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Dependencia extends Model
{
    protected $table = 'public.dependencias';
    public $timestamps = false;

    protected $fillable = [
    	'iddependencia', 'descdependencia', 'ncdependencia', 'id_padre', 'interno', 'fk_idpersonal'
    ];

    protected $hidden = [

    ];

	function cargarDesdeRequest($request) {
        $this->iddependencia = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->iddependencia;
        $this->descdependencia = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->ncdependencia = isset($request["txtCodigo"]) ? $request["txtCodigo"] : "";
        $this->id_padre = isset($request["lstAreaPadre"]) && $request["lstAreaPadre"] != "" ? $request["lstAreaPadre"] : 0;
        $this->interno = isset($request["txtInterno"]) ? $request["txtInterno"] : "";
        $this->fk_idpersonal = isset($request["lstUsuario"]) ? $request["lstUsuario"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.descdependencia',
           1 => 'A.ncdependencia',
           2 => 'A.interno',
           3 => 'C.nombre',
            );
        $sql = "SELECT 
                  A.iddependencia,
                  A.descdependencia,
                  A.ncdependencia,
                  A.interno,
                  C.apellido as apellido_responsable,
                  C.nombre as nombre_responsable
                FROM public.dependencias A
                LEFT JOIN ". env("LEGAJO") ." C ON C.idpersonal = A.fk_idpersonal
                where 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.descdependencia LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.ncdependencia LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.interno LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR C.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR C.apellido LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.iddependencia,
                  A.descdependencia
                From public.dependencias A";

        $sql .= " ORDER BY A.descdependencia";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerSubDependencias($id=null){
        if($id){
            $sql = "SELECT 
                      A.iddependencia,
                      A.descdependencia
                    FROM public.dependencias A
                    WHERE A.iddependencia <> '$id'";

            $sql .= " ORDER BY A.descdependencia";
            $resultado = DB::select($sql);
        } else {
            $resultado = $this->obtenerTodos();
        }
        return $resultado;
    }

    public function obtenerPorId($iddependencia) {
        $sql = "SELECT
                iddependencia,
                descdependencia,
                ncdependencia,
                id_padre,
                interno,
                fk_idpersonal
                FROM public.dependencias WHERE iddependencia = '$iddependencia'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->iddependencia = $lstRetorno[0]->iddependencia;
            $this->descdependencia = $lstRetorno[0]->descdependencia;
            $this->ncdependencia = $lstRetorno[0]->ncdependencia;
            $this->id_padre = $lstRetorno[0]->id_padre;
            $this->interno = $lstRetorno[0]->interno;
            $this->fk_idpersonal = $lstRetorno[0]->fk_idpersonal;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE public.dependencias SET
            descdependencia='$this->descdependencia',
            ncdependencia='$this->ncdependencia',
            id_padre=$this->id_padre,
            interno='$this->interno',
            fk_idpersonal=$this->fk_idpersonal
            WHERE iddependencia=?";
        $affected = DB::update($sql, [$this->iddependencia]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM public.dependencias WHERE 
            iddependencia=?";
        $affected = DB::delete($sql, [$this->iddependencia]);
    }

    public function insertar() {
        $sql = "INSERT INTO public.dependencias (
        descdependencia,
        ncdependencia,
        id_padre,
        interno,
        fk_idpersonal
        ) VALUES (?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [$this->descdependencia, $this->ncdependencia, $this->id_padre, $this->interno, $this->fk_idpersonal]);
       return $this->iddependencia = DB::getPdo()->lastInsertId();
    } 

}
