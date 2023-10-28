<header>
	<h1><?php echo $this->accion; ?></h1>
</header>
<form id='formulario' data-rutaAplicacion='<?php echo URL_MVC_FOLDER; ?>EmisionCertificacionOrigen' 
     data-opcion='registroProduccion/guardarProduccion' data-destino="detalleItem" data-accionEnExito ="ACTUALIZAR" method="post">
	  <input type="hidden" id="emergente" name="emergente" value="emergenteProduccion"/>
	 <input type="hidden" id="especie" name="especie" value=""/>																		  
	<fieldset id="centroFaenamiento">
		<legend>Datos Centro de Faenamiento</legend>				

		<div data-linea="1">
			<label for="provincia">Provincia: </label>
			
				<?php echo $this->labelProvinciaTecnico();?>
		
		</div>
		
		<div data-linea="1">
			<label for="ruc">RUC: </label>
			<input type="text" id="ruc" name="ruc" />
		</div>	

		<div data-linea="2">
			<label for="sitio">Sitio: </label>
			<select id="sitio" >
				<option value="">Seleccionar....</option>
			</select>
			<input type="hidden" id="id_sitio" name="id_sitio" />
		</div>				

		<div data-linea="2">
			<label for="area">Área: </label>
			<select id="area" >
				<option value="">Seleccionar....</option>
			</select>
			<input type="hidden" id="id_area" name="id_area" />
		</div>				

					
		
	</fieldset >
	<fieldset id="produccionDiariaAgregada">
		<legend>Producción Emergente</legend>
		
		<div data-linea="1">
			<label for="tipo_especie">Especie: </label>
			<select id="tipo_especie">
			    <option value="">Seleccionar....</option>
				<?php //echo $this->especie;?>
			</select>
			
		</div>

		<div data-linea="2" id="recepcionContenedor" >
				<div id="fechaRecepcion1">
					<label for="fecha_recepcion">F.R: </label>
						<input type="text" id="fecha_recepcion1" name="fecha_recepcion1" placeholder="Fecha de recepción" readonly/>
						<input type="text" id="fecha_recepcion2" name="fecha_recepcion2" placeholder="Fecha de recepcion" readonly/>
                </div>		
			</div>
			<div data-linea="2" id="recepcionContenedor">
				<div id="horaInicioR">
					<label for="hora_inicio_r">Hora Inicio: </label>
					<input type="time" id="hora_inicio_r" name="hora_inicio_r" value="" placeholder="00:00"  />
				</div>	
			</div>
			<div data-linea="2" id="recepcionContenedor">
				<div id="horaFinR">
					<label for="hora_fin_r">Hora Fin: </label>
					<input type="time" id="hora_fin_r" name="hora_fin_r" value="" placeholder="00:00" />
				</div>	
			</div>

			<div data-linea="3" id="faenamientoContenedor" >
				<div id="fechaFaenamiento1">
					<label for="fecha_faenamiento" id='labelFechaF'>F.F: </label>
					<input type="text" id="fecha_faenamiento1" name="fecha_faenamiento1" placeholder="Fecha de faenamiento" readonly/>
					<input type="text" id="fecha_faenamiento2" name="fecha_faenamiento2" placeholder="Fecha de faenamiento" readonly/>
                </div>		
			</div>
			<div data-linea="3" id="faenamientoContenedor">
				<div id="horaInicioF">
				<label for="hora_inicio_f">Hora Inicio: </label>
								<input type="text" id="hora_inicio_f" name="hora_inicio_f" placeholder="00:00" readonly />
				</div>	
			</div>
			<div data-linea="3" id="faenamientoContenedor">
				<div id="horaFinF">
				    <label for="hora_fin_f">Hora Fin: </label>
						<input type="time" id="hora_fin_f" name="hora_fin_f" placeholder="00:00" />
				</div>	
			</div>
		
       <div data-linea="4">
			<label for="num_animales_recibidos">N° Animales recibidos: </label>
			<select id="num_animales_recibidos">
				<?php //echo $this->comboNumeros(500);?>
			</select>		
			</div>	
		<div data-linea="5">
			<label for="num_canales_obtenidos">N° Canales obtenidos: </label>
			<select id="num_canales_obtenidos">
				<option value="">Seleccionar....</option>
			</select>		
			</div>				

		<div data-linea="6">
			<label for="num_canales_obtenidos_uso">N° Canales obtenidas sin restricción de uso: </label>
			<select id="num_canales_obtenidos_uso">
				<option value="">Seleccionar....</option>
			</select>		
		</div>				

		<div data-linea="7">
			<label for="num_canales_uso_industri">N° Canales para uso industrial: </label>
			<span id="num_canales_uso_industri"> </span>	
		</div>				
		<div data-linea="8">
			<button type="button" class="guardar" id="produccionDiaria">Agregar</button>
		</div>
	</fieldset >
	<fieldset>
		<legend>Productos agregados</legend>	
		<div id="productosAgregados" style="width:100%"><?php echo $this->productosAgregados;?></div>			
		
	</fieldset >
	<fieldset id="subproductosSN">
		<legend>Producción Emergente: Subproductos</legend>				

		<div data-linea="1" id="opcionRadio">
			<label for="id_registro_produccion">Se obtuvieron subproductos: </label>
			<input  name="resultado" type="radio"  id="Si"   value="Si" onclick="verificarOpcion(id);"><span> Si</span>&nbsp;&nbsp;&nbsp;&nbsp;
			<input  name="resultado" type="radio"  id="No" value="No" onclick="verificarOpcion(id);"><span> No</span>&nbsp;&nbsp;&nbsp;&nbsp;

		</div>				

		<div data-linea="2" id="campoEspecie">
			<label for="tipo_especie_sub">Productos agregados: </label>
			<select id="tipo_especie_sub">
				<option value="">Seleccionar....</option>
			</select>
		</div>				
		<div data-linea="3" id="campoSubproducto">
			<label for="subproducto">Subproducto: </label>
			<select id="subproducto">
				<option value="">Seleccionar....</option>
			</select>
		</div>	
		<div data-linea="4" id="campoCantidad">
			<label for="cantidad">Cantidad: </label>
			<select id="cantidad">
				<option value="">Seleccionar....</option>
			</select>
		</div>				

		<div data-linea="7" id="campoAgregar">
			<button type="button" id="agregarSubproducto" class="guardar">Agregar</button>
		</div>
	</fieldset >
	<fieldset>
		<legend>Subproductos agregados</legend>				
       <div id="subProductosAgregados" style="width:100%">
       <?php echo $this->subProductosAgregados;?></div>	
		
	</fieldset >
	<div data-linea="7">
			<button type="submit"  id="buttonGuardar"  class="guardar">Guardar</button>
		</div>
		<div data-linea="7">
			<button type="button" class="" id="borrarRegistro">Eliminar</button>
		</div>
		<input type="hidden" name="tipo" value="<?php echo $this->tipo;?>">
