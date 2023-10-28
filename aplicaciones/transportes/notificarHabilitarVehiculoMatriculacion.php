<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';

$conexion = new Conexion();
$cv = new controladorVehiculos();

$identificadorUsuarioRegistro = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

</head>
<body>

<header>
	<h1>Confirmar habilitación de vehículo</h1>
</header>

<div id="estado"></div>

	<p>El siguiente<b> vehículo</b> va a ser habilitado: </p>
	
	<?php		
		$vehiculo = explode(",",$_POST['elementos']);
		$res = $cv->abrirVehiculo($conexion, $vehiculo[0]);
		$vehiculoUsado = pg_fetch_assoc($res);
		
		//Matrícula
		$res = $cv->obtenerMatriculacionXVehiculoXTipo($conexion, $vehiculo[0], 'Matrícula del Vehículo');
		$matricula = pg_fetch_assoc($res);
		
		//Certificado Matrícula
		$res = $cv->obtenerMatriculacionXVehiculoXTipo($conexion, $vehiculo[0], 'Certificado de Matriculación Anual');
		$certificadoMatricula = pg_fetch_assoc($res);
	?>
	
 

<form id="notificarHabilitarVehiculo" data-rutaAplicacion="transportes" data-opcion="habilitarVehiculoMatriculacion" data-accionEnExito="ACTUALIZAR" >
		<fieldset id='datosVehiculo'>
			<legend>Información del vehículo</legend>

			<div data-linea="1">

				<label>Placa: </label>
				<?php echo $vehiculoUsado['placa'];?>

			</div>
			<div data-linea="2">

				<label>Marca: </label>
				<?php echo $vehiculoUsado['marca'];?>

			</div>
			<div data-linea="2">

				<label>Modelo: </label>
				<?php echo $vehiculoUsado['modelo'];?>

			</div>
			<div data-linea="3">

				<label>Tipo: </label>
				<?php echo $vehiculoUsado['tipo'];?>

			</div>
			<div data-linea="3">

				<label>Tipo combustible: </label>
				<?php echo $vehiculoUsado['combustible'];?>

			</div>
			
		</fieldset>
		
		<fieldset>
			<legend>Última Matriculación</legend>

			<div data-linea="1">

				<label>Tipo: </label>
				<?php echo $matricula['tipo_documento'];?>

			</div>
			
			<div data-linea="1">

				<label>Tipo: </label>
				<?php echo $certificadoMatricula['tipo_documento'];?>

			</div>
			
			<div data-linea="2">

				<label>Fecha inicio vigencia: </label>
				<?php echo $matricula['fecha_inicio'];?>

			</div>
			<div data-linea="2">

				<label>Fecha inicio vigencia: </label>
				<?php echo $certificadoMatricula['fecha_inicio'];?>

			</div>
			<div data-linea="3">

				<label>Fecha fin vigencia: </label>
				<?php echo $matricula['fecha_fin'];?>

			</div>
			<div data-linea="3">

				<label>Fecha fin vigencia: </label>
				<?php echo $certificadoMatricula['fecha_fin'];?>

			</div>
			
			<div data-linea="4">

				<label>Estado: </label>
				<?php echo $matricula['estado_documento'];?>

			</div>
			<div data-linea="4">

				<label>Estado: </label>
				<?php echo $certificadoMatricula['estado_documento'];?>

			</div>
			
			<div data-linea="5">

				<label>Estado liberación: </label>
				<?php echo $matricula['bandera_liberacion'];?>

			</div>
			<div data-linea="5">

				<label>Estado liberación: </label>
				<?php echo $certificadoMatricula['bandera_liberacion'] . ' ' . $certificadoMatricula['fecha_liberacion'];?>

			</div>
			
			<div data-linea="6">

				<label>Motivo liberación: </label>
				<?php echo $matricula['motivo_liberacion'];?>

			</div>
			<div data-linea="6">

				<label>Motivo liberación: </label>
				<?php echo $certificadoMatricula['motivo_liberacion'];?>

			</div>
			
		</fieldset>

		<input type="hidden" name="placa" value="<?php echo $vehiculoUsado['placa'];?>" /> 
		<input type='hidden' id='identificadorUsuarioRegistro' name='identificadorUsuarioRegistro' value="<?php echo $identificadorUsuarioRegistro;?>" />
						
		<fieldset id="formHabilitarVehiculo">

			<legend>Liberar Vehículo</legend>

				<div data-linea="1">
					<label>Tipo de Documento</label>
				<select id="tipoDocumento" name="tipoDocumento" required>
					<option value="">Seleccione....</option>
					<option value="<?php echo $certificadoMatricula['id_matriculacion'];?>">Certificado de Matriculación Anual</option>
					<option value="<?php echo $matricula['id_matriculacion'];?>">Matrícula del Vehículo</option>
				</select>
				</div>
				
				<div data-linea="2">
					<label>Motivo liberación:</label>
						<input type="text" name="motivoLiberacion" id="motivoLiberacion" /> 
				</div>
		</fieldset>

		<button type="submit" id="botonHabilitar" class="guardar">Liberar vehículo</button>
	
</form>

</body>

<script type="text/javascript">
var vehiculo= <?php echo json_encode($vehiculoUsado['placa']); ?>;
var estadoVehiculo= <?php echo json_encode($vehiculoUsado['estado']); ?>;

$(document).ready(function(){

	distribuirLineas();
	
	if(vehiculo == ''){
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione un vehículo para continuar.</div>');
	}else{
		
		if(estadoVehiculo != 5){
			$("#detalleItem").html('<div class="mensajeInicial">No puede habilitar un vehículo que no se encuentre en estado <b>Matriculación</b>.</div>');
		}else{
		
		}
	}
});

$("#notificarHabilitarVehiculo").submit(function(event){

	event.preventDefault();
	
	$(".alertaCombo").removeClass("alertaCombo");
	var error = false;

	if($("#tipoDocumento option:selected").val()==""){
		error = true;
		$("#tipoDocumento").addClass("alertaCombo");
	}
	
	if($("#motivoLiberacion").val()==""){
		error = true;
		$("#motivoLiberacion").addClass("alertaCombo");
	}

	if(!error ){
		ejecutarJson($(this));
	}
});


</script>

</html>