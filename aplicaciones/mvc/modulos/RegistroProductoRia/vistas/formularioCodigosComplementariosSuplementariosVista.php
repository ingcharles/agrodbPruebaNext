<header>
    <h1><?php echo $this->accion; ?></h1>
</header>
	
	<?php echo $this->codigoComplementarioSuplementarioPlaguicida; ?>
		
<script type="text/javascript">
    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
        acciones("#fCodigoComplementarioSuplementarioPlaguicida","#tCodigoComplementarioSuplementarioPlaguicida");
    });

    $("#regresar").submit(function(event){
			event.stopImmediatePropagation();
			abrir($(this),event,false);
	});
		
	//Funcion que agrega codigo complementario suplementario
   	$("#agregarCodigoComplementarioSuplementarioPlaguicida").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fCodigoComplementarioSuplementarioPlaguicida .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/CodigosComplementariosSuplementariosPlaguicidasBio/guardar",
                {
                    id_solicitud_registro_producto: $("#id").val(),
                    id_partida_arancelaria: $("#id_partida_arancelaria").val(),
                    codigo_complementario: $("#codigo_complementario").val(),
                    codigo_suplementario: $("#codigo_suplementario").val()
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tCodigoComplementarioSuplementarioPlaguicida tbody").append(data.filaCodigoComplementarioSuplementarioPlaguicida);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
    
    //Funcion que elimina una fila de codigos complementarios suplementarios
    function fn_eliminarCodigoComplementarioSuplementarioPlaguicida(idCodigoComplementarioSuplementario) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/CodigosComplementariosSuplementariosPlaguicidasBio/borrar",
            {
                elementos: idCodigoComplementarioSuplementario
            },
            function (data) {
                $("#fila" + idCodigoComplementarioSuplementario).remove();
            });
    }
    
    
</script>