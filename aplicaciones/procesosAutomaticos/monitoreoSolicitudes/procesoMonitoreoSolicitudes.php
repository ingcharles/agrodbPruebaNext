<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorMonitoreoSolicitudes.php';


if($_SERVER['REMOTE_ADDR'] == ''){
//if (1) {
    $conexion = new Conexion();
    $cm = new ControladorMonitoreo();
    $cms = new ControladorMonitoreoSolicitudes();


    $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_MON_SOLIC');

    if($resultadoMonitoreo){
    //if (1) {

        define('IN_MSG', '<br/> >>> ');

        $fecha = date("Y-m-d h:m:s");
        echo IN_MSG . '<p><strong> INICIO MONITOREO SOLIITUDES ' . $fecha . '</strong></p>';

        $qMonitoreoSolicitudes = $cms->obtenerMonitoreoSolicitudes($conexion);

        while ($solicitudMonitoreo = pg_fetch_assoc($qMonitoreoSolicitudes)) {

            echo IN_MSG . '<p> Inicio de cambio de estado de solicitud # ' . $solicitudMonitoreo['id_solicitud'] . '</p>';

            $cms->actualizarEstadoMonitoreoSolicitud($conexion, $solicitudMonitoreo['id_solicitud'], 'W');

            $cms->actualizarEstadoSolictudes($conexion, $solicitudMonitoreo);

            $cms->actualizarEstadoMonitoreoSolicitud($conexion, $solicitudMonitoreo['id_solicitud'], 'Atendida');

            echo IN_MSG . '<p> Fin de cambio de estado de solicitud</p>';

        }

        echo IN_MSG . '<p><strong> FIN MONITOREO SOLIITUDES ' . $fecha . '</strong></p>';

    }

} else {

    $minutoS1 = microtime(true);
    $minutoS2 = microtime(true);
    $tiempo = $minutoS2 - $minutoS1;
    $xcadenota = "FECHA " . date("d/m/Y") . " " . date("H:i:s");
    $xcadenota .= "; IP REMOTA " . $_SERVER['REMOTE_ADDR'];
    $xcadenota .= "; SERVIDOR HTTP " . $_SERVER['HTTP_REFERER'];
    $xcadenota .= "; SEGUNDOS " . $tiempo . "\n";
    $arch = fopen("../../../aplicaciones/logs/cron/monitoreo_solicitudes" . date("d-m-Y") . ".txt", "a+");
    fwrite($arch, $xcadenota);
    fclose($arch);

}


?>