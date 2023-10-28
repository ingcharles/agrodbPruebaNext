<header>
    <h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>EnsayoEficacia'
      data-opcion='Solicitudes/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post">

    <input type="hidden" id="id_solicitud" name="id_solicitud"
           value="<?php echo $this->modeloSolicitudes->getIdSolicitud(); ?>"/>

    <?php echo $this->datosGenerales; ?>

    <fieldset>
        <legend>Datos de solicitud</legend>

        <div data-linea="1">
            <label for="tipo_solicitud">Tipo de solicitud: </label>
            <select id="tipo_solicitud" name="tipo_solicitud" class="validacion">
                <option value="">Seleccione...</option>
                <?php
                echo $this->comboTipoSolicitudEnsayoEficacia($this->modeloSolicitudes->getTipoSolicitud());
                ?>
            </select>
        </div>

        <div data-linea="2">
            <label for="tipo_producto">Tipo de producto: </label>
            <select id="tipo_producto" name="tipo_producto" class="validacion">
                <option value="">Seleccione...</option>
                <?php
                echo $this->comboTipoProductoEnsayoEficacia($this->modeloSolicitudes->getTipoProducto());
                ?>
            </select>
        </div>

        <div data-linea="3">
            <label for="producto">Producto: </label>
            <input type="text" id="producto" name="producto"
                   value="<?php echo $this->modeloSolicitudes->getProducto(); ?>"
                   placeholder="Nombre del producto" class="validacion" maxlength="128"/>
        </div>

        <div data-linea="4">
            <label for="titulo_ensayo">Título del ensayo: </label>
            <input type="text" id="titulo_ensayo" name="titulo_ensayo"
                   value="<?php echo $this->modeloSolicitudes->getTituloEnsayo(); ?>"
                   placeholder="Título del ensayo" class="validacion" maxlength="256"/>
        </div>

        <div data-linea="5">
            <label for="id_categoria_toxicologica">Categoría toxicológica: </label>
            <select id="id_categoria_toxicologica" name="id_categoria_toxicologica">
                <option value="">Seleccione...</option>
                <?php
                echo $this->comboCategoriaToxicologica('IAP', $this->modeloSolicitudes->getIdCategoriaToxicologica());
                ?>
            </select>
            <input
                    type="hidden"
                    name="nombre_categoria_toxicologica"
                    id="nombre_categoria_toxicologica"
                    value="<?php echo $this->modeloSolicitudes->getNombreCategoriaToxicologica(); ?>"
            />
        </div>

    </fieldset>

    <fieldset>
        <legend>Documentos requeridos</legend>

        <label for="ruta_ficha_tecnica">Ficha técnica:</label>
        <div data-linea="1">
            <input type="hidden" class="rutaArchivo" id="ruta_ficha_tecnica" name="ruta_ficha_tecnica" value="0"/>
            <input type="file" class="archivo validacion" id="archivo_ruta_ficha_tecnica" accept="application/pdf"/>
            <div class="estadoCarga">En espera de archivo... (Tamaño
                máximo <?php echo ini_get('upload_max_filesize'); ?>B)
            </div>
            <button type="button" class="subirArchivo adjunto" data-rutaCarga="<?php echo ENSAYO_EFICACIA_URL; ?>">Subir
                archivo
            </button>
        </div>

        <label for="ruta_permiso_importacion_muestra">Permiso de importación de muestra:</label>
        <div data-linea="2">
            <input type="hidden" class="rutaArchivo" id="ruta_permiso_importacion_muestra" name="ruta_permiso_importacion_muestra" value="0"/>
            <input type="file" class="archivo" id="archivo_ruta_permiso_importacion_muestra" accept="application/pdf"/>
            <div class="estadoCarga">En espera de archivo... (Tamaño
                máximo <?php echo ini_get('upload_max_filesize'); ?>B)
            </div>
            <button type="button" class="subirArchivo adjunto" data-rutaCarga="<?php echo ENSAYO_EFICACIA_URL; ?>">Subir
                archivo
            </button>
        </div>

        <label for="ruta_protocolo">Protocolo:</label>
        <div data-linea="3">
            <input type="hidden" class="rutaArchivo" id="ruta_protocolo" name="ruta_protocolo" value="0"/>
            <input type="file" class="archivo validacion" id="archivo_ruta_ruta_protocolo" accept="application/pdf"/>
            <div class="estadoCarga">En espera de archivo... (Tamaño
                máximo <?php echo ini_get('upload_max_filesize'); ?>B)
            </div>
            <button type="button" class="subirArchivo adjunto" data-rutaCarga="<?php echo ENSAYO_EFICACIA_URL; ?>">Subir
                archivo
            </button>
        </div>
    </fieldset>

    <fieldset id="datosAdicionales">
        <legend>Datos adicionales:</legend>
        <div data-linea="1">
           <label for="observacion">Observación:</label>
                <input type="text" id="observacion" name="observacion" value=""/>
        </div>
        <div data-linea="2">
            <label for="cultivo_menor">
                <input onchange="cultivoMenor()" type="checkbox" id=cultivo_menor name="cultivo_menor"/>
                Solicitud pertenece a cultivo menor
            </label>
        </div>
    </fieldset>
    <button type="button" class="editar" id="modificarSolicitud">Modificar</button>
    <button type="submit" class="guardar">Guardar</button>
