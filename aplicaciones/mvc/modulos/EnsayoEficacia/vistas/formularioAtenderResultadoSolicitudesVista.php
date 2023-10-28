<header>
    <h1><?php echo $this->accion; ?></h1>
</header>

<?php echo $this->datosGenerales; ?>

<form id="resuladoRevisionResultado" data-rutaAplicacion="<?php echo URL_MVC_FOLDER; ?>EnsayoEficacia"
      data-opcion="RevisionSolicitudes/guardarProcesoRevisionResultado" data-destino="detalleItem"
      data-accionEnExito="ACTUALIZAR" method="post">
    <input type="hidden" id="id_solicitud" name="id_solicitud"
           value="<?php echo $this->modeloSolicitudes->getIdSolicitud(); ?>"/>
    <fieldset id="resuladoRevisionResultado">
        <legend>Resultado revisión técnica</legend>
        <div data-linea="1">
            <label>Resultado: </label>
            <select id="resultado" name="resultado" class="validacion">
                <option value="">Seleccione....</option>
                <option value="aprobado">Aprobar</option>
                <option value="subsanacionResultado">Subsanar</option>
                <option value="rechazado">Rechazar</option>
            </select>
        </div>
        <div data-linea="2" id="d_dirigido_a">
            <label>Dirigido a: </label>
            <select id="dirigido_a" name="dirigido_a">
                <option value="">Seleccione....</option>
                <option value="operador">Operador</option>
                <option value="organismo">Organismo de inspección</option>
                <option value="ambos">Ambos</option>
            </select>
        </div>
        <label>Observación: </label>
        <div data-linea="3">
            <textarea name="observacion" rows="3" maxlength="1000" class="validacion"></textarea>
        </div>

        <label for="ruta_informe_uno">Informe aprobado (1):</label>
        <div data-linea="4">
            <input type="hidden" class="rutaArchivo" id="ruta_informe_uno" name="ruta_informe_uno" value="0"/>
            <input type="file" class="archivo validacion" id="archivo_informe_uno" accept="application/pdf"/>
            <div class="estadoCarga">En espera de archivo... (Tamaño
                máximo <?php echo ini_get('upload_max_filesize'); ?>B)
            </div>
            <button type="button" class="subirArchivo adjunto" data-rutaCarga="<?php echo ENSAYO_EFICACIA_URL; ?>">Subir
                archivo
            </button>
        </div>

        <label for="ruta_informe_dos">Informe aprobado (2):</label>
        <div data-linea="5">
            <input type="hidden" class="rutaArchivo" id="ruta_informe_dos" name="ruta_informe_dos" value="0"/>
            <input type="file" class="archivo" id="archivo_ruta_informe_dos" accept="application/pdf"/>
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
        $('#d_dirigido_a').hide();
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

    $("#resuladoRevisionResultado").submit(function (event) {
        event.preventDefault();
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;
        var mensaje = '';

        $('#resuladoRevisionResultado .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
                mensaje = 'Por favor revise los campos obligatorios.';
            }
        });

        if($('#archivo_ruta_informe_dos').val()){
            if ($('#ruta_informe_dos').val() == 0) {
                error = true;
                $('#archivo_ruta_informe_dos').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_informe_uno').val()){
            if ($('#ruta_informe_uno').val() == 0) {
                error = true;
                $('#archivo_informe_uno').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if (!error) {
            $("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
            $("#guardarResultado").attr('disabled', 'disabled');
            setTimeout(function () {
                var respuesta = JSON.parse(ejecutarJson($("#resuladoRevisionResultado")).responseText);

                if (respuesta.estado == 'exito') {
                    $("#estado").html(respuesta.mensaje);
                    $("#_actualizar").click();
                    $("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí un item para revisarlo.</div>');
                }
                $("#cargarMensajeTemporal").html("");

            }, 1000);
        } else {
            $("#estado").html(mensaje).addClass("alerta");
        }
    });

    $("#resultado").change(function (event) {
        if ($("#resultado").val() == 'subsanacionResultado') {
            $("#dirigido_a").addClass('validacion');
            $("#d_dirigido_a").show();
        } else {
            $("#dirigido_a").removeClass('validacion');
            $("#d_dirigido_a").hide();
        }
    });

</script>
