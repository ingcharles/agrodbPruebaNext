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
            $("#numeroSolicitud").val("");
            $("#estadoSolicitud").val("");
            $("#fecha").val("");
            $("#identificador").val("");
            $("#idArea").val("");

        }else {
            $("#estado").html(mensaje).addClass("alerta");
        }
    });

    //Función para filtrar
    function fn_filtrar() {
        $("#paginacion").html("<div id='cargando'>Cargando...</div>");
        $.post("<?php echo URL ?>ModificacionProductoRia/SolicitudesProductos/filtrarInformacion",
            {
                idArea: $("#idArea").val(),
                numeroSolicitud: $("#numeroSolicitud").val(),
                estadoSolicitud: $("#estadoSolicitud").val(),
                identificador: $("#identificador").val(),
                fecha: $("#fecha").val(),
                tipo: 'verSolicitud'
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
