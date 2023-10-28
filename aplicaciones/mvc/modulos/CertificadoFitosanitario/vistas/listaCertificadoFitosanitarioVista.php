<header>
<nav><?php echo $this->panelBusquedaCertificado;?></nav>
<nav><?php echo $this->crearAccionBotones();?></nav></header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
	<thead><tr>
		<th>#</th>
		<th>Tipo</th>
		<th>CFE</th>
		<th>País</th>
		<th>Fecha de Solicitud</th>
		<th>Estado</th>
		</tr></thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes");
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
	});

	$("#bFechaInicio").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#bFechaInicio').datepicker('getDate')); 
        	fecha.setDate(fecha.getDate()+15);	 
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
	 
	$("#bTipoProducto").change(function () {
    
    	event.preventDefault();
		let idTipoProducto = $("#bTipoProducto").val();
   	
    	if (idTipoProducto !== ""){    
    		 $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/buscarSubtipoProductoPorIdTipoProducto",
                {
			 		idTipoProducto : idTipoProducto		 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#bSubtipoProducto").html(data.resultado);                	
	                }else{
	                    mostrarMensaje(data.mensaje, "FALLO");
                    }	                       
                }, 'json');
    	}
    	
	});
	
	$("#bSubtipoProducto").change(function () {
    
    	event.preventDefault();
		let idSubtipoProducto = $("#bSubtipoProducto").val();
   	
    	if (idSubtipoProducto !== ""){    
    		 $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/buscarProductoPorIdSubtipoProducto",
                {
			 		idSubtipoProducto : idSubtipoProducto		 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#bProducto").html(data.resultado);                	
	                }else{
	                    mostrarMensaje(data.mensaje, "FALLO");
                    }	                       
                }, 'json');
    	}
    	
	});
	 
	$("#btnFiltrar").click(function (event) {
		event.preventDefault();
		fn_filtrar();
	});
	
	function fn_filtrar() {
		event.preventDefault();
		fn_limpiar();

		var error = false;
		        
		if (!error) {
			$("#paginacion").html("<div id='cargando'>Cargando...</div>");
			  $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/listarCertificadosFitosanitariosFiltrados",
		    	{
				  	identificadorOperador: $("#identificadorUsuario").val(),
				  	tipoSolicitud: $("#bTipoSolicitud").val(),
				  	estadoCertificado: $("#bEstadoCertificado").val(),
				  	idTipoProducto: $("#bTipoProducto").val(),
				  	idSubtipoProducto: $("#bSubtipoProducto").val(),
				  	idProducto: $("#bProducto").val(),
				  	paisDestino: $("#bPaisDestino").val(),
				  	idTipoProducto: $("#bTipoProducto").val(),
				  	idSubtipoProducto: $("#bSubtipoProducto").val(),
				  	idProducto: $("#bProducto").val(),
				  	fechaInicio: $("#bFechaInicio").val(),
				    fechaFin: $("#bFechaFin").val(),
				    numeroCertificado: $("#bNumeroCertificado").val()
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