</form >
 <div id="cargarMensajeTemporal"></div>
<script type ="text/javascript">
var visualizar  = <?php echo json_encode($this->visualizar);?>;
var idproducto  = <?php echo json_encode($this->idRegistro);?>;
var tipo = <?php echo json_encode($this->tipo);?>; 
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
		$("#estado").html("");
		$("#campoEspecie").hide();
		$("#campoSubproducto").hide();
		$("#campoCantidad").hide();
		$("#campoAgregar").hide();
		$("#borrarRegistro").hide();
		$("#labelFechaF").hide();
		
		
		$("#num_animales_recibidos").numeric();
		$("#num_canales_obtenidos").numeric();
		$("#num_canales_obtenidos_uso").numeric();
		$("#num_canales_uso_industri").numeric();

		if(visualizar=='si'){
			$("#produccionDiariaAgregada").hide();
			$("#produccionDiaria").hide();
			$("#buttonGuardar").hide();
			$("#subproductosSN").hide();
			$("#centroFaenamiento").hide();
		}
		if(visualizar=='eliminar'){
			$("#produccionDiariaAgregada").hide();
			$("#buttonGuardar").hide();
			$("#subproductosSN").hide();
			$("#produccionDiaria").hide();
			$("#centroFaenamiento").hide();
 			$("#borrarRegistro").show();
		}

		$("#recepcionContenedor").hide();
		$("#faenamientoContenedor").hide();

		$("#fecha_recepcion1").hide();
		$("#fecha_recepcion2").hide();

		$("#fecha_faenamiento1").hide();
		$("#fecha_faenamiento2").hide();

		$("#horaInicioR").hide();
		$("#horaFinR").hide();

		$("#horaInicioF").hide();
		$("#horaFinF").hide();

		$("#fecha_recepcion2").prop('disabled', false);
		
		

	 });

	$("#formulario").submit(function (event) {
		event.preventDefault();
		var error = false;
		$(".alertaCombo").removeClass("alertaCombo");
		var resultado =  $("input[name='resultado']").map(function(){ if($(this).prop("checked")){return $(this).val();}}).get();
		if(resultado == ''){
			error=true;
			$("#opcionRadio").addClass("alertaCombo");
			}
		if (!error) {
			abrir($(this), event, false);
			abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
	});


//fechas para las especies de Avicola,cunicola
	  $("#fecha_recepcion1").datepicker({
    	yearRange: "c:c",
    	changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
        minDate: -1,
        maxDate: 0,
        onSelect: function(dateText, inst) {

        	var fecha = new Date($('#fecha_recepcion1').datepicker('getDate'));
			var fechaMinima = new Date($('#fecha_recepcion1').datepicker('getDate'));
        	
    		fecha.setDate(fecha.getDate()+1);
    	  	fecha.setMonth(fecha.getMonth());
    		fecha.setUTCFullYear(fecha.getUTCFullYear()); 
        }
        
      });

	  $("#fecha_recepcion2").datepicker({
    	yearRange: "c:c",
    	changeMonth: false,
        changeYear: false,
        dateFormat: 'yy-mm-dd',
        minDate: -1,
        maxDate: 0,
        onSelect: function(dateText, inst) {

        	var fecha = new Date($('#fecha_recepcion2').datepicker('getDate'));
			var fechaMinima = new Date($('#fecha_recepcion2').datepicker('getDate'));

			fechaObtenida = (fecha.getFullYear()+"-"+((fecha.getMonth() > 8) ? (fecha.getMonth() + 1) : ('0' + (fecha.getMonth() + 1)))+"-"+((fecha.getDate() > 9) ? fecha.getDate() : ('0' + fecha.getDate())));

			$('#fecha_faenamiento2').val(fechaObtenida);
        }
      });
	


	 $("#num_animales_recibidos").change(function (event){
    	 if($("#num_animales_recibidos").val() != ''){
    		  $.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/listarCanalObtenido", 
    	              {
    			         numCanalesObtenidos:$("#num_animales_recibidos").val(),
    	              }, function (data) {
    	              	if (data.estado === 'EXITO') {
    	              		    $("#num_canales_obtenidos").html(data.contenido);
    	              		    $("#num_canales_obtenidos_uso").html('<option value="">Seleccionar....</option>');
    	              		    $("#num_canales_uso_industri").html('');
    		                    mostrarMensaje(data.mensaje, data.estado);
    	                  } else {
    	                  	mostrarMensaje(data.mensaje, "FALLO");
    	                  }
    	      }, 'json');
		  }
    });
	    
	 $("#num_canales_obtenidos").change(function (event){
    	 if($("#num_canales_obtenidos").val() != ''){
    		  $.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/listarCanalSinRestrUso", 
    	              {
    			         numCanalesObtenidos:$("#num_canales_obtenidos").val(),
    	              }, function (data) {
    	              	if (data.estado === 'EXITO') {
    	              		    $("#num_canales_obtenidos_uso").html(data.contenido);
    	              		    $("#num_canales_uso_industri").html('');
    		                    mostrarMensaje(data.mensaje, data.estado);
    	                  } else {
    	                  	mostrarMensaje(data.mensaje, "FALLO");
    	                  }
    	      }, 'json');
		  }
    });
    
	 $("#num_canales_obtenidos_uso").change(function (event){
	   	 if($("#num_canales_obtenidos_uso").val() != ''){
	   		  $.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/listarCanalIndustr", 
	   	              {
	   			         numCanalesObtenidos:$("#num_canales_obtenidos").val(),
	   			         numCanalesObtenidosUso:$("#num_canales_obtenidos_uso").val(),
	   	              }, function (data) {
	   	              	if (data.estado === 'EXITO') {
	   	              		    $("#num_canales_uso_industri").html(data.contenido);
	   		                    mostrarMensaje(data.mensaje, data.estado);
	   	                  } else {
	   	                  	mostrarMensaje(data.mensaje, "FALLO");
	   	                  }
	   	      }, 'json');
			  }
	   });


    $("#produccionDiaria").click(function (event){
      	event.preventDefault();
		var error = false;
		$(".alertaCombo").removeClass("alertaCombo");

		if(!$.trim($("#tipo_especie").val())){
			   $("#tipo_especie").addClass("alertaCombo");
			   error = true;
		}else{
			if($("#especie").val() == ''){
				$("#especie").val($("#tipo_especie").val());
			}
		}
		if(!$.trim($("#num_animales_recibidos").val())){
			   $("#num_animales_recibidos").addClass("alertaCombo");
			   error = true;
		}
		if(!$.trim($("#num_canales_obtenidos").val())){
			   $("#num_canales_obtenidos").addClass("alertaCombo");
			   error = true;
		}
		if(!$.trim($("#num_canales_obtenidos_uso").val())){
			   $("#num_canales_obtenidos_uso").addClass("alertaCombo");
			   error = true;
		}

		var especie = ($( "#tipo_especie" ).val().replace(/ /g, ""));
		if(especie == "Avícola" || especie == "Porcinos" || especie == "Cunícola" || especie == "Cavia"){
			if(!$.trim($("#fecha_faenamiento1").val())){
			   $("#fecha_faenamiento1").addClass("alertaCombo");
			   error = true;
			}
			if(!$.trim($("#fecha_recepcion1").val())){
			   $("#fecha_recepcion1").addClass("alertaCombo");
			   error = true;
			}
			if(!$.trim($("#hora_inicio_f").val())){
			   $("#hora_inicio_f").addClass("alertaCombo");
			   error = true;
			}
			if(!$.trim($("#hora_fin_f").val())){
			   $("#hora_fin_f").addClass("alertaCombo");
			   error = true;
			}
			if(!$.trim($("#hora_inicio_r").val())){
			   $("#hora_inicio_r").addClass("alertaCombo");
			   error = true;
			}
			if(!$.trim($("#hora_fin_r").val())){
			   $("#hora_fin_r").addClass("alertaCombo");
			   error = true;
			}

		}else{
			if(!$.trim($("#fecha_faenamiento2").val())){
			   $("#fecha_faenamiento2").addClass("alertaCombo");
			   error = true;
			}
			if(!$.trim($("#fecha_recepcion2").val())){
			   $("#fecha_recepcion2").addClass("alertaCombo");
			   error = true;
			}
		}

		
		if (!error) {
		
			// $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
			$("#fecha_faenamiento").attr('disabled',false);
			 $.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/agregarProduccion", 
     	              {
						emergente: $("#emergente").val(),																 
				         fecha_recepcion : $("#fecha_recepcion1").val() != '' ? $("#fecha_recepcion1").val() : $("#fecha_recepcion2").val(),
				         fecha_faenamiento : $("#fecha_faenamiento1").val() != '' ? $("#fecha_faenamiento1").val() : $("#fecha_faenamiento2").val(),
						 hora_inicio_faenamiento : $("#hora_inicio_f").val() != '' ? $("#hora_inicio_f").val() : '',
						 hora_fin_faenamiento : $("#hora_fin_f").val() != '' ? $("#hora_fin_f").val() : '',
						 hora_inicio_recepcion : $("#hora_inicio_r").val() != '' ? $("#hora_inicio_r").val() : '',
						 hora_fin_recepcion : $("#hora_fin_r").val() != '' ? $("#hora_fin_r").val() : '',        				
						 tipo_especie : $("#tipo_especie").val(),
        				 num_animales_recibidos : $("#num_animales_recibidos").val(),
        				 num_canales_obtenidos : $("#num_canales_obtenidos").val(),
        				 num_canales_obtenidos_uso : $("#num_canales_obtenidos_uso").val(),
          				 num_canales_uso_industri : $("#num_canales_obtenidos").val() - $("#num_canales_obtenidos_uso").val(),
           				 menores : 'si',
						 id_sitio : $("#id_sitio").val(),
						 id_area : $("#id_area").val(),
						 ruc : $("#ruc").val()
        			         
     	              }, function (data) {
     	            	 $("#cargarMensajeTemporal").html("");
     	              	if (data.estado === 'EXITO') {
     	              		$("#productosAgregados").html(data.contenido);
     	              		$("#tipo_especie_sub").html(data.subContenido);
     	              		$("#subproducto").val('');
    	            		$("#cantidad").val('');
		                    mostrarMensaje(data.mensaje, data.estado);
		                    distribuirLineas();
		                    limpiarProduccion();
     	                  } else {
     	                  	mostrarMensaje(data.mensaje, "FALLO");
     	                  	$("#subproducto").val('');
    	            		$("#cantidad").val('');
     	                  }
     	      }, 'json');
			   limpiarCampos();
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
      });

    function eliminarProducto(id){
    	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/eliminarProduccion", 
	              {
			     id:id,
				 ruc : $("#ruc").val()
	              }, function (data) {
	            	 $("#cargarMensajeTemporal").html("");
	              	if (data.estado === 'EXITO') {
	              		$("#productosAgregados").html(data.contenido);
	              		$("#tipo_especie_sub").html(data.subContenido);
	              		$("#subproducto").val('');
	            		$("#cantidad").val('');
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
	                  } else {
	                  	mostrarMensaje(data.mensaje, "FALLO");
	                  }
	      }, 'json');
        }
    function verificarOpcion(id){
    	if(id=='Si'){
    		$("#campoEspecie").show();
    		$("#campoSubproducto").show();
    		$("#campoCantidad").show();
    		$("#campoAgregar").show();
    		distribuirLineas();
    	}else{
    		$("#campoEspecie").hide();
    		$("#campoSubproducto").hide();
    		$("#campoCantidad").hide();
    		$("#campoAgregar").hide();

    		$("#tipo_especie_sub").val('');
    		$("#subproducto").val('');
    		$("#cantidad").val('');
    		
    	}
    }
    
    $("#tipo_especie_sub").change(function (event){
      	 if($("#tipo_especie_sub").val() != ''){
      		$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
      		  $.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/agregarSubproducto", 
      	              {
      			         tipoEspecieSub:$("#tipo_especie_sub").val(),
      	              }, function (data) {
      	            	$("#cargarMensajeTemporal").html("");
      	              	if (data.estado === 'EXITO') {
      	              		    $("#subproducto").html(data.contenido);
      	              		    $("#cantidad").html('<option value="">Seleccionar...</option>');
      		                    mostrarMensaje(data.mensaje, data.estado);
      	                  } else {
      	                	 $("#subproducto").html('<option value="">Seleccionar...</option>');
      	                	 $("#cantidad").html('<option value="">Seleccionar...</option>');
      	                  	mostrarMensaje(data.mensaje, "FALLO");
      	                  }
      	      }, 'json');
   		  }else{
   			$("#subproducto").html('<option value="">Seleccionar...</option>'); 
   			$("#cantidad").html('<option value="">Seleccionar...</option>');
   		  }
      });
    
    $("#subproducto").change(function (event){
     	 if($("#subproducto").val() != ''){
     		  $.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/numPiezaSubproducto", 
     	              {
     						tipoEspecie:$("#tipo_especie_sub").val(),
     						numPiezas:$("#subproducto").val(),
     						subproducto:$("#subproducto option:selected").text(),
     	              }, function (data) {
     	              	if (data.estado === 'EXITO') {
     	              		    $("#cantidad").html(data.contenido);
     		                    mostrarMensaje(data.mensaje, data.estado);
     	                  } else {
     	                  	mostrarMensaje(data.mensaje, "FALLO");
     	                  }
     	      }, 'json');
  		  }else{
  			 $("#cantidad").html('<option value="">Seleccionar...</option>');
  		  }
     });

    $("#agregarSubproducto").click(function (event){
      	event.preventDefault();
		var error = false;
		$(".alertaCombo").removeClass("alertaCombo");

		if(!$.trim($("#tipo_especie_sub").val())){
			   $("#tipo_especie_sub").addClass("alertaCombo");
			   error = true;
		}
		if(!$.trim($("#subproducto").val())){
			   $("#subproducto").addClass("alertaCombo");
			   error = true;
		}
		if(!$.trim($("#cantidad").val())){
			   $("#cantidad").addClass("alertaCombo");
			   error = true;
		}
		
		if (!error) {
			$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
			 $.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/agregarSubProduccion", 
     	              {
						 emergente:$("#emergente").val(),  
				         tipo_especie_sub:$("#tipo_especie_sub").val(),
				         subproducto:$("#subproducto option:selected").text(),
				         cantidad:$("#cantidad").val(),
						 ruc:$("#ruc").val(),
        			         
     	              }, function (data) {
     	            	 $("#cargarMensajeTemporal").html("");
     	              	if (data.estado === 'EXITO') {
     	              		$("#subProductosAgregados").html(data.contenido);
		                    mostrarMensaje(data.mensaje, data.estado);
		                    $("#tipo_especie_sub").val('');
		                    $("#subproducto").val('');
		                    $("#cantidad").val('');
		                    distribuirLineas();
     	                  } else {
     	                  	mostrarMensaje(data.mensaje, "FALLO");
     	                  }
     	      }, 'json');
		} else {
			$("#estado").html("Por favor revise los campos obligatorios.").addClass("alerta");
		}
      });

    function eliminarSubproducto(id){
    	$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/eliminarSubproduccion", 
	              {
			     id:id,
				 ruc:$("#ruc").val()
	              }, function (data) {
	            	 $("#cargarMensajeTemporal").html("");
	              	if (data.estado === 'EXITO') {
	              		$("#subProductosAgregados").html(data.contenido);
	              		$("#subproducto").val('');
	            		$("#cantidad").val('');
	                    mostrarMensaje(data.mensaje, data.estado);
	                    distribuirLineas();
	                  } else {
	                  	mostrarMensaje(data.mensaje, "FALLO");
	                  }
	      }, 'json');
        }

    $("#borrarRegistro").click(function (event) {
    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/eliminarRegistro", 
	              {
			       id:idproducto
	              }, function (data) {
	            	 $("#cargarMensajeTemporal").html("");
	              	if (data.estado === 'EXITO') {
	              		abrir($("#ventanaAplicacion #opcionesAplicacion a.abierto"),"#listadoItems",true);
	                    mostrarMensaje(data.mensaje, data.estado);
	                  } else {
	                  	mostrarMensaje(data.mensaje, "FALLO");
	                  }
	      }, 'json');
	});
    
    $("#ruc").blur(function (event){
		mostrarMensaje("", "");    	
		if ( $("#ruc").val()!= ''){
			if ($('#ruc').val().length == 13){
			
				$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/buscarSitioEmergente", 
	              {
			       provincia : $("#nombre_provincia").val(),
				   ruc : $("#ruc").val(),
	              }, function (data) {
	            	  $("#cargarMensajeTemporal").html("");
	              		if (data.estado === 'EXITO') {
	              			$("#sitio").html(data.contenido);
	                  	 	mostrarMensaje(data.mensaje, data.estado);
	                  	} else {
	                  		mostrarMensaje(data.mensaje, "FALLO");
	                  	}
	      		}, 'json');
    	
			}else{
				mostrarMensaje("Por favor Ingrese un RUC valido.", "FALLO");
			}
		}else{
			mostrarMensaje("Por favor Ingrese el RUC del operador.", "FALLO");
		}
	});
    $("#area").change(function (event){
    	if($("#area").val() != ''){
        $("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/buscarEspecieEmergente", 
	              {
			       id:$("#area").val(),
			       ruc:$("#ruc").val()
	              }, function (data) {
	                $("#cargarMensajeTemporal").html("");
	              	if (data.estado === 'EXITO') {
	              		$("#tipo_especie").html(data.contenido);
	              		$("#codigo_area").val(data.codigo);
	                    mostrarMensaje(data.mensaje, data.estado);
	                  } else {
	                  	mostrarMensaje(data.mensaje, "FALLO");
	                  }
	      }, 'json');
    	}else{
    		$("#tipo_especie").html('<option value="">Seleccionar....</option>');
    		$("#codigo_area").val('');
        	}
	});

	function limpiarProduccion(){
		$("#fecha_faenamiento").val('');
	    $("#fecha_recepcion").val('');
	    $("#tipo_especie").val('');
		$("#num_animales_recibidos").val('');
        $("#num_canales_obtenidos").val('');
        $("#num_canales_obtenidos_uso").val('');
        $("#num_canales_uso_industri").html('');
		}
	// $("#tipo_especie").change(function (event){
	// 		if($("#tipo_especie").val() != ''){
	// 			$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
	// 			$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/comboAnimalesRecibidos", 
	// 					{
	// 						tipoEspecie:$("#tipo_especie").val(),
	// 					}, function (data) {
	// 						$("#cargarMensajeTemporal").html("");
	// 						if (data.estado === 'EXITO') {
	// 								$("#num_animales_recibidos").html(data.contenido);
	// 								mostrarMensaje(data.mensaje, data.estado);
	// 						} else {
	// 							$("#num_animales_recibidos").html('<option value="">Seleccionar...</option>');
	// 							mostrarMensaje(data.mensaje, "FALLO");
	// 						}
	// 			}, 'json');
	// 		}else{
	// 			$("#num_animales_recibidos").html('<option value="">Seleccionar...</option>');
	// 		}
    // });

	 

		

	$( "#tipo_especie" ).change(function(event) {
			
			var especie = ($( "#tipo_especie" ).val().replace(/ /g, ""));
			if(especie !=''){
					
									   
										 
   
																									   
								   
							  
							
					
					limpiarCampos();
					$("#faenamientoContenedor").show();
					$("#recepcionContenedor").show();				
				
					if(especie == "Avícola" || especie == "Porcinos" || especie == "Cunícola" || especie == "Cavia"){
						$("#fecha_recepcion1").show();
						$("#horaInicioR").show();
						$("#horaFinR").show();	
						
						$("#fecha_faenamiento2").hide();
						$("#fecha_recepcion2").hide();


					}else{
						$("#labelFechaF").show();
						$("#fecha_faenamiento1").hide();
						$("#fecha_recepcion1").hide();
						$("#horaInicioF").hide();
						$("#horaFinF").hide();
						$("#horaInicioR").hide();
						$("#horaFinR").hide();

						$("#fecha_recepcion2").show();
						$("#fecha_faenamiento2").show();
						
					}
			}else{
				$("#faenamientoContenedor").hide();
				$("#recepcionContenedor").hide();
			
			}

			mostrarMensaje("", "");
			if($("#emergente").val() == 'emergenteProduccion'){
			
				if(especie == "Avícola" || especie == "Porcinos" || especie == "Cunícola" || especie == "Cavia"){
					$("#recepcionContenedorVista").hide();
					mostrarMensaje("No puede realizar una producción de este tipo de especie...!", "FALLO");
				}else{
					
					$("#fecha_recepcion2").show();
						$("#fecha_faenamiento2").show();
						$("#recepcionContenedorVista").show();
						$("#faenamientoContenedor").show();
					if($("#tipo_especie").val() != ''){
					$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
					$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/comboAnimalesRecibidos", 
							{
								tipoEspecie:$("#tipo_especie").val(),
							}, function (data) {
								$("#cargarMensajeTemporal").html("");
								if (data.estado === 'EXITO') {
										$("#num_animales_recibidos").html(data.contenido);
										mostrarMensaje(data.mensaje, data.estado);
								} else {
									$("#num_animales_recibidos").html('<option value="">Seleccionar...</option>');
									mostrarMensaje(data.mensaje, "FALLO");
								}
					}, 'json');
				}else{
					$("#num_animales_recibidos").html('<option value="">Seleccionar...</option>');
				}
				}
			}else{
				
				if($("#tipo_especie").val() != ''){
					$("#cargarMensajeTemporal").html("<div id='cargando'>Cargando...</div>");
					$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/comboAnimalesRecibidos", 
							{
								tipoEspecie:$("#tipo_especie").val(),
							}, function (data) {
								$("#cargarMensajeTemporal").html("");
								if (data.estado === 'EXITO') {
										$("#num_animales_recibidos").html(data.contenido);
										mostrarMensaje(data.mensaje, data.estado);
								} else {
									$("#num_animales_recibidos").html('<option value="">Seleccionar...</option>');
									mostrarMensaje(data.mensaje, "FALLO");
								}
					}, 'json');
				}else{
					$("#num_animales_recibidos").html('<option value="">Seleccionar...</option>');
				}
				
			}
			  			
		});

		function limpiarCampos(){
			$("#faeanamientoContenedor").val('');
			$("#recepcionContenedor").val('');
			$("#fecha_faenamiento1").val('');
			$("#fecha_faenamiento2").val('');
			$("#fecha_recepcion1").val('');
			$("#fecha_recepcion2").val('');
			$("#hora_inicio_f").val('');
			$("#hora_fin_f").val('');
			$("#hora_inicio_r").val('');
			$("#hora_fin_r").val('');
			$("#labelFechaF").hide();
		}

		
		$("#hora_fin_r" ).blur(function() {
			if ($("#hora_inicio_r").val() != ''){
				mostrarMensaje("", "");
				horaSeparadaFin = separarHora($("#hora_fin_r").val());

				if (horaSeparadaFin.toString() == '00' ){
					var horaSeparadaInicio = parseInt(separarHora($("#hora_inicio_r").val()));

					if (horaSeparadaInicio == horaSeparadaFin){
						if ($("#hora_inicio_r").val() >= $("#hora_fin_r").val() ){
							mostrarMensaje("La Hora-Fin no puede ser menor que la Hora-Inicio de recepción.", "FALLO");
							$("#hora_fin_r").addClass("alertaCombo");	
							$("#hora_inicio_f").val('');
						}else{
							$("#hora_fin_r").removeClass("alertaCombo");
							calcularHora();
						}
					}else if ( parseInt(horaSeparadaInicio) >=00 && horaSeparadaInicio <= 23 ){
						if ($("#hora_inicio_r").val() > $("#hora_fin_r").val() ){
							mostrarMensaje("La Hora-Fin no puede ser menor que la Hora-Inicio de recepción.", "FALLO");
							$("#hora_fin_r").addClass("alertaCombo");	
							$("#hora_inicio_f").val('');
						}else{
							$("#hora_fin_r").removeClass("alertaCombo");
							$("#hora_inicio_r").removeClass("alertaCombo");
						calcularHora();
						}
						
					}else{
						mostrarMensaje("La Hora-Fin no puede ser menor que la Hora-Inicio de recepción.", "FALLO");
						$("#hora_fin_r").addClass("alertaCombo");	
					}
				}else {
					if ($("#hora_inicio_r").val() >= $("#hora_fin_r").val() ){
						mostrarMensaje("La Hora-Fin no puede ser menor que la Hora-Inicio de recepción.", "FALLO");
						$("#hora_fin_r").addClass("alertaCombo");	
						$("#hora_inicio_f").val('');
					}else{
						$("#hora_fin_r").removeClass("alertaCombo");
						$("#hora_inicio_r").removeClass("alertaCombo");
						calcularHora();
					}
				}

				if($("#fecha_recepcion1").val() != '' && $("#hora_inicio_r").val() != '' && $("#hora_fin_r").val() != ''){

					$("#fecha_faenamiento1").show();
					$("#horaInicioF").show();
					$("#horaFinF").show();
					$("#labelFechaF").show();
				}
			}else{
				mostrarMensaje("Debe seleccionar antes una hora de inicio..!.", "FALLO");
				$("#hora_inicio_r").addClass("alertaCombo");	
				$("#hora_fin_r").val('');
			}
			//asignar fecha faenamiento de manera automatica
			$("#fecha_faenamiento1").val($("#fecha_recepcion1").val());
		});

		$("#hora_inicio_r" ).blur(function() {

			if($("#fecha_recepcion1").val() != '' && $("#hora_inicio_r").val() != '' && $("#hora_fin_r").val() != ''){
				$("#fecha_faenamiento1").show();
				$("#horaInicioF").show();
				$("#horaFinF").show();
				$("#labelFechaF").show();
			}else{
				$("#hora_inicio_r" ).click(function() {
					$("#hora_fin_r").val('');
					$("#hora_inicio_f").val('');
				});
			}
		});


		function calcularHora(){

			horaFinFaenamiento = separarHora($("#hora_fin_r").val());
			minutoFinFaenamiento = separarHoraMinuto($("#hora_fin_r").val());

			if (horaFinFaenamiento.toString() == '00' ){

				$("#hora_inicio_f").val("04:"+minutoFinFaenamiento);

			}else if (parseInt(horaFinFaenamiento) >= 20 && parseInt(horaFinFaenamiento) <= 23 ) {
				
				horaCalculada = (parseInt(horaFinFaenamiento)+4);
				
				if (horaCalculada == 24){
					$("#hora_inicio_f").val("00:"+minutoFinFaenamiento);
				}else{
					horaInicioRecoleccion = horaCalculada - 24;
					$("#hora_inicio_f").val("0"+horaInicioRecoleccion+":"+minutoFinFaenamiento);
				}
				
			}else{
				var horaCalculada = (parseInt(horaFinFaenamiento) + 4);
				var horaTotal = (horaCalculada+":"+minutoFinFaenamiento);
				if (horaCalculada<10){	
					var horaTotal = ("0"+horaCalculada+":"+minutoFinFaenamiento);
					$("#hora_inicio_f" ).val(horaTotal);
				}else if (horaCalculada >= 10 && horaCalculada <= 23){
					$("#hora_inicio_f" ).val(horaTotal);
				}
			}
		}

		$("#hora_fin_f" ).blur(function() {
			mostrarMensaje("", "");
			horaSeparadaFin = separarHora($("#hora_fin_f").val());

			if (horaSeparadaFin.toString() == '00' ){
    			
    			var horaSeparadaInicio = parseInt(separarHora($("#hora_inicio_f").val()));

				if (horaSeparadaInicio == horaSeparadaFin){
					if ($("#hora_inicio_f").val() >= $("#hora_fin_f").val() ){
						mostrarMensaje("La Hora-Fin no puede ser menor que la Hora-Inicio de faenamiento.", "FALLO");
						$("#hora_fin_f").addClass("alertaCombo");	
					}else{
						$("#hora_fin_f").removeClass("alertaCombo");
					}
				}else {
					if ($("#hora_inicio_f").val() >= $("#hora_fin_f").val() ){
						mostrarMensaje("La Hora-Fin no puede ser menor que la Hora-Inicio de faenamiento.", "FALLO");
						$("#hora_fin_f").addClass("alertaCombo");	
					}else{
						$("#hora_fin_f").removeClass("alertaCombo");
						$("#hora_inicio_f").removeClass("alertaCombo");
					}
				}
			}else {
				if ($("#hora_inicio_f").val() >= $("#hora_fin_f").val() ){
					mostrarMensaje("La Hora-Fin no puede ser menor que la Hora-Inicio de faenamiento.", "FALLO");
					$("#hora_fin_f").addClass("alertaCombo");	
				}else{
					$("#hora_fin_f").removeClass("alertaCombo");
					$("#hora_inicio_f").removeClass("alertaCombo");
				}
			}

			
		});

		

		function separarHora(dato){
			var hora = dato;
   			var separador = ':';
    		var horaSeparada = hora.split(separador);
			return horaSeparada[0];
		}
		function separarHoraMinuto(dato){
			var hora = dato;
   			var separador = ':';
    		var horaSeparada = hora.split(separador);
			return horaSeparada[1];
		}
		
		$( "#sitio" ).change(function() {
			id_sitio = separarCadena($("#sitio").val()); 
			$("#id_sitio").val(id_sitio);
		});

		$( "#area" ).change(function() {
			id_area =  separarCadena($("#area").val());
			$("#id_area").val(id_area);
			
						$("#fecha_recepcion1").hide();
						$("#horaInicioR").hide();
						$("#horaFinR").hide();	
						
						$("#fecha_faenamiento2").hide();
						$("#fecha_recepcion2").hide();


					
						$("#labelFechaF").show();
						$("#fecha_faenamiento1").hide();
						$("#fecha_recepcion1").hide();
						$("#horaInicioF").hide();
						$("#horaFinF").hide();
						$("#horaInicioR").hide();
						$("#horaFinR").hide();

						$("#fecha_recepcion2").hide();
						$("#fecha_faenamiento2").hide();
						$("#recepcionContenedorVista").hide();
						$("#faenamientoContenedor").hide();
						
						
		});

		function separarCadena(dato){
			var codigo = dato;
   			var separador = '-';
    		var codigoSeparado = codigo.split(separador);
			return parseInt(codigoSeparado[0]);
		}

		$("#sitio").change(function (event){
    	if($("#sitio").val() != ''){
    	$.post("<?php echo URL ?>EmisionCertificacionOrigen/registroProduccion/buscarAreaEmergente", 
	              {
			       id:$("#sitio").val(),
			       ruc:$("#ruc").val()
	              }, function (data) {
	            	  $("#cargarMensajeTemporal").html("");
	              	if (data.estado === 'EXITO') {
	              		$("#area").html(data.contenido);
	                    mostrarMensaje(data.mensaje, data.estado);
	                  } else {
	                  	mostrarMensaje(data.mensaje, "FALLO");
	                  }
	      }, 'json');
    	}else{
    		$("#tipo_especie").html('<option value="">Seleccionar....</option>');
    		$("#codigo_area").val('');
    		$("#area").html('<option value="">Seleccionar....</option>');
    	}
	});
</script>
