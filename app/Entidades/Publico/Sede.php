<?php

namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Sede extends Model
{
    protected $table = 'public.sedes';
    public $timestamps = false;

    protected $fillable = [
        'idsede', 'descsede', 'ncsede', 'domicilio', 'urlweb', 'telefono', 'contacto', 'comentarios'
    ];

    protected $hidden = [

    ];

    function cargarDesdeRequest($request) {
        $this->idsede = isset($request["id"]) && $request["id"] != "0" ? $request["id"] : $this->idsede;
        $this->descsede = isset($request["txtNombre"]) ? $request["txtNombre"] : "";
        $this->ncsede = isset($request["txtCodigo"]) ? $request["txtCodigo"] : "";
        $this->domicilio = isset($request["txtDomicilio"]) ? $request["txtDomicilio"] : "";
        $this->urlweb = isset($request["txtWeb"]) ? $request["txtWeb"] : "";
        $this->telefono = isset($request["txtTelefono"]) ? $request["txtTelefono"] : "";
        $this->contacto = isset($request["txtContacto"]) ? $request["txtContacto"] : "";
        $this->comentarios = isset($request["txtComentario"]) ? $request["txtComentario"] : "";
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.ncsede',
           1 => 'A.descsede',
           2 => 'A.domicilio',
           3 => 'A.telefono'
            );
        $sql = "SELECT 
                  A.idsede,
                  A.descsede,
                  A.ncsede,
                  A.domicilio,
                  A.urlweb,
                  A.telefono,
                  A.contacto,
                  A.comentarios
                From public.sedes A WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.ncsede LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.descsede LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.domicilio LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.telefono LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                  A.idsede,
                  A.descsede,
                  A.ncsede,
                  A.domicilio,
                  A.urlweb,
                  A.telefono,
                  A.contacto,
                  A.comentarios
                From public.sedes A";

        $sql .= " ORDER BY A.descsede";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT
                A.idsede,
                A.descsede,
                A.ncsede,
                A.domicilio,
                A.urlweb,
                A.telefono,
                A.contacto,
                A.comentarios
                FROM public.sedes A WHERE idsede = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idsede = $lstRetorno[0]->idsede;
            $this->descsede = $lstRetorno[0]->descsede;
            $this->ncsede = $lstRetorno[0]->ncsede;
            $this->domicilio = $lstRetorno[0]->domicilio;
            $this->urlweb = $lstRetorno[0]->urlweb;
            $this->telefono = $lstRetorno[0]->telefono;
            $this->contacto = $lstRetorno[0]->contacto;
            $this->comentarios = $lstRetorno[0]->comentarios;
            return $this;
        }
        return null;
    }

    public function guardar() {
        DB::table($this->table)
            ->where('idsede', $this->idsede)
            ->update([
                'descsede' => $this->descsede,
                'ncsede' => $this->ncsede,
                'domicilio' => $this->domicilio,
                'urlweb' => $this->urlweb,
                'telefono' => $this->telefono,
                'contacto' => $this->contacto,
                'comentarios' => $this->comentarios
            ]);
    }

    public function insertar() {
        DB::table($this->table, 'idsede')->insert([
            'descsede' => $this->descsede,
            'ncsede' => $this->ncsede,
            'domicilio' => $this->domicilio,
            'urlweb' => $this->urlweb,
            'telefono' => $this->telefono,
            'contacto' => $this->contacto,
            'comentarios' => $this->comentarios
        ]);
       return $this->idsede = DB::getPdo()->lastInsertId();
    } 

}
