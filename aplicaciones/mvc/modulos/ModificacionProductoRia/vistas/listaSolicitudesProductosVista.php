<header>
    <nav><?php echo $this->panelBusqueda; ?></nav>
    <br/>
    <nav><?php echo $this->crearAccionBotones(); ?></nav>
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
    <thead>
    <tr>
        <th>#</th>
        <th>Solicitud</th>
        <th>Identificador</th>
        <th>Fecha</th>
        <th>Nombre producto</th>
        <th>Área</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    $(document).ready(function () {
        construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
        $("#listadoItems").removeClass("comunes");
        $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
    });

    $("#_eliminar").click(function () {
        if ($("#cantidadItemsSeleccionados").text() > 1) {
            alert('Por favor seleccione un registro a la vez');
            return false;
        }
        if ($("#cantidadItemsSeleccionados").text() == 0) {
            $("#detalleItem").html('<div class="mensajeInicial">Seleccione una solicitud y presione el botón Eliminar.</div>');
            return false;
        }
    });

    $("#btnFiltrar").click(function () {
        fn_filtrar();
        $("#numeroSolicitud").val("");
        $("#estadoSolicitud").val("");
        $("#fecha").val("");
    });

    //Función para filtrar
    function fn_filtrar() {
        $("#paginacion").html("<div id='cargando'>Cargando...</div>");
        $.post("<?php echo URL ?>ModificacionProductoRia/SolicitudesProductos/filtrarInformacion",
            {
                numeroSolicitud: $("#numeroSolicitud").val(),
                estadoSolicitud: $("#estadoSolicitud").val(),
                fecha: $("#fecha").val(),
                tipo: 'solicitudOperador'
            },
            function (data) {
                if (data.estado == 'EXITO') {
                    $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
                    construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
                    mostrarMensaje('', "EXITO");
                } else {
                    $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
                    construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
                    mostrarMensaje(data.mensaje, "FALLO");
                }
            }, 'json');
    }

    $("#fecha").datepicker({
        yearRange: "c:c",
        changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
    });
    $("#fecha").click(function () {
        $(this).val('');
    });
</script>
