<header>
<h1>Configuración producto/cupo</h1>
<nav><?php echo $this->crearAccionBotones();?></nav>
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
	<thead><tr>
		<th>#</th>
		<th>Tipo de producto</th>
		<th>Subtipo de producto</th>
		<th>Producto</th>
		<th>Control de cupo</th>
		<th>Fecha de creación</th>
		</tr></thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes");
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
	});
</script>
