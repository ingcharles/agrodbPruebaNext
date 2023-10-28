<?php

class ControladorCertificadoFito
{
    public function abrirSolicitud ($conexion, $idSolicitud){
        
        $res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_certificado_fitosanitario.certificado_fitosanitario cf
                                                INNER JOIN g_operadores.operadores o ON cf.identificador_solicitante = o.identificador
											WHERE
												cf.id_certificado_fitosanitario =  $idSolicitud;");
        return $res;
    }
    
    public function obtenerDetalleExportadoresProductos ($conexion, $idSolicitud){
    
        $res = $conexion->ejecutarConsulta("SELECT
                                            	cfp.*, stp.nombre as nombre_subtipo_producto
                                            FROM
                                            	g_certificado_fitosanitario.certificado_fitosanitario_productos cfp
                                            	INNER JOIN g_catalogos.productos p ON p.id_producto = cfp.id_producto
                                            	INNER JOIN g_catalogos.subtipo_productos stp ON stp.id_subtipo_producto = p.id_subtipo_producto
                                            WHERE
                                            	cfp.id_certificado_fitosanitario = $idSolicitud
                                            ORDER BY
                                            	cfp.nombre_subtipo_producto, nombre_producto ASC;");
        
        return $res;
    }
    
    public function actualizarEstadoCertificado($conexion, $estado, $idSolicitud, $identificador){

        $res = $conexion->ejecutarConsulta("UPDATE
												g_certificado_fitosanitario.certificado_fitosanitario
											SET
												estado_certificado = '$estado'
											WHERE
												id_certificado_fitosanitario = $idSolicitud;");
        
        return $res;
        
    }
    
    /*public function actualizarEstadoExportadoresProductos($conexion, $estado, $idSolicitud){
        
        $res = $conexion->ejecutarConsulta("UPDATE
												g_certificado_fitosanitario.exportadores_productos
											SET
												estado_exportador_producto = '$estado'
											WHERE
												id_certificado_fitosanitario = $idSolicitud and
                                                estado_exportador_producto in ('Creado', 'DocumentalAprobada');");
        
        return $res;
        
    }*/
    
    public function obtenerSolicitudPorEstadoProvincia ($conexion, $estado, $provincia){
        
        $busqueda = "";
        
        if($estado == 'verificacion'){
            $busqueda = " and forma_pago not in ('saldo')";
        }
        
        $consulta = "SELECT
                        cf.id_certificado_fitosanitario as id_solicitud,
                        cf.fecha_creacion_certificado as fecha_registro,
                        cf.codigo_certificado as numero_solicitud,
                        cf.identificador_solicitante as identificador_operador
                    FROM
                        g_certificado_fitosanitario.certificado_fitosanitario cf
                        INNER JOIN g_catalogos.localizacion l ON l.id_localizacion = cf.id_provincia_puerto_embarque
                    WHERE
                        cf.estado_certificado = '$estado'
                        and l.nombre = '$provincia'
                        and ((cf.tipo_solicitud in ('otros')" . $busqueda . ") or (cf.tipo_solicitud in ('ornamentales', 'musaceas') and (cf.descuento = 'Si' or cf.forma_pago not in ('saldo'))));";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
	
	public function buscarCertificadoFitosanitario ($conexion, $codigoCertificado){

        $consulta = "SELECT
						*
					FROM
						g_certificado_fitosanitario.certificado_fitosanitario
					WHERE
						codigo_certificado = '$codigoCertificado';";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    public function obtenerCertificadoFitosanitarioPago ($conexion){
        
        $consulta = "SELECT
						*
					FROM
						g_certificado_fitosanitario.certificado_fitosanitario
					WHERE
                        estado_certificado = 'pago'
						and tipo_solicitud in ('ornamentales', 'musaceas')
                        and descuento = 'No'
					LIMIT 12;";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    public function actualizarEstadoSolicitudXIdCertificadoFitosanitario ($conexion, $idCertificadoFitosanitario, $estado){
        
        $consulta = "UPDATE 
                        g_certificado_fitosanitario.certificado_fitosanitario
                     SET 
                        estado_certificado = '" . $estado . "' 
                     WHERE 
                        id_certificado_fitosanitario IN (" . $idCertificadoFitosanitario . ");";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
 
    public function obtenerDocumentoDescuentoPorIdCertificadoPorTipoAdjunto ($conexion, $idCertificadoFitosanitario, $tipoAdjunto){
        
        $consulta = "SELECT 
                        id_documento_adjunto
                        , id_certificado_fitosanitario
                        , tipo_adjunto
                        , ruta_adjunto
                     FROM 
                        g_certificado_fitosanitario.documentos_adjuntos
                     WHERE
                        id_certificado_fitosanitario = '" . $idCertificadoFitosanitario . "'
                        and tipo_adjunto = '" . $tipoAdjunto . "';";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    public function actualizarFechaAprobacionCertificado($conexion, $fechaAprobacionCertificado, $idCertificadoFitosanitario){
        
        $consulta = "UPDATE
                        g_certificado_fitosanitario.certificado_fitosanitario
                     SET
                        fecha_aprobacion_certificado = '" . $fechaAprobacionCertificado . "'
                     WHERE
                        id_certificado_fitosanitario = '" . $idCertificadoFitosanitario . "';";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
	public function obtenerDatosProvinciaPorIdCertificadoFitosanitario($conexion, $idCertificadoFitosanitario){
        
        $consulta = "SELECT
                        cf.id_certificado_fitosanitario as id_solicitud,
                        cf.fecha_creacion_certificado as fecha_registro,
                        cf.codigo_certificado as numero_solicitud,
                        cf.identificador_solicitante as identificador_operador,
                        l.nombre as nombre_provincia
                    FROM
                        g_certificado_fitosanitario.certificado_fitosanitario cf
                        INNER JOIN g_catalogos.localizacion l ON l.id_localizacion = cf.id_provincia_puerto_embarque
                    WHERE
                        cf.id_certificado_fitosanitario = " . $idCertificadoFitosanitario . " ;";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
	
	public function obtenerCertificadoFitosanitarioPorEliminar($conexion){
        
        $consulta = "SELECT 
                        id_certificado_fitosanitario 
                         , EXTRACT(epoch FROM age(now(), fecha_creacion_certificado)) / 3600 as dias_transcurridos
						 , es_reemplazo
                     FROM 
                        g_certificado_fitosanitario.certificado_fitosanitario
                     WHERE
                        estado_certificado = 'Creado'
                        and EXTRACT(epoch FROM age(now(), fecha_creacion_certificado)) / 3600 > 24;";
                                
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    public function guardarTransaccionProductoAgregado($conexion, $tipoTransaccion, $idTotalInspeccionFitosanitaria, $cantidadIngreso, $pesoIngreso, $cantidadEgreso, $pesoEgreso){

        $consulta = "SELECT * FROM g_certificado_fitosanitario.f_agregar_descontar_saldo_inspeccion('". $tipoTransaccion . "', $idTotalInspeccionFitosanitaria, $cantidadIngreso, $pesoIngreso, $cantidadEgreso, $pesoEgreso)";
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    public function actualizarEstadoCertificadoFitosanitarioAnulado($conexion, $idCertificadoFitosanitario, $estadoCertificado, $observacionAnulacion, $fechaAculacionCertificado){
        
        $consulta = "UPDATE 
                        g_certificado_fitosanitario.certificado_fitosanitario
                     SET 
                        estado_certificado = '" . $estadoCertificado . "'
                        , observacion_revision = '" . $observacionAnulacion . "'
                        ,  fecha_anulacion_certificado = '" . $fechaAculacionCertificado . "'
                     WHERE
                        id_certificado_fitosanitario = '" . $idCertificadoFitosanitario . "';";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
	
	public function obtenerIdentificadorAsignarAplicacion($conexion){
        
        $consulta = "SELECT 							 
                    	DISTINCT op.identificador_operador 
                    FROM																															  
                    	g_operadores.operaciones op 
                    INNER JOIN g_catalogos.tipos_operacion top on op.id_tipo_operacion = top.id_tipo_operacion
                    	WHERE top.id_area || top.codigo in ('SVEXP', 'SVEXB', 'SVAGE','SVCFE') and op.estado in ('registrado', 'registradoObservacion')
                    EXCEPT
                    SELECT 
                    	DISTINCT ar.identificador 
                    FROM
                    	g_programas.aplicaciones_registradas ar
                    INNER JOIN g_programas.aplicaciones a ON a.id_aplicacion = ar.id_aplicacion and a.codificacion_aplicacion = 'PRG_CERT_FITO';";										
																																				  
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
	
}