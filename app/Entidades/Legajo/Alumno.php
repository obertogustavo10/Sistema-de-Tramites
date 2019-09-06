<?php
namespace App\Entidades\Legajo;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Alumno extends Model{
	
    protected $table = "legajo.alumnos";
    public $timestamps = false;

    protected $fillable = [
		'idalumno', 'fk_idtidoc', 'apellido', 'documento', 'nombre', 'email', 'celular', 'telparticular', 'tellaboral', 'sexo', 'fechanacimiento', 'nro_legajo', 'cuit', 'fk_idiva', 'fk_idestado', 'fk_nacionalidad', 'fk_idpais'
    ];

 public function obtenerTodos() {
       $sql ="SELECT
            idalumno,
            fk_idtidoc,
            apellido,
            documento,
            nombre,
            email,
            celular,
            telparticular,
            tellaboral,
            sexo,
            fechanacimiento,
            nro_legajo,
            cuit,
            fk_idiva,
            fk_idestado,
            fk_nacionalidad,
            fk_idpais
            FROM ". $this->table;

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function cargarDesdeRequest($request) {
		$this->idalumno = $request->input('id')!= "0" ? $request->input('id') : $this->idalumno;
		$this->fk_idtidoc = $request->input('lstTipoDocumento');
		$this->apellido = $request->input('txtApellido');
		$this->documento = $request->input('txtNroDocumento');
		$this->nombre = $request->input('txtNombre');
		$this->email = $request->input('txtEmail');
		$this->celular = $request->input('txtCelular');
		$this->telparticular = $request->input('txtTelParticular');
		$this->tellaboral = $request->input('txtTelLaboral');
		$this->sexo = $request->input('lstSexo');
		$this->fechanacimiento = $request->input('txtFechaNacimiento');
		$this->nro_legajo = $request->input('txtNroLegajo');
		$this->cuit = $request->input('txtCuit');
		$this->fk_idiva = $request->input('lstSituacionImpositiva');
		$this->fk_idestado = $request->input('lstSituacionImpositiva');
		$this->fk_nacionalidad = $request->input('lstPaisNacionalidad');
		$this->fk_idpais = $request->input('lstPaisNacimiento');  
    }

    public function obtenerPorId($id) {
       $sql ="SELECT
            idalumno,
            fk_idtidoc,
            apellido,
            documento,
            nombre,
            email,
            celular,
            telparticular,
            tellaboral,
            sexo,
            fechanacimiento,
            nro_legajo,
            cuit,
            fk_idiva,
            fk_idestado,
            fk_nacionalidad,
            fk_idpais
            FROM ". $this->table ." WHERE idalumno = '$id'";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0){
			$this->idalumno = $lstRetorno[0]->idalumno;
			$this->fk_idtidoc = $lstRetorno[0]->fk_idtidoc;
			$this->apellido = $lstRetorno[0]->apellido;
			$this->documento = $lstRetorno[0]->documento;
			$this->nombre = $lstRetorno[0]->nombre;
			$this->email = $lstRetorno[0]->email;
			$this->celular = $lstRetorno[0]->celular;
			$this->telparticular = $lstRetorno[0]->telparticular;
			$this->tellaboral = $lstRetorno[0]->tellaboral;
			$this->sexo = $lstRetorno[0]->sexo;
			$this->fechanacimiento = $lstRetorno[0]->fechanacimiento;
			$this->nro_legajo = $lstRetorno[0]->nro_legajo;
			$this->cuit = $lstRetorno[0]->cuit;
			$this->fk_idiva = $lstRetorno[0]->fk_idiva;
			$this->fk_idestado = $lstRetorno[0]->fk_idestado;
			$this->fk_nacionalidad = $lstRetorno[0]->fk_nacionalidad;
			$this->fk_idpais = $lstRetorno[0]->fk_idpais;    
            return $lstRetorno[0];
        }
        return null;
    }

