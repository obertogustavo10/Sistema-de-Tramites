<?php

namespace App\Entidades\Actividad;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class SedeActividad extends Model
{
    protected $table = 'actividades.sedeactividad';
    public $timestamps = false;

    protected $fillable = [
        'subdirector',
        'idsedeactividad',
        'fk_idsedepadre',
        'fk_idsede',
        'fk_iddepartamento',
        'fk_idactividad',
        'director'
    ];
    
    protected $hidden = [

    ];

    public function obtenerTodosPorActividad($idactividad){
          $sql = "SELECT 
                A.subdirector,
                A.idsedeactividad,
                A.fk_idsedepadre,
                A.fk_idsede,
                A.fk_iddepartamento,
                A.fk_idactividad,
                A.director,
                B.ncactividad as actividad,
                C.descsede as sede,
                C.descsede as subsede,
                E.nombre as director_nombre,
                E.apellido as director_apellido,
                F.nombre as subdirector_nombre,
                F.apellido as subdirector_apellido
                FROM actividades.sedeactividad A
                INNER JOIN actividades.actividades B ON B.idactividad = A.fk_idactividad
                LEFT JOIN public.sedes C ON C.idsede = A.fk_idsede
                LEFT JOIN public.sedes D ON D.idsede = A.fk_idsedepadre
                LEFT JOIN legajo.personalfmed E ON E.idpersonal = A.director
                LEFT JOIN legajo.personalfmed F ON F.idpersonal = A.subdirector
                WHERE A.fk_idactividad = $idactividad";
        $sql .= " ORDER BY A.idsedeactividad";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public  function eliminarPorActividad($idactividad) {
        $sql = "DELETE FROM actividades.sedeactividad WHERE 
            fk_idactividad=?";
        $affected = DB::delete($sql, [$idactividad]);
    }

    public function insertar() {
        DB::table($this->table, 'idsedeactividad')->insert([
            'subdirector' => $this->subdirector,
            'fk_idsedepadre' => $this->fk_idsedepadre,
            'fk_idsede' => $this->fk_idsede,
            'fk_iddepartamento' => $this->fk_iddepartamento,
            'fk_idactividad' => $this->fk_idactividad,
            'director' => $this->director
        ]);
       return $this->idsedeactividad = DB::getPdo()->lastInsertId();
    } 

}
