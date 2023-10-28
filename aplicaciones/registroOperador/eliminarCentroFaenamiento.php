<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorRegistroOperador.php';


$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';
$mensaje['contenido'] = '';


try{
        $idCentroFaenamientoTransporte = $_POST['idCentroFaenamientoTransporte'];
		$idOperacion = $_POST['idOperacion'];
		$idArea = $_POST['idArea'];

	try {
	    $conexion = new Conexion();
		$cr = new ControladorRegistroOperador();
		$arrayParametros = array('id_centros_faenamiento_transporte' => $idCentroFaenamientoTransporte, 'id_operacion' => $idOperacion,'id_area' =>$idArea);
		    $res = $cr->eliminarCentroFaenamienTransporte($conexion, $arrayParametros);
		    $arrayParametros = array('id_operacion' => $idOperacion,'id_area' =>$idArea);
		    $res = $cr->consultarCentroFaenamienTransporte($conexion,$arrayParametros);
		    $html='';
		    
		    $contadorProducto = 0;
		    while ($fila = pg_fetch_assoc($res)) {
		            $arrayParametros = array('id_centro_faenamiento' => $fila['id_centro_faenamiento']);
		            $dato = pg_fetch_assoc($cr->buscarCentroFaenamientoXid($conexion,$arrayParametros));
		            $html .= '<tr><td>'.++$contadorProducto.'</td>
                          <td>'.$dato['identificador_operador'].'</td>
                          <td>'.$dato['razon_social'].'</td>
                          <td>'.$dato['provincia'].'</td>
                          <td>'.$dato['nombre_lugar'].'</td>
						  <td>'.$dato['nombre_area'].'</td>
                          <td><button type="button" class="menos" onclick="eliminarCF('.$fila['id_centros_faenamiento_transporte'].'); return false; ">Quitar</button></td></tr>';
		    }
		    
		    $mensaje['estado'] = 'EXITO';
		    $mensaje['mensaje'] = 'Registro eliminado correctamente ..!!';
		    $mensaje['contenido'] = $html;
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
