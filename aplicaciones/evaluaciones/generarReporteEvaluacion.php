<?php
session_start();

require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';

header("Content-type: application/octet-stream");
//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=REPORTE_EVALUACION.xls");
//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

$conexion = new Conexion();
$cr = new ControladorEvaluaciones();

$idEvaluacion = $_POST['idEvaluacion'];
$fechaInicio = $_POST['fechaInicio'];
$identificador = $_POST['identificadorFiltro'];

$res = $cr->generarReporteEvaluacionesSimple($conexion, $idEvaluacion, $fechaInicio, $identificador);
?>


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    
    <style type="text/css">
        h1, h2 {
            margin: 0;
            padding: 0;
        }

        #tablaReporte {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            display: inline-block;
            width: auto;
            margin: 1em 0;
            padding: 0;
            border-collapse: collapse;
        }

        #tablaReporte td, #tablaReporte th {
            font-size: 1.2em;
            border: 1px solid #98bf21;
            padding: 3px 7px 2px 7px;
        }

        #tablaReporte th {
            text-align: left;
            padding-top: 5px;
            padding-bottom: 4px;
            background-color: #A7C942;
            color: #ffffff;
        }

        @page {
            margin: 5px;
        }

        .formato {
            mso-style-parent: style0;
            mso-number-format: "\@";
        }

        .formatoNumero {
            mso-style-parent: style0;
            mso-number-format: "0.000000";
        }

        .colorCelda {
            background-color: #FFE699;
        }

    </style>
</head>
<body>

<h1>Reporte de Evaluación: <?php echo pg_fetch_result($res, 0, 'nombre');?></h1>

<div id="tabla">
    <table id="tablaReporte" class="soloImpresion">
        <thead>
        	
            <tr>
            <th>Identificador</th>
            <th>Nombres</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Oportunidad</th>
            <th>Calificación</th>
            <tr>
        </thead>
        <tbody>
        <?php

        While ($fila = pg_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>" . $fila['identificador'] . "</td>";
            echo "<td>" . $fila['nombres'] . "</td>";
            echo "<td>" . $fila['fecha_inicio'] . "</td>";
            echo "<td>" . $fila['fecha_fin'] . "</td>";
            echo "<td>" . $fila['numero_oportunidad'] . "</td>";
            echo "<td>" . $fila['calificacion'] . "</td>";
            echo "</tr>";
        }
        ?>

        </tbody>
    </table>

</div>
</body>
</html>