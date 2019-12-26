<?php

namespace App\Entidades\Formularios;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class PoderEspecial extends Model{
      

    protected $table = 'valores';
    public $timestamps = false;
    
    private $aIdCampos = array(
        "tipopoder" => 33,
        "nombrepoderdante" => 2,
        "fechapoderdante" => 3,
        "cuilpoderdante" => 5,
        "domiciliopoderdante" => 8,
        "estadocivilpoderdante" => 10,
        "conyugepoderdante" => 12,
        "madrepoderdante" => 14,
        "padrepoderdante" => 16,
        "nombreapoderado" => 1,
        "fechaapoderado" => 4,
        "cuilapoderado" => 6,
        "domicilioapoderado" => 9,
        "estadocivilapoderado" => 11,
        "conyugeapoderado" => 13,
        "madreapoderado" => 15,
        "padreapoderado" => 17,
    );

    protected $fillable = [
        'tipopoder', 'nombrepoderdante','fechapoderdante', 'cuilpoderdante','domiciliopoderdante','estadocivilpoderdante','conyugepoderdante','madrepoderdante','padrepoderdante','nombreapoderado','fechaapoderado', 'cuilapoderado','domicilioapoderado','estadocivilapoderado','conyugeapoderado','madreapoderado','padreapoderado'];

    protected $hidden = [
        'idtramite'
    ];

     function cargarDesdeRequest($request) {
        $this->idtramite = $request->input('id')!= "0" ? $request->input('id') : $this->idtramite;
        $this->tipopoder =$request->input('tipoDePoder');
        $this->nombrepoderdante = $request->input('nombrePoderdante');
        $this->fechapoderdante = $request->input('fechaPoderdante');
        $this->cuilpoderdante =  $request->input('cuilPoderdante');
        $this->cantidad_bloqueo = $request->input('txtBloqueo');
        $this->domiciliopoderdante = $request->input('domicilioPoderdante');
        $this->estadocivilpoderdante = $request->input('estadoCivilPoderdante');
        $this->conyugepoderdante = $request->input('nombreConyugePoderdante');
        $this->madrepoderdante = $request->input('nombreMadrePoderdante');
        $this->padrepoderdante = $request->input('nombrePadrePoderdante');
        $this->nombreapoderado = $request->input('nombreApoderado');
        $this->fechaapoderado = $request->input('fechaApoderado');
        $this->cuilapoderado = $request->input('cuilApoderadoo');
        $this->domicilioapoderado = $request->input('domicilioApoderado');
        $this->estadocivilapoderado= $request->input('estadoCivilApoderado');
        $this->conyugeapoderado= $request->input('nombreConyugeApoderado');
        $this->madreapoderado= $request->input('nombreMadreApoderado');
        $this->padreapoderado= $request->input('nombrePadreApoderado');
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