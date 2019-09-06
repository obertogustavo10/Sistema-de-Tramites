<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Legajo\Alumno;
use App\Entidades\Cursada\FormuCabecera;
use App\Entidades\Cursada\FormuDetalle;
use App\Entidades\Actividad\PlanDeEstudio;
use Session;

class ControladorInscripcionCDPDF extends Controller
{
    public function generarComprobante($idformu)
    {
        //Obtiene la cabecera del comprobante
        $entidadCabecera = new FormuCabecera();
        $formuCabecera = $entidadCabecera->obtenerPorId($idformu);

        $alumno = new Alumno();
        $alumno->obtenerPorId($formuCabecera->idalumno);


        //Obtiene el ultimo comprobante emitido
        $ultimoComprobante = $entidadCabecera->obtenerUltimoComprobantePorPlanPorAlumno($formuCabecera->documento, $formuCabecera->fk_idplan);

        //Se fija que la constancia sea del alumno logueado y que sea el ultimo comprobante emitido
        if($formuCabecera && $ultimoComprobante->idformu == $idformu){


            $formuDetalle = new FormuDetalle();
            $aOferta = $formuDetalle->obtenerPorFormulario($idformu);

            $plan = new PlanDeEstudio();
            $plan->obtenerPorId($formuCabecera->fk_idplan);

            //Materias del comprobante
            $data['plan'] = $plan->descplan;
            $data['fechaInscripcion'] = $formuCabecera->control;
            $data['nombreResponsable']  = strtoupper($alumno->apellido . " " . $alumno->nombre);
            $data['dni'] = $alumno->documento;
            $data['idformu'] = $idformu;
            $data['aOferta'] = $aOferta;

            $html = view('autogestion.cd-comprobante-pdf',$data)->render();
            $namefile = 'Acta de traslado'.time().'.pdf';
     
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
     
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
            $mpdf = new Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    public_path() . '/fonts',
                ]),
                'fontdata' => $fontData + [
                    'arial' => [
                        'R' => 'arial.ttf',
                        'B' => 'arialbd.ttf',
                    ],
                ],
                'default_font' => 'arial',
              	"format" => "A4"
            ]);
            // $mpdf->SetTopMargin(5);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);

            $mpdf->Output($namefile,"I"); //ver
            //$mpdf->Output($namefile,"D"); //descargar
        }
    }
}