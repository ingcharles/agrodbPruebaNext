<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorRegistroOperador.php';


$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';
$mensaje['contenido'] = '';


try{
		$area = $_POST['area'];
		$idOperacion = $_POST['idOperacion'];
		$idArea = $_POST['idArea'];

	try {
	    $conexion = new Conexion();
	    
	    $datos = explode('-', $area);
	    $area= $datos[0];
	    $idCentroFaenamiento = $datos[1];
		$cr = new ControladorRegistroOperador();
		$arrayParametros = array('id_centro_faenamiento' => $idCentroFaenamiento, 'id_operacion' => $idOperacion,'id_area' =>$idArea);
		$res = $cr->consultarCentroFaenamienTransporte($conexion,$arrayParametros);

		if(pg_num_rows($res) > 0){
		    $mensaje['estado'] = 'error';
		    $mensaje['mensaje'] = 'Ya existe el centro de faenamiento..!!';
		}else{
			$res = $cr->guardarCentroFaenamienTransporte($conexion,$arrayParametros);
			$fila = pg_fetch_result($res,0, 'id_centros_faenamiento_transporte');
			$contadorProducto = 0;
				$contenidoTablaCentros='';
					$arrayParametros = array('id_centro_faenamiento' => $idCentroFaenamiento);
					$dato = pg_fetch_assoc($cr->buscarCentroFaenamientoXid($conexion,$arrayParametros));
					
						$contenidoTablaCentros .= '<tr id='.$dato['id_centro_faenamiento'].'><td>'.++$contadorProducto.'</td>
							<td>'.$dato['identificador_operador'].'</td>
							<td>'.$dato['razon_social'].'</td>
							<td>'.$dato['provincia'].'</td>
							<td>'.$dato['nombre_lugar'].'</td>
							<td>'.$dato['nombre_area'].'</td>
							<td><button type="button" class="menos" onclick="eliminarCF('.$fila.'); return false; ">Quitar</button></td></tr>';
					$mensaje['estado'] = 'EXITO';
					$mensaje['mensaje'] = 'Registro agregado ..!!';
					$mensaje['contenido'] = $contenidoTablaCentros;
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
