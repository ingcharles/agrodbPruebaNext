<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';

$conexion = new Conexion();
$cv = new controladorVehiculos();

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

	<p>El siguiente <b>administrador</b> va a ser eliminado: </p>
	
	<?php
		
	$administradores = explode(",",$_POST['elementos']);
	
		
	for ($i = 0; $i < count ($administradores); $i++) {
	    $res = $cv->buscarDatosAdministrador($conexion, $administradores[$i]);
		$admin = pg_fetch_assoc($res);
		echo '<fieldset><legend>Administrador</legend>';
		echo '<div data-linea="0">
		
		<label>Identificador: </label>'. $admin['identificador'].'
	    
	    </div>
	    <div data-linea="1">
	    
	    <label>Nombre: </label> '.$admin['nombre'].' '.$admin['apellido'].'
	    
	    </div>

        <div data-linea="2">
	    
	    <label>Localización: </label> '.$admin['provincia'].' - '.$admin['oficina'].'
	    
	    </div>';
		echo'</fieldset>';
	}
	
	
	
	?>
	
 

<form id="notificarEliminarAdministrador" data-rutaAplicacion="transportes" data-opcion="eliminarAdministrador" data-accionEnExito="ACTUALIZAR" >

	<input type='hidden' id='identificadorUsuarioRegistro' name='identificadorUsuarioRegistro' value="<?php echo $identificadorUsuarioRegistro;?>" />
	
	<fieldset>
		<legend>Observación</legend>

		<div data-linea="1">
			<textarea id="observacion" name="observacion"></textarea>
		</div>
	</fieldset>
	
			<?php 
    			for ($i = 0; $i < count ($administradores); $i++) {
    			    $res = $cv->buscarDatosAdministrador($conexion, $administradores[$i]);
    			    $admin = pg_fetch_assoc($res);
    			    
    			    echo'<input type="hidden" name="id[]" value="'.$administradores[$i].'"/>';
    			    echo'<input type="hidden" name="provincia[]" value="'.$admin['provincia'].'"/>';
    			    echo'<input type="hidden" name="oficina[]" value="'.$admin['oficina'].'"/>';
				}
			?>	
				
	 <button id="eliminar" type="submit" class="eliminar" >Eliminar Administrador</button>
	
</form>

</body>

<script type="text/javascript">

var array_documento= <?php echo json_encode($administradores); ?>;

$("#notificarEliminarAdministrador").submit(function(event){

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


$(document).ready(function(){

	distribuirLineas();
	construirValidador();

	if(array_documento == ''){
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione un documento.</div>');
	}

	if($("#nEliminar").text()){
		$("#notificarEliminarAdministrador").hide();
	}

});
	
</script>

</html>
