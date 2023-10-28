<?php 

	//print_r($_POST);
	
	/*$host = '192.168.1.52';
	$user = 'anonymous';
	$pass = '';*/
	
	//$remote_file = $_POST['archivoVUE'];
	//$local_file = $_POST['nombreArchivo'];
	
	$remote_file = '2014/12/22/18/2014-0000000000000000000000000609681_NOTA P UVAS CORREA.pdf';
	$local_file = 'NOTA DE PEDIDO.pdf';
	
	$host = '192.168.1.7';
	$user = 'FtpAGR';
	$pass = 'MAGAPAdmin13';
	
	//conectarse al host
	$conn = @ftp_connect($host);
	
	
	//Comprobar que la conexión ha tenido éxito
	if (!$conn) {
	echo 'Error al tratar de conectar con ' . $host . "</br>";
	exit();
	}
	echo 'Conectado con ' . $host . "</br>";

	//Iniciamos sesión
	$login = @ftp_login($conn, $user, $pass);
	if (!$login) {
	echo 'Error al intentar acceder con el usuario ' . $user;
	ftp_quit($conn);
	exit(); 
	}
	echo 'Conectado con el usuario ' . $user . "</br>";

	//obtenemos el archivo del servidor

	ftp_pasv($conn, true);
	
	if (ftp_get($conn, $local_file, $remote_file, FTP_BINARY)) {
	
		header('Content-Type: application/force-download');   
		header('Content-Disposition: attachment; filename="copia_local.pdf"');
	
	
		readfile($local_file);
		//unlink($local_file);
		
	echo 'El archivo ' . $local_file . ' se ha guardado.' . "</br>";
	} else {
	echo 'El archivo ' . $local_file . ' NO se ha guardado.' . "</br>";
	}

	
	//Cerramos la conexion
	ftp_close($conn);
?>

<!--?php
	$host = 'ftp.restaurante-pekin.com';
	$user = 'prueba@restaurante-pekin.com';
	$pass = 'S@loS@lo12';
	$remote_file = 'prueba2.pdf';
	$local_file = $_SERVER['DOCUMENT_ROOT'] . '/copia_local.pdf';
	
	echo $local_file;

	//conectarse al host
	$conn = @ftp_connect($host);

	//Comprobar que la conexión ha tenido éxito
	if (!$conn) {
	echo 'Error al tratar de conectar con ' . $host . "</br>";
	exit();
	}
	echo 'Conectado con ' . $host . "</br>";

	//Iniciamos sesión
	$login = @ftp_login($conn, $user, $pass);
	if (!$login) {
	echo 'Error al intentar acceder con el usuario ' . $user;
	ftp_quit($conn);
	exit(); 
	}
	echo 'Conectado con el usuario ' . $user . "</br>";

	//obtenemos el archivo del servidor
	if (ftp_get($conn, $local_file, $remote_file, FTP_BINARY)) {
	echo 'El archivo ' . $local_file . ' se ha guardado.' . "</br>";
	} else {
	echo 'El archivo ' . $local_file . ' NO se ha guardado.' . "</br>";
	}

	//subimos un archivo al servidor remoto
	$remote_file = 'prueba2.pdf';
	$local_file = $_SERVER['DOCUMENT_ROOT'] . '/copia_local.pdf';

	if (ftp_put($conn, $remote_file, $local_file, FTP_BINARY)) {
	echo 'El archivo ' . $local_file . ' se ha cargado en el servidor remoto.' . "</br>";
	} else {
	echo 'El archivo ' . $local_file . ' NO se ha cargado en el servidor remoto.' . "</br>";
	}

	//borramos el archivo del servidor
	if (ftp_delete($conn, $remote_file)) {
	echo 'El archivo ' . $remote_file . ' ha sido borrado del servidor.' . "</br>";
	}

	//obtenemos una lista con los archivos del servidor
	$files = ftp_nlist($conn, '.');
	foreach ($files as $file) {
	echo $file . "</br>";
	}

	//Cerramos la conexion
	ftp_close($conn);
?-->

<!--?php
$name = fopen ("ftp://prueba@restaurante-pekin.com:S@loS@lo12@ftp.restaurante-pekin.com/2014/01/02/prueba.pdf", "r");
//$name = 'prueba.pdf';
header('Content-disposition: attachment; filename="'.$name.'"');
header('Content-type: application/pdf');
$texto="";
while ($linea = fgets($name,1024)) {
   if ($linea) $texto .= $linea;
}
readfile($texto);
fclose($name);
?-->

<!--?php
$archivoFtp = fopen('ftp://192.168.1.52/2014/01/22/11/2014-0000000000000000000000000001769_FLUJO.pdf','r');
?-->

