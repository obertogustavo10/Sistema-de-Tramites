<?php

namespace App\Entidades\Formularios;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

Class Calculo_vacaciones extends Model
{
    protected $table = 'valores';
    public $timestamps = false;

    protected $fillable = 
    [
        'idvalor', 'nombre', 'cedula', 'cargo', 'fecha_ingreso', 'fecha_salida', 'ultimo_salario', 'nombre_solicitante'
    ];

    protected $hidden = 
    [

    ];

    public function cargarDesdeRequest($request)
    {
        $this->idvalor = $request->input('id') !="0" ? $request->input('id') : $this->idvalor;
        $this->nombre = $request->input('txtNombre');
        $this->cedula = $request->input('txtCedula');
        $this->cargo = $request->input('txtCargo');
        $this->fecha_ingreso = $request->input('txtFechaIngreso');
        $this->fecha_salida = $request->input('txtFechaSalida');
        $this->ultimo_salario = $request->input('txtUltSalario');
        $this->nombre_solicitante = $request->input('txtNombre');
    }
    public function insertar() 
    {
        $sql = "INSERT INTO valores (
            idvalor,
            fk_idcampo,
            valor,
            fk_idtramite
            ) VALUES (?, ?, ?, ?);";
            $result = DB::insert($sql, [
                $this->idvalor,
                $this->fk_idcampo,
                $this->valor,
                $this->fk_idtramite
            ]);
            return $this->idvalor = DB::getPdo()->lastInsertId();
    }
    public function guardar() 
    {
        $sql = "UPDATE valores SET
            idvalor='$this->idvalor',
            fk_idcampo='$this->fk_idcampo',
            valor='$this->valor',
            fk_idtramite='$this->fk_idtramite'
            WHERE idvalor=?";
        $affected = DB::update($sql, [$this->idvalor]);
    }

    public  function eliminar() 
    {
        $sql = "DELETE FROM valores WHERE 
            fk_idtramite=?";
        $affected = DB::delete($sql, [$this->fk_idtramite]);
    }
}