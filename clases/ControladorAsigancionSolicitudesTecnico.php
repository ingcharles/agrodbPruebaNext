<?php

class ControladorAsigancionSolicitudesTecnico
{
    public function obtenerSolicitudesAsigancionPorEstado($conexion)
    {

        $consulta = "SELECT
                        *
					 FROM
						g_asignacion_solicitudes.solicitudes
					 WHERE
						estado = 'Por atender'
                    ORDER BY fecha_creacion ASC";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function actualizarEstadoSolicitudAsignacion($conexion, $idSolicitud, $estado)
    {

        $consulta = "UPDATE 
                        g_asignacion_solicitudes.solicitudes
					 SET
						estado = '$estado'
					 WHERE
						id_solicitud = '$idSolicitud'";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function obtenerSolicitudesAsigancionPorPerfil($conexion, $codificacionPerfil, $estado = 'Activo')
    {

        $consulta = "SELECT
                       identificador
					 FROM
						g_asignacion_solicitudes.tecnicos_perfiles
					 WHERE
						codificacion_perfil = '$codificacionPerfil'
					 and estado = 'Activo'";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function obtenerMinimoSolicitudesAsigancionPorPerfil($conexion, $codificacionPerfil, $estado = 'Activo')
    {

        $consulta = "SELECT
                       coalesce(min(cantidad),0) as cantidad
					 FROM
						g_asignacion_solicitudes.tecnicos_perfiles
					 WHERE
						codificacion_perfil = '$codificacionPerfil'
					 and estado = 'Activo'";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function obtenerIdentificadorPorPerfil($conexion, $codificacionPerfil)
    {

        $consulta = "SELECT
                       identificador
					 FROM
						g_usuario.perfiles p 
					 INNER JOIN g_usuario.usuarios_perfiles up ON p.id_perfil = up.id_perfil
					 WHERE
						codificacion_perfil = '$codificacionPerfil'";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function actualizarEstadoUsuarioPerfil($conexion, $identificador, $codificacionPerfil, $cantidad, $estado = 'Activo')
    {

        $consulta = "UPDATE
                       g_asignacion_solicitudes.tecnicos_perfiles
					 SET
						estado = '$estado',
						cantidad = '$cantidad'
					 WHERE
						codificacion_perfil = '$codificacionPerfil'
						and identificador = '$identificador'";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function insertarUsuarioPerfil($conexion, $identificador, $codificacionPerfil, $cantidad)
    {

        $consulta = "INSERT INTO
                       g_asignacion_solicitudes.tecnicos_perfiles(identificador, codificacion_perfil, cantidad)
					 VALUES 
						('$identificador', '$codificacionPerfil', '$cantidad')";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function buscarUsuarioPerfil($conexion, $identificador, $codificacionPerfil)
    {

        $consulta = "SELECT 
                        * 
                    FROM 
                       g_asignacion_solicitudes.tecnicos_perfiles
					WHERE 
						identificador = '$identificador'
						and codificacion_perfil = '$codificacionPerfil'";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function buscarUsuarioPerfilCantidadParaAsigancion($conexion, $codificacionPerfil, $cantidad, $estado = 'Activo')
    {

        $consulta = "SELECT 
                        * 
                    FROM 
                       g_asignacion_solicitudes.tecnicos_perfiles
					WHERE 
						codificacion_perfil = '$codificacionPerfil'
                        and cantidad = '$cantidad'
                        and estado = '$estado'
                    LIMIT 1";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function actualizarCantidadUsuarioPerfil($conexion, $identificador, $codificacionPerfil, $cantidad)
    {

        $consulta = "UPDATE
                       g_asignacion_solicitudes.tecnicos_perfiles
					 SET
						cantidad = '$cantidad'
					 WHERE
						codificacion_perfil = '$codificacionPerfil'
						and identificador = '$identificador'";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function actualizarEstadoSolictudes($conexion, $identificador, $solicitud)
    {

        $actualizarOrigen = '';

        $tablaOrigen = $solicitud['nombre_tabla_origen'];
        $columnaIdentificadorCampoOrigen = $solicitud['nombre_campo_identificar_tabla_origen'];
        $datoIdentificadorCampoOrigen = $solicitud['id_tabla_origen'];
        $columnaEstadoOrigen = $solicitud['nombre_campo_estado_tabla_origen'];
        $datoEstadoCampoOrigen = $solicitud['estado_tabla_origen'];
        $columnaIdentificadorOrigen = $solicitud['nombre_campo_identificador_tabla_origen'];

        $consulta = "UPDATE " . $tablaOrigen . "
                    SET " . $columnaEstadoOrigen . "='" . $datoEstadoCampoOrigen . "'
                        ," . $columnaIdentificadorOrigen . "='" . $identificador . "'
                    WHERE " . $columnaIdentificadorCampoOrigen . "='" . $datoIdentificadorCampoOrigen . "';";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function guardarNuevoInspectorCoordinador($conexion, $datos)
    {

        $identificadorInspector = $datos['identificador_inspector'];
        $idSolicitud = $datos['id_solicitud'];
        $tipoSolicitud = $datos['tipo_solicitud'];
        $tipoInspector = $datos['tipo_inspector'];

        $consulta = "INSERT INTO
                    g_revision_solicitudes.asignacion_coordinador(identificador_inspector, fecha_asignacion, identificador_asignante, tipo_solicitud, id_solicitud,tipo_inspector)
                    VALUES ('$identificadorInspector',now(), '$identificadorInspector', '$tipoSolicitud', $idSolicitud,'$tipoInspector')
                    RETURNING id_asignacion_coordinador;";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }
}