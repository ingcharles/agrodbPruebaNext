<header>
	<h1>Reportes</h1>
</header>

<article id="0" class="item" data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>RegistroCapacitaciones' data-opcion='ReporteCapacitacion/listarReportegeneral' draggable="true"
	ondragstart="drag(event)" data-destino="listadoItems">
	<span>Reporte General</span>
</article>

<article id="1" class="item" data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>RegistroCapacitaciones' data-opcion='ReporteCapacitacion/listarReporteProvincia' draggable="true"
	ondragstart="drag(event)" data-destino="listadoItems">
	<span>Reporte de Provincia</span>
</article>



<script>
	$(document).ready(function(){
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un ítem para revisarlo.</div>');
		$("#listadoItems").addClass("comunes");
	});
</script>
