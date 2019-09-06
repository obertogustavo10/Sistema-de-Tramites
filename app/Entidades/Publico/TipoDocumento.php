<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class TipoDocumento extends Model
{
    protected $table = 'public.t_documentos';
    public $timestamps = false;

    protected $fillable = [
        'idtidoc', 'desctidoc', 'nctidoc'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idtidoc = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idtidoc;
        $this->desctidoc = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->nctidoc = isset($request["txtCodigo"]) ? $request["txtCodigo"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.desctidoc',
           1 => 'A.nctidoc',
            );
        $sql = "SELECT 
                  A.idtidoc,
                  A.desctidoc,
                  A.nctidoc
                From public.t_documentos A WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.desctidoc LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.nctidoc LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idtidoc,
                  A.desctidoc, 
                  A.nctidoc
                From public.t_documentos A";

        $sql .= " ORDER BY A.desctidoc";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                idtidoc,
                desctidoc,
                nctidoc
                FROM public.t_documentos WHERE idtidoc = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idtidoc = $lstRetorno[0]->idtidoc;
            $this->desctidoc = $lstRetorno[0]->desctidoc;
            $this->nctidoc = $lstRetorno[0]->nctidoc;
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE public.t_documentos SET
            desctidoc='$this->desctidoc',
            nctidoc='$this->nctidoc'
            WHERE idtidoc=?";
        $affected = DB::update($sql, [$this->id]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM public.t_documentos WHERE 
            idtidoc=?";
        $affected = DB::delete($sql, [$this->idtidoc]);
    }

    public function insertar() {
        $sql = "INSERT INTO public.t_documentos (
        desctidoc,
        nctidoc
        ) VALUES (?, ?);";
       $result = DB::insert($sql, [$this->desctidoc, $this->nctidoc]);
       return $this->idtidoc = DB::getPdo()->lastInsertId();
    } 

}
