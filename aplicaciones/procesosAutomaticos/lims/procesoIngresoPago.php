<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorFinanciero.php';
require_once '../../../clases/ControladorFinancieroAutomatico.php';
require_once '../../../clases/ControladorLims.php';
require_once '../../../clases/Constantes.php';

if($_SERVER['REMOTE_ADDR'] == ''){
//if(1){
	$conexion = new Conexion();
	$cm = new ControladorMonitoreo();
	$cf = new ControladorFinanciero();
	$cfa = new ControladorFinancieroAutomatico();
	$cl = new ControladorLims();
	$const = new Constantes;

	
	$resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_ING_FIN_AUTO_LIMS');

	//if($resultadoMonitoreo){
    if(1){
        
		define('IN_MSG','<br/> >>> ');

		$fecha = date("Y-m-d h:m:s");
		echo IN_MSG . '<p><strong> INICIO REGISTRO SOLICITUDES '.$fecha.'</strong></p>';

		$qSolicitudOrdenTrabajo = $cl->obtenerSolicitudesPagoAutomatico($conexion);
		
		//Todas las órdenes de trabajo automáticas
		while ($ordenTrabajo = pg_fetch_assoc($qSolicitudOrdenTrabajo)) {

    		    $idOrdenTrabajo = $ordenTrabajo['id'];
    		    $formaPago = 'efectivo';
    		    $tipoSolicitud = "lims";    		    
    		    $estado = "Por atender";
    		    $idArea = 'LT';
    		    
    		    echo IN_MSG . '<p> Inicio inserción en cabecera automático '.$fecha.'</p>';
    		    echo IN_MSG.'Número de solicitud: '. $ordenTrabajo['codigo'];
    		    
    		    
    		    //Todas las órdenes de trabajo automáticas
    		        
		        //Calcular monto con tarifario
		        $montoTarifario = pg_fetch_result($cl->costoTotalPaquetes($conexion, $idOrdenTrabajo), 0, 'total');
		        
		        //Calcular monto sin tarifario
		        $montoSinTarifario = pg_fetch_result($cl->totalOtrosPaquetes($conexion, $idOrdenTrabajo), 0, 'total');
		        
		        $totalServicios = $montoTarifario + $montoSinTarifario;
		    
		        //Crear cabecera
		        $idFinancieroCabecera = pg_fetch_result($cfa->guardarFinancieroAutomaticoCabecera($conexion, $totalServicios, $idOrdenTrabajo, $tipoSolicitud, $formaPago), 0, 'id_financiero_cabecera');
		    
		    
		        //Crear detalle factura
		        //Elementos con tarifa
		        $paquetesConItem = $cl->paquetesConTarifa($conexion, $idOrdenTrabajo);
		        
		        while ($paquetes = pg_fetch_assoc($paquetesConItem)) {
		            $cfa->guardarFinancieroAutomaticoDetalle($conexion, $idFinancieroCabecera, $paquetes['id_servicio'], $paquetes['concepto'], $paquetes['cantidad_paquetes'], $paquetes['precio_paquete'], 0, $paquetes['iva'], $paquetes['total_item']);
		        }
		        
		        
		        //Elementos con tarifa Otros Servicios de Laboratorio
		        if(pg_num_rows($cl->totalOtrosPaquetes($conexion, $idOrdenTrabajo)) > 0){
    		        $paquetesSinItem = pg_fetch_result($cl->totalOtrosPaquetes($conexion, $idOrdenTrabajo), 0, 'totalOtros');
    		        
    		        $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion, '04.21.001', $idArea));
    		        
    		        while ($paquetes = pg_fetch_assoc($paquetesSinItem)) {
    		            $cfa->guardarFinancieroAutomaticoDetalle($conexion, $idFinancieroCabecera, $servicio['id_servicio'], $servicio['concepto'], 1, $paquetesSinItem['totalOtros'], 0, $paquetesSinItem['iva'], $paquetesSinItem['total']);
    		        }    		        
		        }
    		    
    		    $cfa->actualizarEstadoFinancieroAutomaticoCabecera($conexion, $idFinancieroCabecera, $estado);		    
    		    $cfa->actualizarTipoProcesoFacturaFinancieroAutomaticoCabeceraPorIdentificador($conexion, $idFinancieroCabecera, 'factura');
    		    
    		    $cl->actualizarEstadoSolicitud($conexion, 'verificacion', $idOrdenTrabajo);
    		        		    
    		    echo IN_MSG . '<p> Fin inserción en cabecera automático '.$fecha.'</p>';
    		    
		}

		echo IN_MSG . '<p><strong> FIN REGISTRO SOLICITUDES '.$fecha.'</strong></p>';
		
	}

}else{

	$minutoS1=microtime(true);
	$minutoS2=microtime(true);
	$tiempo=$minutoS2-$minutoS1;
	$xcadenota = "FECHA ".date("d/m/Y")." ".date("H:i:s");
	$xcadenota.= "; IP REMOTA ".$_SERVER['REMOTE_ADDR'];
	$xcadenota.= "; SERVIDOR HTTP ".$_SERVER['HTTP_REFERER'];
	$xcadenota.= "; SEGUNDOS ".$tiempo."\n";
	$arch = fopen("../../../aplicaciones/logs/cron/automatico_financiero_orden_lims".date("d-m-Y").".txt", "a+");
	fwrite($arch, $xcadenota);
	fclose($arch);

}


?>