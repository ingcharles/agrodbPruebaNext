<?php

if($_SERVER['REMOTE_ADDR'] == ''){
//if(1){
    require_once '../../../clases/Conexion.php';
    require_once '../../../clases/ControladorMonitoreo.php';
    require_once '../../../clases/ControladorReportesMag.php';
    
    $conexion = new Conexion();
    $cm = new ControladorMonitoreo();
    $conexionBdFrontera = new Conexion('192.168.200.13', '5432', 'agrocalidad', 'postgres', 'pgC4l1d4d');
    $reportesMag = new ControladorReportesMag();
    
    define ( 'IN_MSG', '<br/> >>> ' );
    define ( 'OUT_MSG', '<br/> <<< ' );
    define ( 'PRO_MSG', '<br/> &emsp;&emsp;... ' );
    
    $fecha = date("Y-m-d h:m:s");
    $fecha1= date('Y-m-d h:m:s', strtotime("-1 day", strtotime($fecha)));
   
   $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_REP_MAG');
    if($resultadoMonitoreo){
   // if(1){
        
        echo '<h1>VERIFICACION DE REGISTRO OPERADORES SANIDAD ANIMAL</h1>';
        echo IN_MSG .'<b>INICIO PROCESO SELECCION OPERADORES REGISTRADO SANIDAD ANIMAL'.$fecha.'</b></p>';
        $qRegistroOperadorSa = $reportesMag->obtenerReporteRegistroOperadorSA($conexion,$fecha1,$fecha);
        
            while ($filas = pg_fetch_row($qRegistroOperadorSa)){
               
                $resultArray .="{'razon_social': '$filas[1]',
                            'nombre_representante': '$filas[2]',
                            'estado_operador': '$filas[9]',
                            'tipo_operacion': '$filas[17]',
                            'parroquia': '$filas[31]',
                            'canton': '$filas[32]',
                            'provincia': '$filas[33]',
                            'superficie': '$filas[23]'
                             },";
            }
             $resultArray = str_replace("'", "\"", $resultArray);
             $valoresNuevos = trim($resultArray, ',');
        if($valoresNuevos!=null){
             echo IN_MSG .'<b>INICIO PROCESO REGISTRO DATOS BASE FRONTERA'.$fecha.'</b></p>';
            $reportesMag->insertarOperadoresMagSA($conexionBdFrontera, $valoresNuevos);
        }else{        
            echo '</p>'.OUT_MSG .'<b>NO HAY OPERADORES NUEVOS REGISTRADOS SANIDAD ANIMAL '.$fecha.'</b>';
        }

        echo '</p>'.OUT_MSG .'<b>FIN DEL PROCESO DE OPERADORES SANIDAD ANIMAL '.$fecha.'</b>';
        echo '</p>'.OUT_MSG .'<b>*********************'.$fecha.'</b>';
        echo '<h1>VERIFICACION DE REGISTRO OPERADORES SANIDAD VEGETAL</h1>';
        echo IN_MSG .'<b>INICIO PROCESO SELECCION OPERADORES REGISTRADO SANIDAD VEGETAL'.$fecha.'</b></p>';
        $qRegistroOperadorSv = $reportesMag->obtenerReporteRegistroOperadorSV($conexion,$fecha1,$fecha);
       
            while ($filas = pg_fetch_row($qRegistroOperadorSv)){
               
                $resultArrayOpSv .="{'razon_social': '$filas[1]',
                            'nombre_representante': '$filas[2]',
                            'estado_operador': '$filas[9]',
                            'tipo_operacion': '$filas[17]',
                            'parroquia': '$filas[31]',
                            'canton': '$filas[32]',
                            'provincia': '$filas[33]',
                            'superficie': '$filas[23]'
                             },";
            }
             $resultArrayOpSv = str_replace("'", "\"", $resultArrayOpSv);
             $valoresNuevosOpSv = trim($resultArrayOpSv, ',');
        if($valoresNuevosOpSv!=null){
             echo IN_MSG .'<b>INICIO PROCESO REGISTRO DATOS BASE FRONTERA'.$fecha.'</b></p>';
            $reportesMag->insertarOperadoresMagSV($conexionBdFrontera, $valoresNuevosOpSv);
        }else{        
            echo '</p>'.OUT_MSG .'<b>NO HAY OPERADORES NUEVOS REGISTRADOS '.$fecha.'</b>';
        }
        echo '</p>'.OUT_MSG .'<b>FIN DEL PROCESO DE OPERADORES '.$fecha.'</b>';
  
        //Proceso de certificado Exportacion sv
        echo '</p>'.OUT_MSG .'<b>*********************'.$fecha.'</b>';
        echo '<h1>VERIFICACION DE CERTIFICADO DE EXPORTACION SANIDAD VEGETAL</h1>';
        echo IN_MSG .'<b>INICIO PROCESO SELECCION CERTIFICADO DE EXPORTACION SANIDAD VEGETAL'.$fecha.'</b></p>';
        $qRegistroCertificadoExportacionSv = $reportesMag->obtenerReporteCertificadoExportacionSV($conexion,$fecha1,$fecha);
       
            while ($filas = pg_fetch_row($qRegistroCertificadoExportacionSv)){
               
                $resultArrayExpSv .="{'nombre_producto': '$filas[21]',
                            'puerto_origen': '$filas[8]',
                            'transporte': '$filas[9]',
                            'pais_destino': '$filas[4]',
                            'puerto_destino': '$filas[3]',
                            'numero_bulto': '$filas[22] $filas[23]',
                            'cantidad': '$filas[24] $filas[25]'
                             },";
            }
             $resultArrayExpSv = str_replace("'", "\"", $resultArrayExpSv);
             $valoresNuevosExpSv = trim($resultArrayExpSv, ',');
             if($valoresNuevosExpSv!=null){
                echo IN_MSG .'<b>INICIO PROCESO REGISTRO DATOS BASE FRONTERA'.$fecha.'</b></p>';
                $reportesMag->insertarCertificadoExportacionMagSV($conexionBdFrontera, $valoresNuevosExpSv);
             }else{
                echo IN_MSG .'<b> NO HAY DATA'.$fecha.'</b></p>';
             }
        echo '</p>'.OUT_MSG .'<b>FIN DEL CERTIFICADOS DE EXPORTACION SV '.$fecha.'</b>';
        
        
        //Proceso de certificado Importacion Sv
        echo '</p>'.OUT_MSG .'<b>*********************'.$fecha.'</b>';
        echo '<h1>VERIFICACION DE CERTIFICADO DE IMPORTACION SANIDAD VEGETAL</h1>';
        echo IN_MSG .'<b>INICIO PROCESO SELECCION CERTIFICADO DE IMPORTACION SANIDAD VEGETAL'.$fecha.'</b></p>';
        $qRegistroCertificadoImportacionSv = $reportesMag->obtenerReporteCertificadoImportacionSV($conexion,$fecha1,$fecha);
      
            while ($filas = pg_fetch_row($qRegistroCertificadoImportacionSv)){
               
                $resultArrayImpSv .="{'razon_social': '$filas[1]',
                            'nombre_producto': '$filas[5]',
                            'subtipo_producto': '$filas[4]',
                            'pais_origen': '$filas[10]',
                            'peso': '$filas[8] $filas[9]',
                            'numero_pfi': '$filas[16]'
                             },";
            }
             $resultArrayImpSv = str_replace("'", "\"", $resultArrayImpSv);
             $valoresNuevosImpSv = trim($resultArrayImpSv, ',');
                if($valoresNuevosImpSv!=null){
                    echo IN_MSG .'<b>INICIO PROCESO REGISTRO DATOS BASE FRONTERA'.$fecha.'</b></p>';
                    $reportesMag->insertarCertificadoImportacionSV($conexionBdFrontera, $valoresNuevosImpSv);    
                }
                else{
                echo IN_MSG .'<b> NO HAY DATA'.$fecha.'</b></p>';
                }
        echo '</p>'.OUT_MSG .'<b>FIN DEL CERTIFICADOS DE IMPORTACION SV '.$fecha.'</b>';
       

    //reporte importacion_sanidad_animmal
 
         echo '</p>'.OUT_MSG .'<b>*********************'.$fecha.'</b>';
         echo '<h1>VERIFICACION DE CERTIFICADO DE IMPORTACION SANIDAD ANIMAL</h1>';
         echo IN_MSG .'<b>INICIO PROCESO SELECCION CERTIFICADO DE IMPORTACION SANIDAD ANIMAL'.$fecha.'</b></p>';
         $qRegistroCertificadoImportacionSa = $reportesMag->obtenerReporteCertificadoImportacionSA($conexion,$fecha1,$fecha);
        
             while ($filas = pg_fetch_row($qRegistroCertificadoImportacionSa)){
                
                 $resultArrayImpSa .="{'razon_social': '$filas[1]',
                             'tipo_producto': '$filas[4]',
                             'subtipo_producto': '$filas[5]',
                             'nombre_producto': '$filas[6]',
                             'partida_arancelaria': '$filas[7]',
                             'cantidad_producto': '$filas[8] $filas[9]',
                             'peso_producto': '$filas[10] $filas[11]',
                             'licencia_mag': '$filas[10]',
                             'pais_origen': '$filas[13]',
                             'razon_exportador': '$filas[14]',
                             'identificador_vue': '$filas[19]',
                             'valor_fob': '$filas[20]',
                             'estado': '$filas[27]'
                              },";
             }
              $resultArrayImpSa = str_replace("'", "\"", $resultArrayImpSa);
              $valoresNuevosImpSa = trim($resultArrayImpSa, ',');
              if($valoresNuevosImpSa!=null){
                echo IN_MSG .'<b>INICIO PROCESO REGISTRO DATOS BASE FRONTERA'.$fecha.'</b></p>';
                $reportesMag->insertarCertificadoImportacionSA($conexionBdFrontera, $valoresNuevosImpSa);
              }
              else{
                echo IN_MSG .'<b> NO HAY DATA'.$fecha.'</b></p>';
              }
         
         echo '</p>'.OUT_MSG .'<b>FIN DEL CERTIFICADOS DE IMPORTACION SA'.$fecha.'</b>';
       

    // //     //Proceso de certificado Exportacion Sa
         echo '</p>'.OUT_MSG .'<b>*********************'.$fecha.'</b>';
         echo '<h1>VERIFICACION DE CERTIFICADO DE EXPORTACION SANIDAD ANIMAL</h1>';
         echo IN_MSG .'<b>INICIO PROCESO SELECCION CERTIFICADO DE EXPORTACION SANIDAD ANIMAL'.$fecha.'</b></p>';
         $qRegistroCertificadoExportacionSa = $reportesMag->obtenerReporteCertificadoExportacionSA($conexion,$fecha1,$fecha);
         
             while ($filas = pg_fetch_row($qRegistroCertificadoExportacionSa)){
                
                 $resultArrayExpSa .="{'id_vue': '$filas[0]',
                                 'fecha_creacion': '$filas[1]',
                                 'nombre_operador': '$filas[3]',
                                 'pais_destino': '$filas[5]',
                                 'puerto_embarque': '$filas[7]',
                                 'patida_arancelaria': '$filas[10]',
                                 'nombre_producto': '$filas[11]',
                                 'cantidad': '$filas[12] $filas[13]',
                                 'provincia': '$filas[19]',
                                 'estado': '$filas[21]'
                                 },";
             }
              $resultArrayExpSa = str_replace("'", "\"", $resultArrayExpSa);
              $valoresNuevosExpSa = trim($resultArrayExpSa, ',');
              if($valoresNuevosExpSa!=null){
                echo IN_MSG .'<b>INICIO PROCESO REGISTRO DATOS BASE FRONTERA'.$fecha.'</b></p>';
                $reportesMag->insertarCertificadoExportacionSA($conexionBdFrontera, $valoresNuevosExpSa);
              }else{
                echo IN_MSG .'<b> NO HAY DATA'.$fecha.'</b></p>';
              }
         echo '</p>'.OUT_MSG .'<b>FIN DEL CERTIFICADOS DE EXPORTACION SA'.$fecha.'</b>';

       //operadores certificados BPA
              echo '</p>'.OUT_MSG .'<b>*********************'.$fecha.'</b>';
              echo '<h1>VERIFICACION DE CERTIFICADO BPA OPERADORES</h1>';
              echo IN_MSG .'<b>INICIO PROCESO SELECCION CERTIFICADO BPA OPERADORES'.$fecha.'</b></p>';
              $qRegistroCertificadoBpaOperadores = $reportesMag->obtenerReporteOperadoresCertificadosBPA($conexion,$fecha1,$fecha);
                  while ($filas = pg_fetch_row($qRegistroCertificadoBpaOperadores)){
                      $resultArrayCerBpa .="{'razon_social': '$filas[0]',
                                      'provincia': '$filas[1]',
                                      'canton': '$filas[2]',
                                      'parroquia': '$filas[3]',
                                      'tipo_certificado': '$filas[4]',
                                      'nombre_producto': '$filas[5]',
                                      'nombre_area': '$filas[6]',
                                      'operacion': '$filas[7]',
                                      'estado': '$filas[8]',
                                      'area': '$filas[9]'
                                      },";
                  }
                   $resultArrayCerBpa = str_replace("'", "\"", $resultArrayCerBpa);
                   $valoresNuevosCerBpa = trim($resultArrayCerBpa, ',');
                   if($valoresNuevosCerBpa!=null){
                    echo IN_MSG .'<b>INICIO PROCESO REGISTRO DATOS BASE FRONTERA'.$fecha.'</b></p>';
                     $reportesMag->insertarOperadoresCertificadoBPA($conexionBdFrontera, $valoresNuevosCerBpa);
                   }else{
                    echo IN_MSG .'<b> NO HAY DATA'.$fecha.'</b></p>';
                   }
              echo '</p>'.OUT_MSG .'<b>FIN DEL CERTIFICADO BPA OPERADORES'.$fecha.'</b>';
            
    }
}else{
    $minutoS1=microtime(true);
    $minutoS2=microtime(true);
    $tiempo=$minutoS2-$minutoS1;
    $xcadenota = "FECHA ".date("d/m/Y")." ".date("H:i:s");
    $xcadenota.= "; IP REMOTA ".$_SERVER['REMOTE_ADDR'];
    $xcadenota.= "; SERVIDOR HTTP ".$_SERVER['HTTP_REFERER'];
    $xcadenota.= "; SEGUNDOS ".$tiempo."\n";
    $arch = fopen("../../../aplicaciones/logs/cron/verificar_operacion_OCC_".date("d-m-Y").".txt", "a+");
    fwrite($arch, $xcadenota);
    fclose($arch);
    
}
?>