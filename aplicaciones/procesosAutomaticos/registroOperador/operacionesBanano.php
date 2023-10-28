<?php
if ($_SERVER['REMOTE_ADDR'] == '') {
//if(1){

	require_once '../../../clases/Conexion.php';
	require_once '../../../clases/ControladorUsuarios.php';
	require_once '../../../clases/ControladorMonitoreo.php';
	require_once '../../../clases/ControladorAplicaciones.php';
	require_once '../../../clases/ControladorRegistroOperador.php';
	require_once '../../../clases/ControladorGestionAplicacionesPerfiles.php';

	$conexion = new Conexion();
	$cr = new ControladorRegistroOperador();
	$cu = new ControladorUsuarios();
	$cm = new ControladorMonitoreo();
	$ca = new ControladorAplicaciones();
	$cgap = new ControladorGestionAplicacionesPerfiles();

	set_time_limit(60000);

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	define('PRO_MSG', '<br/> ');
	define('IN_MSG', '<br/> >>> ');
	$fecha = date("Y-m-d h:m:s");
$numero = '1';

$resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_DATO_OPERACIONES_BANANO');

	if($resultadoMonitoreo){
	//if(1){
		
		echo IN_MSG . '<b>INICIO PROCESO DE CREACION DE SITIOS, AREAS Y OPERACIONES A OPERADORES ' . $fecha . '</b>';
		
		
		$operaciones = $cr->obtenerOperacionesBanano($conexion);

		echo("<b>registros_obtenidos:_".pg_num_rows($operaciones)."</b>");

		while ($operacion = pg_fetch_assoc($operaciones)) {

			echo IN_MSG . $numero ++ . '.- Identificador operador: ' . $operacion['identificador'] . ' con id: ' . $operacion['id']." Sistema GUIA";

			$idRegistro = $operacion['id'];
			
			$cr->actulizarEstadoOperacionesBanano($conexion, $idRegistro, 'W');

			$datos = array(
				'id' => $operacion['id'],
				'identificador' => $operacion['identificador'],
				'nombreSitio' =>$operacion['nombre_sitio'],
				'superficieTotal' => $operacion['superficie_total'], 
				'provincia' => $operacion['provincia'],
				'canton' => $operacion['canton'], 
				'parroquia' => $operacion['parroquia'],
				'direccion' =>$operacion['direccion'],
				'telefono' => $operacion['telefono'],
				'latitud' => $operacion['latitud'],
				'longitud' => $operacion['longitud'],
				'tipoArea' => $operacion['tipo_area'],
				'superficieUtilizada' => $operacion['superficie_utilizada'], 
				'nombreArea' => $operacion['nombre_area'], 
				'tipoOperacion' =>$operacion['tipo_operacion'], 
				'producto' => $operacion['producto'], 
				'codigoTransaccion' => $operacion['codigo_hacienda']); 

			$vOperador = $cr->buscarOperador($conexion, $datos['identificador']); 
			$usuario = $cu->verificarUsuario($conexion, $datos['identificador']);

			if (pg_num_rows($vOperador) == 0 || pg_num_rows($usuario) == 0) {

				if (pg_num_rows($vOperador) == 0) {
					echo IN_MSG . 'El operador no se encuentra registrado en Agrocalidad.';
				
				}

				if (pg_num_rows($usuario) == 0) {
					echo IN_MSG . 'El usuario no se encuentra registrado en Agrocalidad.';
					
				}
				echo '</br>';
			} else {

				

				$qDatosAuditoria = $cr->bucarSitioPorNombreIdentificadorAuditoria($conexion, $datos['identificador'], $idRegistro, $datos['codigoTransaccion'],'activo');
				$qDato = '';
				if(pg_num_rows($qDatosAuditoria) > 0){
					while ($datosAuditoria = pg_fetch_assoc($qDatosAuditoria)) {
						$datosAuditoriaOperaciones = array(
							'id' => $datosAuditoria['id'], 
							'identificador' => $datosAuditoria['identificador'], 
							'nombreSitio' => $datosAuditoria['nombre_sitio'], 
							'superficieTotal' =>$datosAuditoria['superficie_total'], 
							'provincia' => $datosAuditoria['provincia'],
							'canton' => $datosAuditoria['canton'], 
							'parroquia' => $datosAuditoria['parroquia'], 
							'direccion' =>$datosAuditoria['direccion'], 
							'telefono' =>$datosAuditoria['telefono'], 
							'latitud' =>$datosAuditoria['latitud'], 
							'longitud' =>$datosAuditoria['longitud'], 
							'tipoArea' =>$datosAuditoria['tipo_area'],
							'superficieUtilizada' =>$datosAuditoria['superficie_utilizada'], 
							'nombreArea' => $datosAuditoria['nombre_area'],
							'tipoOperacion' => $datosAuditoria['tipo_operacion'], 
							'producto' => $datosAuditoria['producto'],
							'codigoTransaccion' =>$datosAuditoria['codigo_hacienda'], 
						);
					}
					$qDatos = $datosAuditoriaOperaciones;
					$cr->actualizarEstadoAuditoriaOperacionesBanano($conexion, $datosAuditoriaOperaciones['identificador'] ,$datosAuditoriaOperaciones['id'], 'inactivo');
				}else{
					$qDatos = $datos;
				}

				$datosProvincia = $cr->obtenerLocalizacionPorNombre($conexion, trim($qDatos['provincia']), 1, 'provincia');

				if (pg_num_rows($datosProvincia) != 0){

					$provincia = pg_fetch_assoc($datosProvincia);

					$nombreProvincia = $provincia['nombre'];

					$datosCanton = $cr->obtenerLocalizacionPorNombre($conexion, trim($qDatos['canton']), 2, 'canton', ($provincia['id_localizacion'] == '' ? 0 : $provincia['id_localizacion']));
					if (pg_num_rows($datosCanton) != 0){
						$canton = pg_fetch_assoc($datosCanton);
						$nombreCanton = $canton['nombre'];
						$parroquia = $qDatos['parroquia']!=''?trim($qDatos['parroquia']):'';
						$parroquia = $cr->obtenerLocalizacionPorNombre($conexion, $parroquia, 4, 'parroquia', ($canton['id_localizacion'] == '' ? 0 : $canton['id_localizacion']));
						if (pg_num_rows($parroquia) != 0 && $datos['parroquia']!=''){
							$parroquia = pg_fetch_assoc($parroquia);
							$nombreParroquia = $parroquia['nombre'];
						}else{
							$nombreParroquia = $qDatos['parroquia'];
						}
					}else{
						$nombreCanton = $qDatos['canton'];
						$nombreParroquia = $qDatos['parroquia'];
					}
				}else{
					$nombreProvincia = $qDatos['provincia'];
					$nombreCanton = $qDatos['canton'];
					$nombreParroquia = $qDatos['parroquia'];
				}

				
				echo IN_MSG . 'Búsqueda  de sitio de operador.';
				$qSitio = $cr->bucarSitioPorAreaNombreIdentificador($conexion, $qDatos['identificador'], $qDatos['nombreSitio'], $qDatos['superficieTotal'],$qDatos['codigoTransaccion'],$qDatos['tipoArea']); 
				

				if (pg_num_rows($qSitio) == 0) {

					echo IN_MSG . 'Generación código de sitio de operador.';
					$qSecuencialSitio = $cr->obtenerSecuencialSitio($conexion, $nombreProvincia , $qDatos['identificador']);
					$secuencialSitio = str_pad(pg_fetch_result($qSecuencialSitio, 0, 'valor'), 2, "0", STR_PAD_LEFT);

					echo IN_MSG . 'Creación de sitio de operador.';
					$qIdSitio = $cr->guardarNuevoSitio($conexion, $qDatos['nombreSitio'], $nombreProvincia, $nombreCanton, $nombreParroquia, $qDatos['direccion'], '', $qDatos['superficieTotal'], $qDatos['identificador'], $qDatos['telefono'], $qDatos['latitud'], $qDatos['longitud'], $secuencialSitio, '', '17', substr($provincia['codigo_vue'], 1));
					$idSitio = pg_fetch_assoc($qIdSitio);
				} else {
					echo IN_MSG . 'Posee un sitio creado se asocia el id.';
					$idSitio = pg_fetch_assoc($qSitio);
				}

				if (mb_strtolower($qDatos['tipoArea']) === 'lugar de producción') {
					$codigoArea = pg_fetch_assoc($cr->bucarCodigoCatalogoAreaPorNombre($conexion, $qDatos['tipoArea']));
					$idTipoOperacion = pg_fetch_result($cr->bucarCodigoCatalogoTipoOperacionPorCodigo($conexion, 'SV', 'PRB'), 0, 'id_tipo_operacion');
					//$codigoArea = '06';
				} else if (mb_strtolower($qDatos['tipoArea']) === 'domicilio tributario') {
					//$codigoArea = '09';
					$codigoArea = pg_fetch_assoc($cr->bucarCodigoCatalogoAreaPorNombre($conexion, $qDatos['tipoArea']));
					$idTipoOperacion = pg_fetch_result($cr->bucarCodigoCatalogoTipoOperacionPorCodigo($conexion, 'SV', 'EXB'), 0, 'id_tipo_operacion');
				}

				$qArea = $cr->bucarAreaPorNombreSitioTipoArea($conexion, $idSitio['id_sitio'], $qDatos['nombreArea'], $codigoArea['nombre'], $qDatos['codigoTransaccion']);

				if (pg_num_rows($qArea) == 0) {

					echo IN_MSG . 'Generación código de área de operador.';
					$qSecuencialArea = $cr->obtenerSecuencialArea($conexion, $datos['identificador'], $codigoArea['codigo'], $provincia['nombre']);
					$secuencialArea = str_pad(pg_fetch_result($qSecuencialArea, 0, 'valor'), 2, "0", STR_PAD_LEFT);

					echo IN_MSG . 'Creación de área de operador.';
					$area = $cr->guardarNuevaArea($conexion, $qDatos['nombreArea'], $codigoArea['nombre'], $qDatos['superficieUtilizada'], $idSitio['id_sitio'], $codigoArea['codigo'], $secuencialArea, $qDatos['codigoTransaccion']);
					$idArea = pg_fetch_assoc($area);
				} else {
					echo IN_MSG . 'Posee una área creada se asocia el id.';
					$idArea = pg_fetch_assoc($qArea);
		
				}
				
				$vAreaProductoOperacion = $cr->buscarAreasOperacionPorSolicitud($conexion, $idTipoOperacion, $idArea['id_area'], $qDatos['identificador']);
				
				if(pg_num_rows($vAreaProductoOperacion) == 0){
					echo IN_MSG . 'Generación del operador tipo operación del operador.';
					
					$qIdOperadorTipoOperacion = $cr->guardarTipoOperacionPorIndentificadorSitio($conexion, $qDatos['identificador'], $idSitio['id_sitio'], $idTipoOperacion); //guarda
					$idOperadorTipoOperacion = pg_fetch_assoc($qIdOperadorTipoOperacion);
					
					echo IN_MSG . 'Generación del historial de tipo operación del operador.';
					$qHistorialOperacion = $cr->guardarDatosHistoricoOperacion($conexion, $idOperadorTipoOperacion['id_operador_tipo_operacion']);
					$historicoOperacion = pg_fetch_assoc($qHistorialOperacion);
					
					$idVigenciaDocumento = 0;
					
					echo IN_MSG . 'Creación de la operación del operador.';
					$qIdSolicitud= $cr->guardarNuevaOperacionPorTipoOperacion($conexion, $idTipoOperacion, $qDatos['identificador'], $idOperadorTipoOperacion['id_operador_tipo_operacion'], $historicoOperacion['id_historial_operacion'], 'creado', $idVigenciaDocumento);
					$idSolicitud = pg_fetch_assoc($qIdSolicitud);
					
					$cr->actualizarIdentificadorOperacionPorOperadorTipoOperacion($conexion, $idOperadorTipoOperacion['id_operador_tipo_operacion'], $idSolicitud['id_operacion']);
					
					$cr->guardarAreaOperacion($conexion, $idArea['id_area'], $idSolicitud['id_operacion']);
					$cr->guardarAreaPorIdentificadorTipoOperacion($conexion, $idArea['id_area'], $idOperadorTipoOperacion['id_operador_tipo_operacion']);

					echo IN_MSG . 'Actualización de estado de operación del operador.';
					$cr -> enviarOperacion($conexion, $idSolicitud['id_operacion'],'cargarProducto');
					
					$producto = pg_fetch_assoc($cr->obtenerCodigoProducto($conexion, 'Frutas, hortalizas y tubérculos frescos', 'Fruta', $qDatos['producto']));
					$todosProductos = "(" . rtrim($producto['id_producto'], ',') . ")";
					
					$vAreaProductoOperacionS = $cr->buscarAreasOperacionProductoXSolicitud($conexion, $idTipoOperacion, $todosProductos, $idArea['id_area'], $qDatos['identificador']);
					
					if(pg_num_rows($vAreaProductoOperacionS) ==0){
						
						$qOperacion = $cr->abrirOperacionXid($conexion, $idSolicitud['id_operacion']);
						$operacion = pg_fetch_assoc($qOperacion);
						
						if ($operacion['id_producto'] == null){
							
							$cr->actualizarProductoOperacion($conexion, $idSolicitud['id_operacion'], $producto['id_producto'], $producto['nombre_comun']);
							$idSolicitud = $idSolicitud['id_operacion'];
						}else{
							
							$qIdSolicitud = $cr->guardarNuevaOperacionPorTipoOperacion($conexion, $operacion['id_tipo_operacion'], $qDatos['identificador'], $operacion['id_operador_tipo_operacion'], $operacion['id_historial_operacion'], 'cargarProducto', $idVigenciaDocumento);
							$idSolicitud = pg_fetch_result($qIdSolicitud, 0, 'id_operacion');
							$cr->actualizarProductoOperacion($conexion, $idSolicitud, $producto['id_producto'], $producto['nombre_comun'], $idVigenciaDocumento);
							$cr->guardarAreaOperacion($conexion, $idArea['id_area'], $idSolicitud);
						}
						
						$cr->enviarOperacionEstadoAnterior($conexion, $idSolicitud);
						
						$fechaActual = date('Y-m-d H-i-s');
						$cr->actualizarEstadoPorOperadorTipoOperacionHistorial($conexion, $operacion['id_operador_tipo_operacion'], $operacion['id_historial_operacion'], 'registrado', 'Solicitud aprobada '.$fechaActual);
						$cr->cambiarEstadoAreaOperacionPorPorOperadorTipoOperacionHistorial($conexion, $operacion['id_operador_tipo_operacion'], $operacion['id_historial_operacion']);
						
						$cr-> actualizarEstadoTipoOperacionPorIndentificadorSitio($conexion, $idOperadorTipoOperacion['id_operador_tipo_operacion'], 'registrado');
						
					}else{
						echo IN_MSG . 'Posee una operación con el producto deseado.';
					}
					
				}else{
					echo IN_MSG . 'Ya posee operación.';
					
					echo IN_MSG . 'Agregacion de nuevo producto.';
					$idVigenciaDocumento = 0;
					$producto = pg_fetch_assoc($cr->obtenerCodigoProducto($conexion, 'Frutas, hortalizas y tubérculos frescos', 'Fruta', $qDatos['producto']));
					$todosProductos = "(" . rtrim($producto['id_producto'], ',') . ")";
					
					$vAreaProductoOperacionS = $cr->buscarAreasOperacionProductoXSolicitud($conexion, $idTipoOperacion, $todosProductos, $idArea['id_area'], $qDatos['identificador']);
					
					if(pg_num_rows($vAreaProductoOperacionS) ==0){
						
						$qOperacion = $cr->abrirOperacionXid($conexion, pg_fetch_result($vAreaProductoOperacion, 0, 'id_operacion'));
						$operacion = pg_fetch_assoc($qOperacion);
						
						if ($operacion['id_producto'] == null){
							
							$cr->actualizarProductoOperacion($conexion, $idSolicitud['id_operacion'], $producto['id_producto'], $producto['nombre_comun']);
							$idSolicitud = $idSolicitud['id_operacion'];
						}else{
							
							$qIdSolicitud = $cr->guardarNuevaOperacionPorTipoOperacion($conexion, $operacion['id_tipo_operacion'], $qDatos['identificador'], $operacion['id_operador_tipo_operacion'], $operacion['id_historial_operacion'], 'cargarProducto', $idVigenciaDocumento);
							$idSolicitud = pg_fetch_result($qIdSolicitud, 0, 'id_operacion');
							$cr->actualizarProductoOperacion($conexion, $idSolicitud, $producto['id_producto'], $producto['nombre_comun'], $idVigenciaDocumento);
							$cr->guardarAreaOperacion($conexion, $idArea['id_area'], $idSolicitud);
						}
						
						$cr->enviarOperacionEstadoAnterior($conexion, $idSolicitud);
						
						$fechaActual = date('Y-m-d H-i-s');
						$cr->actualizarEstadoPorOperadorTipoOperacionHistorial($conexion, $operacion['id_operador_tipo_operacion'], $operacion['id_historial_operacion'], 'registrado', 'Solicitud aprobada '.$fechaActual);
						$cr->cambiarEstadoAreaOperacionPorPorOperadorTipoOperacionHistorial($conexion, $operacion['id_operador_tipo_operacion'], $operacion['id_historial_operacion']);
						
						$cr-> actualizarEstadoTipoOperacionPorIndentificadorSitio($conexion, $operacion['id_operador_tipo_operacion'], 'registrado');
					}else{
						echo IN_MSG . 'Posee una operación con el producto deseado.';
					}
				}
				
				echo IN_MSG . 'Creación de operación del operador finalizada.</br>';
				$cr->actulizarEstadoOperacionesBanano($conexion, $idRegistro, 'Atendida');
				
				echo IN_MSG . 'Asignacion de aplicacion registro fitosanitario.</br>';
				
				$modulosAgregados = "('PRG_INSP_FITO'),";
				$perfilesAgregados = "('PFL_INS_FITO'),";
				
				$qGrupoAplicacion = $cgap->obtenerGrupoAplicacion($conexion, '(' . rtrim($modulosAgregados, ',') . ')');
				
				if (pg_num_rows($qGrupoAplicacion) > 0){
					while ($filaAplicacion = pg_fetch_assoc($qGrupoAplicacion)){
						if (pg_num_rows($ca->obtenerAplicacionPerfil($conexion, $filaAplicacion['id_aplicacion'], $qDatos['identificador'])) == 0){
							$cgap->guardarGestionAplicacion($conexion, $qDatos['identificador'], $filaAplicacion['codificacion_aplicacion']);
							$qGrupoPerfiles = $cgap->obtenerGrupoPerfilXAplicacion($conexion, $filaAplicacion['id_aplicacion'], '(' . rtrim($perfilesAgregados, ',') . ')');
							while ($filaPerfil = pg_fetch_assoc($qGrupoPerfiles)){
								$cgap->guardarGestionPerfil($conexion, $qDatos['identificador'], $filaPerfil['codificacion_perfil']);
							}
						}else{
							$qGrupoPerfiles = $cgap->obtenerGrupoPerfilXAplicacion($conexion, $filaAplicacion['id_aplicacion'], '(' . rtrim($perfilesAgregados, ',') . ')');
							while ($filaPerfil = pg_fetch_assoc($qGrupoPerfiles)){
								$qPerfil = $cu->obtenerPerfilUsuario($conexion, $filaPerfil['id_perfil'], $qDatos['identificador']);
								if (pg_num_rows($qPerfil) == 0)
									$cgap->guardarGestionPerfil($conexion, $qDatos['identificador'], $filaPerfil['codificacion_perfil']);
							}
						}
					}
				}
				
				echo IN_MSG . 'Fin asignacion de aplicacion registro fitosanitario.</br>';
			}
		}



		////////////////////////////////////////////////////////////////////////////////////----ACTUALIZACION SITIOS -  AREAS///////////////////////////////////////////////////////////////////////////////////////////////////
	
				echo IN_MSG . '<b>INICIO PROCESO DE ACTUALIZACION DATOS SITIOS Y AREAS ' . $fecha . '</b>';

		
		$operacionesAuditoria = $cr->obtenerOperacionesBananoPorAreaAuditoria($conexion);
			$cantidaRegistros = pg_num_rows($operacionesAuditoria);
		echo("<b>registros_obtenidos:_".$cantidaRegistros."</b>");
			$actu =0;
		if (pg_num_rows($operacionesAuditoria) > 0){

			while ($filas = pg_fetch_row($operacionesAuditoria)) {

				$arrayParametros = array(
					'identificador' => $filas[0],
					'tipo_area' => $filas[9],
					'tipo_operacion' => $filas[10],
					'producto' => $filas[11],
					'codigo_hacienda' => $filas[12]
					);

				$operaciones = $cr->obtenerOperacionesBananoPorAreaPorId($conexion,$arrayParametros);
				echo("<b>registros_obtenidos:_".pg_num_rows($operaciones)."</b>");
				
				while ($filas = pg_fetch_row($operaciones)) {
					if($filas[16]=='Atendida'){
						$actu = $actu+1;
						if (pg_num_rows($operaciones) > 0){
								
							$valoresSitio = '';
							$valoresArea = '';
						
								// echo IN_MSG . $numero ++ . '.- Identificador operador: ' . $filas[1] .'con id: ' . $filas[0]." Sistema GUIA  ----- contador_:".$contador;

								$valoresSitio = "('$filas[2]','$filas[3]','$filas[7]','$filas[8]','$filas[9]','$filas[10]','$filas[17]'";
							
								$valoresSitio = trim($valoresSitio, ',');
							
								if ($valoresSitio != '') {
							
									echo '<br/> >>>>Actualizacion de sitios operador banano';
									$cr->actualizarSitioOperadorBanano($conexion, $valoresSitio,$arrayParametros);
									echo '<br/> <<< Fin de actualizacion de sitios operador banano<br/>';
								}

								$area = $cr->buscarAreaBanano($conexion,$arrayParametros);

								if(pg_num_rows($area) > 0){

									$idArea = pg_fetch_assoc($area);

									$codidoArea = $idArea['id_area'];

									$arrayParametrosArea = array(
										'nombre_area' => $filas[13],
										'superficie_utilizada' => $filas[12]
										);
								
										echo '<br/> >>>>Actualizacion de area operador banano';
										$cr->actualizarAreaOperadorBanano($conexion, $arrayParametrosArea,$filas[11],$codidoArea );
										echo '<br/> <<< Fin de actualizacion de area operador banano<br/>';
									
								}
								
						
						}
					}
				}
			}
		}
		echo IN_MSG . '<b>FIN DE PROCESO DE ACTUALIZACION DATOS SITIOS Y AREAS ' . $fecha . '</b>';

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

////////////////////////////////////////////////////////////////////////////////////-----INACTIVACION SITIOS, AREAS ----////////////////////////////////////////////////////////////////////////////////////////////////

		echo IN_MSG . '<b>INICIO PROCESO DE ACTIVACION DE SITIOS, AREAS Y OPERACIONES A OPERADORES ' . $fecha . '</b>';
		
		$operaciones = $cr->obtenerOperacionesBanano($conexion, 'W');
		
		while ($operacion = pg_fetch_assoc($operaciones)) {
			
			$idRegistro = $operacion['id'];
			
			$cr->actulizarEstadoOperacionesBanano($conexion, $idRegistro, 'W');
			
			$datos = array(
				'id' => $operacion['id'], 
				'identificador' => $operacion['identificador'], 
				'nombreSitio' => $operacion['nombre_sitio'], 
				'superficieTotal' => $operacion['superficie_total'],
				'provincia' => $operacion['provincia'],
				'canton' => $operacion['canton'], 
				'parroquia' => $operacion['parroquia'], 
				'direccion' => $operacion['direccion'], 
				'telefono' => $operacion['telefono'],
				'latitud' => $operacion['latitud'], 
				'longitud' => $operacion['longitud'], 
				'tipoArea' => $operacion['tipo_area'],
				'superficieUtilizada' => $operacion['superficie_utilizada'], 
				'nombreArea' =>$operacion['nombre_area'], 
				'tipoOperacion' => trim(htmlspecialchars($operacion['tipo_operacion'], ENT_NOQUOTES, 'UTF-8')),
				'producto' => $operacion['producto'], 
				'codigoTransaccion' =>$operacion['codigo_hacienda'], 
			);

					$qDatos = $datos;
				
			$qSitio = $cr->bucarSitioPorAreaNombreIdentificador($conexion, $qDatos['identificador'], $qDatos['nombreSitio'], $qDatos['superficieTotal'],$qDatos['codigoTransaccion'],$qDatos['tipoArea']);
			echo IN_MSG . $numero ++ . '.- Identificador operador: ' . $qDatos['identificador'] . ' con id: ' . $qDatos['id']." Sistema GUIA";
			if (pg_num_rows($qSitio) != 0) {
				echo IN_MSG . 'Posee un sitio creado se asocia el id.';
				$idSitio = pg_fetch_assoc($qSitio);
				
				if (mb_strtolower($qDatos['tipoArea']) === 'lugar de producción') {
					$codigoArea = pg_fetch_assoc($cr->bucarCodigoCatalogoAreaPorNombre($conexion, $qDatos['tipoArea']));
					$idTipoOperacion = pg_fetch_result($cr->bucarCodigoCatalogoTipoOperacionPorCodigo($conexion, 'SV', 'PRB'), 0, 'id_tipo_operacion');
					//$codigoArea = '06';
				} else if (mb_strtolower($qDatos['tipoArea']) === 'domicilio tributario') {
					//$codigoArea = '09';
					$codigoArea = pg_fetch_assoc($cr->bucarCodigoCatalogoAreaPorNombre($conexion, $qDatos['tipoArea']));
					$idTipoOperacion = pg_fetch_result($cr->bucarCodigoCatalogoTipoOperacionPorCodigo($conexion, 'SV', 'EXB'), 0, 'id_tipo_operacion');
				}
				
				$qArea = $cr->bucarAreaPorNombreSitioTipoArea($conexion, $idSitio['id_sitio'], $qDatos['nombreArea'], $codigoArea['nombre'], $qDatos['codigoTransaccion']);
				
				if (pg_num_rows($qArea) != 0) {
					echo IN_MSG . 'Posee una área creada se asocia el id.';
					$idArea = pg_fetch_assoc($qArea);
					
					$producto = pg_fetch_assoc($cr->obtenerCodigoProducto($conexion, 'Frutas, hortalizas y tubérculos frescos', 'Fruta', $qDatos['producto']));
					$todosProductos = "(" . rtrim($producto['id_producto'], ',') . ")";
					
					$vAreaProductoOperacionS = $cr->buscarAreasOperacionProductoXSolicitud($conexion, $idTipoOperacion, $todosProductos, $idArea['id_area'], $qDatos['identificador']);
					
					
					if(pg_num_rows($vAreaProductoOperacionS) !=0){
						echo IN_MSG . 'Posee una operacion creada se asocia el id.';
						
						$idOperacion = pg_fetch_result($vAreaProductoOperacionS, 0, 'id_operacion');
						
						$cr->enviarOperacionEstadoAnterior($conexion, $idOperacion); //registrado   //nohabilitado
						
						$cr->enviarOperacion($conexion, $idOperacion, 'Registrado', 'Operación habilitada, por proceso de actualización MAG');  //nohabilitado  //registrado
						
						$cr->cambiarEstadoAreaXidSolicitud($conexion, $idOperacion, 'Registrado', 'Operación  habilitada, por proceso de actualización MAG');

						
						echo IN_MSG . 'Creación de operación del operador finalizada.</br>';
						$cr->actulizarEstadoOperacionesBanano($conexion, $idRegistro, 'Atendida');
						
						echo IN_MSG . 'Asignacion de aplicacion registro de musaceas.</br>';
						$modulosAgregados = "('PRG_INSP_FITO'),";
						$perfilesAgregados = "('PFL_INS_FITO'),";
						
						$qGrupoAplicacion = $cgap->obtenerGrupoAplicacion($conexion, '(' . rtrim($modulosAgregados, ',') . ')');
						
						if (pg_num_rows($qGrupoAplicacion) > 0){
							while ($filaAplicacion = pg_fetch_assoc($qGrupoAplicacion)){
								if (pg_num_rows($ca->obtenerAplicacionPerfil($conexion, $filaAplicacion['id_aplicacion'], $qDatos['identificador'])) == 0){
									$cgap->guardarGestionAplicacion($conexion, $qDatos['identificador'], $filaAplicacion['codificacion_aplicacion']);
									$qGrupoPerfiles = $cgap->obtenerGrupoPerfilXAplicacion($conexion, $filaAplicacion['id_aplicacion'], '(' . rtrim($perfilesAgregados, ',') . ')');
									while ($filaPerfil = pg_fetch_assoc($qGrupoPerfiles)){
										$cgap->guardarGestionPerfil($conexion, $qDatos['identificador'], $filaPerfil['codificacion_perfil']);
									}
								}else{
									$qGrupoPerfiles = $cgap->obtenerGrupoPerfilXAplicacion($conexion, $filaAplicacion['id_aplicacion'], '(' . rtrim($perfilesAgregados, ',') . ')');
									while ($filaPerfil = pg_fetch_assoc($qGrupoPerfiles)){
										$qPerfil = $cu->obtenerPerfilUsuario($conexion, $filaPerfil['id_perfil'], $qDatos['identificador']);
										if (pg_num_rows($qPerfil) == 0)
											$cgap->guardarGestionPerfil($conexion, $qDatos['identificador'], $filaPerfil['codificacion_perfil']);
									}
								}
							}
						}
						
					}else{
						echo IN_MSG . 'No posee una operacion creada.';
					}
				} else {
					echo IN_MSG . 'No posee una área creada.';
				}
			} else {
				echo IN_MSG . 'No posee un sitio creado.';
			}
			
			echo IN_MSG . 'Activación de operación del operador finalizada.</br>';
			$cr->actulizarEstadoOperacionesBanano($conexion, $idRegistro, 'Atendida');
		}

		////////////////////////////////////////////////////////////////////////////////////-----INACTIVACION SITIOS, AREAS ----/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo IN_MSG . '<b>INICIO PROCESO DE INACTIVACION DE SITIOS, AREAS Y OPERACIONES A OPERADORES ' . $fecha . '</b>';
		
		$operaciones = $cr->obtenerOperacionesBanano($conexion, 'Por inactivar');
		
		while ($operacion = pg_fetch_assoc($operaciones)) {
			
			$idRegistro = $operacion['id'];
			
			$cr->actulizarEstadoOperacionesBanano($conexion, $idRegistro, 'W');
			
			$datos = array(
				'id' => trim(htmlspecialchars($operacion['id'], ENT_NOQUOTES, 'UTF-8')),
				'identificador' => trim(htmlspecialchars($operacion['identificador'], ENT_NOQUOTES, 'UTF-8')),
				'nombreSitio' => trim(htmlspecialchars($operacion['nombre_sitio'], ENT_NOQUOTES, 'UTF-8')),
				'superficieTotal' => trim(htmlspecialchars($operacion['superficie_total'], ENT_NOQUOTES, 'UTF-8')),
				'provincia' => trim(htmlspecialchars($operacion['provincia'], ENT_NOQUOTES, 'UTF-8')),
				'canton' => trim(htmlspecialchars($operacion['canton'], ENT_NOQUOTES, 'UTF-8')),
				'parroquia' => trim(htmlspecialchars($operacion['parroquia'], ENT_NOQUOTES, 'UTF-8')),
				'direccion' => trim(htmlspecialchars($operacion['direccion'], ENT_NOQUOTES, 'UTF-8')),
				'telefono' => trim(htmlspecialchars($operacion['telefono'], ENT_NOQUOTES, 'UTF-8')),
				'latitud' => trim(htmlspecialchars($operacion['latitud'], ENT_NOQUOTES, 'UTF-8')),
				'longitud' => trim(htmlspecialchars($operacion['longitud'], ENT_NOQUOTES, 'UTF-8')),
				'tipoArea' => trim(htmlspecialchars($operacion['tipo_area'], ENT_NOQUOTES, 'UTF-8')),
				'superficieUtilizada' => trim(htmlspecialchars($operacion['superficie_utilizada'], ENT_NOQUOTES, 'UTF-8')),
				'nombreArea' => trim(htmlspecialchars($operacion['nombre_area'], ENT_NOQUOTES, 'UTF-8')),
				'tipoOperacion' => trim(htmlspecialchars($operacion['tipo_operacion'], ENT_NOQUOTES, 'UTF-8')),
				'producto' => trim(htmlspecialchars($operacion['producto'], ENT_NOQUOTES, 'UTF-8')),
				'codigoTransaccion' => trim(htmlspecialchars($operacion['codigo_hacienda'], ENT_NOQUOTES, 'UTF-8'))
			);
			
			$qSitio = $cr->bucarSitioPorNombreIdentificador($conexion, $datos['identificador'], $datos['nombreSitio'], $datos['superficieTotal']);
			
			if (pg_num_rows($qSitio) != 0) {
				echo IN_MSG . 'Posee un sitio creado se asocia el id.';
				$idSitio = pg_fetch_assoc($qSitio);
				
				if ($datos['tipoArea'] == 'Lugar de producción') {
					$codigoArea = pg_fetch_assoc($cr->bucarCodigoCatalogoAreaPorNombre($conexion, $datos['tipoArea']));
					$idTipoOperacion = pg_fetch_result($cr->bucarCodigoCatalogoTipoOperacionPorCodigo($conexion, 'SV', 'PRB'), 0, 'id_tipo_operacion');
					//$codigoArea = '06';
				} else if ($datos['tipoArea'] == 'Domicilio tributario') {
					//$codigoArea = '09';
					$codigoArea = pg_fetch_assoc($cr->bucarCodigoCatalogoAreaPorNombre($conexion, $datos['tipoArea']));
					$idTipoOperacion = pg_fetch_result($cr->bucarCodigoCatalogoTipoOperacionPorCodigo($conexion, 'SV', 'EXB'), 0, 'id_tipo_operacion');
				}
				
				$qArea = $cr->bucarAreaPorNombreSitioTipoArea($conexion, $idSitio['id_sitio'], $datos['nombreArea'], $codigoArea['nombre'], $datos['superficieUtilizada'], $datos['codigoTransaccion']);
				
				if (pg_num_rows($qArea) != 0) {
					echo IN_MSG . 'Posee una área creada se asocia el id.';
					$idArea = pg_fetch_assoc($qArea);
					
					$producto = pg_fetch_assoc($cr->obtenerCodigoProducto($conexion, 'Frutas, hortalizas y tubérculos frescos', 'Fruta', $datos['producto']));
					$todosProductos = "(" . rtrim($producto['id_producto'], ',') . ")";
					
					$vAreaProductoOperacionS = $cr->buscarAreasOperacionProductoXSolicitud($conexion, $idTipoOperacion, $todosProductos, $idArea['id_area'], $datos['identificador']);
					
					
					if(pg_num_rows($vAreaProductoOperacionS) !=0){
						echo IN_MSG . 'Posee una operacion creada se asocia el id.';
						
						$idOperacion = pg_fetch_result($vAreaProductoOperacionS, 0, 'id_operacion');
						
						$cr->enviarOperacionEstadoAnterior($conexion, $idOperacion);
						
						$cr->enviarOperacion($conexion, $idOperacion, 'noHabilitado', 'Operación no habilitada, por proceso de actualización MAG');
						
						$cr->cambiarEstadoAreaXidSolicitud($conexion, $idOperacion, 'noHabilitado', 'Operación no habilitada, por proceso de actualización MAG');
						
						echo IN_MSG . 'Eliminacion de aplicacion registro de musaceas.</br>';
						
						$verificacionOperacion = $cr->verificarOperacionesBanano($conexion,  $datos['identificador']);
						
						if(pg_num_rows($verificacionOperacion) == 0){
							
							$modulosAgregados = "('PRG_INSP_MUS'),";
							
							$qGrupoAplicacion = $cgap->obtenerGrupoAplicacion($conexion, '(' . rtrim($modulosAgregados, ',') . ')');
							
							$ca->eliminarAplicacion($conexion, $datos['identificador'], pg_fetch_result($qGrupoAplicacion, 0, 'id_aplicacion'));
							
							echo IN_MSG . 'Ingreso eliminacion de aplicacion registro de musaceas.</br>';
							
						}
						
						echo IN_MSG . 'Fin eliminacion de aplicacion registro de musaceas.</br>';
						
					}else{
						echo IN_MSG . 'No posee una operacion creada.';
					}
				} else {
					echo IN_MSG . 'No posee una área creada.';
				}
			} else {
				echo IN_MSG . 'No posee un sitio creado.';
			}
			
			echo IN_MSG . 'Inactivación de operación del operador finalizada.</br>';
			$cr->actulizarEstadoOperacionesBanano($conexion, $idRegistro, 'Inactivado');
		}
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo IN_MSG. 'FIN DE PROCESO CROM.';
		
		
	}

	
}else{
	
	$minutoS1 = microtime(true);
	$minutoS2 = microtime(true);
	$tiempo = $minutoS2 - $minutoS1;
	$xcadenota = "FECHA " . date("d/m/Y") . " " . date("H:i:s");
	$xcadenota .= "; IP REMOTA " . $_SERVER['REMOTE_ADDR'];
	$xcadenota .= "; SERVIDOR HTTP " . $_SERVER['HTTP_REFERER'];
	$xcadenota .= "; SEGUNDOS " . $tiempo . "\n";
	$arch = fopen("../../../aplicaciones/logs/cron/automatico_datos_operaciones_banano" . date("d-m-Y") . ".txt", "a+");
	fwrite($arch, $xcadenota);
	fclose($arch);
}

?>