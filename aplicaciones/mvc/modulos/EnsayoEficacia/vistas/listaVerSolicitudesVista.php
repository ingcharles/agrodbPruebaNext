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
        <th>Tipo solicitud</th>
        <th>Tipo producto</th>
        <th>Producto</th>
        <th>Razón social</th>
        <th>Estado</th>
        <th>Técnico</th>
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
            $("#estadoSolicitud").val("");
            $("#fecha").val("");
            $("#identificador").val("");
        }else {
            $("#estado").html(mensaje).addClass("alerta");
        }
    });

    function fn_filtrar() {
        $("#paginacion").html("<div id='cargando'>Cargando...</div>");
        $.post("<?php echo URL ?>EnsayoEficacia/Solicitudes/filtrarSolicitudes",
            {
                nombreProducto: $("#nombreProducto").val(),
                estadoSolicitud: $("#estadoSolicitud").val(),
                fecha: $("#fecha").val(),
                identificador: $("#identificador").val(),
                tipo: 'verSolicitud'
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
