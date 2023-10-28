<?php
session_start();

require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorReportesCSV.php';

header("Content-type: application/octet-stream");
//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=REPORTE_IMPORTACION_SANIDAD_ANIMAL.xls");
//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

$conexion = new Conexion();
$cr = new ControladorReportesCSV();

$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$tipoReporte = $_POST['cbxTipoReporte'];
$tituloReporte='REPORTE IMPORTACION SANIDAD ANIMAL';

$cabecera = "";
$detalle = "";     
        $res = $cr->generarReporteImportacionSanidadAnimal($conexion, $fechaInicio, $fechaFin,$tipoReporte);
      
            $cabecera = '<thead>                
                <tr>
                    <th>Identificador</th>		
                    <th>Razon Social</th>
                    <th>Direccion</th>					
                    <th>Correo</th>
                    <th>Tipo Producto</th>
                    <th>Subtipo Producto</th>
                    <th>Nombre Producto</th>
                    <th>Partida Arancelaria</th>
                    <th>Cantidad Producto</th>
                    <th>Unidad Producto</th>
                    <th>Peso</th>
                    <th>Unidad Peso</th>
                    <th>Licencia Magap</th>
                    <th>Pais Origen</th>
                    <th>Razon Exportador</th>
                    <th>Direccion Exportador</th>
                    <th>Tipo Transporte</th>
                    <th>Puerto Embarque</th>
                    <th>Puerto Destino</th>
                    <th>Identificador Vue</th>
                    <th>Valor Fob</th>
                    <th>Nombre Provincia</th>
                    <th>Nombre Ciudad</th>
                    <th>Fecha Creacion</th>                    
                    <th>Fecha Revision Documental</th>
                    <th>Fecha Tasa Imposición</th>                                            
                    <th>Fecha Aprobacion</th>
                    <th>Fecha Vigencia</th>	                  
                    <th>Estado</th>   
                    <th>Nombre Tecnico</th> 
                    <th>Observacion</th>                  
                </tr>
            </thead>';		
                
            while($fila = pg_fetch_assoc($res)) {
            
                    $detalle .=
                    '<tr>
                        <td class="formato">'.$fila['identificador'].'</td>
                        <td >'.$fila['razon_social'].'</td>
                        <td >'.$fila['direccion'].'</td>
                        <td >'.$fila['correo'].'</td>
                        <td >'.$fila['tipo_producto'].'</td>					
                        <td >'.$fila['subtipo_prodcuto'].'</td>
                        <td >'.$fila['nombre_producto'].'</td>
                        <td >'.$fila['partida_arancelaria'].'</td>
                        <td >'.$fila['cantidad_producto'].'</td>
                        <td >'.$fila['unidad_producto'].'</td>    
                        <td >'.$fila['peso'].'</td>                  
                        <td >'.$fila['unidad_peso'].'</td>
                        <td >'.$fila['licencia_magap'].'</td>
                        <td >'.$fila['pais_origen'].'</td>
                        <td >'.$fila['razon_exportador'].'</td>
                        <td >'.$fila['direccion_exportador'].'</td>
                        <td >'.$fila['tipo_transporte'].'</td>
                        <td >'.$fila['puerto_embarque'].'</td>                    
                        <td >'.$fila['puerto_destino'].'</td>
                        <td >'.$fila['id_vue'].'</td>
                        <td >'.$fila['valor_fob'].'</td>
                        <td >'.$fila['nombre_provincia'].'</td>
                        <td >'.$fila['nombre_ciudad'].'</td>
                        <td >'.$fila['fecha_creacion'].'</td>                       
                        <td >'.$fila['fecha_inspeccion'].'</td>
                        <td >'.$fila['fecha_imposicion_tasa'].'</td>                         
                        <td >'.$fila['fecha_aprobacion'].'</td>
                        <td >'.$fila['fecha_vigencia'].'</td>
                        <td >'.$fila['estado'].'</td>  
                        <td >'.$fila['nombre_tecnico'].'</td>
                        <td >'.$fila['observacion'].'</td>
                        
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
        $periodo = ($fechaInicio." / ".$fechaFin);
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






