<?php

//if($_SERVER['REMOTE_ADDR'] == ''){
if(1){
    require_once '../../../clases/Conexion.php';
    require_once '../../../clases/ControladorMonitoreo.php';
    require_once '../../../clases/ControladorCatastroProducto.php';
    
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    set_time_limit(300);
    
    $conexion = new Conexion();
    $cm = new ControladorMonitoreo();
    $ccp = new ControladorCatastroProducto();
    
    define('PRO_MSG', '<br/> ');
    define('IN_MSG','<br/> >>> ');
    $fecha = date("Y-m-d h:m:s");
    
    //$resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_INACT_DET_CATA');//TODO: Crear nuevo código de cron en base de datos "CRON_INACT_DET_CATA"
    //if($resultadoMonitoreo){
    if(1){
        
        echo IN_MSG .'<b>INICIO PROCESO DE ACTUALIZACIÓN DE IDENTIFICADORES '.$fecha.'</b>';
        
        $ccp->insertarIdenificadoresDuplicados($conexion);
        
        //Obtener catastro de los identificadores únicos repetidos
        
        $qIdentificadoresCatastroRepetidos = $ccp->obtenerCatastrosRepetidosConAreas($conexion);
        $contador = 0;
        while($identificadoresCatastroRepetidos = pg_fetch_assoc($qIdentificadoresCatastroRepetidos)){            
            //echo $contador = $contador + 1;
           // echo " - ";
            //echo $identificadoresCatastroRepetidos['identificador_unico_producto'];
            //echo "</br>";
            $idCatastro = $identificadoresCatastroRepetidos['id_catastro'];
            $idArea = $identificadoresCatastroRepetidos['id_area'];
            //$anio = $identificadorescatastroRepetidos['identificador_unico_producto'];            
            //$anio = substr(strstr($anio, "-"), 1, 2);
            $secuencialRepetido = $identificadoresCatastroRepetidos['secuencial'];   
            $identificadorRepetido = $identificadoresCatastroRepetidos['identificador_unico_producto'];     
            $anio = date("y");
            
            
           
            
            $qVericarSecuencial = $ccp->verificarSecuenciaCatastro($conexion, $idArea, $anio);
            $verificarSecuencial = pg_fetch_result($qVericarSecuencial, 0, 'secuencia_final');
            
            /*if(pg_num_rows($qVericarSecuencial))
            {
                $verificarSecuencial = pg_fetch_result($qVericarSecuencial, 0, 'secuencia_final');
            }else{
                $verificarSecuencial = "";
            }*/

            // Verifica si existe la serie en la tabla de secuencia
            if ($verificarSecuencial != null || $verificarSecuencial != '') {
                
                // Obtengo la secuencia final por año y área de la tabla de secuencias
                $secuencialInicial = pg_fetch_result($qVericarSecuencial, 0, 'secuencia_final');
                $secuencialFinal = $secuencialInicial + 1;
                
            }else{
                
                // Obtengo la secuencia final por año y área de la tabla de detalle de catastros
                $secuencialInicial = $ccp->autogenerarSecuencialDetalleCatastroProducto($conexion, $idArea);
                $secuencialFinal = $secuencialInicial + 1;
                
            }
            
            //echo $contador = $contador + 1; 
            // Inserto la secuencia en la tabla de secuencias
            $qInsertarSecuencia = $ccp->insertarSecuencialCatastroSecuencia($conexion, $idArea, $anio, $secuencialInicial, $secuencialFinal - 1);
            
            //for ($k = $secuencialInicial; $k < $secuencialFinal; $k ++) {
                
                $secuencialProducto = str_pad($secuencialInicial, 6, "0", STR_PAD_LEFT);
                $identificadorUnico = $idArea . '-' . date('y') . '-' . $secuencialProducto;
               
                $ccp->insertarTablaActualizacionesRealizadas($conexion, $idCatastro, $secuencialRepetido, $identificadorRepetido, $secuencialProducto, $identificadorUnico);
                
                $ccp->actualizaridentificadorUnicoProducto($conexion, $idCatastro, $identificadorRepetido, $secuencialProducto, $identificadorUnico);
            //}
            
            //$verificarSecuencial = pg_fetch_result($qVericarSecuencial, 0, 'secuencia_final');
            
            //echo "</br>";
            //echo $ccp->autogenerarSecuencialDetalleCatastroProductoII($conexion, $idArea, $anio); echo "</br>";
            
        }
        
       /* 
        $path = '412783-20-031232';
        $filename = substr(strstr($path, "-"), 1, 2);
        echo $filename; // "index.html"*/
        
        echo IN_MSG .'<b>FIN DEL PROCESO DE INACTIVACION DE REGISTRO TEMPORAL '.$fecha.'</b>';
        
        
    }
}else{
    $minutoS1=microtime(true);
    $minutoS2=microtime(true);
    $tiempo=$minutoS2-$minutoS1;
    $xcadenota = "FECHA ".date("d/m/Y")." ".date("H:i:s");
    $xcadenota.= "; IP REMOTA ".$_SERVER['REMOTE_ADDR'];
    $xcadenota.= "; SERVIDOR HTTP ".$_SERVER['HTTP_REFERER'];
    $xcadenota.= "; SEGUNDOS ".$tiempo."\n";
    $arch = fopen("../../../aplicaciones/logs/cron/catastro_estado_inactivo_".date("d-m-Y").".txt", "a+");
    fwrite($arch, $xcadenota);
    fclose($arch);
    
}
?>