<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';


try{
	$identificadorUsuarioRegistro = htmlspecialchars ($_POST['identificadorUsuarioRegistro'],ENT_NOQUOTES,'UTF-8');
	$placa = htmlspecialchars ($_POST['placa'],ENT_NOQUOTES,'UTF-8');
	$idMatricula = htmlspecialchars ($_POST['tipoDocumento'],ENT_NOQUOTES,'UTF-8');
	$motivoLiberacion = htmlspecialchars ($_POST['motivoLiberacion'],ENT_NOQUOTES,'UTF-8');
	
	try {	
			
			$conexion = new Conexion();
			$cv = new ControladorVehiculos();
			
			if ($identificadorUsuarioRegistro != ''){
				//Cambio de estado en vehículo
			    $cv -> actualizarEstadoVehiculo($conexion, $placa, 'Liberar');
			    
			    $idMatriculacion = $idMatricula;
				
				//Agregar número de orden de trabajo
			    $cv -> actualizarMatriculacionLiberacion($conexion, $idMatriculacion, $motivoLiberacion);
				
				$mensaje['estado'] = 'exito';
				$mensaje['mensaje'] = 'Los datos han sido actualizados satisfactoriamente.';
				
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