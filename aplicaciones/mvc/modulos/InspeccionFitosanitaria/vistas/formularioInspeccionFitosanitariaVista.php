<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<?php
echo $this->datosOperador;
?>
<form id='formulario'
	data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>InspeccionFitosanitaria'
	data-opcion='InspeccionFitosanitaria/guardar'
	data-destino="detalleItem" method="post">
    <?php
    echo $this->datosExportacion;
    ?>
    <div data-linea="1">
		<button type="submit" class="guardar">Guardar</button>
	</div>
	<input type="hidden" id="id" name="id" />
</form>
<script type="text/javascript">
	
    $(document).ready(function() {
        construirValidador();
        distribuirLineas();
        $("#cantidad_producto").numeric();
        $("#peso_producto").numeric();
        $("#duracion").numeric();
        $("#temperatura").numeric();
        $("#concentracion").numeric();
    });
    
    $("#id_puerto_embarque").change(function (event) {
    	$("#nombre_puerto_embarque").val($("#id_puerto_embarque option:selected").attr("data-nombre"));
    });
    
    $("#id_pais_destino").change(function (event) {
    	$("#nombre_pais_destino").val($("#id_pais_destino option:selected").text());
    });
        
    function adicionalProducto(id){
    	event.preventDefault();
		visualizar = $("#resultadoInformacionProducto"+id).css("display");
        if(visualizar == "table-row") {
        	$("#resultadoInformacionProducto"+id).fadeOut('fast',function() {
            	$("#resultadoInformacionProducto"+id).css("display", "none");
            });
        }else{
        	$("#resultadoInformacionProducto"+id).fadeIn('fast',function() {
        		$("#resultadoInformacionProducto"+id).css("display", "table-row");
            });
        }
	}
        
	$("#formulario").submit(function (event) {
        event.preventDefault();
        var error = false;

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
                $("#formulario").attr('data-opcion', 'InspeccionFitosanitaria/editar');
                abrir($("#formulario"), event, false);
            }else {
                $("#estado").html(respuesta.mensaje).addClass("alerta");
            }
        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

</script>
