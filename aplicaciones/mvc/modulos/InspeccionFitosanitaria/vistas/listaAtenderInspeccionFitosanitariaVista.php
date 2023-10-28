<header>
	<nav><?php echo $this->panelBusqueda;?></nav><br>
	<nav><?php echo $this->crearAccionBotones();?></nav>
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
	<thead>
		<tr>
			<th>#</th>
			<th>Número solicitud</th>
			<th>Solicitante</th>
			<th>Estado</th>
			<th>País destino</th>
			<th>Provincia</th>
			<th>Fecha</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes"); 
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí registro para editar.</div>');
	});
		
	$("#btnFiltrar").click(function () {
        fn_filtrar();
    });

    function fn_filtrar() {
        $("#paginacion").html("<div id='cargando'>Cargando...</div>");
        $.post("<?php echo URL ?>InspeccionFitosanitaria/RevisionInspeccionFitosanitaria/listarAtenderSolicitudesInspeccionFitosanitaria",
            {
                b_id_pais_destino: $("#b_id_pais_destino").val(),
                b_numero_solicitud: $("#b_numero_solicitud").val(),
                b_producto: $("#b_producto").val(),
                b_fecha_inicio: $("#b_fecha_inicio").val(),
                b_fecha_fin: $("#b_fecha_fin").val()
            },
            function (data) {
                if (data.estado == 'EXITO') {
                    construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
                    mostrarMensaje('', "EXITO");
                } else {
                    construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
                    mostrarMensaje(data.mensaje, "FALLO");
                }
            }, 'json');
    }

    $("#b_fecha_inicio").datepicker({
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#b_fecha_inicio').datepicker('getDate')); 
        	fecha.setDate(fecha.getDate()+30);	 
      		$('#b_fecha_fin').datepicker('option', 'minDate', $("#b_fecha_inicio" ).val());
      		$('#b_fecha_fin').datepicker('option', 'maxDate', fecha);
      		$('#b_fecha_fin').datepicker('setDate', fecha);
	    }
	}).datepicker("setDate", new Date());

	$("#b_fecha_fin").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#b_fecha_inicio').datepicker('getDate')); 
	    }
	 }).datepicker("setDate", new Date());
	 
	 $("#b_tipo_producto").change(function () {
    
    	event.preventDefault();
		let idTipoProducto = $("#b_tipo_producto").val();
   	
    	if (idTipoProducto !== ""){    
    		 $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/buscarSubtipoProductoPorIdTipoProducto",
                {
			 		idTipoProducto : idTipoProducto		 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#b_subtipo_producto").html(data.resultado);                	
	                }else{
	                    mostrarMensaje(data.mensaje, "FALLO");
                    }	                       
                }, 'json');
    	}
    	
	});
	
	$("#b_subtipo_producto").change(function () {
    
    	event.preventDefault();
		let idSubtipoProducto = $("#b_subtipo_producto").val();
   	
    	if (idSubtipoProducto !== ""){    
    		 $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/buscarProductoPorIdSubtipoProducto",
                {
			 		idSubtipoProducto : idSubtipoProducto		 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#b_producto").html(data.resultado);                	
	                }else{
	                    mostrarMensaje(data.mensaje, "FALLO");
                    }	                       
                }, 'json');
    	}
    	
	});
	 
</script>
