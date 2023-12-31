<?php

	if($_SERVER['REMOTE_ADDR'] == ''){
		require_once '../../clases/Conexion.php';
		require_once '../../clases/ControladorMail.php';
		require_once '../../clases/ControladorReportes.php';
		require_once '../../clases/ControladorFinanciero.php';
		require_once '../../clases/ControladorCertificados.php';
		require_once '../../clases/ControladorImportaciones.php';
		require_once '../../clases/ControladorFitosanitario.php';
		require_once '../../clases/ControladorFitosanitarioExportacion.php';
		
		define('IN_MSG','<br/> >>> ');
		
		set_time_limit(150);
		ini_set('default_socket_timeout',150);
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>

<?php
			
		$conexion = new Conexion();
		$cc = new ControladorCertificados();
		$cf = new ControladorFinanciero();
		$jru = new ControladorReportes();
		$cMail = new ControladorMail();
		
		$fechaVigente = pg_fetch_assoc($cf->obtenerFechasContigenciaVigentes($conexion));
		$fechaActualSistema = date('Y-m-d H:i:s');
			
		$fechaContingenciaDesde = date('Y-m-d H:i:s', strtotime($fechaVigente['fecha_desde']));
		$fechaContingenciaHasta = date('Y-m-d H:i:s', strtotime($fechaVigente['fecha_hasta']));
			
			
		if($fechaActualSistema >= $fechaContingenciaDesde && $fechaActualSistema <= $fechaContingenciaHasta ){
			
			echo '<p> <strong>SISTEMA DEL SRI EN MANTENIMIENTO, CLAVES DE CONTINGENCIA ACTIVADAS</strong></p>';
			
		}else{
			$solicitudesPendientes = $cc->cargarDocumentosPoratenderEnvioSRI($conexion);
	
			echo '<p> <strong>INICIO FACTURCIÓN ELECTRONICA ' . $solicitudPendiente['clave_acceso'] . '</strong></br>';
				
			while ($solicitudPendiente = pg_fetch_assoc($solicitudesPendientes)){
					
				echo '<p> <strong>CLAVE DE ACCESO ' . $solicitudPendiente['clave_acceso'] . '</strong>'. IN_MSG . 'Tipo comprobante '. $solicitudPendiente['tipo'];
					
				$nombreArchivoXML = $solicitudPendiente['clave_acceso'].'.xml';
				$nombreArchivoPDF = $solicitudPendiente['clave_acceso'].'.pdf';
					
				switch ($solicitudPendiente['estado_sri']){
						
					case 'POR ATENDER':
							
						$cc->cambiarEstadoComprobantesElectronicos($conexion, $solicitudPendiente['tipo'], 'W', $solicitudPendiente['id_comprobante']);
							
						echo IN_MSG . 'Envio de comprobante al SRI.';
						$respuestaRecepcion = $cc->enviarXMLSRI($constg::RUTA_SERVIDOR_OPT, $constg::RUTA_APLICACION, $nombreArchivoXML);
							
						$estadoComprobante = $respuestaRecepcion->RespuestaRecepcionComprobante->estado;
						$observacionSRI = json_encode($respuestaRecepcion->RespuestaRecepcionComprobante->comprobantes->comprobante);
						$observacionSRI = str_replace("'", "''", $observacionSRI);
							
						switch ($solicitudPendiente['tipo']){
							case 'factura':
									
								if($estadoComprobante != ''){
									echo IN_MSG . 'Actualización de estado del comprobante';
									$cc->actualizarObservacionSRIFactura($conexion, $solicitudPendiente['id_comprobante'], $observacionSRI);
									$cc->cambiarEstadoComprobantesElectronicos($conexion, $solicitudPendiente['tipo'], $estadoComprobante, $solicitudPendiente['id_comprobante']);
								}else{
									echo IN_MSG . 'Problemas al enviar el comprobante';
									$cc->actualizarObservacionSRIFactura($conexion, $solicitudPendiente['id_comprobante'],$observacionSRI);
								}
									
								break;
									
							case 'notaCredito':
									
								if($estadoComprobante != ''){
									echo IN_MSG . 'Actualización de estado del comprobante';
									$cc->actualizarObservacionSRINotaCredito($conexion, $solicitudPendiente['id_comprobante'], $observacionSRI);
									$cc->cambiarEstadoComprobantesElectronicos($conexion, $solicitudPendiente['tipo'], $estadoComprobante, $solicitudPendiente['id_comprobante']);
								}else{
									echo IN_MSG . 'Problemas al enviar el comprobante';
									$cc->actualizarObservacionSRIFactura($conexion, $solicitudPendiente['id_comprobante'],$observacionSRI);
								}
									
								break;
									
							default:
								echo 'Tipo formulario desconocido.';
						}
							
						echo IN_MSG . 'Fin de envio comprobante al SRI';
							
						break;
							
							
					case 'RECIBIDA':
							
						echo IN_MSG . 'Solicitando autorización al SRI';
							
						$cc->cambiarEstadoComprobantesElectronicos($conexion, $solicitudPendiente['tipo'], 'WA', $solicitudPendiente['id_comprobante']);
							
						$respuestaAutorizacion = $cc->obtenerAutorizacionSRI($solicitudPendiente['clave_acceso']);
							
						$estadoAutorizacionXML = $respuestaAutorizacion->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado;
						$numeroAutorizacion = $respuestaAutorizacion->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
						$fechaAutorizacion = $respuestaAutorizacion->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
						$comprobante = $respuestaAutorizacion->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
							
						$rutaArchivoFirmado = $constg::RUTA_SERVIDOR_OPT."/".$constg::RUTA_APLICACION."/aplicaciones/financiero/archivoXml/autorizadosSRI/".$nombreArchivoXML;
						
						//----------------------------------------------------------------GENERAR XML--------------------------------------------------------------------

						//Generar archivo xml
						$xml = new DomDocument('1.0', 'UTF-8');

						//Nodo principal
						$root = $xml->createElement('autorizacion');
						$root = $xml->appendChild($root);

						$estado=$xml->createElement('estado',$estadoAutorizacionXML);
						$estado =$root->appendChild($estado);

						$numeroAutorizacionMailSRI=$xml->createElement('numeroAutorizacion',$numeroAutorizacion);
						$numeroAutorizacionMailSRI =$root->appendChild($numeroAutorizacionMailSRI);

						$fechaAutorizacionMailSRI=$xml->createElement('fechaAutorizacion',$fechaAutorizacion);
						$fechaAutorizacionMailSRI =$root->appendChild($fechaAutorizacionMailSRI);

						$cdata = $xml->createCDATASection($comprobante);

						$comprobanteMailSRI=$xml->createElement('comprobante');
						$comprobanteMailSRI =$root->appendChild($comprobanteMailSRI);

						$comprobanteMailSRI->appendChild($cdata);

						$xml->formatOutput = true;  //poner los string en la variable $strings_xml:
						$strings_xml = $xml->saveXML();

						$xml->save($rutaArchivoFirmado);

						//----------------------------------------------------------------FIN XML--------------------------------------------------------------------
											
						switch ($solicitudPendiente['tipo']){
							case 'factura':
									
								if($estadoAutorizacionXML == 'AUTORIZADO'){
										
									echo IN_MSG . 'Comprobante autorizado.';
			
									$rutaArchivoAutorizado = $constg::RUTA_SERVIDOR_OPT."/".$constg::RUTA_APLICACION."/aplicaciones/financiero/archivoXml/autorizadosSRI/".$nombreArchivoXML;
									//copy($rutaArchivoFirmado, $rutaArchivoAutorizado);
			
									//--------------------------------------RUTAS DE REPORTE FACTURA ---------------------------------------------------
									$ReporteJasper='aplicaciones/financiero/reportes/factura.jrxml';										
									$salidaReporte='aplicaciones/financiero/documentos/facturas/'.$nombreArchivoPDF;
										
									echo IN_MSG . 'Actualización de datos de autorización.';
			
									$cc->actualizarDatosAutorizacionSRIFactura($conexion, $solicitudPendiente['id_comprobante'], $estadoAutorizacionXML, $numeroAutorizacion, $fechaAutorizacion, $rutaArchivoAutorizado, $salidaReporte);
			
									//--------------------------------------DATOS NUEVOS REPORTE FACTURA ---------------------------------------------------
									
									$ordenPago = pg_fetch_assoc($cc->abrirOrdenPago($conexion, $solicitudPendiente['id_comprobante']));
																		
									switch ($ordenPago['tipo_solicitud']){										
										case 'Importación':
											$ci = new ControladorImportaciones();									
											$importacion = pg_fetch_assoc($ci->obtenerImportacion($conexion, $ordenPago['id_solicitud']));									
											$solicitudAtendida = $importacion['id_vue'];									
										break;	
										case 'Fitosanitario':
											$cfi = new ControladorFitosanitario();											
											$fitosanitario = pg_fetch_assoc($cfi->listarFitoExportacion($conexion, $ordenPago['id_solicitud']));
											$solicitudAtendida = $fitosanitario['id_vue'];
										break;
										case 'FitosanitarioExportacion':
											$cfe = new ControladorFitosanitarioExportacion();
											$fitosanotarioExportacion = pg_fetch_assoc($cfe->obtenerCabeceraFitosanitarioExportacion($conexion, $ordenPago['id_solicitud']));
											$solicitudAtendida = $fitosanotarioExportacion['id_vue'];
										break;
										case 'Operadores':									
											$solicitudAtendida = (strlen($ordenPago['id_solicitud'])>36?(substr($ordenPago['id_solicitud'],0,36).'...'):$ordenPago['id_solicitud']);									
										break;									
										case 'Otros':									
											$solicitudAtendida = $ordenPago['numero_solicitud'];
										break;												
									}
									
									$observacion = (strlen($ordenPago['observacion'])>100?(substr($ordenPago['observacion'],0,96).'...'):($ordenPago['observacion']!=''?$ordenPago['observacion']:'Sin observación.'));
									
									$formaPago = $cc->abrirLiquidarOrdenPago($conexion, $solicitudPendiente['id_comprobante']);
									
									$datosDeposito = '';
									
									while ($fila = pg_fetch_assoc($formaPago) ){
										switch ($fila['transaccion']){
											case 'Efectivo':
												$datosDeposito .= 'Efectivo, ';
												break;
											case 'Valor nota credito':
												$numeroNotaCredito = pg_fetch_assoc($cc->abrirNotaCredito($conexion, $fila['id_nota_credito']));
												$datosDeposito .= 'Nota de credito: '.$numeroNotaCredito['numero_establecimiento'].'-'.$numeroNotaCredito['punto_emision'].'-'.$numeroNotaCredito['numero_nota_credito'].', ';
												break;
											case 'Saldo disponible':
												$datosDeposito .= 'Saldo, ';
											break;
											
											default:
												$datosDeposito .= 'Deposito: '.$fila['transaccion'].', ';
											break;
										}
									}
									
									$datosDeposito = rtrim($datosDeposito,', ');
									$datosDeposito = (strlen($datosDeposito)>80?(substr($datosDeposito,0,76).'...'):$datosDeposito);
									
									
									//--------------------------------------DATOS NUEVOS REPORTE FACTURA ---------------------------------------------------
									
									//INICIO EJAR
									$valoresDetalle = $cc -> obtenerDatosDetalleFactura($conexion,$solicitudPendiente['id_comprobante']);
									$detalleValores =  pg_fetch_assoc($valoresDetalle);
									//FIN EJAR
									
									if($solicitudPendiente['numero_establecimiento'] == '013' || $solicitudPendiente['numero_establecimiento'] == '029' ||
											$solicitudPendiente['numero_establecimiento'] == '030' || $solicitudPendiente['numero_establecimiento'] == '035' ||
											$solicitudPendiente['numero_establecimiento'] == '031' || $solicitudPendiente['numero_establecimiento'] == '012' ){
										$aplicarDescuento = 'activo';
									}else{
										$aplicarDescuento = 'inactivo';
									}
									
									
									
									
									//INICIO EJAR
									if($detalleValores['total_con_iva']!= 0 && $aplicarDescuento == 'activo'){
										$compensacion = 'Descuento solidario 2% IVA USD: '. round($detalleValores['total_con_iva']*0.02, 2);
										$ivaSRI = '12%';
									}else {
										$compensacion = '';
										$ivaSRI = '14%';
									}
									
									$parameters['parametrosReporte'] = array(
										'idpago' => (int)$solicitudPendiente['id_comprobante'],
										'datosDeposito' => $datosDeposito,
										'solicitudAtendida' => $solicitudAtendida,
										'observacion' => $observacion,
										'compensacion' => $compensacion,
										'ivaSri' => $ivaSRI
									);
									
									//FIN EJAR
										
									echo IN_MSG . 'Generación de RIDE.';
										
									$jru->generarReporteJasper($ReporteJasper,$parameters,$conexion,$salidaReporte,'defecto');
										
										
									$asunto = 'Facturación electronica AGROCALIDAD';
									$cuerpoMensaje = 'Estimado Cliente: <br/><br/>AGROCALIDAD informa que en base al cumplimiento con la Resolución No.NAC-DGERCGC12-00105 emitida por el SRI, adjunto a este correo se encuentra su FACTURA electrónico(a) en formato XML, así como su interpretación en formato RIDE (SRI).' ;
									
									$destinatario = array();
									//$correos = explode(';', $solicitudPendiente['correo_electronico']);
									
									//foreach ($correos as $correo){
									//	array_push($destinatario, $correo);
									//}
									array_push($destinatario, $solicitudPendiente['correo_electronico']);
									
									
									$adjuntos = array();
									array_push($adjuntos, $rutaArchivoFirmado, $constg::RUTA_SERVIDOR_OPT.'/'.$constg::RUTA_APLICACION.'/'.$salidaReporte);
										
									echo IN_MSG . 'Insertar registro de envío de correo electronico.';
										
									//$estadoMail = $cMail->enviarMail($destinatario, $asunto, $cuerpoMensaje, $adjuntos);										
									//echo IN_MSG . 'Actualización estado correo electronico.';										
									//$cc->cambiarEstadoMailComprobantesElectronicos($conexion, $solicitudPendiente['tipo'], $estadoMail, $solicitudPendiente['id_comprobante']);
									
									$codigoModulo = 'PRG_FINANCIERO';
									$tablaModulo = 'g_financiero.orden_pago';
									
									$qGuardarCorreo=$cMail->guardarCorreo($conexion, $asunto, $cuerpoMensaje, 'Por enviar', $codigoModulo, $tablaModulo, $solicitudPendiente['id_comprobante']);
									$idCorreo=pg_fetch_result($qGuardarCorreo, 0, 'id_correo');
									
									$cMail->guardarDestinatario($conexion, $idCorreo, $destinatario);									
									$cMail->guardarDocumentoAdjunto($conexion, $idCorreo, $adjuntos);
			
								}else if ($estadoAutorizacionXML == 'NO AUTORIZADO'){
										
									echo IN_MSG . 'Comprobante no autorizado.';
										
									$rutaArchivoNoAutorizado = $constg::RUTA_SERVIDOR_OPT."/".$constg::RUTA_APLICACION."/aplicaciones/financiero/archivoXml/rechazadosSRI/".$nombreArchivoXML;
									copy($rutaArchivoFirmado, $rutaArchivoNoAutorizado);
										
									echo IN_MSG . 'Actualización de datos del comprobante.';
										
									$observacionSRI = json_encode($respuestaAutorizacion->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->mensajes);
									$observacionSRI = str_replace("'", "''", $observacionSRI);
									$cc->actualizarObservacionSRIFactura($conexion,$solicitudPendiente['id_comprobante'],$observacionSRI, $rutaArchivoNoAutorizado);
									$cc->cambiarEstadoComprobantesElectronicos($conexion, $solicitudPendiente['tipo'], $estadoAutorizacionXML, $solicitudPendiente['id_comprobante']);
			
								}else{
										
									echo IN_MSG . 'Error al solicitar autorización.';
										
									$observacionSRI = json_encode($respuestaAutorizacion->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->mensajes);
									$observacionSRI = str_replace("'", "''", $observacionSRI);
									$cc->actualizarObservacionSRIFactura($conexion,$solicitudPendiente['id_comprobante'],$observacionSRI, $rutaArchivoNoAutorizado);
								}
									
								break;
									
							case 'notaCredito':
									
								if($estadoAutorizacionXML == 'AUTORIZADO'){
										
									echo IN_MSG . 'Comprobante autorizado.';
			
									$rutaArchivoAutorizado = $constg::RUTA_SERVIDOR_OPT."/".$constg::RUTA_APLICACION."/aplicaciones/financiero/archivoXml/autorizadosSRI/".$nombreArchivoXML;
									//copy($rutaArchivoFirmado, $rutaArchivoAutorizado);
			
									//--------------------------------------RUTAS DE REPORTE FACTURA ---------------------------------------------------
									$ReporteJasper='aplicaciones/financiero/reportes/notaCredito.jrxml';			
									$salidaReporte='aplicaciones/financiero/documentos/notaCredito/'.$nombreArchivoPDF;
									
									///INICIO EJAR
									
									$valoresDetalleNCredito = $cc->obtenerDatosDetalleNotaCredito($conexion,$solicitudPendiente['id_comprobante']);
									$detalleNCValores =  pg_fetch_assoc($valoresDetalleNCredito);
									
									$valoresNotaCredito = $cc -> obtenerDatosNotaCredito($conexion,$solicitudPendiente['id_comprobante']);
									$notaCreditoValores =  pg_fetch_assoc($valoresNotaCredito);
									
									$datosFacturaModificada = pg_fetch_assoc($cc->abrirOrdenPago($conexion, $notaCreditoValores['id_pago']));
									
									if($datosFacturaModificada['numero_establecimiento'] == '013' || $datosFacturaModificada['numero_establecimiento'] == '029' ||
											$datosFacturaModificada['numero_establecimiento'] == '030' || $datosFacturaModificada['numero_establecimiento'] == '035' ||
											$datosFacturaModificada['numero_establecimiento'] == '031' || $datosFacturaModificada['numero_establecimiento'] == '012' ){
										$datosFacturaIva = 'activo';
									}else{
										$datosFacturaIva = 'inactivo';
									}
									
									if($solicitudPendiente['numero_establecimiento'] == '013' || $solicitudPendiente['numero_establecimiento'] == '029' ||
											$solicitudPendiente['numero_establecimiento'] == '030' || $solicitudPendiente['numero_establecimiento'] == '035' ||
											$solicitudPendiente['numero_establecimiento'] == '031' || $solicitudPendiente['numero_establecimiento'] == '012' ){
										$aplicarDescuento = 'activo';
									}else{
										$aplicarDescuento = 'inactivo';
									}
									
									if($detalleNCValores['total_con_iva']!= 0 && $aplicarDescuento == 'activo' && $datosFacturaIva = 'activo'){
										//$compensacion = 'Descuento solidario 2% IVA USD: '. round($detalleValores['total_con_iva']*0.02, 2);
										$ivaSRI = '12%';
									}else {
										$ivaSRI = '14%';
									}
																			
									///FIN EJAR
										
									echo IN_MSG . 'Actualziación de datos de autorización.';
			
									$cc->actualizarDatosAutorizacionSRINotaCredito($conexion,  $solicitudPendiente['id_comprobante'], $estadoAutorizacionXML, $numeroAutorizacion, $fechaAutorizacion, $rutaArchivoAutorizado, $salidaReporte);
										
									$parameters['parametrosReporte'] = array(
										'idnotaCredito' => (int)$solicitudPendiente['id_comprobante'],
										'ivaSri' => $ivaSRI
									);
										
									echo IN_MSG . 'Generación de RIDE.';
										
									$jru->generarReporteJasper($ReporteJasper,$parameters,$conexion,$salidaReporte,'defecto');
			
			
									$asunto = 'Facturación electronica AGROCALIDAD';
									$cuerpoMensaje = 'Estimado Cliente: <br/><br/>AGROCALIDAD informa que en base al cumplimiento con la Resolución No.NAC-DGERCGC12-00105 emitida por el SRI, adjunto a este correo se encuentra su FACTURA electrónico(a) en formato XML, así como su interpretación en formato RIDE (SRI).' ;
									$destinatario = array();
									array_push($destinatario, $solicitudPendiente['correo_electronico']);
									$adjuntos = array();
									array_push($adjuntos, $rutaArchivoFirmado, $constg::RUTA_SERVIDOR_OPT.'/'.$constg::RUTA_APLICACION.'/'.$salidaReporte);
										
									echo IN_MSG . 'Insertar registro de envío de correo electronico.';
										
									//$estadoMail = $cMail->enviarMail($destinatario, $asunto, $cuerpoMensaje, $adjuntos);										
									//echo IN_MSG . 'Actualización estado correo electronico.';										
									//$cc->cambiarEstadoMailComprobantesElectronicos($conexion, $solicitudPendiente['tipo'], $estadoMail, $solicitudPendiente['id_comprobante']);
									
									$codigoModulo = 'PRG_FINANCIERO';
									$tablaModulo = 'g_financiero.nota_credito';
									
									$qGuardarCorreo=$cMail->guardarCorreo($conexion, $asunto, $cuerpoMensaje, 'Por enviar', $codigoModulo, $tablaModulo, $solicitudPendiente['id_comprobante']);
									$idCorreo=pg_fetch_result($qGuardarCorreo, 0, 'id_correo');
									
									$cMail->guardarDestinatario($conexion, $idCorreo, $destinatario);									
									$cMail->guardarDocumentoAdjunto($conexion, $idCorreo, $adjuntos);
			
								}else if ($estadoAutorizacionXML == 'NO AUTORIZADO'){
										
									echo IN_MSG . 'Comprobante no autorizado.';
			
									$rutaArchivoNoAutorizado = $constg::RUTA_SERVIDOR_OPT."/".$constg::RUTA_APLICACION."/aplicaciones/financiero/archivoXml/rechazadosSRI/".$nombreArchivoXML;
									copy($rutaArchivoFirmado, $rutaArchivoNoAutorizado);
										
									echo IN_MSG . 'Actualización de datos del comprobante.';
			
									$observacionSRI = json_encode($respuestaAutorizacion->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->mensajes);
									$observacionSRI = str_replace("'", "''", $observacionSRI);
									$cc->actualizarObservacionSRIFactura($conexion,$solicitudPendiente['id_comprobante'],$observacionSRI, $rutaArchivoNoAutorizado);
									$cc->cambiarEstadoComprobantesElectronicos($conexion, $solicitudPendiente['tipo'], $estadoAutorizacionXML, $solicitudPendiente['id_comprobante']);
			
								}else{
										
									echo IN_MSG . 'Error al solicitar autorización.';
										
									$observacionSRI = json_encode($respuestaAutorizacion->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->mensajes);
									$observacionSRI = str_replace("'", "''", $observacionSRI);
									$cc->actualizarObservacionSRIFactura($conexion,$solicitudPendiente['id_comprobante'],$observacionSRI, $rutaArchivoNoAutorizado);
								}
									
								break;
									
							default:
								echo 'Tipo formulario desconocido.';
						}
							
						echo IN_MSG . 'Fin de solicitud de autorización al SRI';
							
						break;
							
					default:
						echo 'Estado desconocido.';
							
				}
				echo '<br/><strong>FIN</strong></p>';
					
			}
		}
	}else{
		
		$minutoS1=microtime(true);
		$minutoS2=microtime(true);
		$tiempo=$minutoS2-minutoS1;
		$xcadenota = "FECHA ".date("d/m/Y")." ".date("H:i:s");
		$xcadenota.= "; IP REMOTA ".$_SERVER['REMOTE_ADDR'];
		$xcadenota.= "; SERVIDOR HTTP ".$_SERVER['HTTP_REFERER'];
		$xcadenota.= "; SEGUNDOS ".$tiempo."\n";
		$arch = fopen("../../aplicaciones/logs/cron/factoracion_electronica_".date("d-m-Y").".txt", "a+");
		fwrite($arch, $xcadenota);
		fclose($arch);		

	}
		
?>



</body>

</html>
