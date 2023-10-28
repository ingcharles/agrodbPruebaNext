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
        <th>Núm de solicitud</th>
        <th>Tipo de solicitud</th>
        <th>Producto</th>
        <th>Estado</th>
        <th>Técnico</th>
        <th>Fecha aprox de atención</th>
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

    $("#btnFiltrar").click(function (event) {
        event.preventDefault();
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;
        var mensaje = '';

        $('#filtro .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
                mensaje = 'Por favor revise los campos obligatorios.';
            }
        });

        if (!error) {
            fn_filtrar();
            $("#nombreProducto").val("");
            $("#identificador").val("");
            $("#estadoSolicitud").val("");
            $("#fecha").val("");
        }else {
            $("#estado").html(mensaje).addClass("alerta");
        }
    });

    function fn_filtrar() {
        $("#paginacion").html("<div id='cargando'>Cargando...</div>");
        $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
        $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/filtrarSolicitudesRegistroProducto",
            {
                nombreProducto: $("#nombreProducto").val(),
                identificador: $("#identificador").val(),
                estadoSolicitud: $("#estadoSolicitud").val(),
                fecha: $("#fecha").val(),
                tipo: 'verSolicitud'
            },
            function (data) {
                if (data.estado == 'EXITO') {
                    construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
                    mostrarMensaje('', "EXITO");
                } else {
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
