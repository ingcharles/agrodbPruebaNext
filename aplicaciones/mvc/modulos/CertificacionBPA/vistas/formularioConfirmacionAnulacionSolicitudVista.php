<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>CertificacionBPA' data-opcion='solicitudes/anularSolicitud' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<input type="hidden" id="id" name="id" value="<?php echo $_POST['elementos'];?>"/>
	
	<fieldset>
		<legend>Solicitudes a Anular</legend>				
		
		<div data-linea="0">
			<p>Las siguientes solicitudes serán anuladas:</p>
		</div>	
		
		<?php 
		echo $this->anular;
		?>			

		<div data-linea="00">
			<p class="nota">No se puede anular solicitudes que no se encuentren Aprobadas.</p>
		</div>	
		
	</fieldset>
	
	<div data-linea="4">
		<button type="submit" class="guardar">Guardar</button>
	</div>

</form >

<div id="errorSolicitud">
	   <?php
            echo 'Debe seleccionar una solicitud para anulación';
        ?>
</div>

<script type ="text/javascript">
var identificadorUsuario = <?php echo json_encode($_SESSION['usuario']); ?>;
var bandera = <?php echo json_encode($this->formulario); ?>;
var combo = "<option>Seleccione....</option>";

$('#errorSolicitud').hide();

	$(document).ready(function() {
		if(bandera == 'Anular'){
			$('#formulario').show();
			$('#errorSolicitud').hide();
		}else{
			$('#formulario').hide();
			$('#errorSolicitud').show();
		}
		
		construirValidador();
		distribuirLineas();
	 });

	$("#formulario").submit(function (event) {
		event.preventDefault();
		var error = false;
		if (!error) {
			var respuesta = JSON.parse(ejecutarJson($(this)).responseText);		
			
	        if (respuesta.estado == 'exito'){
	        	$("#estado").html("Se han guardado los datos con éxito.").addClass("exito");
	        		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un ítem para revisarlo.</div>');
	        }
			
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});
</script>