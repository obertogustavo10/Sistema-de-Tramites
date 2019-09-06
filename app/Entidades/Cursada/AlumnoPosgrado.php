<?php

namespace App\Entidades\Cursada;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class AlumnoPosgrado extends Model
{
    protected $table = 'cursada.alumnosposgrado';
    public $timestamps = false;

    protected $fillable = [
        'fk_idplan','fk_idestadoalu','fk_idcategoria','fk_idalumno','fechainscripcion'
    ];

    protected $hidden = [

    ];

    public function insertar() {
        DB::table($this->table)->insert([
            'fk_idplan' => $this->fk_idplan,
            'fk_idestadoalu' => $this->fk_idestadoalu,
            'fk_idcategoria' => $this->fk_idcategoria,
            'fk_idalumno' => $this->fk_idalumno,
            'fechainscripcion' => $this->fechainscripcion
        ]);
    }

}


