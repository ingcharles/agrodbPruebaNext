<header>
	<nav><?php echo $this->listaBotones;?></nav>
</header>

<div id="paginacion" class="normal"></div>

<table id="tablaItems">
	<thead>
		<tr>
			<th>#</th>
			<th>Grupo de Producto</th>
			<th>Proceso de Revisión</th>
			<th>Documento Anexo</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes");
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
	});

	function fn_filtrar() {
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
		$("#paginacion").html("<div id='cargando'>Cargando...</div>");
	    $.post("<?php echo URL ?>Catalogos/AnexosPecuarios/actualizarAnexosPecuarios",
	      	function (data) {
	            construirPaginacion($("#paginacion"), JSON.parse(data));
	        });
	}
</script>