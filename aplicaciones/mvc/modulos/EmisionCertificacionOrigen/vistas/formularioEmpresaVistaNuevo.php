<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='nuevoEmpleadoEmpresa' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>EmisionCertificacionOrigen' data-opcion='empresa/guardar' data-destino="detalleItem" data-accionEnExito ="ACTUALIZAR" method="post">
    
    <fieldset id="busquedaEmpleado">
		<legend>Búsqueda de Empleados</legend>
		<div data-linea="1">
			<label>Identificación Empleado:</label>
			<input id="identificadorEmpleado"  type="text" placeholder="Ej: 9999999999"  maxlength="13" />
		</div>
		<div data-linea="1">
			<label>Nombres o Apellidos:</label>
			<input  id="nombreEmpleado"  type="text" placeholder="Ej: David"  maxlength="250"  />
		</div>
		
		<div data-linea="2" style="text-align: center">
			<button type="button" id="buscarEmpleado" name="buscarEmpleado" >Buscar empleado</button>
		</div>
	</fieldset>
	<fieldset>
		<legend>Agregar Empleados</legend>
		  <div data-linea="1" id="resultadoEmpleado" >				
				<label>Empleados: </label>
				<select id="campoEmpleadoRol" name="datosEmpleado">
					<option value="0">Seleccione...</option>
				</select>
							
		  </div>		   			   			   		   			   			
	</fieldset>	

    <div data-linea="4" class="editable">
    <button type="submit" class="guardar" id="guardar">Guardar</button>
</div>
</form >
<div id="cargarMensajeTemporal"></div>
<script type="text/javascript">			
    $(document).ready(function(){			
			
	});


    $("#nuevoEmpleadoEmpresa").submit(function(event){
    	event.preventDefault();
    	$(".alertaCombo").removeClass("alertaCombo");
		var error = false;
		mostrarMensaje("", "");
		if($("#empleado").val()==0 || $("#campoEmpleadoRol").val()==0){	
			 error = true;	
			 $("#empleado").addClass("alertaCombo");
			 $("#campoEmpleadoRol").addClass("alertaCombo");
			 $("#busquedaEmpleado").addClass("alertaCombo");	
			 $("#estado").html("Por favor seleccione el empleado.").addClass('alerta');
		}
		if (!error) {
			$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
			setTimeout(function(){
				JSON.parse(ejecutarJson($("#nuevoEmpleadoEmpresa")).responseText);
			}, 1000);

		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
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
                 	              	if (data.estado == 'EXITO') {
										$('#campoEmpleadoRol').empty();
										var combo = $('#campoEmpleadoRol');
										var datos = data.contenido;
											for (var i = 0; i < datos.length; i++) {
												combo.append('<option value="' + datos[i] + '">' +datos[i] + '</option>');
											}										
                 	                }else {
										mostrarMensaje(data.mensaje, "FALLO");
                 	                }
            }, 'json');
        }else{
			mostrarMensaje("Debe ingresar un parametro de busqueda..!", "FALLO");
		}
    });      
</script>