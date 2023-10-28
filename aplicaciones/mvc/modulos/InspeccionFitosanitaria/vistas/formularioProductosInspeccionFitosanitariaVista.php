<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>InspeccionFitosanitaria' data-opcion='productosinspeccionfitosanitaria/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">
	<fieldset>
		<legend>ProductosInspeccionFitosanitaria</legend>				

		<div data-linea="1">
			<label for="id_producto_inspeccion_fitosanitaria">id_producto_inspeccion_fitosanitaria </label>
			<input type="text" id="id_producto_inspeccion_fitosanitaria" name="id_producto_inspeccion_fitosanitaria" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdProductoInspeccionFitosanitaria(); ?>"
			placeholder="Identificador unico de la tabla" required maxlength="8" />
		</div>				

		<div data-linea="2">
			<label for="id_inspeccion_fitosanitaria">id_inspeccion_fitosanitaria </label>
			<input type="text" id="id_inspeccion_fitosanitaria" name="id_inspeccion_fitosanitaria" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdInspeccionFitosanitaria(); ?>"
			placeholder="Identificador unico de la tabla g_inspecciones_fitosanitarias.inspeccion_fitosanitaria" required maxlength="8" />
		</div>				

		<div data-linea="3">
			<label for="id_area">id_area </label>
			<input type="text" id="id_area" name="id_area" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdArea(); ?>"
			placeholder="Identificador unico de la tabla g_operadores.areas. Identifica el id del area a inspeccionar" required maxlength="8" />
		</div>				

		<div data-linea="4">
			<label for="codigo_area">codigo_area </label>
			<input type="text" id="codigo_area" name="codigo_area" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getCodigoArea(); ?>"
			placeholder="Campo que almacena el codigo del area a inspeccionar" required maxlength="32" />
		</div>				

		<div data-linea="5">
			<label for="id_tipo_producto">id_tipo_producto </label>
			<input type="text" id="id_tipo_producto" name="id_tipo_producto" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdTipoProducto(); ?>"
			placeholder="Identificador unico de la tabla g_catalogos.tipos_productos. Identifica el tipo de producto a inspeccionar" required maxlength="8" />
		</div>				

		<div data-linea="6">
			<label for="id_subtipo_producto">id_subtipo_producto </label>
			<input type="text" id="id_subtipo_producto" name="id_subtipo_producto" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdSubtipoProducto(); ?>"
			placeholder="Identificador unico de la tabla g_catalogos.subtipos_productos. Identifica el tipo de producto a inspeccionar" required maxlength="8" />
		</div>				

		<div data-linea="7">
			<label for="id_producto">id_producto </label>
			<input type="text" id="id_producto" name="id_producto" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdProducto(); ?>"
			placeholder="Identificador unico de la tabla g_catalogos.productos. Identifica el producto a inspeccionar" required maxlength="8" />
		</div>				

		<div data-linea="8">
			<label for="cantidad_producto">cantidad_producto </label>
			<input type="text" id="cantidad_producto" name="cantidad_producto" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getCantidadProducto(); ?>"
			placeholder="Campo que almacena la cantidad de producto a inspeccionar" required maxlength="8" />
		</div>				

		<div data-linea="9">
			<label for="peso_producto">peso_producto </label>
			<input type="text" id="peso_producto" name="peso_producto" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getPesoProducto(); ?>"
			placeholder="Campo que almacena el peso del producto a inspeccionar" required maxlength="8" />
		</div>				

		<div data-linea="10">
			<label for="id_tipo_tratamiento">id_tipo_tratamiento </label>
			<input type="text" id="id_tipo_tratamiento" name="id_tipo_tratamiento" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdTipoTratamiento(); ?>"
			placeholder="Identificador unico de la tabla g_catalogos.tipos_tratamiento. Identifica el tipo de tratamiento del producto" required maxlength="8" />
		</div>				

		<div data-linea="11">
			<label for="id_tratamiento">id_tratamiento </label>
			<input type="text" id="id_tratamiento" name="id_tratamiento" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdTratamiento(); ?>"
			placeholder="Identificador unico de la tabla g_catalogos.tratamientos. Identifica el tratamiento del producto" required maxlength="8" />
		</div>				

		<div data-linea="12">
			<label for="id_duracion">id_duracion </label>
			<input type="text" id="id_duracion" name="id_duracion" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdDuracion(); ?>"
			placeholder="Identificador unico de la tabla g_catalogos.unidades_medidas." required maxlength="8" />
		</div>				

		<div data-linea="13">
			<label for="duracion">duracion </label>
			<input type="text" id="duracion" name="duracion" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getDuracion(); ?>"
			placeholder="Campo que almacena el valor de duracion" required maxlength="8" />
		</div>				

		<div data-linea="14">
			<label for="id_temperatura">id_temperatura </label>
			<input type="text" id="id_temperatura" name="id_temperatura" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdTemperatura(); ?>"
			placeholder="Identificador unico de la tabla g_catalogos.unidades_medidas." required maxlength="8" />
		</div>				

		<div data-linea="15">
			<label for="temperatura">temperatura </label>
			<input type="text" id="temperatura" name="temperatura" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getTemperatura(); ?>"
			placeholder="Campo que almacena el valor de temperatura" required maxlength="8" />
		</div>				

		<div data-linea="16">
			<label for="fecha_tratamiento">fecha_tratamiento </label>
			<input type="text" id="fecha_tratamiento" name="fecha_tratamiento" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getFechaTratamiento(); ?>"
			placeholder="Campo que almacena la fecha de tratamiento" required maxlength="8" />
		</div>				

		<div data-linea="17">
			<label for="producto_quimico">producto_quimico </label>
			<input type="text" id="producto_quimico" name="producto_quimico" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getProductoQuimico(); ?>"
			placeholder="Campo que almacena el producto quimico" required maxlength="8" />
		</div>				

		<div data-linea="18">
			<label for="id_concentracion">id_concentracion </label>
			<input type="text" id="id_concentracion" name="id_concentracion" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getIdConcentracion(); ?>"
			placeholder="Identificador unico de la tabla g_catalogos.unidades_medidas." required maxlength="8" />
		</div>				

		<div data-linea="19">
			<label for="concentracion">concentracion </label>
			<input type="text" id="concentracion" name="concentracion" value="<?php echo $this->modeloProductosInspeccionFitosanitaria->getConcentracion(); ?>"
			placeholder="Campo que almacena el valor de concentracion" required maxlength="8" />
		</div>

		<div data-linea="20">
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
