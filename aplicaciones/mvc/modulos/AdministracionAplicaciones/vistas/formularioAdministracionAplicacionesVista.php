<header>
	<h1><?php echo $this->accion; ?></h1>
</header>

<form id="formularioAplicaciones" data-rutaAplicacion="<?php echo URL_MVC_FOLDER;?>AdministracionAplicaciones" data-opcion="AdministracionAplicaciones/guardar" data-destino="detalleItem" method="post" data-accionEnExito="ACTUALIZAR">
	<input type="hidden" id="idArea" name="idArea" value="<?php echo $this->area;?>" />
	<input type="hidden" id="tipoUsuario" name="tipoUsuario" value="<?php echo $this->tipoUsuario;?>" />
	
    <fieldset>
	    <legend>Datos del Usuario</legend>
	    
	    <div data-linea="1">
	    	<label>Identificador: </label>
	    	<input type="text" id="identificadorUsuario" name="identificadorUsuario" data-er="^[0-9]+$" required="required" maxlength="10" />
	    </div>
	    
	    <div data-linea="2" class="datosUsuario">
	    	<label>Nombre: </label>
	    	<input type="text" id="nombreUsuario" name="nombreUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="3" class="datosUsuario">
	    	<label>Tipo de Contrato: </label>
	    	<input type="text" id="tipoContratoUsuario" name="tipoContratoUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="4" class="datosUsuario">
	    	<label>Provincia contrato: </label>
	    	<input type="text" id="provinciaUsuario" name="provinciaUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="4" class="datosUsuario">
	    	<label>Cantón contrato: </label>
	    	<input type="text" id="cantonUsuario" name="cantonUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="5" class="datosUsuario">
	    	<label>Oficina contrato: </label>
	    	<input type="text" id="oficinaUsuario" name="oficinaUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="5" class="datosUsuario">
	    	<label>Unidad contrato: </label>
	    	<input type="text" id="gestionUsuario" name="gestionUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="6" class="datosUsuario datosPlanificacion">
	    	<label>Área Funcionario estructura: </label>
	    	<input type="text" id="nombreAreaUsuario" name="nombreAreaUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="7" class="datosUsuario datosPlanificacion">
	    	<label>Código área estructura: </label>
	    	<input type="text" id="areaUsuario" name="areaUsuario" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="7" class="datosUsuario datosPlanificacion">
	    	<label>Código área responsabilidad estructura: </label>
	    	<input type="text" id="areaResponsableUsuario" name="areaResponsableUsuario" readonly="readonly" />
	    </div>
	    
	</fieldset>
	
	<fieldset>
	    <legend>Datos de la Aplicación</legend>
	    
	    <div data-linea="3">
	    	<label>Módulo: </label>
	    	<select id="idModulo" name= "idModulo" required>
            	<?php echo $this->comboModulo($this->area, $this->tipoUsuario); ?>
			</select>
			
			<input type="hidden" id="codificacionModulo" name="codificacionModulo" required="required" readonly="readonly" />
	    </div>
	    
	    <div data-linea="4">
	    	<label>Perfil: </label>
	    	<select id="idPerfil" name= "idPerfil" disabled="disabled" required>
                <option value>Seleccione...</option>
			</select>
			
			<input type="hidden" id="codificacionPerfil" name="codificacionPerfil" required="required" readonly="readonly" />
		</div>
	    
	</fieldset>	
	
	<div data-linea="14">
		<button type="submit" class="guardar">Guardar</button>
	</div>
	
	<div data-linea="4">
	    	<div id="datosPerfiles"></div>
	    </div>
	
</form>

