<?php

namespace App\Entidades\formularios;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class CalculoUtilidades extends Model{
 protected $table = 'valores';
    public $timestamps = false;
    
    private $aIdCampos = array(
        "nombre" => 23,
        "no_cedula" => 24,
        "cargo_empresa" => 25,
        "fecha_ingreso" => 26,
        "dias_bonificar" => 27,
        "nombre_solicitante" => 28,
        "calculo_ultimosalario" => 29,
        "calculo_salariopromedio" => 30,
        );
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