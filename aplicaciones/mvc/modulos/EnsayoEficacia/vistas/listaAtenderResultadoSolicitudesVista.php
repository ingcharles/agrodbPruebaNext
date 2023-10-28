<header>
    <nav><?php echo $this->panelBusqueda; ?></nav><br>
    <nav><?php echo $this->crearAccionBotones(); ?></nav>
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
    <thead>
    <tr>
        <th>#</th>
        <th>Número solicitud</th>
        <th>Tipo solicitud</th>
        <th>Tipo producto</th>
        <th>Producto</th>
        <th>Razón social</th>
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

    //Cuando se presiona en Filtrar lista, debe cargar los datos
    $("#btnFiltrar").click(function () {

        var error = false;
        $(".alertaCombo").removeClass("alertaCombo");
        mostrarMensaje("", "EXITO");

        if (!error) {
            fn_filtrar();
        }

    });

    function fn_filtrar() {

        $("#paginacion").html("<div id='cargando'>Cargando...</div>");
        $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');

        $.post("<?php echo URL ?>EnsayoEficacia/RevisionSolicitudes/listarSolicitudesResultadoPorAtender",
            {
                nombreProducto: $('#nombreProducto').val(),
                numeroSolicitud: $('#numeroSolicitud').val(),
                fecha: $('#fecha').val()
            },

            function (data) {
                if (data.estado === 'FALLO') {
                    construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
                    mostrarMensaje(data.mensaje, "FALLO");
                } else {
                    construirPaginacion($("#paginacion"), JSON.parse(data.contenido));
                }
            }, 'json');
    }
</script>
