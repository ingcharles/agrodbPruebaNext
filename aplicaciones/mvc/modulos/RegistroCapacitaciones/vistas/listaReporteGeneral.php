<header>
	<nav><?php echo $this->panelBusquedaReporteGeneral;?></nav>
</header>

<script>

var combo = "<option>Seleccione....</option>";

	$(document).ready(function () {
		construirValidador();
	});
	
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
	
	// //Inicio funcion que activa el combo direcciones
	$("#idCoordinacion").change(function () {
		$("#idDireccion").val('');
		$("#idDireccion").attr('disabled', false);
		$("#idCursoCapacitacion").val('');
		$("#idCursoCapacitacion").attr('disabled', true);
	});

	//Inicio funcion que activa el combo direcciones
	$("#idDireccion").change(function () {
		$("#idCursoCapacitacion").val('');
		$("#idCursoCapacitacion").attr('disabled', false);
		if ($("#idDireccion option:selected").val() !== "") {

			fn_cargarTemasCursosXCoordinacionXDireccion();
		}
	});

	//funcion que carga los temas cursos dado un id de coordinacion
	function fn_cargarTemasCursosXCoordinacionXDireccion() {

		var id_coordinacion = $("#idCoordinacion option:selected").val();
		var id_direccion = $("#idDireccion option:selected").val();

		if (id_coordinacion !== '') {
			$.post("<?php echo URL ?>RegistroCapacitaciones/Base/cargarCursosCapacitacionesXIdCoordinacionXIdDireccion/", 
			{
				id_coordinacion : id_coordinacion,
				id_direccion : id_direccion,
			},
			function (data) {
				
				$("#idCursoCapacitacion").html(combo+data);
				$("#idCursoCapacitacion").removeAttr('disabled');
			});
		}else{
			$("#idCursoCapacitacion").val('');
			$("#idCursoCapacitacion").attr('disabled', 'disabled');
		}
	}

</script>
