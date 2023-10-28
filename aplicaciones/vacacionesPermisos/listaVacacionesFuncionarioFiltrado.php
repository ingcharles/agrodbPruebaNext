<?php 
	session_start();
	require_once '../../clases/Conexion.php';
	require_once '../../clases/ControladorVacaciones.php';

	
	$conexion = new Conexion();
	$cv = new ControladorVacaciones();
	
	$identificador = $_POST['identificador'];
	$estadoSaldo = $_POST['estadoSaldo'];
	$apellido = $_POST['apellidoUsuario'];
	$nombre = $_POST['nombreUsuario'];
	$area = $_POST['area'];
	
	$listaReporte = $cv->listadoSaldoUsuarioAnual($conexion, $identificador, $estadoSaldo, $apellido, $nombre);
	
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Identificador</th>
			<th>Nombre funcionario</th>
			<th>Año</th>
			<th>Cantidad disponible</th>
		</tr>
	</thead>
	
<?php 
		$contador = 0;
		while($fila = pg_fetch_assoc($listaReporte)){
			
			$dias=floor(intval($fila['minutos_disponibles'])/480);
			$horas=floor((intval($fila['minutos_disponibles'])-$dias*480)/60);
			$minutos=(intval($fila['minutos_disponibles'])-$dias*480)-$horas*60;
			$identifi=$fila['identificador'].'.'.$estadoSaldo.'.'.$fila['anio'];
			echo '<tr 
						id="'.$identifi.'"
						class="item"
						data-rutaAplicacion="vacacionesPermisos"
						data-opcion="editarVacacionesFuncionario" 
						ondragstart="drag(event)" 
						draggable="true" 
						data-destino="detalleItem">
					<td>'.++$contador.'</td>
					<td style="white-space:nowrap;"><b>'.$fila['identificador'].'</b></td>
					<td>'.$fila['apellido'].' '.$fila['nombre'].'</td>
                    <td>'.$fila['anio'].'</td>
					<td>'. $dias.' días '. $horas .' horas '. $minutos .' minutos</td>
				</tr>';
			}
?>			
</table>

</body>

<script type="text/javascript"> 

	$(document).ready(function(){
		$("#listadoItems").removeClass("comunes");
		$("#listadoItems").addClass("lista");
	});

	
</script>
</html>
