<?php

class ControladorInspeccionFitosanitaria
{
       
    public function obtenerInspeccionFitosanitariaPorEliminar($conexion){
        
        $consulta = "SELECT 
                    	id_inspeccion_fitosanitaria 
                    	, EXTRACT(epoch FROM age(now(), fecha_creacion)) / 3600 as horas_trascurridas
                    	, fecha_creacion
                        , estado_inspeccion_fitosanitaria
                     FROM 
                    	g_inspeccion_fitosanitaria.inspeccion_fitosanitaria
                     WHERE
                    	estado_inspeccion_fitosanitaria = 'Creado'
                    	and EXTRACT(epoch FROM age(now(), fecha_creacion)) / 3600 > 24;";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    public function actualizarEstadoInspeccionFitosanitariaRechazada($conexion, $idInspeccionFitosanitaria, $estadoAnteriorInspeccionFitosanitaria, $estadoInspeccionFitosanitaria, $observacionRechazo){
        
        $consulta = "UPDATE 
                        g_inspeccion_fitosanitaria.inspeccion_fitosanitaria
                     SET 
                        estado_anterior_inspeccion_fitosanitaria = '" . $estadoAnteriorInspeccionFitosanitaria . "'
                        , estado_inspeccion_fitosanitaria = '" . $estadoInspeccionFitosanitaria ."'
                        , observacion_revisor = '" . $observacionRechazo . "'
                        , fecha_rechazo_solicitud = now()
                     WHERE
                        id_inspeccion_fitosanitaria = '" . $idInspeccionFitosanitaria . "';";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    public function obtenerIdentificadorAsignarAplicacion($conexion){
        
        $consulta = "SELECT
                    	DISTINCT op.identificador_operador
                    FROM
                    	g_operadores.operaciones op
                    INNER JOIN g_catalogos.tipos_operacion top on op.id_tipo_operacion = top.id_tipo_operacion
                    	WHERE top.id_area || top.codigo in ('SVEXP', 'SVEXB', 'SVACO','SVCOM', 'SVAGE') and op.estado in ('registrado', 'registradoObservacion')
                    EXCEPT
                    SELECT
                    	DISTINCT ar.identificador
                    FROM
                    	g_programas.aplicaciones_registradas ar
                    INNER JOIN g_programas.aplicaciones a ON a.id_aplicacion = ar.id_aplicacion and a.codificacion_aplicacion = 'PRG_INSP_FITO';";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
	public function obtenerInspeccionFitosanitariaPorCaducar($conexion){
        
        $consulta = "	SELECT
                        	id_inspeccion_fitosanitaria
                        	, fecha_vigencia
                        	, tiempo_vigencia
                        	, estado_inspeccion_fitosanitaria
                         FROM
                        	g_inspeccion_fitosanitaria.inspeccion_fitosanitaria
                         WHERE
                        	fecha_vigencia <= now()
                        	and estado_inspeccion_fitosanitaria = 'Aprobado';";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
	
}