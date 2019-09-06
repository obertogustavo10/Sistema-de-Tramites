<?php
namespace App\Entidades\Publico;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Cargo extends Model{

	protected $table = 'panel_cargo';
	public $timestamp = false;

	protected $fillable = [
		'nombre'
	];

	public function cargarDesdeRequest($request) {
		$this->id = $request->input('id')!="0" ? $request->input('id') : $this->id;
		$this->nombre = $request->input('txtDescripcion');
	}

	public function obtenerTodos() {
        $sql ="SELECT id, nombre FROM panel_cargo WHERE 1 = 1";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

	public function obtenerGrilla() {
		$requestData = $_REQUEST;
		$columns = array(
			0 => 'nombre');
		$sql = "SELECT
					id,
					nombre
				FROM panel_cargo WHERE 1=1"; 

		if (!empty($requestData['search']['value'])) {
           // if there is a search parameter, $requestData['search']['value'] contains search parameter            
           $sql.=" AND ( nombre LIKE '%" . $requestData['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
        
        $lstRetorno = DB::select($sql);
        return $lstRetorno;		
	}

	public function obtenerPorId($id) {
		$sql = "SELECT
				id,
				nombre
				FROM panel_cargo WHERE id = '$id'";
		$lstRetorno = DB::select($sql);

		if(count($lstRetorno)>0){
			$this->id = $lstRetorno[0]->id;
			$this->nombre = $lstRetorno[0]->nombre;
			return $lstRetorno[0];
		}
		return null;
	}

	public function guardar() {
        $sql = "UPDATE panel_cargo SET
            nombre='$this->nombre'
            WHERE id=?";
        $affected = DB::update($sql, [$this->id]);
    }

    public  function eliminar() {
        $sql = "DELETE FROM panel_cargo WHERE 
            id=?";
        $affected = DB::delete($sql, [$this->id]);
    }

    public function insertar() {
        $sql = "INSERT INTO panel_cargo (
        nombre
        ) VALUES (?);";
       $result = DB::insert($sql, [$this->nombre]);
       $this->id = DB::getPdo()->lastInsertId();
    } 
}
?>