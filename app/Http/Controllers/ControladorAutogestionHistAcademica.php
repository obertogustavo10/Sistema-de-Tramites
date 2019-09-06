<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Cursada\AlumnoInscripcion;
use App\Entidades\Cursada\AlumnoMateria;
use App\Entidades\Actividad\Materia;
use App\Entidades\Actividad\PlanEquivalencia;
use App\Entidades\Actividad\PlanMateria;
use App\Entidades\Cursada\OfertaCursada;

require app_path().'/start/constants.php';
use Session;

class ControladorAutogestionHistAcademica extends Controller
{
    public function index(Request $request){
        $titulo = "Historia académica";
        $array_materias_aprobadas = $array_materias_restanaprobar = $array_materias_ausentesdesaprobadas = array();
        $porcentaje_aprobacion = 0;

        if(Usuario::autogestionAutenticado() == true){
            $dni = Session::get("usuarioalu");
            $idPlan = $request->input('lstPlan');

            $entidad = new AlumnoInscripcion();
            $array_carrera =  $entidad->obtenerCarrerasPorDni(Session::get('usuarioalu'));


            if(count($array_carrera)>0 && $idPlan == "")
                $idPlan = $array_carrera[0]->fk_idplan;

            if(count($array_carrera)>0){

                //************************************************
                //Materias aprobadas
                //************************************************
                $entidad = new AlumnoMateria();
                $aMateriasAprobadas = $entidad->obtenerMateriasAprobadasDelAlumno(Session::get('alumno_id'));

                if(count($aMateriasAprobadas)>0)
                    foreach($aMateriasAprobadas as $materia){
                        if($materia->fk_idplan == $idPlan)
                            $array_materias_aprobadas[] = $entidad->obtenerMateriaPorPlan($materia->fk_idplan, $materia->idmateria, Session::get('alumno_id'));
                        else {
                            //Busca el nombre de la materia por equivalencia
                            $planEquivalencia = new PlanEquivalencia();
                            $aEquivalencia = $planEquivalencia->obtenerSupraEquivalenciaPorPlanPorMateria($materia->fk_idplan, $idPlan, $materia->idmateria);

                            if(count($aEquivalencia)>0){

                                foreach($aEquivalencia as $equivalencia){
                                    $entidadMateria = new Materia();
                                    $entidadMateria->obtenerPorId($equivalencia->fk_idmateria);

                                    $materiaAux = new AlumnoMateria();
                                    $materiaAux->idmateria = $entidadMateria->idmateria;
                                    $materiaAux->descmateria = $entidadMateria->descmateria . " (Por Equiv. ". $materia->descmateria . " )";
                                    $materiaAux->nota_alumno = $materia->nota_alumno;
                                    $materiaAux->nota_descalumno = $materia->nota_descalumno;
                                    $materiaAux->nota_minima = $materia->nota_minima;
                                    $materiaAux->fechaacta = $materia->fechaacta;
                                    $materiaAux->libro = $materia->libro;
                                    $materiaAux->folio = $materia->folio;
                                    $materiaAux->resolucionexime = $materia->resolucionexime;
                                    $materiaAux->expedienteexime = $materia->expedienteexime;
                                    $materiaAux->fecharesolexime = $materia->fecharesolexime;
                                    $materiaAux->cargahorariaenhs = $materia->cargahorariaenhs;
                                    $materiaAux->fk_idplan = $idPlan;
                                    $materiaAux->resolucion = $materia->resolucion;
                                    $array_materias_aprobadas[] = $materiaAux;
                                    unset($materiaAux);
                                }
                            }
                        }
                    }

                //************************************************
                //Materias en curso
                //************************************************
                $array_materia_encurso = $entidad->obtenerMateriasEnCurso(Session::get('alumno_id'), $idPlan);


                //************************************************
                //Materias que restan cursar
                //************************************************
                $entidadMateria = new PlanMateria();
                $aMateria =  $entidadMateria->obtenerTodosPorPlan($idPlan);

                //Quita las materias aprobadas
                if(count($aMateria)>0)
                    foreach($aMateria as $materia){
                        $aprobada = false;
                        if(count($array_materias_aprobadas)>0)
                            foreach($array_materias_aprobadas as $materiaAprobada){
                                if($materiaAprobada->idmateria == $materia->fk_idmateria)
                                    $aprobada = true;
                            }
                        if(!$aprobada){
                            $array_materias_restanaprobar[] = $materia;
                        }
                    }

                //************************************************
                //Materias ausentes o desaprobadas
                //************************************************
                $array_materias_ausentesdesaprobadas = $entidad->obtenerMateriasAusentesDesaprobadasDelAlumno(Session::get('alumno_id'), $idPlan);

                //************************************************
                //Porcentaje de aprobacion
                //************************************************
                $aMateriaUnica = array();
                if(count($array_materias_aprobadas)>0)
                    foreach($array_materias_aprobadas as $materia){
                        $aMateriaUnica[$materia->idmateria]=true;
                    }

                if(count($aMateria)>0)
                    $porcentaje_aprobacion = round(count($aMateriaUnica)*100/count($aMateria), 2);

                $entidad = $entidad->obtenerUltimaMateriaPorAlumnoPorPlan(Session::get('alumno_id'), $idPlan);
                if($entidad)
                    $fecha_materia = $entidad->fechaacta;
            }
            return view('autogestion.historiaacademica', compact('titulo', 'array_carrera', 'array_materia_encurso', 'array_materias_aprobadas', 'array_materias_restanaprobar', 'array_materias_ausentesdesaprobadas', 'fecha_materia', 'promedio', 'idPlan', 'porcentaje_aprobacion'));
        } else {
           return redirect(env('APP_URL_AUTOGESTION') . '');
        }
    }

}
