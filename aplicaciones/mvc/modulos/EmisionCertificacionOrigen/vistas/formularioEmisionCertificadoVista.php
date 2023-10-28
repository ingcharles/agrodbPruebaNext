<header>
	<h1><?php echo $this->accion;?></h1>
</header>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>



<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>EmisionCertificacionOrigen' data-opcion='emisionCertificado/guardarRegistros' data-destino="detalleItem" data-accionEnExito ="ACTUALIZAR" >
	<input type="hidden" name="id" id="id">
	<fieldset id="centroFaenamiento">
		<legend>Datos Origen</legend>				


		<div data-linea="1">
			<label for="provincia">Provincia: </label>
			<select id="provincia" name="provincia">
				<?php echo $this->comboProvinciaCf();?>
			</select>
		</div>				

		<div data-linea="1">
			<label for="sitio_origen">Sitio: </label>
			<select id="sitio_origen" name="sitio_origen">
				<option value="">Seleccionar....</option>
			</select>
		</div>				

		<div data-linea="2">
			<label for="area_origen">Área: </label>
			<select id="area_origen" name="area_origen">
				<option value="">Seleccionar....</option>
			</select>
		</div>				

		<div data-linea="2">
			<label for="codigo_area">Código de área: </label>
			<input type="text" id="codigo_area" name="codigo_area" 
			disabled readonly />
		</div>				
		
	</fieldset >
	<fieldset id="datosConsultaWebServices">
		<legend>Datos Destino</legend>				

		<div data-linea="1">
			<label for="identificador_destino">RUC/CI destino: </label>
			<input type="text" id="identificador_destino" name="identificador_destino" value="<?php echo $this->modeloEmisionCertificado->getIdEmisionCertificado(); ?>"
			placeholder="Identificador"  maxlength="13" />
			<input type="hidden" id="clasificacion" name="clasificacion" value="" >
			<input type="hidden" id="numero" name="numero" value="" >
		</div>
		
		<div id="estadoConsulta"></div>

		<div data-linea="2">
			<label for="razon_social_destino">Razón social: </label>
			<input type="text" id="razon_social_destino" name="razon_social_destino" value="" disabled
			placeholder="Razón social"  maxlength="400" />
			
		</div>						

		<div data-linea="3">
			<label for="provincia_destino">Provincia: </label>
			<select id="provincia_destino" name="provincia_destino">
				<option value="">Seleccionar...</option>
				<?php echo $this->comboProvinciasEc();?>
			</select>
		</div>				

		<div data-linea="3">
			<label for="canton_destino">Cantón: </label>
			<select id="canton_destino" name="canton_destino" disabled>
				<option value="">Seleccionar...</option>
			</select>
		</div>				

		<div data-linea="3">
			<label for="parroquia_destino">Parroquia: </label>
			<select id="parroquia_destino" name="parroquia_destino" disabled>
				<option value="">Seleccionar...</option>
			</select>
		</div>				

		<div data-linea="6">
			<label for="direccion_destino">Dirección: </label>
			<input type="text" id="direccion_destino" name="direccion_destino" value="<?php echo $this->modeloEmisionCertificado->getProvinciaDestino(); ?>"
			placeholder="Dirección destino" maxlength="512" />
		</div>				
	</fieldset >
	<fieldset >
		<legend>Datos de Movilización</legend>

		<div data-linea="1" id="esperarMovi">
			<label for="identificador_movilizacion">RUC/CI: </label> <input
				type="text" id="identificador_movilizacion"
				name="identificador_movilizacion" placeholder="RUC/CI"
				maxlength="13" />
		</div>
				
		<div data-linea="2">
			<label for="transportista">Razón Social: </label> <input type="text"
				id="transportista" name="transportista" placeholder="Razón Social"
				maxlength="512" />
		</div>

		<div data-linea="3">
			<button type="button" class="buscar" id="buscar_trans">Buscar</button>
		</div>
		<hr>
		<div data-linea="4">
			<label for="identificador_operador_transportista">Transportista: </label>
			<select id="identificador_operador_transportista"
				name="identificador_operador_transportista" disabled>
				<option value="">Seleccionar...</option>
			</select>
		</div>
		<div data-linea="5">
			<label for="contenedor">Contenedor en buenas condiciones: </label>
			<select id="contenedor" name="contenedor" disabled>
				<?php echo $this->comboOpcion();?>
			</select>
		</div>

	</fieldset>
	<fieldset id="divDetalleProductosMovilizar">
		<legend>Detalle de productos a Movilizar</legend>				
		<div data-linea="1">
			<label for="producto_movilizar">Productos a movilizar: </label>
			<select id="producto_movilizar" name="producto_movilizar" >
				<?php echo $this->comboProdMovilizar();?>
			</select>
		</div>		
		<div data-linea="2">
           <label for="fecha_produccion">Fecha de faenamiento: </label>
           <input type="text" id="fecha_produccion" name="fecha_produccion" value="" placeholder="Fecha de faenamiento"  readonly />
         </div>
        <div data-linea="3">
             <label for="tipo_especie">Especie: </label>
             <select id="tipo_especie" name="tipo_especie">
             <?php echo $this->comboEspecie(); ?>
             </select>
              </div>	
			  
			  
		<hr>

		<div data-linea="3" id="mostrarPorduccionSubproducto">
			<label for="fecha_creacion_produccion">Producción declarada: </label>
				<select id="fecha_creacion_produccion_subporducto" name="fecha_creacion_produccion" style="width: 100%;" >
					<option value="">Seleccione....</option>
						<?php echo $this->comboProduccionSubproducto();?>
				</select>
		</div>		
		<div style="width:100%" id="divCarga">
		</div>
		<div data-linea="14" id="agregarDetalleMov">
			<button type="button" id="agregarProductosMovilizar" class="">Agregar</button>
		</div>
		</fieldset >
		<fieldset id="divProductosagregados">
		<legend>Productos agregados</legend>	
		<div id="productosAgregados" style="width:100%"></div>			
		</fieldset >
		
		<fieldset id="divDetalleSubProductosMovilizar">
		<legend>Detalle de subproductos a Movilizar</legend>				
		<div data-linea="1">
			<label for="producto_agregado">Productos agregados: </label>
			<select id="producto_agregado" name="producto_movilizar" >
			<option value="">Seleccionar...</option>
			</select>
		</div>		
		<div data-linea="4">
			<label for="subproducto_sub">Subproducto: </label>
			<select id="subproducto_sub" name="subproducto_sub" onChange="subproductobus(id); return false; ">
            <option value="">Seleccionar...</option>
			</select>
		</div>
            
		<div data-linea="5">
			<label for="saldo_disponible_spam_sub">Saldo disponible: </label>
			<span id="saldo_disponible_spam_sub"></span>
		</div>
            
		<div data-linea="6">
			<label for="cantidad_movilizar_sub">Cantidad a movilizar: </label>
			<select id="cantidad_movilizar_sub" name="cantidad_movilizar_sub" >
               <option value="">Seleccionar...</option>
			</select>
		</div>
		<div data-linea="14" id="agregarSubDetalleMov">
			<button type="button" id="agregarSubProductosMovilizar" class="">Agregar</button>
		</div>
		</fieldset >
		<fieldset id="divSubProductosagregados">
		<legend>Subproductos agregados</legend>	
		<div id="subproductosAgregados" style="width:100%"></div>			
		
		</fieldset >
		<div data-linea="15">
			<button type="submit" class="guardar" id="guardar">Guardar</button>
		</div> 
		<input type="hidden" id="id_emision_certificado" name="id_emision_certificado" value="">
		<input type="hidden" id="id_registro_produccion" name="id_registro_produccion" value="">
		<input type="hidden" id="id_productos" name="id_productos" value="">
	    <input type="hidden" id="saldo_disponible" name="saldo_disponible" value=0 >
	    <input type="hidden" id="subproductosCanalEmision" name="subproductosCanalEmision" value='' >
		
</form >
 <div id="cargarMensajeTemporal"></div>
