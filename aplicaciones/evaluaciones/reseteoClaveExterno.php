<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{
	
    $identificador = $_POST['identificador'];
	
	try {
		$conexion = new Conexion();
		$cv = new ControladorEvaluaciones();
		
		for ($i = 0; $i < count ($identificador); $i++) {
	        
	        //Reactivar evaluación		        
		    $cv->actualizarClaveUsuario($conexion, $identificador[$i]);
	        
		}
		
		$mensaje['estado'] = 'exito';
		$mensaje['mensaje'] = 'Se ha reseteado la clave.';
					
		$conexion->desconectar();
		echo json_encode($mensaje);
	} catch (Exception $ex){
		pg_close($conexion);
		$mensaje['estado'] = 'error';
		$mensaje['mensaje'] = "Error al ejecutar sentencia";
		echo json_encode($mensaje);
	}
} catch (Exception $ex) {
	$mensaje['estado'] = 'error';
	$mensaje['mensaje'] = 'Error de conexión a la base de datos';
	echo json_encode($mensaje);
}
?>