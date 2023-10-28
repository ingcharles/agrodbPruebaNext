<!-- php 
/*require_once 'clases/Conexion.php';

$conexion = new Conexion();

//$datos = file_get_contents('aplicaciones/general/img/agrito.png');
//$imagen = pg_escape_bytea($datos);

//$res = $conexion->ejecutarConsulta("INSERT INTO imagen(foto) VALUES ('$imagen');");

$res = pg_fetch_assoc($conexion->ejecutarConsulta("SELECT * FROM g_operadores.sitios WHERE id_sitio = 104;"));

$imagen = pg_unescape_bytea($res['imagen_mapa']);

//header("Content-type: image/png");
echo $imagen;*/

?-->

<!-- ?php
     $values = array(
        12,
        "15",
        "15",
        34,
        15 => 25
    );

    $key = array_search("15", $values);
	
    if (!$key) {
        echo "Not found";
    }
    else {
        // gettype() will return either 'string' or 'integer'
        echo $key . ' - ' . strtolower(gettype($values[$key]));
    }
	
	echo "<pre>";
	print_r($values);
	echo "</pre>";
	
?-->


<!--?php

require_once(dirname(__FILE__).'/lib/TCPDF-master/tcpdf_import.php');
require_once(dirname(__FILE__).'/lib/FPDI-1.6.1/fpdi.php');

	$pdf = new FPDI();
	$pageCount = $pdf->setSourceFile(dirname(__FILE__).'/prueba.pdf');
	
	for ($i = 1; $i <= $pageCount; $i++) {
	    $tplIdx = $pdf->importPage($i, '/MediaBox');
	    $pdf->AddPage();
	    $pdf->useTemplate($tplIdx);
	}
	
	$pdf->Output();

?-->

<?php


/*set_time_limit('3600');

require_once 'clases/Conexion.php';
require_once 'clases/ControladorImportaciones.php';

$conexion = new Conexion('192.168.200.17', '5432', 'agrocalidad', 'postgres', 'd5R0_7Are4yut23rde09gdYt@43OdI');
$ci = new ControladorImportaciones();

$res = $ci->obtenerRegistros($conexion);

while ($fila = pg_fetch_assoc($res)){

	$archivoGuias = dirname(__FILE__).'/archivoImportacion/'.$fila['fecha_inicio'].'/';

	echo $fila['informe_requisitos'];

	if(!file_exists($archivoGuias)){
		mkdir($archivoGuias, 0777,true);
	}

	$archivo = explode('aplicaciones/importaciones/archivosRequisitos', $fila['informe_requisitos']);
	copy('https://guia.agrocalidad.gob.ec/agrodb/'.$fila['informe_requisitos'], $archivoGuias.end($archivo));
}*/


/*
 * setlocale(LC_TIME, 'es_ES');
 *
 * //$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
 * //$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 *
 * $fecha=new DateTime();
 * //$mes = strtoupper($fecha->format('n'));
 * //echo $mes;
 * //echo $meses[$mes -1];
 *
 * $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
 * $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
 *
 * $mes = ($fecha->format('F'));
 *
 * $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
 *
 * echo $mes;
 * echo strtoupper($nombreMes);
 */

// require_once 'clases/ControladorReportes.php';

// echo $constg::RUTA_SERVIDOR_OPT;

// echo '<span title="HOLAAAAA">HOLA</span>'

/*
 * require_once 'clases/Constantes.php';
 * $constg = new Constantes();
 *
 * $temporal=$constg::RUTA_APLICACION;
 * $temporal= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/'.$temporal;
 * echo $temporal;
 */

