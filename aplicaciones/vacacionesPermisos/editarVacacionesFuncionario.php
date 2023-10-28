<?php 
	session_start();
	require_once '../../clases/Conexion.php';
	require_once '../../clases/ControladorVacaciones.php';
	
	try {
	    $conexion = new Conexion();
	    $cv = new ControladorVacaciones();
	    
	    $tmp = explode('.',$_POST['id']);
	    
	    $identificador = $tmp[0];
	    $estado = $tmp[1];
	    $anio = $tmp[2];
	    
	    $listaReporte = pg_fetch_assoc($cv->saldoUsuarioAnual($conexion, $identificador,$estado, $anio),0);
	    
	} catch (Exception $e) {
	    echo $e;
	}
	
	

?>

	<header>
		<h1>Detalle de Saldo de Funcionario</h1>
	</header>
	
	<div id="estado"></div>
	
	<form id="actualizarSaldo" data-rutaAplicacion="vacacionesPermisos" data-opcion="actualizarSaldoVacaciones" data-accionEnExito="ACTUALIZAR">
		<input type="hidden" id="identificador" name="identificador" value="<?php echo $identificador;?>">
		<input type="hidden" id="anio" name="anio" value="<?php echo $anio;?>"/>
		<input type="hidden" id="secuencial" name="secuencial" value="<?php echo $listaReporte['secuencial'];?>"/>
		<input type="hidden" id="estado" name="estado" value="<?php echo $listaReporte['activo'];?>"/>
		
		<?php 
    		$dias=floor(intval($listaReporte['minutos_disponibles'])/480);
    		$horas=floor((intval($listaReporte['minutos_disponibles'])-$dias*480)/60);
    		$minutos=(intval($listaReporte['minutos_disponibles'])-$dias*480)-$horas*60;
		?>
								
		<fieldset>
			<legend>Saldo Usuario</legend>	
			
				<div data-linea="1">
					<label>Identificador: </label> <?php echo $identificador; ?>
				</div>
				
				<div data-linea="2">
					<label>Nombre: </label> <?php echo $listaReporte['nombre'] . ' ' . $listaReporte['apellido']; ?>
				</div>
				
				<div data-linea="3">
					<label>Saldo disponible en año <?php  echo$listaReporte['anio']; ?>: </label> <?php echo $dias.' días '. $horas .' horas '. $minutos .' minutos'; ?>
				</div>
				
				<div data-linea="4">
					<label>Nuevo Saldo en minutos: </label> 
					<input type="number" min="0" step="1" id="tiempoNuevo" name="tiempoNuevo" required="required" value="<?php echo $listaReporte['minutos_disponibles'];?>"/>
				</div>
				
				<div data-linea="5">
					<label>Observación: </label> 
					<input type="text" id="observacion" name="observacion" required="required" />
				</div>
							
				<div data-linea="6">
					<button type="submit" class="guardar">Actualizar</button>
				</div>
				
		</fieldset>
	</form>	
	

<script type="text/javascript">
	$('document').ready(function(){
		distribuirLineas();
		construirValidador();		
		
		   
 	});
 	
 	$("#actualizarSaldo").submit(function(event){

	 if($("#tiempoNuevo").val()=="") {
	    	$("#tiempoNuevo").focus();
	    	$("#tiempoNuevo").addClass("alertaCombo");
	        alert("Debe ingresar un valor entero mayor a cero");
	        return false;
	  }else{
		  	event.preventDefault();
			ejecutarJson($(this));
			$("#detalleItem").html('<div class="mensajeInicial">Seleccione un vehículo para visualizar.</div>');
	  }
});
</script>