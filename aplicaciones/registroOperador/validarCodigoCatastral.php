<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorRegistroOperador.php';


$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';
$mensaje['contenido'] = '';


try{
        $codigo_catastral = $_POST['codigo_catastral'];
		$identificador_operador = $_POST['identificador_operador'];

	try {
	    $conexion = new Conexion();
		$cr = new ControladorRegistroOperador();
		$arrayParametros = array('codigo_catastral' => $codigo_catastral, 'identificador_operador' => $identificador_operador);
	    $res = $cr->validarCodigoCatastral($conexion, $arrayParametros);

	    $validacion = true;
	    while ($fila = pg_fetch_assoc($res)) {
	    	if($fila['codigo_catastral_count'] > 0){
	    		$validacion = false;
	    	}
	    }

	    if($validacion){
	    	$mensaje['estado'] = 'EXITO';
		    $mensaje['mensaje'] = 'Código catastral validado!!';
	    }
	    else{
	    	$mensaje['estado'] = 'error';
		    $mensaje['mensaje'] = 'Código catastral ya utilizado!!';
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
