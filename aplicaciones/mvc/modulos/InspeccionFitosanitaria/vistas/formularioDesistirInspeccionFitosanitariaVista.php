<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<?php
    echo $this->datosOperador;
    echo $this->datosExportacion;
    echo $this->datosDescripcionEnvio;
    echo $this->datosProductoresAgregados;
    echo $this->datosRevision;
    echo $this->datosInspeccion;
?>

<form id='formularioDesestimiento'
	data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>InspeccionFitosanitaria'
	data-opcion='InspeccionFitosanitaria/enviarDesestimiento'
	data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<input type="hidden" name="id_inspeccion_fitosanitaria" value="<?php echo $this->modeloInspeccionFitosanitaria->getIdInspeccionFitosanitaria();?>" readonly="readonly">
	<div data-linea="1">
		<button type="submit" id="bDesistirSolicitud" class="guardar">Desistir</button>
	</div>
	<div id="cargarMensajeTemporal"></div>
</form>
<script type="text/javascript">
	
	var banderaDesestimiento = <?php echo json_encode($this->banderaDesestimiento);?>;
	var mensajeDesestimiento = <?php echo json_encode($this->mensajeDesestimiento);?>;

    $(document).ready(function() {
        construirValidador();
        distribuirLineas();
        $("#estado").html("").removeClass('alerta');
		if(banderaDesestimiento == "desestimiento"){		
    		$("#detalleItem").html('<div class="mensajeInicial">' + mensajeDesestimiento + '</div>');
        }
    });
	
	//Funcion para agregar fila de detalle de exportadores productos
    $("#formularioDesestimiento").submit(function (event) {
        event.preventDefault();
        $(".alertaCombo").removeClass("alertaCombo");
		var error = false;

		if (!error) {
		
			//$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Guardando...</div>").fadeIn();
			$("#bDesistirSolicitud").prop('disabled', true);
			
			//setTimeout(function () {	
        		var respuesta = JSON.parse(ejecutarJson($("#formularioDesestimiento")).responseText);
			//}, 1000);
			
			if (respuesta.estado == 'exito'){
	       		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
            	abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), "#listadoItems", true);
	        }
			
		}else{
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});

    
</script>
