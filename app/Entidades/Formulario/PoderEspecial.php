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
    public function insertar() {

            $sql = "INSERT INTO valores (
                fk_idcampo,
                valor,
                fk_idtramites
                    ) VALUES (?, ?, ?);";
            $result = DB::insert($sql, [
                $this->fk_idcampo,
                $this->valor,
                $this->fk_idtramite
                    ]);

            return $this->idvalor = DB::getPdo()->lastInsertId();
    }

    public function guardar() {
       $sql = "UPDATE valores SET
            fk_idcampo='$this->fk_idcampo',
            valor='$this->valor',
            fk_idtramites='$this->fk_idtramites'
            WHERE idvalores= ?"; 
        $affected = DB::update($sql, [$this->idvalor]);
    }

    public function eliminar() {
        $sql = "DELETE FROM valores WHERE 
            fk_idtramite=?";
        $affected = DB::delete($sql, [$this->fk_idtramite]);
    }
}

?>