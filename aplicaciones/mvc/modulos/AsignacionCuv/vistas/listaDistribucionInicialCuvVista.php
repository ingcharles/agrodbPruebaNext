<header>
    <nav><?php echo $this->panelBusquedaAdministrador;?></nav></br>
    <nav><?php echo $this->crearAccionBotones();?></nav>
</header>
<div id="paginacion" class="normal"></div>
<table id="tablaItems">
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Provincia</th>
            <th>Año</th>
            <th>CUV Inicio</th>
            <th>CUV Fin</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
$(document).ready(function() {

    <!-- Código JavaScript relacionado con Aumentar TODOS en los select-->
    // Agregar la opción "Todos" al principio del select de "Año"
    $('#anioFiltro').prepend('<option value="">Todos</option>');
    <!-- Código JavaScript FIN-->
    <!-- Código JavaScript relacionado con Aumentar TODOS en los select-->
    // Agregar la opción "Todos" al principio del select de "Provincia"
    $('#provinciaFiltro').prepend('<option value="">Todos</option>');
    <!-- Código JavaScript FIN-->

    construirPaginacion($("#paginacion"),
        <?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
    $("#listadoItems").removeClass("comunes");
});
$("#_eliminar").click(function() {
    if ($("#cantidadItemsSeleccionados").text() > 1) {
        alert('Por favor seleccione un registro a la vez');
        return false;
    }
});

$("#btnFiltrar").click(function(event) {
    event.preventDefault();
    $(".alertaCombo").removeClass("alertaCombo");
    fn_filtrar();
});

function fn_filtrar() {
    //debugger;
    var anio = $("#anioFiltro").val();
    var provincia = $("#provinciaFiltro").val();
    var url = "<?php echo URL ?>AsignacionCuv/DistribucionInicialCuv/filtroBuscar";
    var error = false;

    if (!error) {
        console.log("NO hay error");
        $("#paginacion").html("<div id='cargando'>Cargando...</div>");
        $.ajax({
            type: "POST",
            url: url,
            data: {
                idProvincia: provincia,
                anio: anio,
            },
            dataType: "json",
            success: function(response) {
                if (response.validacion == "Fallo") {
					$("#paginacion").html("");
					construirPaginacion($("#paginacion"),<?php print_r(json_encode($this->itemsFiltrados, JSON_UNESCAPED_UNICODE)); ?>);
                    mostrarMensaje(response.mensaje, "FALLO");
                } else if (response.validacion == "Exito") {
                    construirPaginacion($("#paginacion"), JSON.parse(response.resultado));
                    mostrarMensaje(response.mensaje, "Exito");
                    //console.log(response.resultado);
                }
            }
        });
    } else {
        console.log("Si hay error");
		mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
    }
}

$("#tablaItems").click(function() {});
</script>