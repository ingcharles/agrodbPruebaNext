<header>
	<nav><?php echo $this->panelAnulacionFactura; ?></nav>
	<nav><?php echo $this->crearAccionBotones();?></nav>
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
	<thead>
		<tr>
			<th>#</th>
			<th>Número de factura</th>
			<th>Número de GLPI</th>
			<th>Fecha de anulación</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes"); });
		$("#_eliminar").click(function () {
		if ($("#cantidadItemsSeleccionados").text() > 1) {
			alert('Por favor seleccione un registro a la vez');
			return false;
		}
	});

	$("#bRuc").change(function () {	
    	let ruc = $('#bRuc option:selected').val();    	
    	event.preventDefault();
    	
    	$("#estado").html("").removeClass('alerta');

		if(ruc != ""){
    		$.post("<?php echo URL ?>Financiero/AnulacionFactura/obtenerNumeroEstablecimientoPorRuc",
    		{
    			ruc : ruc
    		}, function (data) {
    			$("#bNumeroEstablecimiento").html(data);
    		});
		}   	
	});
	
	$("#bNumeroFactura").on('input', function () { 
    	this.value = this.value.replace(/[^0-9]/g,'');
	});
	
	$("#bFechaInicio").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#bFechaInicio').datepicker('getDate')); 
        	fecha.setDate(fecha.getDate()+90);	 
      		$('#bFechaFin').datepicker('option', 'minDate', $("#bFechaInicio" ).val());
      		$('#bFechaFin').datepicker('option', 'maxDate', fecha);
      		$('#bFechaFin').datepicker('setDate', fecha);
	    }
	}).datepicker("setDate", new Date());

	$("#bFechaFin").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#bFechaInicio').datepicker('getDate')); 
	    }
	 }).datepicker("setDate", new Date());
	 
	 
	 $("#btnFiltrar").click(function (event) {
		event.preventDefault();
		fn_filtrar();
	});
	
	function fn_filtrar() {

		event.preventDefault();
        var error = false;
        fn_limpiar();
		$("#estado").html("").removeClass('alerta');
		$(".alertaCombo").removeClass("alertaCombo");

        $('#busquedaFactura .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });
		        
		if (!error) {
			$("#paginacion").html("<div id='cargando'>Cargando...</div>");
			  $.post("<?php echo URL ?>Financiero/AnulacionFactura/listarFacturasAnuladas",
		    	{
				  	bRuc: $("#bRuc").val(),
				  	bNumeroEstablecimiento: $("#bNumeroEstablecimiento").val(),
				  	bNumeroFactura: $("#bNumeroFactura").val(),
				  	bFechaInicio: $("#bFechaInicio").val(),
				  	bFechaFin: $("#bFechaFin").val(),
		        },
		      	function (data) {
		        	if (data.estado === 'FALLO') {
	                mostrarMensaje(data.mensaje, "FALLO");
	                } else {
	                	construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
	                }
		        }, 'json');
		} else {
			$("#estado").html();
			mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
		}		
	}

	function fn_limpiar() {
		$(".alertaCombo").removeClass("alertaCombo");
		$('#estado').html('');
	}
	
</script>
