<header>
    <h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>RegistroProductoRia'
      data-opcion='SolicitudesRegistroProductos/eliminar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR"
      method="post">

    <?php echo $this->datosGenerales; ?>

    <input type="hidden" id="id_solicitud" name="id_solicitud"
           value="<?php echo $this->modeloSolicitudesRegistroProductos->getIdSolicitudRegistroProducto(); ?>"/>

    <div data-linea="1">
        <button type="submit" class="_eliminar">Eliminar</button>
    </div>

</form>
<script type="text/javascript">
    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
    });

    $("#formulario").submit(function (event) {
        event.preventDefault();

        var respuesta = JSON.parse(ejecutarJson($(this)).responseText);
        if (respuesta.estado === 'exito') {
            abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), "#listadoItems", true);
            $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
        } else {
            $("#estado").html(respuesta.mensaje).addClass("alerta");
        }
    });
</script>
