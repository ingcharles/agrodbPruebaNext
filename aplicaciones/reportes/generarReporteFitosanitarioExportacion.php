<?php
session_start();

require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorReportesCSV.php';

header("Content-type: application/octet-stream");
//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=REPORTE_FITOSANITARIO_EXPORTACION.xls");
//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

$conexion = new Conexion();
$cr = new ControladorReportesCSV();

$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$tituloReporte='REPORTE FITOSANITARIO DE EXPORTACION';

$cabecera = "";
$detalle = "";     
        $res = $cr->generarReporteFitosanitarioExportacion($conexion, $fechaInicio, $fechaFin);
      
            $cabecera = '<thead>                
                <tr>
                    <th>Identificador Exportación</th>		
                    <th>Fecha Inicio</th>
                    <th>Fecha Vigencia</th>					
                    <th>Puerto Destino</th>
                    <th>Pais Destino</th>
                    <th>Razon Social</th>
                    <th>Nombre Importador</th>
                    <th>Dirección Importador</th>
                    <th>Puerto Embarque</th>
                    <th>Transporte</th>
                    <th>Lugar Inspección</th>
                    <th>Nombre Marcas</th>
                    <th>Tipo Producto</th>
                    <th>Subtipo Producto</th>
                    <th>Partida Arancelaria</th>
                    <th>Codigo Producto</th>
                    <th>Nombre Científico</th>
                    <th>Identificador Producto Operador</th>
                    <th>Identificador Fito Exportación</th>
                    <th>Identificador Operador</th>
                    <th>Codigo Producto</th>
                    <th>Nombre Producto</th>
                    <th>Nr° Bultos</th>
                    <th>Unidad Bultos</th>
                    <th>Cantidad Producto</th>
                    <th>Unidad Cantidad</th>
                    <th>Permiso Musaceas</th>	
                    <th>Estado</th>
                    <th>Observación</th>
                    <th>Ruta Archivo</th>
                    <th>Subpartida Producto Vue</th>
                    <th>Codigo Producto Vue</th>                    
                    <th>Declaracion Adicional</th>
                    <th>Fecha Tratamiento</th>
                    <th>Tratamiento Realizado</th>
                    <th>Quimico Tratamiento</th>			
                    <th>Duracion Tratamiento</th>
                    <th>Temperatura Tratamiento</th>                   
                    <th>Concentracion Producto</th>
                    <th>Reporte Inspeccion</th>
                    <th>Identificador Vue</th>
                    <th>Fecha Creacion</th>   
                    <th>Nombre Aprobacion Documental</th>                
                    <th>Producto Organico</th> 
                    <th>Numero Producto Organico</th>
                    <th>Aprobación Revisión Documental</th> 
                    <th>Fecha Tasa Financiero</th> 
                </tr>
            </thead>';		
                
            while($fila = pg_fetch_assoc($res)) {
            
                    $detalle .=
                    '<tr>
                        <td class="formato">'.$fila['id_fito_exportacion_fe'].'</td>
                        <td >'.$fila['fecha_inicio'].'</td>
                        <td >'.$fila['fecha_vigencia'].'</td>
                        <td >'.$fila['puerto_destino'].'</td>
                        <td >'.$fila['pais_destino'].'</td>					
                        <td >'.$fila['razon_social'].'</td>
                        <td >'.$fila['nombre_importador'].'</td>
                        <td >'.$fila['direccion_importador'].'</td>
                        <td >'.$fila['puerto_embarque'].'</td>
                        <td >'.$fila['transporte'].'</td>
                        <td >'.$fila['lugar_inspeccion'].'</td>
                        <td >'.$fila['nombre_marcas'].'</td>
                        <td >'.$fila['tipo_producto'].'</td>
                        <td >'.$fila['subtipo_producto'].'</td>
                        <td >'.$fila['partida_arancelaria'].'</td>
                        <td >'.$fila['codigo_producto'].'</td>
                        <td >'.$fila['nombre_cientifico'].'</td>
                        <td >'.$fila['id_fito_exp_operador_producto'].'</td>                    
                        <td >'.$fila['id_fito_exportacion'].'</td>
                        <td >'.$fila['identificador_operador'].'</td>
                        <td >'.$fila['id_producto'].'</td>
                        <td >'.$fila['nombre_producto'].'</td>
                        <td >'.$fila['numero_bultos'].'</td>
                        <td >'.$fila['unidad_bultos'].'</td>
                        <td >'.$fila['cantidad_producto'].'</td>
                        <td >'.$fila['unidad_cantidad_producto'].'</td>
                        <td >'.$fila['permiso_musaceas'].'</td>
                        <td >'.$fila['estado'].'</td>
                        <td >'.$fila['observacion'].'</td>
                        <td >'.$fila['ruta_archivo'].'</td>
                        <td >'.$fila['subpartida_producto_vue'].'</td>
                        <td >'.$fila['codigo_producto_vue'].'</td>
                        <td >'.$fila['declaracion_adicional'].'</td>                        
                        <td >'.$fila['fecha_tratamiento'].'</td>
                        <td >'.$fila['tratamiento_realizado'].'</td>
                        <td >'.$fila['quimico_tratamiento'].'</td>
                        <td >'.$fila['duracion_tratamiento'].'</td>
                        <td >'.$fila['temperatura_tratamiento'].'</td>
                        <td >'.$fila['concentracion_producto'].'</td>
                        <td >'.$fila['reporte_inspeccion'].'</td>
                        <td >'.$fila['id_vue'].'</td>
                        <td >'.$fila['fecha_creacion'].'</td>                    
                        <td >'.$fila['nombre_aprobacion_documental'].'</td>
                        <td >'.$fila['producto_organico'].'</td>
                        <td >'.$fila['numero_producto_organico'].'</td>
                        <td >'.$fila['aprobacion_revision_documental'].'</td>                       
                        <td >'.$fila['fecha_imposicion_tasa_financiero'].'</td>
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






