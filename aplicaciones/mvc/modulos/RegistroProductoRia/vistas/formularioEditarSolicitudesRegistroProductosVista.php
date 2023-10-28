<header>
    <h1><?php echo $this->accion; ?></h1>
</header>

<?php echo $this->datosGenerales; ?>

<?php echo $this->pestania; ?>

<script type="text/javascript">

	var numeroPestania = <?php echo json_encode($this->numeroPestania);?>;
	var tipoSolicitud = <?php echo json_encode($this->tipoSolicitud);?>;

    $(document).ready(function () {
        $("#partida_arancelaria").attr("data-inputmask", "'mask': '9999999999'")
        construirValidador();
        distribuirLineas();
        construirAnimacion($(".pestania"), numeroPestania);
        mostrarMensaje("", "");
        acciones("#fProducto","#tPartidaArancelaria");
        acciones("#fProducto","#tFabricanteFormuladorProducto");
    });

    $("#id_tipo_producto").change(function () {
        mostrarMensaje("", "EXITO");
        if ($("#id_tipo_producto").val() != '') {
            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/obtenerSubtipoProductoPorIdTipoProducto",
                {
                    id_tipo_producto: $("#id_tipo_producto").val(),
                    tipo_solicitud: $("#tipo_solicitud").val()

                }, function (data) {
                    if (data.estado === 'EXITO') {
                        $("#id_subtipo_producto").html(data.comboSubtipoProducto);
                        $("#nombre_tipo_producto").val($("#id_tipo_producto option:selected").text());
                    }
                }, 'json');
        } else {
            mostrarMensaje("Por favor seleccione un valor", "FALLO");
        }
    });

    $("#id_subtipo_producto").change(function () {
        if($("#tipo_solicitud").val() === 'fertilizantes' || $("#tipo_solicitud").val() === 'bioplaguicidas'){
            $("#nombre_subtipo_producto").val($("#id_subtipo_producto option:selected").text());
            return false;
        }
        mostrarMensaje("", "EXITO");
        $("#numero_registro").val('');
        if ($("#id_subtipo_producto").val() != '') {
            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/obtenerProductoPorIdSubtipoProducto",
                {
                    id_subtipo_producto: $("#id_subtipo_producto").val()

                }, function (data) {
                    if (data.estado === 'EXITO') {
                        $("#id_producto").html(data.comboProducto);
                        $("#nombre_subtipo_producto").val($("#id_subtipo_producto option:selected").text());
                    }
                }, 'json');
        } else {
            mostrarMensaje("Por favor seleccione un valor", "FALLO");
        }
    });

    $("#id_producto").change(function () {
        $("#numero_registro").val('');
        $("#nombre_comun").val($("#id_producto option:selected").text());
        $("#numero_registro").val($("#id_producto option:selected").attr("data-numeroregistro"));
        $("#nombre_categoria_toxicologica").val($("#id_producto option:selected").attr("data-categoriatoxicologica"));
    });

    $("#id_formulacion").change(function () {
        $("#nombre_formulacion").val($("#id_formulacion option:selected").text());
    });

    $("#productoSolicitud").submit(function (event) {
        event.preventDefault();
        var error = false;
        $(".alertaCombo").removeClass("alertaCombo");

        $('#productoSolicitud .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {
            var respuesta = JSON.parse(ejecutarJson($(this)).responseText);

            if (respuesta.estado === 'exito') {
                abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), "#listadoItems", true);
            } else {
                $("#estado").html(respuesta.mensaje).addClass("alerta");
            }
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

    ////////////////////////////////////////////////////////
    /////------------------Composición------------------////
    ////////////////////////////////////////////////////////

    $("#id_tipo_componente").change(function (event) {
        mostrarMensaje("", "EXITO");
        if ($("#id_tipo_componente").val() !== '') {
            $("#tipo_componente").val($("#id_tipo_componente option:selected").text());
        } else {
            mostrarMensaje("Por favor seleccione un valor", "FALLO");
        }
    });

    $("#id_ingrediente_activo").change(function (event) {
        mostrarMensaje("", "EXITO");
        if ($("#id_ingrediente_activo").val() !== '') {
            $("#ingrediente_activo").val($("#id_ingrediente_activo option:selected").text());
        } else {
            mostrarMensaje("Por favor seleccione un valor", "FALLO");
        }
    });

    $("#agregarComposicion").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fComposicionProducto .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/guardarDetalleSolicitud",
                {
                    id_solicitud_registro_producto: $("#id_solicitud_registro_producto").val(),
                    id_ingrediente_activo: $("#id_ingrediente_activo").val(),
                    ingrediente_activo: $("#ingrediente_activo").val(),
                    id_tipo_componente: $("#id_tipo_componente").val(),
                    tipo_componente: $("#tipo_componente").val(),
                    concentracion: $("#concentracion").val(),
                    unidad_medida: $("#unidad_medida").val(),
                    tipo: 'composicion',
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tComposicionProducto tbody").append(data.filaComposicionProducto);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

    //Funcion que elimina una fila del detalle de composicion producto
    function fn_eliminarComposicion(idComposicion) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/Composiciones/borrar",
            {
                elementos: idComposicion
            },
            function (data) {
                $("#fila" + idComposicion).remove();
            });
    }

    ////////////////////////////////////////////////////////
    /////------------------Fin composición--------------////
    ////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////
    /////------------------Cod Compl Supl---------------////
    ////////////////////////////////////////////////////////

    $("#agregarCodigoComplemenarioSuplementario").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fCodigoComplementarioSuplementarioProducto .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/guardarDetalleSolicitud",
                {
                    id_solicitud_registro_producto: $("#id_solicitud_registro_producto").val(),
                    codigo_complementario: $("#codigo_complementario").val(),
                    codigo_suplementario: $("#codigo_suplementario").val(),
                    tipo: 'codigoComplementarioSuplementario',
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tCodigoComplementarioSuplementarioProducto tbody").append(data.filaComposicionProducto);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

    //Funcion que elimina una fila del detalle de codigo complementario suplementario producto
    function fn_eliminarCodigoComplementarioSuplementario(idCodigoComplementarioSuplementario) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/CodigosComplementariosSuplementarios/borrar",
            {
                elementos: idCodigoComplementarioSuplementario
            },
            function (data) {
                $("#fila" + idCodigoComplementarioSuplementario).remove();
            });
    }

    ////////////////////////////////////////////////////////
    /////---------------Fin Cod Compl Supl--------------////
    ////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////
    /////------------------Presentacion------------------////
    ////////////////////////////////////////////////////////

    $("#agregarPresentacion").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fPresentacionProducto .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/guardarDetalleSolicitud",
                {
                    id_solicitud_registro_producto: $("#id_solicitud_registro_producto").val(),
                    presentacion: $("#presentacion").val(),
                    unidad_medida: $("#unidad_medida_presentacion").val(),
                    tipo: 'presentacion'
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        $("#tPresentacionProducto tbody").append(data.filaPresentacion);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

    //Funcion que elimina una fila del detalle de adicion presentacion
    function fn_eliminarPresentacion(idPresentacion) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/Presentaciones/borrar",
            {
                elementos: idPresentacion
            },
            function (data) {
                $("#fila" + idPresentacion).remove();
            });
    }

    ////////////////////////////////////////////////////////
    /////----------------Fin Presentaion----------------////
    ////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////
    /////----------Fabricante-formulador----------------////
    ////////////////////////////////////////////////////////

    $("#id_pais_origen").change(function (event) {
        mostrarMensaje("", "EXITO");
        if ($("#id_pais_origen").val() !== '') {
            $("#nombre_pais_origen").val($("#id_pais_origen option:selected").text());
        } else {
            mostrarMensaje("Por favor seleccione un valor", "FALLO");
        }
    });

    $("#agregarFabricanteFormulador").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fFabricanteFormuladorProducto .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/guardarDetalleSolicitud",
                {
                    id_solicitud_registro_producto: $("#id_solicitud_registro_producto").val(),
                    tipo: $("#tipo").val(),
                    nombre: $("#nombre_fabricante_formulador").val(),
                    id_pais_origen: $("#id_pais_origen").val(),
                    nombre_pais_origen: $("#nombre_pais_origen").val(),
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tFabricanteFormuladorProducto tbody").append(data.filaFabricanteFormuladorProducto);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

    //Funcion que elimina una fila del detalle de titularidad producto
    function fn_eliminarFabricanteFormulador(idFabricanteFormulador) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/FabricantesFormuladores/borrar",
            {
                elementos: idFabricanteFormulador
            },
            function (data) {
                $("#fila" + idFabricanteFormulador).remove();
            });
    }

    ////////////////////////////////////////////////////////
    /////----------Fin Fabricante formulador------------////
    ////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////
    /////--------------------Usos-----------------------////
    ////////////////////////////////////////////////////////

    $('#aplicado_a').change(function (event) {
        if ($("#aplicado_a option:selected").val() == "Instalacion") {
            $(".UsoInstalacion").show();
            $(".UsoProducto").hide();
            $("#instalacion").addClass('validacion');
            $("#instalacion_producto").removeClass('validacion');
        } else if ($("#aplicado_a option:selected").val() == "Producto") {
            $(".UsoInstalacion").hide();
            $(".UsoProducto").show();
            $("#instalacion_producto").addClass('validacion');
            $("#instalacion").removeClass('validacion');
        }

        $("#instalacion").val('');
        $("#id_uso_producto").val('');
        $("#instalacion_producto").val('');
        distribuirLineas();

    });

    $("#id_uso_producto").change(function (event) {
        mostrarMensaje("", "EXITO");
        if ($("#id_uso_producto option:selected").val() !== '') {
            $("#nombre_uso").val($("#id_uso_producto option:selected").text());
        } else {
            $("#nombre_uso").val("");
            mostrarMensaje("Por favor seleccione un valor", "FALLO");
        }
    });

    $("#agregarUso").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fUsoProducto .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/guardarDetalleSolicitud",
                {
                    id_solicitud_registro_producto: $("#id_solicitud_registro_producto").val(),
                    id_uso_producto: $("#id_uso_producto").val(),
                    nombre_uso: $("#nombre_uso").val(),
                    aplicado_a: $("#aplicado_a").val(),
                    instalacion: $("#instalacion").val(),
                    instalacion_producto: $("#instalacion_producto").val(),
                    tipo: 'uso'
                },

                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tUsoProducto tbody").append(data.filaUsoProducto);
                    }
                }, 'json');
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

    //Funcion que elimina una fila del detalle de usos
    function fn_eliminarUso(idUso) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/Usos/borrar",
            {
                elementos: idUso
            },
            function (data) {
                $("#fila" + idUso).remove();
            });
    }
    ////////////////////////////////////////////////////////
    /////---------------------Fin Usos------------------////
    ////////////////////////////////////////////////////////

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

    $("#finalizarSolicitud").submit(function (event) {
        event.preventDefault();
        var error = false;
        var mensaje = '';

        $('#finalizarSolicitud .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
                mensaje = 'Por favor revise los campos obligatorios.';
            }
        });

        if($('#archivo_ruta_composicion_vida_util').val()){
            if ($('#ruta_composicion_vida_util').val() == 0) {
                error = true;
                $('#archivo_ruta_composicion_vida_util').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_analisis_laboratorio').val()){
            if ($('#ruta_analisis_laboratorio').val() == 0) {
                error = true;
                $('#archivo_ruta_analisis_laboratorio').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_etiqueta').val()){
            if ($('#ruta_etiqueta').val() == 0) {
                error = true;
                $('#archivo_ruta_etiqueta').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_otros').val()){
            if ($('#ruta_otros').val() == 0) {
                error = true;
                $('#archivo_ruta_otros').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_declaracion_juramentada').val()){
            if ($('#ruta_declaracion_juramentada').val() == 0) {
                error = true;
                $('#archivo_ruta_declaracion_juramentada').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_envases_embalajes').val()){
            if ($('#ruta_envases_embalajes').val() == 0) {
                error = true;
                $('#archivo_ruta_envases_embalajes').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_analisis_composicion').val()){
            if ($('#ruta_analisis_composicion').val() == 0) {
                error = true;
                $('#archivo_ruta_analisis_composicion').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_etiqueta_aprobada').val()){
            if ($('#ruta_etiqueta_aprobada').val() == 0) {
                error = true;
                $('#archivo_ruta_etiqueta_aprobada').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_etiqueta_hoja_informativa').val()){
            if ($('#ruta_etiqueta_hoja_informativa').val() == 0) {
                error = true;
                $('#archivo_ruta_etiqueta_hoja_informativa').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_producto_formulado_terminado').val()){
            if ($('#ruta_producto_formulado_terminado').val() == 0) {
                error = true;
                $('#archivo_ruta_producto_formulado_terminado').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if($('#archivo_ruta_semioquimico').val()){
            if ($('#ruta_semioquimico').val() == 0) {
                error = true;
                $('#archivo_ruta_semioquimico').addClass("alertaCombo");
                mensaje = 'Por favor subir el archivo seleccionado';
            }
        }

        if (!error) {
            var respuesta = JSON.parse(ejecutarJson($(this)).responseText);

            if (respuesta.estado === 'exito') {
                $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
                abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), "#listadoItems", true);
            } else {
                $("#estado").html(respuesta.mensaje).addClass("alerta");
            }
        } else {
            $("#estado").html(mensaje).addClass("alerta");
        }
    });
    
    ///////////////////////
   	/////BIOPLAGUCIDAS/////
   	///////////////////////
   	
   	$("#id_categoria_toxicologica").change(function (event) {
   		$("#nombre_categoria_toxicologica").val($("#id_categoria_toxicologica option:selected").text()); 	
   	});
   	
   	//Funcion que agrega partida arancelaria
   	$("#agregarPartidaArancelaria").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fPartidaArancelaria .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/guardarDetalleSolicitud",
                {
                    id_solicitud_registro_producto: $("#id_solicitud_registro_producto").val(),
                    partida_arancelaria: $("#partida_arancelaria").val(),
                    tipo: 'partidaarancelaria',
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tPartidaArancelaria tbody").append(data.filaPartidaArancelaria);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
    
    //Funcion que elimina una fila de partdas arencelarias
    function fn_eliminarPartidaArancelaria(idPartidaArancelaria) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/PartidasArancelariasPlaguicidasBio/borrar",
            {
                elementos: idPartidaArancelaria
            },
            function (data) {
                $("#fila" + idPartidaArancelaria).remove();
            });
    }
    
    $('#id_cultivo').change(function(event){
		if($("#cultivo option:selected").val() !== ""){
			$("#nombre_cultivo").val($("#id_cultivo option:selected").attr('data-nombre_comun'));
		}else{
			$("#nombre_cultivo").val("");
		}
	});

	$('#id_plaga').change(function(event){
		if($("#plaga option:selected").val() !== ""){
			$("#nombre_plaga").val($("#id_plaga option:selected").attr('data-nombre_comun'));
		}else{
			$("#nombre_plaga").val("");
		}
	});
	
	//Funcion que agrega un uso de plaguicida bio
	$("#agregarUsoPlaguicidaBio").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fUsoPlaguicidaBio .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/guardarDetalleSolicitud",
                {
                    id_solicitud_registro_producto: $("#id_solicitud_registro_producto").val(),
                    id_cultivo: $("#id_cultivo option:selected").val(),
                    cultivo_nombre_comun: $("#id_cultivo option:selected").attr('data-nombre_comun'),
                    cultivo_nombre_cientifico: $("#id_cultivo option:selected").text(),
                    id_plaga: $("#id_plaga option:selected").val(),
                    plaga_nombre_comun: $("#id_plaga option:selected").attr('data-nombre_comun'),
                    plaga_nombre_cientifico: $("#id_plaga option:selected").text(),
                    dosis: $("#dosis").val(),
                    unidad_dosis: $("#id_unidad_dosis option:selected").val(),
                    periodo_carencia: $("#periodo_carencia").val(),
                    gasto_agua: $("#gasto_agua").val(),
                    unidad_gasto_agua: $("#id_unidad_medida_agua option:selected").val(),
                    tipo: 'usoPlaguicidaBio'
                },

                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tUsoPlaguicidaBio tbody").append(data.filaUsoPlaguicidaBio);
                    }
                }, 'json');
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
    
    //Funcion que elimina una fila de usos plaguicida bio
    function fn_eliminarUsoPlaguicidaBio(idUso) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/UsosProductosPlaguicidasBio/borrar",
            {
                elementos: idUso
            },
            function (data) {
                $("#fila" + idUso).remove();
            });
    }
    
    //Funcion que agrega un ensayo de eficacia
	$("#agregarEnsayoEficacia").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fEnsayoEficacia .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/SolicitudesRegistroProductos/guardarDetalleSolicitud",
                {
                    id_solicitud_registro_producto: $("#id_solicitud_registro_producto").val(),
                    solicitud_ensayo_eficacia: $("#solicitud_ensayo_eficacia").val(),
                    tipo: 'ensayoEficacia'
                },

                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tEnsayoEficacia tbody").append(data.filaEnsayoEficacia);
                    }
                }, 'json');
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
    
    //Funcion que elimina una fila de ensayo de eficacia
    function fn_eliminarEnsayoEficacia(idEnsayoEficacia) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/EnsayosEficaciaPlaguicidasBio/borrar",
            {
                elementos: idEnsayoEficacia
            },
            function (data) {
                $("#fila" + idEnsayoEficacia).remove();
            });
    }
	
	$('#id_tipo_componente').change(function(event){    

		if(tipoSolicitud == "bioplaguicidas"){

            let tipoComposicion = $("#id_tipo_componente option:selected").text();
            
            if (id_tipo_componente !== ""){    
        		 $.post("<?php echo URL ?>RegistroProductoRia/Composiciones/obtenerNombreTipoComposicion",
                    {
    			 		tipoComposicion : tipoComposicion
                    }, function (data) {    
                        if(data.validacion == 'Exito'){
                        	$("#id_ingrediente_activo").html(data.resultado);
    	                }else{        	                    
    	                    mostrarMensaje(data.mensaje, "FALLO");
    	                }	                       
                    }, 'json');
        	}
    	
    	}
        
	});

	$("#pago_ensayo_eficacia").click(function (event){    	   
        if($('#pago_ensayo_eficacia').prop('checked')){
        	$('#requiere_descuento').removeAttr("checked");
        	$('#requiere_descuento').prop("disabled", true);
        }else{
        	$('#requiere_descuento').prop("disabled", false);
        }    
    });
	
</script>
