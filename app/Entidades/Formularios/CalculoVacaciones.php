<?php

namespace App\Entidades\Formularios;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class CalculoVacaciones extends Model{
      

    protected $table = 'valores';
    public $timestamps = false;
    
    private $aIdCampos = array(
        "nombreyapellidodeltrabajor" => 34,
        "numerodeceduladeidentidad" => 35,
        "cargoqueocupaenlaempresa" => 36,
        "fechadeingreso" => 37,
        "fechadesalidadevacaciones" => 38,
        "ultimosalariodevengado" => 39,
        "nombredelsolicitante" => 40,
        );

    protected $fillable = [
        'nombreyapellidodeltrabajor',
        'numerodeceduladeidentidad',
        'cargoqueocupaenlaempresa',
        'fechadeingreso',
        'fechadesalidadevacaciones',
        'ultimosalariodevengado',
        'nombredelsolicitante'];

    protected $hidden = [
        'idtramite'
    ];

     function cargarDesdeRequest($request) {
        $this->idtramite = $request->input('id')!= "0" ? $request->input('id') : $this->idtramite;
        $this->nombreyapellidodeltrabajor =$request->input('txtNombreTrabajador');
        $this->numerodeceduladeidentidad = $request->input('txtCedula');
        $this->cargoqueocupaenlaempresa = $request->input('txtCargo');
        $this->fechadeingreso =  $request->input('txtFechaIngreso');
        $this->fechadesalidadevacaciones = $request->input('txtFechaSalida');
        $this->ultimosalariodevengado = $request->input('txtUltimoSalario');
        $this->nombredelsolicitante = $request->input('txtNombreSolicitante');
        
    }

    public function obtenerPorId($id){
          $sql = "SELECT
                idvalor,
                fk_idtramite,
                fk_idcampo,
                valor
                FROM valores WHERE fk_idtramite = $id";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->idtramite = $id;
            foreach($lstRetorno as $fila){
                foreach($this->aIdCampos as $campo => $fk_idcampo){
                    if($fila->fk_idcampo == $fk_idcampo){
                        $this->$campo = $fila->valor; 
                    }
                }
            }
            return $this;
        }
        return null;
    }

    public function insertar() {
        foreach($this->fillable as $campo){
            $sql = "INSERT INTO valores (
                fk_idtramite,
                fk_idcampo,
                valor
            ) VALUES (?, ?, ?);";
            $result = DB::insert($sql, [
                $this->idtramite,
                $this->aIdCampos[$campo],
                $this->$campo
            ]);
            $idvalor = DB::getPdo()->lastInsertId();
        }
    }

    public function guardar($idTramite) {
         foreach ($this as $campo => $valor) {
            $sql = "UPDATE valores SET
                valor='$valor'
            WHERE idvalores= ? AND campo = ?"; 
            $affected = DB::update($sql, [$idTramite, $campo]);
        }
    }

    public function eliminar() {
        $sql = "DELETE FROM valores WHERE 
            fk_idtramite=?";
        $affected = DB::delete($sql, [$this->fk_idtramite]);
    }
}

?>