<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';
require_once '../../clases/ControladorAreas.php';
require_once '../../clases/ControladorUsuarios.php';
require_once '../../clases/ControladorCatalogos.php';

$conexion = new Conexion();
$ca = new ControladorAreas();
$cu = new ControladorUsuarios();
$cv = new ControladorVehiculos();
$cc = new ControladorCatalogos();

//Identificador Usuario Administrador o Apoyo de Transportes
$identificadorUsuarioRegistro = $_SESSION['usuario'];
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
	<h1>Nuevo administrador provincial</h1>
</header>

<div id="estado"></div>

<form id='formularioAdministrador' data-rutaAplicacion='transportes' data-opcion='guardarNuevoAdministrador' data-destino="detalleItem">

	<input type='hidden' id='identificadorUsuarioRegistro' name='identificadorUsuarioRegistro' value="<?php echo $identificadorUsuarioRegistro;?>" />

	<fieldset>
		<legend>Datos del responsable</legend>
		
		<div data-linea="1">	
	
			<label>Identificador:</label>
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
			<div id="dSubOficinaAdmin"></div>
    	 </div>
    	 
    	 <div data-linea="5">
			<div id="dSubOcupanteAdmin"></div>
    	 </div>
	
		<input type='hidden' id='area' name='area'  />
	
	</fieldset>
	
	<fieldset>
		<legend>Información adicional</legend>

		<div data-linea="1">
		
		<label>Observaciones</label> 
			<input type="text" id="observaciones" name="observaciones" data-er="^[A-Za-z0-9.,/ ]+$"/>
			
		</div>
			
	</fieldset>
	
	<button type="submit" class="guardar">Guardar vehículo</button>
</form>

<div id="fotosVehiculo"></div>
</body>

<script type="text/javascript">


				
$("#formularioAdministrador").submit(function(event){

	$("#formularioAdministrador").attr('data-opcion', 'guardarNuevoAdministrador');
	$("#formularioAdministrador").attr('data-destino', 'detalleItem');
	event.preventDefault();

	$(".alertaCombo").removeClass("alertaCombo");
	var error = false;

	if($("#administrador").val()==null || $("#administrador").val()==''){
		error = true;
		$("#administrador").addClass("alertaCombo");
		$("#estado").html("Debe seleccionar a un funcionario de Agrocalidad").addClass("alerta");
	}

	if($("#observaciones").val()!=""){
		if(!$.trim($("#observaciones").val()) || !esCampoValido("#observaciones")){
			error = true;
			$("#observaciones").addClass("alertaCombo");
		}
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


	$("#provinciaOcupante").change(function(event){
		$("#dSubOficinaAdmin").text("");
		$("#dSubOcupanteAdmin").text("");
		
		$("#formularioAdministrador").attr('data-opcion', 'combosAdministrador');
	    $("#formularioAdministrador").attr('data-destino', 'dSubOficinaAdmin');
	    abrir($("#formularioAdministrador"), event, false); //Se ejecuta ajax
	 });

	$(document).ready(function(){
		distribuirLineas();
		construirValidador();
	});
      
</script>
</html>