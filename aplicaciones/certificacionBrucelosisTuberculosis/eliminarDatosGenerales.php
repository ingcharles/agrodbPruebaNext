<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorBrucelosisTuberculosis.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';
	
try{	
	 
	try {
		$conexion = new Conexion();
		$cbt = new ControladorBrucelosisTuberculosis();
		
		$identificador = $_SESSION['usuario'];
	
		$idInformacionPredio = htmlspecialchars ($_POST['idInformacionPredio'],ENT_NOQUOTES,'UTF-8');
		
		$conexion->ejecutarConsulta("begin;");
					
			$cbt->eliminarInformacionPredio($conexion, $idInformacionPredio);
		
		$conexion->ejecutarConsulta("commit;");
		
		$mensaje['estado'] = 'exito';
		$mensaje['mensaje'] = $idInformacionPredio;
		
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