<header>
    <nav>
		<?php echo $this->crearAccionBotones();?>
	</nav>
    <br>
    <nav>
		<th><label>Consultar Certificación Sanitaria de Origen y Movilización</label></th>
		<!-- imprime el cuadro de busqueda -->
		<?php echo $this->panelBusquedaAdministrador;?>
	</nav>
    
    
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
	<thead><tr>
		<th>#</th>
		<th>F.Emisión</th>
		<th>Centro de Faenamiento</th>
		<th>N° Certificado</th>
		<th>Especie</th>
		</tr></thead>
	<tbody></tbody>
</table>

<script>
	$(document).ready(function () {
		construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
		$("#listadoItems").removeClass("comunes"); });
		
		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');

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

	if($("#numeroCertificado").val() == '' ){
		$("#numeroCertificado").addClass("alertaCombo");
		error = true;
    }
		
	if (!error) {
		  $.post("<?php echo URL ?>EmisionCertificacionOrigen/AnularCertificadoOrigen/listarCertificadoEmitidos",
			{
                provincia: $("#provincia").val(),
			    numero_certificado: $("#numeroCertificado").val(),
			},
			  function (data) {
				if (data.estado == 'FALLO') {
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