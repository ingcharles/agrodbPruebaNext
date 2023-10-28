<header>
    <h1><?php echo $this->accion; ?></h1>
</header>

<?php echo $this->datosGenerales; ?>

<form id="resuladoRevisionTecnica" data-rutaAplicacion="<?php echo URL_MVC_FOLDER; ?>EnsayoEficacia"
      data-opcion="RevisionSolicitudes/guardarProcesoRevisionTecnica" data-destino="detalleItem"
      data-accionEnExito="ACTUALIZAR" method="post">
    <input type="hidden" id="id_solicitud" name="id_solicitud"
           value="<?php echo $this->modeloSolicitudes->getIdSolicitud(); ?>"/>
    <fieldset id="fResuladoRevisionTecnica">
        <legend>Resultado revisión técnica</legend>
        <div data-linea="3">
            <label>Resultado: </label>
            <select id="resultado" name="resultado" class="validacion">
                <option value="">Seleccione....</option>
                <option value="organismoInspeccion">Aprobar</option>
                <option value="subsanacion">Subsanar</option>
                <option value="rechazado">Rechazar</option>
            </select>
        </div>
        <label>Observación: </label>
        <div data-linea="24">
            <textarea name="observacion" rows="3" maxlength="1000" class="validacion"></textarea>
        </div>
        <label>Adjunto: </label>
        <div data-linea="5">
            <input type="hidden" class="rutaArchivo" id="informeRevision" name="informeRevision" value="0"/>
            <input type="file" class="archivo" id="vInforme" accept="application/pdf"/>
            <div class="estadoCarga">En espera de archivo... (Tamaño
                máximo <?php echo ini_get('upload_max_filesize'); ?>B)
            </div>
            <button type="button" class="subirArchivo adjunto" data-rutaCarga="<?php echo ENSAYO_EFICACIA_URL; ?>">Subir
                archivo
            </button>
        </div>
    </fieldset>

    <div data-linea="6">
        <button id="guardarResultado" type="submit" class="guardar">Enviar resultado</button>
    </div>
</form>
<script type="text/javascript">

    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
    });

    $('button.subirArchivo').click(function (event) {
        var boton = $(this);
        var tipo_archivo = boton.parent().find(".rutaArchivo").attr("id");
        var nombre_archivo = tipo_archivo + "<?php echo '_' . (md5(time())); ?>";
        var archivo = boton.parent().find(".archivo");
        var rutaArchivo = boton.parent().find(".rutaArchivo");
        var extension = archivo.val().split('.');
        var estado = boton.parent().find(".estadoCarga");

        if (extension[extension.length - 1].toUpperCase() == 'PDF') {
            subirArchivo(
                archivo
                , nombre_archivo
                , boton.attr("data-rutaCarga")
                , rutaArchivo
                , new carga(estado, archivo, boton)
            );
        } else {
            estado.html('Formato incorrecto, solo se admite archivos en formato PDF');
            archivo.val("0");
        }
    });

    $("#resuladoRevisionTecnica").submit(function (event) {
        event.preventDefault();
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#resuladoRevisionTecnica .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {
            $("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
            $("#guardarResultado").attr('disabled', 'disabled');
            setTimeout(function () {
                var respuesta = JSON.parse(ejecutarJson($("#resuladoRevisionTecnica")).responseText);

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
