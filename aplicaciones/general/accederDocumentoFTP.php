<?php 
	session_start();
	require_once 'administrarArchivoFTP.php';

	$cFTP = new administrarArchivoFTP();
	
	list($usec, $sec) = explode(" ", microtime());
	$fechaActual =  date("Y-m-d-H-i-s-",$sec).intval(round($usec*1000));
			
	$archivoRemoto = utf8_decode($_POST['rutaArchivo']);
	$archivoLocal = $fechaActual.utf8_decode($_POST['nombreArchivo']);
	$idVue = utf8_decode($_POST['idVue']);
	
	if($idVue!=''){ 
		$coneccionFTP = $cFTP->conexionFTP();
		
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename="'.$archivoLocal.'"');
		
		//Linux
		/*if($coneccionFTP){
			echo '/app/attach/vueadm'. $archivoRemoto;
			
		    if(ssh2_scp_recv($coneccionFTP, '/app/attach/vueadm'. $archivoRemoto, $archivoLocal)){
		        echo "archivo copiado\n accedido XXXXXX";
				readfile($archivoLocal);
			unlink($archivoLocal);
		    }else{
		        echo "no se copio\n accedido";
		    }
		    
		}else{
		    
		    echo "No hay conexión SFTP";
		}*/
		
		if (ftp_get($coneccionFTP, $archivoLocal, $archivoRemoto, FTP_BINARY)) {
			readfile($archivoLocal);
			unlink($archivoLocal);
		}

		ftp_close($coneccionFTP);
		
	}else{
		
		$nombreArchivo = $_SERVER['DOCUMENT_ROOT'].'/agrodb/'.$archivoRemoto;
		
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename="'.$archivoLocal.'"');
		
		readfile($nombreArchivo);

	}
	
?>