</form>
<script type="text/javascript">

    var estado = <?php echo json_encode($this->estado); ?>;
    var tipoSolicitud = <?php echo json_encode($this->modeloSolicitudes->getTipoSolicitud()); ?>;

    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
        $("#modificarSolicitud").hide();

        if(estado == 'subsanacion' || estado == 'subsanacionResultado' || estado == 'organismoInspeccion'){
            $("#formulario select").attr("disabled", "disabled");
            $("#formulario input").attr("disabled", "disabled");
            $("#formulario .guardar").attr("disabled", "disabled");
            $("#modificarSolicitud").show();
            $("#datosAdicionales").hide();
        }
    });

    $("#modificarSolicitud").click(function () {
        $(this).attr("disabled", "disabled");
        $("#titulo_ensayo").removeAttr("disabled");
        $("#producto").removeAttr("disabled");
        $("#archivo_ruta_ficha_tecnica").removeAttr("disabled");
        $("#archivo_ruta_permiso_importacion_muestra").removeAttr("disabled");
        $("#archivo_ruta_ruta_protocolo").removeAttr("disabled");
        $("#formulario .guardar").removeAttr("disabled");
        $("#id_solicitud").removeAttr("disabled");
        $("#ruta_ficha_tecnica").removeAttr("disabled");
        $("#ruta_permiso_importacion_muestra").removeAttr("disabled");
        $("#ruta_protocolo").removeAttr("disabled");

        /*if(tipoSolicitud == 'ampliacion'){
            $("#archivo_ruta_permiso_importacion_muestra").removeClass('validacion');
        }*/
    });

    /*$("#tipo_solicitud").change(function (event) {
        if ($("#tipo_solicitud").val() != '' && $("#tipo_solicitud").val() == 'ampliacion') {
            $("#archivo_ruta_permiso_importacion_muestra").removeClass('validacion');
        } else {
            $("#archivo_ruta_permiso_importacion_muestra").addClass('validacion');
        }
    });*/

    $("#tipo_producto").change(function (event) {
        if ($("#tipo_producto").val() != '' && $("#tipo_producto").val() == 'quimico') {
            $("#id_categoria_toxicologica").addClass('validacion');
        } else {
            $("#id_categoria_toxicologica").removeClass('validacion');
        }
    });

    $("#id_categoria_toxicologica").change(function (event) {
        if ($("#id_categoria_toxicologica").val() != '') {
            $("#nombre_categoria_toxicologica").val($("#id_categoria_toxicologica option:selected").text());
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

    $("#formulario").submit(function (event) {
        fn_limpiar()
        event.preventDefault();
        var error = false;
        var mensaje = '';

        $('#formulario .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
                mensaje = 'Por favor revise los campos obligatorios.';
            }
        });

        if($('#archivo_ruta_ficha_tecnica').val()){
            if ($('#ruta_ficha_tecnica').val() == 0) {
                error = true;
                $('#archivo_ruta_ficha_tecnica').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_permiso_importacion_muestra').val()){
            if ($('#ruta_permiso_importacion_muestra').val() == 0) {
                error = true;
                $('#archivo_ruta_permiso_importacion_muestra').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_ruta_protocolo').val()){
            if ($('#ruta_protocolo').val() == 0) {
                error = true;
                $('#archivo_ruta_ruta_protocolo').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if (!error) {
            var respuesta = JSON.parse(ejecutarJson($(this)).responseText);

            if (respuesta.estado === 'exito') {
                abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), "#listadoItems", true);
            } else {
                $("#estado").html(respuesta.mensaje).addClass("alerta");
            }
        } else {
            $("#estado").html(mensaje).addClass("alerta");
        }
    });

    function cultivoMenor() {
        if ($("#cultivo_menor").prop('checked')) {
            $("#cultivo_menor").val(true);
        } else {
            $("#cultivo_menor").val(false);
        }
    }

    function fn_limpiar() {
        $(".alertaCombo").removeClass("alertaCombo");
        $('#estado').html('');
    }


</script>
