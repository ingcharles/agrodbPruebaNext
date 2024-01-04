<header>
<h1>Asignación de cupo</h1>
<nav><?php echo $this->panelBusqueda?></nav>
<nav><?php echo $this->crearAccionBotones();?></nav></header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
	<thead><tr>
		<th>#</th>
		<th>Sitio</th>
		<th>Área</th>
		<th>Producto</th>
		<th>Lote</th>
		<th>Estimación de cosecha (Kilogramos)</th>
		<th>Cupo disponible (Kilogramos)</th>
		<th>Año</th>
		</tr></thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes");
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
	});
	
	$("#fechaInicio").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#fechaInicio').datepicker('getDate')); 
        	fecha.setDate(fecha.getDate()+90);	 
      		$('#fechaFin').datepicker('option', 'minDate', $("#fechaInicio" ).val());
      		$('#fechaFin').datepicker('option', 'maxDate', fecha);
      		$('#fechaFin').datepicker('setDate', fecha);
	    }
	}).datepicker("setDate", new Date());

	$("#fechaFin").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#fechaInicio').datepicker('getDate')); 
	    }
	}).datepicker("setDate", new Date());
		
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
			
			let provincia = "";
			
			if($("#provincia option:selected").val() != ""){
				provincia = $("#provincia option:selected").text();
			}
			
            $.post("<?php echo URL ?>MovilizacionVegetal/AsignacionCupo/listarAsignacionCupoFiltrado",
            {
              	identificacionOperador: $("#identificacionOperador").val(),
              	nombreOperador: $("#nombreOperador").val(),
              	provincia: provincia,
              	fechaInicio: $("#fechaInicio").val(),
              	fechaFin: $("#fechaFin").val()
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
</script>
