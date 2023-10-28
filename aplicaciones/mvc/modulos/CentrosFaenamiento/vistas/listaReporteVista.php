<header>

    <nav>
		<th><label>Filtro para el reporte de CF.</label></th>
		<!-- imprime el cuadro de busqueda -->
		<?php echo $this->panelBusquedaAdministrador;?>
	</nav>
    
    
</header>



<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes"); });
		
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');

		$("#fechaInicio").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#fechaInicio').datepicker('getDate')); 
        	fecha.setMonth(fecha.getMonth()+3);	 
      		$('#fechaFin').datepicker('option', 'minDate', $("#fechaInicio" ).val());
      		$('#fechaFin').datepicker('option', 'maxDate', fecha);
      		$('#fechaFin').datepicker('setDate', fecha);
	    }
	}).datepicker("setDate", new Date());

	$("#fechaFin").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#fechaInicio').datepicker('getDate')); 
	    }
	}).datepicker("setDate", new Date());

	$("#idProvinciaFiltro").change(function () {
		$("#nombreProvincia").val($("#idProvinciaFiltro option:selected").text());
	});
</script>