<header><nav><?php echo $this->crearAccionBotones();?></nav></header>
<table id="tablaItems">
	<thead><tr>
		<th>#</th>
		<th>Identificador</th>
		<th>Archivo .crt</th>
		<th>Caducidad</th>
		</tr></thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes"); 
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí registro para editar.</div>');
	});

	function fn_filtrar() {
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
	}

</script>
