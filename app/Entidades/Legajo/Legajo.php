<?php

namespace App\Entidades\Legajo;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Legajo extends Model
{
    protected $table = 'legajo_datospersonales';
    public $timestamps = false;

    protected $fillable = [
		'id', 'nro_legajo', 'fk_tipo_documento', 'nro_documento', 'sexo', 'fecha_nacimiento', 'fk_nacionalidad_id', 'fk_paisnacimiento_id', 'cuit', 'fk_situacionimpositiva_id', 'fk_estado_id', 'fk_area_id', 'fk_cargo_id', 'nombre', 'apellido', 'email'
    ];

    public function cargarDesdeRequest($request) {
        $this->id = $request->input('id')!= "0" ? $request->input('id') : $this->id;
        $this->nro_legajo = $request->input('txtNroLegajo');
        $this->fk_tipo_documento = $request->input('lstTipoDocumento');
        $this->nro_documento = $request->input('txtNroDocumento');
        $this->sexo = $request->input('lstSexo');
        $this->fecha_nacimiento = $request->input('txtFechaNacimiento');
        $this->fk_nacionalidad_id = $request->input('lstPaisNacionalidad');
        $this->fk_paisnacimiento_id = $request->input('lstPaisNacimiento');
        $this->cuit = $request->input('txtCuit');
        $this->fk_situacionimpositiva_id = $request->input('lstSituacionImpositiva');
        $this->fk_estado_id = $request->input('lstEstado');
        $this->fk_area_id = $request->input('lstArea');
        $this->fk_cargo_id = $request->input('lstCargo');
        $this->nombre = $request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->email = $request->input('txtEmail');
    }

    public function obtenerPorId($id) {
       $sql ="SELECT
			id,
			nro_legajo,
			fk_tipo_documento,
			nro_documento,
			sexo,
			fecha_nacimiento,
			fk_nacionalidad_id,
			fk_paisnacimiento_id,
			cuit,
			fk_situacionimpositiva_id,
			fk_estado_id,
			fk_area_id,
			fk_cargo_id,
            nombre, 
            apellido,
            email
            FROM legajo_datospersonales WHERE id = '$id'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->id = $lstRetorno[0]->id;
			$this->nro_legajo = $lstRetorno[0]->nro_legajo;
			$this->fk_tipo_documento = $lstRetorno[0]->fk_tipo_documento;
			$this->nro_documento = $lstRetorno[0]->nro_documento;
			$this->sexo = $lstRetorno[0]->sexo;
			$this->fecha_nacimiento = $lstRetorno[0]->fecha_nacimiento;
			$this->fk_nacionalidad_id = $lstRetorno[0]->fk_nacionalidad_id;
			$this->fk_paisnacimiento_id = $lstRetorno[0]->fk_paisnacimiento_id;
			$this->cuit = $lstRetorno[0]->cuit;
			$this->fk_situacionimpositiva_id = $lstRetorno[0]->fk_situacionimpositiva_id;
			$this->fk_estado_id = $lstRetorno[0]->fk_estado_id;
			$this->fk_area_id = $lstRetorno[0]->fk_area_id;
			$this->fk_cargo_id = $lstRetorno[0]->fk_cargo_id;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->email = $lstRetorno[0]->email;
            return $lstRetorno[0];
        }
        return null;
    }



    public function insertar() {
        $sql = "INSERT INTO legajo_datospersonales (
        	nro_legajo,
			fk_tipo_documento,
			nro_documento,
			sexo,
			fecha_nacimiento,
			fk_nacionalidad_id,
			fk_paisnacimiento_id,
			cuit,
			fk_situacionimpositiva_id,
			fk_estado_id,
			fk_area_id,
			fk_cargo_id,
            nombre, 
            apellido,
            email
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
			$this->nro_legajo,
			$this->fk_tipo_documento,
			$this->nro_documento,
			$this->sexo,
			$this->fecha_nacimiento,
			$this->fk_nacionalidad_id,
			$this->fk_paisnacimiento_id,
			$this->cuit,
			$this->fk_situacionimpositiva_id,
			$this->fk_estado_id,
			$this->fk_area_id,
			$this->fk_cargo_id,
            $this->nombre,
            $this->apellido,
            $this->email
       ]);
       $this->id = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE legajo_datospersonales SET
            nro_legajo='$this->nro_legajo',
            fk_tipo_documento='$this->fk_tipo_documento',
            nro_documento='$this->nro_documento',
            sexo='$this->sexo',";
            if($this->fecha_nacimiento != "") $sql .= "fecha_nacimiento='$this->fecha_nacimiento',";
            if($this->fk_nacionalidad_id != "") $sql .= "fk_nacionalidad_id='$this->fk_nacionalidad_id',";
            if($this->fk_paisnacimiento_id != "") $sql .= "fk_paisnacimiento_id='$this->fk_paisnacimiento_id',";
            if($this->fk_situacionimpositiva_id != "") $sql .= "fk_situacionimpositiva_id='$this->fk_situacionimpositiva_id',";
            if($this->fk_estado_id != "") $sql .= "fk_estado_id='$this->fk_estado_id',";
            if($this->fk_area_id != "") $sql .= "fk_area_id='$this->fk_area_id',";
            if($this->fk_cargo_id != "") $sql .= "fk_cargo_id='$this->fk_cargo_id',";
            $sql .= "cuit='$this->cuit',
            nombre='$this->nombre',
            apellido='$this->apellido',
            email='$this->email'
            WHERE id=?;";
        $affected = DB::update($sql, [$this->id]);
    }

    public function insertarDesdeUsuario($usuario) {
        $sql = "INSERT INTO legajo_datospersonales (
            nombre, 
            apellido,
            email
        ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [
            $usuario->nombre,
            $usuario->apellido,
            $usuario->email
       ]);
       $this->id = DB::getPdo()->lastInsertId();
    }

     public function guardarDesdeUsuario($usuario) {
        $sql = "UPDATE legajo_datospersonales SET
            nombre='$usuario->nombre',
            apellido='$usuario->apellido',
            email='$usuario->email'
            WHERE id=?;";

        $affected = DB::update($sql, [$usuario->fk_legajo_id]);
    }


    public function obtenerGrilla() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.nro_documento',
            1 => 'A.nombre'
            );
        $sql = "SELECT DISTINCT
                A.id,
                A.nro_documento,
                A.nombre, 
                A.apellido,
                A.email,
                A.cuit,
                C.nombre as estado
                FROM legajo_datospersonales A
                LEFT JOIN legajo_estado C ON C.id = A.fk_estado_id WHERE 1=1";

        if (!empty($request['search']['value'])) {      
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function validarNroDocumento($documento, $idalumno=null){
        if($idalumno != "") {
            $sql = "SELECT count(A.documento) as cantidad
                FROM ". $this->table ." A
                WHERE A.documento = '$documento' AND A.idalumno <> $idalumno;";
        } else {
           $sql = "SELECT count(A.documento) as cantidad
                FROM ". $this->table ." A
                WHERE A.documento = '$documento';";
        }

        $lstRetorno = DB::select($sql);
        return $lstRetorno[0]->cantidad>0;
    }

}