<script type="text/javascript">
	var combo = '<option value>Seleccione...</option>';
	var area = <?php echo json_encode($this->area); ?>;
	var tipoUsuario = <?php echo json_encode($this->tipoUsuario); ?>;
	
	$(document).ready(function() {
		construirValidador();
		distribuirLineas();
		$("#estado").html("");	
		$(".datosUsuario").hide();	
	});

	function esCampoValido(elemento){
		var patron = new RegExp($(elemento).attr("data-er"),"g");
		return patron.test($(elemento).val());
	}
	
	//Datos del usuario
	$("#identificadorUsuario").change(function () {
		$(".datosUsuario").hide();
		fn_limpiarDatosUsuario();
    	
        if ($("#identificadorUsuario").val() !== "") {        	
        	fn_cargarDatosUsuarioForm();
        }else{
        	$("#identificadorUsuario").val('');
        	$(".datosUsuario").hide();
        }
    });
    
    //Mostrar los datos del Usuario
	function fn_cargarDatosUsuarioForm() {
        var identificador = $("#identificadorUsuario").val();
        
        if (identificador !== '') {
        	$.post("<?php echo URL ?>AdministracionAplicaciones/AdministracionAplicaciones/mostrarDatosUsuario/", 
			{
        		identificador : identificador,
        		area : area,
        		tipoUsuario : tipoUsuario
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
        	$("#datosUsuario").val('');
        	$("#identificadorUsuario").removeAttr('disabled');
        }
    }
    
  	//Función para mostrar los datos obtenidos del operador/asociación
    function fn_cargarDatosUsuario(data) {
    	$("#nombreUsuario").val(data.funcionario);
    	$("#tipoContratoUsuario").val(data.tipo_contrato);
    	$("#provinciaUsuario").val(data.provincia);
    	$("#cantonUsuario").val(data.canton);
    	$("#oficinaUsuario").val(data.oficina);
    	$("#gestionUsuario").val(data.gestion);
    	$("#nombreAreaUsuario").val(data.nombre_area);
    	$("#areaUsuario").val(data.area_funcionario);    	
		$("#areaResponsableUsuario").val(data.area_responsable);
		$(".datosUsuario").show();
		
		if(area != 'DGPGE'){
			$(".datosPlanificacion").hide();
		}
		
    } 
    
    function fn_limpiarDatosUsuario() {
    	$("#nombreUsuario").val('');
    	$("#tipoContratoUsuario").val('');
    	$("#provinciaUsuario").val('');
    	$("#cantonUsuario").val('');
    	$("#oficinaUsuario").val('');
    	$("#gestionUsuario").val('');
    	$("#nombreAreaUsuario").val('');
    	$("#areaUsuario").val('');    	
		$("#areaResponsableUsuario").val('');
		$(".datosUsuario").hide();
    }
    
    //Lista de los módulos
    $("#idModulo").change(function () {
		$("#idPerfil").val('');
		$("#codificacionModulo").val('');
		$("#codificacionPerfil").val('');
    	
        if ($("#idModulo option:selected").val() !== "") {        	
        	fn_cargarPerfilesXAplicacionForm();
        }else{
        	$("#idPerfil").html(combo);
        	$("#idPerfil").attr('disabled', 'disabled');
        	$("#codificacionModulo").val('');
			$("#codificacionPerfil").val('');
        }
    });
    
    //Lista de perfiles por aplicación
	function fn_cargarPerfilesXAplicacionForm() {
        var idAplicacion = $("#idModulo option:selected").val();
        
        if (idAplicacion !== '') {
        	$.post("<?php echo URL ?>AdministracionAplicaciones/AdministracionAplicaciones/comboPerfilesXAplicacionXTipoUsuario/", 
			{
        		idAplicacion : idAplicacion,
        		area : area,
        		tipoUsuario : tipoUsuario
			},
            function (data) {
                $("#idPerfil").html(data);
                $("#idPerfil").removeAttr('disabled');
                $("#codificacionModulo").val($("#idModulo option:selected").attr('data-codigo'));
				$("#codificacionPerfil").val('');
            });
        }else{
        	$("#idPerfil").html(combo);
        	$("#idPerfil").attr('disabled', 'disabled');
        	$("#codificacionModulo").val('');
			$("#codificacionPerfil").val('');
        }
    }
    
    //Lista de los módulos
    $("#idPerfil").change(function () {
		$("#codificacionPerfil").val('');
    	
        if ($("#idPerfil option:selected").val() !== "") {        	
        	$("#codificacionPerfil").val($("#idPerfil option:selected").attr('data-codigo'));
        }else{
			$("#codificacionPerfil").val('');
        }
    });

	$("#formularioAplicaciones").submit(function (event) {
		event.preventDefault();
		var error = false;

		if(!$.trim($("#identificadorUsuario").val())){
        	error = true;
        	$("#identificadorUsuario").addClass("alertaCombo");
		}
		
		if(!$.trim($("#tipoContratoUsuario").val())){
        	error = true;
        	$("#tipoContratoUsuario").addClass("alertaCombo");
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