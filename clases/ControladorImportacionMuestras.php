<?php

class ControladorImportacionMuestras{
	
    public function listarImportacionMuestrasRevisionProvinciaRS($conexion, $estado, $provincia, $perfilUsuario){
        
        switch($perfilUsuario){
            case 'PFL_INS_IMMU_SA':
                $query = " and codigo_tipo_solicitud in ('SA') ";
            break;
            
            case 'PFL_INS_IMMU_SV':
                $query = " and codigo_tipo_solicitud in ('SV') ";
            break;
            
            case 'PFL_INS_IMMU_RIA':
                $query = " and codigo_tipo_solicitud in ('IAV', 'IAPB', 'IAPQ', 'IAF') ";
            break;
            
            default:
                $query = '';
            break;
        }
        
        $consulta = "SELECT 
						distinct id_importacion_muestras as id_solicitud,
						identificador_importador as identificador_operador,
						estado,
						nombre_tipo_solicitud as tipo_certificado,
						nombre_pais_origen as pais,
						razon_social_importador,
						req_no as id_vue,
						fecha_creacion
					FROM 
						g_importacion_muestras.importacion_muestras 
					WHERE 
						estado = '$estado' and
						UPPER(provincia_revision) = UPPER('$provincia') 
                        " .$query . "
                    ORDER BY
                        fecha_creacion;";
		
		$res = $conexion->ejecutarConsulta($consulta);
		
		return $res;
	}
	
