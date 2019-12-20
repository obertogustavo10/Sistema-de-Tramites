<?php 

namespace App\Entidades\Formularios;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;


class AutorizacionViaje extends Model{
	protected $table = 'valores';
	public $timestamps = false;

	protected $fillable = [
		'idvalor','campo','valor','fk_idtramite','nombremadre','nombrepadre','nombremenor','pais','tiempo'
	];

    protected $hidden = [

    ];
	
	public function cargarDesdeRequest($request) {
        $this->idvalor = $request->input('idvalor') !="0" ? $request->input('idvalor') : $this->idvalor;
        $this->nombremadre = $request->input('txtNombreMadre');
        $this->nombrepadre = $request->input('txtNombrePadre');
        $this->nombremenor = $request->input('txtNombreMenor');
        $this->pais = $request->input('lstPais');
        $this->tiempo = $request->input('txtTiempo');
    }
    public function insertar() {
        $sql = "INSERT INTO valores(
                fk_idcampo,
                fk_idtramite,
                idvalor,
                nombremadre,
                nombrepadre,
                nombremenor,
                pais,
                tiempo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
       $result = DB::insert($sql, [
            
            $this->fk_idcampo,
            $this->fk_idtramite,
            $this->idvalor,
            $this->nombremadre,  
            $this->nombrepadre, 
            $this->nombremenor,
            $this->pais,
            $this->tiempo
        ]);
       return $this->idvalor = DB::getPdo()->lastInsertId();
    }
    public function guardar() {
        $sql = "UPDATE valores SET
            fk_idcampo ='$this->fk_idcampo',
            fk_idtramite =$this->fk_idtramite,
            idvalor ='$this->idvalor',
            nombremadre ='$this->nombremadre',
            nombrepadre ='$this->nombrepadre',
            nombremenor ='$this->nombremenor',
            pais ='$this->pais',
            tiempo ='$this->tiempo'
            WHERE idvalor=?";
        $affected = DB::update($sql, [$this->idvalor]);
    }
       public  function eliminar() {
        $sql = "DELETE FROM valores WHERE 
            fk_idtramite = ?";
        $affected = DB::delete($sql, [$this->fk_idtramite]);
    }

}

?>