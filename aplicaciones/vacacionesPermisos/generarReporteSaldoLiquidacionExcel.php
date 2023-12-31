<?php 
	session_start();
	
	require_once '../../clases/Conexion.php';
	require_once '../../clases/ControladorVacaciones.php';
		
	header("Content-type: application/octet-stream");
	//indicamos al navegador que se está devolviendo un archivo
	header("Content-Disposition: attachment; filename=REPORTE_LIQUIDACION.xls");
	//con esto evitamos que el navegador lo grabe en su caché
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$conexion = new Conexion();
	$cv = new ControladorVacaciones();
		
	$identificador = $_POST['identificador'];
	$estadoSaldo = $_POST['estadoSaldo'];
	$apellido = $_POST['apellidoUsuario'];
	$nombre = $_POST['nombreUsuario'];
	$area = $_POST['area'];
	
	$listaReporte = $cv->filtroObtenerReporteFuncionariosLiquidar($conexion, $identificador, $estadoSaldo, $apellido, $nombre, $area, 'unico');
	
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
	mso-number-format:"0.000000";
}

.colorCelda{
	background-color: #FFE699;
}

</style>
</head>
<body>

<table id="tablaReporte" class="soloImpresion">
	<thead>
		<tr>
		    <th>Cédula</th>
		    <th>Apellidos y Nombres</th>
		    <th>Año</th>
		    <th>Mes</th>
		    <th>Saldo</th>
		    <th>Número de CUR</th>
		    <th>Estado</th>
		</tr>
	</thead>
	<tbody>
	 <?php
	 While($fila = pg_fetch_assoc($listaReporte)) {
        echo '<tr>
			<td class="formato">'.$fila['identificador'].'</td>
			<td>'.$fila['apellido'].' '.$fila['nombre'].'</td>
			<td></td>
		    <td></td>	
            <td></td> 
			<td></td> 
    	</tr>';
        
        $consulta = $cv->devolverDetalleLiquidacion($conexion, $fila['id_liquidacion_vacaciones']);
        
        if(pg_num_rows($consulta)>0){
        	while ($item = pg_fetch_assoc($consulta)){
			        echo '<tr>
						<td></td>
						<td></td>
						<td align="right">'.$item['anio'].'</td>
						<td align="right">'.$item['mes'].'</td>
					    <td align="right">'.number_format(($item['minutos_utilizados']/480), 2) .'</td>
			            <td>'. $fila['numero_cur'].'</td>
						<td>'. $estadoSaldo.'</td>
			    	</tr>';
        	}
        }
	 }
	 ?>
	
	</tbody>
</table>


</body>
</html>