<script type ="text/javascript">
	$(document).ready(function() {
		
		construirValidador();
		distribuirLineas();
		$("#identificador_destino").numeric();
		$("#identificador_movilizacion").numeric();
		$("#divCanal").hide();
		$("#divSubproductos").hide();
		$("#agregarDetalleMov").hide();
		$("#divCanalSubproductos").hide();
		$("#divDetalleProductosMovilizar").hide();
		$("#divDetalleSubProductosMovilizar").hide();
		$("#divProductosagregados").hide();
		$("#divSubProductosagregados").hide();

		$("#mostaraCamposAvicolaCanal").hide();
		$("#mostaraCamposAvicolaCanalSubpro").hide();
		$("#mostrarCamposCanal").hide();
		$("#mostrarCamposCanalSubpro").hide();
		$("#mostrarPorduccionSubproducto").hide();

		
		activarFecha();
		mostrarMensaje("","");
	});

	$("#formulario").submit(function (event) {
		event.preventDefault();
		var error = false;
		mostrarMensaje("", "");
		$(".alertaCombo").removeClass("alertaCombo");
		if(verificarCamposGenerales()){
			error=true;
		}

		if($("#contenedor").val() == 'Si' || $("#contenedor").val() == 'No'){
			if($("#id_emision_certificado").val() == ''){
    			error=true;
    			$("#divProductosagregados").show();
    			$("#productosAgregados").html("<span>No existen productos agregados</span>");
    			$("#productosAgregados").addClass("alertaCombo");

			}else if($("#producto_movilizar").val() == 'Canal con subproductos'){

				if($("#subproductosCanalEmision").val() == ''){
					error=true;
    				$("#divProductosagregados").show();
        			$("#subproductosAgregados").html("<span>No existen productos agregados</span>");
        			$("#subproductosAgregados").addClass("alertaCombo");
					}
				}
			
		}
	
		if (!error) {
			datosOrigen('activar');
			setTimeout(function(){
				JSON.parse(ejecutarJson($("#formulario")).responseText);
			}, 1000);
			$("#cargarMensajeTemporal").html("<div id='cargando' style='position :fixed'>Cargando...</div>").fadeIn();
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});



	$("#sitio_origen_xx").change(function(event){
		event.preventDefault();
		$(".alertaCombo").removeClass("alertaCombo");
		if( $("#sitio_origen").val() != ""){
			$("#estado").html("").removeClass('alerta');
			$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
	    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/listarAreaCF", 
	                {
	        	       idSitio:$("#sitio_origen").val()
	    	  		         		  		     
	                }, function (data) {
	                $("#cargarMensajeTemporal").html("");
	                	if (data.estado === 'EXITO') {
	                		    $("#area_origen").html(data.contenido);
	    	                    mostrarMensaje(data.mensaje, data.estado);
	                        } else {
	                        	$("#area_origen").html(data.contenido);
	                        	mostrarMensaje(data.mensaje, "FALLO");
	                        }
	            }, 'json');
		}else{
			$("#area_origen").html('<option value="" >Seleccione...</option>');
		}
	});

	   //Cuando seleccionamos la provincia
    $("#provincia_destino").change(function() {
        if($(this).val() != ''){
        $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
        $.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/buscarCantones", 
				{
				    idProvincia: $(this).val()
				},
				function (data) {
					$("#cargarMensajeTemporal").html("");
	            	$("#canton_destino").html(data);
	            	$("#canton_destino").removeAttr("disabled");
	        	});
        }else {
        	 $("#id_canton").html('<option value="">Seleccione...</option>');
            }
        $("#id_parroquia").html('<option value="">Seleccione...</option>');
        
	});

  //Cuando seleccionamos la canton
    $("#canton_destino").change(function() {
    	if($(this).val() != ''){
    	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
        $.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/buscarParroquias", 
				{
				    idCanton: $(this).val()
				},
				function (data) {
					$("#cargarMensajeTemporal").html("");
	            	$("#parroquia_destino").html(data);
	            	$("#parroquia_destino").removeAttr("disabled");
	        	});
    	}else {
       	 $("#parroquia_destino").html('<option value="">Seleccione...</option>');
           }
	});
    //****************buscar transporte ********************************
    $("#buscar_trans").click(function() {
      	  mostrarMensaje("", "");
      	  event.preventDefault();
		  var error = false;
		  $(".alertaCombo").removeClass("alertaCombo"); 
      	  if(!$.trim($("#codigo_area").val())){
 			   $("#centroFaenamiento").addClass("alertaCombo");
 			   error = true;
 		  }
      	
      	 if(!$.trim($("#identificador_movilizacion").val()) && !$.trim($("#transportista").val())){
      		$("#identificador_movilizacion").addClass("alertaCombo");
      		$("#transportista").addClass("alertaCombo");
			   error = true;
		  }

      	if (!error) {
  	        $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
  	        $.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/buscarTransporte", 
  					{
  					    idtransportista: $("#identificador_movilizacion").val(),
  					    transportista: $("#transportista").val(),
  					    idCentroFaenamiento: $("#area_origen").val()
  					},
  					function (data) {
  					$("#cargarMensajeTemporal").html("");

  					if (data.estado === 'EXITO') {
  						$("#identificador_operador_transportista").html(data.contenido);
  						$("#identificador_operador_transportista").removeAttr("disabled");
  						$("#contenedor").val('').removeAttr("disabled");
 	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
 	                  } else {
 	                	 $("#identificador_operador_transportista").html(data.contenido);
 	                	 $("#identificador_operador_transportista").attr("disabled","disabled");
 	                	 $("#contenedor").val('').attr("disabled","disabled");
  						 mostrarMensaje(data.mensaje, data.estado);
 	                  }
  		        	}, 'json');

      	} else {
			$("#estado").html("Debe llenar mínimo un campo en datos de movilización...!!").addClass("alerta");
		}
    });


    //Cuando seleccionamos la canton
    $("#identificador_operador_transportista").change(function() {
       	 $("#contenedor").val('');
       	$("#divDetalleProductosMovilizar").hide();
		$("#divProductosagregados").hide();
	});

    function activarFecha(){
    $("#fecha_produccion").datepicker({
    	yearRange: "c:c",
    	changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
        minDate: -2,
        maxDate: 0,
      });
    }
	$("#fecha_produccion").datepicker({
    	yearRange: "c:c",
    	changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
        minDate: -2,
        maxDate: 0,
      });

    $("#tipo_especie").change(function() {
		
		
    	  event.stopImmediatePropagation();
    	  mostrarMensaje("", "");
    	  $(".alertaCombo").removeClass("alertaCombo");
		  var error = false;

    	if($("#tipo_especie").val() != ''){

			if ($("#tipo_especie").val() == "AVICOLA"){
				
				$("#mostrarPorduccionSubproducto").show();
			}else{
				$("#mostrarPorduccionSubproducto").hide();
			}
		  
			if(!$.trim($("#producto_movilizar").val())){
				$("#producto_movilizar").addClass("alertaCombo");
				error = true;
			}
			if(!$.trim($("#fecha_produccion").val())){
				$("#fecha_produccion").addClass("alertaCombo");
				error = true;
			}
			if (!error) {
				var fecha_produccion = '';

				if ($("#fecha_creacion_produccion_avicola option:selected").val() != undefined){
					fecha_produccion = $("#fecha_creacion_produccion_avicola").val();  
				}

				if ($("#fecha_creacion_produccion option:selected").val() != undefined){
					fecha_produccion = $("#fecha_creacion_produccion").val();
				}
					$("#divDetalleSubProductosMovilizar").hide();
					if($("#producto_movilizar").val() == 'Canal'){
							$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
							$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/buscarCanal", 
									{
										tipoEspecie:$("#tipo_especie").val(),
										fechaProduccion:$("#fecha_produccion").val(),
										producto_movilizar:$("#producto_movilizar").val(),
										sitio_origen: $("#sitio_origen option:selected").val(),
										area_origen: $("#area_origen option:selected").val(),
										fecha_creacion_produccion: fecha_produccion,
									}, function (data) {
										$("#cargarMensajeTemporal").html("");
										if (data.estado === 'EXITO') {
												$("#divCarga").html(data.valores);
												$("#agregarDetalleMov").show();
												$("#codigo_canal").html(data.canal);
												$("#codigo_canal").removeAttr("disabled");
												mostrarMensaje(data.mensaje, data.estado);
											distribuirLineas();
										} else {
											$("#codigo_canal").html('<option value="">Seleccionar...</option>');
											$("#divCarga").html('');
											$("#agregarDetalleMov").hide();
											mostrarMensaje(data.mensaje, "FALLO");
										}
										
							}, 'json');
							
					}else if($("#producto_movilizar").val() == 'Subproductos'){
						
						$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");	
						
								$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/cargarProduccionDeclarada", 
								{
									tipoEspecie:$("#tipo_especie").val(),
									fechaProduccion:$("#fecha_produccion").val(),
									producto_movilizar:$("#producto_movilizar").val(),
									
								}, function (data) {
									$("#cargarMensajeTemporal").html("");
									if (data.estado === 'EXITO') {
										$("#mostrarPorduccionSubproducto").show();
										$("#fecha_creacion_produccion_subporducto").html(data.contenido);

									}
								}, 'json');

						}else if($("#producto_movilizar").val() == 'Canal con subproductos'){
							$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>"); 
							$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/buscarCanal", 
									{
										tipoEspecie:$("#tipo_especie").val(),
										fechaProduccion:$("#fecha_produccion").val(),
										producto_movilizar:$("#producto_movilizar").val(),
										sitio_origen: $("#sitio_origen option:selected").val(),
										area_origen: $("#area_origen option:selected").val(),
										fecha_creacion_produccion: fecha_produccion,
										///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									}, function (data) {
										$("#cargarMensajeTemporal").html("");
										if (data.estado === 'EXITO') {
												$("#divCarga").html(data.valores);
												$("#agregarDetalleMov").show();
												$("#codigo_canal").html(data.canal);
												$("#codigo_canal").removeAttr("disabled");
												$("#divDetalleSubProductosMovilizar").show();
												mostrarMensaje(data.mensaje, data.estado);
											distribuirLineas();
										} else {
											$("#divDetalleSubProductosMovilizar").hide();
											$("#codigo_canal").html('<option value="">Seleccionar...</option>');
											$("#divCarga").html('');
											$("#agregarDetalleMov").hide();
											mostrarMensaje(data.mensaje, "FALLO");
										}
							}, 'json');
						}
					

			} else {
				$("#estado").html("Por favor revise los campos obligatorios..!!").addClass("alerta");
				$("#tipo_especie").val('');
				$("#divCarga").html('');
				$("#agregarDetalleMov").hide();
			}

		}else{
				$("#codigo_canal").html('<option value="">Seleccionar...</option>'); 
				$("#divCarga").html('');
				$("#agregarDetalleMov").hide();
		}
			// if (this.change) {
			// } else {
				$("#mostaraCamposAvicolaCanal").hide();
				$("#mostaraCamposAvicolaCanalSubpro").hide();
				$("#mostrarCamposCanal").hide();
				$("#mostrarCamposCanalSubpro").hide();
			// }  
	  
    });
    //Cuando producto_movilizar
    $("#producto_movilizar").change(function() {
     		$("#divCarga").html('');
     		$("#fecha_produccion").val('');
     		$("#tipo_especie").val('');
     		$("#divDetalleSubProductosMovilizar").hide();
 	});

     //Cuando producto_movilizar
     $("#contenedor").change(function() {
     	if($(this).val() != ''){
     		if($(this).val() == 'Si' || $(this).val() == 'No'){
     			limpiarCampos();
        		$("#divDetalleProductosMovilizar").show();
     		}else{
     			 $("#divDetalleSubProductosMovilizar").hide();
        		$("#divDetalleProductosMovilizar").hide();
         		}
     		distribuirLineas();
     	}else {
     		$("#divDetalleSubProductosMovilizar").hide();
     		$("#divDetalleProductosMovilizar").hide();
    		$("#divProductosagregados").hide();
    		distribuirLineas();
        }
 	});

    function tipoMovilizacionCanal(e){
  		$(".alertaCombo").removeClass("alertaCombo");
  		mostrarMensaje("", "");
 		var error = false;
 		if($("#tipo_movilizacion_canal").val() != '' ){
			
         			if($("#tipo_movilizacion_canal").val() == 'Entera' ){
         				$("#destino").val('Un destino');
         				$("#destino").attr('disabled', true);
         		   }else {
         			  $("#destino").val('');
         			  $("#destino").attr('disabled', false);
         			}

         			 if(!$.trim($("#tipo_producto_movilizar_canal").val())){
   		  			   $("#tipo_producto_movilizar_canal").addClass("alertaCombo");
   		  			   error = true;
   		  		  }

					var fecha_produccion = '';
					if ($("#fecha_creacion_produccion").text() === undefined){
						fecha_produccion = $("#fecha_creacion_produccion_avicola").val();
					}else{
						fecha_produccion = $("#fecha_creacion_produccion").val();   
					}

   				if (!error) {
           				  $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
                 		    $.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/codigoCanal", 
                 	              {
                 		    	     tipo_especie:$("#tipo_especie").val(),
                 			         fecha_produccion:$("#fecha_produccion").val(),
                 			         tipo_producto_movilizar_canal:$("#tipo_producto_movilizar_canal").val(),
                 			         producto_movilizar:$("#producto_movilizar").val(),
                 			         tipo_movilizacion_canal:$("#tipo_movilizacion_canal").val(),
                 			         id_emision_certificado: $("#id_emision_certificado").val(),
									 sitio_origen : $("#sitio_origen").val(),
									 area_origen : $("#area_origen").val() ,
									 fecha_creacion_produccion :  fecha_produccion,               			        
									           			        
                 	              }, function (data) {
                 	            	 $("#cargarMensajeTemporal").html("");
                 	              	if (data.estado === 'EXITO') {
                 	              		    $("#codigo_canal").html(data.contenido);
                 	              		    $("#codigo_canal").removeAttr("disabled");
                 		                    mostrarMensaje(data.mensaje, data.estado);
                 		                    distribuirLineas();
                 	                  } else {
                 	                	 $("#codigo_canal").html('<option value="">Seleccionar...</option>');
                 	                  	 mostrarMensaje(data.mensaje, "FALLO");
                 	                  }
                 	      }, 'json');
   				}else{
   					 $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
   				}		
 			}else{
 				$("#destino").val('');
 				}
 	}

	function separarCaracteres(dato){
		var separador = '-';
    	var datoSeparado = dato.split(separador);
		return datoSeparado[0];
	}

    $(document).on('change',"#tipo_producto_movilizar_canal", function(){
 		  	$("#tipo_movilizacion_canal").val('');
 	});
  	
     $(document).on('click',"#fecha_produccion", function(){
  			$("#tipo_especie").val('');
  			$("#codigo_canal").val('');
  	});

     $("#agregarProductosMovilizar").click(function(event){
		
 		event.preventDefault();
 		$(".alertaCombo").removeClass("alertaCombo");
 		mostrarMensaje("", "");
		var error = false;
		if(verificarCamposGenerales()){
			error=true;
		}
		if(verificarCampos($("#producto_movilizar").val(),$("#tipo_especie").val())){
			
			error=true;
		}
		var fecha_produccion = '';

			if ($("#fecha_creacion_produccion_avicola option:selected").val() != undefined){
				
				fecha_produccion = $("#fecha_creacion_produccion_avicola").val();  
			}

			if ($("#fecha_creacion_produccion option:selected").val() != undefined){
				
				fecha_produccion = $("#fecha_creacion_produccion").val();
			}
			
			if ($("#fecha_creacion_produccion_subporducto_avicola").val() != "" && $("#fecha_creacion_produccion_subporducto_avicola option:selected").val() != undefined){
				
				fecha_produccion = $("#fecha_creacion_produccion_subporducto_avicola").val();
			}

    	 if (!error) {
			var especie = quitarAcentos(($("#tipo_especie").val().toUpperCase()));
			
         			$("#estado").html("").removeClass('alerta');
         			$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
         	    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/agregarProductosMovilizar", 
         	                {
         	    		       sitio_origen:$("#sitio_origen").val(),
         	        	       area_origen:$("#area_origen").val(),
         	        	       identificador_destino:$("#identificador_destino").val(),
         	        	       razon_social_destino:$("#razon_social_destino").val(),
         	        	       provincia_destino:$("#provincia_destino").val(),
         	        	       canton_destino:$("#canton_destino").val(),
         	        	       parroquia_destino:$("#parroquia_destino").val(),
         	        	       direccion_destino:$("#direccion_destino").val(),
         	        	       identificador_movilizacion:$("#identificador_operador_transportista").val(),
         	        	       contenedor:$("#contenedor").val(),
         	        	       producto_movilizar:$("#producto_movilizar").val(),
         	        	       fecha_produccion:$("#fecha_produccion").val(),
         	        	       tipo_especie:$("#tipo_especie").val(),
         	        	       tipo_producto_movilizar_canal:$("#tipo_producto_movilizar_canal").val(),
         	        	       codigo_canal:$("#codigo_canal").val(),
         	        	       tipo_movilizacion_canal:$("#tipo_movilizacion_canal").val(),
         	        	       destino:$("#destino").val(),
         	        	       subproducto:$("#subproducto").val(),
         	        	       saldo_disponible:$("#saldo_disponible").val(),
         	        	       cantidad_movilizar:$("#cantidad_movilizar").val(),
         	        	    //    id_emision_certificado: $("#id_emision_certificado").val(),
							   id_emision_certificado:$("#id_emision_certificado").val(),
         	        	       id_registro_produccion:$("#id_registro_produccion").val(),
         	        	       id_productos:$("#id_productos").val(),
							   fecha_creacion_produccion:fecha_produccion != "" ?fecha_produccion:$("#fecha_creacion_produccion_subporducto").val(),
							   fecha_faenamiento:$("#fecha_faenamiento").val(),
							   cantidadSeleccionada:$("#cantidad_movilizar").val()//******************************************************************************************************************** */
         	    	  		         		  		     
         	                }, function (data) {
         	                $("#cargarMensajeTemporal").html("");
         	                	if (data.estado === 'EXITO') {
         	                		limpiarCamposDetalleProductos();
         	                		if($("#producto_movilizar").val() == 'Canal'){
         	                			$("#divProductosagregados").show();
         	                		    $("#productosAgregados").html(data.contenido);

         	                		    if(especie == 'AVICOLA'){
         	                		    	$("#saldo_disponible").val(data.total);
         	                		    	$("#saldo_disponible_spam").html(data.total);
         	                		    	$("#cantidad_movilizar").html(data.canal);
             	                		    }
         	                		    
         	                		}else if($("#producto_movilizar").val() == 'Subproductos'){
         	                			$("#divSubProductosagregados").show();
         	                		    $("#subproductosAgregados").html(data.contenido);
             	                	}else{
             	                		$("#divProductosagregados").show();
         	                		    $("#productosAgregados").html(data.contenido);
         	                		    $("#divSubProductosagregados").show();
        	                		    $("#producto_agregado").html(data.canalSub);
        	                		    if(especie == 'AVICOLA'){
         	                		    	$("#saldo_disponible").val(data.total);
         	                		    	$("#saldo_disponible_spam").html(data.total);
         	                		    	$("#cantidad_movilizar").html(data.canal);
             	                		    }
        	                		    limpiarCamposSubproducto();
             	                	}
         	                		    $("#codigo_canal").html(data.canal);
         	                		    $("#id_emision_certificado").val(data.id);
         	                		    
         	                		    datosOrigen('bloquear');
         	    	                    mostrarMensaje(data.mensaje, data.estado);
         	                        } else {
         	                        	//$("#codigo_canal").html('<option value="">Seleccionar...</option>');
         	                        	if($("#producto_movilizar").val() == 'Canal'){
             	                		    $("#productosAgregados").html(data.contenido);
             	                		}else if($("#producto_movilizar").val() == 'Subproductos'){
             	                		    $("#subproductosAgregados").html(data.contenido);
                 	                	}else{
                 	                		$("#productosAgregados").html(data.contenido);
                 	                	}
         	                        	if(data.contenido==''){
         	                        		$("#divProductosagregados").hide();
         	                        		$("#divSubProductosagregados").hide();
             	                        	$("#id_emision_certificado").val('');
             	                        	datosOrigen('activar');
                 	                    }
         	                        	mostrarMensaje(data.mensaje, "FALLO");
         	                        }
         	            }, 'json');
         		
    	 }else{
    		 $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
         }
 	});
  	
     function eliminarProducto(codigo){

		var separador = '/';
    	var codigoSeparado = codigo.split(separador);
		var id = codigoSeparado[0];
		var codigoCanal=codigoSeparado[1];
		var idCertificado=codigoSeparado[2];
		var fechaProduccion = codigoSeparado[3];
		var tipoEspecie = codigoSeparado[4];
		

         	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
         	$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/eliminarProduccion", 
     	              {
     			        id:id,
						codigoCanal : codigoCanal,
						fechaProduccion : fechaProduccion,
						idCertificado : idCertificado,
						tipoEspecie : tipoEspecie,
     			        id_emision_certificado:$("#id_emision_certificado").val(),
						sitio_origen : $("#sitio_origen").val(),
						area_origen : $("#area_origen").val(),
						
     	              }, function (data) {
     	            	 $("#cargarMensajeTemporal").html("");
     	              	if (data.estado === 'EXITO') {
     	              		$("#productosAgregados").html(data.contenido);
     	              		$("#codigo_canal").html(data.canal);
     	              		$("#producto_agregado").html(data.canalSub);
     	                    mostrarMensaje(data.mensaje, data.estado);
     	                    distribuirLineas();
     	                        if(data.contenido==''){
     	                        	if($("#producto_movilizar").val() != 'Canal con subproductos'){
     	                        		$("#divProductosagregados").hide();
         	                        	}
     	                        	
     	                        	$("#id_emision_certificado").val('');
     	                        	datosOrigen('activar');
         	                    }else{
         	                    	datosOrigen('bloquear');
             	                    }
     	                  } else {
     	                	 $("#productosAgregados").html(data.contenido);
      	              		 $("#codigo_canal").html(data.canal);
      	              		 $("#producto_agregado").html(data.canalSub);
     	                	// $("#producto_agregado").html('<option value="">Seleccionar...</option>');
     	                	 //$("#codigo_canal").html('<option value="">Seleccionar...</option>');
     	                  	mostrarMensaje(data.mensaje, "FALLO");
     	                  }
     	      }, 'json');
         }


     function eliminarSubproductos(id){
      	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
      	$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/eliminarSubproductos", 
  	              {
  			        id:id,
  			        id_emision_certificado:$("#id_emision_certificado").val()
  	              }, function (data) {
  	            	 $("#cargarMensajeTemporal").html("");
  	              	if (data.estado === 'EXITO') {
  	              	    $("#subproductosAgregados").html(data.contenido);
  	                    mostrarMensaje(data.mensaje, data.estado);
  	                    distribuirLineas();
  	                    limpiarCamposDetalleProductos();
  	                    limpiarCamposSubproducto();
  	                        if(data.contenido==''){
  	                        	$("#subproductosCanalEmision").val('');
  	                        	if($("#producto_movilizar").val() != 'Canal con subproductos'){
  	                        		$("#id_emision_certificado").val(''); 
  	                        		$("#divSubProductosagregados").hide();
  	                        	}
  	                        	datosOrigen('activar');
      	                    }else{
      	                    	datosOrigen('bloquear');
          	                    }
  	                  } else {
  	                  	mostrarMensaje(data.mensaje, "FALLO");
  	                  }
  	      }, 'json');
      }

     function eliminarProductoMenor(id){
      	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
		  var fecha_produccion = '';

			if ($("#fecha_creacion_produccion_avicola option:selected").val() != undefined){
				fecha_produccion = $("#fecha_creacion_produccion_avicola option:selected").val();  
			}
      	$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/eliminarProduccionMenor", //**************************************************************************************************************************** */
  	              {
  			        id:id,
  			        id_emision_certificado:$("#id_emision_certificado").val(),
  			        tipo_producto_movilizar_canal:$("#tipo_producto_movilizar_canal").val(),
  			        fecha_faenamiento:$("#fecha_faenamiento").val(),
					fecha_creacion_produccion:fecha_produccion,
  	              }, function (data) {
  	            	 $("#cargarMensajeTemporal").html("");
  	              	if (data.estado === 'EXITO') {
  	              		$("#productosAgregados").html(data.contenido);
  	              	    $("#saldo_disponible_spam").html(data.total);
  	              	    $("#saldo_disponible").val(data.total);
  	                    $("#cantidad_movilizar").html(data.cantidadMovilizar);
              	    
  	                    mostrarMensaje(data.mensaje, data.estado);
  	                   if(data.contenido==''){
  	                	     $("#id_emision_certificado").val('');
  	                         $("#tipo_producto_movilizar_canal").val('');
  	                	     datosOrigen('activar');
	                    }else{
	                    	// datosOrigen('bloquear');
    	                    }
  	                    distribuirLineas();
  	                  } else {
  	                  	mostrarMensaje(data.mensaje, "FALLO");
  	                  }
  	      }, 'json');
      }
     
    	function verificarCampos(opt,especie){
    		var error1 = false;
			var especie = quitarAcentos((especie.toUpperCase()));
    		if(especie=='AVICOLA'){
    		switch (opt) { 
    		case 'Canal': 
                		if(!$.trim($("#fecha_produccion").val())){
                			   $("#fecha_produccion").addClass("alertaCombo");
                			   error1 = true;
                		  }
                		if(!$.trim($("#tipo_especie").val())){
             			   $("#tipo_especie").addClass("alertaCombo");
             			   error1 = true;
             		  	}	
                		if(!$.trim($("#tipo_producto_movilizar_canal").val())){
             			   $("#tipo_producto_movilizar_canal").addClass("alertaCombo");
             			   error1 = true;
             		  	}
                		if(!$.trim($("#cantidad_movilizar").val())){
             			   $("#cantidad_movilizar").addClass("alertaCombo");
             			   error1 = true;
             		 	 }
       		  
    			break;
    		case 'Subproductos': 
                		if(!$.trim($("#fecha_produccion").val())){
                 			   $("#fecha_produccion").addClass("alertaCombo");
                 			   error1 = true;
                 		  }
                 		if(!$.trim($("#tipo_especie").val())){
              			   $("#tipo_especie").addClass("alertaCombo");
              			   error1 = true;
              		  	}	
                 		if(!$.trim($("#subproducto").val())){
              			   $("#subproducto").addClass("alertaCombo");
              			   error1 = true;
              		  	}
                 		if(!$.trim($("#saldo_disponible").val())){
              			   $("#saldo_disponible").addClass("alertaCombo");
              			   error1 = true;
              		 	 }
                 		if(!$.trim($("#cantidad_movilizar").val())){
              			   $("#cantidad_movilizar").addClass("alertaCombo");
              			   error1 = true;
              		  	}
    			break;
    		case 'Canal con subproductos':
                	    if(!$.trim($("#fecha_produccion").val())){
                 			   $("#fecha_produccion").addClass("alertaCombo");
                 			   error1 = true;
                 		  }
                 		if(!$.trim($("#tipo_especie").val())){
              			   $("#tipo_especie").addClass("alertaCombo");
              			   error1 = true;
              		  	}	
                 		if(!$.trim($("#tipo_producto_movilizar_canal").val())){
              			   $("#tipo_producto_movilizar_canal").addClass("alertaCombo");
              			   error1 = true;
              		  	}
                 		if(!$.trim($("#cantidad_movilizar").val())){
              			   $("#cantidad_movilizar").addClass("alertaCombo");
              			   error1 = true;
              		 	 }
    			break;
    		default:
    			error1 = true;
    	       }
    		}else{
    			switch (opt) { 
        		case 'Canal': 
                    		if(!$.trim($("#fecha_produccion").val())){
                    			   $("#fecha_produccion").addClass("alertaCombo");
                    			   error1 = true;
                    		  }
                    		if(!$.trim($("#tipo_especie").val())){
                 			   $("#tipo_especie").addClass("alertaCombo");
                 			   error1 = true;
                 		  	}	
                    		if(!$.trim($("#tipo_producto_movilizar_canal").val())){
                 			   $("#tipo_producto_movilizar_canal").addClass("alertaCombo");
                 			   error1 = true;
                 		  	}
                    		if(!$.trim($("#codigo_canal").val())){
                 			   $("#codigo_canal").addClass("alertaCombo");
                 			   error1 = true;
                 		 	 }
                    		if(!$.trim($("#tipo_movilizacion_canal").val())){
                 			   $("#tipo_movilizacion_canal").addClass("alertaCombo");
                 			   error1 = true;
                 		  	}
                    		if(!$.trim($("#destino").val())){
                 			   $("#destino").addClass("alertaCombo");
                 			   error1 = true;
                 		  	}
           		  
        			break;
        		case 'Subproductos': 
                    		if(!$.trim($("#fecha_produccion").val())){
                     			   $("#fecha_produccion").addClass("alertaCombo");
                     			   error1 = true;
                     		  }
                     		if(!$.trim($("#tipo_especie").val())){
                  			   $("#tipo_especie").addClass("alertaCombo");
                  			   error1 = true;
                  		  	}	
                     		if(!$.trim($("#subproducto").val())){
                  			   $("#subproducto").addClass("alertaCombo");
                  			   error1 = true;
                  		  	}
                     		if(!$.trim($("#saldo_disponible").val())){
                  			   $("#saldo_disponible").addClass("alertaCombo");
                  			   error1 = true;
                  		 	 }
                     		if(!$.trim($("#cantidad_movilizar").val())){
                  			   $("#cantidad_movilizar").addClass("alertaCombo");
                  			   error1 = true;
                  		  	}
        			break;
        		case 'Canal con subproductos':
                    			if(!$.trim($("#fecha_produccion").val())){
                     			   $("#fecha_produccion").addClass("alertaCombo");
                     			   error1 = true;
                     		  }
                     		if(!$.trim($("#tipo_especie").val())){
                  			   $("#tipo_especie").addClass("alertaCombo");
                  			   error1 = true;
                  		  	}	
                     		if(!$.trim($("#tipo_producto_movilizar_canal").val())){
                  			   $("#tipo_producto_movilizar_canal").addClass("alertaCombo");
                  			   error1 = true;
                  		  	}
                     		if(!$.trim($("#codigo_canal").val())){
                  			   $("#codigo_canal").addClass("alertaCombo");
                  			   error1 = true;
                  		 	 }
                     		if(!$.trim($("#tipo_movilizacion_canal").val())){
                  			   $("#tipo_movilizacion_canal").addClass("alertaCombo");
                  			   error1 = true;
                  		  	}
                     		if(!$.trim($("#destino").val())){
                  			   $("#destino").addClass("alertaCombo");
                  			   error1 = true;
                  		  	}
        			break;
        		default:
        			error1 = true;
        	       }
    		}
    		  return error1;
        	}

    	function verificarCamposGenerales(){
    		 error = false;
    	 if(!$.trim($("#sitio_origen").val())){
  			   $("#sitio_origen").addClass("alertaCombo");
  			   error = true;
  		  }
  		 if(!$.trim($("#area_origen").val())){
  			   $("#area_origen").addClass("alertaCombo");
  			   error = true;
  		  }
  		 if(!$.trim($("#identificador_destino").val())){
  			   $("#identificador_destino").addClass("alertaCombo");
  			   error = true;
  		  }
  		 if(!$.trim($("#razon_social_destino").val())){
  			   $("#razon_social_destino").addClass("alertaCombo");
  			   error = false;
  		  }
  		 if(!$.trim($("#provincia_destino").val())){
  			   $("#provincia_destino").addClass("alertaCombo");
  			   error = true;
  		  }
  		 if(!$.trim($("#canton_destino").val())){
  			   $("#canton_destino").addClass("alertaCombo");
  			   error = true;
  		  }
  		 if(!$.trim($("#parroquia_destino").val())){
  			   $("#parroquia_destino").addClass("alertaCombo");
  			   error = true;
  		  }
  		 if(!$.trim($("#direccion_destino").val())){
  			   $("#direccion_destino").addClass("alertaCombo");
  			   error = true;
  		  }
  		 if(!$.trim($("#identificador_operador_transportista").val())){
  			   $("#identificador_operador_transportista").addClass("alertaCombo");
  			   error = true;
  		  }
  		 if(!$.trim($("#contenedor").val())){
  			   $("#contenedor").addClass("alertaCombo");
  			   error = true;
  		  }

		  return error;
        	}


    	function verificarCamposSubproducto(){
   		 error = false;
   	     if(!$.trim($("#producto_agregado").val())){
 			   $("#producto_agregado").addClass("alertaCombo");
 			   error = true;
 		  }
 		 if(!$.trim($("#subproducto_sub").val())){
 			   $("#subproducto_sub").addClass("alertaCombo");
 			   error = true;
 		  }
 		 if(!$.trim($("#cantidad_movilizar_sub").val())){
 			   $("#cantidad_movilizar_sub").addClass("alertaCombo");
 			   error = true;
 		  }

		  return error;
       	}
    	function limpiarCamposSubproducto(){
    		$("#saldo_disponible_spam_sub").html('');
    		$("#subproducto_sub").val('');
    		$("#cantidad_movilizar_sub").val('');
          	}
       	
    	function limpiarCampos(){
        	
    		$("#fecha_produccion").val('');
 		    $("#tipo_especie").val('');
 		    $("#tipo_producto_movilizar_canal").val('');
 		    $("#codigo_canal").val('');
 		    $("#tipo_movilizacion_canal").val('');
 		    $("#destino").val('');
		  	$("#subproducto").val('');
		  	$("#saldo_disponible").val('');
		  	$("#cantidad_movilizar").val('');
    	}

       function limpiarCamposDetalleProductos(){
        	
		  	$("#subproducto").val('');
		  	$("#saldo_disponible").val('');
		  	$("#cantidad_movilizar").val('');
		  	$("#saldo_disponible_spam").html('');
    	}

    	  function saldoDisponible(id){ 
			
				var fecha_produccion = '';

				if ($("#fecha_creacion_produccion_avicola option:selected").val() != undefined){
					fecha_produccion = $("#fecha_creacion_produccion_avicola").val();  
				}

				if ($("#fecha_creacion_produccion option:selected").val() != undefined){
					fecha_produccion = $("#fecha_creacion_produccion").val();
				}
				
				if ($("#fecha_creacion_produccion_subporducto_avicola option:selected").val() != undefined){
					fecha_produccion = $("#fecha_creacion_produccion_subporducto_avicola").val();
				}

					event.stopImmediatePropagation();
					mostrarMensaje("", "FALLO");
					$(".alertaCombo").removeClass("alertaCombo");
				if($("#tipo_especie").val() != ''){
					if($("#tipo_producto_movilizar_canal").val() != ''){
					mostrarMensaje("", "");
								$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
								$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/saldoDisponible", 
                     	              {
                     			          tipo_producto_movilizar_canal:$("#tipo_producto_movilizar_canal").val(),
                     			          fecha_faenamiento:$("#fecha_produccion").val(),
                     			          tipo_especie:$("#tipo_especie").val(),
                     			          id_emision_certificado:$("#id_emision_certificado").val(),
										  fecha_creacion_produccion:fecha_produccion,
                       			      
                     	              }, function (data) {
                     	            	 $("#cargarMensajeTemporal").html("");
                     	              	if (data.estado === 'EXITO') {
                     	              		    $("#saldo_disponible_spam").html(data.total);
                     	              		    $("#saldo_disponible").val(data.total);
                     	              		    $("#cantidad_movilizar").removeAttr("disabled");
                     	              		    $("#cantidad_movilizar").html(data.contenido);
                     	              		    $("#id_registro_produccion").val(data.idRegistroProduccion);
                     	              		    $("#id_productos").val(data.idProductos);
                     		                    mostrarMensaje(data.mensaje, data.estado);
                     	                  } else {
                     	                	 $("#cantidad_movilizar").html('<option value="">Seleccionar...</option>');
                     	                	 $("#saldo_disponible").val(0);
                     	                	 $("#saldo_disponible_spam").html('');
                     	                  	 mostrarMensaje(data.mensaje, "FALLO");
                     	                  }
                     	      }, 'json');
          		  }else{
          			 $("#saldo_disponible").val(0); 
          			 $("#saldo_disponible_spam").html('');
          			 $("#tipo_producto_movilizar_canal").addClass("alertaCombo");
          			 mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
          		  }
        	  }else{
        		  $("#tipo_especie").addClass("alertaCombo");
        		  mostrarMensaje("Por favor revise los campos obligatorios.", "FALLO");
            	  }
				
         }

		 //tipo_producto_movilizar_canal//control campo combo produccion declarada. ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ producto_movilizar

		 
		$(document).on('change',"#fecha_creacion_produccion_avicola", function(){
			event.stopPropagation();
			var especie = quitarAcentos(($("#tipo_especie").val().toUpperCase()));
			if($("#fecha_creacion_produccion_avicola").val() != ''){
				$("#tipo_producto_movilizar_canal").val('');
				$("#saldo_disponible_spam").val('');
				$("#cantidad_movilizar").empty()	;
			}

			if (especie == "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal" ){
				$("#mostaraCamposAvicolaCanal").show();
			}

			if (especie == "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal con subproductos" ){
				$("#mostaraCamposAvicolaCanalSubpro").show();
			}

			if (especie != "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal" ){
				$("#mostrarCamposCanal").show();
			}

			if (especie != "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal con subproductos" ){
				$("#mostrarCamposCanalSubpro").show();
			}

 		});

		 $(document).on('change',"#fecha_creacion_produccion_subporducto_avicola", function(){
			event.stopPropagation();
			var especie = quitarAcentos(($("#tipo_especie").val().toUpperCase()));
			if($("#fecha_creacion_produccion_avicola").val() != ''){
				$("#tipo_producto_movilizar_canal").val('');
				$("#saldo_disponible_spam").val('');
				$("#cantidad_movilizar").empty()	;
			}

			if (especie == "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal" ){
				$("#mostaraCamposAvicolaCanal").show();
			}

			if (especie == "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal con subproductos" ){
				$("#mostaraCamposAvicolaCanalSubpro").show();
			}

			if (especie != "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal" ){
				$("#mostrarCamposCanal").show();
			}

			if (especie != "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal con subproductos" ){
				$("#mostrarCamposCanalSubpro").show();
			}

 		});

		 $(document).on('change',"#fecha_creacion_produccion", function(){
			event.stopPropagation();
			var especie = quitarAcentos(($("#tipo_especie").val().toUpperCase()));
			if($("#fecha_creacion_produccion_avicola").val() != ''){
				$("#tipo_producto_movilizar_canal").val('');
				$("#saldo_disponible_spam").val('');
				$("#cantidad_movilizar").empty();
			}

			if (especie == "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal" ){
				$("#mostaraCamposAvicolaCanal").show();
			}

			if (especie == "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal con subproductos" ){
				$("#mostaraCamposAvicolaCanalSubpro").show();
			}

			if (especie != "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal" ){
				$("#mostrarCamposCanal").show();
			}

			if (especie != "AVICOLA" && $("#producto_movilizar option:selected").val() == "Canal con subproductos" ){
				$("#mostrarCamposCanalSubpro").show();
			}

			if ($("#fecha_creacion_produccion").val() != ''){

				$("#tipo_producto_movilizar_canal").attr('disabled',false);
				$("#tipo_movilizacion_canal").attr('disabled',false);
				$("#destino").attr('disabled',false);

			}
			
 		});

		
		


    	  function cantidadMovilizar(id){ 
     	     event.stopImmediatePropagation();
          	 if($("#saldo_disponible").val() != ''){
          	 mostrarMensaje("", "");
                  		 $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
                  		  $.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/cantidadMovilizar", 
                  	              {
                  			         subproducto:$("#subproducto").val(),
                  	              }, function (data) {
                  	            	 $("#cargarMensajeTemporal").html("");
                  	              	if (data.estado === 'EXITO') {
                  	              		    $("#cantidad_movilizar").html(data.contenido);
                  	              		    $("#cantidad_movilizar").removeAttr("disabled");
                  		                    mostrarMensaje(data.mensaje, data.estado);
                  	                  } else {
                  	                	 $("#codigo_canal").html('<option value="">Seleccionar...</option>');
                  	                  	 mostrarMensaje(data.mensaje, "FALLO");
                  	                  }
                  	      }, 'json');
       		  }
      }

    	  $("#provincia").change(function (event){
    	    	if($("#provincia").val() != ''){
    	    	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
    	    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/buscarSitio", 
    		              {
    				       id:$("#provincia").val()
    		              }, function (data) {
    		            	$("#cargarMensajeTemporal").html("");
    		              	if (data.estado === 'EXITO') {
    		              		$("#sitio_origen").html(data.contenido);
    		                    mostrarMensaje(data.mensaje, data.estado);
    		                  } else {
    		                  	mostrarMensaje(data.mensaje, "FALLO");
    		                  }
    		      }, 'json');
    	    	}else{
    	    		$("#sitio_origen").html('<option value="">Seleccionar....</option>');
    	    		$("#tipo_especie").html('<option value="">Seleccionar....</option>');
    	    		$("#codigo_area").val('');
    	    		$("#area_origen").html('<option value="">Seleccionar....</option>');
    	    	}
    		});

    	    $("#sitio_origen").change(function (event){
    	    	if($("#sitio_origen").val() != ''){
    	        $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
    	    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/buscarArea", 
    		              {
    				       id:$("#sitio_origen").val()
    		              }, function (data) {
    		            	$("#cargarMensajeTemporal").html("");
    		              	if (data.estado === 'EXITO') {
    		              		$("#area_origen").html(data.contenido);
    		                    mostrarMensaje(data.mensaje, data.estado);
    		                  } else {
    		                  	mostrarMensaje(data.mensaje, "FALLO");
    		                  }
    		      }, 'json');
    	    	}else{
    	    		$("#tipo_especie").html('<option value="">Seleccionar....</option>');
    	    		$("#codigo_area").val('');
    	    		$("#area_origen").html('<option value="">Seleccionar....</option>');
    	    	}
    		});
    	    $("#area_origen").change(function (event){
    	    	if($("#area_origen").val() != ''){
    	    	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
    	    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/buscarEspecie", 
    		              {
    				       id:$("#area_origen").val()
    		              }, function (data) {
    		            	$("#cargarMensajeTemporal").html("");
    		              	if (data.estado === 'EXITO') {
    		              		$("#tipo_especie").html(data.contenido);
    		              		$("#codigo_area").val(data.codigo);
    		              		$("#divCarga").html('');
     	              		    $("#agregarDetalleMov").hide();

            	                limpiarCampos();
         	         			$("#divDetalleProductosMovilizar").hide();
         	            		$("#divProductosagregados").hide();
         	            		$("#identificador_operador_transportista").html('<option value="">Seleccionar....</option>');
         	            		$("#contenedor").val('');
         	            		$("#contenedor").attr('disabled',true);

         	            		if(data.criterio == 'Activo'){
         	            		//	$("#provincia_destino option:contains("+data.provincia+")").attr('selected', true);
         	            			cargarValorDefecto("provincia_destino",data.provincia);
         	            			$("#provincia_destino").attr('disabled',true);
         	            			$("#canton_destino").html(data.canton);
         	            			$("#parroquia_destino").html(data.parroquia);
         	            			$("#parroquia_destino").attr('disabled',false);
         	            			
         	            		}else{
         	            			$("#provincia_destino").val('');
         	            			$("#provincia_destino").attr('disabled',false);
         	            			$("#parroquia_destino").attr('disabled',true);
         	            			$("#canton_destino").val('');
         	            			$("#parroquia_destino").val('');
         	            		//	$("#parroquia_destino").attr('disabled',true);
             	            		}
     	            		
    		                    mostrarMensaje(data.mensaje, data.estado);
    		                  } else {
    		                	 $("#divCarga").html('');
       	              		    $("#agregarDetalleMov").hide();
    		                  	mostrarMensaje(data.mensaje, "FALLO");
    		                  }
    		      }, 'json');
    	    	}else{
    	    		$("#tipo_especie").html('<option value="">Seleccionar....</option>');
    	    		$("#codigo_area").val('');
    	    		$("#divCarga").html('');
           		    $("#agregarDetalleMov").hide();
           		 limpiarCampos();
       			$("#divDetalleProductosMovilizar").hide();
          		$("#divProductosagregados").hide();
          		$("#identificador_operador_transportista").html('<option value="">Seleccionar....</option>');
         		$("#contenedor").val('');
         		$("#contenedor").attr('disabled',true);
          		
    	        	}
    		});
    		
			 $("#identificador_destino").blur(function (event){
				event.preventDefault();
				$('#detalleItem #estadoConsulta').html('');
				
				if((($("#identificador_destino").val()).length) == 10){
					$("#clasificacion").val('Cédula');
					$("#numero").val($("#identificador_destino").val());
				}else{
					$("#clasificacion").val('Natural');
					$("#numero").val($("#identificador_destino").val());
				}
				serializedData = $("#datosConsultaWebServices").serialize(),
        		url1 = "aplicaciones/general/consultaWebServices.php";
        		
				resultado = $.ajax({
    			    url: url1,
    			    type: "post",
    			    data: serializedData,
    			    dataType: "json",
    			    async:   true,
    			    beforeSend: function(){
    			    	$("#estado").html('').removeClass();
    			    	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
    				},
    				
    			    success: function(msg){
    			    	if(msg.estado=="exito"){
							
							if($("#clasificacion").val() == 'Cédula'){

								var stringParts = msg.valores.Nombre.split(" ");
								var num = stringParts.length;
								switch(num) {
								case 2:
									var nomb= stringParts[1];
									var apell= stringParts[0];
									break;
								case 3:
									var nomb= stringParts[1]+' '+stringParts[2];
									var apell= stringParts[0];
									break;
								case 4:
									var nomb= stringParts[2]+' '+stringParts[3];
									var apell= stringParts[0]+' '+stringParts[1];
									break;
								case 5:
									var nomb= stringParts[2]+' '+stringParts[3]+' '+stringParts[4];
									var apell= stringParts[0]+' '+stringParts[1];
									break;
								case 6:
									var nomb= stringParts[4]+' '+stringParts[5];
									var apell= stringParts[0]+' '+stringParts[1]+' '+stringParts[2]+' '+stringParts[3];
									break;
								default:
									var nomb= stringParts[2]+' '+stringParts[3];
									var apell= stringParts[0]+' '+stringParts[1];  
								} 
								$("#razon_social_destino").val(nomb+" "+apell);
							}else{
								$("#razon_social_destino").val(msg.valores.razonSocial);
							}
							$("#razon_social_destino").attr('disabled', true);
    			    	}else{
    			    		
    			    		mostrarMensaje(msg.mensaje,"FALLO");
							$("#identificador_destino").val('');
							$("#razon_social_destino").val('');
							
    			    		
    				    }
    			    		
    			   },
    			    error: function(jqXHR, textStatus, errorThrown){
    			    	$("#cargando").delay("slow").fadeOut();
						
    			    	mostrarMensaje("ERR: ERROR EN LA CONEXION A LOS SERVICIOS GUBERNAMENTALES..! ","FALLO");
    			    	$('#detalleItem #estadoConsulta').html('Error en la conexion con el servicio intente mas tarde ó puede ingresar de forma manual los datos..!').addClass("alerta");
						$("#razon_social_destino").attr('disabled', false);
    			    	
    			    },
    		        complete: function(){
    		        	$("#cargando").delay("slow").fadeOut();
    		        }
    			});

			 });

			 $("#identificador_destino").click(function (event){
				mostrarMensaje("","");
				$("#identificador_destino").val('');
				$("#razon_social_destino").val('');
				$("#parroquia_destino").val('');
				$("#direccion_destino").val('');
				$("#razon_social_destino").attr('disabled', true);
			 });
   function datosOrigen(opt){

	   if(opt=='bloquear'){
    		$("#provincia").attr('disabled', true);
    		$("#sitio_origen").attr('disabled', true);
    		$("#area_origen").attr('disabled', true);
    		$("#tipo_producto_movilizar_canal").attr('disabled', true);
    		$("#producto_movilizar").attr('disabled', true);

    		$("#identificador_destino").attr('disabled', true);
    		$("#razon_social_destino").attr('disabled', true);
    		$("#provincia_destino").attr('disabled', true);
    		$("#canton_destino").attr('disabled', true);
    		$("#parroquia_destino").attr('disabled', true);
    		$("#direccion_destino").attr('disabled', true);

    		$("#identificador_operador_transportista").attr('disabled', true);
    		$("#contenedor").attr('disabled', true);
    		$("#buscar_trans").attr('disabled', true); 
    		
    		$("#tipo_movilizacion_canal").attr('disabled', true);
	   }else{
		    $("#provincia").attr('disabled', false);
			$("#sitio_origen").attr('disabled', false);
			$("#area_origen").attr('disabled', false);
			$("#tipo_producto_movilizar_canal").attr('disabled', false);
			$("#producto_movilizar").attr('disabled', false);

			$("#identificador_destino").attr('disabled', false);
    		$("#razon_social_destino").attr('disabled', false);
    		$("#provincia_destino").attr('disabled', false);
    		$("#canton_destino").attr('disabled', false);
    		$("#parroquia_destino").attr('disabled', false);
    		$("#direccion_destino").attr('disabled', false);

    		$("#identificador_operador_transportista").attr('disabled', false);
    		$("#contenedor").attr('disabled', false);
    		$("#buscar_trans").attr('disabled', false);

    		$("#tipo_movilizacion_canal").attr('disabled', false);
		   }
	   
   }

   function subproductobus(id){
	var fecha_produccion = '';

			if ($("#fecha_creacion_produccion_avicola option:selected").val() != undefined){
				fecha_produccion = $("#fecha_creacion_produccion_avicola").val();  
			}

			if ($("#fecha_creacion_produccion option:selected").val() != undefined){
				fecha_produccion = $("#fecha_creacion_produccion").val();
			}
			if ($("#fecha_creacion_produccion_subporducto option:selected").val() != ''){///////////////////////////////////////6666666666666666666666666666666666666666
				fecha_produccion = $("#fecha_creacion_produccion_subporducto").val();
			}
	   if($("#"+id).val() != ''){
		   event.stopImmediatePropagation();
     	  if($("#tipo_especie").val() != '' || $("#producto_movilizar").val() == 'Canal con subproductos'){
          	 if($("#tipo_producto_movilizar_canal").val() != '' || $("#producto_movilizar").val() == 'Canal con subproductos'){
          	 mostrarMensaje("", "");
                  		 $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
                  		  $.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/saldoDisponibleSubProducto", 
                  	              {
                  			          tipo_producto_movilizar_canal:$("#tipo_producto_movilizar_canal").val(),
                  			          fecha_faenamiento:$("#fecha_produccion").val(),
                  			          producto_agregado:$("#producto_agregado").val(),
                      			      tipo_especie:$("#tipo_especie").val(),
                      			      subproducto:$("#"+id).val(),
                      			      id_emision_certificado:$("#id_emision_certificado").val(),
                      			      fecha_creacion_produccion:fecha_produccion,
									  producto_movilizar:$("#producto_movilizar").val(),

                  	              }, function (data) {
                  	            	 $("#cargarMensajeTemporal").html("");
                  	              	if (data.estado === 'EXITO') {
                      	              	if(id == 'subproducto'){
                  	              		    $("#saldo_disponible_spam").html(data.total);
                  	              		    $("#saldo_disponible").val(data.total);
                  	              		    $("#cantidad_movilizar").removeAttr("disabled");
                  	              		    $("#cantidad_movilizar").html(data.contenido);
                      	              	}else{
                          	              	$("#saldo_disponible_spam_sub").html(data.total);
                   	              		    $("#saldo_disponible").val(data.total);
                   	              		    $("#cantidad_movilizar_sub").removeAttr("disabled");
                   	              		    $("#cantidad_movilizar_sub").html(data.contenido);
                      	              	}
                  	              		    
                  	              		    $("#id_registro_produccion").val(data.idRegistroProduccion);
                  		                    mostrarMensaje(data.mensaje, data.estado);
                  	                  } else {
                  	                	 $("#cantidad_movilizar").html('<option value="">Seleccionar...</option>');
                  	                	 $("#saldo_disponible").val(0);
                  	                	 $("#saldo_disponible_spam").html('');

                  	                	if(id == 'subproducto'){
                  	              		    $("#saldo_disponible_spam").html('');
                  	              		    $("#cantidad_movilizar").removeAttr("disabled");
                  	              		    $("#cantidad_movilizar").html('<option value="">Seleccionar...</option>');
                      	              	}else{
                          	              	$("#saldo_disponible_spam_sub").html('');
                   	              		    $("#cantidad_movilizar_sub").removeAttr("disabled");
                   	              		    $("#cantidad_movilizar_sub").html('<option value="">Seleccionar...</option>');
                      	              	}
                      	              	
                  	                  	 mostrarMensaje(data.mensaje, "FALLO");
                  	                  }
                  	      }, 'json');
       		  }else{
       			 $("#saldo_disponible").val(0); 
       			 $("#saldo_disponible_spam").html('');
       		  }
     	  }else{
     		  $("#tipo_especie").addClass("alertaCombo");
         	  }
	   }
  	  }
   $("#producto_agregado").change(function (event){
	   if($("#producto_agregado").val() != ''){
           $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
        	  $.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/buscarSubproductos", 
                   {
        		         tipoEspecie:$("#tipo_especie").val(),
        		         fechaProduccion:$("#fecha_produccion").val(),
        		         producto_movilizar:$("#producto_movilizar").val(),
        		         producto_agregado:$("#producto_agregado").val()
        		         
                   }, function (data) {
                 	 $("#cargarMensajeTemporal").html("");
                   	if (data.estado === 'EXITO') {
                   		    $("#subproducto_sub").html(data.contenido);
        	                    mostrarMensaje(data.mensaje, data.estado);
        	                    distribuirLineas();
                       } else {
                     	 $("#subproducto_sub").html('<option value="">Seleccionar...</option>');
                       	 mostrarMensaje(data.mensaje, "FALLO");
                       }
           }, 'json');
	   }
   });


   $("#agregarSubProductosMovilizar").click(function(event){
		event.preventDefault();
		$(".alertaCombo").removeClass("alertaCombo");
		mostrarMensaje("", "");
		var error = false;
		if(verificarCamposSubproducto()){
			error=true;
		}
   	 if (!error) {
	
		var fecha_produccion = '';

			if ($("#fecha_creacion_produccion_avicola option:selected").val() != undefined){
				fecha_produccion = $("#fecha_creacion_produccion_avicola").val();  
			}

			if ($("#fecha_creacion_produccion option:selected").val() != undefined){
				fecha_produccion = $("#fecha_creacion_produccion").val();
			}
        			$("#estado").html("").removeClass('alerta');
        			$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
        	    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/agregarSubProductosMovilizar", 
        	                {
        	        	       producto_movilizar:$("#producto_movilizar").val(),
        	        	       producto_agregado:$("#producto_agregado").val(),
        	        	       fecha_produccion:$("#fecha_produccion").val(),
        	        	       tipo_especie:$("#tipo_especie").val(),
        	        	       tipo_producto_movilizar_canal:$("#tipo_producto_movilizar_canal").val(),
        	        	       tipo_movilizacion_canal:$("#tipo_movilizacion_canal").val(),
        	        	       subproducto:$("#subproducto_sub").val(),
        	        	       saldo_disponible:$("#saldo_disponible").val(),
        	        	       cantidad_movilizar:$("#cantidad_movilizar_sub").val(),
        	        	       id_emision_certificado: $("#id_emision_certificado").val(),
        	        	       id_registro_produccion:$("#id_registro_produccion").val(),
        	        	       fecha_creacion_produccion:fecha_produccion,
        	    	  		         		  		     
        	                }, function (data) {
        	                $("#cargarMensajeTemporal").html("");
        	                	if (data.estado === 'EXITO') {
        	                		    $("#subproductosAgregados").html(data.contenido);
        	                		    $("#subproductosCanalEmision").val('Agregado');
        	                		    datosOrigen('bloquear');
        	                		    limpiarCamposSubproducto();
        	    	                    mostrarMensaje(data.mensaje, data.estado);
        	                        } else {
        	                        	if(data.contenido==''){
        	                        		$("#subproductosAgregados").html(data.contenido);
        	                        		$("#subproductosCanalEmision").val('');
                	                    }
        	                        	mostrarMensaje(data.mensaje, "FALLO");
        	                        }
        	            }, 'json');
        		
   	 }else{
   		 $("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
       	 }
	});

	$("#area_origen").change(function (event){
		$("#centroFaenamiento").removeClass("alertaCombo");
	});


	$(document).on('change',"#codigo_canal", function(event){
		var tipoMovilizacionCanal = $("#tipo_movilizacion_canal option:selected").text();
		event.preventDefault();
		if ( tipoMovilizacionCanal != "Entera"){
   			var separador = '-';
    		var datoSeparado = ($("#codigo_canal option:selected").text()).split(separador);
			datoSeparado[1];
			if(datoSeparado[1] == "M" || datoSeparado[1] == "Saldo"){
				event.preventDefault();
				asignarvalorComboDestino("Varios destinos");
			}else{
				event.preventDefault();
				asignarvalorComboDestino("null");
			}
		}else{
			$("#destino").val('Un destino');
         	$("#destino").attr('disabled', true);
		}
 	});


	function asignarvalorComboDestino(opcion) {
		event.stopImmediatePropagation();
		$.post("<?php echo URL ?>EmisionCertificacionOrigen/Base/comboDestino1", 
		{
			opcion : opcion
		},
			function (data) {	
				$("#destino").html(data);
				$("#destino").attr('disabled', false);
		});
		   
	}
	


	$(document).on('change',"#fecha_creacion_produccion_avicola", function(){
		event.stopPropagation();
			if($("#fecha_creacion_produccion_avicola").val() != ''){
				$("#tipo_producto_movilizar_canal").val('');
				$("#saldo_disponible_spam").val('');
				$("#cantidad_movilizar").empty()	;
			}
 	});

	 $(document).on('change',"#fecha_creacion_produccion", function(){
		event.stopPropagation();
			if($("#fecha_creacion_produccion_avicola").val() != ''){
				$("#tipo_producto_movilizar_canal").val('');
				$("#saldo_disponible_spam").val('');
				$("#cantidad_movilizar").empty();
				$("#tipo_movilizacion_canal").val('');
			}
 	});

	function quitarAcentos(cadena){
		const acentos = {'á':'a','é':'e','í':'i','ó':'o','ú':'u','Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
		return cadena.split('').map( letra => acentos[letra] || letra).join('').toString();	
	}

	$(document).on('change',"#fecha_creacion_produccion_subporducto", function(){

		if ($("#fecha_creacion_produccion_subporducto").val() !=''){

			$.post("<?php echo URL ?>EmisionCertificacionOrigen/emisionCertificado/buscarSoloSubproductos", 
			{
				tipoEspecie:$("#tipo_especie").val(),
				fechaProduccion:$("#fecha_produccion").val(),
				producto_movilizar:$("#producto_movilizar").val(),
				fecha_creacion_produccion:$("#fecha_creacion_produccion_subporducto").val()
				
			}, function (data) {
				$("#cargarMensajeTemporal").html("");
				if (data.estado === 'EXITO') {
					$("#divCarga").html(data.valores);
					$("#agregarDetalleMov").show();
					$("#divProductosagregados").hide();
					$("#codigo_canal").html(data.canal);
					$("#codigo_canal").removeAttr("disabled");
						$("#subproducto").html(data.contenido);
						
						$("#subproducto").removeAttr("disabled");
						mostrarMensaje(data.mensaje, data.estado);
						distribuirLineas();
				} else {
					$("#subproducto").html('<option value="">Seleccionar...</option>');
					mostrarMensaje(data.mensaje, "FALLO");
				}
			}, 'json');
		}else{

		}
	});










</script>
