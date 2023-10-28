<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>RegistroCapacitaciones' data-opcion='cursosimpartidos/recargar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
<?php echo $this->contenidoInformacionCapacitacion;?>
<?php echo $this->contenidoLugarCapacitacion;?>
<?php echo $this->contenidoPublicoMeta;?>
<?php echo $this->contenidoDetallePublico;?>
<?php echo $this->contenidoDatosCapacitador;?>
<?php echo $this->contenidoDatosGenerales;?>


</form >
<div id="cargarMensajeTemporal"></div>
<script type ="text/javascript">
	
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
	 });

	$("#formulario").submit(function (event) {
		event.preventDefault();
		var error = false;
		if (!error) {
			
			abrir($(this), event, false);
			abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
			
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});

	function eliminarCursoImpartido(codigoCursoImpartido){
		mostrarMensaje("", "");
		$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
				$.post("<?php echo URL ?>RegistroCapacitaciones/CursosImpartidos/eliminarCursoImpartido", 
					{
						id_curso_impartido :codigoCursoImpartido,
										
					}, function (data) {
				
					if (data.estado === 'EXITO') {
						abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
						mostrarMensaje(data.mensaje, data.estado);
						$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeOut();
					}
				},  'json');
		mostrarMensaje("", "");
			
	}
</script>
