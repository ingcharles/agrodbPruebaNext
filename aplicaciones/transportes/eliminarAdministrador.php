<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';
require_once '../../clases/ControladorAplicaciones.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{
	
	$identificadorUsuarioRegistro = $_SESSION['usuario'];
	
	$observaciones = htmlspecialchars ($_POST['observacion'],ENT_NOQUOTES,'UTF-8');
	                
	$administradores = $_POST['id'];
	$provincias = $_POST['provincia'];
	$oficinas= $_POST['oficina'];
	
	try {
		$conexion = new Conexion();
		$cv = new ControladorVehiculos();
		$ca = new ControladorAplicaciones();
		
		$modulo = pg_fetch_result($ca->obtenerIdAplicacion($conexion, 'PRG_TRANSPORTES'), 0, 'id_aplicacion');
		$perfil = pg_fetch_result($ca->obtenerIdPerfil($conexion, 'PFL_ADM_PROV'), 0, 'id_perfil');
		
		if ($identificadorUsuarioRegistro != ''){
		    for ($i = 0; $i < count ($administradores); $i++) {
		        
		        //Eliminar módulo		        
		        $ca->eliminarAplicacion($conexion, $administradores[$i], $modulo);
		        
		        //Eliminar perfil		        
		        $ca->eliminarPerfil($conexion, $administradores[$i], $perfil);
		        
		        //Auditoría
		        $cv->guardarAuditoriaAdministrador($conexion, $_SESSION['usuario'], $administradores[$i], $provincias[$i], $oficinas[$i], 'Eliminación', $observaciones);
		        
			}
			
			$mensaje['estado'] = 'exito';
			$mensaje['mensaje'] = 'Los datos han sido eliminados satisfactoriamente';
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