<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/Constantes.php';
require_once '../../clases/ControladorVehiculos.php';

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
<link href="estilos/estiloapp.css" rel="stylesheet"></link>

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
	<div id="imprimir">
	<form id="filtrar" action="reporteMatriculacionDetalleExcel.php" target="_blank" method="post">
	 <input type="hidden" id="tipo" name="tipo" value="<?php echo $tipo;?>" />
	 <input type="hidden" id="localizacion" name="localizacion" value="<?php echo $localizacion;?>" />
	 <input type="hidden" id="fechaInicio" name="fechaInicio" value="<?php echo $fechaInicio;?>" />
	 <input type="hidden" id="fechaFin" name="fechaFin" value="<?php echo $fechaFin;?>" />
	 <button type="submit" class="guardar">Imprimir</button>	  	 
	</form>
	</div>
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