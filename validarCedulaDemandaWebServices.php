<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sistema GUIA</title>
</head>
<body>
	<h1>Verificación de registros realizados en el sistema</h1>

	<?php
	//require_once 'clases/Conexion.php';
	//require_once 'clases/ControladorValidacion.php';
	require_once 'clases/ControladorServiciosGubernamentales.php';
	//require_once 'clases/ControladorValidarIdentificacion.php';

	define('IN_MSG','<br/> >>> ');
	define('OUT_MSG','<br/> <<< ');
	define('PRO_MSG', '<br/> ... ');
	
	set_time_limit(172800);

	//$conexion = new Conexion();
	$webServices = new ControladorServiciosGubernamentales();
	//$cv = new ControladorValidacion();

	//$validacionDatos = $cv->obtenerRegistros($conexion);

	//while ($registroValidar = pg_fetch_assoc($validacionDatos)){

		//echo '<p> <strong>INICIO VERIFICACIÓN ' . $registroValidar['identificador'] . '</strong>' . IN_MSG . 'Inicio';
		
		//$rutaWebervices = 'https://www.bsg.gob.ec/sw/RC/BSGSW03_Consultar_Ciudadano?wsdl';
		//$rutaWebervices = 'https://www.bsg.gob.ec/sw/SENESCYT/BSGSW04_Consultar_Titulos?wsdl';
		$rutaWebervices = 'https://www.bsg.gob.ec/sw/ANT/BSGSW01_Consultar_MatriculaLic?wsdl';
		
		$resultadoAutenticacion = $webServices->consultarWebServicesAutenticacion($rutaWebervices);
		
		$cabeceraSeguridad = $webServices->crearCabeceraSeguridadWebServices($resultadoAutenticacion);
		
		//$resultadoConsulta = $webServices->consultarWebServicesCedula($cabeceraSeguridad, $registroValidar['identificador']);
		
		//$resultadoConsulta = $webServices->consultarWebServicesSenecyt($cabeceraSeguridad, '1307208221');
		
		$resultadoConsulta = $webServices->consultarWebServicesANT($cabeceraSeguridad, 'PBW8905');
		
		/*if($resultadoConsulta['CodigoError'] == '000'){
		    $cv->actualizarRegistrosValidadoWebSerices($conexion, $registroValidar['identificador'], 'TRUE');
		}else{
		    $cv->actualizarRegistrosValidadoWebSerices($conexion, $registroValidar['identificador'], $resultadoConsulta['Error']);
		}*/
		
		echo '<pre>';
		print_r($resultadoConsulta);
		echo '</pre>';
		
		echo OUT_MSG . 'Se ha finalizado la tarea.';
		echo '<br/><strong>FIN</strong></p>';
	//}

	?>

</body>
</html>
