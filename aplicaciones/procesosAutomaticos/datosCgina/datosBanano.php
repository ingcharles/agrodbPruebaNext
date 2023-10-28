<?php

// if ($_SERVER['REMOTE_ADDR'] == '') {
if(1){
    require_once '../../../clases/Conexion.php';
    require_once '../../../clases/ControladorMonitoreo.php';
    require_once '../../../clases/ControladorMagBanano.php';
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    $conexion = new Conexion();
    $conexionMag = new Conexion('192.168.200.13', '5432', 'agrocalidad', 'postgres', 'pgC4l1d4d');

    $cMAg = new ControladorMagBanano();
    $cm = new ControladorMonitoreo();
    
    $fecha = date('Y-m-d');
    
    // $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_DATO_CGINA_BANANO');

    if(1){
    // if($resultadoMonitoreo){
    	/// INICIO OPERADOES BANANO ///
    	
    	$datosUsuario = $cMAg->obtenerInformacionUsuarios($conexionMag, $fecha);
		echo("<br/>total registros operadores_:".pg_num_rows($datosUsuario)."<br/>");
    	
    	$valores = '';
    	
    	while ($filas = pg_fetch_row($datosUsuario)) {
    		
    		if ($filas[14]=='A'){
    			$filas[14]='Por atender';
    		} else{
    			$filas[14]='Por inactivar';
    		}
    		
    		$valores .= "('$filas[0]','$filas[1]','$filas[2]','$filas[3]','$filas[4]','$filas[5]','$filas[6]','$filas[7]','$filas[8]','$filas[9]'
                    ,'$filas[10]','$filas[11]','$filas[12]','individual','$filas[14]','now()',md5('$filas[1]')),";
    	}
    	
    	$valores = trim($valores, ',');
    	
    	if ($valores != '') {
    		
    		echo '<br/> >>>>Actualizacion de operadores de banano';
    		$cMAg->actualizarOperadoresBanano($conexion, $valores);
    		echo '<br/> <<< Fin de actualizacion de operadores de banano<br/>';
    		
    		echo '<br/> >>>>Ingreso de nuevos operdores de banano';
    		$cMAg->insertarOperadoresBanano($conexion, $valores);
    		echo '<br/> >>>>Fin de nuevos operdores de banano<br/>';
    	}
    	
    	/////// FIN OPERADORES BANANO
    	
    	
    	
    	/////// INICIO PROVEEDROES BANANO //////
    	
    	$datosProveedores = $cMAg->obtenerProveedores($conexionMag, $fecha);

		echo("<br/>total registros proveedores_:".pg_num_rows($datosProveedores)."<br/>");
    	
    	$valores = '';
    	
    	while ($filas = pg_fetch_row($datosProveedores)) {
    		
    		if ($filas[3]=='A'){
    			$filas[3]='Por atender';
    		} else{
    			$filas[3]='Por inactivar';
    		}
    		
    		$valores .= "('$filas[0]','$filas[1]','$filas[2]','$filas[3]','now()'),";
    	}
    	
    	$valores = trim($valores, ',');
    	
    	if ($valores != '') {


    		
    		echo '<br/> >>>>Actualizacion de proveedores de banano';
    		$cMAg->actualizarPorveedoresbanano($conexion, $valores);
    		echo '<br/> <<< Fin de actualizacion de proveedores de banano<br/>';
    		
    		echo '<br/> >>>>Ingreso de nuevos proveedores de banano';
    		$cMAg->insertarProveedores($conexion, $valores);
    		echo '<br/> >>>>Fin de nuevos proveedores de banano<br/>';
    	}
    	
    	///// FIN PROVEEDROES BANANO //////
    	
    	
    	
    	///// INICIO OPERACIONES BANANO //////
    	
    	$datosOperaciones = $cMAg->obtenerRegistroOperador($conexionMag, $fecha);
		echo("<br/>total registros operaciones_prueba_:".pg_num_rows($datosOperaciones)."<br/>");
    	
    	$valores = '';
    	
    	while ($filas = pg_fetch_row($datosOperaciones)) {
    		
    		// if ($filas[15]=='A'){
    		if ($filas[18]=='ACTIVO'){
    			$filas[15]='Por atender';
    		} else{
    			$filas[15]='Por inactivar';
    		}
		
			if(is_null($filas[2])){
				$filas[2] = 0;
			}
			
			if(is_null($filas[11])){
				$filas[11] = 0;
			}
		
			if (mb_strtolower($filas[10]) != 'lugar de producción') {
				$filas[10] = utf8_decode($filas[10]);
			 }
    		
    		$valores .= "('$filas[0]','$filas[1]','$filas[2]','$filas[3]','$filas[4]','$filas[5]','$filas[6]',substr('$filas[7]',0,10),'$filas[8]','$filas[9]'
                    ,'$filas[10]','$filas[11]','$filas[12]','$filas[13]','$filas[14]','$filas[15]','$filas[16]','now()'),";

					
					
    	}
    	
    	$valores = trim($valores, ',');
    	
    	if ($valores != '') {
			
				echo '<br/> >>>>Ingreso de nuevas operaciones de banano';
    			$cMAg->insertarOperacionesBanano($conexion, $valores);
    			echo '<br/> >>>>Fin de nuevas operaciones de banano<br/>';

				echo '<br/> >>>>Actualizacion de operaciones banano';
    			$cMAg->actualizarOperacionesBanano($conexion, $valores);
    			echo '<br/> <<< Fin de actualizacion de operaciones de banano<br/>';
			
    			
			
    	}
    	
    	/////// FIN OPERACIONES BANANO //////
    	
    }

}else{
	
	$minutoS1 = microtime(true);
	$minutoS2 = microtime(true);
	$tiempo = $minutoS2 - $minutoS1;
	$xcadenota = "FECHA " . date("d/m/Y") . " " . date("H:i:s");
	$xcadenota .= "; IP REMOTA " . $_SERVER['REMOTE_ADDR'];
	$xcadenota .= "; SERVIDOR HTTP " . $_SERVER['HTTP_REFERER'];
	$xcadenota .= "; SEGUNDOS " . $tiempo . "\n";
	$arch = fopen("../../../aplicaciones/logs/cron/automatico_datos_cgina_banano" . date("d-m-Y") . ".txt", "a+");
	fwrite($arch, $xcadenota);
	fclose($arch);
}
