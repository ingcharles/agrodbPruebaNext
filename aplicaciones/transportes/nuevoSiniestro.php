<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorAreas.php';
require_once '../../clases/ControladorVehiculos.php';
require_once '../../clases/ControladorUsuarios.php';
require_once '../../clases/ControladorCatastro.php';
require_once '../../clases/ControladorCatalogos.php';

$conexion = new Conexion();
$ca = new ControladorAreas();
$cv = new ControladorVehiculos();
$cu = new ControladorUsuarios();
$cca = new ControladorCatastro();
$cc = new ControladorCatalogos();

//Identificador Usuario Administrador o Apoyo de Transportes
$identificadorUsuarioRegistro = $_SESSION['usuario'];

//$talleres = $cv->abrirDatosTalleres($conexion, $_SESSION['idLocalizacion']);
$vehiculo = $cv->obtenerDatosVehiculos($conexion, $_SESSION['nombreLocalizacion'],"Otro");
$area = $ca->obtenerAreasDireccionesTecnicas($conexion, "('Planta Central','Oficina Técnica')", "(3,4,1)");
$usuario = $cu->obtenerUsuariosXarea($conexion);

while($fila = pg_fetch_assoc($usuario)){
	$responsable[]= array(identificador=>$fila['identificador'], apellido=>$fila['apellido'], nombre=>$fila['nombre'], area=>$fila['id_area']);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel='stylesheet' href='../general/estilos/agrodb_papel.css' >
<link rel='stylesheet' href='../general/estilos/agrodb.css'>
</head>
<body>

<header>
	<h1>Nuevo Siniestro</h1>
</header>

<div id="estado"></div>
<form id="formulario" data-rutaAplicacion="transportes" data-opcion="guardarNuevoSiniestro" data-destino="detalleItem">
	<input type='hidden' id='identificadorUsuarioRegistro' name='identificadorUsuarioRegistro' value="<?php echo $identificadorUsuarioRegistro;?>" />
	<input type="hidden" name="id_vehiculo" id="id_vehiculo"/>
	
	<fieldset>
		<legend>Detalle de Siniestro</legend>
		
		<div data-linea="1">
						
			<label>Tipo</label> 
				<select id="tipo_siniestro" name="tipo_siniestro" >	
					<option value="" selected="selected">Tipo...</option>
					<option value="Robo">Robo</option>
					<option value="Choque">Choque</option>
					<option value="Daños menores">Daños menores</option>							
				</select>
								
		</div><div data-linea="1">
			
			<label>Fecha</label>
				<input type="text" id="fecha_siniestro" name="fecha_siniestro" required="required" readonly="readonly" />
				
		</div><div data-linea="2">
			
			<label>Ubicación</label> 
				<input type="text" name="lugar_siniestro" placeholder="Ej: Av. Amazonas y Eloy Alfaro" required="required"/> 
				
		</div><div data-linea="2">
			
			<label>Magnitud del Daño</label> 
				<select id="magnitud_siniestro" name="magnitud_siniestro">
					<option value="" selected="selected">Tipo...</option>
					<option value="Reparación">Reparación</option>
					<option value="Pérdida total">Pérdida total</option>							
				</select> 
				
		</div><div data-linea="3"> 
			
			<label>Observaciones</label> 
				<!--input type="text" name="observaciones" placeholder="Ej: Ninguna" required="required"/-->
				<textarea id="observaciones" name="observaciones" rows="4" required="required"></textarea>
		</div>
				
	</fieldset>
		
		<fieldset id="datosVehiculo">
		<legend>Datos generales</legend>
		
		<div data-linea="1"> 
		
			<label>Vehículo</label>	
				<select id="vehiculo" name="vehiculo" >
					<option value="">Vehículo....</option>
					<?php 
						while($fila = pg_fetch_assoc($vehiculo)){
							echo '<option value="' . $fila['placa'] . '" data-kilometraje="Kilometraje actual: '. $fila['kilometraje_actual'].'" data-idVehiculo="'. $fila['id_vehiculo'].'">' . $fila['marca'] .' '.$fila['modelo'] .' -> '.$fila['placa']. '</option>';					
						}
					?>
				</select>
				
		</div>
		
		<div data-linea="1">
			
			<label>Kilometraje</label> 
				<input type="number" step="1" name="kilometraje" id="kilometraje" placeholder="Ej: 12345" required="required"/> 
			
		</div>			
				 
	</fieldset>
	
	<fieldset>
		<legend>Conductor Responsable</legend>
			
			<div data-linea="3">		
        		<label>Provincia:</label>
        				<select id="provinciaOcupante" name="provinciaOcupante" >
        					<option value="">Provincia....</option>
        					<?php 
        						$provincias = $cc->listarSitiosLocalizacion($conexion,'PROVINCIAS');
        						foreach ($provincias as $provincia){
        						    echo '<option value="' . $provincia['nombre'] . '">' . $provincia['nombre'] . '</option>';
        						}
        					?>
        				</select>
        	</div>        		
        				
    		<div data-linea="4">
    			<div id="dSubOficina"></div>
        	 </div>
        	 
        	 <div data-linea="5">
    			<div id="dSubOcupante"></div>
        	 </div>
				 
			 <input type='hidden' id='area' name='area'  />
				 
	</fieldset>	

	<button type="submit" class="guardar">Guardar siniestro</button>
	
</form>

<div id="fotosVehiculoSiniestro"></div>

</body>

<script type="text/javascript">


var array_responsable= <?php echo json_encode($responsable); ?>;

$("#vehiculo").change(function(){
	var vehiculo = $("#vehiculo  option:selected").attr("data-kilometraje");
	$("#estado").html(vehiculo).addClass("exito");	
	$('#id_vehiculo').val($("#vehiculo  option:selected").attr("data-idVehiculo"));

	var actualKm = $("#vehiculo  option:selected").attr("data-kilometraje");
	var kmActual = actualKm.split(" ");  

	$("#kilometraje").val(Number(kmActual[2]));
});

$("#area").change(function(event){
	$("#categoriaArea").val($('#area option:selected').attr('data-categoria'));
	$("#formulario").attr('data-opcion', 'combosOcupante');
    $("#formulario").attr('data-destino', 'dSubOcupante');
    abrir($("#formulario"), event, false); //Se ejecuta ajax, busqueda de sub tipo producto
    
    $('#ocupante').html(socupante);
    $('#ocupante').removeAttr("disabled");
 });

$("#formulario").submit(function(event){

	$("#formulario").attr('data-opcion', 'guardarNuevoSiniestro');
    $("#formulario").attr('data-destino', 'detalleItem');
    
	event.preventDefault();

	$(".alertaCombo").removeClass("alertaCombo");
	var error = false;

	if($("#tipo_siniestro").val()==""){
		error = true;
		$("#tipo_siniestro").addClass("alertaCombo");
	}

	if($("#magnitud_siniestro").val()==""){
		error = true;
		$("#magnitud_siniestro").addClass("alertaCombo");
	}

	if($("#vehiculo").val()==""){
		error = true;
		$("#vehiculo").addClass("alertaCombo");
	}

	if($("#area").val()==""){
		error = true;
		$("#area").addClass("alertaCombo");
	}
	
	if($("#ocupante").val()==null || $("#ocupante").val()=='' || $("#ocupante").val()=="Otro"){
		error = true;
		$("#ocupante").addClass("alertaCombo");
		$("#estado").html("Debe seleccionar a un funcionario de Agrocalidad").addClass("alerta");
	}

	if (!error){
		abrir($(this),event,false);
	}
});


$(document).ready(function(){

	distribuirLineas();
	
		$("#fecha_siniestro").datepicker({
		      changeMonth: true,
		      changeYear: true,
			dateFormat: 'yy-mm-dd'
		    });
	});

$("#vehiculo").change(function(){
	$('#id_vehiculo').val($("#vehiculo  option:selected").attr("data-idVehiculo"));
});

$("#provinciaOcupante").change(function(event){
	$("#dSubOficina").text("");
	$("#dSubOcupante").text("");
	
	$("#formulario").attr('data-opcion', 'combosOcupante');
    $("#formulario").attr('data-destino', 'dSubOficina');
    abrir($("#formulario"), event, false); //Se ejecuta ajax
 });

</script>
