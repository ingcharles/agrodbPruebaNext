<header>
    <h1><?php echo $this->accion; ?></h1>
</header>

<?php echo $this->datosGenerales; ?>

<form id="resultadoEnsayoEficacia" data-rutaAplicacion="<?php echo URL_MVC_FOLDER; ?>EnsayoEficacia"
      data-opcion="ResultadosEnsayo/guardar" data-destino="detalleItem"
      data-accionEnExito="ACTUALIZAR" method="post">
    <input type="hidden" id="id_solicitud" name="id_solicitud"
           value="<?php echo $this->modeloSolicitudes->getIdSolicitud(); ?>"/>
    <fieldset id="fResultadoEnsayoEficacia">
        <legend>Resultados del Ensayo de Eficacia</legend>

        <label for="ruta_informe_uno">Informe de resultados (1):</label>
        <div data-linea="1">
            <input type="hidden" class="rutaArchivo" id="ruta_informe_uno" name="ruta_informe_uno" value="0"/>
            <input type="file" class="archivo validacion" id="archivo_informe_uno" accept="application/pdf"/>
            <div class="estadoCarga">En espera de archivo... (Tamaño
                máximo <?php echo ini_get('upload_max_filesize'); ?>B)
            </div>
            <button type="button" class="subirArchivo adjunto" data-rutaCarga="<?php echo ENSAYO_EFICACIA_URL; ?>">Subir
                archivo
            </button>
        </div>

        <label for="ruta_informe_dos">Informe de resultados (2):</label>
        <div data-linea="2">
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
        <button id="guardarResultado" type="submit" class="guardar">Guardar</button>
    </div>
</form>

<script type="text/javascript">

    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
    });

    $("#resultadoEnsayoEficacia").submit(function (event) {
        event.preventDefault();
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;
        var mensaje = '';

        $('#resultadoEnsayoEficacia .validacion').each(function (i, obj) {
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
                var respuesta = JSON.parse(ejecutarJson($("#resultadoEnsayoEficacia")).responseText);

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
</script>
