<?php
 if ($_SERVER['REMOTE_ADDR'] == ''){
    require_once '../../../clases/Conexion.php';
	require_once '../../../clases/ControladorMonitoreo.php';
    require_once '../../../clases/ControladorMail.php';
	require_once '../../../clases/ControladorEnvioTokenCliente.php';
    require_once '../../../clases/ControladorMonitoreo.php';
	$conexion = new Conexion();
	$cMail = new ControladorMail();
	$cenvioToken = new ControladorEnvioTokenCliente();
	$cm = new ControladorMonitoreo();
	$fecha = date('Y-m-d');
    $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_UPDATE_TOKEN');
    if ($resultadoMonitoreo){
        echo '<br/> >>>>Inicio el proceso de generacion de nuevo token para clientes->>actulizarTokenClientesbr/>';
        $datosTokenActulizado = $cenvioToken->actulizarTokenClientes($conexion);
        echo '<br/> >>>>Fin del proceso de generacion de nuevo token para clientes<<<--actulizarTokenClientesbr/>';
        if(pg_num_rows($datosTokenActulizado)>0){
            echo '<br/> >>>>si hay nuevos Tokens br/>';
            define('IN_MSG','<br/> >>> ');
            $asunto = 'Agrocalidad - Token para el consumo de servicios web.';
            while ($fila = pg_fetch_assoc($datosTokenActulizado)){
                $cuerpoMensaje =  $cenvioToken->cuerpoCorreo($fila['token']);
                $destinatario = array();
			    if($fila['correo']!= ''){
				array_push($destinatario, $fila['correo']);
			    }
                $fecha = date("Y-m-d h:m:s");
                echo IN_MSG . $fecha;
                $estadoMail = $cMail->enviarMail($conexion, $destinatario, $asunto, $cuerpoMensaje);
                echo IN_MSG . 'Actualización estado correo electronico.'.$estadoMail.'';
            }
        }else{
            echo '<br/> >>>>No se generaron Tokens br/>';
        }

        echo '<br/> >>>>Fin del proceso de Actulizacion y generacion de Tokens br/>';
    }

 } else{

 	$minutoS1=microtime(true);
 	$minutoS2=microtime(true);
 	$tiempo=$minutoS2-$minutoS1;
 	$xcadenota = "FECHA ".date("d/m/Y")." ".date("H:i:s");
 	$xcadenota.= "; IP REMOTA ".$_SERVER['REMOTE_ADDR'];
 	$xcadenota.= "; SERVIDOR HTTP ".$_SERVER['HTTP_REFERER'];
 	$xcadenota.= "; SEGUNDOS ".$tiempo."\n";
 	$arch = fopen("../../../aplicaciones/logs/cron/envioTokenClientes_".date("d-m-Y").".txt", "a+");
 	fwrite($arch, $xcadenota);
 	fclose($arch);

 }
?>