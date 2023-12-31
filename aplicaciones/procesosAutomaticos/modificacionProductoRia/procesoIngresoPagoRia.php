<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorFinanciero.php';
require_once '../../../clases/ControladorFinancieroAutomatico.php';
require_once '../../../clases/ControladorModificacionProductoRia.php';
require_once '../../../clases/Constantes.php';

if($_SERVER['REMOTE_ADDR'] == ''){
//if(1){
	$conexion = new Conexion();
	$cm = new ControladorMonitoreo();
	$cf = new ControladorFinanciero();
	$cfa = new ControladorFinancieroAutomatico();
	$cmp = new ControladorModificacionProductoRia();
	$const = new Constantes;

	$resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_ING_FIN_AUTO_MPRO');

	if($resultadoMonitoreo){
    //if(1){
        
		define('IN_MSG','<br/> >>> ');

		$fecha = date("Y-m-d h:m:s");
		echo IN_MSG . '<p><strong> INICIO REGISTRO SOLICITUDES '.$fecha.'</strong></p>';

		$qSolicitudProducto = $cmp->obtenerSolicitudesProductosPago($conexion);
		
		while ($solicitudProducto = pg_fetch_assoc($qSolicitudProducto)) {

                $idSolicitudProducto = $solicitudProducto['id_solicitud_producto'];
                $numeroSolicitud = $solicitudProducto['numero_solicitud'];
    		    $formaPago = 'efectivo';
    		    $tipoSolicitud = "modificacionProductoRia";    		    
    		    $estado = "Por atender";
    		    $idArea = $solicitudProducto['id_area'];
				$idAreaFinanciero = 'CGRIA';
    		    
    		    echo IN_MSG . '<p> Inicio inserción en cabecera automático '.$fecha.'</p>';
    		    echo IN_MSG.'Número de solicitud: '. $solicitudProducto['numero_solicitud'];
    		    
    		    if($idArea == "IAP"){		    
    		        $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion, $const::ITEM_TARIFARIO_IAP, $idAreaFinanciero));
    		    }else if($idArea == "IAV"){
    		        $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion, $const::ITEM_TARIFARIO_IAV, $idAreaFinanciero));
    		    }else if($idArea == "IAF"){
    		        $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion, $const::ITEM_TARIFARIO_IAF, $idAreaFinanciero));
    		    }
    		    
    		    $idFinancieroCabecera = pg_fetch_result($cfa->guardarFinancieroAutomaticoCabecera($conexion, $servicio['valor'], $numeroSolicitud, $tipoSolicitud, $formaPago), 0, 'id_financiero_cabecera');
    		    
    		    $cfa->guardarFinancieroAutomaticoDetalle($conexion, $idFinancieroCabecera, $servicio['id_servicio'], $servicio['concepto'], 1, $servicio['valor'], 0, 0, $servicio['valor']);
     
    		    $cfa->actualizarEstadoFinancieroAutomaticoCabecera($conexion, $idFinancieroCabecera, $estado);		    
    		    $cfa->actualizarTipoProcesoFacturaFinancieroAutomaticoCabeceraPorIdentificador($conexion, $idFinancieroCabecera, 'factura');
    		    
    		    $cmp->actualizarEstadoSolicitudPorIdSolicitudProducto($conexion, $idSolicitudProducto, 'generarOrden');
    		        		    
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
	$arch = fopen("../../../aplicaciones/logs/cron/automatico_financiero_orden".date("d-m-Y").".txt", "a+");
	fwrite($arch, $xcadenota);
	fclose($arch);

}


?>