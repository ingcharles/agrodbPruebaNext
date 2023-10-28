<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorCertificadoFito.php';

if($_SERVER['REMOTE_ADDR'] == ''){
//if(1){
	$conexion = new Conexion();
	$cm = new ControladorMonitoreo();
	$ccf = new ControladorCertificadoFito();

	$resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_ELIMI_CERT_FITO');

	if($resultadoMonitoreo){
    //if(1){
        
		define('IN_MSG','<br/> >>> ');

		$fecha = date("Y-m-d h:m:s");
		echo IN_MSG . '<p><strong> INICIO ELIMINACION SOLICITUDES '.$fecha.'</strong></p>';
								
		$qCertificadoFitosanitario = $ccf->obtenerCertificadoFitosanitarioPorEliminar($conexion);
		
		while ($certificadoFitosanitario = pg_fetch_assoc($qCertificadoFitosanitario)) {
		    
		    $idCertificadoFitosanitario = $certificadoFitosanitario['id_certificado_fitosanitario'];
		    $estadoCertificado = "Eliminado";
		    $observacionAnulacion = "Solicitud eliminada ya que no fue enviada antes de 24 horas.";
		    $fechaActulacionCertificado = "now()";
		    
		    echo IN_MSG . '<p> Inicio eliminación certificado fitosanitario '.$fecha.'</p>';
		    echo IN_MSG.'Número de solicitud: '. $idCertificadoFitosanitario;
		    
		    $qProductosCertificadoFitosanitario = $ccf->obtenerDetalleExportadoresProductos($conexion, $idCertificadoFitosanitario);
		    
		    while ($productoCertificadoFitosanitario = pg_fetch_assoc($qProductosCertificadoFitosanitario)) {
		        
		        if(empty($certificadoFitosanitario['es_reemplazo'])){
		        
    		        $idTotalInspeccionFitosanitaria = $productoCertificadoFitosanitario['id_total_inspeccion_fitosanitaria'];
    		        $cantidadComercial = $productoCertificadoFitosanitario['cantidad_comercial'];
    		        $pesoNeto = $productoCertificadoFitosanitario['peso_neto'];
    		        
    		        echo IN_MSG.'Inicio devolución de cupo: '. $idTotalInspeccionFitosanitaria;
    		        
    		        $ccf->guardarTransaccionProductoAgregado($conexion, 'ingreso', $idTotalInspeccionFitosanitaria, $cantidadComercial, $pesoNeto, 0, 0);
    		        
    		        echo IN_MSG.'Fin devolución de cupo: '. $idTotalInspeccionFitosanitaria;
    		        
		        }
		        
		    }
		    
		    $ccf->actualizarEstadoCertificadoFitosanitarioAnulado($conexion, $idCertificadoFitosanitario, $estadoCertificado, $observacionAnulacion, $fechaActulacionCertificado);
		    
		    echo IN_MSG . '<p> Fin eliminación de certificado '.$fecha.'</p>';
		    
		}		

		echo IN_MSG . '<p><strong> FIN ELIMINACION SOLICITUDES '.$fecha.'</strong></p>';
		
	}

}else{

	$minutoS1=microtime(true);
	$minutoS2=microtime(true);
	$tiempo=$minutoS2-$minutoS1;
	$xcadenota = "FECHA ".date("d/m/Y")." ".date("H:i:s");
	$xcadenota.= "; IP REMOTA ".$_SERVER['REMOTE_ADDR'];
	$xcadenota.= "; SERVIDOR HTTP ".$_SERVER['HTTP_REFERER'];
	$xcadenota.= "; SEGUNDOS ".$tiempo."\n";
	$arch = fopen("../../../aplicaciones/logs/cron/automatico_proceso_eliminar_solicitud_cfe".date("d-m-Y").".txt", "a+");
	fwrite($arch, $xcadenota);
	fclose($arch);

}


?>