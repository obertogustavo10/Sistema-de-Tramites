<?php

namespace App\Entidades\Cliente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Cliente extends Model{
    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [
        'idcliente', 'razon_social', 'nombre', 'mail', 'documento', 'telefono', 'fk_idtipodomicilio', 'fk_idtipocliente', 'fk_idtipodocumento'
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
        $this->fk_idtipodomicilio = $request->input('lstTipoDomicilio');
      

    }

    public function insertarCliente() {
        $sql = "INSERT INTO clientes (
            
                razon_social,
                nombre,
                mail,
                documento,
                telefono,
                fk_idtipocliente,
                fk_idtipodomicilio,
                fk_idtipodocumento


            ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";

    
       $result = DB::insert($sql, [
             
            $this->razon_social, 
            $this->nombre, 
            $this->mail, 
            $this->documento,
            $this->telefono,
            $this->fk_idtipocliente,
            $this->fk_idtidomicilio,
            $this->fk_idtidocumento,
        ]);
       return $this->idcliente = DB::getPdo()->lastInsertId();
    }
    public function guardarCliente() {
        $sql = "UPDATE clientes SET
            razon_social='$this->razon_social',
            nombre='$this->nombre',
            mail='$this->mail',
            documento=$this->documento,
            telefono='$this->telefono',
            fk_idtipocliente='$this->fk_idtipocliente',
            fk_idtipodomicilio='$this->fk_idtipodomicilio',
            fk_idtipodocumento='$this->fk_idtipodocumento'
            WHERE idcliente=?";
        $affected = DB::update($sql, [$this->idcliente]);
    }
    public  function eliminarCliente() {
        $sql = "DELETE FROM clientes WHERE 
            idcliente=?";
        $affected = DB::delete($sql, [$this->idcliente]);
    }
    public function obtenerFiltradoCliente() {
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
                    A.fk_idtipocliente,
                    C.nombre AS tipodocumento,
                    D.nombre AS tipodomicilio
                    FROM clientes A
                    INNER JOIN tipo_clientes B ON A.fk_idtipocliente = B.idtipocliente
                    INNER JOIN tipo_documentos C ON A.fk_idtipodocumento = C.nombre
                    INNER JOIN tipo_domicilios D ON A.fk_idtipodomicilio = D.nombre
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
    public function obtenerPorIdCliente($id){
        $sql = "SELECT
              idcliente,
              razon_social,
                nombre,
                mail,
                documento,
                telefono,
                fk_idtipocliente,
                fk_idtipodomicilio,
                fk_idtipodocumento
              FROM clientes WHERE idcliente = $id";
      $lstRetorno = DB::select($sql);

      return $lstRetorno;
  }
}