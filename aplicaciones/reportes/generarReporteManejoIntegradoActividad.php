<?php
session_start();

require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorReportesCSV.php';

header("Content-type: application/octet-stream");
//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=REPORTE_MANEJO_INTEGRADO_ACTIVIDAD.xls");
//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

$conexion = new Conexion();
$cr = new ControladorReportesCSV();

$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$tituloReporte='REPORTE MANEJO INTEGRADO ACTIVIDAD';

$cabecera = "";
$detalle = "";     
        $res = $cr->generarReporteActividadManejoIntegrado($conexion, $fechaInicio,$fechaFin);
      
            $cabecera = '<thead>                
                <tr>
                    <th>Cédula Técnico</th>
                    <th>Provincia</th>		
                    <th>Canton</th>
                    <th>Parroquia</th>			
                    <th>Coordenada X</th>
                    <th>Coordenada Y</th>
                    <th>Coordenada Z</th>
                    <th>Fecha</th>
                    <th>Semana</th>                   
                    <th>Accion Mip</th>
                    <th>MTD Inicial</th>
                    <th>Plaga Objetivo</th>                    
                    <th>Escenario</th>
                    <th>Especie Hortofruticola</th>
                    <th>Especies Hospedantes</th>
                    <th>Superficie</th>
                    <th>Medidas Control</th>       
                    <th>Cantidad</th> 
                    <th>Insumos</th> 
                    <th>Fuentes</th> 
                    <th>MTD Final</th>                          
                </tr>
            </thead>';		
                
            while($fila = pg_fetch_assoc($res)) {
                    $detalle .=
                    '<tr>
                        <td class="formato">'.$fila['identificador_tecnico'].'</td>
                        <td class="formato">'.$fila['provincia'].'</td>
                        <td >'.$fila['canton'].'</td>
                        <td class="formato">'.$fila['parroquia'].'</td>
                        <td class="formato">'.$fila['coordenada_x'].'</td>					
                        <td class="formato">'.$fila['coordenada_y'].'</td>
                        <td class="formato">'.$fila['coordenada_z'].'</td>                        
                        <td >'.$fila['fecha'].'</td>
                        <td >'.$fila['semana'].'</td>    
                        <td >'.$fila['acciones_mip'].'</td>                  
                        <td >'.$fila['mdt_inicial'].'</td>                       
                        <td >'.$fila['plaga_objetivo'].'</td>
                        <td >'.$fila['escenario'].'</td>
                        <td >'.$fila['especie_hortofruticola'].'</td>
                        <td >'.$fila['especie_hospedante'].'</td>
                        <td class="formato">'.$fila['superficie'].'</td>
                        <td class="formato">'.$fila['medidas_control'].'</td>
                        <td class="formato">'.$fila['cantidad'].'</td>
                        <td class="formato">'.$fila['insumos'].'</td>
                        <td class="formato">'.$fila['fuente'].'</td>
                        <td class="formato">'.$fila['mdt_final'].'</td>          
                    </tr>';
            }
      
?>	

<html LANG="es">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<style type="text/css">
#tablaReporte
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
display: inline-block;
width: auto;
margin: 0;
padding: 0;
border-collapse:collapse;
}
#tablaReporte td, #tablaReporte th 
{
font-size:1em;
border:1px solid #98bf21;
padding:3px 7px 2px 7px;
}
#tablaReporte th 
{
font-size:1em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#A7C942;
color:#ffffff;
}
#logoMagap{
margin-top: -17px;
width: 15%;
height:120px;
background-image: url(../../aplicaciones/general/img/magap.png);
background-repeat: no-repeat;
float: left;	
}

#logoAgrocalidad{
width: 20%;
height:80px;
background-image: url(../../aplicaciones/general/img/agrocalidad.png); background-repeat: no-repeat;
float: right;
}

#textoTitulo{
width: 60%;
height:80px;
text-align: center;
float:left;
}

@page{
margin: 5px;
}

.formato{
mso-style-parent:style0;
mso-number-format:"\@";
}


</style>
</body>
</head>
<body>
<div id="header">
   <div id="logoMagap"></div>
    <div id="textoTitulo"><b>AGENCIA DE REGULACIÓN Y CONTROL FITO Y ZOOSANITARIO</b><br>
    <?php echo '<b>'.$tituloReporte.'</b>'; ?><br>
    <strong>PERIODO:</strong> <?php
        $periodo = ($fechaInicio);
         echo $periodo;?>
            <br>
        </div>
    <div id="logoAgrocalidad"><!-- img src="../../aplicaciones/general/img/magap.png" --></div>
</div>

</head>
<body>
<div id="tabla">
<table id="tablaReporte" class="soloImpresion">
    <?php echo $cabecera;?>
    <tbody>		
    <?php 	
        echo $detalle;
    ?>		
    </tbody>
</table>
</div>	
</body>

<script type="text/javascript"> 

$(document).ready(function(){
$("#listadoItems").removeClass("comunes");
$("#listadoItems").addClass("lista");

});

</script>

</html>






