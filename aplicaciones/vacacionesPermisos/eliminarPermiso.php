<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVacaciones.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

try{
	
	$identificadorUsuarioRegistro = $_SESSION['usuario'];
	
	$observaciones = htmlspecialchars ($_POST['observacion'],ENT_NOQUOTES,'UTF-8');
	                
	$permisos = $_POST['id'];
		
	try {
		$conexion = new Conexion();
		$cv = new ControladorVacaciones();
		
		if ($identificadorUsuarioRegistro != ''){
		    for ($i = 0; $i < count ($permisos); $i++) {
		        
		        //Eliminar permiso		        
		        $res = $cv->obtenerPermisoSolicitado($conexion, $permisos[$i]);
		        $permisoUsuario = pg_fetch_assoc($res);
		        
		        //Permisos sin descuento de tiempo
		        if($permisoUsuario['codigo'] == 'VA-VA' || $permisoUsuario['codigo'] == 'PE-PIV'){
		            $cv->eliminarPermisoConTiempo($conexion, $permisos[$i], $observaciones);
		            
		            //Devolución de tiempo restado
		            //Buscar registros de tiempo generados por permiso
		            $registrosTiempo = $cv->buscarRegistrosPermisoConTiempo($conexion, $permisos[$i]);
		            //$registrosTiempo = pg_fetch_result($res);
		            //print_r( $registrosTiempo );
		            //echo 'Buscar registros de tiempo generados por permiso';
		            
		            while($regTiempo = pg_fetch_assoc($registrosTiempo)){
		                $idDescuento =$regTiempo['id_detalle_descuento'];
		                $identificador = $regTiempo['identificador'];
		                $anio = $regTiempo['anio'];
		                $tiempo = $regTiempo['tiempo'];
		                
		                //Buscar registro de saldo de tiempo por año del usuario
		                //Obtener saldo actual
		                $resS = $cv->buscarRegistrosTiempoUsuarioXAnio($conexion, $identificador, $anio);
		                $saldoTiempoUsuario = pg_fetch_result($resS, 0, 'minutos_disponibles');
		                $max = pg_fetch_result($resS, 0, 'secuencial');
		                
		               // echo 'Obtener saldo actual';
		                
		                //Actualizar tiempo de saldo
		                $cv->actualizarTiempoDevolucionSaldo($conexion, $identificador, $anio, ($tiempo+$saldoTiempoUsuario), $observaciones, $max);
		                //echo 'Actualizar tiempo de saldo';
		                //Actualizar detalle tiempo permiso
		                $cv->actualizarTiempoDevolucionPermiso($conexion, $idDescuento);
		            }
		            	            
		           
		        }else{//permisos con descuento de tiempo
		            $cv->eliminarPermisoSinTiempo($conexion, $permisos[$i], $observaciones);
		        }
		        
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