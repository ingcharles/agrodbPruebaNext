<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';


$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';


try{
	$identificadorUsuarioRegistro = htmlspecialchars ($_POST['identificadorUsuarioRegistro'],ENT_NOQUOTES,'UTF-8');
	
	$idSiniestro = $_POST['id_siniestro'];
	$resolucion = $_POST['resolucionQuipux'];
	$placa = $_POST['placa'];
	
	
	try {
		$conexion = new Conexion();
		$cv = new ControladorVehiculos();
		
		if ($identificadorUsuarioRegistro != ''){
		
			$cv->actualizarDatosSiniestroResolucion($conexion, $idSiniestro, $resolucion, $identificadorUsuarioRegistro);
			$cv->actualizarDatosSiniestroCierreFase($conexion, $idSiniestro, 5, $identificadorUsuarioRegistro);
			$cv->actualizarEstadoVehiculo($conexion, $placa, 'Liberar');
				
			$mensaje['estado'] = 'exito';
			$mensaje['mensaje'] = 'Los datos han sido actualizados satisfactoriamente';
		}else{
			$mensaje['estado'] = 'error';
			$mensaje['mensaje'] = "Su sesión expiró, por favor ingrese nuevamente al sistema";
		}
		
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