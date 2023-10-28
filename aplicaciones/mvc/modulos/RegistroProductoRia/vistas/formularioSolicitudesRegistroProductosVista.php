<header>
    <h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>RegistroProductoRia'
      data-opcion='SolicitudesRegistroProductos/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR"
      method="post">

    <?php echo $this->datosGenerales; ?>

    <fieldset>
        <legend>Solicitud</legend>

        <div data-linea="1">
            <label for="tipo_solicitud">Tipo de solicitud: </label>
            <select id="tipo_solicitud" name="tipo_solicitud" class="validacion">
                <option value="">Seleccione...</option>
                <option value="fertilizantes">Fertilizantes</option>
                <option value="bioplaguicidas">Bioplaguicidas</option>
                <option value="clonesfertilizantes">Clones fertilizantes</option>
                <option value="clonesplaguicidas">Clones plaguicidas</option>
            </select>
        </div>
    </fieldset>

    <div data-linea="1">
        <button type="submit" class="guardar">Guardar</button>
    </div>

    <input type="hidden" id="id" name="id" />

</form>
<script type="text/javascript">
    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
    });

    $("#formulario").submit(function (event) {
        event.preventDefault();
        var error = false;
        mostrarMensaje("", "")

        //rutaDeclaracionJuramentada
        if($("#ruta_declaracion_juramentada").val() == 0 || $("#ruta_declaracion_juramentada").val() == ""){
			error=true;
			$('#archivo_ruta_declaracion_juramentada').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}else if ($("#ruta_declaracion_juramentada").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivo_ruta_declaracion_juramentada').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}

         //rutaEnvasesEmbalajes
         if($("#ruta_envases_embalajes").val() == 0 || $("#ruta_envases_embalajes").val() == ""){
			error=true;
			$('#archivo_ruta_envases_embalajes').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}else if ($("#ruta_envases_embalajes").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivo_ruta_envases_embalajes').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}

        //rutaetiquetas
        if($("#ruta_etiqueta").val() == 0 || $("#ruta_etiqueta").val() == ""){
			error=true;
			$('#archivo_ruta_etiqueta').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}else if ($("#ruta_etiqueta").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivo_ruta_etiqueta').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}

        //rutaAnalisisComposicion
          if($("#ruta_analisis_composicion").val() == 0 || $("#ruta_analisis_composicion").val() == ""){
			error=true;
			$('#archivo_ruta_analisis_composicion').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}else if ($("#ruta_analisis_composicion").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivo_ruta_analisis_composicion').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}

        //rutaOtros
        if($("#ruta_otros").val() == 0 || $("#ruta_otros").val() == ""){
			error=true;
			$('#archivo_ruta_otros').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}else if ($("#ruta_otros").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivo_ruta_otros').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}

        //rutaComposicionVidaUtil 
        if($("#ruta_composicion_vida_util").val() == 0 || $("#ruta_composicion_vida_util").val() == ""){
			error=true;
			$('#archivo_ruta_composicion_vida_util').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}else if ($("#ruta_composicion_vida_util").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivo_ruta_composicion_vida_util').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}

        //rutaAnalisisLaboratorio
        if($("#ruta_analisis_laboratorio").val() == 0 || $("#ruta_analisis_laboratorio").val() == ""){
			error=true;
			$('#archivo_ruta_analisis_laboratorio').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}else if ($("#ruta_analisis_laboratorio").val() == "No se cargó archivo. Extención incorrecta"){
			error=true;
			$('#archivo_ruta_analisis_laboratorio').addClass("alertaCombo");
			mostrarMensaje("El archivo no se cargo por favor intente nuevamente...!", "FALLO");			
		}


        $('#formulario .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {
            var respuesta = JSON.parse(ejecutarJson($(this)).responseText);

            if (respuesta.estado === 'exito'){
                abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
                $("#id").val(respuesta.contenido);
                $("#formulario").attr('data-opcion', 'SolicitudesRegistroProductos/editar');
                abrir($("#formulario"), event, false);
            }else {
                $("#estado").html(respuesta.mensaje).addClass("alerta");
            }
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
</script>
