<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';

$conexion = new Conexion();
$cv = new ControladorEvaluaciones();

$itemsFiltrados[] = array();

$contador=0;
$identificador = $_POST['usuarioFiltro'];

$res = $cv->datosUsuarioExterno($conexion, $identificador);
		
		while($admin = pg_fetch_assoc($res)){
			$itemsFiltrados[] = array('<tr
						id="'.$admin['identificador']."-".$admin['id_evaluacion'].'"
						class="item">
					<td>'.++$contador.'</td>
					<td style="white-space:nowrap;"><b>'.$admin['identificador'].'</b></td>
					<td>'.$admin['nombre'].' '.$admin['apellido'].'</td>
					<td>'.$admin['nombre_evaluacion'].'</td>
                    <td>'.$admin['fecha_inicio'].'</td>
                    <td>'.$admin['fecha_fin'].'</td>
                    <td>'.$admin['estado_evaluacion'].'</td>
				</tr>');

}
	
?>	

<div id="paginacion" class="normal"></div>

<table id="tablaItems">
	<thead>
		<tr>
			<th>#</th>
    			<th>Identificador</th>
    			<th>Nombre</th>
    			<th>Evaluación</th>
    			<th>Fecha Inicio</th>
    			<th>Fecha Fin</th>
    			<th>Estado eva</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<script type="text/javascript"> 
	$(document).ready(function(){
		$("#listadoItems").removeClass("comunes");
		$("#listadoItems").addClass("lista");
		construirPaginacion($("#paginacion"),<?php echo json_encode($itemsFiltrados);?>);
	});

	$('#_asignar').addClass('_asignar');
	
</script>