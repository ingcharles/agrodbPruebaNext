<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

<?php
    echo $this->datosGenerales;
?>
<script type="text/javascript">
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
	 });

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
       		var respuesta = JSON.parse(ejecutarJson($("#formulario")).responseText);
	    } else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});
	
	$("#id_tipo_producto").change(function () {
    
    	$("#id_producto").attr("disabled", false);				
		$("#estado").html("").removeClass('alerta');	

    	let idTipoProducto = $("#id_tipo_producto option:selected").val();
    	
    	fn_limpiarCombo("id_producto");
    	
		if (idTipoProducto !== ""){    
    		 $.post("<?php echo URL ?>MovilizacionVegetal/ConfiguracionProductoCupo/obtenerSubtipoProductoPorIdTipoProducto",
                {
					idTipoProducto : idTipoProducto 			 		
                }, function (data) {                    
                    $("#id_subtipo_producto").html(data.resultado);                      
                }, 'json');
    	}
		
	});
	
	$("#id_subtipo_producto").change(function () {
    
    	$("#id_producto").attr("disabled", false);				
		$("#estado").html("").removeClass('alerta');	

    	let idSubtipoProducto = $("#id_subtipo_producto option:selected").val();
    	
    	fn_limpiarCombo("id_producto");
    	
		if (idSubtipoProducto !== ""){    
    		 $.post("<?php echo URL ?>MovilizacionVegetal/ConfiguracionProductoCupo/obtenerProductoPorIdSubtipoProducto",
                {
					idSubtipoProducto : idSubtipoProducto 			 		
                }, function (data) {    
                    $("#id_producto").html(data.resultado);                 
                }, 'json');
    	}
		
	});
	
	function fn_limpiarCombo(elemento){ 		
        $("#" + elemento).empty()
        $("#" + elemento).append('<option value="">Seleccione...</option>');
 	} 
</script>
