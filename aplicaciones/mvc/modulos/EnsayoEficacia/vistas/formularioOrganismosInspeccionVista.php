<header>
    <h1><?php echo $this->accion; ?></h1>
</header>

<?php echo $this->datosGenerales; ?>

<form id="asignarOrganismoInspeccion" data-rutaAplicacion="<?php echo URL_MVC_FOLDER; ?>EnsayoEficacia"
      data-opcion="OrganismosInspeccion/guardar" data-destino="detalleItem"
      data-accionEnExito="ACTUALIZAR" method="post">
    <input type="hidden" id="id_solicitud" name="id_solicitud"
           value="<?php echo $this->modeloSolicitudes->getIdSolicitud(); ?>"/>
    <fieldset id="fAsignarOrganismoInspeccion">
        <legend>Organismo de inspección</legend>
        <div data-linea="1">
            <label>Organismo:</label>
            <select style="width: 48%;" id="identificador_organismo_inspeccion" name="identificador_organismo_inspeccion" class="validacion">
                <option value="">Seleccione....</option>
                <?php echo $this->comboOrganismos; ?>
            </select>
        </div>
    </fieldset>

    <div data-linea="6">
        <button id="guardarResultado" type="submit" class="guardar">Guardar</button>
    </div>
</form>

<script type="text/javascript">

    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
    });

    $("#asignarOrganismoInspeccion").submit(function (event) {
        event.preventDefault();
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#asignarOrganismoInspeccion .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {
            $("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
            $("#guardarResultado").attr('disabled', 'disabled');
            setTimeout(function () {
                var respuesta = JSON.parse(ejecutarJson($("#asignarOrganismoInspeccion")).responseText);

                if (respuesta.estado == 'exito') {
                    $("#estado").html(respuesta.mensaje);
                    $("#_actualizar").click();
                    $("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un item para revisarlo.</div>');
                }
                $("#cargarMensajeTemporal").html("");

            }, 1000);
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
</script>
