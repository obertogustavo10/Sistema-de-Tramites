<?php

namespace App\Entidades\Cliente;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Domicilio extends Model{
    protected $table = 'domicilios';
    public $timestamps = false;

    protected $fillable = [
         'iddomicilio',  'domicilio', 'fk_tipodomicilio', 'fk_idcliente'
    ];
    protected $hidden =[

    ];
    public function cargarDesdeRequest($request) {
       $this->iddomicilio = $request->input('iddomicilio')!= "0" ? $request->input('iddomicilio') : $this->iddomicilio; 
        $this->domicilio =$request->input('txtDomicilio');
        $this->fk_idtipodomicilio = $request->input('lstTipoDomicilio');
       
       

    }

    public function insertarDomicilio() {
        $sql = "INSERT INTO domicilios ( 
                domicilio,
           fk_idtipodomicilio,
           fk_idcliente


            ) VALUES ( ? , ?, ? );";

    
       $result = DB::insert($sql, [
             
 
            $this->domicilio,
             $this->fk_idtipodomicilio,
             $this->fk_idcliente
        ]);
       return $this->iddomicilio = DB::getPdo()->lastInsertId();
    }
    public function guardarDomicilio() {
        $sql = "UPDATE domicilios SET
            domicilio='$this->domicilio' ,
            fk_idtipodomicilio='$this->fk_idtipodomicilio' 
            WHERE iddomicilio=?";
        $affected = DB::update($sql, [$this->iddomicilio]);
    }
    public  function eliminarDomicilio() {
        $sql = "DELETE FROM domicilios WHERE 
            iddomicilio=?";
        $affected = DB::delete($sql, [$this->iddomicilio]);
    }
        public function obtenerFiltradoDomicilio() {
            $request = $_REQUEST;
            $columns = array(
               0 => 'A.domicilio',
                );
            $sql = "SELECT
                        A.iddomicilio,
                        A.domicilio,
                        B.nombre 
                        FROM domicilios A
                         INNER JOIN tipo_domicilios B ON A.fk_idtipodomicilio = D.nombre 
                    WHERE 1=1
                    ";
    
            //Realiza el filtrado
            if (!empty($request['search']['value'])) { 
                $sql.=" AND ( A.domicilio LIKE '%" . $request['search']['value'] . "%' ";
            }
            $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];
    
            $lstRetorno = DB::select($sql);
    
            return $lstRetorno;
        }
        
    }