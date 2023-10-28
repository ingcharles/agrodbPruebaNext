<?php

class ControladorRegistroProductoRia
{
    public function obtenerSolicitudPorEstadoProvincia($conexion, $estado, $provincia)
    {

        if ($estado == 'pago') {
            $condicion = " and s.requiere_descuento = true
                            UNION
                            SELECT
                                s.id_solicitud_registro_producto AS id_solicitud,
                                s.identificador_operador AS identificador_operador,
                                s.numero_solicitud AS numero_solicitud,
                                s.fecha_creacion AS fecha_registro
                             FROM
                                g_registro_productos.solicitudes_registro_productos s
                                INNER JOIN g_operadores.operadores o ON o.identificador = s.identificador_operador
                             WHERE
                                s.estado = '" . $estado . "'
                                and upper(o.provincia) = UPPER ('" . $provincia . "')
                                and s.tipo_solicitud IN ('clonesplaguicidas','bioplaguicidas')";
        }

        $consulta = "SELECT
                        s.id_solicitud_registro_producto AS id_solicitud,
                        s.identificador_operador AS identificador_operador,
                        s.numero_solicitud AS numero_solicitud,
                        s.fecha_creacion AS fecha_registro
					 FROM
						g_registro_productos.solicitudes_registro_productos s
                        INNER JOIN g_operadores.operadores o ON o.identificador = s.identificador_operador
					 WHERE
						s.estado = '" . $estado . "'
						and upper(o.provincia) = UPPER ('" . $provincia . "')
						" . $condicion . "
					ORDER BY fecha_registro DESC";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function abrirSolicitud($conexion, $idSolicitud)
    {

        $res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_registro_productos.solicitudes_registro_productos
											WHERE
												id_solicitud_registro_producto =  $idSolicitud;");
        return $res;
    }

    public function actualizarEstadoSolicitudPorIdSolicitud($conexion, $idSolicitud, $estado)
    {

        $actualizar = '';

        if ($estado == 'inspeccion') {
            $actualizar = ", fecha_confirmacion_pago = 'now()'";
        }

        $consulta = "UPDATE
                        g_registro_productos.solicitudes_registro_productos
                     SET
                        estado = '" . $estado . "'
                        " . $actualizar . "
                     WHERE
                        id_solicitud_registro_producto = '" . $idSolicitud . "';";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function obtenerSolicitudesProductosPago($conexion)
    {

        $consulta = "SELECT
						*
					FROM
						g_registro_productos.solicitudes_registro_productos
					WHERE
                        estado = 'pago'
                        and requiere_descuento = false
                        and tipo_solicitud not in ('clonesplaguicidas','bioplaguicidas');";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function abrirSolicitudPorNumeroSolicitud($conexion, $numeroSolicitud)
    {

        $res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_registro_productos.solicitudes_registro_productos
											WHERE
												numero_solicitud =  '" . $numeroSolicitud . "';");
        return $res;
    }

    public function actualizarEstadoSolicitudPorIdSolicitudRegistroProducto($conexion, $idSolicitudRegistroProducto, $estado)
    {

        $consulta = "UPDATE
                        g_registro_productos.solicitudes_registro_productos
                     SET
                        estado = '" . $estado . "'
                     WHERE
                        id_solicitud_registro_producto = '" . $idSolicitudRegistroProducto . "';";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function tipoSolicitud($tipoSolicitud)
    {
        switch ($tipoSolicitud) {
            case 'fertilizantes':
                $tipoSolicitud = 'Fertilizantes';
                break;
            case 'bioplaguicidas':
                $tipoSolicitud = 'Bioplaguicidas';
                break;
            case 'clonesfertilizantes':
                $tipoSolicitud = 'Clones fertilizantes';
                break;
            case 'clonesplaguicidas':
                $tipoSolicitud = 'Clones plaguicidas';
                break;
        }
        return $tipoSolicitud;
    }
}