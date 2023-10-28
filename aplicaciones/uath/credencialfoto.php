<?php 

/**
 * @author Alejandro Camacho
 * @version 1.0.0
 * @date 23/02/2023
 * 
 */
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEmpleados.php';

$conexion = new Conexion();
$ce = new ControladorEmpleados();
$res = $ce->obtenerDatosCredencial($conexion, $_SESSION['usuario']);
$empleado = pg_fetch_assoc($res);

//Crear codigo QR con una url previamente definida 
$urlCredencial = urlencode("http://181.112.155.173/agrodbPrueba/aplicaciones/uath/archivosPerfilPublico/credenciales/" . md5($empleado['identificador']) . ".png"); 				//pruebas
//$urlCredencial = urlencode("https://guia.agrocalidad.gob.ec/agrodbPrueba/aplicaciones/uath/archivosPerfilPublico/credenciales/" . md5($empleado['identificador']) . ".png");		//produccion
$imageQR = "https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=" . $urlCredencial . "&choe=UTF-8";
$urlCredencialServer = $_SERVER['DOCUMENT_ROOT']."/agrodbPrueba/aplicaciones/uath/archivosPerfilPublico/credenciales/" . md5($empleado['identificador']) . ".png";

//Datos del usuario
$url = $empleado['fotografia'];
$nombre = mb_convert_case(mb_strtolower($empleado['nombre'], 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
$cedula = $empleado['identificador'];
$cargo =  $empleado['nombre_puesto']; 
$direccion = $empleado['direccion']; 


//Separar el cargo en dos frases si es necesario
$cargoSeparado = explode(' ', $cargo);
$letras = 0;
$cargoFinal1 = '';
$cargoFinal2 = '';
foreach ($cargoSeparado as $key => $value) {
	$letras += strlen($value);
	if($letras < 45){
		$cargoFinal1 = $cargoFinal1 . $value . ' ';
	}
	else{
		$cargoFinal2 = $cargoFinal2 . $value . ' ';
	}
}

//Separar la direccion en dos frases si es necesario
$direccionSeparado = explode(' ', $direccion);
$letras = 0;
$direccionFinal1 = '';
$direccionFinal2 = '';
foreach ($direccionSeparado as $key => $value) {
	$letras += strlen($value);
	if($letras < 45){
		$direccionFinal1 = $direccionFinal1 . $value . ' ';
	}
	else{
		$direccionFinal2 = $direccionFinal2 . $value . ' ';
	}
}


header('Content-type: image/png');

$canvas = imagecreatetruecolor(650, 502);
$frente = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/agrodbPrueba/aplicaciones/uath/fotos/credencial/frente.png");
$posterior = imagecreatefrompng($_SERVER['DOCUMENT_ROOT']."/agrodbPrueba/aplicaciones/uath/fotos/credencial/posterior.png");
$foto = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT']."/agrodbPrueba/" . $url);
$foto2 = imagescale ( $foto , 140 , 190 );
$imgQR = imagecreatefrompng($imageQR);

$font_path = $_SERVER['DOCUMENT_ROOT']. "/agrodbPrueba/aplicaciones/uath/estilos/" . "Gotham_Medium.otf";
$color = imagecolorallocate($frente, 118, 120, 122);

$size = 8;
$size2 = 8;


//calcular el punto inicial en x donde ira el texto.
$relacion = 5.4; //relacion letra a pixel. 
$anchoNombre = (imagesx($frente)/2)-(strlen($nombre)*$relacion/2);
$anchoCedula = (imagesx($frente)/2)-(strlen($cedula)*$relacion/2);
$anchoCargo1 = (imagesx($frente)/2)-(strlen($cargoFinal1)*$relacion/2);
$anchoCargo2= (imagesx($frente)/2)-(strlen($cargoFinal2)*$relacion/2);
$anchoDir1 = (imagesx($frente)/2)-(strlen($direccionFinal1)*$relacion/2);
$anchoDir2 = (imagesx($frente)/2)-(strlen($direccionFinal2)*$relacion/2);


//insertar textos en la imagen 
$alto = 350;
imagettftext($frente, $size, 0, $anchoNombre, 310, $color, $font_path, $nombre);
imagettftext($frente, $size, 0, $anchoCedula, 330, $color, $font_path, $cedula);
imagettftext($frente, $size2, 0, $anchoCargo1, $alto, $color, $font_path, $cargoFinal1);
if($cargoFinal2 != ''){
	$alto += 15;
	imagettftext($frente, $size2, 0, $anchoCargo2, $alto, $color, $font_path, $cargoFinal2);
}
$alto += 20;
imagettftext($frente, $size2, 0, $anchoDir1, $alto, $color, $font_path, $direccionFinal1);
if($direccionFinal2 != ''){
	$alto += 15;
	imagettftext($frente, $size2, 0, $anchoDir2, $alto, $color, $font_path, $direccionFinal2);
}
$alto += 5;



imagecopy($canvas, $frente, 0, 0, 0, 0, imagesx($frente), imagesy($frente));
imagecopy($canvas, $foto2, 92, 98, 0, 0, 140, 189);
imagecopy($canvas, $imgQR, 200, $alto, 0, 0, imagesx($imgQR), imagesy($imgQR));
imagecopy($canvas, $posterior, 325, 0, 0, 0, imagesx($posterior), imagesy($posterior));
//Descargar la imagen automaticamente al servidor
imagepng($canvas, $urlCredencialServer);
//muestra la imagen en pantalla 
imagepng($canvas); 
imagedestroy($canvas); 
imagedestroy($frente);
imagedestroy($foto2); 

?> 