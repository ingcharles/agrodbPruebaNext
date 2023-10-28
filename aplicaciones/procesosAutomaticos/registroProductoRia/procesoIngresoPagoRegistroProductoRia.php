<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorFinanciero.php';
require_once '../../../clases/ControladorFinancieroAutomatico.php';
require_once '../../../clases/ControladorRegistroProductoRia.php';
require_once '../../../clases/Constantes.php';

if($_SERVER['REMOTE_ADDR'] == ''){
//if (1) {
    $conexion = new Conexion();
    $cm = new ControladorMonitoreo();
    $cf = new ControladorFinanciero();
    $cfa = new ControladorFinancieroAutomatico();
    $crpr = new ControladorRegistroProductoRia();
    $const = new Constantes;

    $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_ING_FIN_AUTO_RPRIA');

    if($resultadoMonitoreo){
    //if (1) {

        define('IN_MSG', '<br/> >>> ');

        $fecha = date("Y-m-d h:m:s");
        echo IN_MSG . '<p><strong> INICIO REGISTRO SOLICITUDES ' . $fecha . '</strong></p>';

        $qSolicitudRegistroProducto = $crpr->obtenerSolicitudesProductosPago($conexion);

        while ($solicitudRegistroProducto = pg_fetch_assoc($qSolicitudRegistroProducto)) {

            $idsolicitudRegistroProducto = $solicitudRegistroProducto['id_solicitud_registro_producto'];
            $numeroSolicitud = $solicitudRegistroProducto['numero_solicitud'];
            $formaPago = 'efectivo';
            $tipoProceso = "registroProductoRia";
            $estado = "Por atender";
            $tipoSolicitud = $solicitudRegistroProducto['tipo_solicitud'];
            $tipoSolicitudFinanciero = 'CGRIA';

            echo IN_MSG . '<p> Inicio inserción en cabecera automático ' . $fecha . '</p>';
            echo IN_MSG . 'Número de solicitud: ' . $solicitudRegistroProducto['numero_solicitud'];

            if ($tipoSolicitud == "fertilizantes") {
                $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion, $const::ITEM_TARIFARIO_RPRIA_FER, $tipoSolicitudFinanciero));
            } else if ($tipoSolicitud == "bioplaguicidas") {
                $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion, $const::ITEM_TARIFARIO_RPRIA_BIO, $tipoSolicitudFinanciero));
            } else if ($tipoSolicitud == "clonesfertilizantes") {
                $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion, $const::ITEM_TARIFARIO_RPRIA_CLO_FER, $tipoSolicitudFinanciero));
            }

            $idFinancieroCabecera = pg_fetch_result($cfa->guardarFinancieroAutomaticoCabecera($conexion, $servicio['valor'], $numeroSolicitud, $tipoProceso, $formaPago), 0, 'id_financiero_cabecera');

            $cfa->guardarFinancieroAutomaticoDetalle($conexion, $idFinancieroCabecera, $servicio['id_servicio'], $servicio['concepto'], 1, $servicio['valor'], 0, 0, $servicio['valor']);

            $cfa->actualizarEstadoFinancieroAutomaticoCabecera($conexion, $idFinancieroCabecera, $estado);
            $cfa->actualizarTipoProcesoFacturaFinancieroAutomaticoCabeceraPorIdentificador($conexion, $idFinancieroCabecera, 'factura');

            $crpr->actualizarEstadoSolicitudPorIdSolicitudRegistroProducto($conexion, $idsolicitudRegistroProducto, 'generarOrden');

            echo IN_MSG . '<p> Fin inserción en cabecera automático ' . $fecha . '</p>';

        }

        echo IN_MSG . '<p><strong> FIN REGISTRO SOLICITUDES ' . $fecha . '</strong></p>';

    }

} else {

    $minutoS1 = microtime(true);
    $minutoS2 = microtime(true);
    $tiempo = $minutoS2 - $minutoS1;
    $xcadenota = "FECHA " . date("d/m/Y") . " " . date("H:i:s");
    $xcadenota .= "; IP REMOTA " . $_SERVER['REMOTE_ADDR'];
    $xcadenota .= "; SERVIDOR HTTP " . $_SERVER['HTTP_REFERER'];
    $xcadenota .= "; SEGUNDOS " . $tiempo . "\n";
    $arch = fopen("../../../aplicaciones/logs/cron/automatico_financiero_orden_registro_producto" . date("d-m-Y") . ".txt", "a+");
    fwrite($arch, $xcadenota);
    fclose($arch);

}


?>