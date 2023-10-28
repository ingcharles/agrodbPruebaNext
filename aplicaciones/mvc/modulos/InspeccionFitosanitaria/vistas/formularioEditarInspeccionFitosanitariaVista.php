<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<?php 
    echo $this->datosOperador;
    echo $this->datosExportacion;    
    echo $this->datosDescripcionEnvio;
    echo $this->datosProductoresAgregados;
    echo $this->datosRevision;
    echo $this->datosInspeccion;
?>

<script type ="text/javascript">
	
	var idPaisDestino = <?php echo json_encode($this->modeloInspeccionFitosanitaria->getIdPaisDestino());?>;
	var idInspeccionFitosanitaria = <?php echo json_encode($this->modeloInspeccionFitosanitaria->getIdInspeccionFitosanitaria());?>;

    $(document).ready(function() {
        construirValidador();
        distribuirLineas();
        $("#duracion").numeric();
        $("#temperatura").numeric();
        $("#concentracion").numeric();
        $("#latitud_lugar_inspeccion").numeric();
        $("#longitud_lugar_inspeccion").numeric();
        formatearCantidadProducto("input[name='cantidad_producto']");
        formatearCantidadProducto("input[name='peso_producto']");
    });
         
    function formatearCantidadProducto(inputElement) {
        $(inputElement).on('input', function () {
            var valor = this.value.replace(/[^\d.]/g, ''); // Elimina caracteres no numéricos ni puntos
            var partes = valor.split('.');
            
            if (partes.length > 1) {
                partes[0] = partes[0].substring(0, 7); // Limita a enterosMaximos enteros
                partes[1] = partes[1].substring(0, 2); // Limita a decimalesMaximos decimales
                valor = partes.join('.');
            } else if (partes[0].length > 7) {
                valor = partes[0].substring(0, 7); // Limita a enterosMaximos enteros si no hay parte decimal
            }
            
            this.value = valor;
        });
    }
    
	$("input[name='r_codigo']").click(function() {
        if($("input[name='r_codigo']").is(':checked')) {
        	$("#codigo").val(""); 
            fn_limpiarElementos();
        } 
    });
    
    $("#m_lotes_producto").change(function () {
    	let valorLoteProducto = $("#m_lotes_producto").val();
    	$("#lotes_producto").val(valorLoteProducto);
    });
    
    $("#codigo").change(function () {
    
    	event.preventDefault();
		$(".alertaCombo").removeClass("alertaCombo");
		var error = false;
		
		$("#id_tipo_producto").attr("disabled", false);				
		$("#estado").html("").removeClass('alerta');
		
		fn_limpiarElementos();

		let tipoCodigo = $("input[name=r_codigo]:checked").val();
		let codigo = $("#codigo").val();
   	
    	if (tipoCodigo !== "" && codigo !== ""){    
    		 $.post("<?php echo URL ?>InspeccionFitosanitaria/InspeccionFitosanitaria/buscarAreaCodigoMag",
                {
			 		tipoCodigo : tipoCodigo,
					codigo : codigo 			 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#nombre_lugar").val(data.resultado.nombreSitio + '/' + data.resultado.nombreArea);
                    	$("#nombre_lugar").attr('data-identificadorOperador', data.resultado.identificadorProductor);
                    	$("#nombre_lugar").attr('data-nombreoperador', data.resultado.nombreOperador);
                    	$("#nombre_lugar").attr('data-idsitio', data.resultado.idSitio);
                    	$("#nombre_lugar").attr('data-nombresitio', data.resultado.nombreSitio);
                    	$("#nombre_lugar").attr('data-nombreprovincia', data.resultado.nombreProvincia);
                    	$("#nombre_lugar").attr('data-nombrecanton', data.resultado.nombreCanton);
                    	$("#nombre_lugar").attr('data-idarea', data.resultado.idArea);	                    
	                    $("#nombre_lugar").attr('data-nombrearea', data.resultado.nombreArea);	                   
	                    $("#nombre_lugar").attr('data-codigoarea', data.resultado.codigoArea);
	                    
	                    fn_obtenerTipoProductoPorArea(idPaisDestino, data.resultado.idArea);                	
	                }else{
	                    mostrarMensaje(data.mensaje, "FALLO");
                    }	                       
                }, 'json');
    	}
    	
	});
	
	function fn_obtenerTipoProductoPorArea(idPaisDestino, idArea){

    	$("#id_subtipo_producto").attr("disabled", false);				
		$("#estado").html("").removeClass('alerta');	
		
		fn_limpiarCombo("id_subtipo_producto");
		fn_limpiarCombo("id_producto");
				
    	if (idPaisDestino){    
    		 $.post("<?php echo URL ?>InspeccionFitosanitaria/InspeccionFitosanitaria/obtenerTipoProductoPorArea",
                {
			 		idPaisDestino : idPaisDestino,
					idArea : idArea 			 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#id_tipo_producto").html(data.resultado);
	                }else{        	                    
	                    mostrarMensaje(data.mensaje, "FALLO");
	                }	                       
                }, 'json');
    	}
    
    }
    
    $("#id_tipo_producto").change(function () {
    
    	$("#id_producto").attr("disabled", false);				
		$("#estado").html("").removeClass('alerta');	
    
    	let idArea = $("#nombre_lugar").attr('data-idarea');
    	let idTipoProducto = $("#id_tipo_producto option:selected").val();
    	
    	fn_limpiarCombo("id_producto");
    	
		if (idTipoProducto !== ""){    
    		 $.post("<?php echo URL ?>InspeccionFitosanitaria/InspeccionFitosanitaria/obtenerSubtipoProductoPorArea",
                {
			 		idPaisDestino : idPaisDestino,
					idArea : idArea,
					idTipoProducto : idTipoProducto 			 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#id_subtipo_producto").html(data.resultado);
	                }else{        	                    
	                    mostrarMensaje(data.mensaje, "FALLO");
	                }	                       
                }, 'json');
    	}
		
	});
	
	$("#id_subtipo_producto").change(function () {
    
    	$("#id_producto").attr("disabled", false);				
		$("#estado").html("").removeClass('alerta');	
    
    	let idArea = $("#nombre_lugar").attr('data-idarea');
    	let idSubtipoProducto = $("#id_subtipo_producto option:selected").val();
    	
    	fn_limpiarCombo("id_producto");
    	
		if (idSubtipoProducto !== ""){    
    		 $.post("<?php echo URL ?>InspeccionFitosanitaria/InspeccionFitosanitaria/obtenerProductoPorArea",
                {
			 		idPaisDestino : idPaisDestino,
					idArea : idArea,
					idSubtipoProducto : idSubtipoProducto 			 		
                }, function (data) {    
                    if(data.validacion == 'Exito'){
                    	$("#id_producto").html(data.resultado);
	                }else{        	                    
	                    mostrarMensaje(data.mensaje, "FALLO");
	                }	                       
                }, 'json');
    	}
		
	});	
	
	function fn_limpiarCombo(elemento){ 		
        $("#" + elemento).empty()
        $("#" + elemento).append('<option value="">Seleccione...</option>');
 	} 	
 	
    $("#fecha_tratamiento").datepicker({
        yearRange: "c:c",
        changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
    });

    $("#fecha_tratamiento").click(function () {
        $(this).val('');
    });
 	
 	function fn_limpiarElementos(){
    	$("#nombre_lugar").attr('data-idarea', '');
    	$("#nombre_lugar").val("");
    	fn_limpiarCombo("id_tipo_producto");
    	fn_limpiarCombo("id_subtipo_producto");
    	fn_limpiarCombo("id_producto");
    	$("#cantidad_producto").val("");
    	$("#peso_producto").val("");
    	$("#id_unidad_cantidad_producto").val("");
    	$("#id_tipo_tratamiento").val("");
    	$("#id_tratamiento").val("");
    	$("#duracion").val("");
    	$("#id_duracion").val("");
    	$("#temperatura").val("");
    	$("#id_temperatura").val("");
    	$("#fecha_tratamiento").val("");
    	$("#producto_quimico").val("");
    	$("#concentracion").val("");
    	$("#id_concentracion").val("");
 	}
 	
 	$("#agregarProductor").click(function (event) {
        event.preventDefault();
        mostrarMensaje("", "");
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;

		if($.trim($("#id_tratamiento").val())){
        	$("#duracion").addClass("validacion");
        	$("#id_duracion").addClass("validacion");
        	$("#fecha_tratamiento").addClass("validacion");        
        }else{
        	$("#duracion").removeClass("validacion");
        	$("#id_duracion").removeClass("validacion");
        	$("#fecha_tratamiento").removeClass("validacion");
        }
        
		if($.trim($("#temperatura").val())){
        	$("#id_temperatura").addClass("validacion");
        }else{
        	$("#id_temperatura").removeClass("validacion");
        }
		
        if($.trim($("#concentracion").val())){
        	$("#id_concentracion").addClass("validacion");
        }else{
        	$("#id_concentracion").removeClass("validacion");
        }
		
        $('#fDescripcionEnvio .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });

        if (!error) {

            $.post("<?php echo URL ?>InspeccionFitosanitaria/ProductosInspeccionFitosanitaria/guardar",
                {
                    id_inspeccion_fitosanitaria : idInspeccionFitosanitaria,
                    id_pais_destino : idPaisDestino,
                    identificador_operador : $("#nombre_lugar").attr("data-identificadoroperador"),
                    nombre_operador : $("#nombre_lugar").attr("data-nombreoperador"),
                    id_sitio :  $("#nombre_lugar").attr("data-idsitio"),
                    nombre_sitio : $("#nombre_lugar").attr("data-nombresitio"),
                    nombre_provincia : $("#nombre_lugar").attr("data-nombreprovincia"),
                    nombre_canton : $("#nombre_lugar").attr("data-nombrecanton"),                 
                    id_area : $("#nombre_lugar").attr("data-idarea"),
					nombre_area : $("#nombre_lugar").attr("data-nombrearea"),
					codigo_area : $("#nombre_lugar").attr("data-codigoarea"),
			  		id_tipo_producto : $("#id_tipo_producto option:selected").val(),
			  		nombre_tipo_producto : $("#id_tipo_producto option:selected").text(),
			    	id_subtipo_producto : $("#id_subtipo_producto option:selected").val(),
			    	nombre_subtipo_producto : $("#id_subtipo_producto option:selected").text(),
			    	id_producto : $("#id_producto option:selected").val(),
			    	nombre_producto : $("#id_producto option:selected").text(),			    	
			    	cantidad_producto : $("#cantidad_producto").val(),
			    	id_unidad_cantidad_producto : $("#id_unidad_cantidad_producto option:selected").val(),
			    	nombre_unidad_cantidad_producto : $("#id_unidad_cantidad_producto option:selected").text(),
			    	peso_producto : $("#peso_producto").val(),
			    	id_unidad_peso_producto : $("#id_unidad_peso_producto option:selected").val(),
			    	nombre_unidad_peso_producto : $("#id_unidad_peso_producto option:selected").text(),
			    	id_tipo_tratamiento : $("#id_tipo_tratamiento option:selected").val(),
			    	nombre_tipo_tratamiento : $("#id_tipo_tratamiento option:selected").text(),
			    	id_tratamiento : $("#id_tratamiento option:selected").val(),
			    	nombre_tratamiento : $("#id_tratamiento option:selected").text(),
			    	duracion : $("#duracion").val(),
			    	id_duracion : $("#id_duracion option:selected").val(),
			    	nombre_duracion : $("#id_duracion option:selected").text(),
			    	temperatura : $("#temperatura").val(),
			    	id_temperatura : $("#id_temperatura option:selected").val(),
			    	nombre_temperatura : $("#id_temperatura option:selected").text(),
			    	fecha_tratamiento : $("#fecha_tratamiento").val(),
			    	producto_quimico : $("#producto_quimico").val(),
			    	concentracion : $("#concentracion").val(),
			    	id_concentracion : $("#id_concentracion option:selected").val(),
			    	nombre_concentracion : $("#id_concentracion option:selected").text(),
                },
                function (data) {
                    if (data.validacion === 'Fallo') {
                        mostrarMensaje(data.resultado, "FALLO");
                    } else {
                        mostrarMensaje(data.resultado, "EXITO");                        
                        $("#tProductoresAgregados tbody").append(data.filaProductoInspeccionar);
                        $("#id_area").html(data.comboLugarInspeccion);
                        $("#tipo_solicitud").val(data.tipoSolicitud);                   
                        fn_limpiarCamposEnvio();
                        fn_limpiarCamposDatosInspeccion();                        
                    }
                }, 'json');

        } else {
            $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
        }
    });

    //Funcion que elimina una fila del detalle de producto a inspeccionar
    function fn_eliminarDetalleProductoInspeccion(idProductoInspeccionFitosanitaria) {

        $("#estado").html("").removeClass('alerta');

        $.post("<?php echo URL ?>InspeccionFitosanitaria/ProductosInspeccionFitosanitaria/borrar",
            {
                id_inspeccion_fitosanitaria : idInspeccionFitosanitaria,
                id_producto_inspeccion_fitosanitaria: idProductoInspeccionFitosanitaria
            },
            function (data) {
                $("#fila" + idProductoInspeccionFitosanitaria).remove();
                $("#resultadoInformacionProducto" + idProductoInspeccionFitosanitaria).remove();
                $("#id_area").html(data.comboLugarInspeccion);
                $("#tipo_solicitud").val(data.tipoSolicitud);   
                if($("#tProductoresAgregados tbody tr").length == 0){
                	fn_limpiarCamposDatosInspeccion();     	
                }             
            }, 'json');
    }
    
    $("#codigo_lugar_inspeccion").change(function () {
    
    	event.preventDefault();
		$(".alertaCombo").removeClass("alertaCombo");
		var error = false;
					
		$("#estado").html("").removeClass('alerta');

		let tipoLugarInspeccion = $("#id_area option:selected").val();
		let codigoLugarInspeccion = $("#codigo_lugar_inspeccion").val();
   	
    	if (tipoLugarInspeccion !== "" && codigoLugarInspeccion !== ""){
    	
    		if(tipoLugarInspeccion == "ACO" || tipoLugarInspeccion == "AGE"){
    	  
	    		 $.post("<?php echo URL ?>InspeccionFitosanitaria/InspeccionFitosanitaria/buscarLugarInspeccionFitosanitaria",
	                {
				 		id_inspeccion_fitosanitaria : idInspeccionFitosanitaria,
				 		id_pais_destino : idPaisDestino,
				 		tipo_lugar_inspeccion : tipoLugarInspeccion,
						codigo_lugar_inspeccion : codigoLugarInspeccion 			 		
	                }, function (data) {    
	                    if(data.validacion == 'Exito'){
	                    	$("#nombre_lugar_inspeccion").val(data.resultado.nombreSitio + '/' + data.resultado.nombreArea);
	                    	$("#direccion_lugar_inspeccion").val(data.resultado.direccionSitio);
	                    	$("#nombre_lugar_inspeccion").attr('data-identificadoroperadorLugar', data.resultado.identificadorProductor);
	                    	$("#nombre_lugar_inspeccion").attr('data-nombreoperadorlugar', data.resultado.nombreOperador);
	                    	$("#nombre_lugar_inspeccion").attr('data-idsitiolugar', data.resultado.idSitio);
	                    	$("#nombre_lugar_inspeccion").attr('data-nombresitiolugar', data.resultado.nombreSitio);
	                    	$("#nombre_lugar_inspeccion").attr('data-nombreprovinciacantonlugar', data.resultado.nombreProvinciaCanton);
	                    	$("#nombre_lugar_inspeccion").attr('data-idarealugar', data.resultado.idArea);	                    
		                    $("#nombre_lugar_inspeccion").attr('data-nombrearealugar', data.resultado.nombreArea);	                   
		                    $("#nombre_lugar_inspeccion").attr('data-codigoarealugar', data.resultado.codigoArea);
		                    $("#latitud_lugar_inspeccion").val(data.resultado.latitud);
		                    $("#longitud_lugar_inspeccion").val(data.resultado.longitud);            	
		                }else{
		                	$("#codigo_lugar_inspeccion").val("");
		                	$("#nombre_lugar_inspeccion").val("");
		                	$("#direccion_lugar_inspeccion").val("");
		                	$("#latitud_lugar_inspeccion").val("");
		                	$("#longitud_lugar_inspeccion").val("");
		                    mostrarMensaje(data.mensaje, "FALLO");
	                    }                       
	                }, 'json');
                
                }
                
    	}
    	
	});
	
	$("#fecha_lugar_inspeccion").datepicker({ 
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
  	});

	$("#id_area").change(function () {
	
		event.preventDefault();
		$(".alertaCombo").removeClass("alertaCombo");
		var error = false;
		
		$("#estado").html("").removeClass('alerta');
		$("#codigo_lugar_inspeccion").val("");
		$("#nombre_lugar_inspeccion").val("");
		$("#direccion_lugar_inspeccion").val("");
		$("#latitud_lugar_inspeccion").val("");
		$("#longitud_lugar_inspeccion").val("");
						
    	if($("#id_area option:selected").val() != ""){     		
    		
    		if($("#id_area option:selected").val() == "ACO" || $("#id_area option:selected").val() == "AGE"){
    		 	$("#codigo_lugar_inspeccion").addClass("validacion");
    			$("#codigo_lugar_inspeccion").attr("placeholder", "Ejm: 2300123252.17060102");
    			$("#codigo_lugar_inspeccion").prop('disabled', false);
    			$("#latitud_lugar_inspeccion").prop('disabled', false);    
    			$("#longitud_lugar_inspeccion").prop('disabled', false);
    			$("#nombre_lugar_inspeccion").prop('readonly', true);
    			$("#direccion_lugar_inspeccion").prop('readonly', true);
    			$("#nombre_lugar_inspeccion").prop('disabled', true);
    			$("#direccion_lugar_inspeccion").prop('disabled', true);
    			$("#lid_provincia_inspeccion").remove();
    			$("#id_provincia_inspeccion").remove();
    		}
    		if($("#id_area option:selected").val() == "PRO"){
    		
	    		let tipoArea = $("#id_area option:selected").val();
	    	
	    		$.post("<?php echo URL ?>InspeccionFitosanitaria/InspeccionFitosanitaria/comboProvinciaInspeccion",
	            {
	            	tipoArea : tipoArea
	            }, function (data) {
	            	if(data.validacion == "Exito"){
	    				$("#dProvincia").html(data.resultado);
	    				distribuirLineas();	     		
	            	}
	            }, 'json'); 
    		
    		 	$("#codigo_lugar_inspeccion").addClass("validacion");
    		 	$("#nombre_lugar_inspeccion").addClass("validacion");
    		 	$("#direccion_lugar_inspeccion").addClass("validacion");
    			$("#codigo_lugar_inspeccion").attr("placeholder", "Ejm: Área de producción");
    			$("#codigo_lugar_inspeccion").prop('disabled', false);
    			$("#nombre_lugar_inspeccion").prop('disabled', false);
    			$("#nombre_lugar_inspeccion").prop('readonly', false);
    			$("#direccion_lugar_inspeccion").prop('disabled', false);
    			$("#direccion_lugar_inspeccion").prop('readonly', false);
    			$("#latitud_lugar_inspeccion").prop('disabled', false);    
    			$("#longitud_lugar_inspeccion").prop('disabled', false);
    		}
    		if($("#id_area option:selected").val() == "PUE"){
    			$("#codigo_lugar_inspeccion").removeClass("validacion");
				$("#nombre_lugar_inspeccion").removeClass("validacion");
    			$("#direccion_lugar_inspeccion").removeClass("validacion");
    		 	$("#codigo_lugar_inspeccion").removeAttr("placeholder");
    			$("#codigo_lugar_inspeccion").prop('disabled', true);
    			$("#nombre_lugar_inspeccion").prop('disabled', true);
    			$("#direccion_lugar_inspeccion").prop('disabled', true);
    			$("#latitud_lugar_inspeccion").prop('disabled', true);    
    			$("#longitud_lugar_inspeccion").prop('disabled', true);
    			$("#lid_provincia_inspeccion").remove();
    			$("#id_provincia_inspeccion").remove();     			
    		}
    	}else{
    		$("#codigo_lugar_inspeccion").prop('disabled', true);
    	}	
	});
	
	$("input[name='r_codigo']").click(function () {	
    	$("#codigo").prop('disabled', false);
    	$("#codigo").attr("placeholder", "Ejm: 2300123252.17060102 o 1256");
	});
	
	//Funcion que limpia los campos de descripcion de envio 	
 	function fn_limpiarCamposEnvio(){
 		$("#codigo").val("");
    	$("#nombre_lugar").attr('data-idarea', '');
    	$("#nombre_lugar").val("");
    	fn_limpiarCombo("id_tipo_producto");
    	fn_limpiarCombo("id_subtipo_producto");
    	fn_limpiarCombo("id_producto");
    	$("#cantidad_producto").val("");
    	$("#peso_producto").val("");
    	$("#id_unidad_cantidad_producto").val("");
    	$("#id_tipo_tratamiento").val("");
    	$("#id_tratamiento").val("");
    	$("#duracion").val("");
    	$("#id_duracion").val("");
    	$("#temperatura").val("");
    	$("#id_temperatura").val("");
    	$("#fecha_tratamiento").val("");
    	$("#producto_quimico").val("");
    	$("#concentracion").val("");
    	$("#id_concentracion").val("");
 	}
 	
 	function fn_limpiarCombo(elemento){ 		
        $("#" + elemento).empty()
        $("#" + elemento).append('<option value="">Seleccione...</option>');
 	}
	
	//Funcion que limpia los campos de los datos del lugar de inspeccion
    function fn_limpiarCamposDatosInspeccion(){
    	$("#codigo_lugar_inspeccion"). val("");
    	$("#nombre_lugar_inspeccion"). val("");
    	$("#direccion_lugar_inspeccion"). val("");
    	$("#latitud_lugar_inspeccion"). val("");
    	$("#longitud_lugar_inspeccion"). val("");
    	$("#fecha_lugar_inspeccion"). val("");
    	$("#hora_lugar_inspeccion"). val("");
    	$("#observacion_lugar_inspeccion"). val("");
    }
	
	//Funcion para agregar fila de detalle de exportadores productos
    $("#formularioEnviarSolicitudInspeccion").submit(function (event) {
        event.preventDefault();
        $(".alertaCombo").removeClass("alertaCombo");
		var error = false;
        let mensajeDetalle = "";

    	$('#formularioEnviarSolicitudInspeccion .validacion').each(function (i, obj) {
            if (!$.trim($(this).val())) {
                error = true;
                $(this).addClass("alertaCombo");
            }
        });
        
        if($("#tProductoresAgregados tbody tr").length == 0){
        	error = true;
        	mensajeDetalle += " Debe agregar al menos un producto.";       	
        }
        
		if (!error) {

			$("#estado").html("").removeClass('alerta');
		        
		        var respuesta = JSON.parse(ejecutarJson($("#formularioEnviarSolicitudInspeccion")).responseText);

				if (respuesta.estado == 'exito'){
		       		$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un item para revisarlo.</div>');
                	abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"), "#listadoItems", true);
		        }
	        
		} else {
			$("#estado").html("Por favor revise los campos obligatorios." + mensajeDetalle).addClass("alerta");
		}
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

    $("#hora_lugar_inspeccion").change(function () {
    	if (!validarHora($('#hora_lugar_inspeccion'))) {
    		$('#hora_lugar_inspeccion').val("");
    	}
    
    });	
    
    function validarHora (input) {
        isValid = true;
        var currVal = $(input).val();
        if (currVal === ''){
            isValid = false;
     	}
        //Declarar Regex 
        var rxDatePattern = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/;
        var dtArray = currVal.match(rxDatePattern);
        if (dtArray === null){
            isValid = false;
     	}
        return isValid;
	};
    
</script>
