<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';
require_once '../../clases/ControladorEstructuraFuncionarios.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';


try{
	
	$identificador = htmlspecialchars ($_POST['identificadorUsuario'],ENT_NOQUOTES,'UTF-8');
	$nombre = htmlspecialchars ($_POST['nombreUsuario'],ENT_NOQUOTES,'UTF-8');
	$apellido = htmlspecialchars ($_POST['apellidoUsuario'],ENT_NOQUOTES,'UTF-8');
	$idEvaluacion = htmlspecialchars ($_POST['idEvaluacion'],ENT_NOQUOTES,'UTF-8');
	
	$tipoEvaluacion = htmlspecialchars ($_POST['tipoEvaluacion'],ENT_NOQUOTES,'UTF-8');
	$idUnidad = htmlspecialchars ($_POST['idUnidad'],ENT_NOQUOTES,'UTF-8');
	$idEvaluacion = htmlspecialchars ($_POST['idEvaluacion'],ENT_NOQUOTES,'UTF-8');
	$tipoUsuario = htmlspecialchars ($_POST['tipoUsuario'],ENT_NOQUOTES,'UTF-8');
	
	try {
	    if($tipoEvaluacion != null or $tipoEvaluacion != ''){
        		$conexion = new Conexion();
        		$ce = new ControladorEvaluaciones();
        		$cef = new ControladorEstructuraFuncionarios();
        		
        		//Revisar el tipo de evaluación requerido.
        		
        		if($tipoEvaluacion == 'Individual'){
        		    if($identificador != '' && $nombre != '' && $apellido != ''){
        		        //Asignar aplicacion
        		        $ce->asignarAplicacion($conexion, $identificador, 'PRG_EVALUACIONES');
        		        
        		        //Asignar perfiles
        		        $ce->asignarPerfil($conexion, $identificador, 'PFL_EVALUACION');
        		        
        		        //Asignar evaluación
        		        $ce->asignarEvaluacion($conexion, $identificador, $nombre, $apellido, $idEvaluacion);
        		        $ce->reiniciarEvaluacion($conexion, $identificador, $idEvaluacion);
        		        
        		        $mensaje['estado'] = 'exito';
        		        $mensaje['mensaje'] = "Se ha asignado la evaluación al usuario";
        		    }else{
        		        $mensaje['estado'] = 'error';
        		        $mensaje['mensaje'] = "Debe remitir toda la información del usuario.";
        		    }

        		}else if($tipoEvaluacion == 'Unidad'){
        		    if($idUnidad != ''){
        		        //Buscar a todos los funcionarios dentro de la dirección o coordinación para asignar la evaluación
        		        
        		        $usuarios = $cef->obtenerUsuariosEstructuraXUnidadPrincialActivos($conexion, $idUnidad);
        		        
        		        while ($fila = pg_fetch_assoc($usuarios)){
        		            //Asignar aplicacion
        		            $ce->asignarAplicacion($conexion, $fila['identificador'], 'PRG_EVALUACIONES');
        		            
        		            //Asignar perfiles
        		            $ce->asignarPerfil($conexion, $fila['identificador'], 'PFL_EVALUACION');
        		            
        		            //Asignar evaluación
        		            $ce->asignarEvaluacion($conexion, $fila['identificador'], $fila['nombre'], $fila['apellido'], $idEvaluacion);
        		            $ce->reiniciarEvaluacion($conexion, $fila['identificador'], $idEvaluacion);
        		        }
        		        
        		        $mensaje['estado'] = 'exito';
        		        $mensaje['mensaje'] = "Se ha asignado la evaluación a los usuarios";
        		    }else{
        		        $mensaje['estado'] = 'error';
        		        $mensaje['mensaje'] = "Debe remitir una dirección o coordinación para asignar la evaluación.";
        		    }
        		}else{
        		    if($tipoUsuario == 'Todos'){
        		        //Buscar a todos los funcionarios y servicios profesionales activos nacional para asignar la evaluación        		        
        		        $usuarios = $cef->obtenerFuncionariosNacionalActivos($conexion);
        		        
        		        while ($fila = pg_fetch_assoc($usuarios)){
        		            //Asignar aplicacion
        		            $ce->asignarAplicacion($conexion, $fila['identificador'], 'PRG_EVALUACIONES');
        		            
        		            //Asignar perfiles
        		            $ce->asignarPerfil($conexion, $fila['identificador'], 'PFL_EVALUACION');
        		            
        		            //Asignar evaluación
        		            $ce->asignarEvaluacion($conexion, $fila['identificador'], $fila['nombre'], $fila['apellido'], $idEvaluacion);
        		            $ce->reiniciarEvaluacion($conexion, $fila['identificador'], $idEvaluacion);
        		        }
        		        
        		        $mensaje['estado'] = 'exito';
        		        $mensaje['mensaje'] = "Se ha asignado la evaluación a los usuarios";
        		    }else{
        		        //Buscar a todos los funcionarios internos activos nacional para asignar la evaluación
        		        $usuarios = $cef->obtenerFuncionariosInternosNacionalActivos($conexion);
        		        
        		        while ($fila = pg_fetch_assoc($usuarios)){
        		            //Asignar aplicacion
        		            $ce->asignarAplicacion($conexion, $fila['identificador'], 'PRG_EVALUACIONES');
        		            
        		            //Asignar perfiles
        		            $ce->asignarPerfil($conexion, $fila['identificador'], 'PFL_EVALUACION');
        		            
        		            //Asignar evaluación
        		            $ce->asignarEvaluacion($conexion, $fila['identificador'], $fila['nombre'], $fila['apellido'], $idEvaluacion);
        		            $ce->reiniciarEvaluacion($conexion, $fila['identificador'], $idEvaluacion);
        		        }
        		        
        		        $mensaje['estado'] = 'exito';
        		        $mensaje['mensaje'] = "Se ha asignado la evaluación a los usuarios";
        		    }
        		}

        		$conexion->desconectar();

	    }else{
	        $mensaje['estado'] = 'error';
	        $mensaje['mensaje'] = "Debe seleccionar un tipo de evaluación.";
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