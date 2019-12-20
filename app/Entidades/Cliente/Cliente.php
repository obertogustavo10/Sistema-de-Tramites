<?php

namespace App\Entidades\Cliente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Cliente extends Model{
    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [
        'idcliente', 'razon_social', 'nombre', 'mail', 'documento', 'telefono', 'fk_iddomicilio', 'fk_idtipocliente'
    ];
    protected $hidden =[

    ];
    public function cargarDesdeRequest($request) {
        $this->idcliente = $request->input('idcliente')!= "0" ? $request->input('idcliente') : $this->idcliente;
        $this->razon_social =$request->input('txtRazonSocial');
        $this->nombre =$request->input('txtNombre');
        $this->mail = $request->input('txtMail');
        $this->documento = $request->input('txtDocumento');
        $this->telefono = $request->input('txtTel');
        $this->fk_idtipocliente = $request->input('lstPersona');

    }

    public function insertar() {
        $sql = "INSERT INTO clientes (
            
                razon_social,
                nombre,
                mail,
                documento,
                telefono,
                fk_idtipocliente

            ) VALUES ( ?, ?, ?, ?, ?,?);";
       $result = DB::insert($sql, [
             
            $this->razon_social, 
            $this->nombre, 
            $this->mail, 
            $this->documento,
            $this->telefono,
            $this->fk_idtipocliente
        ]);
       return $this->idcliente = DB::getPdo()->lastInsertId();
    }
    public function guardar() {
        $sql = "UPDATE clientes SET
            razon_social='$this->razon_social',
            nombre='$this->nombre',
            mail='$this->mail',
            documento=$this->documento,
            telefono='$this->telefono',
            fk_idtipocliente='$this->fk_idtipocliente',
            WHERE idcliente=?";
        $affected = DB::update($sql, [$this->idcliente]);
    }
    public  function eliminar() {
        $sql = "DELETE FROM clientes WHERE 
            idcliente=?";
        $affected = DB::delete($sql, [$this->idcliente]);
    }
    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'A.nombre',
           1 => 'A.razon_social',
           2 => 'A.documento',
           3 => 'A.mail'
            );
        $sql = "SELECT
                    A.idcliente,
                    A.nombre,
                    A.razon_social,
                    A.documento,
                    A.telefono,
                    A.mail,
                    A.fk_idtipocliente
                    FROM clientes A
                    INNER JOIN tipo_clientes B ON A.fk_idtipocliente = B.idtipocliente
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.razon_social LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.documento LIKE '%" . $request['search']['value'] . "%' )";
            $sql.=" OR A.mail LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

}