<?php 
	session_start();
	
	require_once '../../clases/Conexion.php';
	require_once '../../clases/ControladorCertificados.php';
		
	header("Content-type: application/octet-stream");
	//indicamos al navegador que se está devolviendo un archivo
	header("Content-Disposition: attachment; filename=REPORTERFACTURASANULADAS.xls");
	//con esto evitamos que el navegador lo grabe en su caché
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$conexion = new Conexion();
	$cc = new ControladorCertificados();
		
	$fechaInicio = $_POST['fechaInicio'];
	$fechaFin = $_POST['fechaFin'];
	$provincia = $_POST['provincia'];
	$establecimiento = $_POST['establecimiento'];
	$ruc = $_POST['ruc'];	

	$res = $cc -> listarReporteFacturasAnuladasPorNumeroEstablecimiento($conexion, $fechaInicio, $fechaFin, $provincia, $establecimiento, $ruc);  //punto de venta
	
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

@page{
   margin: 5px;
}

.formato{
 	mso-style-parent:style0;
 	mso-number-format:"\@";
}

.formatoNumero{
	mso-style-parent:style0;
	mso-number-format:"0.00";
}

.colorCelda{
	background-color: #FFE699;
}

</style>


</head>
<body>

<div id="tablaCabecera">
<table>
<tr>
	<td style="font-weight: bold;">SUBPROCESO DE RECURSOS FINANCIEROS</td>
</tr>
<tr>
	<td style="font-weight: bold;">REPORTE DE FACTURAS ANULADAS</td>
</tr>
<tr>
	<td style="font-weight: bold;">PUNTO DE FACTURACIÓN:</td><td> <?php echo (($establecimiento != "") ? $establecimiento.'-001' : "TODOS") ?></td>
</tr>
<tr>
	<td style="font-weight: bold;">FECHA DÍA DE FACTURACIÓN:</td><td> <?php echo date('d-m-Y')?></td>
</tr>
<tr>
</tr>
</table>
</div>

<div id="tabla">
<table id="tablaReporte" class="soloImpresion">
	<thead>
		<tr>
			<th>Identificador</th>
			<th>Razón social</th>
			<th>Número de solicitud</th>
            <th>Número de factura</th>
            <th>Total a pagar</th>
            <th>Localización</th>
            <th>Fecha de facturación</th>
			<th>Estado de factura</th>
            <th>Motivo de anulación</th>
            <th>Tipo de solicitud</th>
            <th>Nombre de provincia</th>
            <th>Identificador responsable anulación</th>
            <th>Responsable anulación</th>
            <th>Fecha anulación factura</th>
		</tr>
	</thead>
	<tbody>
	 <?php

	 While($fila = pg_fetch_assoc($res)) {

	 	echo '<tr>
                <td class="formato">' . $fila['identificador_operador'] . '</td>
					<td>'. $fila['razon_social'] . '</td>
					<td>'. $fila['numero_solicitud'] . '</td>
                    <td>'. $fila['numero_factura'] . '</td>
                    <td class="formatoNumero">'.($fila['total_pagar']==''?'':number_format($fila['total_pagar'],2,',','.')).'</td>
                    <td>'. $fila['localizacion'] . '</td>
                    <td>'. $fila['fecha_facturacion'] . '</td>
                    <td>'. $fila['estado_sri'] . '</td>
                    <td>'. $fila['motivo_anulacion'] . '</td>
                    <td>'. $fila['tipo_solicitud'] . '</td>
                    <td>'. $fila['nombre_provincia'] . '</td>
                    <td>'. $fila['identificador_responsable_anulacion'] . '</td>
                    <td>'. $fila['nombre_responsable_anulacion'] . '</td>
                    <td>'. $fila['fecha_anulacion_factura'] . '</td>
            </tr>';
	 	
	 }
	 
	 ?>
	 

	</tbody>
</table>

</div>
</body>

</html>



