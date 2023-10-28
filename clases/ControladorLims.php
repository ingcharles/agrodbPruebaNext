<?php

class ControladorLims
{
    //Consulta de órdenes para facturación por provincia
    public function obtenerSolicitudPorEstadoProvincia ($conexion, $estado, $provincia){
        
        $consulta = "SELECT
						ot.id as id_solicitud,
						ot.fecha_hora as fecha_registro,
						ot.codigo as numero_solicitud,
						ot.cliente_identificacion as identificador_operador
					 FROM
						g_lims.ordenes ot
					 WHERE
						ot.estado = '$estado'
                        and tipo_pago = 'manual'
						and upper(ot.provincia) = upper('$provincia');";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    //Muestra la información de cabecera de la orden de trabajo
    public function abrirSolicitud ($conexion, $idSolicitud){
        
        $res = $conexion->ejecutarConsulta("SELECT
										      *
											FROM
												g_lims.ordenes ot
                                                INNER JOIN g_lims.orden_muestra_procedimientos omp ON omp.orden_id = ot.id
											WHERE
												ot.id =  $idSolicitud;");
        return $res;
    }
    
    //Muestra el listado de paquetes y la cantidad
    public function abrirSolicitudPaquetes ($conexion, $idSolicitud){
        
        $res = $conexion->ejecutarConsulta("SELECT 
                                            	distinct omp.paquete_id, 
                                            	p.descripcion, 
                                            	count(omp.paquete_id) as cantidad_paquetes,
                                            	s.valor as precio_paquete,
                                            	0 as precio_lims,
                                            	s.codigo,
                                            	(count(omp.paquete_id)*s.valor) total_item
                                            FROM 
                                            	g_lims.orden_muestra_procedimientos omp 
                                            	INNER JOIN g_catalogos.paquete p ON p.id = omp.paquete_id
                                            	LEFT JOIN g_financiero.servicios s ON p.servicio_id = s.id_servicio
                                            WHERE 
                                            	omp.orden_id = $idSolicitud and
                                            	s.codigo not in ('04.21.001')
                                            GROUP BY 
                                            	omp.paquete_id, p.descripcion, s.valor, s.codigo
                                            
                                            UNION
                                            
                                            SELECT 
                                            	omp.paquete_id, 
                                            	p.descripcion, 
                                            	count(omp.paquete_id) as cantidad_paquetes,
                                            	s.valor as precio_paquete,
                                            	p.valor as precio_lims,
                                            	s.codigo,
                                            	(count(omp.paquete_id)*p.valor) total_item
                                            FROM 
                                            	g_lims.orden_muestra_procedimientos omp 
                                            	INNER JOIN g_catalogos.paquete p ON p.id = omp.paquete_id
                                            	LEFT JOIN g_financiero.servicios s ON p.servicio_id = s.id_servicio
                                            WHERE 
                                            	omp.orden_id = $idSolicitud and
                                            	s.codigo in ('04.21.001')
                                            GROUP BY 
                                            	omp.paquete_id, p.descripcion, s.valor,p.valor, s.codigo
                                            	
                                            order by 5;");
        
        return $res;
    }
    
    public function totalOtrosPaquetes ($conexion, $idSolicitud){
        
        $res = $conexion->ejecutarConsulta("SELECT
                                            	sum(p.valor) totalOtros,
												(sum(p.valor) *0.12) iva,
												(sum(p.valor) + (sum(p.valor) *0.12)) total
                                            FROM
                                            	g_lims.orden_muestra_procedimientos omp
                                            	INNER JOIN g_catalogos.paquete p ON p.id = omp.paquete_id
                                            	LEFT JOIN g_financiero.servicios s ON p.servicio_id = s.id_servicio
                                            WHERE
                                            	omp.orden_id = $idSolicitud and
                                            	s.codigo in ('04.21.001');");
        
        return $res;
    }
    
    public function costoTotalPaquetes ($conexion, $idSolicitud){
        
        $res = $conexion->ejecutarConsulta("SELECT
                                            	sum(s.valor) totalPaquetes,
												(sum(s.valor) *0.12) iva,
												(sum(s.valor) + (sum(s.valor) *0.12)) total
                                            FROM
                                            	g_lims.orden_muestra_procedimientos omp
                                            	INNER JOIN g_catalogos.paquete p ON p.id = omp.paquete_id
                                            	LEFT JOIN g_financiero.servicios s ON p.servicio_id = s.id_servicio
                                            WHERE
                                            	omp.orden_id = $idSolicitud and
                                            	s.codigo not in ('04.21.001');");
        
        return $res;
    }

    //Ok
    public function actualizarEstadoSolicitud($conexion, $estado, $idSolicitud){

        $res = $conexion->ejecutarConsulta("UPDATE
                                                g_lims.ordenes
                                            SET
                                                estado = '$estado'
                                            WHERE
                                                id = $idSolicitud;");
        
        return $res; 
    }
    
    public function actualizarFacturaLims($conexion, $idSolicitud, $numFactura){
        
        $res = $conexion->ejecutarConsulta("UPDATE
                                                g_lims.ordenes
                                            SET
                                                numero_factura = '$numFactura'
                                            WHERE
                                                id = $idSolicitud;");
        
        return $res;
    }
    
    //PAGO AUTOMÁTICO
    public function obtenerSolicitudesPagoAutomatico ($conexion){
        
        $consulta = "SELECT
						*
					FROM
						g_lims.ordenes ot
					WHERE
                        ot.estado = 'pago' and
                        ot.tipo_pago = 'automatico';";
        
        $res = $conexion->ejecutarConsulta($consulta);
        
        return $res;
    }
    
    //Detalle de servicios para facturación automática
    public function paquetesConTarifa ($conexion, $idSolicitud){
        
        $res = $conexion->ejecutarConsulta("SELECT 
                                            	distinct omp.paquete_id, 
                                            	p.descripcion, 
                                            	count(omp.paquete_id) as cantidad_paquetes,
                                            	s.id_servicio,
                                                s.concepto,
												s.valor as precio_paquete,
                                            	s.codigo,
												((count(omp.paquete_id)*s.valor)*0.12) as iva,
                                            	((count(omp.paquete_id)*s.valor) + ((count(omp.paquete_id)*s.valor)*0.12)) total_item
                                            FROM 
                                            	g_lims.orden_muestra_procedimientos omp 
                                            	INNER JOIN g_catalogos.paquete p ON p.id = omp.paquete_id
                                            	LEFT JOIN g_financiero.servicios s ON p.servicio_id = s.id_servicio
                                            WHERE 
                                            	omp.orden_id = 1 and
                                            	s.codigo not in ('04.21.001')
                                            GROUP BY 
                                            	omp.paquete_id, p.descripcion, s.id_servicio, s.concepto, s.valor, s.codigo
                                            order by 5;");
        
        return $res;
    }
}