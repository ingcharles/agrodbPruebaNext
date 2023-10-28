<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

	
	<div class="pestania">
		<form id='formularioDatosGenerales'
			data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>CertificadoFitosanitario'
			data-opcion='CertificadoFitosanitario/actualizarDatosCertificadoFitosanitario'
				data-destino="detalleItem" data-accionEnExito="ACTUALIZAR"
				method="post">
			<?php
			echo $this->datosGenerales;
			echo $this->datosFormaPago;
			?>			
		</form>
	</div>
	<div class="pestania">
		<?php		
		echo $this->datosPaisDestino;
		echo $this->datosProductos;
		echo $this->datosPuertosTransito;
		?>
		<form id='formularioEnviarSolicitud'
			data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>CertificadoFitosanitario'
			data-opcion='CertificadoFitosanitario/enviarSolicitud'
				data-destino="detalleItem" data-accionEnExito="ACTUALIZAR"
				method="post">
				<input type="hidden" name="id_certificado_fitosanitario" value="<?php echo $this->datosCertificadoFitosanitario->getIdCertificadoFitosanitario();?>" readonly="readonly" >
			<?php			
			echo $this->datosExportador;
			echo $this->datosRevisionDocumental;
			echo $this->datosDocumentosAdjuntos;
			?>
			<div id="cargarMensajeTemporal"></div>		
		</form>
	</div>
	
	
