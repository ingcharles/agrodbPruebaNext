<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEventoSanitario.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';
	
try{	
	 
	try {
		$conexion = new Conexion();
		$cpco = new ControladorEventoSanitario();
		
		$identificador = $_SESSION['usuario'];
	
		$idPoblacionAnimales = htmlspecialchars ($_POST['idPoblacionAnimales'],ENT_NOQUOTES,'UTF-8');
		
		$conexion->ejecutarConsulta("begin;");
					
			$cpco->eliminarPoblaciones($conexion, $idPoblacionAnimales);
		
		$conexion->ejecutarConsulta("commit;");
		
		$mensaje['estado'] = 'exito';
		$mensaje['mensaje'] = $idPoblacionAnimales;
		
		$conexion->desconectar();
		
		echo json_encode($mensaje);
	
	} catch (Exception $ex){
		$conexion->ejecutarConsulta("rollback;");
		$mensaje['mensaje'] = $ex->getMessage();
		$mensaje['error'] = $conexion->mensajeError;
		$conexion->desconectar();
	}
	
} catch (Exception $ex) {
	$mensaje['mensaje'] = $ex->getMessage();
	$mensaje['error'] = $conexion->mensajeError;
	$conexion->desconectar();
}
?>