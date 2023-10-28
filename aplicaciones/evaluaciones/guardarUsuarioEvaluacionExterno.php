<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';
require_once '../../clases/ControladorCatastro.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';


try{
	
	$identificador = htmlspecialchars ($_POST['identificadorUsuario'],ENT_NOQUOTES,'UTF-8');
	$nombre = htmlspecialchars ($_POST['nombreUsuario'],ENT_NOQUOTES,'UTF-8');
	$apellido = htmlspecialchars ($_POST['apellidoUsuario'],ENT_NOQUOTES,'UTF-8');
	$idEvaluacion = htmlspecialchars ($_POST['idEvaluacion'],ENT_NOQUOTES,'UTF-8');
	
	try {
	    if($identificador != null or $identificador != ''){
        		$conexion = new Conexion();
        		$ce = new ControladorEvaluaciones();
        		$cca = new ControladorCatastro();
        		
        		//Buscar otros administradores 
        		$existeUsuario = $cca->obtenerDatosContratoXIdentificador($conexion, $identificador);
        		
        		if(pg_num_rows($existeUsuario) == 0){
        		    
        		    //Crear usuario
        		    $ce->crearUsuario($conexion, $identificador);
        		    
        		    //Resetear clave
        		    $ce->actualizarClaveUsuario($conexion, $identificador);
        		    
        		    //Asignar aplicacion
        		    $ce->asignarAplicacion($conexion, $identificador, 'PRG_EVALUACIONES');
        		    
        		    //Asignar perfiles
        		    $ce->asignarPerfil($conexion, $identificador, 'PFL_USUAR_EXT');
        		    $ce->asignarPerfil($conexion, $identificador, 'PFL_EVALUACION');
        		    
        		    //Asignar evaluación
        		    $ce->asignarEvaluacion($conexion, $identificador, $nombre, $apellido, $idEvaluacion);
        		    $ce->reiniciarEvaluacion($conexion, $identificador, $idEvaluacion);

    		        $mensaje['estado'] = 'exito';
    		        $mensaje['mensaje'] = "Se ha asignado la evaluación al usuario";
        		    
        		}else{
        		    $mensaje['estado'] = 'error';
        		    $mensaje['mensaje'] = "El usuario es funcionario de Agrocalidad, no puede ser habilitado para una evaluación externa.";
        		}

        		$conexion->desconectar();

	    }else{
	        $mensaje['estado'] = 'error';
	        $mensaje['mensaje'] = "Debe ingresar un usuario y una evaluación.";
	    }
		
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