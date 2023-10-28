<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorDocumentos.php';
require_once '../../clases/ControladorSolicitudes.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{
	$identificadorUsuarioRegistro = htmlspecialchars ($_POST['identificador'],ENT_NOQUOTES,'UTF-8');
	
	$datos = array( 'observacion' => htmlspecialchars ($_POST['observacion'],ENT_NOQUOTES,'UTF-8'));
	                
	$idDocumento = $_POST['id'];
	 
	
	try {
		$conexion = new Conexion();
		$cd = new ControladorDocumentos();
		$cs = new ControladorSolicitudes();
		
		if ($identificadorUsuarioRegistro != ''){
		    
		    //Buscar información del registro
		    $res = $cd->abrirDocumento($conexion, $idDocumento);
		    $documentoEliminar = pg_fetch_assoc($res);
		    
		    $cd->eliminarDocumento($conexion, $idDocumento, $datos['observacion']);
		    $cs->eliminarSolicitud($conexion, $documentoEliminar['id_solicitud'], $datos['observacion']);
		    $cs->eliminarRevisoresSolicitud($conexion, $documentoEliminar['id_solicitud'], $datos['observacion']);
					
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