<?php 
	session_start();
	require_once '../../clases/Conexion.php';
	require_once '../../clases/ControladorAplicaciones.php';
	require_once '../../clases/ControladorCatalogos.php';
	require_once '../../clases/ControladorVehiculos.php';
	
	$conexion = new Conexion();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

<header>
	<h1>Matriculación de Vehículos</h1>
</header>

<div id="paginacion" class="normal"></div>
	<table id="tablaItems">
    	<thead>
    		<tr>
    			<th>#</th>
    			<th>Modelo</th>
    			<th>Placa</th>
    			<th>Oficina</th>
    			<th>Fin Vigencia Matrícula</th>
    			<th>Fin Vigencia Cert. Matrícula</th>
    			<th>Estado Matrícula</th>
    		</tr>
    	</thead>	
	


	<?php 
	//print_r($_SESSION);
		$cv = new ControladorVehiculos();
		$res = $cv->datosVehiculosMatriculacion($conexion, $_SESSION['nombreLocalizacion']);
        $contador = 0;
		
        while($vehiculo = pg_fetch_assoc($res)){
            echo '<tr
						id="'.$vehiculo['placa'].'"
						class="item"
						data-rutaAplicacion="transportes"
						data-opcion="abrirMatriculacion"
						ondragstart="drag(event)"
						draggable="true"
						data-destino="detalleItem">
					<td>'.++$contador.'</td>
					<td style="white-space:nowrap;"><b>'.$vehiculo['modelo'].'</b></td>
					<td>'.$vehiculo['placa'].'</td>
					<td>'.$vehiculo['localizacion'].'</td>
					<td>'.$vehiculo['vigencia_matricula'].'</td>
					<td>'.$vehiculo['vigencia_certificado_matricula'].'</td>
					<td>'.$vehiculo['estado_matricula'].'</td>
				</tr>';
        }
        
        echo '</table>';
	?>


	
</body>
<script>
	$(document).ready(function(){
		$("#listadoItems").removeClass("comunes");
		$("#listadoItems").addClass("lista");
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un vehículo para revisarlo.</div>');
	});
</script>
</html>