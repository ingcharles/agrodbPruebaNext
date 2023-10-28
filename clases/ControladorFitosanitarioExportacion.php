<?php

class ControladorFitosanitarioExportacion{	
	
	public function listarFitosanitarioExportacionPorProvincia($conexion, $provincia, $estado){
		
		$res = $conexion->ejecutarConsulta("SELECT
												id_fitosanitario_exportacion as id_solicitud,							
												id_vue,
												numero_identificacion_solicitante as identificador_operador,
												nombre_pais_destino as pais												
											FROM
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											WHERE
												estado = '$estado' and
												UPPER(nombre_provincia_revision) = UPPER('$provincia');");
		return $res;
	}
	
	public function listarFitosanitarioExportacionPorPorInspectorAsignado($conexion, $estadoSolicitud, $identificadorInspector, $tipoSolicitud, $tipoInspector){
			
		$res = $conexion->ejecutarConsulta("SELECT
												id_fitosanitario_exportacion as id_solicitud,							
												id_vue,
												numero_identificacion_solicitante as identificador_operador,
												nombre_pais_destino as pais
											FROM
												g_fitosanitario_exportacion.fitosanitario_exportaciones fe,
												g_revision_solicitudes.asignacion_coordinador ac
											WHERE
												fe.id_fitosanitario_exportacion = ac.id_solicitud and
												ac.identificador_inspector = '$identificadorInspector' and
												ac.tipo_solicitud = '$tipoSolicitud' and
												ac.tipo_inspector = '$tipoInspector' and
												fe.estado in ('$estadoSolicitud');");
		return $res;
	}
	
	public function obtenerCabeceraFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
		
		$res = $conexion->ejecutarConsulta("SELECT
												*												
											FROM
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
		
		return $res;
		
	}
	
	public function obtenerArchivosAdjuntosFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
		
		$cid = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.documentos_adjuntos
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		while ($fila = pg_fetch_assoc($cid)){
			$res[] = array(
					idImportacion=>$fila['id_importacion'],
					tipoArchivo=>$fila['tipo_archivo'],
					rutaArchivo=>$fila['ruta_archivo'],
					area=>$fila['area'],
					idVue=>$fila['id_vue']);
		}
	
		return $res;
	}
	
	public function obtenerExportadoresFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
		
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.fitosanitario_exportadores
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		return $res;
	
	}
	
	public function obtenerProductosFitosanitarioExportacion($conexion, $idFitosanitarioExportacion, $idFitosanitarioExportador){
					
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.fitosanitario_productos
											WHERE
												id_fitosanitario_exportador = $idFitosanitarioExportador and
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		return $res;
	
	}
	
	public function obtenerAreasFitosanitarioExportacion($conexion, $idFitosanitarioExportacion, $idFitosanitarioExportador, $idFitosanitarioProducto){
					
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.fitosanitario_areas
											WHERE
												id_fitosanitario_exportador = $idFitosanitarioExportador and
												id_fitosanitario_exportacion = $idFitosanitarioExportacion and
												id_fitosanitario_producto = $idFitosanitarioProducto;");
	
		return $res;
	
	}
	
	public function obtenerTransitoFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
	
		$cidFito = $conexion->ejecutarConsulta("SELECT
														*
												FROM
													g_fitosanitario_exportacion.fitosanitario_transportes
												WHERE
													id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		while ($fila = pg_fetch_assoc($cidFito)){
			$res[] = array(
					idPais=>$fila['id_pais'],
					nombrePais=>$fila['nombre_pais'],
					idPuerto=>$fila['id_puerto'],
					nombrePuerto=>$fila['nombre_puerto'],
					tipoTransporte=>$fila['descripcion_tipo_transporte']);
		}
	
		return $res;
	}
	
