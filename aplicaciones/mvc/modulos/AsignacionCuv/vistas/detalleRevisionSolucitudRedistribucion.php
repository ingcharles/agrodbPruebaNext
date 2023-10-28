<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>AsignacionCuv' 
    data-opcion='SolicitudRedistribucionCuv/enviarRedistribucion' data-destino="detalleItem" method="post">
	<input type="hidden" name="id_solicitud_redistribucion_cuv" id="id_solicitud_redistribucion_cuv" value ="<?php echo $this->modeloSolicitudRedistribucionCuv->getIdSolicitudRedistribucionCuv() ?>">
    <fieldset>
		<legend>Detalle Solicitud de Redistribución</legend>	
    <div data-linea="1">
        <label for="fecha_redistribucion">Fecha:</label>
        <input type="text" id="fecha_redistribucion" name="fecha_redistribucion"
                value="<?php echo date('d-m-Y', strtotime($this->modeloSolicitudRedistribucionCuv->getFechaCreacion()))?>"/>
	</div>
    <div data-linea="2">
        <label for="tecnicoProvincia">Técnico de Solicitante:</label>
        <input type="text" id="tecnicoProvincia" name="tecnicoProvincia"
                value="<?php echo $this->modeloSolicitudRedistribucionCuv->getTecnicoProvincia(); ?>"/>
	</div>
    <div data-linea="3">
        <label for="provinciaDestino">Provincia Solicitante:</label>
        <input type="text" id="provinciaDestino" name="provinciaDestino"
                value="<?php echo $this->modeloSolicitudRedistribucionCuv->getProvinciaDestino(); ?>"/>
	</div>
    <div data-linea="4">
        <label for="cantidadSolicitada">Cantidad Solicitada:</label>
        <input type="text" id="cantidadSolicitada" name="cantidadSolicitada"
                value="<?php echo $this->modeloSolicitudRedistribucionCuv->getCantidadSolicitada(); ?>"/>
	</div>
    </fieldset >
	<fieldset>
		<legend>Detalle Redistribución</legend>
		<div data-linea="4">
        <label for="provinciaOrigen">Provincia Origen:</label>
        <input type="text" id="provinciaOrigen" name="provinciaOrigen"
                value="<?php echo $this->modeloSolicitudRedistribucionCuv->getProvinciaOrigen(); ?>"/>
		</div>
		<div data-linea="5">
        <label for="cantidad_reasignada">Cantidad a Reasignar:</label>
        <input type="text" id="cantidad_reasignada" name="cantidad_reasignada"
                value="<?php echo $this->modeloRedistribucionCuv['cantidad_reasignada']; ?>"/>
		</div>
		<div data-linea="7">
        <label for="codigo_cuv_inicio">Serie Inicio::</label>
        <input type="text" id="codigo_cuv_inicio" name="codigo_cuv_inicio"
                value="<?php echo $this->modeloRedistribucionCuv['codigo_cuv_inicio']; ?>"/>
		</div>
		<div data-linea="7">
        <label for="codigo_cuv_fin">Serie Fin:</label>
        <input type="text" id="codigo_cuv_fin" name="codigo_cuv_fin"
                value="<?php echo $this->modeloRedistribucionCuv['codigo_cuv_fin']; ?>"/>
		</div>
		<div data-linea="8">
        <label for="observaciones">Observaciones:</label>
        <input type="text" id="observaciones" name="observaciones"
                value="<?php echo $this->modeloSolicitudRedistribucionCuv->getObservaciones(); ?>"/>
		</div>
		<div data-linea="20" style="text-align:center;width:100%">
		<button type="submit">Enviar</button>
		</div>
	</fieldset >
</form>

<script type ="text/javascript">
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
		var elementosDeshabilitar = ['#fecha_redistribucion', '#tecnicoProvincia', '#provinciaDestino','#cantidadSolicitada'
	,'#provinciaOrigen','#cantidad_reasignada','#codigo_cuv_inicio','#codigo_cuv_fin','#observaciones'];
		elementosDeshabilitar.forEach(function(elemento) {
			$(elemento).on('mousedown', function(event) {
				event.preventDefault();
				this.blur();
				window.focus();
			});
		});
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