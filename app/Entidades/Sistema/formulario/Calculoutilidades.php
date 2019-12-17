<?php

namespace App\Entidades\formulario;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Calculoulidades extends Model
{
    protected $table = 'valores';
    public $timestamps = false;


    protected $fillable = [
        'nombre', 'no_cedula', 'cargo_empresa', 'fecha_ingreso', 'dias_bonificar', 'nombre_solicitante',
         'calculo_ultimosalario', 'calculo_salariopromedio'
    ];
    protected $hidden = [

    ];
    function cargarDesdeRequest($request) {
        $this->nombre = $request->input('txtNombre');
        $this->no_cedula = $request->input('txtCedula');
        $this->cargo_empresa = $request->input('txtCargo');
        $this->fecha_ingreso = $request->input('txtFecha');
        $this->dias_bonificar = $request->input('txtBonificar');
        $this->nombre_solicitante = $request->input('txtNombreSolicitante');
        $this->calculo_ultimosalario = $request->input('lstUltimo_Salario');
        $this->calculo_salariopromedio = $request->input('lstSalario_Promedio');
    }
    public function insertar() {
        $sql = "INSERT INTO valores (
                fk_idcampo,
                valor,
                fk_idtramites,
                activo
            ) VALUES (?, ?, ?);";
       $result = DB::insert($sql, [
            $this->fk_idcampo, 
            $this->valor, 
            $this->fk_idtramites
        ]);
       return $this->idvalor = DB::getPdo()->lastInsertId();
    }
    public function guardar() {
        $sql = "UPDATE valores SET
            fk_idcampo='$this->fk_idcampo',
            valor='$this->valor',
            fk_idtramite=$this->fk_idtramite
            WHERE idvalor_=?";
        $affected = DB::update($sql, [$this->idvalor]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM valores WHERE 
            fk_idtramite=?";
        $affected = DB::delete($sql, [$this->fk_idtramite]);
    }
}