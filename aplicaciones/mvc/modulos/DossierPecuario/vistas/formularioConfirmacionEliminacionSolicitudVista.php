<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>DossierPecuario' data-opcion='solicitud/eliminarSolicitud' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<input type="hidden" id="id" name="id" value="<?php echo $this->solicitudes;?>"/>
	
	<fieldset>
		<legend>Solicitudes a Eliminar</legend>				
		
		<div data-linea="0">
			<p>Las siguientes solicitudes serán eliminadas:</p>
		</div>	
		
		<?php 
		echo $this->eliminar;
		?>			

		<div data-linea="00">
			<p class="nota">No se puede eliminar solicitudes Aprobadas, Rechazadas o Eliminadas previamente.</p>
		</div>	
		
	</fieldset>
	
	<div data-linea="4">
		<button type="submit" class="guardar">Guardar</button>
	</div>

</form >

<div id="errorSolicitud">
	   <?php
            echo 'Debe seleccionar una solicitud para eliminación';
        ?>
</div>

<script type ="text/javascript">
var identificadorUsuario = <?php echo json_encode($_SESSION['usuario']); ?>;
var bandera = <?php echo json_encode($this->formulario); ?>;
var solicitudes = <?php echo json_encode($this->solicitudes); ?>;
var combo = "<option>Seleccione....</option>";

$('#errorSolicitud').hide();

	$(document).ready(function() {
		if(bandera == 'Eliminar'){
			$('#formulario').show();
			$('#errorSolicitud').hide();
		}else{
			$('#formulario').hide();
			$('#errorSolicitud').show();
		}
		
    	if(solicitudes == ''){
    		$("#detalleItem").html('<div class="mensajeInicial">No se puede eliminar solicitudes Aprobadas, Rechazadas o Eliminadas previamente.</div>');
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