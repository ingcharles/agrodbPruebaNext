<header>
	<h1>Reportes</h1>
</header>

<article id="0" class="item" data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' data-opcion='Reportes/reporteCuvsProvincia' draggable="true"
	ondragstart="drag(event)" data-destino="listadoItems">
	<span>Reporte CUVs en todas las provincias</span>
</article>

<article id="1" class="item" data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' data-opcion='Reportes/reporteOperadorCuvs' draggable="true"
	ondragstart="drag(event)" data-destino="listadoItems">
	<span>Reporte CUVs de todos los operadores</span>
</article>

<script>
	$(document).ready(function(){
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
		$("#listadoItems").addClass("comunes");
	});
</script>