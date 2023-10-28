<?php

if($_SERVER['REMOTE_ADDR'] == ''){
//if(1){
    require_once '../../../clases/Conexion.php';
    require_once '../../../clases/ControladorMonitoreo.php';
    require_once '../../../clases/ControladorVehiculos.php';
    
    $conexion = new Conexion();
    $cm = new ControladorMonitoreo();
    $cv = new ControladorVehiculos();
    
    define('PRO_MSG', '<br/> ');
    define('IN_MSG','<br/> >>> ');
    $fecha = date("Y-m-d h:m:s");
    
    $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_MATRIC_CADUCADO');
    if($resultadoMonitoreo){
    //if(1){
        
        echo IN_MSG .'<b>INICIO PROCESO DE INACTIVACION DE MATRÍCULA CADUCADA '.$fecha.'</b>';
        
        $res = $cv->buscarMatriculasCaducadas($conexion);
        
        while ($vehiculo = pg_fetch_assoc($res)) {
            $cv->cambioEstadoMatriculacionCaducado($conexion, $vehiculo['id_matriculacion']);
            $cv->actualizarEstadoVehiculo($conexion, $vehiculo['placa'], 'Matriculacion');
        }
        
        echo IN_MSG .'<b>FIN DEL PROCESO DE INACTIVACION DE MATRÍCULA CADUCADA '.$fecha.'</b>';
        
    }
}else{
    $minutoS1=microtime(true);
    $minutoS2=microtime(true);
    $tiempo=$minutoS2-$minutoS1;
    $xcadenota = "FECHA ".date("d/m/Y")." ".date("H:i:s");
    $xcadenota.= "; IP REMOTA ".$_SERVER['REMOTE_ADDR'];
    $xcadenota.= "; SERVIDOR HTTP ".$_SERVER['HTTP_REFERER'];
    $xcadenota.= "; SEGUNDOS ".$tiempo."\n";
    $arch = fopen("../../../aplicaciones/logs/cron/cambiar_estado_matriculacion_caducado_".date("d-m-Y").".txt", "a+");
    fwrite($arch, $xcadenota);
    fclose($arch);
    
}
?>