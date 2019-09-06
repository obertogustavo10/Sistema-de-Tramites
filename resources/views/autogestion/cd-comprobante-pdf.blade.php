<!DOCTYPE html>
<html>
<head>
    <title>Constancia de inscripción a Carrera Docente</title>
    <style type="text/css">
    body{
        font-size: 14px;
        font-family: "Arial";
    }
    h1 {
        font-size: 22px;
    }
    table{
        border-collapse: collapse;
    }
    td{
        padding: 6px 5px;
        font-size: 14px;
    }
    #logo {
        width: 222px;
        height: 41px;
    }
    #encabezado{
        margin-bottom: 10px;
        text-align: right;
    }
    #titulo {
        margin-bottom: 30px;
        text-align: center;
    }
    #datos-contacto {
        margin-bottom: 20px;
    }
    #texto-principal {
        text-align: justify;
        margin-bottom: 20px;
    }
    #tabla{
        margin-bottom: 40px;
    }
    #tabla td{
        border: 0.5px solid #000;
    }
    .linea{
        border-bottom: 1px dotted #000;
    }
    .fondo{
        background-color: #dfdfdf;
    }
</style>
</head>
<body>
    <div>
        <div id="logo">
            <img src="{{ asset('images/logo.png') }}">
        </div>
        <div id="encabezado">
                @php 
                    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                    $mesActual = $meses[date_format(date_create($fechaInscripcion), 'm')-1];
                @endphp
            <p style="text-align: right;">Ciudad Autónoma de Buenos Aires, {{ date_format(date_create($fechaInscripcion), 'd')}} de {{ $mesActual }} de {{ date_format(date_create($fechaInscripcion), 'Y') }} a las {{ date_format(date_create($fechaInscripcion), 'H:m') }} hs.</p>
        </div>
        <div id="titulo">
            <h1>Constancia de inscripción a Carrera Docente</h1>
            <h3>Nro. CONSTANCIA: {{ $idformu }}</h3>
        </div>
        <table width="100%" id="datos-contacto">
            <tr>
                <td width="15%"><strong>Alumno:</strong></td>
                <td width="50%" class="linea"><span class="text">{{ $nombreResponsable }}</span></td>
                <td width="15%"><strong>Documento:</strong></td>
                <td width="20%" class="linea"><span class="text">{{ $dni }}</span></td>
            </tr>
            <tr>
                <td><strong>Plan:</strong></td>
                <td class="linea"><span class="text">{{ $plan }}</span></td>
            </tr>
        </table>
        <div id="texto-principal">
            <p>Por la prensente se certifica que el alumno/a ha finalizado la inscripción habiendo seleccionado los siguientes horarios:</p>

            <p>ADVERTENCIA: Si ud. tiene PAGOS PENDIENTES deberá abonarlos, caso contrario ESTA INSCRIPCION NO SERA VÁLIDA. </p>

            <p>Se ha inscripto en los siguientes horarios:</p>
        </div>
        <table width="100%" id="tabla">
            <tr>
                <td align="center" class="fondo"><strong>Materia</strong></td>
                <td align="center" class="fondo"><strong>Horario seleccionado</strong></td>
            </tr>
            @if($aOferta)
                @foreach($aOferta as $oferta)
                <tr>
                    <td width="55%"><span class="text">{{$oferta->descmateria}} - (Prof. {{ucfirst(strtolower($oferta->apellido))}} {{ucfirst(strtolower ($oferta->nombre))}})</span></td>
                    <td width="45%"><span class="text">{{$oferta->descdia}} de {{$oferta->horainiciocursada}} hs. a {{$oferta->horafincursada}} hs. <br>Inicia: {{ date_format(date_create($oferta->fechainiciocursada), 'd/m')}} al {{ date_format(date_create($oferta->fechafincursada), 'd/m')}} <br>Observación: {{$oferta->comentario}}</span></td>
                </tr>
                @endforeach
            @else
                <tr><td colspan="2" style="text-align: center">No hay materias inscriptas</td></tr>
            @endif
        </table>
         <table width="100%" id="aranceles">
            <tr>
                <td align="center" class="fondo"><strong>Aranceles de las materias de Carrera Docente para el año 2019 según Res. (CD) 2831/18</strong></td>
            </tr>
            <tr><td><span class="text" style="font-size: 12px">MÓDULO PEDAGÓGICO: Didáctica (60 hs): $5.250,00 / Políticas (30 hs): $2.625,00 / Org. y Práctica (50 hs): $ 4.375,00</span></td></tr>
            <tr><td><span class="text" style="font-size: 12px">MÓDULO METODOLÓGICO: Metodología (30 hs): $2.625,00 / Epistemología (10 hs): $875,00 / Seminario (10 hs): $875,00</span></td></tr>
            <tr><td><span class="text" style="font-size: 12px">MÓDULO HUMANÍSTICO: Historia (50 hs): $ 4.375,00 / Antropología (16 hs): $ 1.400,00 / Org. y Admin. (16 h): $ 1.400,00</span></td></tr>
        </table>
    </div>
</body>
</html>
