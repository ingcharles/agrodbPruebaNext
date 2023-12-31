<header>
	<h1>Saldos</h1>

	<nav><?php echo $this->comboIdentificador; ?></nav>
	<div>
		<nav><?php echo $this->crearAccionBotones(); ?></nav>
	</div>
	

</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems" style="text-align: center;">
	<thead>
		<tr>
			<th>#</th>
			<th>Identificador</th>
			<th>Razón social</th>
			<th># Transacciones de saldo disponible</th>			
		</tr>
	</thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function() {
		construirPaginacion($("#paginacion"), <?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes");
	});

	$("#fechaInicio").datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: "0",
		onSelect: function(dateText, inst) {
			var fecha = new Date($('#fechaInicio').datepicker('getDate'));
			fecha.setDate(fecha.getDate() + 90);
			$('#fechaFin').datepicker('option', 'minDate', $("#fechaInicio").val());
			$('#fechaFin').datepicker('option', 'maxDate', fecha);
		}
	});

	$("#fechaFin").datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: "0",
		onSelect: function(dateText, inst) {
			var fecha = new Date($('#fechaInicio').datepicker('getDate'));
		}
	});

	$("#_eliminar").click(function() {
		if ($("#cantidadItemsSeleccionados").text() > 1) {
			alert('Por favor seleccione un registro a la vez');
			return false;
		}
	});

	//Cuando se presiona en Filtrar lista, debe cargar los datos
	$("#btnFiltrar").click(function() {
		fn_filtrar();
	});

	// Función para filtrar
	function fn_filtrar() {
		$(".alertaCombo").removeClass("alertaCombo");
		mostrarMensaje("", "EXITO");
		var error = false;

		if (!$.trim($("#fechaInicio").val()) || !esCampoValido("#fechaInicio")) {
			error = true;
			$("#fechaInicio").addClass("alertaCombo");
		}

		if (!$.trim($("#fechaFin").val()) || !esCampoValido("#fechaFin")) {
			error = true;
			$("#fechaFin").addClass("alertaCombo");
		}

		if (!error) {
			$("#paginacion").html("<div id='cargando'>Cargando...</div>");
			$.post("<?php echo URL ?>Financiero/Saldos/listarSaldoUsuario/interno", {
					identificador: $("#identificadorFiltro").val(),
					fechaInicio: $("#fechaInicio").val(),
                    fechaFin: $("#fechaFin").val()
				},
				function(data) {
					construirPaginacion($("#paginacion"), JSON.parse(data));
				});
		} else {
			mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
		}
	}

	//$("#tablaItems").click(function () {});
</script>