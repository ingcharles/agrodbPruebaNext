<header>
	<nav><?php echo $this->panelBusquedaAdministrador?></nav>
	<nav><?php echo $this->crearAccionBotones();?>
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
	<thead><tr>
		<th>#</th>
		<th>Fecha</th>
		<th>Solicitante</th>
		<th>Provincia</th>
		<th>Cantidad</th>
		<th>Estado</th>
		</tr></thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes"); });
		$("#_eliminar").click(function () {
		if ($("#cantidadItemsSeleccionados").text() > 1) {
			alert('Por favor seleccione un registro a la vez');
			return false;
		}
	});

	$("#tablaItems").click(function () {});

	<!-- Código JavaScript relacionado con Fechas Formato-->
	var today = new Date();
	var startDate = new Date(today.getFullYear(), today.getMonth() - 3, today.getDate()); // Obtener la fecha de inicio permitida (3 meses antes de hoy)
	var endDate = new Date(today.getFullYear(), today.getMonth() + 3, today.getDate()); // Obtener la fecha de fin permitida (3 meses después de hoy)
	$("#fechaInicio").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		minDate: startDate, // La fecha mínima permitida es 3 meses antes de hoy
		maxDate: endDate, // La fecha máxima permitida es 3 meses después de hoy
		onSelect: function(dateText, inst) {
			var fecha = new Date($('#fechaInicio').datepicker('getDate'));
			// Realiza las operaciones o acciones necesarias con las fechas seleccionadas
		}
	}).datepicker("setDate", new Date());
	
	$("#fechaFin").datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		minDate: startDate, // La fecha mínima permitida es 3 meses antes de hoy
		maxDate: endDate, // La fecha máxima permitida es 3 meses después de hoy
		onSelect: function(dateText, inst) {
			var fecha = new Date($('#fechaFin').datepicker('getDate'));
			// Realiza las operaciones o acciones necesarias con las fechas seleccionadas
		}
	}).datepicker("setDate", new Date());
	<!-- FIN -->


	<!-- Código JavaScript relacionado con Boton Filtrar-->

	$("#btnFiltrar").click(function(event) {
		event.preventDefault();
		$(".alertaCombo").removeClass("alertaCombo");
		fn_filtrar();
	});

	<!-- FIN -->

	<!-- Código JavaScript relacionado con metodo fn_filtrar-->

	function fn_filtrar(){
		console.log('Filtrando');
		var fechainicio = $("#fechaInicio").val();
		var fechaFin = $("#fechaFin").val();
		var estado_solicitud = $("#slctEstadoRedist").val();
		var url = "<?php echo URL ?>AsignacionCuv/SolicitudRedistribucionCuv/filtroBuscarSolicitudRedistribucion";
		var error = false;
		if (!error) {
			$("#paginacion").html("<div id='cargando'>Cargando...</div>");
			$.ajax({
				type: "POST",
				url: url,
				data: {
					fechaInicio: fechainicio,
					fechaFin: fechaFin,
					estado_solicitud: estado_solicitud
				},
				dataType: "json",
				success: function (response) {
					if (response.validacion == "Fallo") {
						$("#paginacion").html("");
						construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
						mostrarMensaje(response.mensaje, "FALLO");						
					} else if (response.validacion == "Exito"){
						construirPaginacion($("#paginacion"), JSON.parse(response.resultado));
						mostrarMensaje(response.mensaje, "Exito");
					}
				}
			});
		} else {
			console.log("Si hay error");
			mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
		}
	}

	<!-- FIN -->
</script>
