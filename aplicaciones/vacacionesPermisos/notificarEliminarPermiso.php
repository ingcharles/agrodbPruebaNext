<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVacaciones.php';

$conexion = new Conexion();
$cv = new ControladorVacaciones();

$identificadorUsuarioRegistro = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

</head>
<body>

<header>
	<h1>Confirmar eliminación</h1>
</header>

<div id="estado"></div>

	<p>El siguiente <b>permiso</b> va a ser eliminado: </p>
	
	<?php
		
	$permisos = explode(",",$_POST['elementos']);
	$permisoValidado = '';
	
	if(count ($permisos) >0){
	    for ($i = 0; $i < count ($permisos); $i++) {
	        $res = $cv->obtenerPermisoSolicitado($conexion, $permisos[$i]);
	        $permisoUsuario = pg_fetch_assoc($res);
	        
	        //if($permisoUsuario['codigo'] != 'VA-VA' && $permisoUsuario['codigo'] != 'PE-PIV'){
	            echo '<fieldset>
        		<legend>Permiso #'.$permisos[$i].'</legend>
        		<div data-linea="1">
        		<label>Permiso por: </label>'.$permisoUsuario['descripcion_subtipo'] .
        		'</div>
                <hr id="separador">
        		<div data-linea="4">
        			<label id="etiquetaFechaSuceso">Fecha de suceso: </label>'.
        			date('j/n/Y',strtotime($permisoUsuario['fecha_suceso'])).
        			'</div>
        		<hr id="separador">
        		<div data-linea="5">
        			<label>Fecha de salida: </label> '.
        			date('j/n/Y',strtotime($permisoUsuario['fecha_inicio'])).
        			'</div>
        		<div data-linea="5">
        			<label>Hora de salida: </label>'.
        			date('H:i',strtotime($permisoUsuario['fecha_inicio'])).
        			'</div>
        		<hr>
        		<div data-linea="6">
        			<label>Fecha de retorno: </label> '.
        			date('j/n/Y',strtotime($permisoUsuario['fecha_fin'])).
        			'</div>
        		<div data-linea="6">
        			<label>Hora de retorno: </label> '.
        			date('H:i',strtotime($permisoUsuario['fecha_fin'])) .
        			'</div>
        	</fieldset>';
        			
        			$permisoValidado .= $permisoUsuario['id_permiso_empleado'] .',';
	        //}
	        
	    }
	    $permisoValidado = substr($permisoValidado, 0, -1);
	}
	
	?>
	
 

<form id="notificarEliminarPermiso" data-rutaAplicacion="vacacionesPermisos" data-opcion="eliminarPermiso" data-accionEnExito="ACTUALIZAR" >

	<input type='hidden' id='identificadorUsuarioRegistro' name='identificadorUsuarioRegistro' value="<?php echo $identificadorUsuarioRegistro;?>" />
	
	<fieldset>
		<legend>Observación</legend>

		<div data-linea="1">
			<textarea id="observacion" name="observacion"></textarea>
		</div>
	</fieldset>
	
			<?php 
    			for ($i = 0; $i < count ($permisos); $i++) {
    			    $res = $cv->obtenerPermisoSolicitado($conexion, $permisos[$i]);
    			    $permisoUsuario = pg_fetch_assoc($res);
    			    
    			    //if($permisoUsuario['codigo'] != 'VA-VA' && $permisoUsuario['codigo'] != 'PE-PIV'){
    			        echo'<input type="hidden" name="id[]" value="'.$permisos[$i].'"/>';
    			    //}
    			        			    
    			}
			?>	
				
	 <button id="eliminar" type="submit" class="eliminar" >Eliminar permiso</button>
	
</form>

</body>

<script type="text/javascript">
var permiso= <?php echo json_encode(count ($permisos)); ?>;
var array_permiso= <?php echo json_encode($permisoValidado); ?>;

$(document).ready(function(){

	distribuirLineas();
	construirValidador();
	
	if(permiso == 0){
	alert();
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione un elemento.</div>');
	}

	if(array_permiso == ''){
		$("#detalleItem").html('<div class="mensajeInicial">No se puede eliminar permisos por Vacaciones o Imputables a Vacaciones.</div>');
	}

	if($("#nEliminar").text()){
		$("#notificarEliminarPermiso").hide();
	}

});

$("#notificarEliminarPermiso").submit(function(event){

	 if($("#observacion").val()=="") {
	    	$("#observacion").focus();
	    	$("#observacion").addClass("alertaCombo");
	        alert("Debe ingresar una observación");
	        return false;
	  }else{
		  	event.preventDefault();
			ejecutarJson($(this));
	  }
});


</script>

</html>