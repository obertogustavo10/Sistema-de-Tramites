<?php

namespace App\Entidades\Tramite;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Tramite extends Model
{
    protected $table = 'tramites';
    public $timestamps = false;

    protected $fillable = [
        'idtramite','rectificativa','fecha_inicio','fk_idcliente','fk_idformulario','fk_idtramite_estado','usuario_sistema'

    ];

    protected $hidden = [

    ];

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
           0 => 'C.nombre',
           1 => 'B.nombre',
           2 => 'A.fecha_inicio',
           3 => 'A.rectificativa'
            );
        $sql = "SELECT
                    A.idtramite, 
                    A.fk_idformulario,
                    C.nombre AS nombre_tramite,
                    A.fk_idtramite_estado,
                    B.nombre AS estado,
                    A.rectificativa,
                    A.fecha_inicio
                    FROM tramites A
                    INNER JOIN tramite_estado B ON A.fk_idtramite_estado = B.idtramite_estado
                    INNER JOIN formularios C ON A.fk_idformulario = C.idformulario
                WHERE 1=1
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

}
