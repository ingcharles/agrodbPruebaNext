<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{
	$identificadorUsuarioRegistro = htmlspecialchars ($_SESSION['usuario'],ENT_NOQUOTES,'UTF-8');
	$placa = $_POST['placa'];
	$idMatriculacion = $_POST['idMatriculacion'];	 
	
	try {
		$conexion = new Conexion();
		$cv = new ControladorVehiculos();
		
		if ($identificadorUsuarioRegistro != ''){
		    $cv->darBajaMatriculacion($conexion, $idMatriculacion, $identificadorUsuarioRegistro);
		    
		    //buscar todos los registros del vehiculo, si no hay ningun registro activo bloquear el carro
		    $matriculas = $cv->validarMatriculasActivas($conexion, $placa);
		    
		    if(pg_num_rows($matriculas) == 0){
		        $cv->actualizarEstadoVehiculo($conexion, $placa, 'Matriculacion');
		    }
		    		
			$mensaje['estado'] = 'exito';
			$mensaje['mensaje'] = $idMatriculacion;//'Se ha eliminado el registro';
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