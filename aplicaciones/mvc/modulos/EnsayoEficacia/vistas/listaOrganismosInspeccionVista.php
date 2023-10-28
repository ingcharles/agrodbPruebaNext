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
        <th>Tipo de solicitud</th>
        <th>Tipo de producto</th>
        <th>Producto</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    $(document).ready(function () {
        construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
        $("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí una solicitud para revisarla.</div>');
        $("#listadoItems").removeClass("comunes");
    });
    $("#_eliminar").click(function () {
        if ($("#cantidadItemsSeleccionados").text() > 1) {
            alert('Por favor seleccione un registro a la vez');
            return false;
        }
    });

    $("#btnFiltrar").click(function () {
        fn_filtrar();
        $("#nombreProducto").val("");
        $("#estadoSolicitud").val("");
        $("#fecha").val("");
    });

    function fn_filtrar() {
        $("#paginacion").html("<div id='cargando'>Cargando...</div>");
        $.post("<?php echo URL ?>EnsayoEficacia/OrganismosInspeccion/filtrarSolicitudes",
            {
                nombreProducto: $("#nombreProducto").val(),
                estadoSolicitud: $("#estadoSolicitud").val(),
                fecha: $("#fecha").val()
            },
            function (data) {
                if(data.estado == 'EXITO'){
                    $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
                    construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
                    mostrarMensaje('', "EXITO");
                }else{
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
