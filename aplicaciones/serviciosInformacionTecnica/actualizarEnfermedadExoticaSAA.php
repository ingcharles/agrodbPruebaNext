<?php
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorServiciosInformacionTecnica.php';

$mensaje = array ();
$mensaje ['estado'] = 'error';
$mensaje ['mensaje'] = 'Ha ocurrido un error!';

try {
	$conexion = new Conexion ();
	$csit = new ControladorServiciosInformacionTecnica();
	try {
		$idEnfermedadExotica = $_POST['idEnfermedadExotica'];
		$nombre = $_POST['nombreEnfermedad'];
		$inicioVigencia = $_POST['inicioVigencia'];
		$finVigencia = $_POST['finVigencia'];
		$observacion = $_POST['observacion'];
		$estado = $_POST['estadoEnfermedad'];
		$usuarioResponsable=$_POST['usuarioResponsable'];
		$conexion->ejecutarConsulta("begin;");
		$csit->actualizarEnfermedadExotica($conexion, $idEnfermedadExotica, $nombre, $inicioVigencia, $finVigencia, $observacion, $estado, $usuarioResponsable);
		$mensaje['estado'] = 'exito';
		$mensaje ['mensaje'] = 'Los datos han sido actualizados satisfactoriamente';
		$conexion->ejecutarConsulta("commit;");
	} catch (Exception $ex) {
		$conexion->ejecutarConsulta("rollback;");
		$mensaje['mensaje'] = $ex->getMessage();
		$mensaje['error'] = $conexion->mensajeError;
	} finally {
		$conexion->desconectar();
	}
} catch (Exception $ex) {
	$mensaje['mensaje'] = $ex->getMessage();
	$mensaje['error'] = $conexion->mensajeError;
} finally {
	echo json_encode($mensaje);
}
?>