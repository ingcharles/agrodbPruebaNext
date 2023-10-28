<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';
require_once '../../clases/ControladorUsuarios.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';


try{
	
	$placa = htmlspecialchars ($_POST['placa'],ENT_NOQUOTES,'UTF-8');
	$identificador = htmlspecialchars ($_POST['identificadorUsuarioRegistro'],ENT_NOQUOTES,'UTF-8');
	$tipoDocumento = htmlspecialchars ($_POST['tipoDocumento'],ENT_NOQUOTES,'UTF-8');
	$fechaInicio = htmlspecialchars ($_POST['fechaInicio'],ENT_NOQUOTES,'UTF-8');
	$rutaArchivo = htmlspecialchars ($_POST['archivo'],ENT_NOQUOTES,'UTF-8');
	
	try {
	    if($fechaInicio != null or $fechaInicio != ''){
    	    if($rutaArchivo != null or $rutaArchivo != ''){
        		$conexion = new Conexion();
        		$cv = new ControladorVehiculos();
        		$cu = new ControladorUsuarios();
        		
        		//Tipo de usuario
        		$perfil = $cu->buscarPerfilUsuarioXCodigo($conexion, $identificador, 'PFL_ADM_NAC');
        		
        		if(pg_num_rows($perfil) != 0){
        		    $tipoUsuario = 'Administrador';
        		}else{
        		    $tipoUsuario = 'Usuario';
        		}
        		
        		$fecha = date_create($fechaInicio);
        		
        		if($tipoDocumento == 'Certificado de Matriculación Anual'){
        		    $dateS =date_add($fecha, date_interval_create_from_date_string("1 year"));
        		}else{
        		    $dateS =date_add($fecha, date_interval_create_from_date_string("5 year"));
        		}
        		$fechaFin = date_format($dateS,"Y-m-d");
        		    		
        		$matricula = $cv->buscarMatriculaXVechiculoXFecha($conexion, $placa, $tipoDocumento, $fechaInicio, $fechaFin);
        		
        		if(pg_num_rows($matricula) == 0){
        		    $idMatricula = pg_fetch_row($cv->guardarNuevaMatricula($conexion, $placa, $tipoDocumento, $fechaInicio, $fechaFin, $rutaArchivo, $identificador));
        		
        		    //Desactivar registros previos
        		    $cv->actualizarEstadoMatriculacionesIngreso($conexion, $placa, $tipoDocumento, $idMatricula[0], $identificador);
        		    
        		    $mensaje['estado'] = 'exito';
        		    $mensaje['mensaje'] = $cv->imprimirLineaMatricula($idMatricula[0], $placa, $tipoDocumento, $fechaInicio, $fechaFin, $rutaArchivo, 'transportes', 'Vigente', $tipoUsuario);
        		}else{
        			$mensaje['estado'] = 'error';
        			$mensaje['mensaje'] = "El documento de matrícula ya existe, por favor verificar en el listado.";
        		}
        		
        		$conexion->desconectar();
    		
    	    }else{
    	        $mensaje['estado'] = 'error';
    	        $mensaje['mensaje'] = "Debe adjuntar un documento de respaldo.";
    	    }
	    }else{
	        $mensaje['estado'] = 'error';
	        $mensaje['mensaje'] = "Debe seleccionar una fecha de inicio.";
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