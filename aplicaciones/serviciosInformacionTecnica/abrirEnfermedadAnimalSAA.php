<?php 	session_start();	require_once '../../clases/Conexion.php';	require_once '../../clases/ControladorCatalogos.php';	require_once '../../clases/ControladorServiciosInformacionTecnica.php';		$conexion = new Conexion();;	$cc = new ControladorCatalogos();	$csit = new ControladorServiciosInformacionTecnica();	$idEnfermedad=$_POST['id'];	$qEnfermedad=$csit->abrirEnfermedadAnimal($conexion, $idEnfermedad);	$enfermedad= pg_fetch_assoc($qEnfermedad);	$tipoProducto = $cc->listarTipoProductos($conexion);	$usuarioResponsable=$_SESSION['usuario'];?><!DOCTYPE html><html><head><meta charset="utf-8"></head><body>	<header>		<h1>Modificar Enfermedades Animales</h1>	</header>	<form id="nuevoRequerimiento" data-rutaAplicacion="serviciosInformacionTecnica" data-opcion="actualizarEnfermedadAnimalSAA">		<input type="hidden" id="idEnfermedad" name="idEnfermedad" value="<?php echo $idEnfermedad;?>" /> 		<input type="hidden" id="usuarioResponsable" name="usuarioResponsable" value="<?php echo $usuarioResponsable;?>" />		<div id="estado"></div>		<fieldset>			<legend>Información de Enfermedades Animales</legend>					<div data-linea="1">					<label>Nombre:</label> 					<input type="text" id="nombreEnfermedad" name="nombreEnfermedad" value="<?php echo $enfermedad['nombre'];?>"  maxlength="512" disabled="disabled"/> 				</div>				<div data-linea="2">					<label>Descripción:</label> 				</div>				<div data-linea="4">					<textarea rows="3" cols="50" id="descripcion" name="descripcion" maxlength="512" disabled="disabled"><?php echo $enfermedad['descripcion'];?></textarea>				</div>				<div data-linea="5">					<label>Observaciones:</label> 				</div>				<div data-linea="6">					<textarea rows="3" cols="50" id="observacion" name="observacion" maxlength="512" disabled="disabled"><?php echo $enfermedad['observacion'];?></textarea>				</div>				<p>					<button id="modificar" type="button" class="editar">Modificar</button>					<button id="actualizar" type="submit" class="guardar" disabled="disabled">Guardar</button>				</p>		</fieldset>	</form>		<form id="nuevoRegistro" data-rutaAplicacion="serviciosInformacionTecnica"  >		<input type="hidden" id="idEnfermedad" name="idEnfermedad" value="<?php echo $idEnfermedad;?>">		<input type="hidden" id="usuarioResponsable" name="usuarioResponsable" value="<?php echo $usuarioResponsable;?>" />		<input type="hidden" id="opcion" name="opcion"  />				<fieldset>			<legend>Selección de Productos</legend>			<div data-linea="1">							<label>Tipo de producto: </label> 				<select id="tipoProducto" name="tipoProducto" >					<option value="">Seleccione...</option>						<?php 							while ($fila = pg_fetch_assoc($tipoProducto)){								$opcionesTipoProducto[] =  '<option value="'.$fila['id_tipo_producto']. '" data-grupo="'. $fila['id_area'] . '">'. $fila['nombre'] .'</option>';							}						?>				</select>							</div>			<div data-linea="2">							<div id="dSubTipoProducto"></div>			</div>			<div data-linea="3">				<div id="dProducto"></div>						</div>				<div data-linea="4">				<button type="submit" id="agregarDetalleRecorrido" class="mas" >Agregar</button>			</div>		</fieldset>	</form>		<fieldset>		<legend>Productos Agregados</legend>		<table id="camposDetalle" style="width:100%"  class="tablaMatriz">		<thead>		<tr>			<th>Producto</th>			<th>N° Partida</th>			<th>Eliminar</th>		</tr>		</thead>		<?php 			$qEnfermedad=$csit->listaEnfermedadNombreProducto($conexion, $idEnfermedad,$usuarioResponsable);			while ($fila = pg_fetch_assoc($qEnfermedad)){				echo $csit->imprimirLineaEnfermedadProducto($fila['id_enfermedad_producto'], $fila['nombre_producto'],$usuarioResponsable,$fila['partida_arancelaria']);
			}
		?>		</table>	</fieldset>	</body><script type="text/javascript">	var array_opcionesTipoProducto = <?php echo json_encode($opcionesTipoProducto);?>;	$(document).ready(function(){		distribuirLineas();		for(var i=0; i<array_opcionesTipoProducto.length; i++){		 $('#tipoProducto').append(array_opcionesTipoProducto[i]);  		}	});		acciones("#nuevoRegistro","#camposDetalle",null,null,new exitoIngresoo(),null,null,new validarInputs());	$("#tipoProducto").change(function(event){		$("#estado").html("").removeClass("alerta");		$(".alertaCombo").removeClass("alertaCombo");		$("#nuevoRegistro").attr('data-opcion', 'combosServicios');	    $("#nuevoRegistro").attr('data-destino', 'dSubTipoProducto');	    $("#opcion").val('subTipoProducto');	  	if($("#tipoProducto").val() == ''){			$("#tipoProducto").addClass("alertaCombo");			$("#estado").html("Por favor seleccione un tipo de producto.").addClass("alerta");		}else{			abrir($("#nuevoRegistro"), event, false); //Se ejecuta ajax, busqueda de sub tipo producto		}    	});		function validarInputs() {		var msj;	    this.ejecutar = function () {		    var error = false;	        $(".alertaCombo").removeClass("alertaCombo");	        if ($("#tipoProducto").val()==""){			   error = true;		       $("#tipoProducto").addClass("alertaCombo");		       msj='Por favor seleccione el tipo de producto.';			}			if ($("#subtipoProducto").val()==""){			   error = true;		       $("#subtipoProducto").addClass("alertaCombo");		       msj='Por favor seleccione el subtipo de producto.';			}			return !error;		};	    this.mensajeError = function () {	    	mostrarMensaje(msj, "FALLO");	    }	    	}	function exitoIngresoo(){		this.ejecutar = function(msg){			mostrarMensaje("Nuevo registro agregado","EXITO");			var fila = msg.mensaje;			$("#camposDetalle").append(fila);				$("#nuevoRegistro" + " fieldset input:not(:hidden,[data-resetear='no'])").val('');			$("#nuevoRegistro fieldset textarea").val('');		};	}		$("#modificar").click(function(){		$("#nuevoRequerimiento input").removeAttr("disabled");		$("#nuevoRequerimiento textarea").removeAttr("disabled");		$("#actualizar").removeAttr("disabled");		$(this).attr("disabled",true);	});		function validaSoloNumeros() {		 if ((event.keyCode < 48) || (event.keyCode > 57))		  event.returnValue = false;	}		$("#nuevoRequerimiento").submit(function(event){		event.preventDefault();		$(".alertaCombo").removeClass("alertaCombo");		var error = false;		if(!$.trim($("#nombreEnfermedad").val())){			error = true;			$("#nombreEnfermedad").addClass("alertaCombo");			$("#estado").html('Por favor ingrese el nombre del tipo de requerimiento').addClass("alerta");		}				if (!error){			ejecutarJson("#nuevoRequerimiento");					}	});</script></html>					