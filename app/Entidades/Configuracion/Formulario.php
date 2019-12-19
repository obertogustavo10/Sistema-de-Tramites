<?php

namespace App\Entidades\Configuracion;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

Class Formulario extends Model
{
    protected $table = 'formularios';
    public $timestamps = false;

    protected $fillable = 
    [
        'idformulario', 'nombre', 'descripcion', 'url'
    ];

    protected $hidden = 
    [

    ];
    

    public function cargarDesdeRequest($request)
    {
        $this->idformulario = $request->input('id') !="0" ? $request->input('id') : $this->idformulario;
        $this->nombre = $request->input('txtNombre');
    }

    public function insertar() 
    {
        $sql = "INSERT INTO formularios (
            idformulario,
            nombre
            ) VALUES (?, ?);";
            $result = DB::insert($sql, [
                $this->idformulario,
                $this->nombre
            ]);
            return $this->idformulario = DB::getPdo()->lastInsertId();
    }
    public function guardar() 
    {
        $sql = "UPDATE formularios SET
            idformulario='$this->idformularios',
            nombre='$this->nombre',
            WHERE idformulario=?";
        $affected = DB::update($sql, [$this->idformulario]);
    }

    public  function eliminar() 
    {
        $sql = "DELETE FROM formularios WHERE 
            idformulario=?";
        $affected = DB::delete($sql, [$this->idformulario]);
    }
    public function obtenerFiltrado() 
    {
        $request = $_REQUEST;
        $columns = array(
           0 => 'idformulario',
           1 => 'nombre',
           2 => 'descripcion',
           3 => 'url'
            );
        $sql = "SELECT 
                idformulario,
                nombre,
                descripcion,
                url
                FROM formularios
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) 
        { 
            $sql.=" AND ( nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR idformulario LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
}