<!--?php
$archivo = fopen ("ftp://192.168.1.52/2014/01/22/11/2014-0000000000000000000000000001769_FLUJO.pdf", "r");
if (!$archivo) {
echo "<p>No puedo abrir el archivo para lectura</p>";
exit;
}
$texto="";
while ($linea = fgets($archivo,1024)) {
   if ($linea) $texto .= $linea;
}
echo $texto;
//fclose ($archivo);


    header('Content-Type: application/pdf');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    ob_clean();
    flush();
    readfile($archivo);
    exit;


?-->

<!--?php

	 Function DescargarArchivo($ruta, $nombreArchivo, $id_ftp) {
    // path to remote file
    $remote_file = $ruta."/".$nombreArchivo;
    $local_file = $nombreArchivo;

    //open some file to write to
    $handle = fopen($local_file, 'w');
    if (ftp_fget($id_ftp, $handle, $remote_file, FTP_BINARY, 0)) {
        header("Content-Type: application/force-download");   
        header("Content-Disposition: attachment; filename=$local_file");
        readfile($local_file);
        unlink($local_file);
        return true;
    } 
    else {
        echo "There was a problem while downloading\n";
        return false;
    }
}


if (DescargarArchivo("/2014/01/22/11/","2014-0000000000000000000000000001769_FLUJO.pdf","192.168.1.52"))
 {
   echo "descargado";
 }  

?-->



<!--?php
function pdfVersion($filename)
{
    $fp = @fopen($filename, 'rb');
    if (!$fp) {
        return 0;
    }
    /* Reset file pointer to the start */
    fseek($fp, 0);
    /* Read 20 bytes from the start of the PDF */
    preg_match('/\d\.\d/',fread($fp,20),$match);
    fclose($fp);
    if (isset($match[0])) {
        return $match[0];
    } else {
        return 0;
    }
} 
$version = pdfVersion("ftp://192.168.1.52/2014/01/22/11/2014-0000000000000000000000000001769_FLUJO.pdf");
?-->

<!--?php 
	$host = 'ftp.restaurante-pekin.com';
	$user = 'prueba@restaurante-pekin.com';
	$pass = 'S@loS@lo12';
	$remote_file = 'prueba2.pdf';
	$local_file = $_SERVER['DOCUMENT_ROOT'] . '/copia_local.pdf';
	
	echo $local_file;

	//conectarse al host
	$conn = @ftp_connect($host);

	//Comprobar que la conexión ha tenido éxito
	if (!$conn) {
	echo 'Error al tratar de conectar con ' . $host . "</br>";
	exit();
	}
	echo 'Conectado con ' . $host . "</br>";

	//Iniciamos sesión
	$login = @ftp_login($conn, $user, $pass);
	if (!$login) {
	echo 'Error al intentar acceder con el usuario ' . $user;
	ftp_quit($conn);
	exit(); 
	}
	echo 'Conectado con el usuario ' . $user . "</br>";

	//obtenemos el archivo del servidor
	if (ftp_get($conn, $local_file, $remote_file, FTP_BINARY)) {
	echo 'El archivo ' . $local_file . ' se ha guardado.' . "</br>";
	} else {
	echo 'El archivo ' . $local_file . ' NO se ha guardado.' . "</br>";
	}

	//subimos un archivo al servidor remoto
	$remote_file = 'prueba2.pdf';
	$local_file = $_SERVER['DOCUMENT_ROOT'] . '/copia_local.pdf';

	if (ftp_put($conn, $remote_file, $local_file, FTP_BINARY)) {
	echo 'El archivo ' . $local_file . ' se ha cargado en el servidor remoto.' . "</br>";
	} else {
	echo 'El archivo ' . $local_file . ' NO se ha cargado en el servidor remoto.' . "</br>";
	}

	//borramos el archivo del servidor
	if (ftp_delete($conn, $remote_file)) {
	echo 'El archivo ' . $remote_file . ' ha sido borrado del servidor.' . "</br>";
	}

	//obtenemos una lista con los archivos del servidor
	$files = ftp_nlist($conn, '.');
	foreach ($files as $file) {
	echo $file . "</br>";
	}

	//Cerramos la conexion
	ftp_close($conn);
?-->


<!--?php
	$archivo = fopen ("ftp://prueba@restaurante-pekin.com:S@loS@lo12@ftp.restaurante-pekin.com/2014/01/02/prueba.pdf", "r");
		if (!$archivo) {
			echo "<p>No puedo abrir el archivo para lectura</p>";
		exit;
		}
	/*$texto="";
	while ($linea = fgets($archivo,1024)) {
	   if ($linea) $texto .= $linea;
	}
	echo $texto;*/
	
	
	//$pdf->Output("prueba.pdf",F); 
	$mi_pdf = 'prueba.pdf';  
	header('Content-type: application/pdf'); 
	header('Content-Disposition: inline; filename="'.$mi_pdf.'"');   
	readfile($mi_pdf);  
	

	
	fclose ($archivo);
	
?-->

