<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorAsigancionSolicitudesTecnico.php';
require_once '../../../clases/ControladorUsuarios.php';


if($_SERVER['REMOTE_ADDR'] == ''){
//if (1) {
    $conexion = new Conexion();
    $cm = new ControladorMonitoreo();
    $cas = new ControladorAsigancionSolicitudesTecnico();

    $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_ASIG_SOL_TEC');

    if($resultadoMonitoreo){
    //if (1) {

        define('IN_MSG', '<br/> >>> ');

        $fecha = date("Y-m-d h:m:s");
        echo IN_MSG . '<p><strong> INICIO REGISTRO DE ASIGNACION SOLICITUD TECNICO POR PERFIL ' . $fecha . '</strong></p>';

        $qSolicitudesAsigancion = $cas->obtenerSolicitudesAsigancionPorEstado($conexion);

        while ($solicitudAsigancion = pg_fetch_assoc($qSolicitudesAsigancion)) {

            $idSolicitud = $solicitudAsigancion['id_solicitud'];
            $codificacionPerfil = $solicitudAsigancion['codificacion_perfil'];

            echo IN_MSG . '<p><strong> INICIO SOLICIUD ' . $idSolicitud . '</strong></p>';

            $cas->actualizarEstadoSolicitudAsignacion($conexion, $idSolicitud, 'W');

            $datosAsigancionPerfil = [];
            $qDatosAsigancionPerfil = $cas->obtenerSolicitudesAsigancionPorPerfil($conexion, $codificacionPerfil);
            $cantidad = pg_fetch_result($cas->obtenerMinimoSolicitudesAsigancionPorPerfil($conexion, $codificacionPerfil), 0, 'cantidad');

            while ($item = pg_fetch_assoc($qDatosAsigancionPerfil)) {
                $datosAsigancionPerfil[] = $item['identificador'];
            }

            $datosPerfilUsuario = [];
            $qDatosPerfilUsuario = $cas->obtenerIdentificadorPorPerfil($conexion, $codificacionPerfil);
            while ($item = pg_fetch_assoc($qDatosPerfilUsuario)) {
                $datosPerfilUsuario[] = $item['identificador'];
            }

            $tecnicosEliminados = array_diff($datosAsigancionPerfil, $datosPerfilUsuario);
            $tecnicosNuevos = array_diff($datosPerfilUsuario, $datosAsigancionPerfil);

            if (count($tecnicosEliminados)) {
                foreach ($tecnicosEliminados as $eliminado) {
                    $cas->actualizarEstadoUsuarioPerfil($conexion, $eliminado, $codificacionPerfil, $cantidad, 'Inactivo');
                }
            }

            if (count($tecnicosNuevos)) {
                foreach ($tecnicosNuevos as $nuevo) {
                    $usuario = $cas->buscarUsuarioPerfil($conexion, $nuevo, $codificacionPerfil);
                    if (pg_num_rows($usuario) == 0) {
                        $cas->insertarUsuarioPerfil($conexion, $nuevo, $codificacionPerfil, $cantidad);
                    } else {
                        $cas->actualizarEstadoUsuarioPerfil($conexion, $nuevo, $codificacionPerfil, $cantidad);
                    }
                }
            }

            $usuarioAsignacion = pg_fetch_assoc($cas->buscarUsuarioPerfilCantidadParaAsigancion($conexion, $codificacionPerfil, $cantidad));

            $cas->actualizarEstadoSolictudes($conexion, $usuarioAsignacion['identificador'], $solicitudAsigancion);

            $cas->actualizarCantidadUsuarioPerfil($conexion, $usuarioAsignacion['identificador'], $codificacionPerfil, $cantidad+1);

            $cas->actualizarEstadoSolicitudAsignacion($conexion, $idSolicitud, 'Atendida');

            $arrayParametros = [
                'identificador_inspector' => $usuarioAsignacion['identificador'],
                'id_solicitud' => $solicitudAsigancion['id_tabla_origen'],
                'tipo_solicitud' => 'registroProductoRia',
                'tipo_inspector' => 'Técnico'
            ];

            $cas->guardarNuevoInspectorCoordinador($conexion, $arrayParametros);

            echo IN_MSG . '<p> Fin inserción en aplicacion perfil</p>';

        }

        echo IN_MSG . '<p><strong> FIN REGISTRO ASIGNACION DE TECNICO ' . $fecha . '</strong></p>';

    }

} else {

    $minutoS1 = microtime(true);
    $minutoS2 = microtime(true);
    $tiempo = $minutoS2 - $minutoS1;
    $xcadenota = "FECHA " . date("d/m/Y") . " " . date("H:i:s");
    $xcadenota .= "; IP REMOTA " . $_SERVER['REMOTE_ADDR'];
    $xcadenota .= "; SERVIDOR HTTP " . $_SERVER['HTTP_REFERER'];
    $xcadenota .= "; SEGUNDOS " . $tiempo . "\n";
    $arch = fopen("../../../aplicaciones/logs/cron/asignacion_solicitudes_perfil_" . date("d-m-Y") . ".txt", "a+");
    fwrite($arch, $xcadenota);
    fclose($arch);

}


?>