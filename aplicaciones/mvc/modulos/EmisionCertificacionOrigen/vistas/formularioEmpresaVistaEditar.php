<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='editarEmpleadoEmpresa' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>EmisionCertificacionOrigen' data-opcion='empresa/activarInactivarEmpleadoEmpresa' data-destino="detalleItem" data-accionEnExito ="ACTUALIZAR" method="post">

	<?php echo $this->contenidoBusqueda;?>

</div>
</form >
<div id="cargarMensajeTemporal"></div>
<script type="text/javascript">			
    $(document).ready(function(){			
			
	});


    $("#editarEmpleadoEmpresa").submit(function(event){	
		
		$("#inactivar").hide();
		$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");

    	event.preventDefault();
    	$(".alertaCombo").removeClass("alertaCombo");
		var error = false;

		
		if (!error) {
			setTimeout(function(){
				$("#cargarMensajeTemporal").html("");
				JSON.parse(ejecutarJson($("#editarEmpleadoEmpresa")).responseText);
			}, 1000);
		} 
	});


    $("#buscarEmpleado").click(function() {
    	event.stopImmediatePropagation();
    	mostrarMensaje("", "");
    	$(".alertaCombo").removeClass("alertaCombo");
		var error = false;

		if ($("#identificadorEmpleado").val()=="" && $("#nombreEmpleado").val()=="" && ((($("#nombreEmpleado").val()).replace(/ /g,''))=='')){
			error = true;
			$("#identificadorEmpleado").addClass("alertaCombo");
			$("#nombreEmpleado").addClass("alertaCombo");
		}
		
		if ($("#nombreEmpleado").val()!=""  &&  ((($("#nombreEmpleado").val()).replace(/ /g,''))=='')){
			error = true;
			$("#nombreEmpleado").addClass("alertaCombo");
		}else if($("#nombreEmpleado").val()!="" && $("#nombreEmpleado").val().length < 3){
			error = true;
			$("#nombreEmpleado").addClass("alertaCombo");
		}
       
        if (!error){
            $.post("<?php echo URL ?>EmisionCertificacionOrigen/empresa/buscarEmpleados", 
                 	            {
                 			        identificadorEmpleado:$("#identificadorEmpleado").val(),
                 			        nombreEmpleado:$("#nombreEmpleado").val(),
                 	            }, function (data) {
                 	              	if (data.estado === 'EXITO') {
										
										$('#campoEmpleadoRol').empty();
										var combo = $('#campoEmpleadoRol');
										var datos = data.contenido;
											for (var i = 0; i < datos.length; i++) {
												
												combo.append('<option value="' + datos[i] + '">' +datos[i] + '</option>');
											}										
                 	                } else {
                 	                	
                 	                }
            }, 'json');
        }else{
			mostrarMensaje("Debe ingresar un parametro de busqueda..!", "FALLO");
		}
    });      
</script>