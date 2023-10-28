<?php
require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorCatastroProducto.php';
//if($_SERVER['REMOTE_ADDR'] == ''){
    if(1){

    
    $conexion = new Conexion();
    //$cm = new ControladorMonitoreo();
    $ccp = new ControladorCatastroProducto();
    
    define('PRO_MSG', '<br/> ');
    define('IN_MSG','<br/> >>> ');
    $fecha = date("Y-m-d h:m:s");
    
    
    
    //$resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_INACT_DET_CATA');//TODO: Crear nuevo código de cron en base de datos "CRON_INACT_DET_CATA"
    //if($resultadoMonitoreo){
        if(1){
        
            
            echo IN_MSG .'<b>INICIO PROCESO DE ELIMINAR CATASTRO '.$fecha.'</b>';
            

               
            $idCatastro = 4236657;

                    $qCatastroIndividual = $ccp->cantidadCatastroIndividualActivo($conexion, $idCatastro);
                    $filaCatastro = pg_fetch_assoc($qCatastroIndividual);
                    
                    
                    //TODO: Actualizacion estado aretes
                    $qIdentificadoresProducto=$ccp->actualizarIdentificadoresProducto($conexion, $idCatastro);
                    
                    //reproduccion
                    $idProductoReproduccion=pg_fetch_result($ccp->obtenerIdProductoXCodigoProducto($conexion, 'PORDRE'),0,'id_producto');
                    $idProductoLechon=pg_fetch_result($ccp->obtenerIdProductoXCodigoProducto($conexion, 'PORHON'),0,'id_producto');
                    $idProductoLechona=pg_fetch_result($ccp->obtenerIdProductoXCodigoProducto($conexion, 'PORONA'),0,'id_producto');
                    
                    $identificadorOperador=pg_fetch_result($ccp->abrirSitio($conexion, $filaCatastro['id_sitio']), 0, 'identificador_operador');
                    $qObtenerMaximoControlReproduccion=$ccp->obtenerMaximoControlReproduccion($conexion, $identificadorOperador,$idProductoReproduccion);
                    $qCantidadCatastro=$ccp->obtenerCantidadCatastroXOperador($conexion,  $identificadorOperador, '('.$idProductoReproduccion.')');
                    
                    $qCantidadCatastroCrias=$ccp->obtenerCantidadCatastroXOperador($conexion, $identificadorOperador, '('.$idProductoLechon.','.$idProductoLechona.')');
                    
                    $cantidadCria=pg_fetch_result($qCantidadCatastroCrias, 0, 'cantidad');
                    
                    if($filaCatastro['id_producto']==$idProductoReproduccion){
                        
                        $cantidadReproduccion=pg_num_rows($qIdentificadoresProducto)*28;
                        
                        if (pg_num_rows($qObtenerMaximoControlReproduccion)!=0){
                            $cupoCria=pg_fetch_result($qObtenerMaximoControlReproduccion, 0, 'cupo_cria')-$cantidadReproduccion;
                            $cantidadCriaB=pg_fetch_result($qObtenerMaximoControlReproduccion, 0, 'cantidad_cria');
                        }else{
                            $cantidadCriaB=$cantidadCria;
                            $cupoCria=(pg_fetch_result($qCantidadCatastro, 0, 'cantidad')*28)-$cantidadReproduccion;
                        }
                        
                        if($cupoCria<0)
                            $cupoCria=0;
                            
                            $ccp->guardarControlReproduccion($conexion, $identificadorOperador, $idProductoReproduccion, $cupoCria,$cantidadCriaB);
                            
                    }else if($filaCatastro['id_producto']==$idProductoLechon || $filaCatastro['id_producto']==$idProductoLechona){
                        
                        
                        $cantidadReproduccion=pg_num_rows($qIdentificadoresProducto);
                        $cantidadMadre=pg_fetch_result($qCantidadCatastro, 0, 'cantidad');
                        
                        
                        if (pg_num_rows($qObtenerMaximoControlReproduccion)!=0){
                            $cupoCria=pg_fetch_result($qObtenerMaximoControlReproduccion, 0, 'cupo_cria');
                            if ($cantidadMadre==0 && $cupoCria==0)
                                $cupoCria=0;
                                else
                                    $cupoCria=pg_fetch_result($qObtenerMaximoControlReproduccion, 0, 'cupo_cria')+$cantidadReproduccion;
                                    
                                    $cantidadCriaB=pg_fetch_result($qObtenerMaximoControlReproduccion, 0, 'cantidad_cria')-$cantidadReproduccion;
                        }else{
                            
                            $cupoCria=($cantidadMadre*28)+$cantidadReproduccion;
                            
                            $cantidadCriaB=$cantidadCria-$cantidadReproduccion;
                        }
                        if($cupoCria<0)
                            $cupoCria=0;
                            
                            if($cantidadCriaB<0)
                                $cantidadCriaB=0;
                                
                                $ccp->guardarControlReproduccion($conexion, $identificadorOperador, $idProductoReproduccion, $cupoCria,$cantidadCriaB);
                    }
                    
                    
                    
                    //TODO: Busco el ultima transaccion de catastro para sacar la cantidad total
                    $qConsultarCantidadTotalProducto = $ccp->consultarCantidadTotalProducto($conexion, $filaCatastro['id_area'], $filaCatastro['id_producto'],$filaCatastro['unidad_comercial'],$filaCatastro['id_tipo_operacion']);
                    
                    $cantidadTotal =  (pg_num_rows($qConsultarCantidadTotalProducto)!=0 ? pg_fetch_result($qConsultarCantidadTotalProducto, 0, 'cantidad_total'):0) - $filaCatastro['cantidad'];
                    
                    //TODO: Busco el concepto del catstro del tipo de transacion a realizar
                    $qConsultaConceptoCatastroXCodigo=$ccp->consultaConceptoCatastroXCodigo($conexion, 'ELCA');
                    $filaConcepto = pg_fetch_assoc($qConsultaConceptoCatastroXCodigo);
                    $idConceptoCatastro=$filaConcepto['id_concepto_catastro'];
                    
                    //TODO: Guarda los datos de la transacion total de catastro
                    $ccp->guardarCatastroTransaccionResta($conexion, $idCatastro,$filaCatastro['id_area'], $idConceptoCatastro,  $filaCatastro['id_producto'], $filaCatastro['cantidad'], $cantidadTotal,$filaCatastro['unidad_comercial'],$_SESSION['usuario'],$filaCatastro['id_tipo_operacion']);
                    
                    
                    $qIdentificadoresProductos=$ccp->actualizarIdentificadoresProducto($conexion, $idCatastro);
                    while ($filaIdentificadores = pg_fetch_assoc($qIdentificadoresProductos)){
                        $ccp->actualizarIdentificadorProducto($conexion, $filaIdentificadores['identificador_producto'], 'creado');
                    }
                    
                    $ccp->eliminarDetalleCatastro($conexion, $idCatastro);
                    $ccp->eliminarCatastro($conexion, $idCatastro);
     
                    echo IN_MSG .'<b>FIN PROCESO DE ELIMINAR CATASTRO '.$fecha.'</b>';
                    
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