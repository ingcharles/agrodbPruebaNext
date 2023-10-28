<?php

class ControladorEnsayoEficacia
{
    public function actualizarEstadoSolicitudPorIdSolicitud($conexion, $idSolicitud, $estado)
    {

        $consulta = "UPDATE
                        g_ensayo_eficacia_mvc.solicitudes
                     SET
                        estado = '" . $estado . "'
                     WHERE
                        id_solicitud = '" . $idSolicitud . "';";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function obtenerSolicitudPorEstadoProvincia($conexion, $estado, $provincia)
    {

        $consulta = "SELECT
                        s.id_solicitud AS id_solicitud,
                        s.identificador_operador AS identificador_operador,
                        s.numero_solicitud AS numero_solicitud,
                        s.fecha_creacion AS fecha_registro
					 FROM
						g_ensayo_eficacia_mvc.solicitudes s
                        INNER JOIN g_operadores.operadores o ON o.identificador = s.identificador_operador
					 WHERE
						s.estado = '" . $estado . "'
						and upper(o.provincia) = UPPER ('" . $provincia . "')
                    ORDER BY s.fecha_creacion ASC";

        $res = $conexion->ejecutarConsulta($consulta);

        return $res;
    }

    public function abrirSolicitud($conexion, $idSolicitud)
    {

        $res = $conexion->ejecutarConsulta("SELECT
												*
											FROM
												g_ensayo_eficacia_mvc.solicitudes
											WHERE
												id_solicitud =  $idSolicitud;");
        return $res;
    }

    public function estado($estado)
    {
        switch ($estado) {
            case 'pago':
                $estado = 'Asignación de pago';
                break;
            case 'verificacion':
                $estado = 'Verificación de pago';
                break;
            case 'inspeccion':
                $estado = 'Revisión técnica';
                break;
            case 'asignadoInspeccion':
                $estado = 'Asignado revisión técnica';
                break;
            case 'organismoInspeccion':
                $estado = 'Asignar organismo de Inspección';
                break;
            case 'ingresarResultado':
                $estado = 'Ingresar resultados';
                break;
            case 'asignadoInspeccionResultado':
                $estado = 'Asignado revisión técnica de resultados';
                break;
            case 'inspeccionResultado':
                $estado = 'Revisión técnica de resultados';
                break;
            case 'subsanacion':
                $estado = 'Subsanación';
                break;
            case 'Aprobado':
                $estado = 'Aprobado';
                break;
            case 'Rechazado':
                $estado = 'Rechazado';
                break;
        }
        return $estado;
    }

    public function tipoSolicitud($tipoSolicitud)
    {
        switch ($tipoSolicitud) {
            case 'registro':
                $tipoSolicitud = 'Registro';
                break;
            case 'ampliacionCondicionesUso':
                $tipoSolicitud = 'Ampliación/Cambio en las condiciones de uso';
                break;
            case 'modificacionDosis':
                $tipoSolicitud = 'Modificación de dosis';
                break;
            case 'reevaluacion':
                $tipoSolicitud = 'Revaluación';
                break;
            case 'usoAdicionalregistroProceso':
                $tipoSolicitud = 'Uso adicional para registro en proceso';
                break;
        }
        return $tipoSolicitud;
    }

    public function tipoProducto($tipoProducto)
    {
        switch ($tipoProducto) {
            case 'quimico':
                $tipoProducto = 'Químico';
                break;
            case 'biologico':
                $tipoProducto = 'Biológico';
                break;
        }
        return $tipoProducto;
    }
}