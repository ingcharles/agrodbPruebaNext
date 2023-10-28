<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorInspeccionFitosanitaria.php';

if ($_SERVER['REMOTE_ADDR'] == '') {
    // if(1){
    $conexion = new Conexion();
    $cm = new ControladorMonitoreo();
    $cif = new ControladorInspeccionFitosanitaria();

    $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_ELIMI_INSP_FITO');

    if ($resultadoMonitoreo) {
        // if(1){

        define('IN_MSG', '<br/> >>> ');

        $fecha = date("Y-m-d h:m:s");
        echo IN_MSG . '<p><strong> INICIO RECHAZO SOLICITUDES ' . $fecha . '</strong></p>';

        $qInspeccionFitosanitaria = $cif->obtenerInspeccionFitosanitariaPorEliminar($conexion);

        while ($inspeccionFitosanitaria = pg_fetch_assoc($qInspeccionFitosanitaria)) {

            $idInspeccionFitosanitaria = $inspeccionFitosanitaria['id_inspeccion_fitosanitaria'];
            $estadoAnteriorInspeccionFitosanitaria = $inspeccionFitosanitaria['estado_inspeccion_fitosanitaria'];
            $estadoInspeccionFitosanitaria = "Rechazado";
            $observacionRechazo = "Registro en estado rechazado debido a que la solicitud no fue enviada en 1 día.";

            echo IN_MSG . '<p> Inicio rechazo de inspeccion fitosanitaria ' . $fecha . '</p>';
            echo IN_MSG . 'Número de solicitud: ' . $idInspeccionFitosanitaria;

            $cif->actualizarEstadoInspeccionFitosanitariaRechazada($conexion, $idInspeccionFitosanitaria, $estadoAnteriorInspeccionFitosanitaria, $estadoInspeccionFitosanitaria, $observacionRechazo);

            echo IN_MSG . '<p> Fin rechazo de inspeccion fitosanitaria ' . $fecha . '</p>';
        }

        echo IN_MSG . '<p><strong> FIN ELIMINACION SOLICITUDES ' . $fecha . '</strong></p>';
    }
} else {

    $minutoS1 = microtime(true);
    $minutoS2 = microtime(true);
    $tiempo = $minutoS2 - $minutoS1;
    $xcadenota = "FECHA " . date("d/m/Y") . " " . date("H:i:s");
    $xcadenota .= "; IP REMOTA " . $_SERVER['REMOTE_ADDR'];
    $xcadenota .= "; SERVIDOR HTTP " . $_SERVER['HTTP_REFERER'];
    $xcadenota .= "; SEGUNDOS " . $tiempo . "\n";
    $arch = fopen("../../../aplicaciones/logs/cron/automatico_proceso_eliminar_solicitud_cfe" . date("d-m-Y") . ".txt", "a+");
    fwrite($arch, $xcadenota);
    fclose($arch);
}

?>