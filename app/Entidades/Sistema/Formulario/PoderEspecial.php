<?php

namespace App\Entidades\Formulario\PoderesEspeciales;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class PoderEspecial extends Model{
      

    protected $table = 'valores';
    public $timestamps = false;


    protected $fillable = [
        'idpoder','tipopoder', 'nombrepoderdante','fechapoderdante', 'cuilpoderdante','domiciliopoderdante','estadocivilpoderdante','conyugepoderdante','madrepoderdante','padrepoderdante','nombreapoderado','fechaapoderado', 'cuilapoderado','domicilioapoderado','estadocivilapoderado','conyugeapoderado','madreapoderado','padreapoderado'];


     function cargarDesdeRequest($request) {
        $this->idpoder = $request->input('id')!= "0" ? $request->input('id') : $this->idpoder;
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
    public function insertar($idTramite) {

         foreach ($this as $campo => $valor) {
            $sql = "INSERT INTO valores (
                campo,
                valor,
                fk_idtramite
            ) VALUES (?, ?, ?);";
            $result = DB::insert($sql, [
                $campo,
                $valor,
                $idTramite
            ]);
            //$idvalor = DB::getPdo()->lastInsertId();
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