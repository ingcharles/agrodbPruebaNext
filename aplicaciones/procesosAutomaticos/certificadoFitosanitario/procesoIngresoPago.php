<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorFinanciero.php';
require_once '../../../clases/ControladorFinancieroAutomatico.php';
require_once '../../../clases/ControladorCertificadoFito.php';
require_once '../../../clases/Constantes.php';

if($_SERVER['REMOTE_ADDR'] == ''){
//if(1){
	$conexion = new Conexion();
	$cm = new ControladorMonitoreo();
	$cf = new ControladorFinanciero();
	$cfa = new ControladorFinancieroAutomatico();
	$ccf = new ControladorCertificadoFito();
	$const = new Constantes;
	
	$resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_INGRESO_FIN_AUTO');

	if($resultadoMonitoreo){
    //if(1){
        
		define('IN_MSG','<br/> >>> ');

		$fecha = date("Y-m-d h:m:s");
		echo IN_MSG . '<p><strong> INICIO REGISTRO SOLICITUDES '.$fecha.'</strong></p>';
        
        $banderaSolicitudes = false;
        $solicitudes = '';
        $arrayCertificadoFitosanitario = array();
        $qCertificadoFitosanitario = $ccf->obtenerCertificadoFitosanitarioPago($conexion);
        
        while ($certificadoFitosanitario = pg_fetch_assoc($qCertificadoFitosanitario)) {
                  
            $banderaSolicitudes = true;
            
            $idCertificadoFitosanitario = $certificadoFitosanitario['id_certificado_fitosanitario'];            
																															            
            $codigoCertificado = $certificadoFitosanitario['codigo_certificado'];
            $tipoCertificado = $certificadoFitosanitario['tipo_solicitud'];
            $formaPago = $certificadoFitosanitario['forma_pago'];
            $tipoSolicitud = "certificadoFito";
            $estado = "Por atender";
            $idArea = "SV";
            
            $solicitudes += $idCertificadoFitosanitario . ',';
            
            $arrayCertificadoFitosanitario[] = ['codigo_certificado' => $codigoCertificado
                , 'tipo_certificado' => $tipoCertificado
                , 'forma_pago' => $formaPago
                , 'tipo_solicitud' => $tipoSolicitud
                , 'estado' => $estado
                , 'id_area' => $idArea];
            
        }
        
        if($banderaSolicitudes){
            
            $solicitudes = rtrim($solicitudes, ',');       
            $ccf->actualizarEstadoSolicitudXIdCertificadoFitosanitario($conexion, $solicitudes, 'generarOrden');
                        
            foreach($arrayCertificadoFitosanitario as $llave => $valor){
                
                $codigoCertificado = $valor['codigo_certificado'];
                $tipoCertificado = $valor['tipo_certificado'];
                $formaPago = $valor['forma_pago'];
                $tipoSolicitud = $valor['tipo_solicitud'];
                $estado = $valor['estado'];
                $idArea = $valor['id_area'];
                
                echo IN_MSG . '<p> Inicio inserción en cabecera automático '.$fecha.'</p>';
                echo IN_MSG.'Número de solicitud: '. $codigoCertificado;
                
                if($tipoCertificado == "musaceas"){
                    $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion,  $const::ITEM_TARIFARIO_MUSACEAS, $idArea));
                }else if($tipoCertificado == "ornamentales"){
                    $servicio = pg_fetch_assoc($cf->obtenerIdServicioPorCodigoArea($conexion, $const::ITEM_TARIFARIO_ORNAMENTALES, $idArea));
                }
                
                $idFinancieroCabecera = pg_fetch_result($cfa->guardarFinancieroAutomaticoCabeceraSolicitudes($conexion, $servicio['valor'], $codigoCertificado, $tipoSolicitud, $formaPago), 0, 'id_financiero_cabecera');
                
                if($idFinancieroCabecera){                    
                    $cfa->guardarFinancieroAutomaticoDetalle($conexion, $idFinancieroCabecera, $servicio['id_servicio'], $servicio['concepto'], 1, $servicio['valor'], 0, 0, $servicio['valor']);
                    $cfa->actualizarEstadoFinancieroAutomaticoCabecera($conexion, $idFinancieroCabecera, $estado);
                    $cfa->actualizarTipoProcesoFacturaFinancieroAutomaticoCabeceraPorIdentificador($conexion, $idFinancieroCabecera, 'factura');                    
                }
                
                echo IN_MSG . '<p> Fin inserción en cabecera automático '.$fecha.'</p>';
                
            }
        
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
	$arch = fopen("../../../aplicaciones/logs/cron/automatico_proceso_ingreso_pago_cfe".date("d-m-Y").".txt", "a+");
	fwrite($arch, $xcadenota);
	fclose($arch);

}


?>