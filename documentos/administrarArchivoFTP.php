<?php
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename="archivo.pdf"');
class administrarArchivoFTP{
	
	private function conexionFTP(){
	
		$rutaArchivo = $_POST['ruta'];
	
		$host = '192.168.1.52';
		$user = 'anonymous';
		$pass = '';
		
		//$host = 'ftp.restauranteapedirdeboca.com';
		//$user = 'info@restauranteapedirdeboca.com';
		//$pass = 'd8q==C,G2k1D';
	
		//header('Content-Type: application/force-download');
		//header('Content-Disposition: attachment; filename="archivo.pdf"');
	
		//conectarse al host
		$conn = @ftp_connect($host);
	
		//Comprobar que la conexión ha tenido éxito
		if (!$conn) {
			echo 'Error al tratar de conectar con ' . $host . "</br></br>";
			exit();
		}else{
			echo 'Se ha establecido conexión con' . $host . "</br></br>";
		}
	
		//Iniciamos sesión
		$login = @ftp_login($conn, $user, $pass);
		if (!$login) {
			echo 'Error al intentar acceder con el usuario ' . $user. "</br></br>";
			ftp_quit($conn);
			exit();
		}else{
			echo 'Acceso con el usuario ' . $user. "</br></br>";
		}
		
		return $conn;
	
	}
	
	public function obtenerArchivo(){
	
		//obtenemos el archivo del servidor
		
		$conn = $this->conexionFTP();
		
		//if (ftp_get($conn, $local_file, $remote_file, FTP_BINARY)) {
		if (ftp_get($conn, 'prueba.pdf', 'prueba.pdf', FTP_BINARY)) {
			//readfile($local_file);
			readfile('prueba.pdf');
			//unlink($local_file);
			echo 'El archivo ' . $local_file . ' se ha guardado.' . "</br>";
		} else {
			echo 'El archivo ' . $local_file . ' NO se ha guardado.' . "</br>";
		}
	
		//Cerramos la conexion
		ftp_close($conn);
	
	}
	
	public function enviarArchivo($ruta, $nombreArchivo, $formulario){
		
		$conn = $this->conexionFTP();
		
		$rutaRemoto = 'documentosGUIA/'.$formulario.'/'.$nombreArchivo;
		$rutaLocal= '../../'.$ruta;
		
		ftp_put($conn, $rutaRemoto, $rutaLocal, FTP_BINARY);
		
		ftp_close($conn);
		
	}
	
}


?>