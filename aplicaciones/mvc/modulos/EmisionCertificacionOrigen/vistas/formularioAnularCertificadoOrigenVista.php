<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>EmisionCertificacionOrigen' data-opcion='anularCertificadoOrigen/anularCertificadoEmitido' data-destino="detalleItem" data-accionEnExito ="ACTUALIZAR" method="post">
    
    <?php echo $this->contenidoDatosGenerales;?>
    <?php echo $this->contenidoDatosOrigen;?>
    <?php echo $this->contenidoDatosDestino;?>
    <?php echo $this->contenidoDatosMovilizacion;?>
    <?php echo $this->contenidoDatosDetalleProductosMovilizar;?>
    <?php echo $this->contenidoDatosDetalleSubProductosMovilizar;?> 
    <?php echo $this->contenidoDatosAnularCertificado;?> 

    <div data-linea="4" class="editable">
    <button type="submit" class="guardar" id="hola">Guardar</button>
</div>
</form >

<script type ="text/javascript">
    $(document).ready(function() {

    });

    
    $("#formulario").submit(function (event) {
        event.preventDefault();
		var error = false;
		$(".alertaCombo").removeClass("alertaCombo");

        if($("#idEstadoCertificado").val() == '' ){
		    $("#idEstadoCertificado").addClass("alertaCombo");
		    error = true;
        }
        if($("#text_motivo").val() == '' ){
		    $("#text_motivo").addClass("alertaCombo");
		    error = true;
        }

        if (!error) {
				
            abrir($(this), event, false);
			abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);  
			
		} else {
				$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
			}
    });

    function contadorPalabrasInput(elemento){
	
	    text_max  = $(elemento).attr("maxlength")
    	$('#textarea_feedback').html('Quedan ' + text_max + ' caracteres');
    	$(elemento).keyup(function() {
       	 	var text_length = $(elemento).val().length;
      	 	var text_remaining = text_max - text_length;
        $('#textarea_feedback').html('Quedan ' + text_remaining + ' caracteres');
    	});
    }
    $('.input-number').on('input', function () { 
		this.value = this.value.replace(/[^0-9,]/g,'');
	});
    </script>