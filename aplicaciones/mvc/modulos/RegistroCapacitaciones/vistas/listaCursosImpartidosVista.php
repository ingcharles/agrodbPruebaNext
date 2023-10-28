<header>
<nav>
<th><label>Buscar Capacitación</label></th>
		<!-- imprime el cuadro de busqueda -->
		<?php echo $this->panelBusqueda;?>
		
	</nav>
	<br>
	<nav>
		<?php echo $this->crearAccionBotones();?>
	</nav>
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
	<thead><tr>
		<th>#</th>
		<th>Fecha</th>
		<th>Tema de Capacitación</th>
		<th>Dirección</th>
		<th>Tipo</th>
		<th>Total Asistentes</th>
		<th>Provincia</th>
		</tr></thead>
	<tbody></tbody>
</table>

<script>

	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes");
	 });

		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
	

$("#tablaItems").click(function () {});

$("#fechaInicioFiltro").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#fechaInicioFiltro').datepicker('getDate')); 
        	fecha.setMonth(fecha.getMonth()+3);	 
      		$('#fechaFinFiltro').datepicker('option', 'minDate', $("#fechaInicioFiltro" ).val());
      		$('#fechaFinFiltro').datepicker('option', 'maxDate', fecha);
      		$('#fechaFinFiltro').datepicker('setDate', fecha);
	    }
	}).datepicker("setDate", new Date());

	$("#fechaFinFiltro").datepicker({ 
	    changeMonth: true,
	    changeYear: true,
	    dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
	    onSelect: function(dateText, inst) {
        	var fecha=new Date($('#fechaInicioFiltro').datepicker('getDate')); 
	    }
	}).datepicker("setDate", new Date());


//funcion de boton buscar del cuadro de filtro de busqueda
$("#btnBuscar").click(function (event) {
	
	event.preventDefault();
	 fn_filtrar();
});

$("#fechaInicioFiltro").datepicker({
		dateFormat: 'yy-mm-dd'
	}
);
$("#fechaFinFiltro").datepicker({
		dateFormat: 'yy-mm-dd'
	}
);

function fn_filtrar() {

	event.preventDefault();

	var error = false;
	$(".alertaCombo").removeClass("alertaCombo");
		
	if($("#fechaInicioFiltro").val() ==''){
		$("#fechaInicioFiltro").addClass("alertaCombo");
		error = true;
		
	}

	if($("#fechaFinFiltro").val() ==''){
		$("#fechaFinFiltro").addClass("alertaCombo");
		error = true;
	}
	if($("#id_coordinacionBusqueda").val() ==''){
		$("#id_coordinacionBusqueda").addClass("alertaCombo");
		error = true;
	}
	if($("#id_direccionBusqueda").val() ==''){
		$("#id_direccionBusqueda").addClass("alertaCombo");
		error = true;
	}

	if($("#fechaInicioFiltro").val() !=''){
		if($("#fechaFinFiltro").val() ==''){
			$("#fechaFinFiltro").addClass("alertaCombo");
			error = true;
		}
	}

	if ((($("#fechaInicioFiltro").val() =='') && ($("#fechaInicioFiltro").val() =='')) && ($("#nombreCursoFiltro").val() =='')){
			error = true;
			$("#fechaInicioFiltro").addClass("alertaCombo");
			$("#fechaFinFiltro").addClass("alertaCombo");
	}

	if ((($("#fechaInicioFiltro").val() =='') && ($("#fechaInicioFiltro").val() =='')) && ($("#nombreCursoFiltro").val() !='')){	
			error = false;
			$(".alertaCombo").removeClass("alertaCombo");
	}

	if (!error) {
		  $.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/controldeDatosBusqueda",
			{
				fechaInicio : $("#fechaInicioFiltro").val(),
				fechaFin : $("#fechaFinFiltro").val(),
				coordinacion: $("#id_coordinacionBusqueda").val(),
				direccion: $("#id_direccionBusqueda").val(),
				nombreCurso: $("#nombreCursoFiltro").val(),
				provincia: $("#id_provincia option:selected").text(),
				
			},
			  function (data) {
				if (data.estado === 'FALLO') {
					mostrarMensaje(data.mensaje, "FALLO");
					construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
				} else {
					construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
					mostrarMensaje(data.mensaje, "Exito");
				}
			}, 'json');
			
	} else {
		$("#estado").html();
		mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
	}	
}


</script>
