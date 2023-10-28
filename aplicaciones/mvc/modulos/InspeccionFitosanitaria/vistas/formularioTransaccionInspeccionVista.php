<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>InspeccionFitosanitaria' data-opcion='transaccioninspeccion/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<fieldset>
		<legend>TransaccionInspeccion</legend>				

		<div data-linea="1">
			<label for="id_transaccion_inspeccion">id_transaccion_inspeccion </label>
			<input type="text" id="id_transaccion_inspeccion" name="id_transaccion_inspeccion" value="<?php echo $this->modeloTransaccionInspeccion->getIdTransaccionInspeccion(); ?>"
			placeholder="" required maxlength="8" />
		</div>				

		<div data-linea="2">
			<label for="id_inspeccion_fitosanitaria">id_inspeccion_fitosanitaria </label>
			<input type="text" id="id_inspeccion_fitosanitaria" name="id_inspeccion_fitosanitaria" value="<?php echo $this->modeloTransaccionInspeccion->getIdInspeccionFitosanitaria(); ?>"
			placeholder="Identificador unico de la tabla g_inspecciones_fitosanitarias.inspeccion_fitosanitaria" required maxlength="8" />
		</div>				

		<div data-linea="3">
			<label for="id_producto_inspeccion_fitosanitaria">id_producto_inspeccion_fitosanitaria </label>
			<input type="text" id="id_producto_inspeccion_fitosanitaria" name="id_producto_inspeccion_fitosanitaria" value="<?php echo $this->modeloTransaccionInspeccion->getIdProductoInspeccionFitosanitaria(); ?>"
			placeholder="Identificador unico de la tabla g_inspecciones_fitosanitarias.productos_inspeccion_fitosanitaria" required maxlength="8" />
		</div>				

		<div data-linea="4">
			<label for="valor_egreso">valor_egreso </label>
			<input type="text" id="valor_egreso" name="valor_egreso" value="<?php echo $this->modeloTransaccionInspeccion->getValorEgreso(); ?>"
			placeholder="Campo que almacena el valor de egreso de la cantidad" required maxlength="8" />
		</div>				

		<div data-linea="5">
			<label for="valor_total">valor_total </label>
			<input type="text" id="valor_total" name="valor_total" value="<?php echo $this->modeloTransaccionInspeccion->getValorTotal(); ?>"
			placeholder="Campo que almacena el valor total de la cantidad" required maxlength="8" />
		</div>				

		<div data-linea="6">
			<label for="id_certificado_fitosanitario">id_certificado_fitosanitario </label>
			<input type="text" id="id_certificado_fitosanitario" name="id_certificado_fitosanitario" value="<?php echo $this->modeloTransaccionInspeccion->getIdCertificadoFitosanitario(); ?>"
			placeholder="Identificador unico de la tabla g_certificado_fitosanitario.certificado_fitosanitario" required maxlength="8" />
		</div>				

		<div data-linea="7">
			<label for="fecha_creacion">fecha_creacion </label>
			<input type="text" id="fecha_creacion" name="fecha_creacion" value="<?php echo $this->modeloTransaccionInspeccion->getFechaCreacion(); ?>"
			placeholder="Campo que almacena la fecha de creacion del registro" required maxlength="8" />
		</div>

		<div data-linea="8">
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
