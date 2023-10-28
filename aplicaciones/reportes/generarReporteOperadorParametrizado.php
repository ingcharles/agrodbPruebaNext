<?php
session_start();

require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorReportesCSV.php';

header("Content-type: application/octet-stream");
// //indicamos al navegador que se está devolviendo un archivo
 header("Content-Disposition: attachment; filename=REPORTE_OPERADORES_AREA.xls");
// //con esto evitamos que el navegador lo grabe en su caché
 header("Pragma: no-cache");
 header("Expires: 0");

$conexion = new Conexion();
$cr = new ControladorReportesCSV();

$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];
$tipoOperacionArea=$_POST['cbxTipoOperacionArea'];
$tituloReporte='REPORTE OPERADORES';

$cabecera = "";
$detalle = "";     
        $res = $cr->generarReporteOperadorParametrizado($conexion, $fechaInicio, $fechaFin,$tipoOperacionArea);
      
            $cabecera = '<thead>                
                <tr>
                    <th>Identificador Operador</th>		
                    <th>Razon Social</th>
                    <th>Nombre Representante</th>				
                    <th>Nombre del Técnico</th>
                    <th>Dirección</th>
                    <th>Telefonos</th>
                    <th>Celulares</th>
                    <th>Correo</th>
                    <th>Identificador Operación</th>                    
                    <th>Estado</th>
                    <th>Observación</th>
                    <th>Identificador Operador</th>
                    <th>Identificador Vue</th>
                    <th>Pais Operaciones</th>
                    <th>Nombre Comun</th>
                    <th>Subtipo Producto</th>
                    <th>Tipo Producto</th>
                    <th>Tipo Operacion</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Modificación</th>
                    <th>Fecha Aprobación</th>
                    <th>Nombre Area</th>
                    <th>Tipo Area</th>
                    <th>Superficie Utilizada</th>
                    <th>Estado Area</th>
                    <th>Código Area</th>
                    <th>Código Mag</th>	
                    <th>Nombre Sitio</th>
                    <th>Dirección Sitio</th>
                    <th>Telefono </th>
                    <th>Referencia</th>  
                    <th>Parroquia</th>     
                    <th>Cantón</th>     
                    <th>Provincia</th>     
                    <th>Código Sitios</th>    
                    <th>Código Latitud</th>  
                    <th>Código Longitud</th>  
                    <th>Código Superficie Total</th>  
                    <th>Código Sitio</th>  
                    <th>Código Area</th>                             
                </tr>
            </thead>';		
                
            while($fila = pg_fetch_assoc($res)) {
            
                    $detalle .=
                    '<tr>
                        <td class="formato">'.$fila['identificador'].'</td>
                        <td >'.$fila['razon_social'].'</td>
                        <td >'.$fila['nombre_representante'].'</td>                        
                        <td >'.$fila['apellido_tecnico'].'</td>					
                        <td >'.$fila['direccion'].'</td>
                        <td >'.$fila['telefonos'].'</td>
                        <td >'.$fila['celulares'].'</td>
                        <td >'.$fila['correo'].'</td>
                        <td >'.$fila['id_tipo_operacion'].'</td>    
                        <td >'.$fila['estado'].'</td>                  
                        <td >'.$fila['observacion'].'</td>
                        <td >'.$fila['id_producto'].'</td>
                        <td class="formato">'.$fila['id_vue'].'</td>
                        <td >'.$fila['nombre_pais_operaciones'].'</td>
                        <td >'.$fila['nombre_comun'].'</td>
                        <td >'.$fila['subtipo_producto'].'</td>
                        <td >'.$fila['tipo_producto'].'</td>
                        <td >'.$fila['tipo_operacion'].'</td>                    
                        <td >'.$fila['fecha_creacion'].'</td>
                        <td >'.$fila['fecha_modificacion'].'</td>
                        <td >'.$fila['fecha_aprobacion'].'</td>
                        <td >'.$fila['nombre_area'].'</td>
                        <td >'.$fila['tipo_area'].'</td>
                        <td >'.$fila['superficie_utilizada'].'</td>
                        <td >'.$fila['estado_area'].'</td>
                        <td >'.$fila['codigo_area_areas'].'</td>
                        <td >'.$fila['codigo_mag'].'</td>
                        <td >'.$fila['nombre_sitio'].'</td>
                        <td >'.$fila['direccion_sitio'].'</td>
                        <td >'.$fila['telefono'].'</td>
                        <td >'.$fila['referencia'].'</td>     
                        <td >'.$fila['parroquia'].'</td>   
                        <td >'.$fila['canton'].'</td>   
                        <td >'.$fila['provincia'].'</td>   
                        <td >'.$fila['codigo_sitio_sitios'].'</td>   
                        <td >'.$fila['latitud'].'</td>   
                        <td >'.$fila['longitud'].'</td>   
                        <td >'.$fila['superficie_total'].'</td>   
                        <td >'.$fila['codigo_sitio'].'</td>   
                        <td >'.$fila['codigo_area'].'</td>                                                            
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
    <strong>Tipo Area:</strong><?php echo $tipoOperacionArea; ?><br>
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






