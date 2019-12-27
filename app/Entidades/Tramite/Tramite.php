<?php

namespace App\Entidades\Tramite;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Tramite extends Model{
    protected $table = 'tramites';
    public $timestamps = false;

    protected $fillable = [
        'idtramite',
        'rectificativa',
        'fecha_inicio',
        'fk_idcliente',
        'fk_idformulario',
        'fk_idtramite_estado',
        'fk_formulario_url',
        'usuario_sistema',

    ];

    protected $hidden = [

    ];

    
    public function guardar() {
        $sql = "UPDATE tramites SET
                rectificativa='$this->rectificativa',
                fecha_inicio='$this->fecha_inicio',
                fk_idcliente='$this->fk_idcliente',
                fk_idformulario='$this->fk_idformulario',
                fk_idtramite_estado='$this->fk_idtramite_estado',
                fk_formulario_url='$this->fk_formulario_url,
                usuario_sistema='$this->usuario_sistema'
            WHERE idtramite=?";
        $affected = DB::update($sql, [$this->idtramite]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM tramites WHERE 
            idtramite=?";
        $affected = DB::delete($sql, [$this->idtramite]);
    }

    public function insertar() {
        $sql = "INSERT INTO tramites (
               rectificativa,
               fecha_inicio,
               fk_idcliente,
               fk_idformulario,
               fk_idtramite_estado,
               fk_formulario_url,
               usuario_sistema
            ) VALUES (?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            $this->rectificativa, 
            $this->fecha_inicio, 
            $this->fk_idcliente, 
            $this->fk_idformulario, 
            $this->fk_idtramite_estado,
            $this->fk_formulario_url,
            $this->usuario_sistema
        ]);
       return $this->idtramite = DB::getPdo()->lastInsertId();
    }

    public function obtenerFiltrado($idtramite_estado) {
        $request = $_REQUEST;
        $columns = array(
           0 => 'C.nombre',
           1 => 'B.nombre',
           2 => 'A.fecha_inicio',
           3 => 'A.rectificativa'
            );
        $sql =  "SELECT DISTINCT
                A.idtramite, 
                A.fk_idformulario,
                C.nombre AS nombre_tramite,
                A.fk_idtramite_estado,
                B.nombre AS estado,
                A.rectificativa,
                A.fecha_inicio,
                A.fk_formulario_url,
                D.razon_social,
                D.documento
                FROM tramites A
                INNER JOIN tramite_estado B ON A.fk_idtramite_estado = B.idtramite_estado
                INNER JOIN formularios C ON A.fk_idformulario = C.idformulario
                LEFT JOIN clientes D ON D.idcliente = A.fk_idcliente
                /* INNER JOIN formularios D ON A.fk_formulario_url = D.url */
                /* SE TIENE QUE HACER DESDE AQUI PERO NO SE ENCUENTRA LA FK */
                WHERE fk_idtramite_estado = ".$idtramite_estado."
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( C.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.fecha_inicio LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
    public function obtenerFiltradoFinalizado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'C.nombre',
           1 => 'B.nombre',
           2 => 'A.fecha_inicio',
           3 => 'A.rectificativa'
            );
        $sql =  "SELECT DISTINCT
                A.idtramite, 
                A.fk_idformulario,
                C.nombre AS nombre_tramite,
                A.fk_idtramite_estado,
                B.nombre AS estado,
                A.rectificativa,
                A.fecha_inicio,
                A.fk_formulario_url,
                D.razon_social,
                D.documento
                FROM tramites A
                INNER JOIN tramite_estado B ON A.fk_idtramite_estado = B.idtramite_estado
                INNER JOIN formularios C ON A.fk_idformulario = C.idformulario
                LEFT JOIN clientes D ON D.idcliente = A.fk_idcliente
                WHERE fk_idtramite_estado = ".TRAMITE_FINALIZADO." OR fk_idtramite_estado =".TRAMITE_ANULADO;

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( C.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.fecha_inicio LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function procesar() {
        $sql = "UPDATE tramites SET
                fk_idtramite_estado= " . TRAMITE_EN_PROCESO ."
            WHERE idtramite=?";
        $affected = DB::update($sql, [$this->idtramite]);
    }

    public function finalizar() {
        $sql = "UPDATE tramites SET
                fk_idtramite_estado= " . TRAMITE_FINALIZADO ."
            WHERE idtramite=?";
        $affected = DB::update($sql, [$this->idtramite]);
    }

    public function anular() {
        $sql = "UPDATE tramites SET
                fk_idtramite_estado= " . TRAMITE_ANULADO ."
            WHERE idtramite=?";
        $affected = DB::update($sql, [$this->idtramite]);
    }

    public function rechazar() {
        $sql = "UPDATE tramites SET
                fk_idtramite_estado= " . TRAMITE_RECTIFICAR ."
            WHERE idtramite=?";
        $affected = DB::update($sql, [$this->idtramite]);
    }

}
