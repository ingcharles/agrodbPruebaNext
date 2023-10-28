<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorFinanciero.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{
	
	$idServicio = htmlspecialchars ($_POST['idServicio'],ENT_NOQUOTES,'UTF-8');
	$codigo = htmlspecialchars ($_POST['codigo'],ENT_NOQUOTES,'UTF-8');
	$concepto = htmlspecialchars ($_POST['concepto'],ENT_NOQUOTES,'UTF-8');
	
	try {
		$conexion = new Conexion();
		$cf = new ControladorFinanciero();
		
		$res = $cf->quitarDocumento($conexion, $idServicio, $codigo);
		
		$mensaje['estado'] = 'exito';
		$mensaje['mensaje'] = 'El documento a sido elimado exitosamente';
		
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