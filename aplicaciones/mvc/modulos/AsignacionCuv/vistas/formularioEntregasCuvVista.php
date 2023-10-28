<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' data-opcion='EntregasCuv/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<fieldset>
		<legend>EntregasCuv</legend>				

		<div data-linea="2">
			<label for="id_solicitud_asignacion_cuv">id_solicitud_asignacion_cuv</label>
			<select id="id_solicitud_asignacion_cuv" name="id_solicitud_asignacion_cuv" required="true">
				<option value=""> Seleccionar....</option >
				<?php
					//echo $this->combocomboid_solicitud_asignacion_cuv($this->modeloEntregasCuv->getIdSolicitudAsignacionCuv());
				?>
			</select>
		</div>				

		<div data-linea="3">
			<label for="codigo_cuv_inicio">codigo_cuv_inicio </label>
			<input type="text" id="codigo_cuv_inicio" name="codigo_cuv_inicio" value="<?php echo $this->modeloEntregasCuv->getCodigoCuvInicio(); ?>"
			placeholder="Rango inicial de cuv que pueden ser asignados" required maxlength="8" />
		</div>				

		<div data-linea="4">
			<label for="codigo_cuv_fin">codigo_cuv_fin </label>
			<input type="text" id="codigo_cuv_fin" name="codigo_cuv_fin" value="<?php echo $this->modeloEntregasCuv->getCodigoCuvFin(); ?>"
			placeholder="Rango final de cuv que pueden ser asignados" required maxlength="8" />
		</div>				

		<div data-linea="5">
			<label for="cantidad">cantidad </label>
			<input type="text" id="cantidad" name="cantidad" value="<?php echo $this->modeloEntregasCuv->getCantidad(); ?>"
			placeholder="Cantidad que se requiere asignar a cada provincia" required maxlength="8" />
		</div>

		<div data-linea="8">

			<input type="hidden" name="id_entregas_cuv" id="id_entregas_cuv" value ="<?php echo $this->modeloEntregasCuv->getIdEntregasCuv() ?>">

			<input type="hidden" name="estado" id="estado" value ="<?php echo $this->modeloEntregasCuv->getEstado() ?>">

			<input type="hidden" name="fecha_entrega" id="fecha_entrega" value ="<?php echo $this->modeloEntregasCuv->getFechaEntrega() ?>">
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
