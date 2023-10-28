<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';

$conexion = new Conexion();
$cv = new ControladorVehiculos();

$itemsFiltrados[] = array();

$contador=0;
$provincia = $_POST['provinciaFiltro'];
$oficina = $_POST['oficinaFiltro'];

$res = $cv->datosAdministradoresNacional($conexion, $provincia, $oficina);
		
		while($admin = pg_fetch_assoc($res)){
			$itemsFiltrados[] = array('<tr
						id="'.$admin['identificador'].'"
						class="item"
						>
					<td>'.++$contador.'</td>
					<td style="white-space:nowrap;"><b>'.$admin['identificador'].'</b></td>
					<td>'.$admin['nombre'].' '.$admin['apellido'].'</td>
					<td>'.$admin['provincia'].'</td>
					<td>'.$admin['oficina'].'</td>
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
    			<th>Provincia</th>
    			<th>Oficina</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<script type="text/javascript"> 
	$(document).ready(function(){
		construirPaginacion($("#paginacion"),<?php echo json_encode($itemsFiltrados);?>);
	});

	$('#_asignar').addClass('_asignar');
	
</script>