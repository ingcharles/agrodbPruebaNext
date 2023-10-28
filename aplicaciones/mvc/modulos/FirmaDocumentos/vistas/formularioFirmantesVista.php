<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>FirmaDocumentos' data-opcion='firmantes/guardar' data-destino="detalleItem" data-accionEnExito="ACTUALIZAR" method="post" enctype= "multipart/form-data">
	<?php echo $this->datosFirma; ?>

	<!-- <div id="cargarMensajeTemporal"></div> -->
</form >

<script type ="text/javascript">
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
	 });

	$("#formulario").submit(function (event) {
		event.preventDefault();
		mostrarMensaje("","");
		var error = false;

		if($('#clave').val() == '' ){
			error = true;
			$('#clave').addClass("alertaCombo");
		}

		if($('#archivoFirma').val() == ''){
			error = true;
			$('#archivoFirma').addClass("alertaCombo");
		}

		if (!error) {
			var respuesta = JSON.parse(ejecutarJson($("#formulario")).responseText);
			if (respuesta.estado == 'guardar'){
	       		mostrarMensaje(respuesta.mensaje,"EXITO");
	       		fn_filtrar();
	       		const myTimeout = setTimeout(actualizar, 3000);
	        }
	        else if(respuesta.estado == 'actualizar'){
	        	mostrarMensaje(respuesta.mensaje,"EXITO");
	        	 fn_filtrar();
	        	const myTimeout = setTimeout(actualizar, 3000);
	        }
	        else if(respuesta.estado == 'errorFirma'){
	        	mostrarMensaje(respuesta.mensaje,"FALLO");
	        }
	        else if(respuesta.estado == 'caducidad'){
	        	mostrarMensaje(respuesta.mensaje,"FALLO");
	        }
	        else{
	        	mostrarMensaje(respuesta.mensaje,"FALLO");
	        }
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
			mostrarMensaje("Por favor ingrese todos los campos", "FALLO");
		}
	});

	function actualizar() {
	  $("#_actualizar").click();
	}
	
	//funcionq ue carga archivo adjunto asistencia
$("#btnFirma").click(function (event) {
	if($("#archivoFirma").val() == 0){
		error=true;
		$('#archivoFirma').addClass("alertaCombo");	
	}else{
		var boton = $(this);
		var nombre_archivo = "<?php echo ($_SESSION['usuario']); ?>";
		var archivo = boton.parent().find(".archivo");
		var rutaArchivo = boton.parent().find(".rutaArchivo");
		var extension = archivo.val().split('.');
		var estado = boton.parent().find(".estadoCarga");
	  
		if (extension[extension.length - 1].toUpperCase() == 'P12') {
	  
			subirArchivo(
				archivo
				, nombre_archivo
				, boton.attr("data-rutaCarga")
				, rutaArchivo
				, new carga(estado, archivo, boton)  
		    );
		} else {
			   estado.html('Formato incorrecto, solo se admite archivos en formato P12');
			   archivo.val("0");        
		}
	}

});

</script>
