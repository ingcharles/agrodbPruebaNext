<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorReportes.php';
require_once '../controladores/ControladorMuestra.php';

$conexion = new Conexion();

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

$id_requerimiento=$_POST['id'];

///JASPER///

//Ruta del reporte compilado por Jasper y generado por IReports

// $jru = new ControladorReportes();
$jru = new ControladorReportes(false);
$controladorMuestra= new ControladorMuestra(null);
$banderaReporte = $controladorMuestra->getMuestraXIdRequerimiento($id_requerimiento);

// $laboratorio->getIcMuestraId()
$reporteMostrar ='';
if($banderaReporte){
    $filename = $id_requerimiento.'-360_caso.pdf';
    $ReporteJasper='aplicaciones/inocuidad/reportes/360_caso.jrxml';
    $salidaReporte = 'aplicaciones/inocuidad/archivos_reportes/'.$filename;
    $rutaSubreporte = $constg::RUTA_SERVIDOR_OPT.'/'.$constg::RUTA_APLICACION.'/aplicaciones/inocuidad/reportes/';

    $parameters['parametrosReporte'] = array(
        'requerimiento_id' => $id_requerimiento,
        'SUBREPORT_DIR' => $rutaSubreporte
    );

    //CAMBIAR RUTA IMAGEN
    $jru->generarReporteJasper($ReporteJasper,$parameters,$conexion,$salidaReporte,'ninguno');
    $reporteMostrar ='<embed id="visor" src='.$salidaReporte.' width="540" height="900">';
}else{
    $reporteMostrar ='<div class="mensajeInicial">Lo sentimos no podemos mostrar el Reporte...!</div>';
}

?>

<div id="reporte">
    <?php
    echo $reporteMostrar;
    ?>
</div>