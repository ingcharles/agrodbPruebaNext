<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';

$conexion = new Conexion();
$cv = new ControladorVehiculos();

$itemsFiltrados[] = array();

$contador=0;
$placa = $_POST['placaFiltro'];
$provincia = $_POST['provinciaFiltro'];
$oficina = $_POST['oficinaFiltro'];

$res = $cv->datosVehiculosMatriculacionNacional($conexion, $placa, $provincia, $oficina);
		
		while($vehiculo = pg_fetch_assoc($res)){
			$itemsFiltrados[] = array('<tr
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
				</tr>');

}
	
?>	

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
	<tbody>
	</tbody>
</table>

<script type="text/javascript"> 
	$(document).ready(function(){
		construirPaginacion($("#paginacion"),<?php echo json_encode($itemsFiltrados);?>);
	});

	$('#_asignar').addClass('_asignar');
	
</script>