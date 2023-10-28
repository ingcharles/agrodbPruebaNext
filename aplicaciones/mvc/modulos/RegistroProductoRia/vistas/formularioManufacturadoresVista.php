<header>
    <h1><?php echo $this->accion; ?></h1>
</header>
	
	<?php echo $this->manufacturador; ?>
		
<script type="text/javascript">
    $(document).ready(function () {
        construirValidador();
        distribuirLineas();
    });

    $("#regresar").submit(function(event){
			event.stopImmediatePropagation();
			abrir($(this),event,false);
	});
		
	//Funcion que agrega un manufacturador
   	$("#agregarManufacturador").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fManufacturador .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $("#estado").html("").removeClass('alerta');

            $.post("<?php echo URL ?>RegistroProductoRia/ManufacturadoresPlaguicidasBio/guardar",
                {
                    id_fabricante_formulador: $("#id_fabricante_formulador").val(),
                    manufacturador: $("#manufacturador").val(),
                    id_pais_origen: $("#pais_origen option:selected").val(),
                    pais_origen: $("#pais_origen option:selected").text()
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");
                        $("#tManufacturador tbody").append(data.filaManufacturador);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
    
    //Funcion que elimina una fila de manufacturador
    function fn_eliminarManufacturador(idManufacturador) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>RegistroProductoRia/ManufacturadoresPlaguicidasBio/borrar",
            {
                elementos: idManufacturador
            },
            function (data) {
                $("#fila" + idManufacturador).remove();
            });
    }  
    
</script>