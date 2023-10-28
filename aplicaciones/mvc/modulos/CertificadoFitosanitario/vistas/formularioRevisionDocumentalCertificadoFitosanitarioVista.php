<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

	
	<div class="pestania">
			<?php
			echo $this->datosGenerales;
			echo $this->datosFormaPago;
			?>
	</div>
	<div class="pestania">
		<?php		
		echo $this->datosPaisDestino;
		echo $this->datosProductos;
		echo $this->datosPuertosTransito;
		echo $this->datosExportador;
		echo $this->datosDocumentosAdjuntos;
		?>
	<form id='formularioRevisionDocumental'
		data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>CertificadoFitosanitario'
		data-opcion='RevisionCertificadoFitosanitario/guardarRevisionDocumental'
			data-destino="detalleItem" data-accionEnExito="ACTUALIZAR"
			method="post">
			<input type="hidden" name="id_certificado_fitosanitario" value="<?php echo $this->datosCertificadoFitosanitario->getIdCertificadoFitosanitario();?>" readonly="readonly" >
		<?php		
		echo $this->datosRevisionDocumental;
		?>
		<div id="cargarMensajeTemporal"></div>		
	</form>
	</div>
	
	
<script type="text/javascript">

	var idCertificadoFitosanitario = <?php echo json_encode($this->datosCertificadoFitosanitario->getIdCertificadoFitosanitario());?>;
	var idTipoProduccion = <?php echo json_encode($this->datosCertificadoFitosanitario->getIdTipoProduccion());?>;

	$(document).ready(function() {
		var error = false;
		$("#estado").html("").removeClass('alerta');
		construirAnimacion($(".pestania"));		
		construirValidador();
		distribuirLineas();
		$("input[name='cantidad_comercial[]']").numeric();
        $("input[name='peso_bruto[]']").numeric();
        $("form").keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
    	});
	});
	
	$("#formularioRevisionDocumental").submit(function (event) {
    	event.preventDefault();
		var error = false;
		$(".alertaCombo").removeClass("alertaCombo");
		var mensajeDetalle = "";

		$('#formularioRevisionDocumental .validacion').each(function(i, obj) {
 			if(!$.trim($(this).val())){
 				error = true;
 				$(this).addClass("alertaCombo");
 			}
 		});	

		if (!error) {
		
			$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Guardando...</div>").fadeIn();
			$("#bEnviarResultado").prop('disabled', true);
			
			setTimeout(function () {	
        		var respuesta = JSON.parse(ejecutarJson($("#formularioRevisionDocumental")).responseText);
			}, 1000);
			
		}else{
			$("#estado").html("Por favor revise los campos obligatorios." + mensajeDetalle).addClass("alerta");
		}
	});

</script>
