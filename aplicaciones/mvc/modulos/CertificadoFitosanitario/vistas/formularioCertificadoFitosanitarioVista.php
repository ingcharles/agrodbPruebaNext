<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario'
	data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>CertificadoFitosanitario'
	data-opcion='CertificadoFitosanitario/guardar'
	data-destino="detalleItem"
	method="post">
	<?php
	echo $this->datosGenerales;
	echo $this->datosFormaPago;
	echo $this->datosProductos;
	echo $this->datosPaisDestino;
	echo $this->datosPuertosTransito;
	echo $this->datosExportador;
	echo $this->datosDocumentosAdjuntos;
	?>	
	<div data-linea="1">
		<button type="submit" class="guardar">Guardar</button>
	</div>
	<input type="hidden" id="id" name="id" />
	<div id="cargarMensajeTemporal"></div>
</form>
<script type="text/javascript">

	$(document).ready(function() {
		var error = false;
		$("#estado").html("").removeClass('alerta');
		construirValidador();
		distribuirLineas();
		$("form").keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
    	});
	 });
	 
	 $("#tipo_solicitud").change(function () {
						
		$("#forma_pago").prop('disabled', false);
		$("#tipo_solicitud option:not(:selected)").remove();
		$("#id_idioma").prop('disabled', false);

		var fecha = new Date();	
		if($("#tipo_solicitud").val() == "musaceas" || $("#tipo_solicitud").val() == "otros"){
			$("#fecha_embarque").datepicker({ 
    		    changeMonth: true,
    		    changeYear: true,
    		    dateFormat: 'yy-mm-dd'
    		});   	
		}else if($("#tipo_solicitud").val() == "ornamentales"){
			$("#fecha_embarque").datepicker({ 
    		    changeMonth: true,
    		    changeYear: true,
    		    dateFormat: 'yy-mm-dd',
    		    minDate: fecha
    		}); 		
		}
		 
    });    
    
    $("#id_idioma").change(function () {
		$("#id_tipo_produccion").attr("disabled",false);
		$("#id_medio_transporte").attr("disabled",false);
		$("#fecha_embarque").attr("disabled",false);
		$("#id_puerto_embarque").attr("disabled",false);
		$("#id_idioma option:not(:selected)").remove();
		
		let idiomaCertificado = $('#id_idioma option:selected').attr('data-codigoIdioma');
		
		if(idiomaCertificado!= ""){		
			fn_obtenerTipoProduccionPorIdioma(idiomaCertificado);
			fn_cargarMediosTransportePorIdioma(idiomaCertificado);		
		}
		
	});

    function fn_obtenerTipoProduccionPorIdioma(idioma) {  

		event.preventDefault();
    	$("#estado").html("").removeClass('alerta');

		$.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/obtenerTipoProduccionPorIdioma",
		{
			idioma : idioma
		}, function (data) {
			$("#id_tipo_produccion").html(data);
		});

    } 

    function fn_cargarMediosTransportePorIdioma(idioma) {  

    	event.preventDefault();
    	$("#estado").html("").removeClass('alerta');

		$.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/obtenerMediosTransportePorIdioma",
		{
			idioma : idioma
		}, function (data) {
			$("#id_medio_transporte").html(data);           
		});

    }
	
	$("#id_medio_transporte").change(function () {
	
		let idPuertoEmbarque = $("#id_puerto_embarque");
		let nombreMediotransporte = $("#id_medio_transporte option:selected").text();
	
		if ($("#id_medio_transporte").val() !== "") {
        	fn_cargarPuertosPorMedioTransporte($("#id_puerto_embarque"), nombreMediotransporte);
        	$("#id_puerto_embarque option:not(:selected)").remove();	 
        }
		$("#id_puerto_embarque").prop("disabled",false);		
	});

    function fn_cargarPuertosPorMedioTransporte(objeto, nombreMedioTrasporte) {      

		$.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/obtenerPuertosPorNombreMedioTransporte",
		{
			nombreMedioTrasporte : nombreMedioTrasporte
		}, function (data) {
			objeto.html(data);               
		});
    
    }
    
    $("#forma_pago").change(function () {
		if($("#forma_pago").val() == "saldo"){
			$("#descuento").removeClass("validacion");
			$("#motivo_descuento").removeClass("validacion");
			$("#descuento").prop("disabled",true);
			$("#motivo_descuento").prop("disabled",true);
			$("#motivo_descuento").val("");	
			$("#descuento").val("");	
		}else{
			$("#descuento").addClass("validacion");
			$("#descuento").prop("disabled",false);
		}
	});
	
	$("#descuento").change(function () {
		if($("#descuento").val() == "Si"){
			$("#motivo_descuento").prop("disabled",false);
			$("#motivo_descuento").addClass("validacion");	
		}else{
			$("#motivo_descuento").removeClass("validacion");
			$("#motivo_descuento").prop("disabled",true);	
			$("#motivo_descuento").val("");
		}
    });

	$("#formulario").submit(function (event) {
		event.preventDefault();
        var error = false;
		$("#estado").html("").removeClass('alerta');
		$(".alertaCombo").removeClass("alertaCombo");

        $('#formulario .validacion').each(function (i, obj) {
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
                    $("#formulario").attr('data-opcion', 'CertificadoFitosanitario/editar');
                    abrir($("#formulario"), event, false);
				}, 1000);
                
            }else {
                $("#estado").html(respuesta.mensaje).addClass("alerta");
            }
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
	});

</script>