	public function actualizarEstadoFitosanitarioExportacion ($conexion, $idFitosanitarioExportacion, $estado, $estadoAnterior, $observacion){
		
		$res = $conexion->ejecutarConsulta("UPDATE
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											SET
												estado = '$estado',
												estado_anterior = '$estadoAnterior',
												observacion = '$observacion'
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
		return $res;
	}
	
	public function actualizarArchivoInspeccionFitosanitarioExportacion ($conexion, $idFitosanitarioExportacion, $archivoInspeccion, $nombreAprobador, $cargoAprobador, $observacionAprobador){
	
		$res = $conexion->ejecutarConsulta("UPDATE
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											SET
												archivo_inspeccion = '$archivoInspeccion',
												nombre_aprobador = '$nombreAprobador',
												cargo_aprobador = '$cargoAprobador',
												observacion_aprobador = '$observacionAprobador'
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
		return $res;
	}
	
	public function actualizarProvinciaRevisionFitosanitarioExportacion ($conexion, $idFitosanitarioExportacion, $nombreProvincia, $idProvincia){
	
		$res = $conexion->ejecutarConsulta("UPDATE
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											SET
												id_provincia_revision = $idProvincia,
												nombre_provincia_revision = '$nombreProvincia'
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
		return $res;
	}
	
	public function obtenerProgramaProductosPorIdentificadorFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
			
		$res = $conexion->ejecutarConsulta("SELECT
												p.id_producto,
												p.nombre_comun,
												p.partida_arancelaria,
												p.programa,
												fp.cantidad_cobro,
												fp.unidad_cobro,
												fp.exoneracion
											FROM
												g_fitosanitario_exportacion.fitosanitario_productos fp,
												g_catalogos.productos p
											WHERE
												fp.id_producto = p.id_producto and
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		return $res;
	
	}
	
	public function listarFitosanitarioExportacionfinancieroVerificacion($conexion, $estado, $provincia, $tipoSolicitud){
	
		$res = $conexion->ejecutarConsulta("SELECT
												id_fitosanitario_exportacion as id_solicitud,
												id_vue,
												numero_identificacion_solicitante as identificador_operador,
												nombre_pais_destino as pais
											FROM
												g_fitosanitario_exportacion.fitosanitario_exportaciones fe,
												g_revision_solicitudes.asignacion_inspector ai,
												g_revision_solicitudes.grupos_solicitudes gs,
												g_financiero.orden_pago orp
											WHERE
												fe.id_fitosanitario_exportacion = gs.id_solicitud and
												ai.id_grupo = gs.id_grupo and
												ai.tipo_solicitud = '$tipoSolicitud' and
												ai.tipo_inspector = 'Financiero' and
												gs.estado != 'Verificación' and
												orp.id_grupo_solicitud = ai.id_grupo and
												orp.estado = 3 and
												orp.tipo_solicitud = '$tipoSolicitud' and
												fe.estado = '$estado' and
												UPPER(fe.nombre_provincia_revision) = UPPER('$provincia');");
		return $res;
	}
	
	
	public function buscarFitosanitarioExportacionVUE ($conexion, $idVue){
	
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											WHERE
												id_vue = '$idVue';");
		return $res;
	}
	
	
	public function guardarFitosanitarioExportacion($conexion, $idVue=null, $numeroDocumento,
			$nombreDocumento, $codigoFuncionDocumento, $idCiudadSolictud, $codigoCiudadSolicitud, $nombreCiudadSolicitud,
			$codigoTipoCfe, $nombreTipoCfe, $codigoIdioma, $codigoClasificacionSolicitante,
			$numeroIdentificacionSolicitante, $razonSocialSolicitante, $nombreRepresentanteLegalSolicitante, $direccionSolicitante, $telefonoSolicitante,
			$correoSolicitante, $nombreImportador, $direccionImportador, $productoOrganico, $certificadoOrganico, $numeroBultos, $unidadBultos,
			$idPaisOrigen, $nombrePaisOrigen, $idProvinciaOrigenProducto, $nombreProvinciaOrigenProducto, $identificacionAgenciaCarga, $nombreAgenciaCarga,
			$idPaisDestino, $nombrePaisDestino, $idPuertoDestino, $nombrePuertoDestino, $fechaEmbarque, $idPaisEmbarque, $nombrePaisEmbarque,
			$idPuertoEmbarque, $nombrePuertoEmbarque, $codigoMedioTransporte, $nombreMedioTransporte, $nombreMarca, $numeroViaje, $informacionAdicional,
			$descuento, $motivoDescuento, $nombreAprobador, $cargoAprobador, $observacionAprobador, $usoCiudadTransito, $lugarInspeccion){
									
		$res = $conexion->ejecutarConsulta("INSERT INTO g_fitosanitario_exportacion.fitosanitario_exportaciones(id_vue, numero_documento,
												nombre_documento, codigo_funcion_documento, id_ciudad_solicitante, codigo_ciudad_solicitud, nombre_ciudad_solicitud,
												codigo_tipo_cfe, nombre_tipo_cfe, codigo_idioma, codigo_clasificacion_solicitante,
												numero_identificacion_solicitante, razon_social_solicitante, nombre_representante_legal_solicitante, direccion_solicitante, telefono_solicitante,
												correo_electronico_solicitante, nombre_importador, direccion_importador, producto_organico, certificado_organico, numero_bultos, unidad_bultos,
												id_pais_origen, nombre_pais_origen, id_provincia_origen_producto, nombre_provincia_origen_producto, identificacion_agencia_carga, nombre_agencia_carga,
												id_pais_destino, nombre_pais_destino, id_puerto_destino, nombre_puerto_destino, fecha_embarque, id_pais_embarque, nombre_pais_embarque,
												id_puerto_embarque, nombre_puerto_embarque, codigo_medio_transporte, nombre_medio_transporte, nombre_marca, numero_viaje, informacion_adicional,
												descuento, motivo_descuento, nombre_aprobador, cargo_aprobador, observacion_aprobador, uso_ciudad_transito, lugar_inspeccion)
											VALUES ('$idVue','$numeroDocumento',
												'$nombreDocumento','$codigoFuncionDocumento',$idCiudadSolictud,'$codigoCiudadSolicitud','$nombreCiudadSolicitud',
												'$codigoTipoCfe','$nombreTipoCfe','$codigoIdioma', '$codigoClasificacionSolicitante',
												'$numeroIdentificacionSolicitante', '$razonSocialSolicitante', '$nombreRepresentanteLegalSolicitante', '$direccionSolicitante', '$telefonoSolicitante',
												'$correoSolicitante','$nombreImportador','$direccionImportador','$productoOrganico','$certificadoOrganico', $numeroBultos, '$unidadBultos',
												$idPaisOrigen, '$nombrePaisOrigen', $idProvinciaOrigenProducto, '$nombreProvinciaOrigenProducto', '$identificacionAgenciaCarga', '$nombreAgenciaCarga',
												$idPaisDestino, '$nombrePaisDestino', $idPuertoDestino, '$nombrePuertoDestino', '$fechaEmbarque', $idPaisEmbarque, '$nombrePaisEmbarque',
												$idPuertoEmbarque, '$nombrePuertoEmbarque', '$codigoMedioTransporte', '$nombreMedioTransporte', '$nombreMarca', '$numeroViaje', '$informacionAdicional',
												'$descuento', '$motivoDescuento', '$nombreAprobador', '$cargoAprobador', '$observacionAprobador', '$usoCiudadTransito', '$lugarInspeccion') RETURNING id_fitosanitario_exportacion;");
			
		return $res;
	}
	
	public function actualizarFitosanitarioExportacion($conexion, $idFitosanitarioExportacion, $idVue, $numeroDocumento,
			$nombreDocumento, $codigoFuncionDocumento, $idCiudadSolictud, $codigoCiudadSolicitud, $nombreCiudadSolicitud,
			$codigoTipoCfe, $nombreTipoCfe, $codigoIdioma,  $codigoClasificacionSolicitante,
			$numeroIdentificacionSolicitante, $razonSocialSolicitante, $nombreRepresentanteLegalSolicitante, $direccionSolicitante, $telefonoSolicitante,
			$correoSolicitante, $nombreImportador, $direccionImportador, $productoOrganico, $certificadoOrganico, $numeroBultos, $unidadBultos,
			$idPaisOrigen, $nombrePaisOrigen, $idProvinciaOrigenProducto, $nombreProvinciaOrigenProducto, $identificacionAgenciaCarga, $nombreAgenciaCarga,
			$idPaisDestino, $nombrePaisDestino, $idPuertoDestino, $nombrePuertoDestino, $fechaEmbarque, $idPaisEmbarque, $nombrePaisEmbarque,
			$idPuertoEmbarque, $nombrePuertoEmbarque, $codigoMedioTransporte, $nombreMedioTransporte, $nombreMarca, $numeroViaje, $informacionAdicional,
			$descuento, $motivoDescuento, $nombreAprobador, $cargoAprobador, $observacionAprobador, $usoCiudadTransito, $lugarInspeccion){
	
		$res = $conexion->ejecutarConsulta("UPDATE 
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											SET
												numero_documento='$numeroDocumento', nombre_documento='$nombreDocumento', codigo_funcion_documento='$codigoFuncionDocumento', 
												id_ciudad_solicitante=$idCiudadSolictud, codigo_ciudad_solicitud='$codigoCiudadSolicitud', nombre_ciudad_solicitud='$nombreCiudadSolicitud',
												codigo_tipo_cfe='$codigoTipoCfe', nombre_tipo_cfe='$nombreTipoCfe', codigo_idioma='$codigoIdioma', codigo_clasificacion_solicitante='$codigoClasificacionSolicitante',
												numero_identificacion_solicitante='$numeroIdentificacionSolicitante', razon_social_solicitante='$razonSocialSolicitante',
												nombre_representante_legal_solicitante='$nombreRepresentanteLegalSolicitante', direccion_solicitante='$direccionSolicitante', telefono_solicitante='$telefonoSolicitante',
												correo_electronico_solicitante='$correoSolicitante', nombre_importador='$nombreImportador', direccion_importador='$direccionImportador', producto_organico='$productoOrganico', 
												certificado_organico='$certificadoOrganico', numero_bultos=$numeroBultos, unidad_bultos='$unidadBultos',
												id_pais_origen=$idPaisOrigen, nombre_pais_origen='$nombrePaisOrigen', id_provincia_origen_producto=$idProvinciaOrigenProducto, 
												nombre_provincia_origen_producto='$nombreProvinciaOrigenProducto', identificacion_agencia_carga='$identificacionAgenciaCarga', nombre_agencia_carga='$nombreAgenciaCarga',
												id_pais_destino=$idPaisDestino, nombre_pais_destino='$nombrePaisDestino', id_puerto_destino=$idPuertoDestino, nombre_puerto_destino='$nombrePuertoDestino', 
												fecha_embarque='$fechaEmbarque', id_pais_embarque=$idPaisEmbarque, nombre_pais_embarque='$nombrePaisEmbarque',
												id_puerto_embarque=$idPuertoEmbarque, nombre_puerto_embarque='$nombrePuertoEmbarque', codigo_medio_transporte='$codigoMedioTransporte', 
												nombre_medio_transporte='$nombreMedioTransporte', nombre_marca='$nombreMarca', numero_viaje='$numeroViaje', informacion_adicional='$informacionAdicional',
												descuento='$descuento', motivo_descuento='$motivoDescuento', nombre_aprobador='$nombreAprobador', cargo_aprobador='$cargoAprobador', observacion_aprobador='$observacionAprobador', 
												uso_ciudad_transito='$usoCiudadTransito', lugar_inspeccion = '$lugarInspeccion'
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		return $res;
	}
	
	public function eliminarExportadoresFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
	
		$res = $conexion->ejecutarConsulta("DELETE FROM
												g_fitosanitario_exportacion.fitosanitario_exportadores
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
			
		return $res;
	}
	
	
	public function eliminarProductosFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
	
		$res = $conexion->ejecutarConsulta("DELETE FROM
												g_fitosanitario_exportacion.fitosanitario_productos
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
		return $res;
	}
	
	
	
	public function eliminarAreasFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
	
		$res = $conexion->ejecutarConsulta("DELETE FROM
												g_fitosanitario_exportacion.fitosanitario_areas
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		return $res;
	}
	
	
	public function eliminaTransitoFitosanitarioExportacion($conexion, $idFitosanitarioExportacion){
		$res = $conexion->ejecutarConsulta("DELETE FROM
												g_fitosanitario_exportacion.fitosanitario_transportes
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		return $res;
	}
	
	public function eliminarArchivosAdjuntosFitosanitarioExportacion($conexion, $idFitosanitarioExportacion, $idVue){
		$res = $conexion->ejecutarConsulta("DELETE FROM
												g_fitosanitario_exportacion.documentos_adjuntos
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion
												and id_vue = '$idVue';");
	
		return $res;
	}
	
	
	public function guardarFitosanitarioExportacionExportadores($conexion, $id_fitosanitario_exportacion, $idVue, $codigoClasificacionIdentificacionExportador, $codigoTipoNumeroIdentificacionExportador,
			$numeroIdentificacionExportador, $nombreExportador, $direccionExportador) {
	
		$res = $conexion->ejecutarConsulta("INSERT INTO g_fitosanitario_exportacion.fitosanitario_exportadores(
														id_fitosanitario_exportacion, id_vue, codigo_clasificacion_identificacion_exportador, codigo_tipo_numero_identificacion_exportador,
														numero_identificacion_exportador, nombre_exportador, direccion_exportador)
													VALUES (
														'$id_fitosanitario_exportacion', '$idVue', '$codigoClasificacionIdentificacionExportador', '$codigoTipoNumeroIdentificacionExportador',
														'$numeroIdentificacionExportador', '$nombreExportador', '$direccionExportador')RETURNING id_fitosanitario_exportador;");
	
		return $res;
	}
	
	
	public function guardarFitosanitarioExportacionProductos($conexion, $idFitosanitarioExportador, $idFitosanitarioExportacion, $idVue, $subpartidaArancelaria, $codigoProducto, $idProducto, $nombreProducto,
			$cantidadCobro, $unidadCobro, $cantidadPesoNeto, $unidadPesoNeto, $cantidadPesoBruto, $unidadPesoBruto, $cantidadComercial, $unidadCantidadComercial,
			$codigoTipoTratamiento, $descripcionTipoTratamiento, $codigoNombreTratamiento, $descripcionNombreTratamiento, $duracionTratamiento, $unidadTratamiento,
			$temperaturaTratamiento, $unidadTemperaturaTratamiento, $concentracionProductoQuimico, $fechaTratamiento, $productoQuimico, $informacionAdicional,
			$requisitoFitosanitario, $exoneracion) {
	
		$res = $conexion->ejecutarConsulta("INSERT INTO g_fitosanitario_exportacion.fitosanitario_productos(
												id_fitosanitario_exportador, id_fitosanitario_exportacion, id_vue, subpartida_arancelaria, codigo_producto, id_producto, nombre_producto,
												cantidad_cobro, unidad_cobro, cantidad_peso_neto, unidad_peso_neto, cantidad_peso_bruto, unidad_peso_bruto, cantidad_comercial, unidad_cantidad_comercial,
												codigo_tipo_tratamiento, descripcion_tipo_tratamiento, codigo_nombre_tratamiento, descripcion_nombre_tratamiento, duracion_tratamiento, unidad_tratamiento,
												temperatura_tratamiento, unidad_temperatura_tratamiento, concentracion_producto_quimico, fecha_tratamiento, producto_quimico, informacion_adicional,
												requisito_fitosanitario, exoneracion)
											VALUES (
												$idFitosanitarioExportador, $idFitosanitarioExportacion, '$idVue', '$subpartidaArancelaria', '$codigoProducto', $idProducto, '$nombreProducto',
												$cantidadCobro, '$unidadCobro', $cantidadPesoNeto, '$unidadPesoNeto', $cantidadPesoBruto, '$unidadPesoBruto', $cantidadComercial, '$unidadCantidadComercial',
												'$codigoTipoTratamiento', '$descripcionTipoTratamiento', '$codigoNombreTratamiento', '$descripcionNombreTratamiento', '$duracionTratamiento', '$unidadTratamiento',
												'$temperaturaTratamiento', '$unidadTemperaturaTratamiento', '$concentracionProductoQuimico', $fechaTratamiento, '$productoQuimico', '$informacionAdicional',
											    '$requisitoFitosanitario', '$exoneracion')RETURNING id_fitosanitario_producto;");
	
		return $res;
	}
		
		
	public function guardarFitosanitarioAreasExportadores($conexion, $idFitosanitarioExportador, $idFitosanitarioExportacion, $idFitosanitarioProducto, $idVue, $idArea, $codigoAreaAgrocalidad, $numeroAucp ) {
	
		$res = $conexion->ejecutarConsulta("INSERT INTO g_fitosanitario_exportacion.fitosanitario_areas(id_fitosanitario_exportador, id_fitosanitario_exportacion, 
														id_fitosanitario_producto, id_vue, id_area, codigo_area_agrocalidad_unibanano, numero_aucp)
												VALUES ($idFitosanitarioExportador, $idFitosanitarioExportacion, $idFitosanitarioProducto, '$idVue', $idArea, 
														'$codigoAreaAgrocalidad', '$numeroAucp');");
	
		return $res;
	}
	
	
	public function guardarFitosanitarioAreasTrasportes($conexion, $idFitosanitarioExportacion, $idVue, $codigoTipoTransporte, $descripcionTipoTransporte, $idPais, $nombrePais, $idPuerto, $nombrePuerto, $requisitoFitosanitarioTransito) {
	
		$res = $conexion->ejecutarConsulta("INSERT INTO g_fitosanitario_exportacion.fitosanitario_transportes(id_fitosanitario_exportacion, id_vue, codigo_tipo_transporte, 
														descripcion_tipo_transporte, id_pais, nombre_pais, id_puerto, nombre_puerto, requisito_fitosanitario_transito)
											VALUES ($idFitosanitarioExportacion, '$idVue', '$codigoTipoTransporte', '$descripcionTipoTransporte', $idPais, '$nombrePais', 
													$idPuerto, '$nombrePuerto', '$requisitoFitosanitarioTransito');");
			
		return $res;
	}
	
	public function buscarFitosanitarioExportacionExportador($conexion, $idFitosanitarioExportacion, $idExportador){
	
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.fitosanitario_exportadores
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion and
												numero_identificacion_exportador = '$idExportador';");
		return $res;
	}
	
	public function buscarFitosanitarioExportacionTransporte ($conexion, $idFitosanitarioExportacion, $idPais, $idPuerto, $codigoTransporte){
	
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.fitosanitario_transportes
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion and
												id_pais = $idPais and
												id_puerto = $idPuerto and
												codigo_tipo_transporte = '$codigoTransporte';");
		return $res;
	}
	
	public function buscarFitosanitarioExportacionProducto($conexion, $idFitosanitarioExportador, $idFitosanitarioExportacion, $idProducto){
			
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.fitosanitario_productos
											WHERE
												id_fitosanitario_exportador = $idFitosanitarioExportador and
												id_fitosanitario_exportacion = $idFitosanitarioExportacion and
												id_producto = $idProducto;");
		return $res;
	}
	
	public function buscarFitosanitarioExportacionArea($conexion, $idFitosanitarioExportador, $idFitosanitarioExportacion, $idFitosanitarioProducto, $idArea){
					
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.fitosanitario_areas
											WHERE
												id_fitosanitario_exportador = $idFitosanitarioExportador and
												id_fitosanitario_exportacion = $idFitosanitarioExportacion and
												id_fitosanitario_producto = $idFitosanitarioProducto and
												id_area = $idArea;");
		return $res;
	}
	
	public function modificarCabeceraFitosanitarioExportacion($conexion, $idFitosanitarioExportacion, $nombreImportador, $direccionImportador, $idPuertoDestino, $puertoDestino, $informacionAdicional){
	
		$res = $conexion->ejecutarConsulta("UPDATE
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											SET
												nombre_importador='$nombreImportador', 
												direccion_importador='$direccionImportador',
												id_puerto_destino=$idPuertoDestino, 
												nombre_puerto_destino='$puertoDestino', 
												informacion_adicional='$informacionAdicional'
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
	
		return $res;
	}
	
	public function modificarProductoFitosanitarioExportacion($conexion, $idFitosanitarioExportacion, $idProducto, $identificadorExportador, $informacionAdicional){
			
		$res = $conexion->ejecutarConsulta("UPDATE
												g_fitosanitario_exportacion.fitosanitario_productos
											SET
												informacion_adicional='$informacionAdicional'
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion and
												id_fitosanitario_exportador = $identificadorExportador and
												id_producto = $idProducto;");
									
		return $res;
	}
	
	public function guardarFitosanitarioExportacionDocumentosAdjuntos($conexion, $idFitosanitarioExportacion, $tipoArchivo, $rutaArchivo, $area,$idVue = null){
	
		$documento = $this->abrirFitosanitarioExportacionArchivoIndividual($conexion, $idFitosanitarioExportacion, $tipoArchivo);
	
		if(pg_num_rows($documento)== 0){
	
			$res = $conexion->ejecutarConsulta("INSERT INTO g_fitosanitario_exportacion.documentos_adjuntos(
													id_fitosanitario_exportacion, tipo_archivo, ruta_archivo, area, id_vue)
												VALUES ('$idFitosanitarioExportacion', '$tipoArchivo', '$rutaArchivo', '$area', '$idVue');");
	
			return $res;
		}
	}
	
	public function abrirFitosanitarioExportacionArchivoIndividual($conexion, $idFitosanitarioExportacion, $tipoArchivo){
	
		$res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_fitosanitario_exportacion.documentos_adjuntos
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion
												and tipo_archivo = '$tipoArchivo';");
	
		return $res;
	}
	

	public function guardarSolicitanteFitosanitarioExportacion($conexion, $identificacionSolicitante, $tipoIdentificacion, $razonSocial, $direccionSolicitante, $telefonoSolicitante, $correoElectronicoSolicitante){
	
		$res = $conexion->ejecutarConsulta("INSERT INTO g_financiero.clientes (identificador,  tipo_identificacion,  razon_social,  direccion,  telefono,  correo)
												SELECT '$identificacionSolicitante', '$tipoIdentificacion', '$razonSocial', '$direccionSolicitante', '$telefonoSolicitante', '$correoElectronicoSolicitante'  WHERE NOT EXISTS (SELECT identificador FROM g_financiero.clientes
											WHERE identificador = '$identificacionSolicitante')");
			
		return $res;
	}
	
	public function actualizarFechasAprobacionFitosanitarioExportacion ($conexion, $idFitosanitarioExportacion){
	
		$res = $conexion->ejecutarConsulta("UPDATE
												g_fitosanitario_exportacion.fitosanitario_exportaciones
											SET
												fecha_inicio_vigencia_certificado = now(),
												fecha_fin_vigencia_certificado = now() + '10 year'
											WHERE
												id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
		return $res;
	}
	

	///////////////////////////////
	
	public function guardarNotificacionesCFE($conexion, $numeroNotificacion, $fechaNotificacion, $motivoNotificacion, $observacionNotificacion, $numeroCFE, $identificadorExportador, $razonSocial, $pais, $estadoCFE, $idTipoProducto, $idSubtipoProducto, $idProducto, $nombreProducto, $idPaisDestino) {
	
		$res = $conexion->ejecutarConsulta("INSERT INTO g_notificaciones_sanciones.notificaciones(numero_notificacion, fecha_notificacion, motivo_notificacion, observacion_notificacion, numero_cfe,
													identificador_exportador, razon_social, pais, estado, id_tipo_producto, id_subtipo_producto, id_producto, nombre_producto, id_pais)
											VALUES (
											'$numeroNotificacion', '$fechaNotificacion', '$motivoNotificacion', '$observacionNotificacion',
											'$numeroCFE', '$identificadorExportador', '$razonSocial', '$pais', '$estadoCFE', $idTipoProducto, $idSubtipoProducto, $idProducto, '$nombreProducto', $idPaisDestino);");
	
		return $res;
	}
	
	public function guardarSancionesCFE($conexion, $identificadorExportador, $razonSocial, $idTipoProducto, $idSubtipoProducto, $idProducto, $nombreProducto, $idPais, $fechaInicioSancion, $fechaFinSancion, $motivoSancion, $estadoSancion, $observacionSancion, $nombrePais) {
	
				$res = $conexion->ejecutarConsulta("INSERT INTO g_notificaciones_sanciones.sanciones(identificador_exportador,  razon_social,  id_tipo_producto,  id_subtipo_producto, id_producto, nombre_producto, id_pais,
														fecha_inicio_sancion, fecha_fin_sancion, motivo_sancion, estado_sancion, observacion_sancion, nombre_pais)
													VALUES (
														'$identificadorExportador', '$razonSocial', $idTipoProducto, $idSubtipoProducto, $idProducto, '$nombreProducto', $idPais, '$fechaInicioSancion', '$fechaFinSancion', '$motivoSancion', '$estadoSancion', '$observacionSancion', '$nombrePais');");
		return $res;
	}
	
	public function obtenerNotificacionesXExportador($conexion, $identificadorExportador){
	
	$res = $conexion->ejecutarConsulta("SELECT
											*
										FROM
											g_notificaciones_sanciones.notificaciones
										WHERE
											identificador_exportador = '$identificadorExportador';");
	
			return $res;
	}
	
	public function obtenerSancionesXExportador($conexion, $identificadorExportador){
	
			$res = $conexion->ejecutarConsulta("SELECT
													*
												FROM
													g_notificaciones_sanciones.sanciones
												WHERE
													identificador_exportador = '$identificadorExportador';");
	
			return $res;
	}
	
	
	public function obtenerPaisesSancionesXExportador($conexion, $identificadorExportador){
	
			$res = $conexion->ejecutarConsulta("SELECT
													distinct (fe.id_pais_destino), fe.nombre_pais_destino
												FROM
													g_fitosanitario_exportacion.fitosanitario_exportaciones fe,
													g_fitosanitario_exportacion.fitosanitario_exportadores fex,
													g_fitosanitario_exportacion.fitosanitario_productos p,
													g_notificaciones_sanciones.notificaciones n
												WHERE
													fe.id_fitosanitario_exportacion = fex.id_fitosanitario_exportacion and
													fex.numero_identificacion_exportador='$identificadorExportador' and
													fex.numero_identificacion_exportador = n.identificador_exportador and
													n.id_producto = p.id_producto;");
	
		return $res;
	}
	

	public function obtenerTipoProductoXExportador($conexion, $idFitosanitarioExportacion, $idFitosanitarioExportador){
	
				$res = $conexion->ejecutarConsulta("SELECT 
														*
													FROM
														g_catalogos.subtipo_productos dp,
														g_catalogos.tipo_productos tp,
														g_catalogos.productos p,
														g_fitosanitario_exportacion.fitosanitario_productos fp
													WHERE
														dp.id_tipo_producto = tp.id_tipo_producto and
														dp.id_subtipo_producto = p.id_subtipo_producto and
														fp.id_fitosanitario_exportador = $idFitosanitarioExportador and
														fp.id_fitosanitario_exportacion = $idFitosanitarioExportacion and
														p.id_producto = fp.id_producto;");
		return $res;
	}
	
			
	public function obtenerSubtipoProductoXExportadorXTipo($conexion, $idFitosanitarioExportacion, $idFitosanitarioExportador, $idTipoProducto){
						
					$res = $conexion->ejecutarConsulta("SELECT
															dp.id_subtipo_producto, dp.nombre
														FROM
															g_catalogos.subtipo_productos dp,
															g_catalogos.tipo_productos tp,
															g_catalogos.productos p,
															g_fitosanitario_exportacion.fitosanitario_productos fp
														WHERE
															dp.id_tipo_producto = tp.id_tipo_producto and
															dp.id_subtipo_producto = p.id_subtipo_producto and
															fp.id_fitosanitario_exportador = $idFitosanitarioExportador and
															fp.id_fitosanitario_exportacion = $idFitosanitarioExportacion and
															tp.id_tipo_producto = $idTipoProducto and
															p.id_producto = fp.id_producto;");
		return $res;
	}
	
	public function obtenerProductoXExportadorXSubtipo($conexion, $idFitosanitarioExportacion, $idFitosanitarioExportador, $idSubtipoProducto){
								
				$res = $conexion->ejecutarConsulta("SELECT
														*
													FROM
														g_catalogos.productos p,
														g_catalogos.subtipo_productos stp,
														g_fitosanitario_exportacion.fitosanitario_productos fp
													WHERE
														p.id_subtipo_producto = stp.id_subtipo_producto	and
														p.id_subtipo_producto = $idSubtipoProducto and
														fp.id_fitosanitario_exportador = $idFitosanitarioExportador and
														fp.id_fitosanitario_exportacion = $idFitosanitarioExportacion and
														p.id_producto = fp.id_producto;");
		return $res;
	}
	
	
	public function obtenerTipoProductoXExportadorSancion($conexion, $identificadorExportador){
	
				$res = $conexion->ejecutarConsulta("SELECT
														distinct(tp.id_tipo_producto),
														tp.nombre
													FROM
														g_catalogos.subtipo_productos dp,
														g_catalogos.tipo_productos tp,
														g_catalogos.productos p,
														g_notificaciones_sanciones.notificaciones nt
													WHERE
														dp.id_tipo_producto = tp.id_tipo_producto and
														dp.id_subtipo_producto = p.id_subtipo_producto and
														p.id_producto = nt.id_producto and
														nt.identificador_exportador = '$identificadorExportador';");
		return $res;
	}
	
	public function obtenerSubtipoProductoXExportadorXTipoSancion($conexion, $idTipoProducto){
										
				$res = $conexion->ejecutarConsulta("SELECT
														distinct (dp.id_subtipo_producto), dp.nombre
													FROM
														g_catalogos.subtipo_productos dp,
														g_catalogos.tipo_productos tp,
														g_catalogos.productos p,
														g_notificaciones_sanciones.notificaciones nt
													WHERE
														dp.id_tipo_producto = tp.id_tipo_producto and
														dp.id_subtipo_producto = p.id_subtipo_producto and
														p.id_producto = nt.id_producto and
														tp.id_tipo_producto = $idTipoProducto;");
		return $res;
	}
	
	public function obtenerProductoXExportadorXSubtipoSancion($conexion, $idSubtipoProducto){
										
				$res = $conexion->ejecutarConsulta("SELECT
														distinct (p.id_producto), p.nombre_comun
													FROM
														g_catalogos.productos p,
														g_catalogos.subtipo_productos stp,
														g_notificaciones_sanciones.notificaciones nt
													WHERE
														p.id_subtipo_producto = stp.id_subtipo_producto	and
														p.id_subtipo_producto = $idSubtipoProducto and
														p.id_producto = nt.id_producto;");
				return $res;
		}
	
	
			///ESTA ESTA EN VEREMOS--PREGUNTAR SI SE VALIDA VARIAS NOTIFICACIONES A UN MISMO EXPORTADOR EN UN MISMO CFE
		public function buscarNotificacionesXSolicitudXExportador($conexion, $numeroCFE, $identificadorExportador){
				
			$res = $conexion->ejecutarConsulta("SELECT
													*
												FROM
													g_notificaciones_sanciones.notificaciones
												WHERE
													numero_cfe = '$numeroCFE'	and
													identificador_exportador = '$identificadorExportador';");
				return $res;
		}
	
	
		public function buscarNotificacionesXRucXRazonsocialXPais($conexion, $identificadorExportador, $razonSocial, $idPais){
				
			$identificadorExportador = $identificadorExportador!="" ? "'" . $identificadorExportador . "'" : "null";
			$razonSocial = $razonSocial!="" ? "'%" . $razonSocial . "%'" : "null";
			$idPais = $idPais!="" ?  $idPais : "null";
	
			$res = $conexion->ejecutarConsulta("SELECT
													*
												FROM
													g_notificaciones_sanciones.notificaciones
												WHERE
													identificador_exportador = $identificadorExportador or
													razon_social ilike $razonSocial or
													id_pais = $idPais;");
				return $res;
		}
	
		public function buscarSancionesXRucXRazonsocialXPais($conexion, $identificadorExportador, $razonSocial, $idPais){
		
			$identificadorExportador = $identificadorExportador!="" ? "'" . $identificadorExportador . "'" : "null";
			$razonSocial = $razonSocial!="" ? "'%" . $razonSocial . "%'" : "null";
			$idPais = $idPais!="" ? $idPais : "null";
	
			$res = $conexion->ejecutarConsulta("SELECT
													*
												FROM
													g_notificaciones_sanciones.sanciones
												WHERE
													identificador_exportador = $identificadorExportador or
													razon_social ilike $razonSocial or
													id_pais = $idPais;");
			return $res;
		}
	
		public function buscarNotificacionesXId($conexion, $idNotificacion){
				
			$res = $conexion->ejecutarConsulta("SELECT
													*
												FROM
													g_notificaciones_sanciones.notificaciones
												WHERE
													id_notificacion = $idNotificacion;");
			return $res;
		}
	
		public function buscarSancionesXId($conexion, $idSancion){
					
				$res = $conexion->ejecutarConsulta("SELECT
														*
													FROM
														g_notificaciones_sanciones.sanciones
													WHERE
														id_sancion = $idSancion;");
				return $res;
		}
		
		public function actualizarFechaInspeccionFitosanitarioExportacion($conexion, $idFitosanitarioExportacion, $fechaInspeccion){
				
			$res = $conexion->ejecutarConsulta("UPDATE
													g_fitosanitario_exportacion.fitosanitario_exportaciones
												SET
													fecha_inspeccion='$fechaInspeccion'
												WHERE
													id_fitosanitario_exportacion = $idFitosanitarioExportacion;");
				
			return $res;
		}
		
		public function consultarSancionACaducar($conexion, $estadoSancion){
			$res = $conexion->ejecutarConsulta("SELECT
										            id_sancion,
										            identificador_exportador
										        FROM
										            g_notificaciones_sanciones.sanciones
										        WHERE
										            estado_sancion='".$estadoSancion."'
										            and fecha_fin_sancion=current_date;");
			return $res;
		}
		
		public function actualizarEstadoSancion($conexion, $idSancion,$estadoSancion){
			$res = $conexion->ejecutarConsulta("UPDATE 
													g_notificaciones_sanciones.sanciones
												SET
													estado_sancion = '$estadoSancion'
												WHERE
													id_sancion = '$idSancion';");
			return $res;
		}
		
}