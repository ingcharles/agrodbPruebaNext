<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorAreas.php';
require_once '../../clases/ControladorCatalogos.php';
require_once '../../clases/ControladorVehiculos.php';

$identificador=$_SESSION['usuario'];

if($identificador==''){
	$usuario=0;
}else{
	$usuario=1;
	$idAreaFuncionario = $_SESSION['idArea'];
	$nombreProvinciaFuncionario = $_SESSION['nombreProvincia'];
}//$usuario=0;

$conexion = new Conexion();
$ca = new ControladorAreas();
$cc = new ControladorCatalogos();
$cv = new ControladorVehiculos();
		
$_SESSION['id_area'] = $area['id_area'];
$areaRevisor = $area['id_area'];

$localizacionAdministrador = $_SESSION['nombreLocalizacion'];

$localizacion = $cc->listarLocalizacion($conexion, 'SITIOS');
$localizacionProvincia = $cc->listarLocalizacion($conexion, 'PROVINCIAS');
?>

<header>
	<h1>Reporte de Matriculaciones Generadas</h1>
	<nav>
		<form id="filtrar" data-rutaAplicacion="transportes" data-opcion="reportes" data-destino="detalleItem" action="aplicaciones/transportes/reporteMatriculacionDetalle.php" target="_blank" method="post"> 
		
			<input type='hidden' id='opcion' name='opcion' />
			
			<table class="filtro">
				<tr>
					<td>Provincia/Oficina:</td>
					<td style="width: 100%;">						
						<select id="localizacion" name="localizacion" required="required">
							<?php 
								if($_SESSION['nombreLocalizacion']=='Oficina Planta Central'){
								    echo '<option value="">Seleccione</option>';
								    while($fila = pg_fetch_assoc($localizacionProvincia)){
										echo '<option value="' . $fila['nombre'] . '">' . $fila['nombre'] . '</option>';
									}
									echo '<option value="Nacional">Nacional</option>';
								}else{
									while($fila = pg_fetch_assoc($localizacion)){
										if($fila['nombre'] == $_SESSION['nombreLocalizacion']){
											echo '<option value="' . $fila['nombre'] . '">' . $fila['nombre'] . '</option>';
										}
									}
								}
							?>
						</select>			
					</td>
				</tr>
				<!-- tr>
						<td>Fecha Inicio:</td>
							<td><input type="text" name="fechaInicio" id="fechaInicio" required="required" readonly="readonly"/></td>
						<td>Fecha Fin:</td>
							<td><input type="text" name="fechaFin" id="fechaFin" required="required" readonly="readonly"/></td>
				</tr-->
							
				<tr>
					<th></th>
					<td colspan="5"><button>Generar Reporte</button></td>
				</tr>
			</table>
		</form>

	</nav>
</header>

<div id="tabla"></div>

<script>
	
	$(document).ready(function(){
		$("#listadoItems").removeClass("comunes");
		$("#listadoItems").addClass("lista");
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione las opciones de búsqueda para generar el reporte.</div>');

		$("#fechaInicio").datepicker({
		    changeMonth: true,
		    changeYear: true,
		    onSelect: function(dateText, inst) {
	   		 $('#fechaFin').datepicker('option', 'minDate', $("#fechaInicio" ).val()); 
	       } 
		});

		$("#fechaFin").datepicker({
		    changeMonth: true,
		    changeYear: true
		});
	});

</script>
