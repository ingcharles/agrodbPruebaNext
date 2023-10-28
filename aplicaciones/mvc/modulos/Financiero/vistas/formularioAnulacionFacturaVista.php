<header>
	<h1>
		<?php echo $this->accion; ?>
	</h1>
</header>
<form id='formulario'
	data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>Financiero'
	data-opcion='AnulacionFactura/guardar' data-destino="detalleItem"
	data-accionEnExito="ACTUALIZAR" method="post">
	<?php echo $this->datosAnulacionFactura; ?>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
	});
	
	$("#ruc").change(function () {	
    	let ruc = $('#ruc option:selected').val();    	
    	event.preventDefault();
    	
    	$("#estado").html("").removeClass('alerta');

		if(ruc != ""){
    		$.post("<?php echo URL ?>Financiero/AnulacionFactura/obtenerNumeroEstablecimientoPorRuc",
    		{
    			ruc : ruc
    		}, function (data) {
    			$("#numero_establecimiento").html(data);
    		});
		}
    	
	});
	
	$("#numero_factura").on('input', function () { 
    	this.value = this.value.replace(/[^0-9]/g,'');
	});
	
	$("#numero_glpi").on('input', function () { 
    	this.value = this.value.replace(/[^0-9]/g,'');
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
		
			$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
			setTimeout(function(){
				JSON.parse(ejecutarJson($("#formulario")).responseText);
			}, 1000);

		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});
	
</script>
