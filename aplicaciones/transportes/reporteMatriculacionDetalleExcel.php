<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/Constantes.php';
require_once '../../clases/ControladorVehiculos.php';

header("Content-type: application/octet-stream");
//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=reporteMantenimientosGenerados.xls");
//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

$conexion = new Conexion();
$cv = new ControladorVehiculos();
$constg = new Constantes();

$localizacion = htmlspecialchars ($_POST['localizacion'],ENT_NOQUOTES,'UTF-8');
$fechaInicio = htmlspecialchars ($_POST['fechaInicio'],ENT_NOQUOTES,'UTF-8');
$fechaFin = htmlspecialchars ($_POST['fechaFin'],ENT_NOQUOTES,'UTF-8');

if($_SESSION['nombreLocalizacion']=='Oficina Planta Central'){
    $tipo = 'Administrador';
}else{
    $tipo = 'Usuario';
}

$completo = $cv->obtenerReporteMatriculacionesGeneradas($conexion, $tipo, $localizacion, $fechaInicio, $fechaFin);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<style type="text/css">


#tablaReportePresupuesto 
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	width: 100%;
	margin: 0;
	padding: 0;
    border-collapse:collapse;
}

#tablaReportePresupuesto td, #tablaReportePresupuesto th 
{
font-size:1em;
border:0.5px solid #000000;
padding:1px 3px 1px 3px;
}

#tablaReportePresupuesto th 
{
font-size:1em;
text-align:left;
padding-top:3px;
padding-bottom:2px;
background-color:#A7C942;
color:#ffffff;
}


//Cabecera
#tablaReportePac 
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	width: 100%;
	margin: 0;
	padding: 0;
    border-collapse:collapse;
}

#tablaReportePac td, #tablaReportePac th 
{
font-size:1em;
padding:1px 3px 1px 3px;
}

#textoTitulo{
font-size:12em;
text-align: center;
float:left;
}

#textoSubtitulo{
text-align: center;
float:left;
}

.formatoTexto{
 mso-style-parent:style0;
 mso-number-format:"\@";
}

.formatoNumeroDecimal4{
 mso-style-parent:style0;
 mso-number-format:"\#\\#\#0\.0000";
}

#logotexto{
width: 10%;
height:80px;
float: left;
}

#textoPOA{
width: 40%;
height:80px;
text-align: center;
float:left;
}


</style>
</head>
	<body>

		<div id="header">
		   	<div id="logoMagap"></div>
			<div id="texto"></div>
			<div id="logoAgrocalidad"></div>
			<div id="textoPOA"><?php echo $constg::NOMBRE_INSTITUCION;?><Br> 
									Reporte de Matriculación Vehicular <Br>
							<?php echo $localizacion;?><br>
			</div>
			<div id="direccion"></div>
			<div id="bandera"></div>
		</div>
		<div id="tabla">
		<table id="tablaReportePresupuesto" class="soloImpresion">
			<thead>
				<tr>
				    <th>ID</th>
        		    <th>PLACA</th>
        		    <th>LOCALIZACIÓN</th>
        			<th>ADMINISTRADOR</th>
        			<th>ESTADO VEHÍCULO</th>
        			<th>TIPO MATRÍCULA</th>
        			<th>FECHA INICIO VIGENCIA</th>
        			<th>FECHA FIN VIGENCIA</th>
        			<th>ESTADO MATRÍCULA</th>
        			<th>FECHA LIBERACIÓN</th>
        			<th>MOTIVO LIBERACIÓN</th>
				</tr>
			</thead>
			<tbody>
			
			 <?php
			 
			 //Matriz completa
			 while($fila = pg_fetch_assoc($completo)){
			 	
			 	echo '	<tr>
						    <td class="formatoTexto">'.$fila['id_matriculacion'].'</td>
        			        <td class="formatoTexto">'.$fila['placa'].'</td>
        			        <td class="formatoTexto">'.$fila['localizacion'].'</td>
        			        <td class="formatoTexto">'.$fila['administrador_vehiculo'].'</td>
        			    	<td class="formatoTexto">'.$fila['estado'].'</td>
        			    	<td class="formatoTexto">'.$fila['tipo_documento'].'</td>
        			        <td class="formatoTexto">'.$fila['fecha_inicio'].'</td>
        			        <td class="formatoTexto">'.$fila['fecha_fin'].'</td>
        			        <td class="formatoTexto">'.$fila['estado_documento'].'</td>
        					<td class="formatoTexto">'.$fila['fecha_liberacion'].'</td>
        					<td class="formatoTexto">'.$fila['motivo_liberacion'].'</td>
						</tr>';
			 }
			 
			 ?>
			
			</tbody>
		</table>
		
		</div>
	</body>
</html>