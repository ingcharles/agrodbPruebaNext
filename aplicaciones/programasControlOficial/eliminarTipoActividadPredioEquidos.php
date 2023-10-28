<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorProgramasControlOficial.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';
	
try{	
	 
	try {
		$conexion = new Conexion();
		$cpco = new ControladorProgramasControlOficial();
		
		$identificador = $_SESSION['usuario'];
	
		$idTipoActividadPredioEquidos = htmlspecialchars ($_POST['idTipoActividadPredioEquidos'],ENT_NOQUOTES,'UTF-8');
		
		$conexion->ejecutarConsulta("begin;");
					
			$cpco->eliminarTipoActividadPredioEquidos($conexion, $idTipoActividadPredioEquidos);
		
		$conexion->ejecutarConsulta("commit;");
		
		$mensaje['estado'] = 'exito';
		$mensaje['mensaje'] = $idTipoActividadPredioEquidos;
		
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