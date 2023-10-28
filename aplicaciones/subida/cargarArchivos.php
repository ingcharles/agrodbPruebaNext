<?php

echo IN_MSG . '<p><strong> INICIO COPIA ARCHIVO </strong></p>';

$fichero = 'prueba.pdf';
$dato = time();

for($i=1;$i<=40;$i++ ){
	$nuevo_fichero = '../Pruebas_ftp/sftp_remoto/Prueba'.$dato.$i.'.pdf';
	
	
	if (copy($fichero, $nuevo_fichero)) {
		
		echo IN_MSG . '<p>SE HA COPIADO EL ARCHVO '.$nuevo_fichero.'</p>';
		
	}else {
		
	   echo IN_MSG . '<p>ERROR AL COPIAR EL ARCHVO '.$nuevo_fichero.'</p>';
	   
	}
	
}
?>