<script type="text/javascript">

	var idCertificadoFitosanitario = <?php echo json_encode($this->datosCertificadoFitosanitario->getIdCertificadoFitosanitario());?>;
	var idTipoProduccion = <?php echo json_encode($this->datosCertificadoFitosanitario->getIdTipoProduccion());?>;
	var tipoSolicitud = <?php echo json_encode($this->datosCertificadoFitosanitario->getTipoSolicitud());?>;

	$(document).ready(function() {
		var error = false;
		$("#estado").html("").removeClass('alerta');
		construirAnimacion($(".pestania"));		
		construirValidador();
		distribuirLineas();
        
        $("form").keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
    	});
	});	
	
	/////FORMATEAR CANTIDADES
	
    function formatearCantidadProducto(inputElement) {
        var valor = inputElement.value.replace(/[^\d.]/g, ''); // Elimina caracteres no numéricos ni puntos
        var partes = valor.split('.');
        
        if (partes.length > 1) {
            partes[0] = partes[0].substring(0, 7); // Limita a enterosMaximos enteros
            partes[1] = partes[1].substring(0, 2); // Limita a decimalesMaximos decimales
            valor = partes.join('.');
        } else if (partes[0].length > 7) {
            valor = partes[0].substring(0, 7); // Limita a enterosMaximos enteros si no hay parte decimal
        }
        
        inputElement.value = valor;
	}
	
	/////SOLICITUD DE INSPECCION
        
    $("#numero_solicitud_inspeccion").change(function () {
    
    	event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;
    	let numeroSolicitudInspeccion = $("#numero_solicitud_inspeccion").val();

		$('#fProductosExportacion .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

		if(numeroSolicitudInspeccion != ""){
			fn_obtenerDatosInspeccionFitosanitaria(numeroSolicitudInspeccion);
		}
	});

	/////VALIDAR NUMERO SOLICITUD

    function fn_obtenerDatosInspeccionFitosanitaria(numeroSolicitudInspeccion) {

		event.preventDefault();
		$("#estado").html("").removeClass('alerta');                 
        
		$.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/obtenerDatosInspeccionFitosanitaria",
		{
			idCertificadoFitosanitario : idCertificadoFitosanitario,
			numeroSolicitudInspeccion : numeroSolicitudInspeccion,
			idTipoProduccion : idTipoProduccion,
			tipoSolicitud : tipoSolicitud		 		
		}, function (data) {  
			if(data.validacion == 'Exito'){
				$("#tProductosInspeccion").html(data.resultado);
			}else{
				$("#tProductosInspeccion").empty();     	                    
				mostrarMensaje(data.mensaje, "FALLO");
				$("#numero_solicitud_inspeccion").val("");
			}	                       
		}, 'json');
		    
    }
    
    ////AGREGAR PRODUCTOS
	
	$("#agregarProductoInspeccion").click(function () {
	
		let seleccion;
		let validarInspeccion = false;
	
		if($('#tProductosInspeccion tr').length){		
		
			datosInspeccion = [];
		
			$('#tProductosInspeccion tr').each(function (rows) {
	
	            let seleccion = $(this).find('td').find('input[name="id_total_inspeccion_fitosanitaria[]"]');
	            
	            if(seleccion.prop('checked')){
	
					let idTotalInspeccionado = seleccion.val();
					let idInspeccionFitosanitaria = seleccion.attr('data-idinspeccionfitosanitaria');
					let fechaInspeccion = seleccion.attr('data-fechainspeccion');
	            	let cantidad = $(this).find('td').find('input[name="cantidad_comercial[]"]').val();
	            	let pesoNeto = $(this).find('td').find('input[name="peso_neto[]"]').val();
	            	let pesoBruto = $(this).find('td').find('input[name="peso_bruto[]"]').val();

	            	datosInspeccion.push({idCertificadoFitosanitario : idCertificadoFitosanitario,	            							
				            				idTotalInspeccionado: idTotalInspeccionado,
				            				idInspeccionFitosanitaria : idInspeccionFitosanitaria,
				            				fechaInspeccion : fechaInspeccion,
								           	cantidad: cantidad,
								           	pesoNeto: pesoNeto,
								           	pesoBruto: pesoBruto});
								           	
					validarInspeccion = true;
 
	            }
	
	        });
	        
	        if(validarInspeccion){
	        
		        $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitarioProductos/agregarProductoInspeccionado",
		                {
							datosInspeccion : datosInspeccion	 		
		                }, function (data) {
			                if (data.validacion === 'Fallo') {
                        		mostrarMensaje(data.resultado, "FALLO");
                   			} else {
		                        mostrarMensaje(data.resultado, "EXITO");              
		                        $("#tProductosExportacion").append(data.filaProductoInspeccion);  
                        	}                 
		                }, 'json');
		    
		    }else{		    
		    	$("#estado").html("Por favor seleccione al menos un producto en el check.").addClass("alerta");
		    }
	        
	    }else{
	    	$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
	    }
	    
	});	
	
	function fn_eliminarDetalleProducto(idProducto) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitarioProductos/borrar",
            {
                id_certificado_fitosanitario_producto : idProducto
            },
            function (data) {
                $("#filapr" + idProducto).remove();

                if($("#tProductosExportacion tr").length == 0){                	
                	$("#identificador_exportador").val("");
                	$("#nombre_exportador").val("");
                	$("#direccion_exportador").val(""); 
                	$("#tProductosInspeccion").empty();
                	$("#numero_solicitud_inspeccion").val("");              
                }
                        
            });
    }
    
    ////VALIDAR CANTIDADES
	
	function validarCantidades(idTotalInspeccionFitosanitaria, elemento) {

    	$.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/validarCantidades",
            {
            	id_total_inspeccion_fitosanitaria : idTotalInspeccionFitosanitaria,
            	cantidad : elemento.value,
            	tipo_cantidad : elemento.name
            }, function (data) {
            	if(data.validacion == "Fallo"){
    				$(elemento).val(data.cantidad);	     		
            	}
            }, 'json');
            
	}	
	
	////FUNCIONES
	
	$("#id_pais_destino").change(function () {
	
		let idLocalizacion = $("#id_pais_destino").val();
		let elemento =  $("#id_puerto_destino");					
		
		if (idLocalizacion !== "") {
        	fn_cargarPuertos(idLocalizacion, elemento);
        }
	});
	
	$("#id_pais_transito").change(function () {
	
		let idLocalizacion = $("#id_pais_transito").val();
		let elemento =  $("#id_puerto_transito");

		if (idLocalizacion !== "") {
        	fn_cargarPuertos(idLocalizacion, elemento);
        }
	});

    function fn_cargarPuertos(idLocalizacion, elemento) {                
    
    	if (idLocalizacion !== ""){    
            $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/buscarPuertosPorIdPais",
                {
                 idLocalizacion : idLocalizacion
                }, function (data) {
                elemento.html(data);               
            });
        }
            
    }
    
    /////PAISES PUERTOS DESTINO
    
    $("#agregarPaisPuertoDestino").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fPuertoDestino .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $.post("<?php echo URL ?>CertificadoFitosanitario/PaisesPuertosDestino/guardar",
                {
                    id_certificado_fitosanitario : idCertificadoFitosanitario,
                    id_pais_destino : $("#id_pais_destino").val(),
					nombre_pais_destino : $("#id_pais_destino option:selected").text(),
                    id_puerto_destino : $("#id_puerto_destino").val(),
                    nombre_puerto_destino : $("#id_puerto_destino option:selected").attr("data-nombre")
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");              
                        $("#tPuertoDestino").append(data.filaPuertoDestino);
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });
    
    function fn_eliminarDetallePaisPuertoDestino(idPuertoDestino) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>CertificadoFitosanitario/PaisesPuertosDestino/borrar",
            {
            	id_certificado_fitosanitario : idCertificadoFitosanitario,
                id_pais_puerto_destino : idPuertoDestino
            },
            function (data) {
				if (data.validacion === 'Fallo') {
					mostrarMensaje(data.resultado, "FALLO");
				} else {
					$("#filapd" + idPuertoDestino).remove();
                }    
            }, 'json');
    }
    
    /////PAISES PUERTOS DE TRANSITO
    
    $("#agregarPaisPuertoTransito").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

        $('#fPaisPuertoTransito .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $.post("<?php echo URL ?>CertificadoFitosanitario/PaisesPuertosTransito/guardar",
                {
                    id_certificado_fitosanitario : idCertificadoFitosanitario,
                    id_pais_transito : $("#id_pais_transito").val(),
					nombre_pais_transito : $("#id_pais_transito option:selected").text(),
                    id_puerto_transito : $("#id_puerto_transito").val(),
                    nombre_puerto_transito : $("#id_puerto_transito option:selected").attr("data-nombre"),
                    id_medio_transporte_transito : $("#id_medio_transporte_transito").val(),
                    nombre_medio_transporte_transito : $("#id_medio_transporte_transito option:selected").text()
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");              
                        $("#tPaisPuertoTransito").append(data.filaPaisPuertoTransito);                      
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

    function fn_eliminarDetallePaisPuertoTransito(idPaisPuertoTransito) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>CertificadoFitosanitario/PaisesPuertosTransito/borrar",
            {
                id_pais_puerto_transito : idPaisPuertoTransito
            },
            function (data) {
                $("#filappt" + idPaisPuertoTransito).remove();       
            });
    }
    
    /////DATOS EXPORTADOR
	
	$("#identificador_exportador").change(function () {
    
    	event.preventDefault();
		var error = false;
		$("#estado").html("").removeClass('alerta');
		$(".alertaCombo").removeClass("alertaCombo");

		let identificadorExportador = $("#identificador_exportador").val();
   	
    	if (identificador_exportador !== ""){    
    		 $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/validarProductosExportador",
                {
			 		idCertificadoFitosanitario : idCertificadoFitosanitario,
					identificadorExportador : identificadorExportador 			 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#nombre_exportador").val(data.resultado.nombreOperador);
                    	$("#direccion_exportador").val(data.resultado.direccionOperador);	                                    	
	                }else{
	                    mostrarMensaje(data.mensaje, "FALLO");
	                    $('#identificador_exportador').val("");
                    }	                       
                }, 'json');
    	}
    	
	});
	
	////VALIDAR POA
	
	$("#codigo_poa_exportador").change(function () {

		event.preventDefault();
		var error = false;
		$("#estado").html("").removeClass('alerta');
		$(".alertaCombo").removeClass("alertaCombo");

		let identificadorExportador = $("#identificador_exportador").val();
		let codigoPoaExportador = $("#codigo_poa_exportador").val();

    	if (identificadorExportador !== "" && codigoPoaExportador != ""){    
            $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/validarCodigoPoaExportador",
                {
                 identificadorExportador : identificadorExportador,
                 codigoPoaExportador : codigoPoaExportador
                }, function (data) {    
                    if(data.validacion == 'Fallo'){
                    	mostrarMensaje(data.mensaje, "FALLO");
                    	$("#codigo_poa_exportador").val("");                              	
	                }                       
                }, 'json');
        }else{
        	$("#codigo_poa_exportador").val("");
        }
            
	});	
	
	$("#formularioDatosGenerales").submit(function (event) {
		event.preventDefault();
		var error = false;
		$("#estado").html("").removeClass('alerta');
		$(".alertaCombo").removeClass("alertaCombo");

		let fechaEmbarque = $("#fecha_embarque").val();
		let idPuertoEmbarque = $("#id_puerto_embarque").val();
		let nombreMarca = $("#nombre_marca").val();
		let nombreConsignatario = $("#nombre_consignatario").val();
		let direccionConsignatario = $("#direccion_consignatario").val();
		let codigoCertificadoImportacion = $("#codigo_certificado_importacion").val();
		let informacionAdicional = $("#informacion_adicional").val();
				
        $('#formularioDatosGenerales .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });		
				
		if (!error) {
            $.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/actualizarDatosGeneralesCertificadoFitosanitario", {
            	id_certificado_fitosanitario : idCertificadoFitosanitario,
            	fecha_embarque : fechaEmbarque,
            	id_puerto_embarque : idPuertoEmbarque,
            	nombre_marca : nombreMarca,
            	nombre_consignatario : nombreConsignatario,
            	direccion_consignatario : direccionConsignatario,
            	codigo_certificado_importacion : codigoCertificadoImportacion,
            	informacion_adicional : informacionAdicional            	
            }, function(data) {
                if (data.estado == 'Fallo') {
                    mostrarMensaje(data.mensaje, "FALLO");
                }else{
                    mostrarMensaje(data.resultado,"EXITO");                	
                	setTimeout(function(){
						$("#estado").html("").removeClass('alerta');
   	                },1500);
                }
            }, 'json');
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});	
	    
    $("#subirArchivo").click(function (event) {
	  	  
	  	var boton = $(this);
		var nombre_archivo = "<?php echo 'certificadofitosantario_' . (md5(time())); ?>";
	    var archivo = boton.parent().find(".archivo");
	    var rutaArchivo = boton.parent().find(".ruta_adjunto");
	    var extension = archivo.val().split('.');
	    var estado = boton.parent().find(".estadoCarga");
	
	    if (extension[extension.length - 1].toUpperCase() == 'PDF') {
	
	        subirArchivo(
	            archivo
	            , nombre_archivo
	            , boton.attr("data-rutaCarga")
	            , rutaArchivo
	            , new carga(estado, archivo, $("#no"))
	            
	        );
	    } else {
	        estado.html('Formato incorrecto, solo se admite archivos en formato PDF');
	        archivo.val("0");        
	    }
	});
	
	$("#formularioEnviarSolicitud").submit(function (event) {
    	event.preventDefault();
		var error = false;
		$("#estado").html("").removeClass('alerta');
		$(".alertaCombo").removeClass("alertaCombo");
		var mensajeDetalle = "";

		$('#formularioEnviarSolicitud .validacion').each(function(i, obj) {
 			if(!$.trim($(this).val())){
 				error = true;
 				$(this).addClass("alertaCombo");
 			}
 		});	

		if (!error) {
		
			$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Guardando...</div>").fadeIn();
			$("#bEnviarSolicitud").prop('disabled', true);
			
			setTimeout(function () {		
        		var respuesta = JSON.parse(ejecutarJson($("#formularioEnviarSolicitud")).responseText);      
	        }, 1000);
	        		
		}else{
			$("#estado").html("Por favor revise los campos obligatorios." + mensajeDetalle).addClass("alerta");
		}
	});
	
	function actualizarCantidades(idCertificadoFitosanitarioProducto, elemento) {

    	$.post("<?php echo URL ?>CertificadoFitosanitario/CertificadoFitosanitario/actualizarCantidades",
            {
            	id_certificado_fitosanitario_producto : idCertificadoFitosanitarioProducto,
            	cantidad : elemento.value,
            	tipo_cantidad : elemento.name
            }, function (data) {
            	if(data.validacion == "Fallo"){
    				$(elemento).val(data.cantidad);	     		
            	}
            }, 'json');
            
	}
	
	var fecha = new Date();	
	if(tipoSolicitud == "musaceas"){
		$("#fecha_embarque").datepicker({ 
		    changeMonth: true,
		    changeYear: true,
		    dateFormat: 'yy-mm-dd'
		});   	
	}else if(tipoSolicitud == "ornamentales"){
		$("#fecha_embarque").datepicker({ 
		    changeMonth: true,
		    changeYear: true,
		    dateFormat: 'yy-mm-dd',
		    minDate: fecha
		});   	
	}else if(tipoSolicitud == "otros"){			
		$("#fecha_embarque").datepicker({
		    changeMonth: true,
		    changeYear: true,
		    dateFormat: 'yy-mm-dd',
		    //minDate: fecha,
		    onSelect: function(selectedDate){ 
		    	var actualDate = new Date(selectedDate);
			    //$("#fecha_inspeccion").datepicker('option', 'minDate', fecha );
			    //$("#fecha_inspeccion").datepicker('option', 'maxDate', selectedDate );
		    }
		});  		
	}

</script>
