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
	<h1>Confirmar activación de evaluación</h1>
</header>

<div id="estado"></div>

	<p>La siguiente <b>evaluación</b> va a ser habilitada para una nueva oportunidad: </p>
	
	<?php
	if($_POST['elementos'] != ''){
		
    	$administradores = explode(",",$_POST['elementos']);
    	
    		
    	for ($i = 0; $i < count ($administradores); $i++) {
    	    $datos = explode('-', $administradores[$i]);
    	    $res = $cv->datosUsuarioEvaluacion($conexion, $datos[0], $datos[1]);
    		$admin = pg_fetch_assoc($res);
    		
    		echo '<fieldset><legend>Información de Evaluación</legend>';
    		echo '<div data-linea="0">
    		
    		<label>Identificador: </label>'. $admin['identificador'].'
    	    
    	    </div>
    	    <div data-linea="1">
    	    
    	    <label>Nombre: </label> '.$admin['nombre'].' '.$admin['apellido'].'
    	    
    	    </div>
    
            <div data-linea="2">
    	    
    	    <label>Evaluación: </label> '.$admin['nombre_evaluacion'].'
    	    
    	    </div>';
    		echo'</fieldset>';
    	}
	
	}
	
	?>
	
 

<form id="notificarReactivarEvaluacion" data-rutaAplicacion="evaluaciones" data-opcion="reactivarEvaluaciones" data-accionEnExito="ACTUALIZAR" >

			<?php 
    			if($_POST['elementos'] != ''){
    			    
    			    $administradores = explode(",",$_POST['elementos']);
    			    
        			for ($i = 0; $i < count ($administradores); $i++) {
        			    $datos = explode('-', $administradores[$i]);
        			    echo'<input type="hidden" name="identificador[]" value="'.$datos[0].'"/>';
        			    echo'<input type="hidden" name="idEvaluacion[]" value="'.$datos[1].'"/>';
    				}
    			}
			?>	
				
	 <button id="eliminar" type="submit" >Reactivar evaluación</button>
	
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
