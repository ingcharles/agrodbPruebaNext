<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';

$conexion = new Conexion();
$cv = new controladorEvaluaciones();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

</head>
<body>

<header>
	<h1>Confirmar reseteo de clave de usuario externo</h1>
</header>

<div id="estado"></div>

	<p>Se reseteará la clave del siguiente usuario: </p>
	
	<?php
	if($_POST['elementos'] != ''){
		
    	$administradores = explode(",",$_POST['elementos']);
    	
    		
    	for ($i = 0; $i < count ($administradores); $i++) {
    	    $datos = explode('-', $administradores[$i]);
    	    $res = $cv->datosUsuarioEvaluacion($conexion, $datos[0], $datos[1]);
    		$admin = pg_fetch_assoc($res);
    		
    		echo '<fieldset><legend>Información de Usuario</legend>';
    		echo '<div data-linea="0">
    		
    		<label>Identificador: </label>'. $admin['identificador'].'
    	    
    	    </div>
    	    <div data-linea="1">
    	    
    	    <label>Nombre: </label> '.$admin['nombre'].' '.$admin['apellido'].'
    	    
    	    </div>';
    		
    		echo '<p class="nota">La clave asignada será el número de cédula del usuario seguido de .1</p>';
    		echo'</fieldset>';
    	}
	
	}
	
	?>
	
 

<form id="notificarReactivarEvaluacion" data-rutaAplicacion="evaluaciones" data-opcion="reseteoClaveExterno" data-accionEnExito="ACTUALIZAR" >

			<?php 
    			if($_POST['elementos'] != ''){
    			    
    			    $administradores = explode(",",$_POST['elementos']);
    			    
        			for ($i = 0; $i < count ($administradores); $i++) {
        			    $datos = explode('-', $administradores[$i]);
        			    echo'<input type="hidden" name="identificador[]" value="'.$datos[0].'"/>';
    				}
    			}
			?>	
				
	 <button id="eliminar" type="submit" >Resetear clave</button>
	
</form>

</body>

<script type="text/javascript">

var array_documento= <?php echo json_encode($_POST['elementos']); ?>;

$("#notificarReactivarEvaluacion").submit(function(event){

	event.preventDefault();
	ejecutarJson($(this));
});


$(document).ready(function(){

	distribuirLineas();
	construirValidador();

	if(array_documento == ''){
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione un elemento.</div>');
	}


});
	
</script>

</html>
