<header>
	<nav><?php echo $this->panelBusquedaAdministrador?></nav></br>
</nav></header>


<script>
	$(document).ready(function () {
	});
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

</script>
