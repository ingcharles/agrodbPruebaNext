<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorPAPP.php';


$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';


try{
	
	try {
		$conexion = new Conexion();
		$cp = new ControladorPAPP();
		
		$anioAnterior = date('Y')-1;
		$anioActual = date('Y');
		
		//Catálogos de Objetivos Estratégicos
		$cp->reiniciarCatalogoObjetivosEstrategicos($conexion, $anioActual, $anioAnterior);
		
		//Catálogos de Procesos
		$cp->reiniciarCatalogoProcesos($conexion, $anioActual, $anioAnterior);
		
		//Catálogos de Subprocesos
		$cp->reiniciarCatalogoSubprocesos($conexion, $anioActual, $anioAnterior);
		
		//Catálogos de Actividades
		$cp->reiniciarCatalogoActividades($conexion, $anioActual, $anioAnterior);
		
		
		$mensaje['estado'] = 'exito';
		$mensaje['mensaje'] = 'Los datos han sido actualizados satisfactoriamente';
			
		
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