	public function listarImportacionMuestrasAsignadasInspectorRS ($conexion, $estadoSolicitud, $identificadorInspector, $tipoSolicitud, $tipoInspector, $provincia, $perfilUsuario ){
		
	    switch($perfilUsuario){
            case 'PFL_INS_IMMU_SA':
                $query = " and i.codigo_tipo_solicitud in ('SA') ";
                break;
                
            case 'PFL_INS_IMMU_SV':
                $query = " and i.codigo_tipo_solicitud in ('SV') ";
                break;
                
            case 'PFL_INS_IMMU_RIA':
                $query = " and i.codigo_tipo_solicitud in ('IAV', 'IAPB', 'IAPQ', 'IAF') ";
                break;
                
            default:
                $query = '';
                break;
        }
        
		$res = $conexion->ejecutarConsulta("SELECT
												distinct id_importacion_muestras as id_solicitud,
												identificador_importador as identificador_operador,
												i.estado,
												i.nombre_tipo_solicitud as tipo_certificado,
												nombre_pais_origen as pais,
												razon_social_importador,
												req_no as id_vue,
												fecha_creacion
											FROM
												g_importacion_muestras.importacion_muestras i,
												g_revision_solicitudes.asignacion_coordinador ac
											WHERE
												i.id_importacion_muestras = ac.id_solicitud and
												ac.identificador_inspector = '$identificadorInspector' and
												ac.tipo_solicitud = '$tipoSolicitud' and
												ac.tipo_inspector = '$tipoInspector' and
												i.estado in ('$estadoSolicitud') and
						                        UPPER(i.provincia_revision) = UPPER('$provincia')
                                                " .$query . "
                                            ORDER BY
                                                fecha_creacion;");
		return $res;
	}
	
	public function listarImportacionMuestrasRevisionFinancieroRS ($conexion, $nombreProvincia, $estado='pago'){
	    
	    $res = $conexion->ejecutarConsulta("select
												distinct i.id_importacion_muestras  as id_solicitud,
												i.identificador_importador as identificador_operador,
												i.estado,
												i.nombre_tipo_solicitud as tipo_certificado,
												i.nombre_pais_origen as pais,
												o.razon_social, o.nombre_representante, o.apellido_representante,
												i.req_no as id_vue
											from
												g_importacion_muestras.importacion_muestras i,
												g_operadores.operadores o,
												g_importacion_muestras.importacion_muestras_productos ip
											where
												i.id_importacion_muestras = ip.id_importacion_muestras and
												UPPER(i.provincia_revision) = UPPER('$nombreProvincia') and
												i.identificador_importador = o.identificador and
												i.estado in ('$estado')
											order by 1 asc;");
	    return $res;
	}
	
	public function obtenerImportacionMuestrasFinancieroVerificacion ($conexion, $estado, $nombreProvincia, $tipoSolicitud){
	    
	    $res = $conexion->ejecutarConsulta("SELECT
												distinct i.id_importacion_muestras  as id_solicitud,
												i.identificador_importador as identificador_operador,
												i.estado,
												i.nombre_tipo_solicitud as tipo_certificado,
												i.nombre_pais_origen as pais,
												o.razon_social, o.nombre_representante, o.apellido_representante,
												i.req_no as id_vue
											FROM
												g_importacion_muestras.importacion_muestras i,
												g_operadores.operadores o,
												g_importacion_muestras.importacion_muestras_productos ip,
												g_revision_solicitudes.asignacion_inspector ai,
												g_revision_solicitudes.grupos_solicitudes gs,
												g_financiero.orden_pago orp
											WHERE
												i.id_importacion_muestras = ip.id_importacion_muestras and
												i.id_importacion_muestras = gs.id_solicitud and
												ai.id_grupo = gs.id_grupo and
												i.identificador_importador = o.identificador and
												UPPER(i.provincia_revision) = UPPER('$nombreProvincia') and
												i.estado in ('$estado') and
												ai.tipo_solicitud = '$tipoSolicitud' and
												ai.tipo_inspector = 'Financiero' and
												gs.estado != 'Verificación' and
												orp.id_grupo_solicitud = ai.id_grupo and
												orp.estado = 3 and
												orp.tipo_solicitud = '$tipoSolicitud';");
	    return $res;
	}
	
	public function abrirImportacionMuestras($conexion, $idSolicitud){
		
		$consulta = "SELECT
						*
					FROM
						g_importacion_muestras.importacion_muestras
					WHERE
						id_importacion_muestras = '$idSolicitud';";
		
		$res = $conexion->ejecutarConsulta($consulta);
		
		return $res;
	}
	
	public function buscarImportacionMuestrasVUE($conexion, $identificador, $idVue){
	    
	    $consulta = "SELECT
						*
					FROM
						g_importacion_muestras.importacion_muestras
					WHERE
						identificador_importador = '$identificador'
						and req_no = '$idVue';";
	    
	    $res = $conexion->ejecutarConsulta($consulta);
	    
	    return $res;
	}
	
	public function asignarDocumentoRequisitosTransitoInternacional ($conexion, $idSolicitud, $informeRequisitos){
	    $res = $conexion->ejecutarConsulta("update
												g_transito_internacional.transito_internacional
											set
												informe_requisitos = '$informeRequisitos'
											where
												id_transito_internacional = $idSolicitud;");
	    return $res;
	}
	
	public function abrirImportacionMuestrasProductos($conexion, $idSolicitud){
		
		$consulta = "SELECT
						*
					FROM
						g_importacion_muestras.importacion_muestras_productos
					WHERE
						id_importacion_muestras = '$idSolicitud';";
		
		$res = $conexion->ejecutarConsulta($consulta);
		
		return $res;
	}
	
	public function abrirDocumentosImportacionMuestras($conexion, $idSolicitud){
		
		$consulta = "SELECT
						*
					FROM
						g_importacion_muestras.documentos_adjuntos
					WHERE
						id_importacion_muestras = '$idSolicitud';";
		
		$cid = $conexion->ejecutarConsulta($consulta);
		
		while ($fila = pg_fetch_assoc($cid)){
		    $res[] = array(
		        idImportacionMuestras=>$fila['id_importacion_muestras'],
		        tipoArchivo=>$fila['tipo_archivo'],
		        rutaArchivo=>$fila['ruta_archivo'],
		        reqNo=>$fila['req_no']);
		}
		
		return $res;
	}
	
	public function actualizarEstadoDocumentoAdjunto($conexion, $idSolicitud, $idDocumentoAdjunto){
		
		$consulta = "UPDATE
						g_transito_internacional.documentos_adjuntos
					SET
						estado = 'activo'
					WHERE
						id_transito_internacional = $idSolicitud
						and id_documento_adjunto = $idDocumentoAdjunto;";
		
		$res = $conexion->ejecutarConsulta($consulta);
		
		return $res;
	}
	
	public function obtenerDocumentoAdjuntoPorNombre($conexion, $idSolicitud, $nombreDocumento){
		
		$consulta = "SELECT
						*
					FROM
						g_transito_internacional.documentos_adjuntos
					WHERE
						id_transito_internacional = $idSolicitud
						and tipo_archivo = '$nombreDocumento'
						and estado = 'temporal';";
		
		$res = $conexion->ejecutarConsulta($consulta);
		
		return $res;
	}
	
	public function cambiarEstadoImportacionMuestras ($conexion, $idSolicitud, $estado, $identificador, $observacion = null){
		
		$consulta = "UPDATE
						g_importacion_muestras.importacion_muestras
					SET
						estado = '$estado',
						observacion_tecnico = '$observacion',
						identificador_tecnico = '$identificador'
					where
						id_importacion_muestras = $idSolicitud;";
		
		$res = $conexion->ejecutarConsulta($consulta);
		
		return $res;
	}
	
	public function enviarImportacionMuestras ($conexion, $idImportacionMuestras, $estado){
		
		$consulta = "UPDATE
						g_importacion_muestras.importacion_muestras
					SET
						estado = '$estado'
					where
						id_importacion_muestras = $idImportacionMuestras;";
		
		$res = $conexion->ejecutarConsulta($consulta);
		
		return $res;
	}
	
	public function guardarRutaCertificado($conexion, $idSolicitud, $certificado){
	    
	    $res = $conexion->ejecutarConsulta("UPDATE
												g_importacion_muestras.importacion_muestras
											SET
												informe_requisitos = '$certificado'
											WHERE
												id_importacion_muestras = $idSolicitud;");
	    
	    return $res;
	    
	}
	
	
	/*ok*/
	public function guardarNuevoImportacionMuestras(
                                            	    $conexion, $reqNo, $numeroDocumento, 
                                            	    $nombreDocumento, $codigoFuncionDocumento, $fechaSolicitud,
                                                    $codigoCiudadSolicitud, $nombreCiudadSolicitud, 
                                            	    $codigoTipoSolicitud, $nombreTipoSolicitud, $numeroCertificado,
                                                    $identificadorSolicitante,$razonSocialSolicitante, $representanteLegalSolicitante, 
                                            	    $codigoProvinciaSolicitante, $nombreProvinciaSolicitante,
                                                    $codigoCantonSolicitante, $nombreCantonSolicitante, 
                                            	    $codigoParroquiaSolicitante, $nombreParroquiaSolicitante, 
                                            	    $nombreSolicitante, $direccionSolicitante, $telefonoSolicitante, $correoSolicitante, 
                                            	    $identificadorImportador, $razonSocialImportador, 
                                            	    $representanteLegalImportador, 
                                            	    $codigoProvinciaImportador, $nombreProvinciaImportador,
                                            	    $codigoCantonImportador, $nombreCantonImportador,
                                            	    $codigoParroquiaImportador, $nombreParroquiaImportador,
                                            	    $direccionImportador, $telefonoImportador, $celularImportador, $correoImportador,  	     
                                            	    $nombreExportador, $direccionExportador,
                                            	    $codigoRegimenAduanero, $nombreRegimenAduanero, 
                                            	    $codigoPaisOrigen, $nombrePaisOrigen, 
                                            	    $codigoMedioTransporte, $nombreMedioTransporte,
                                            	    $codigoPaisEmbarque, $nombrePaisEmbarque, 
                                            	    $codigoPuertoEmbarque, $nombrePuertoEmbarque, 
                                            	    $codigoPaisDestino, $nombrePaisDestino,
                                            	    $codigoPuertoDestino, $nombrePuertoDestino, 
                                            	    $codigoUnidadMoneda, $nombreUnidadMoneda, 
	                                                $nombreEmbarcador, $provinciaRevision, $codigoSolicitud){

	        
	    $res = $conexion->ejecutarConsulta("INSERT INTO 
                                                g_importacion_muestras.importacion_muestras(
                                                        req_no, codigo_formulario, 
                                                        nombre_formulario, codigo_funcion_documento, fecha_solicitud, 
                                                        codigo_ciudad_solicitud, nombre_ciudad_solicitud, 
                                                        codigo_tipo_solicitud, nombre_tipo_solicitud, numero_certificado, 
                                                        identificador_solicitante, razon_social_solicitante, representante_legal_solicitante, 
                                                        codigo_provincia_solicitante, nombre_provincia_solicitante, 
                                                        codigo_ciudad_solicitante, nombre_ciudad_solicitante, 
                                                        codigo_parroquia_solicitante, nombre_parroquia_solicitante, 
                                                        nombre_solicitante, direccion_solicitante, telefono_solicitante, correo_solicitante, 
                                                        identificador_importador, razon_social_importador, 
                                                        representante_legal_importador, 
                                                        codigo_provincia_importador, nombre_provincia_importador, 
                                                        codigo_ciudad_importador, nombre_ciudad_importador, 
                                                        codigo_parroquia_importador, nombre_parroquia_importador, 
                                                        direccion_importador, telefono_importador, celular_importador, correo_importador, 
                                                        nombre_exportador, direccion_exportador, 
                                                        codigo_regimen_aduanero, nombre_regimen_aduanero, 
                                                        codigo_pais_origen, nombre_pais_origen, 
                                                        codigo_medio_transporte, nombre_medio_transporte, 
                                                        codigo_pais_embarque, nombre_pais_embarque, 
                                                        codigo_puerto_embarque, nombre_puerto_embarque, 
                                                        codigo_pais_destino, nombre_pais_destino, 
                                                        codigo_puerto_destino, nombre_puerto_destino, 
                                                        codigo_unidad_moneda, nombre_unidad_moneda, 
                                                        nombre_embarcador, provincia_revision, estado, codigo_certificado)
										          VALUES ('$reqNo', '$numeroDocumento', 
                                                        $$$nombreDocumento$$, $$$codigoFuncionDocumento$$, '$fechaSolicitud',
                                                	    '$codigoCiudadSolicitud', $$$nombreCiudadSolicitud$$, 
                                                        '$codigoTipoSolicitud', '$nombreTipoSolicitud', '$numeroCertificado',
                                                        '$identificadorSolicitante', $$$razonSocialSolicitante$$, $$$representanteLegalSolicitante$$, 
                                                        '$codigoProvinciaSolicitante', '$nombreProvinciaSolicitante',
                                                	    '$codigoCantonSolicitante', $$$nombreCantonSolicitante$$, 
                                                        '$codigoParroquiaSolicitante', $$$nombreParroquiaSolicitante$$, 
                                                        $$$nombreSolicitante$$, $$$direccionSolicitante$$, '$telefonoSolicitante', $$$correoSolicitante$$, 
                                                        '$identificadorImportador', $$$razonSocialImportador$$, 
                                                        $$$representanteLegalImportador$$, 
                                                        '$codigoProvinciaImportador', $$$nombreProvinciaImportador$$,
                                                	    '$codigoCantonImportador', $$$nombreCantonImportador$$, 
                                                        '$codigoParroquiaImportador', $$$nombreParroquiaImportador$$,
                                                        $$$direccionImportador$$, '$telefonoImportador', '$celularImportador', $$$correoImportador$$, 
                                                        $$$nombreExportador$$, $$$direccionExportador$$,
                                                        '$codigoRegimenAduanero', $$$nombreRegimenAduanero$$, 
                                                        '$codigoPaisOrigen', $$$nombrePaisOrigen$$, 
                                                        '$codigoMedioTransporte', $$$nombreMedioTransporte$$,
                                                        '$codigoPaisEmbarque', $$$nombrePaisEmbarque$$, 
                                                        '$codigoPuertoEmbarque', $$$nombrePuertoEmbarque$$, 
                                                        '$codigoPaisDestino', $$$nombrePaisDestino$$, 
                                                        '$codigoPuertoDestino', $$$nombrePuertoDestino$$, 
                                                        '$codigoUnidadMoneda', '$nombreUnidadMoneda', 
                                                        $$$nombreEmbarcador$$, '$provinciaRevision', 'enviado', '$codigoSolicitud')
											     RETURNING id_importacion_muestras;");

		  return $res;  
	}
	
	/*ok*/
	public function guardarImportacionMuestrasProductos(     $conexion,   
	                                                          $idImportacionMuestras, $reqNo, $subpartidaArancelaria, 
                                                        	   $nombreProducto, $cantidadProducto, $nombreUnidadCantidad,
                                                        	   $pesoKilos, $nombreUnidadPeso,
                                                    	       $valorFob, $valorCif  
	                                                           ){
	    
       $res = $conexion->ejecutarConsulta("INSERT INTO 
                                                g_importacion_muestras.importacion_muestras_productos(
                                                	id_importacion_muestras, req_no, subpartida, 
                                                    nombre_producto, cantidad_producto, unidad_medida_producto, 
                                                    peso, unidad_peso, 
                                                    valor_fob, valor_cif)
                                        	VALUES ($idImportacionMuestras, '$reqNo', '$subpartidaArancelaria', 
                                                    '$nombreProducto', '$cantidadProducto', '$nombreUnidadCantidad', 
                                                    '$pesoKilos', '$nombreUnidadPeso', 
                                                    '$valorFob', '$valorCif');");
										            
	   return $res;
	}
	
	public function abrirImportacionMuestrasArchivoIndividual($conexion, $idImportacionMuestras, $tipoArchivo){
	    $res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_importacion_muestras.documentos_adjuntos
											WHERE
												id_importacion_muestras = $idImportacionMuestras
												and tipo_archivo = '$tipoArchivo';");
	    
	    return $res;
	}
	
	
	public function guardarImportacionMuestrasArchivos($conexion, $idImportacionMuestras, $tipoArchivo, $rutaArchivo, $reqNo){
	    
	    $documento = $this->abrirImportacionMuestrasArchivoIndividual($conexion, $idImportacionMuestras, $tipoArchivo);
	    
	    if(pg_num_rows($documento)== 0){
	        $res = $conexion->ejecutarConsulta("INSERT INTO g_importacion_muestras.documentos_adjuntos(
														id_importacion_muestras, tipo_archivo, ruta_archivo, req_no, fecha_creacion)
												VALUES ($idImportacionMuestras, '$tipoArchivo', '$rutaArchivo', '$reqNo', now());");
	    }
	    	    
	    return $res;
	}
	
	public function  generarNumeroSolicitud($conexion,$codigo){
	    
	    $res = $conexion->ejecutarConsulta("SELECT
												MAX(codigo_certificado) as numero
											FROM
												g_importacion_muestras.importacion_muestras
											WHERE
												codigo_certificado LIKE '$codigo';");
	    return $res;
	}
	
	public function actualizarDatosImportacionMuestras(     $conexion, $idImportacionMuestras, 
	                                                        $reqNo, $numeroDocumento,
                                                    	    $nombreDocumento, $codigoFuncionDocumento, $fechaSolicitud,
                                                    	    $codigoCiudadSolicitud, $nombreCiudadSolicitud,
                                                    	    $codigoTipoSolicitud, $nombreTipoSolicitud, $numeroCertificado,
                                                    	    $identificadorSolicitante,$razonSocialSolicitante, $representanteLegalSolicitante,
                                                    	    $codigoProvinciaSolicitante, $nombreProvinciaSolicitante,
                                                    	    $codigoCantonSolicitante, $nombreCantonSolicitante,
                                                    	    $codigoParroquiaSolicitante, $nombreParroquiaSolicitante,
                                                    	    $nombreSolicitante, $direccionSolicitante, $telefonoSolicitante, $correoSolicitante,
                                                    	    $identificadorImportador, $razonSocialImportador,
                                                    	    $representanteLegalImportador,
                                                    	    $codigoProvinciaImportador, $nombreProvinciaImportador,
                                                    	    $codigoCantonImportador, $nombreCantonImportador,
                                                    	    $codigoParroquiaImportador, $nombreParroquiaImportador,
                                                    	    $direccionImportador, $telefonoImportador, $celularImportador, $correoImportador,
                                                    	    $nombreExportador, $direccionExportador,
                                                    	    $codigoRegimenAduanero, $nombreRegimenAduanero,
                                                    	    $codigoPaisOrigen, $nombrePaisOrigen,
                                                    	    $codigoMedioTransporte, $nombreMedioTransporte,
                                                    	    $codigoPaisEmbarque, $nombrePaisEmbarque,
                                                    	    $codigoPuertoEmbarque, $nombrePuertoEmbarque,
                                                    	    $codigoPaisDestino, $nombrePaisDestino,
                                                    	    $codigoPuertoDestino, $nombrePuertoDestino,
                                                    	    $codigoUnidadMoneda, $nombreUnidadMoneda,
                                                    	    $nombreEmbarcador, $provinciaRevision,
                                                            $estado){
	    
	        $res = $conexion->ejecutarConsulta("UPDATE
												    g_importacion_muestras.importacion_muestras
    											SET
    												codigo_formulario='$numeroDocumento', 
                                                    nombre_formulario=$$$nombreDocumento$$, 
                                                    codigo_funcion_documento=$$$codigoFuncionDocumento$$, 
                                                    fecha_solicitud='$fechaSolicitud', 
                                                    codigo_ciudad_solicitud='$codigoCiudadSolicitud', 
                                                    nombre_ciudad_solicitud=$$$nombreCiudadSolicitud$$, 
                                                    codigo_tipo_solicitud='$codigoTipoSolicitud', 
                                                    nombre_tipo_solicitud='$nombreTipoSolicitud', 
                                                    numero_certificado='$numeroCertificado',  
                                                    identificador_solicitante='$identificadorSolicitante', 
                                                    razon_social_solicitante=$$$razonSocialSolicitante$$, 
                                                    representante_legal_solicitante=$$$representanteLegalSolicitante$$, 
                                                    codigo_provincia_solicitante='$codigoProvinciaSolicitante', 
                                                    nombre_provincia_solicitante=$$$nombreProvinciaSolicitante$$, 
                                                    codigo_ciudad_solicitante='$codigoCantonSolicitante', 
                                                    nombre_ciudad_solicitante=$$$nombreCantonSolicitante$$, 
                                                    codigo_parroquia_solicitante='$codigoParroquiaSolicitante', 
                                                    nombre_parroquia_solicitante=$$$nombreParroquiaSolicitante$$, 
                                                    nombre_solicitante=$$$nombreSolicitante$$, 
                                                    direccion_solicitante=$$$direccionSolicitante$$, 
                                                    telefono_solicitante='$telefonoSolicitante', 
                                                    correo_solicitante=$$$correoSolicitante$$, 
                                                    identificador_importador='$identificadorImportador', 
                                                    razon_social_importador=$$$razonSocialImportador$$, 
                                                    representante_legal_importador=$$$representanteLegalImportador$$, 
                                                    codigo_provincia_importador='$codigoProvinciaImportador', 
                                                    nombre_provincia_importador=$$$nombreProvinciaImportador$$, 
                                                    codigo_ciudad_importador='$codigoCantonImportador', 
                                                    nombre_ciudad_importador=$$$nombreCantonImportador$$, 
                                                    codigo_parroquia_importador='$codigoParroquiaImportador', 
                                                    nombre_parroquia_importador=$$$nombreParroquiaImportador$$, 
                                                    direccion_importador=$$$direccionImportador$$, 
                                                    telefono_importador='$telefonoImportador, 
                                                    celular_importador='$celularImportador', 
                                                    correo_importador=$$$correoImportador$$, 
                                                    nombre_exportador=$$$nombreExportador$$, 
                                                    direccion_exportador=$$$direccionExportador$$, 
                                                    codigo_regimen_aduanero='$codigoRegimenAduanero', 
                                                    nombre_regimen_aduanero=$$$nombreRegimenAduanero$$, 
                                                    codigo_pais_origen='$codigoPaisOrigen', 
                                                    nombre_pais_origen=$$$nombrePaisOrigen$$, 
                                                    codigo_medio_transporte='$codigoMedioTransporte', 
                                                    nombre_medio_transporte=$$$nombreMedioTransporte$$, 
                                                    codigo_pais_embarque='$codigoPaisEmbarque', 
                                                    nombre_pais_embarque=$$$nombrePaisEmbarque$$, 
                                                    codigo_puerto_embarque='$codigoPuertoEmbarque', 
                                                    nombre_puerto_embarque=$$$nombrePuertoEmbarque$$, 
                                                    codigo_pais_destino='$codigoPaisDestino', 
                                                    nombre_pais_destino=$$$nombrePaisDestino$$, 
                                                    codigo_puerto_destino='$codigoPuertoDestino', 
                                                    nombre_puerto_destino=$$$nombrePuertoDestino$$, 
                                                    codigo_unidad_moneda='$codigoUnidadMoneda', 
                                                    nombre_unidad_moneda='$nombreUnidadMoneda', 
                                                    nombre_embarcador=$$$nombreEmbarcador$$, 
                                                    provincia_revision='$provinciaRevision', 
                                                    estado='$estado'
    											WHERE
    												id_importacion_muestras = $idImportacionMuestras
    												and req_no = '$reqNo';");
	        
	        return $res;
	}
	
	public function eliminarProductosImportacionMuestras($conexion, $idImportacionMuestras){
	    $res = $conexion->ejecutarConsulta("DELETE FROM
												g_importacion_muestras.importacion_muestras_productos
											WHERE
												id_importacion_muestras = $idImportacionMuestras;");
	    
	    return $res;
	}
	
	public function eliminarArchivosAdjuntos($conexion, $idImportacionMuestras, $idVue){
	    $res = $conexion->ejecutarConsulta("DELETE FROM
													g_importacion_muestras.documentos_adjuntos
												WHERE
													id_importacion_muestras = $idImportacionMuestras
													and req_no = '$idVue';");
	    
	    return $res;
	}
	
	public function actualizarDatosTransitoInternacionalPuntos($conexion, $idTransitoInternacional, $idPuntoIngreso, $codigoPuntoIngreso, $nombrePuntoIngreso, $idPuntoSalida, $codigoPuntoSalida, $nombrePuntoSalida, $idVue){
	    
	        $res = $conexion->ejecutarConsulta("UPDATE
    												g_transito_internacional.transito_internacional
    											SET
    												id_punto_ingreso = $idPuntoIngreso, 
                                                    codigo_punto_ingreso = '$codigoPuntoIngreso', 
                                                    nombre_punto_ingreso = '$nombrePuntoIngreso', 
                                                    id_punto_salida = $idPuntoSalida, 
                                                    codigo_punto_salida = '$codigoPuntoSalida', 
                                                    nombre_punto_salida = '$nombrePuntoSalida'
    											WHERE
    												id_transito_internacional = $idTransitoInternacional
    												and req_no = '$idVue';");
	        return $res;
	}
	
	public function buscarTransitoInternacionalProductoVUE ($conexion, $identificador, $idVue, $producto){
	    
	    $res = $conexion->ejecutarConsulta("select
												p.*
											from
												g_transito_internacional.transito_internacional i,
												g_transito_internacional.transito_detalle_productos p
											where
												i.identificador_importador = '$identificador' and
												i.req_no = '$idVue' and
												i.id_transito_internacional = p.id_transito_internacional and
												p.id_producto = $producto;");
	    
	    return $res;
	}
	
	public function numeroProductosTransitoInternacional ($conexion, $identificador, $idVue){
	    
	    $res = $conexion->ejecutarConsulta("select
												count(p.id_transito_internacional) as cantidad
											from
												g_transito_internacional.transito_internacional i,
												g_transito_internacional.transito_detalle_productos p
											where
												i.identificador_importador = '$identificador' and
												i.req_no = '$idVue' and
												i.id_transito_internacional = p.id_transito_internacional;");
	    
	    return $res;
	}
	
	public function abrirImportacionMuestrasReporte ($conexion, $idSolicitud){
	    $cid = $conexion->ejecutarConsulta("SELECT
                        						*
                        					FROM
                        						g_importacion_muestras.importacion_muestras im
                                                INNER JOIN g_importacion_muestras.importacion_muestras_productos imp ON im.id_importacion_muestras = imp.id_importacion_muestras
                        					WHERE
                        						im.id_importacion_muestras = '$idSolicitud';");
	    
	    while ($fila = pg_fetch_assoc($cid)){
	        $res[] = array(
	            id_importacion_muestras=>$fila['id_importacion_muestras'],
	            fechaInicio=>$fila['fecha_inicio_vigencia'],
	            fechaVigencia=>$fila['fecha_fin_vigencia'],
	            idVue=>$fila['req_no'],
	            idArea=>$fila['codigo_tipo_solicitud'],	            
	            observacionesTecnico=>$fila['observacion_tecnico'],
	            
	            razonSocialImportador=>$fila['razon_social_importador'],
	            identificadorImportador=>$fila['identificador_importador'],
	            representanteLegalImportador=>$fila['representante_legal_importador'],
	            direccionImportador=>$fila['direccion_importador'],
	            telefonoImportador=>$fila['telefono_importador'],
	            emailImportador=>$fila['correo_importador'],
	            
	            razonSocialSolicitante=>$fila['nombre_solicitante'],
	            identificadorSolicitante=>$fila['identificador_solicitante'],
	            representanteLegalSolicitante=>$fila['representante_legal_solicitante'],
	            direccionSolicitante=>$fila['direccion_solicitante'],
	            telefonoSolicitante=>$fila['telefono_solicitante'],
	            emailSolicitante=>$fila['correo_solicitante'],
	            
	            nombreExportador=>$fila['nombre_exportador'],
	            direccionExportador=>$fila['direccion_exportador'],
	            
	            paisOrigen=>$fila['nombre_pais_origen'],
	            paisEmbarque=>$fila['nombre_pais_embarque'],
	            paisDestino=>$fila['nombre_pais_destino'],
	            puertoEmbarque=>$fila['nombre_puerto_embarque'],
	            puertoDestino=>$fila['nombre_puerto_destino'],
	            
	            subpartidaArancelaria=>$fila['subpartida'],
	            nombreProducto=>$fila['nombre_producto'],
	            cantidadProducto=>$fila['cantidad_producto'],
	            unidadMedidaProducto=>$fila['unidad_medida_producto'],
	            peso=>$fila['peso'],
	            unidadPeso=>$fila['unidad_peso']
	        );
	    }
	    
	    return $res;
	}
	
	///// FECHA DE VIGENCIA /////
	/*OK*/
	public function enviarFechaVigenciaImportacionMuestras ($conexion, $idImportacionMuestras, $idArea){
	    
	    $fechaVigencia = '';
	    switch ($idArea){
	        
	        case 'SA':  $fechaVigencia = "now() + interval '3 months'"; 	 break;
	        case 'SV':  $fechaVigencia = "now() + interval '3 months'"; 	 break;
	        case 'IAV': $fechaVigencia = "now() + interval '6 months'"; 	 break;
	        case 'IAPQ': $fechaVigencia = "now() + interval '12 months'"; break;
	        case 'IAPB': $fechaVigencia = "now() + interval '6 months'";  break;
	        case 'IAF': $fechaVigencia = "now() + interval '6 months'"; 	 break;	        
	        default:
	            echo 'Área desconocida.';
	    }
	    
		$res = $conexion->ejecutarConsulta("update
												g_importacion_muestras.importacion_muestras
											set
												fecha_inicio_vigencia = now(),
												fecha_fin_vigencia = " . $fechaVigencia ."
											where
												id_importacion_muestras = $idImportacionMuestras;");
	    return $res;
	}
}