<?php

class administrarArchivoFTP{
    
    public function conexionFTP(){
        
        $rutaArchivo = $_POST['ruta'];
        
        //Linux
        /*$host = '192.168.200.40';
        $port = "22";
        $user = 'ftpuser';
        $pass = 'Agrocalidad8';
        
        $conn = ssh2_connect($host, $port);
        //echo 'conexion';
        if(ssh2_auth_password($conn, $user , $pass)){
            echo "conectado";
            return $conn;
        } else {
            echo "conexión fallida11";
            exit();
        }*/
        
        $host = '192.168.200.9'; 
        $port = '22';
        $user = 'ftpuser';
        $pass = 'Agrocalidad8';
        
        //ftp://FtpAGR:MAGAPAdmin13@192.168.1.7/
        
        //conectarse al host
        $conn = @ftp_connect($host);
        
        //Comprobar que la conexión ha tenido éxito
        if (!$conn) {
            exit();
        }
        
        //Iniciamos sesión
        $login = @ftp_login($conn, $user, $pass);
        if (!$login) {
            ftp_quit($conn);
            exit();
        }
        
        ftp_pasv($conn, true);
        
       return $conn;
        
    }
    
    public function enviarArchivo($ruta, $nombreArchivo, $formulario){
		
		$conn = $this->conexionFTP();
		
		$rutaRemoto = 'documentosGUIA/'.$formulario.'/'.$nombreArchivo;
		$rutaLocal= '../../'.$ruta;

		ftp_put($conn, $rutaRemoto, $rutaLocal, FTP_BINARY);
        
        ftp_close($conn);											  
		//Linux
        /*$rutaRemoto = '/app/attach/vueadm/2023';
        
        if($conn){

            if(ssh2_scp_send($conn, $rutaLocal, $rutaRemoto.'/'.$formulario.'/'.$nombreArchivo)){
                echo "archivo copiado\n";
            }else{
                echo "no se copio\n";
            }
            
        }*/
        
    }
    
}


?>