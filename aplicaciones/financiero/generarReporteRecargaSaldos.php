<?php 
	session_start();
	
	require_once '../../clases/Conexion.php';
	require_once '../../clases/ControladorCertificados.php';
		
	header("Content-type: application/octet-stream");
	//indicamos al navegador que se está devolviendo un archivo
	header("Content-Disposition: attachment; filename=REPORTERECARGASALDOS.xls");
	//con esto evitamos que el navegador lo grabe en su caché
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$conexion = new Conexion();
	$cc = new ControladorCertificados();
		
	$comprobante = $_POST['comprobante'];
	$fechaInicio = $_POST['fechaInicio'];
	$fechaFin = $_POST['fechaFin'];
	$provincia = $_POST['provincia'];
	$establecimiento = $_POST['establecimiento'];
	$ruc = $_POST['ruc'];	

	$res = $cc -> listarReporteRecargaSaldosPorNumeroEstablecimiento($conexion, $comprobante, $fechaInicio, $fechaFin, $provincia, $establecimiento, $ruc);  //punto de venta
	
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
	<td style="font-weight: bold;">CUADRE DE RECARGA DE SALDOS</td>
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
		    <th>Cliente CI/RUC</th>
			<th>Razón social</th>
			<th>Número de solicitud</th>
            <th>Observación</th>
            <th>Número de comprobante</th>
			<th>Fecha de emisión de comprobante</th>
            <th>Provincia</th>
            <th>Total</th>
            <th>Subsidio</th>
            <th>Institución bancaria</th>
            <th>Número de comprobante</th>
            <th>Valor depositado</th>
            <th>Fecha de depósito</th>
		</tr>
	</thead>
	<tbody>
	 <?php

	 $auxPago = 0;
	 $aux1Pago = 0;
	 $auxColor = 'pintado';
	 $auxImpresion = 0;

	 While($fila = pg_fetch_assoc($res)) {

	 	$aux1Pago = $auxPago;
	 	$auxPago = $fila['id_pago'];
	 	
	 	if($auxPago != $aux1Pago &&  $aux1Pago != 0){
	 		if($auxColor == 'pintado'){
	 			$auxColor = 'noPintado'; 	 		 				 			
	 		}else{
	 			$auxColor = 'pintado';	 			
	 		}
	 		$auxImpresion = 0;
	 	}

		if($auxPago == 0 || $aux1Pago == 0){
			echo  '<tr class= "colorCelda">';
		}else if($auxPago == $aux1Pago && $auxColor == 'pintado'){
			echo '<tr class= "colorCelda">';
		}else if($auxPago == $aux1Pago && $auxColor == 'noPintado'){
			echo '<tr>';
		}else if ($auxColor == 'pintado'){
			echo '<tr class= "colorCelda">';
		}else{
			echo '<tr>';
		}

        if($auxImpresion == 0){
	 		echo '<td class="formato">'.$fila['identificador_operador'].'</td>
        			<td>'. $fila['razon_social'] . '</td>
        			<td>'. $fila['numero_solicitud'] . '</td>
                    <td>'. $fila['observacion'] . '</td>
        			<td>'. $fila['numero_comprobante'] . '</td>
                    <td>'. $fila['fecha_facturacion'] . '</td>
                    <td>'. $fila['provincia_numero_establecimiento'] . '</td>
                    <td class="formatoNumero">'.($fila['total']==''?'':number_format($fila['total'],2,',','.')).'</td>
                    <td class="formatoNumero">'.($fila['subsidio']==''?'':number_format($fila['total'],2,',','.')).'</td>';
	 		$auxImpresion = 1;
	 	}else{
	 	    echo '<td class="formatoNumero"></td>
		 		  <td class="formatoNumero"></td>
		 		  <td class="formatoNumero"></td>
		 		  <td class="formatoNumero"></td>
		 		  <td class="formatoNumero"></td>
		 		  <td class="formatoNumero"></td>
		 		  <td class="formatoNumero"></td>
		 		  <td class="formatoNumero"></td>
		 		  <td class="formatoNumero"></td>';
	 	}

        echo '<td>'. $fila['institucion_bancaria'] . '</td>
        <td class="formato">'.$fila['transaccion'].'</td>
        <td class="formatoNumero">'.($fila['subsidio']==''?'':number_format($fila['valor_deposito'],2,',','.')).'</td>
        <td>'. $fila['fecha_deposito'] . '</td>';
	 }
	 
	 ?>
	 

	</tbody>
</table>

</div>
</body>

</html>



