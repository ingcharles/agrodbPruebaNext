<header>
	<nav>
		<th><label>Buscar Tema de Capacitación</label></th>
		<!-- imprime el cuadro de busqueda -->
		<?php echo $this->panelBusquedaAdministrador;?>
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
		<th>Tema de Capacitación</th>
		<th>Normativa</th>
		<th>Dirección</th>
		</tr></thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes"); });
		
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');


//Inicio funcion que activa el combo direccion
var combo = "<option>Seleccione....</option>";
$("#id_coordinacionBusqueda").change(function () {
	$("#id_direccionBusqueda").val('');
	$("#id_direccionBusqueda").attr('disabled', false);
});


//funcion de boton buscar del cuadro de filtro de busqueda
$("#btnFiltrar").click(function (event) {
	event.preventDefault();
	fn_filtrar();
});

//funcion que realiza la busqueda
function fn_filtrar() {

	
	event.preventDefault();
	fn_limpiar();

	var error = false;

	if($("#id_coordinacionBusqueda").val() == '' && $("#nombre_capacitacion").val() != '' && $("#id_direccionBusqueda").val() == ''){
		$("#id_coordinacionBusqueda").addClass("alertaCombo");
		$("#id_direccionBusqueda").addClass("alertaCombo");
		error = true;
	}

	if($("#id_coordinacionBusqueda").val() == ''){
		$("#id_coordinacionBusqueda").addClass("alertaCombo");
		error = true;
	}
	if($("#id_direccionBusqueda").val() == ''){
		$("#id_direccionBusqueda").addClass("alertaCombo");
		error = true;
	}
		
	if (!error) {
		$("#paginacion").html("<div id='cargando'>Cargando...</div>");
		  $.post("<?php echo URL ?>RegistroCapacitaciones/CursosCapacitaciones/listarCursoCapacitacionesFiltradas",
			{
			  nombre_capacitacion: $("#nombre_capacitacion").val(),
			  id_coordinacion: $("#id_coordinacionBusqueda option:selected").val(),
			  id_direccion: $("#id_direccionBusqueda option:selected").val(),
			},
			  function (data) {
				if (data.estado === 'FALLO') {
				mostrarMensaje(data.mensaje, "FALLO");
				} else {
					construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
				}
			}, 'json');
	} else {
		$("#estado").html();
		mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
	}		
}
//funcion que limpia el mensaje de la pantalla principal
function fn_limpiar() {
	$(".alertaCombo").removeClass("alertaCombo");
	$('#estado').html('');
}
</script>