// Rutas al archivo (local y FTP)
/*
 * $local_file = 'archivo.pdf'; //Nombre archivo en nuestro PC
 * //$server_file = utf8_decode('2018/06/22/10/2018-0000000000000000000000000464036_AUTORIZACI%D3N.pdf');
 * $server_file = utf8_decode('2018/06/22/10/2018-0000000000000000000000000464036_AUTORIZACIÓN.pdf');
 * //$server_file = '2018/06/22/10/2018-0000000000000000000000000464035_FACT 9244 (2).pdf';
 * require_once 'aplicaciones/general/administrarArchivoFTP.php';
 *
 * echo $server_file;
 *
 * $cFTP = new administrarArchivoFTP();
 *
 * $coneccionFTP = $cFTP->conexionFTP();
 *
 * //header('Content-Type: application/force-download');
 * //header('Content-Disposition: attachment; filename="'.$local_file.'"');
 *
 * // Descarga el $server_file y lo guarda en $local_file
 * if (ftp_get($coneccionFTP, $local_file, $server_file, FTP_BINARY)) {
 * readfile($local_file);
 * unlink($local_file);
 * }else {
 * echo "Ha ocurrido un error\n";
 * }
 *
 * // Cerrar la conexión
 * ftp_close($coneccionFTP);
 */

/*
 * $datetime1 = new DateTime('2019-05-06 00:00:00');
 * $datetime2 = new DateTime('2019-02-05 00:00:00');
 * $interval = $datetime1->diff($datetime2);
 * echo 'UNO'.$interval->days;
 * $plazo=90-$interval->days;
 * echo 'DOS'.$plazo;
 */
/*function obtenerFechaFinalDiasLaborables($fechaInicial, $dias){
		
		$diasFestivos = array(
			'01-01' => 'Año nuevo',
			'05-01' => 'Día del trabajo',
			'05-24' => 'Batalla de pichincha',
			'08-10' => 'Primer grito de independencia',
			'09-09' => 'Independencia de Guayaquil',
			'11-02' => 'Día de los difuntos',
			'11-03' => 'Independencia de Cuenca',
			'12-25' => 'Navidad');
		
		$finSemana = array(
			'Sun' => '',
			'Sat' => '');
		
		$fechaInicio = new DateTime($fechaInicial); // recuerda solo mes y dia
		$fechaSiguiente = clone $fechaInicio;
		$i = 0;
		$fechaFinal = '';
		
		while ($i < $dias){
			$fechaSiguiente->add(new DateInterval('P1D'));
			if (isset($diasFestivos[$fechaSiguiente->format('m-d')]))
				continue;
				if (isset($finSemana[$fechaSiguiente->format('D')]))
					continue;
					$fechaFinal = $fechaSiguiente->format('Y-m-d');
					$i ++;
		}
		
		return $fechaFinal;
	}

$fechaFinal = obtenerFechaFinalDiasLaborables('2019/08/15', 90);

print_r($fechaFinal);

$dato = (double)450;
$dato1 = 450.00;

if($dato < $dato1){
    echo 'SI';
}else{
    echo 'NO';
}

// imprime el nombre de usuario que tiene control del proceso php/httpd activo
// (en un sistema con el ejecutable "whoami" disponible en la ruta)
//echo exec('whoami');

//$datos = array((int)94,(int)95);
//print_r($datos);

/*require_once 'clases/Conexion.php';
require_once 'clases/ControladorReportes.php';

$conexion = new Conexion();
$jru = new ControladorReportes();

set_time_limit(3600);

$solicitud = array(872, 873, 924, 925, 926, 933, 942, 964, 980, 990, 991, 992, 995, 997, 998, 999, 1000, 1001, 1002, 1003, 1004, 1005, 1006, 1007, 1008, 1010, 1011, 1012, 1013, 1014, 1015, 1016, 1017, 1018, 1019, 1020, 1021, 1022, 1023, 1024, 1025, 1026, 1027, 1028, 1029, 1030, 1031, 1032, 1033, 1034, 1035, 1036, 1037, 1038, 1039, 1040, 1041, 1043, 1044, 1045, 1046, 1047, 1048, 1049, 1050, 1051, 1052, 1053, 1054, 1055, 1056, 1057, 1058, 1059, 1060, 1061, 1062, 1063, 1064, 1065, 1066, 1067, 1068, 1069, 1070, 1071, 1072, 1073, 1074, 1075, 1076, 1077, 1078, 1079, 1080, 1081, 1082, 1083, 1084, 1085, 1086, 1087, 1088, 1089, 1090, 1091, 1092, 1093, 1094, 1095, 1096, 1097, 1098, 1099, 1100, 1101, 1102, 1103, 1104, 1105, 1106, 1107, 1108, 1109, 1110, 1111, 1112, 1113, 1114, 1115, 1116, 1117, 1118, 1119, 1120, 1121, 1122, 1123, 1124, 1125, 1127, 1128, 1129, 1130, 1131, 1132, 1133, 1134, 1135, 1136, 1137, 1138, 1139, 1140, 1141, 1142, 1143, 1144, 1145, 1146, 1147, 1148, 1149, 1150, 1151, 1152, 1153, 1154, 1155, 1156, 1157, 1158, 1159, 1160, 1161, 1162, 1163, 1164, 1165, 1166, 1167, 1168, 1169, 1170, 1171, 1172, 1173, 1174, 1175, 1176, 1177, 1178, 1179, 1180, 1181, 1182, 1183, 1184, 1185, 1186, 1187, 1188, 1189, 1190, 1192, 1193, 1194, 1195, 1196, 1197, 1198, 1199, 1200, 1201, 1202, 1203, 1204, 1205, 1206, 1207, 1208, 1209, 1210, 1211, 1212, 1213, 1214, 1215, 1216, 1217, 1218, 1219, 1220, 1221, 1222, 1223, 1224, 1225, 1226, 1227, 1228, 1229, 1230);
$ReporteJasper= '/aplicaciones/mercanciasSinValorComercial/reportes/certificado_zoosanitario_exportacion.jrxml';

for ($i = 0; $i < count($solicitud); $i++) {
	
	$idSolicitud = $solicitud[$i];

	$salidaReporte= '/aplicaciones/mercanciasSinValorComercial/anexos/exportacion_'.$idSolicitud.'.pdf';
	
	$rutaSubreporte = $constg::RUTA_SERVIDOR_OPT.'/'.$constg::RUTA_APLICACION.'/aplicaciones/mercanciasSinValorComercial/reportes/';
	
	$parameters = new java('java.util.HashMap');
	$parameters ->put('idSolicitud',(int)$idSolicitud);
	$parameters ->put('rutaSubreporte',$rutaSubreporte);
	
	$jru->generarReporteJasper($ReporteJasper,$parameters,$conexion->getConnection(),$salidaReporte,'mercanciasSinValorComercial');
}*/

