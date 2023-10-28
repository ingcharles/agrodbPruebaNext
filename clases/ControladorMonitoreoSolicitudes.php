<?php

class ControladorMonitoreoSolicitudes
{

    public function obtenerMonitoreoSolicitudes($conexion)
    {

        $fecha = date("Y-m-d");

        $consulta = "SELECT
                        *
					 FROM
						g_monitoreo_solicitudes.solicitudes
					 WHERE
						fecha_finalizacion = '" . $fecha . "'
						and estado = 'Por atender';";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function actualizarEstadoSolictudes($conexion, $solicitudMonitoreo)
    {

        $actualizarOrigen = '';

        $tablaOrigen = $solicitudMonitoreo['nombre_tabla_origen'];
        $columnaIdentificadorCampoOrigen = $solicitudMonitoreo['nombre_campo_identificar_tabla_origen'];
        $datoIdentificadorCampoOrigen = $solicitudMonitoreo['id_tabla_origen'];
        $columnaEstadoOrigen = $solicitudMonitoreo['nombre_campo_estado_tabla_origen'];
        $datoEstadoCampoOrigen = $solicitudMonitoreo['estado_tabla_origen'];
        $columnaObservacionOrigen = $solicitudMonitoreo['nombre_campo_observacion_tabla_origen'];
        $datoObservacionOrigen = $solicitudMonitoreo['observacion_tabla_origen'];

        if (isset($datoObservacionOrigen) && ($datoObservacionOrigen != '')) {
            $actualizarOrigen .= ",$columnaObservacionOrigen = '" . $datoObservacionOrigen . "'";
        }

        $consulta = "UPDATE " . $tablaOrigen . "
                    SET " . $columnaEstadoOrigen . "='" . $datoEstadoCampoOrigen . "'
                    ".$actualizarOrigen."
                    WHERE " . $columnaIdentificadorCampoOrigen . "='" . $datoIdentificadorCampoOrigen . "';";

        $res = $conexion->ejecutarConsulta($consulta);


        $actualizarDestino = '';

        $tablaDestino = $solicitudMonitoreo['nombre_tabla_destino'];
        $columnaIdentificadorCampoDestino = $solicitudMonitoreo['nombre_campo_identificador_tabla_destino'];
        $datoIdentificadorCampoDestino = $solicitudMonitoreo['id_tabla_destino'];
        $columnaEstadoDestino = $solicitudMonitoreo['nombre_campo_estado_tabla_destino'];
        $datoEstadoCampoDestino = $solicitudMonitoreo['estado_tabla_destino'];
        $columnaObservacionDestino = $solicitudMonitoreo['nombre_campo_observacion_tabla_destino'];
        $datoObservacionDestino = $solicitudMonitoreo['observacion_tabla_destino'];

        if (isset($datoObservacionDestino) && ($datoObservacionDestino != '')) {
            $actualizarDestino .= ",$columnaObservacionDestino = '" . $datoObservacionDestino . "'";
		 			
			$consulta = "UPDATE " . $tablaDestino . "
                    SET " . $columnaEstadoDestino . "='" . $datoEstadoCampoDestino . "'
                    ".$actualizarDestino."
                    WHERE " . $columnaIdentificadorCampoDestino . "='" . $datoIdentificadorCampoDestino . "';";

			$res = $conexion->ejecutarConsulta($consulta);			
        }

        return $res;
    }

    public function actualizarEstadoMonitoreoSolicitud ($conexion, $idSolicitud, $estado){

        $consulta = "UPDATE
                        g_monitoreo_solicitudes.solicitudes
                     SET
                        estado = '" . $estado . "'
                     WHERE
                        id_solicitud = '" . $idSolicitud . "';";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }
}