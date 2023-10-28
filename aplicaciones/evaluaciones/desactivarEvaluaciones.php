<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{
	
    $identificador = $_POST['identificador'];
    $idEvaluacion = $_POST['idEvaluacion'];
	
	try {
		$conexion = new Conexion();
		$cv = new ControladorEvaluaciones();
		
		for ($i = 0; $i < count ($identificador); $i++) {
	        
	        //Reactivar evaluación		        
		    $cv->desactivarEvaluacion($conexion, $identificador[$i], $idEvaluacion[$i]);
	        
		}
		
		$mensaje['estado'] = 'exito';
		$mensaje['mensaje'] = 'Se ha desactivado la evaluación.';
					
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