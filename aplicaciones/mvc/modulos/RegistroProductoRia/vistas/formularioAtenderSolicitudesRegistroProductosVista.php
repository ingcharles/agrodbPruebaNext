<header>
    <h1><?php echo $this->accion; ?></h1>
</header>

<?php echo $this->datosGenerales; ?>

<?php echo $this->pestania; ?>

<?php echo $this->resultadoRevision; ?>

<form id='formularioAsignarRevisor'>

    <input type="hidden" id="solicitudes" name="solicitudes"
           value="<?php echo($_POST['id'] === '_asignar' ? $_POST['elementos'] : $_POST['id']); ?>">
    <div id="cargarMensajeTemporal"></div>
</form>
<script type="text/javascript">

    var numeroPestania = <?php echo json_encode($this->numeroPestania);?>;

    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
        construirAnimacion($(".pestania"), numeroPestania);
        acciones("#fProducto","#tPartidaArancelaria");
        acciones("#fProducto","#tFabricanteFormuladorProducto");
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
        var mensaje = '';

        $('#resuladoRevisionTecnica .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
                mensaje = 'Por favor revise los campos obligatorios.';
            }
        });

        if ($('#v_ruta_revisor').val()) {
            if ($('#ruta_revisor').val() == 0) {
                error = true;
                $('#v_ruta_revisor').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

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
            $("#estado").html(mensaje).addClass("alerta");
        }
    });

</script>
