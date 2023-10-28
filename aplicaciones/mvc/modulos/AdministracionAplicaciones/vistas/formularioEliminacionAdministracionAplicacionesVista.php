<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

<?php
    if($_POST['elementos'] != null){
        $informacionRegistro = explode('-', $_POST['elementos']);
        
        $idModulo = $informacionRegistro[0];
        $idPerfil = $informacionRegistro[1];
        $identificador = $informacionRegistro[2];
        
        $bandera = true;
    }else{
        $bandera = false;
        
        $idModulo = '';
        $idPerfil = '';
        $identificador = '';
    }    
?>
<form id="formularioAplicaciones" data-rutaAplicacion="<?php echo URL_MVC_FOLDER;?>AdministracionAplicaciones" data-opcion="AdministracionAplicaciones/borrar" data-destino="detalleItem" method="post" data-accionEnExito="ACTUALIZAR">
	<input type="hidden" id="identificadorUsuario" name="identificadorUsuario" value="<?php echo $identificador;?>" />
	<input type="hidden" id="idModulo" name="idModulo" value="<?php echo $idModulo;?>" />
	<input type="hidden" id="idPerfil" name="idPerfil" value="<?php echo $idPerfil;?>" />
	
    <fieldset>
	    <legend>Datos del Usuario</legend>
	    
	    <div data-linea="1">
	    	<label>Identificador: </label>
	    	<input type="text" id="identificadorUsuario" name="identificadorUsuario" value="<?php echo $identificador;?>" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="2">
	    	<label>Nombre: </label>
	    	<input type="text" id="nombreUsuario" name="nombreUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="3">
	    	<label>Módulo: </label>
	    	<input type="text" id="moduloUsuario" name="moduloUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="4">
	    	<label>Perfil: </label>
	    	<input type="text" id="perfilUsuario" name="perfilUsuario" readonly="readonly" />
	    </div>
	    

	</fieldset>
	
	<div data-linea="5">
		<button type="submit" class="guardar">Eliminar</button>
	</div>
	
</form>

<fieldset id="mensajeError">
	<legend>Error</legend>
	    
	    <div data-linea="1">
	    	<label>Debe seleccionar un usuario para poder continuar.... </label>
	    </div>
</fieldset>

<script type="text/javascript">
	var bandera = <?php echo json_encode($bandera); ?>;
	var identificador = <?php echo json_encode($identificador); ?>;
	var idModulo = <?php echo json_encode($idModulo); ?>;
	var idPerfil = <?php echo json_encode($idPerfil); ?>;
	
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
		$("#estado").html("");	
		
		if(bandera){
			fn_cargarDatosUsuarioForm();
			$("#formularioAplicaciones").show();
			$("#mensajeError").hide();
		}else{
			$("#formularioAplicaciones").hide();
			$("#mensajeError").show();
		}
	});

	//Mostrar los datos del Usuario
	function fn_cargarDatosUsuarioForm() {
        
        if (identificador != '') {
        	$.post("<?php echo URL ?>AdministracionAplicaciones/AdministracionAplicaciones/mostrarDatosUsuarioEliminacion/", 
			{
        		identificador : identificador,
        		idModulo : idModulo,
        		idPerfil : idPerfil
			},
            function (data) {
				if(data.validacion == "Fallo"){
	        		mostrarMensaje(data.resultado,"FALLO");    
	        		fn_limpiarDatosUsuario();   		
				}else{
					fn_cargarDatosUsuario(data);
				}
            }, 'json');
        }else{
        	$("#identificadorUsuario").val('');
        }
    }
    
  	//Función para mostrar los datos obtenidos del operador/asociación
    function fn_cargarDatosUsuario(data) {
    	$("#nombreUsuario").val(data.funcionario);
    	$("#moduloUsuario").val(data.nombre_aplicacion);    	
		$("#perfilUsuario").val(data.nombre_perfil);
    } 
    
    function fn_limpiarDatosUsuario() {
    	/*$("#nombreUsuario").val('');
    	$("#tipoContratoUsuario").val('');
    	$("#provinciaUsuario").val('');
    	$("#cantonUsuario").val('');
    	$("#oficinaUsuario").val('');
    	$("#gestionUsuario").val('');
    	$("#nombreAreaUsuario").val('');
    	$("#areaUsuario").val('');    	
		$("#areaResponsableUsuario").val('');
		$(".datosUsuario").hide();*/
    }
    
	$("#formularioAplicaciones").submit(function (event) {
		event.preventDefault();
		var error = false;

		if(!$.trim($("#identificadorUsuario").val())){
        	error = true;
        	$("#identificadorUsuario").addClass("alertaCombo");
		}
		
		if(!$.trim($("#idModulo").val())){
        	error = true;
        	$("#idModulo").addClass("alertaCombo");
		}
		
		if(!$.trim($("#idPerfil").val())){
        	error = true;
        	$("#idPerfil").addClass("alertaCombo");
		}
		
		if (!error) {
			var respuesta = JSON.parse(ejecutarJson($(this)).responseText);

			if (respuesta.estado == 'exito'){		
				$("#estado").html("Se han guardado los datos con éxito.").addClass("exito");
			}else{
				$("#estado").html(respuesta.mensaje).addClass("fallo");
			}
	       
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});
</script>