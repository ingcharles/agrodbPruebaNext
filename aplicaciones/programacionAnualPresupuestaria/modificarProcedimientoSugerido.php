<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorProgramacionPresupuestaria.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{

	$idProcedimientoSugerido = htmlspecialchars ($_POST['idProcedimientoSugerido'],ENT_NOQUOTES,'UTF-8');
	$nombreProcedimientoSugerido  = htmlspecialchars ($_POST['nombreProcedimientoSugerido'],ENT_NOQUOTES,'UTF-8');
	$codigoProcedimientoSugerido  = htmlspecialchars ($_POST['codigoProcedimientoSugerido'],ENT_NOQUOTES,'UTF-8');
	$identificador = $_SESSION['usuario'];	
	
	try {
		$conexion = new Conexion();
		$cpp = new ControladorProgramacionPresupuestaria();

		$conexion->ejecutarConsulta("begin;");
		$cpp->modificarProcedimientoSugerido($conexion, $idProcedimientoSugerido, $nombreProcedimientoSugerido, $identificador);
		$conexion->ejecutarConsulta("commit;");
		
		$mensaje['estado'] = 'exito';
		$mensaje['mensaje'] = 'Los datos fueron actualizados';

		$conexion->desconectar();
		echo json_encode($mensaje);
	
	} catch (Exception $ex){
		$conexion->ejecutarConsulta("rollback;");
		$mensaje['mensaje'] = $ex->getMessage();
		$mensaje['error'] = $conexion->mensajeError;
		$conexion->desconectar();
	}/* finally {
		$conexion->desconectar();
	}*/
	
} catch (Exception $ex) {
	$mensaje['mensaje'] = $ex->getMessage();
	$mensaje['error'] = $conexion->mensajeError;
	$conexion->desconectar();
} /*finally {
	echo json_encode($mensaje);
}*/
?>