//phpinfo();


//Verificar certificados de viverista no generados
/*require_once 'clases/Conexion.php';
require_once 'clases/ControladorCatastro.php';

$conexion = new Conexion();
$cc = new ControladorCatastro();

$qDatos = $cc->obtenerCertificadorViverista($conexion);

while($datos = pg_fetch_assoc($qDatos)){

	$ruta = $datos['archivo_salida'];

	if(!file_exists($ruta)){
		echo $ruta . '<br>';
	}

}*/
use Zend\Soap\Client;

$clientOptions = array(
			'local_cert' => '/srv/www/htdocs/agrodbPrueba/aplicaciones/mvc/modulos/WebServices/Modelos/CertificadoFitosanitarioEphyto/certificado/nppo-ec.pem', //Constantes::RUTA_SERVIDOR_OPT.'/'.Constantes::RUTA_APLICACION.'/'.'aplicaciones/mvc/modulos/WebServices/Modelos/CertificadoFitosanitarioEphyto/certificado/nppo-ec.pem',//PRUEBAS
		    //'local_cert' => Constantes::RUTA_SERVIDOR_OPT.'/'.Constantes::RUTA_APLICACION.'/'.'aplicaciones/mvc/modulos/WebServices/Modelos/CertificadoFitosanitarioEphyto/certificado/_.agrocalidad.gob.ec.pem',//PRODUCCION
			'passphrase' => 'nppoECp12',
			'soap_version' => SOAP_1_1,
			'encoding' => 'UTF-8',
			'location' => 'https://uat-hub.ephytoexchange.org/hub/DeliveryService'
		);

		$clienteEphyto = new Client('https://uat-hub.ephytoexchange.org/hub/DeliveryService?wsdl', $clientOptions);//PRUEBAS
		
		var_dump($clienteEphyto->__getFunctions());



?>