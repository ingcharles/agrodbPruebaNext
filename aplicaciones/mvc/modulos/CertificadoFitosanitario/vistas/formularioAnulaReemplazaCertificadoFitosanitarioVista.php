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
		?>
		<form id='formularioAnulaReemplaza'
			data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>CertificadoFitosanitario'
			data-opcion='CertificadoFitosanitario/enviarAnulaReemplaza'
				data-destino="detalleItem"
				method="post">
				<input type="hidden" name="id_certificado_fitosanitario" value="<?php echo (($this->datosCertificadoFitosanitario) ? $this->datosCertificadoFitosanitario->getIdCertificadoFitosanitario() : "");?>" readonly="readonly" >
			<?php			
			echo $this->datosExportador;
			echo $this->datosRevisionDocumental;
			echo $this->datosDocumentosAdjuntos;
			echo $this->datosMotivoAnulacion;
			?>
			<div data-linea="1">
    			<button type="submit" id="bEnviarSolicitud" class="guardar">Anular y reemplazar</button>
    		</div>
    		<input type="hidden" id="id" name="id" />
			<div id="cargarMensajeTemporal"></div>		
		</form>
	</div>
	
	
<script type="text/javascript">

	var banderaAnulaReemplaza = <?php echo json_encode($this->banderaAnulaReemplaza);?>;
	var mensajeAnulaReemplaza = <?php echo json_encode($this->mensajeAnulaReemplaza);?>;
	
	$(document).ready(function() {
		var error = false;
		$("#estado").html("").removeClass('alerta');
		if(banderaAnulaReemplaza == "anulaReemplaza"){    		
    		$("#detalleItem").html('<div class="mensajeInicial">' + mensajeAnulaReemplaza + '</div>');
        }
		construirAnimacion($(".pestania"));		
		construirValidador();
		distribuirLineas();
        $("form").keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
    	});
	});
		
	$("#formularioAnulaReemplaza").submit(function (event) {
    	event.preventDefault();
        var error = false;
		$("#estado").html("").removeClass('alerta');
		$(".alertaCombo").removeClass("alertaCombo");

        $('#formularioAnulaReemplaza .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {
            var respuesta = JSON.parse(ejecutarJson($(this)).responseText);

            if (respuesta.estado === 'exito'){
            		
            	$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Guardando...</div>").fadeIn();
			            
            	setTimeout(function () {
                    abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
                    $("#id").val(respuesta.contenido);
                    $("#formularioAnulaReemplaza").attr('data-opcion', 'CertificadoFitosanitario/editar');
                    abrir($("#formularioAnulaReemplaza"), event, false);
				}, 1000);
                
            }else {
                $("#estado").html(respuesta.mensaje).addClass("alerta");
            }
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
	});

</script>
