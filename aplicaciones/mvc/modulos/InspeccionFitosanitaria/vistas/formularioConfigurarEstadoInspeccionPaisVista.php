<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>InspeccionFitosanitaria' data-opcion='ConfigurarEstadoInspeccionPais/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<?php 
	   echo $this->datosRegistro;
	?>
</form >
<script type ="text/javascript">

	$(document).ready(function() {
		var error = false;
		$("#estado").html("").removeClass('alerta');
		construirValidador();
		distribuirLineas();
	});

	$("#dias_vigencia").on('input', function () { 
    	this.value = this.value.replace(/[^0-9]/g,'');
	});
	
	$("#formulario").submit(function (event) {
		event.preventDefault();
		var error = false;
		$(".alertaCombo").removeClass("alertaCombo");
		var mensajeDetalle = "";

		$('#formulario .validacion').each(function(i, obj) {
 			if(!$.trim($(this).val())){
 				error = true;
 				$(this).addClass("alertaCombo");
 			}
 		});
 		
		if (!error) {
			$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Guardando...</div>").fadeIn();
			$("#bEnviarResultado").prop('disabled', true);
			
			setTimeout(function () {	
        		var respuesta = JSON.parse(ejecutarJson($("#formulario")).responseText);
			}, 1000);
			
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});
</script>
