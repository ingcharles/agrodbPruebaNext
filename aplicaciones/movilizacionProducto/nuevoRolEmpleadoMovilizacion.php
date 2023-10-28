<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorMovilizacionProductos.php';

$conexion = new Conexion();
$cmp = new ControladorMovilizacionProductos();

$identificadorUsuario = $_SESSION['usuario'];
$filaTipoUsuario = pg_fetch_assoc($cmp->obtenerTipoUsuario($conexion, $identificadorUsuario));
?>
<header>
	<h1>Nuevo asignar rol</h1>
</header>
<form id='nuevoEmpleado' data-rutaAplicacion='movilizacionProducto' data-destino='detalleItem' data-opcion='guardarNuevoRolEmpleadoMovilizacion' data-accionEnExito="ACTUALIZAR">
	<input type="hidden" id="opcion" name="opcion" value="">
	<input type="hidden" id="identificacionEmpleado" name="identificacionEmpleado">
	<div id="estado"></div>
	<fieldset>
		<legend>Operador de movilización</legend>
		<div data-linea="1" >				
			<label>Operador de movilización: </label>
			<select id="operadorMovilizacion" name="operadorMovilizacion">
				<?php 
				switch ($filaTipoUsuario['codificacion_perfil']){
					case 'PFL_USUAR_INT':
						echo '<option value="0">Seleccione....</option>';
						$qEmpresas = $cmp->listaEmpresas($conexion);
						while($fila = pg_fetch_assoc($qEmpresas)){
							echo '<option value="' . $fila['id_empresa'] . '">' . $fila['nombre_empresa'] . '</option>';
						}
					break; 
					case 'PFL_USUAR_EXT':
						$qResultadoEmpleadoEmpresa = $cmp->consultarRelacionEmpleadoEmpresa($conexion, $identificadorUsuario);
						if(pg_num_rows($qResultadoEmpleadoEmpresa) != 0){
							$qEmpresas = $cmp->listaEmpresas($conexion,pg_fetch_result($qResultadoEmpleadoEmpresa, 0, 'identificador_empresa'));
							while($fila = pg_fetch_assoc($qEmpresas)){
								echo '<option value="' . $fila['id_empresa'] . '">' . $fila['nombre_empresa'] . '</option>';
							}
						}
				    break;
				}
				?>
				</select>
		</div>
	</fieldset>
	<fieldset>
		<legend>Búsqueda del empleado</legend>
		<div data-linea="1">
			<label>Identificación:</label>
			<input id="identificadorEmpleado" name="identificadorEmpleado" type="text" placeholder="Ej: 9999999999"  maxlength="13" />
		</div>
		<div data-linea="1">
			<label>Nombre:</label>
			<input name="nombreEmpleado" id="nombreEmpleado"  type="text" placeholder="Ej: David"  maxlength="250"  />
		</div>
		<div data-linea="2" style="text-align: center">
			<button type="button" id="buscarEmpleado" name="buscarEmpleado" >Buscar empleado</button>
		</div>
	</fieldset>
	<fieldset>
		<legend>Empleado</legend>
		  <div data-linea="1" id="resultadoEmpleadoRol">				
				<label>Empleado: </label>
				<select id="campoEmpleadoRol">
					<option value="0">Seleccione...</option>
				</select>		
		  </div>		 
		  <div data-linea="2">
			<label>Rol: </label> Digitador de movilización
			<input id="rol" name="rol" type="hidden" value='digitadorMovilizacion' readonly='readonly' />
		</div>  			   			   		   			   			
	</fieldset>	
	<button type="submit" class="guardar">Guardar rol</button>
</form>

<script type="text/javascript">			
    $(document).ready(function(){			
		distribuirLineas();	
		
	});

	$("#buscarEmpleado").click(function(event){
		$(".alertaCombo").removeClass("alertaCombo");
		var error = false;

		if ($("#nombreEmpleado").val().length < 3 && $("#identificadorEmpleado").val() == "") {
			$("#nombreEmpleado").addClass("alertaCombo");
	    	error = true;
	    	$("#estado").html("Por favor ingrese al menos 3 letras para buscar las coincidencias.").addClass('alerta');
	    }
	    
		if($("#identificadorEmpleado").val() == "" && $("#nombreEmpleado").val() == ""){	
			 error = true;		
			$("#identificadorEmpleado").addClass("alertaCombo");
			$("#nombreEmpleado").addClass("alertaCombo");
			$("#estado").html("Por favor ingrese al menos un campo para realizar la búsqueda.").addClass('alerta');
		}
		
		if($("#operadorMovilizacion").val() == 0 || $('#operadorMovilizacion > option').length == 0 ){	
			error = true;		
			$("#operadorMovilizacion").addClass("alertaCombo");
			$("#estado").html("Por favor seleccione el operador de movilización.").addClass('alerta');
		}
		
		if (!error){
			$("#estado").html("").removeClass('alerta');
			$('#nuevoEmpleado').attr('data-opcion','accionesMovilizacionProducto');
			$('#nuevoEmpleado').attr('data-destino','resultadoEmpleadoRol');
		    $('#opcion').val('buscarEmpleadoRol');		
			abrir($("#nuevoEmpleado"),event,false); 
		}					 		
	 });
 
    $("#nuevoEmpleado").submit(function(event){		
    	event.preventDefault();
    	$(".alertaCombo").removeClass("alertaCombo");
		var error = false;

		if($("#empleado").val() == 0 || $("#campoEmpleadoRol").val() == 0){	
			 error = true;	
			 $("#empleado").addClass("alertaCombo");
			 $("#campoEmpleadoRol").addClass("alertaCombo");	
			 $("#estado").html("Por favor seleccione el empleado.").addClass('alerta');
		}
		if($("#operadorMovilizacion").val() == 0 || $('#operadorMovilizacion > option').length == 0){	
			error = true;		
			$("#operadorMovilizacion").addClass("alertaCombo");
			$("#estado").html("Por favor seleccione el operador de movilización.").addClass('alerta');
		}

		if (!error){
			$("#nuevoEmpleado").attr('data-destino', 'detalleItem'); 
			$("#nuevoEmpleado").attr('data-opcion','guardarNuevoRolEmpleadoMovilizacion');   
			ejecutarJson("#nuevoEmpleado");
		}
	});
</script>