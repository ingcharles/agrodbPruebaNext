<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVacaciones.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{
	
	$identificadorUsuarioRegistro = $_SESSION['usuario'];
	
	$identificador = $_POST['identificador'];
	$anio = $_POST['anio'];
	$tiempoNuevo= $_POST['tiempoNuevo'];
	$secuencial = $_POST['secuencial'];
	$estado= $_POST['estado'];
	$observacion = htmlspecialchars ($_POST['observacion'],ENT_NOQUOTES,'UTF-8');
	
	try {
	    $conexion = new Conexion();
	    $cv = new ControladorVacaciones();
		
		if ($identificadorUsuarioRegistro != ''){
		    $cv->actualizarSaldoVacaciones($conexion, $identificador, $anio, $tiempoNuevo, $secuencial, $observacion );
		    			
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