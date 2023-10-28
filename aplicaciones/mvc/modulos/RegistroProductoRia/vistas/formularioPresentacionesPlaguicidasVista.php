<header>
    <h1><?php echo $this->accion; ?></h1>
</header>
	
	<?php echo $this->presentacionPlaguicida; ?>
		
<script type="text/javascript">
    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
    });

    $("#regresar").submit(function(event){
			event.stopImmediatePropagation();
			abrir($(this),event,false);
	});
		
	//Funcion que agrega presentacion
   	$("#agregarPresentacionPlaguicida").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fPresentacionPlaguicida .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/PresentacionesPlaguicidasBio/guardar",
                {
                    id_codigo_complementario_suplementario: $("#id_codigo_complementario_suplementario").val(),
                    presentacion: $("#presentacion").val(),
                    id_unidad: $("#id_unidad_medida option:selected").attr("data-idunidadmedida"),
                    unidad: $("#id_unidad_medida option:selected").val()
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tPresentacionPlaguicida tbody").append(data.filaPresentacionPlaguicida);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
    
    //Funcion que elimina una fila de presentacion
    function fn_eliminarPresentacionPlaguicida(idPresentacion) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/PresentacionesPlaguicidasBio/borrar",
            {
                elementos: idPresentacion
            },
            function (data) {
                $("#fila" + idPresentacion).remove();
            });
    }  
    
</script>