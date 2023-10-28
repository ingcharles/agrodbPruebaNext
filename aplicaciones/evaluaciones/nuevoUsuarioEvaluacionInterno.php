<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';
require_once '../../clases/ControladorUsuarios.php';
require_once '../../clases/ControladorCatalogos.php';
require_once '../../clases/ControladorEstructuraFuncionarios.php';

$conexion = new Conexion();
$cu = new ControladorUsuarios();
$ce = new ControladorEvaluaciones();
$cc = new ControladorCatalogos();
$cef = new ControladorEstructuraFuncionarios();

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
	<h1>Nuevo usuario interno evaluación</h1>
</header>

<div id="estado"></div>

<form id='formularioUsuario' data-rutaAplicacion='evaluaciones' data-opcion='guardarUsuarioEvaluacionInterno' data-destino="detalleItem">

	<input type='hidden' id='tipo' name='tipo' value="Interna" />
	<input type='hidden' id='opcion' name='opcion' value="formularioInterno" />

	<fieldset>
		<legend>Datos del Usuario Interno para Evaluación</legend>
		
		<div data-linea="1">		
			<label>Tipo Evaluación:</label>
			<select id="tipoEvaluacion" name="tipoEvaluacion" required>
				<option value="">Seleccione....</option>
				<option value="Nacional">Nacional</option>
				<option value="Unidad">Coordinación/Dirección</option>
				<option value="Individual">Individual</option>
			</select>						
		</div>
		
		<div data-linea="2">		
			<div id="dSubUsuario"></div>							
		</div>
		
	</fieldset>
			
	<fieldset>
		<legend>Asignar Evaluaciones</legend>

		<div data-linea="1">
		
			<label>Área:</label> 
			<select id="idArea" name="idArea" required>
					<option value="">Seleccione....</option>
					<?php 
					   $coordinaciones = $cef->obtenerEstructuraPlantaCentralGeneral($conexion);
    					
    					while ($fila = pg_fetch_assoc($coordinaciones)){
    					    echo '<option value="' . $fila['id_area'] . '">' . $fila['nombre'] . '</option>';
						}
					?>
				</select>			
		</div>
		
		<div data-linea="2">		
			<div id="dSubEvaluacion"></div>							
		</div>
			
	</fieldset>
	
	<button type="submit" class="guardar">Guardar</button>
</form>

<script type="text/javascript">

$(document).ready(function(){
	distribuirLineas();
	construirValidador();
});
	
$("#idArea").change(function(event){
		$("#dSubEvaluacion").text("");
		
		$("#formularioUsuario").attr('data-opcion', 'combosEvaluaciones');
	    $("#formularioUsuario").attr('data-destino', 'dSubEvaluacion');
	    abrir($("#formularioUsuario"), event, false); //Se ejecuta ajax
});

$("#tipoEvaluacion").change(function(event){
		$("#dSubUsuario").text("");
		
		$("#formularioUsuario").attr('data-opcion', 'combosUnidades');
	    $("#formularioUsuario").attr('data-destino', 'dSubUsuario');
	    abrir($("#formularioUsuario"), event, false); //Se ejecuta ajax
});
	 
function esCampoValido(elemento){
	var patron = new RegExp($(elemento).attr("data-er"),"g");
	return patron.test($(elemento).val());
}
				
$("#formularioUsuario").submit(function(event){

	$("#formularioUsuario").attr('data-opcion', 'guardarUsuarioEvaluacionInterno');
	$("#formularioUsuario").attr('data-destino', 'detalleItem');
	event.preventDefault();

	$(".alertaCombo").removeClass("alertaCombo");
	var error = false;

	if(!$.trim($("#tipoEvaluacion").val())){
		error = true;
		$("#tipoEvaluacion").addClass("alertaCombo");
	}
	
	if($("#tipoEvaluacion option:selected").val() == 'Individual'){
		if(!$.trim($("#identificadorUsuario").val())){
    		error = true;
    		$("#identificadorUsuario").addClass("alertaCombo");
    	}
    
    	if(!$.trim($("#nombreUsuario").val()) || !esCampoValido("#nombreUsuario")){
    		error = true;
    		$("#nombreUsuario").addClass("alertaCombo");
    	}
    	
    	if(!$.trim($("#apellidoUsuario").val()) || !esCampoValido("#apellidoUsuario")){
    		error = true;
    		$("#apellidoUsuario").addClass("alertaCombo");
    	}
	}else if($("#tipoEvaluacion option:selected").val() == 'Unidad'){
		if(!$.trim($("#idUnidad").val())){
    		error = true;
    		$("#idUnidad").addClass("alertaCombo");
    	}
	}
	
	if(!$.trim($("#idArea").val())){
		error = true;
		$("#idArea").addClass("alertaCombo");
	}
	
	if(!$.trim($("#idEvaluacion").val())){
		error = true;
		$("#idEvaluacion").addClass("alertaCombo");
	}
	
	if(!error){
		var respuesta = JSON.parse(ejecutarJson($(this)).responseText);
		
		if (respuesta.estado == 'exito'){
        	$("#estado").html("Se han guardado los datos con éxito.").addClass("exito");
        	$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un ítem para revisarlo.</div>');
        }else{
        	$("#estado").html(respuesta.mensaje).addClass("alerta");
	    }
	        
	}else{
		$("#estado").html("Verificar la información ingresada.").addClass("alerta");
	}
	
});

function esCampoValido(elemento){
	var patron = new RegExp($(elemento).attr("data-er"),"g");
	return patron.test($(elemento).val());
}
      
</script>
</html>