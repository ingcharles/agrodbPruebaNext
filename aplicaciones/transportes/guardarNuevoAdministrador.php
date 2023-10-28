<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';
require_once '../../clases/ControladorAplicaciones.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';


try{
	
	$identificador = htmlspecialchars ($_POST['administrador'],ENT_NOQUOTES,'UTF-8');
	$provincia = htmlspecialchars ($_POST['provinciaOcupante'],ENT_NOQUOTES,'UTF-8');
	$oficina = htmlspecialchars ($_POST['oficinaOcupante'],ENT_NOQUOTES,'UTF-8');
	$observaciones = htmlspecialchars ($_POST['observaciones'],ENT_NOQUOTES,'UTF-8');
	
	try {
	    if($identificador != null or $identificador != ''){
        		$conexion = new Conexion();
        		$cv = new ControladorVehiculos();
        		$ca = new ControladorAplicaciones();
        		
        		//Buscar otros administradores 
        		$otrosAdmins = $cv->buscarAdministradoresXProvinciaXOficina($conexion, $provincia, $oficina);
        		
        		if(pg_num_rows($otrosAdmins) == 0){
        		    
        		    //Buscar administrador asignado
        		    $admin = $cv->buscarAdministradorXProvinciaXOficina($conexion, $identificador, $provincia, $oficina);
        		    
        		    if(pg_num_rows($admin) == 0){
        		        //Asignar módulo
        		        $modulo = pg_fetch_result($ca->obtenerIdAplicacion($conexion, 'PRG_TRANSPORTES'), 0, 'id_aplicacion');
        		        
        		        $ca->guardarGestionAplicacion($conexion, $modulo, $identificador, 0, 'notificaciones');
        		        
        		        //Asignar perfil
        		        $perfil = pg_fetch_result($ca->obtenerIdPerfil($conexion, 'PFL_ADM_PROV'), 0, 'id_perfil');
        		        
        		        $ca->guardarGestionPerfil($conexion, $identificador, $perfil);
        		        
        		        //Auditoría
        		        $cv->guardarAuditoriaAdministrador($conexion, $_SESSION['usuario'], $identificador, $provincia, $oficina, 'Creación', $observaciones);
        		        
        		        $mensaje['estado'] = 'exito';
        		        $mensaje['mensaje'] = "Se ha asignado al usuario como administrador del sistema";
        		    }else{
        		        $mensaje['estado'] = 'error';
        		        $mensaje['mensaje'] = "El usuario seleccionado ya es administrador del sistema";
        		    }
        		    
        		}else{
        		    $mensaje['estado'] = 'error';
        		    $mensaje['mensaje'] = "Ya existe un administrador en la provincia y oficina seleccionada, por favor elimine al administrador para crear uno nuevo.";
        		}

        		$conexion->desconectar();

	    }else{
	        $mensaje['estado'] = 'error';
	        $mensaje['mensaje'] = "Debe seleccionar un administrador.";
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