    public function obtenerPorDni($dni) {
       $sql ="SELECT
            idalumno,
            fk_idtidoc,
            apellido,
            documento,
            nombre,
            email,
            celular,
            telparticular,
            tellaboral,
            sexo,
            fechanacimiento,
            nro_legajo,
            cuit,
            fk_idiva,
            fk_idestado,
            fk_nacionalidad,
            fk_idpais
            FROM ". $this->table ." WHERE documento = '$dni'";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0){
            $this->idalumno = $lstRetorno[0]->idalumno;
            $this->fk_idtidoc = $lstRetorno[0]->fk_idtidoc;
            $this->apellido = $lstRetorno[0]->apellido;
            $this->documento = $lstRetorno[0]->documento;
            $this->nombre = $lstRetorno[0]->nombre;
            $this->email = $lstRetorno[0]->email;
            $this->celular = $lstRetorno[0]->celular;
            $this->telparticular = $lstRetorno[0]->telparticular;
            $this->tellaboral = $lstRetorno[0]->tellaboral;
            $this->sexo = $lstRetorno[0]->sexo;
            $this->fechanacimiento = $lstRetorno[0]->fechanacimiento;
            $this->nro_legajo = $lstRetorno[0]->nro_legajo;
            $this->cuit = $lstRetorno[0]->cuit;
            $this->fk_idiva = $lstRetorno[0]->fk_idiva;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;
            $this->fk_nacionalidad = $lstRetorno[0]->fk_nacionalidad;
            $this->fk_idpais = $lstRetorno[0]->fk_idpais;    
            return $lstRetorno[0];
        }
        return null;
    }

    public function insertar() {
        $sql = "INSERT INTO ". $this->table ." (
            fk_idtidoc,
            apellido,
            documento,
            nombre,
            email,
            celular,
            telparticular,
            tellaboral,
            sexo,
            fechanacimiento,
            nro_legajo,
            cuit,
            fk_idiva,
            fk_idestado,
            fk_nacionalidad,
            fk_idpais
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
			$this->fk_idtidoc,
			$this->apellido,
			$this->documento,
			$this->nombre,
			$this->email,
			$this->celular,
			$this->telparticular,
			$this->tellaboral,
			$this->sexo,
			$this->fechanacimiento,
            $this->nro_legajo,
            $this->cuit,
            $this->fk_idiva,
            $this->fk_idestado,
            $this->fk_nacionalidad,
            $this->fk_idpais
       ]);
       $this->idalumno = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
        $sql = "UPDATE ". $this->table ." SET
            fk_idtidoc='$this->fk_idtidoc',
            apellido='$this->apellido',
            documento='$this->documento',
            nombre='$this->nombre',
            email='$this->email',
            celular='$this->celular',
            telparticular='$this->telparticular',
            tellaboral='$this->tellaboral',
            sexo='$this->sexo',
            nro_legajo='$this->nro_legajo',";
            if($this->fechanacimiento != "") $sql .= "fechanacimiento='$this->fechanacimiento',";
            if($this->fk_nacionalidad != "") $sql .= "fk_nacionalidad='$this->fk_nacionalidad',";
            if($this->fk_idpais != "") $sql .= "fk_idpais='$this->fk_idpais',";
            if($this->fk_idiva != "") $sql .= "fk_idiva='$this->fk_idiva',";
            if($this->fk_idestado != "") $sql .= "fk_idestado='$this->fk_idestado',";
            $sql .= "cuit='$this->cuit'";
            $sql .= "WHERE idalumno=?;";

        $affected = DB::update($sql, [$this->idalumno]);
    }

   public function guardarDesdeAutogestion() {
        $sql = "UPDATE ". $this->table ." SET
            email='$this->email',
            celular='$this->celular',
            telparticular='$this->telparticular',
            tellaboral='$this->tellaboral',
            sexo='$this->sexo',";
            if($this->fechanacimiento != "") $sql .= "fechanacimiento='$this->fechanacimiento',";
            if($this->fk_nacionalidad != "") $sql .= "fk_nacionalidad='$this->fk_nacionalidad',";
            if($this->fk_idpais != "") $sql .= "fk_idpais='$this->fk_idpais',";
            if($this->fk_idiva != "") $sql .= "fk_idiva='$this->fk_idiva',";
            if($this->fk_idestado != "") $sql .= "fk_idestado='$this->fk_idestado',";
            $sql .= "cuit='$this->cuit'";
            $sql .= "WHERE idalumno=?;";

        $affected = DB::update($sql, [$this->idalumno]);
    }

    public function insertarDesdeUsuario($usuario) {
        $sql = "INSERT INTO ". $this->table ." (
            nombre, 
            apellido,
            email
        ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [
            $usuario->nombre,
            $usuario->apellido,
            $usuario->email
       ]);
       $this->idalumno = DB::getPdo()->lastInsertId();
    }

     public function guardarDesdeUsuario($usuario) {
        $sql = "UPDATE ". $this->table ." SET
            nombre='$usuario->nombre',
            apellido='$usuario->apellido',
            email='$usuario->email'
            WHERE idalumno=?;";

        $affected = DB::update($sql, [$usuario->fk_idlegajo]);
    }


   /* public function obtenerGrilla() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.documento',
            1 => 'A.nombre'
            );
        $sql = "SELECT DISTINCT
                A.idalumno,
                A.documento,
                A.nombre, 
                A.apellido,
                A.email,
                A.cuit,
                A.celular,
                A.fk_idestado as estado
                FROM ". $this->table ." A
                WHERE 1=1";

        if (!empty($request['search']['value'])) {      
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }*/

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.documento',
            1 => 'A.nombre',
            2 => 'A.email',
            3 => 'A.celular',
            4 => 'B.descestado'
        );
        $sql = "SELECT 
                A.idalumno,
                A.documento,
                A.nombre, 
                A.apellido,
                A.email,
                A.cuit,
                A.celular,
                B.descestado as estado
                FROM legajo.alumnos A
                LEFT JOIN public.t_estado B ON B.idestado = A.fk_idestado
                WHERE 1=1";

        //Realiza el filtrado
         if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.documento = '" . intval($request['search']['value']) . "' ";
            $sql.=" OR A.nombre ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.email ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.celular ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.descestado ILIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function obtenerGrillaPorOferta($idOferta) {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.documento',
            1 => 'A.nombre',
            2 => 'A.email',
            3 => 'A.celular',
            4 => 'B.descestado'
        );
        $sql = "SELECT 
                A.idalumno,
                A.documento,
                A.nombre, 
                A.apellido,
                A.email,
                A.cuit,
                A.celular,
                B.descestado as estado
                FROM legajo.alumnos A
                LEFT JOIN public.t_estado B ON B.idestado = A.fk_idestado
                INNER JOIN cursada.alumaterias C ON C.fk_idalumno = A.idalumno 
                INNER JOIN cursada.ofertacursada D ON D.idcursada = C.fk_idcursada
                WHERE D.idcursada = $idOferta";

        //Realiza el filtrado
         if (!empty($request['search']['value'])) { 
            $sql.=" AND (A.documento = '" . intval($request['search']['value']) . "' ";
            $sql.=" OR A.nombre ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.email ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.celular ILIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR B.descestado ILIKE '%" . $request['search']['value'] . "%') ";
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
