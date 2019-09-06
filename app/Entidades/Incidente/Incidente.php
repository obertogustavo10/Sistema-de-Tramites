<?php

namespace App\Entidades\Incidente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Incidente extends Model
{
    protected $table = 'incidente_incidente';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'fecha_alta',
        'fecha_cerrado',
        'fecha_modificado',
        'usuario_ultmodif',
        'fk_estado_id',
        'fk_prioridad_id',
        'descripcion',
        'fk_categoria_id',
        'fk_sistema_grupo_id'
    ];

    public function cargarDesdeRequest($request) {
        $this->id = $request->input('id') != "0" ? $request->input('id') : $this->id;
        $this->titulo = $request->input('txtTitulo');
        $this->fk_estado_id = $request->input('lstEstado');
        $this->fk_prioridad_id = $request->input('lstPrioridad');
        $this->descripcion = $request->input('txtDescripcion');
        $this->fk_categoria_id = $request->input('lstCategoria');
    }

    public function obtenerPorId($id) {
       $sql ="SELECT
                    A.id,
                    A.titulo,
                    A.fecha_alta,
                    A.fecha_cerrado,
                    A.fecha_modificado,
                    A.usuario_ultmodif,
                    A.fk_estado_id,
                    A.fk_prioridad_id,
                    A.descripcion,
                    A.fk_categoria_id,
                    B.nombre,
                    B.apellido,
                    A.fk_sistema_grupo_id
            FROM incidente_incidente A
            LEFT JOIN sistema_usuario B ON A.usuario_ultmodif = B.id WHERE A.id = '$id'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->id =$lstRetorno[0]->id;
            $this->titulo =$lstRetorno[0]->titulo;
            $this->fecha_alta = date_format(date_create($lstRetorno[0]->fecha_alta), 'Y-m-d H:i');
            $this->fecha_cerrado =$lstRetorno[0]->fecha_cerrado;
            $this->fecha_modificado = date_format(date_create($lstRetorno[0]->fecha_modificado), 'Y-m-d H:i');
            $this->usuario_ultmodif = $lstRetorno[0]->usuario_ultmodif;
            $this->fk_estado_id =$lstRetorno[0]->fk_estado_id;
            $this->fk_prioridad_id =$lstRetorno[0]->fk_prioridad_id;
            $this->descripcion =$lstRetorno[0]->descripcion;
            $this->fk_categoria_id =$lstRetorno[0]->fk_categoria_id;
            $this->usuario_modif = ", " . $lstRetorno[0]->apellido . " ". $lstRetorno[0]->nombre;
            return $lstRetorno[0];
        }
        return null;
    }

    public function insertarAdministrador() {
        $now = new \DateTime();

        $sql = "INSERT INTO incidente_incidente (
                titulo,
                fecha_alta,
                fecha_modificado,
                usuario_ultmodif,
                fk_estado_id,
                fk_prioridad_id,
                descripcion,
                fk_categoria_id,
                fk_sistema_grupo_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [ $this->titulo, 
                                    $now->format('Y-m-d H:i:s'),
                                    $now->format('Y-m-d H:i:s'),
                                    Session::get('usuario_id'),
                                    $this->fk_estado_id,
                                    $this->fk_prioridad_id,
                                    $this->descripcion,
                                    $this->fk_categoria_id,
                                    Session::get('grupo_id')
                                ]);
       $this->id = DB::getPdo()->lastInsertId();
    }

    public function insertarSolicitante() {
        //Si el usuario es solicitante guarda: titulo, descripcion, categoria y prioridad
        $now = new \DateTime();

        $sql = "INSERT INTO incidente_incidente (
                titulo,
                fecha_alta,
                fecha_modificado,
                usuario_ultmodif,
                fk_estado_id,
                fk_prioridad_id,
                descripcion,
                fk_categoria_id,
                fk_sistema_grupo_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [ $this->titulo, 
                                    $now->format('Y-m-d H:i:s'),
                                    $now->format('Y-m-d H:i:s'),
                                    Session::get('usuario_id'),
                                    INCIDENTE_ESTADO_NUEVO,
                                    $this->fk_prioridad_id,
                                    $this->descripcion,
                                    $this->fk_categoria_id,
                                    Session::get('grupo_id')
                                ]);
       $this->id = DB::getPdo()->lastInsertId();
    }

    public function guardarAdministrador() {
        $now = new \DateTime();
        $fecha = $now->format('Y-m-d H:i:s');
        $usuario = Session::get('usuario_id');
        $fecha_cerrado = "NULL";

        if($this->fk_estado_id == INCIDENTE_CERRADO){
            $sql = "UPDATE incidente_incidente SET
            fecha_cerrado = '$fecha',
            fecha_modificado = '$fecha',
            usuario_ultmodif = $usuario,
            fk_estado_id = $this->fk_estado_id,
            fk_prioridad_id = $this->fk_prioridad_id,
            fk_categoria_id = $this->fk_categoria_id
            WHERE id='$this->id';";
        } else {
            $sql = "UPDATE incidente_incidente SET
            fecha_modificado = '$fecha',
            usuario_ultmodif = $usuario,
            fk_estado_id = $this->fk_estado_id,
            fk_prioridad_id = $this->fk_prioridad_id,
            fk_categoria_id = $this->fk_categoria_id
            WHERE id='$this->id';";
        }

        $affected = DB::update($sql, [$this->id]);
    }

    public function guardarAsignado() {
        //Si el usuario es el asignado guarda: categoria y estado-en-espera y/o estado-en-curso
        $now = new \DateTime();
        $fecha = $now->format('Y-m-d H:i:s');
        $usuario = Session::get('usuario_id');
        $fecha_cerrado = "NULL";

        $sql = "UPDATE incidente_incidente SET
        fecha_modificado = '$fecha',
        usuario_ultmodif = $usuario,
        fk_categoria_id = $this->fk_categoria_id
        ";

        if($this->fk_estado_id == INCIDENTE_ESTADO_ENESPERA || $this->fk_estado_id == INCIDENTE_ESTADO_ENCURSO){
            $sql .= ", fk_estado_id = $this->fk_estado_id";        
        }
        
        $sql .= " WHERE id='$this->id';";

        $affected = DB::update($sql, [$this->id]);
    }

    public function obtenerGrilla() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'titulo',
            1 => 'activo');
        $sql = "SELECT 
            A.id,
            A.titulo,
            A.descripcion,
            B.nombre as 'estado',
            A.fecha_modificado,     
            A.fecha_alta,       
            D.nombre as 'prioridad',
            (
            SELECT GROUP_CONCAT(F.nombre, ' ', F.apellido)
            FROM incidente_usuario E
            INNER JOIN sistema_usuario F ON F.id = E.fk_usuario_id
            WHERE E.tipo = 'S' AND E.fk_incidente_id = A.id
            )
            as 'solicitante', 

            (
            SELECT GROUP_CONCAT(F.nombre, ' ', F.apellido)
            FROM incidente_usuario E
            INNER JOIN sistema_usuario F ON F.id = E.fk_usuario_id
            WHERE E.tipo = 'A' AND E.fk_incidente_id = A.id
            )
            as 'asignado', 

            C.nombre as 'categoria'
            FROM incidente_incidente A
            INNER JOIN incidente_estado B ON A.fk_estado_id = B.id
            LEFT JOIN incidente_categoria C ON A.fk_categoria_id = C.id
            INNER JOIN incidente_prioridad D ON A.fk_prioridad_id = D.id  WHERE 1=1 AND A.fk_sistema_grupo_id = " . Session::get('grupo_id');

        if (!empty($requestData['search']['value'])) {
            // if there is a search parameter, $requestData['search']['value'] contains search parameter            
            $sql.=" AND ( titulo LIKE '%" . $requestData['search']['value'] . "%' )";
        }
        
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function rechazarSolucion($id){
        $now = new \DateTime();
        $fecha = $now->format('Y-m-d H:i:s');
        $usuario = Session::get('usuario_id');

        $sql = "UPDATE incidente_incidente SET
        fecha_cerrado = '$fecha',
        fecha_modificado = '$fecha',
        usuario_ultmodif = $usuario,
        fk_estado_id = ".INCIDENTE_ASIGNADO."
        WHERE id='$id';";

        $affected = DB::update($sql, [$this->id]);   
    }


    public function aprobarSolucion($id){
        $now = new \DateTime();
        $fecha = $now->format('Y-m-d H:i:s');
        $usuario = Session::get('usuario_id');

        $sql = "UPDATE incidente_incidente SET
        fecha_cerrado = '$fecha',
        fecha_modificado = '$fecha',
        usuario_ultmodif = $usuario,
        fk_estado_id = ".INCIDENTE_CERRADO."
        WHERE id='$id';";

        $affected = DB::update($sql, [$this->id]);   
    }
    
    public function enviarSolucion($id){
        $now = new \DateTime();
        $fecha = $now->format('Y-m-d H:i:s');
        $usuario = Session::get('usuario_id');

        $sql = "UPDATE incidente_incidente SET
        fecha_cerrado = '$fecha',
        fecha_modificado = '$fecha',
        usuario_ultmodif = $usuario,
        fk_estado_id = ".INCIDENTE_RESUELTO."
        WHERE id='$id';";

        $affected = DB::update($sql, [$this->id]);   
    }

}
