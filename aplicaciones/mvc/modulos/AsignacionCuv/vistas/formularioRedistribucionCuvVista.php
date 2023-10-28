<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' data-opcion='RedistribucionCuv/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<fieldset>
		<legend>RedistribucionCuv</legend>				

		<div data-linea="1">
			<label for="id_redistribucion_cuv">id_redistribucion_cuv </label>
			<input type="text" id="id_redistribucion_cuv" name="id_redistribucion_cuv" value="<?php echo $this->modeloRedistribucionCuv->getIdRedistribucionCuv(); ?>"
			placeholder="Llave principal de la tabla" required maxlength="8" />
		</div>				

		<div data-linea="2">
			<label for="id_solicitud_redistribucion_cuv">id_solicitud_redistribucion_cuv </label>
			<input type="text" id="id_solicitud_redistribucion_cuv" name="id_solicitud_redistribucion_cuv" value="<?php echo $this->modeloRedistribucionCuv->getIdSolicitudRedistribucionCuv(); ?>"
			placeholder="Llave foránea (redundante) de la tabla g_asignacion_cuv.solicitud_redistribucion_cuv(Origen)" required maxlength="8" />
		</div>				

		<div data-linea="3">
			<label for="codigo_cuv_inicio">codigo_cuv_inicio </label>
			<input type="text" id="codigo_cuv_inicio" name="codigo_cuv_inicio" value="<?php echo $this->modeloRedistribucionCuv->getCodigoCuvInicio(); ?>"
			placeholder="Rango inicial de cuv que pueden ser redistribuidos" required maxlength="8" />
		</div>				

		<div data-linea="4">
			<label for="codigo_cuv_fin">codigo_cuv_fin </label>
			<input type="text" id="codigo_cuv_fin" name="codigo_cuv_fin" value="<?php echo $this->modeloRedistribucionCuv->getCodigoCuvFin(); ?>"
			placeholder="Rango final de cuv que pueden ser redistribuidos" required maxlength="8" />
		</div>				

		<div data-linea="5">
			<label for="estado">estado </label>
			<input type="text" id="estado" name="estado" value="<?php echo $this->modeloRedistribucionCuv->getEstado(); ?>"
			placeholder="Estado de la redistribucion" required maxlength="8" />
		</div>				

		<div data-linea="6">
			<label for="fecha_redistribucion">fecha_redistribucion </label>
			<input type="text" id="fecha_redistribucion" name="fecha_redistribucion" value="<?php echo $this->modeloRedistribucionCuv->getFechaRedistribucion(); ?>"
			placeholder="Fecha en la que se realiza la redistribución" required maxlength="8" />
		</div>

		<div data-linea="7">
			<button type="submit" class="guardar">Guardar</button>
		</div>
	</fieldset >
</form >
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
</script>
