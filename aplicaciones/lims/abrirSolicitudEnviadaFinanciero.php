<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCertificados.php';
require_once '../../clases/ControladorRevisionSolicitudesVUE.php';
require_once '../../clases/ControladorLims.php';

$conexion = new Conexion();
$cce = new ControladorCertificados();
$crs = new ControladorRevisionSolicitudesVUE();
$cl = new ControladorLims();

$idSolicitud = $_POST['id'];
$condicion = $_POST['opcion'];

$res = $cl->abrirSolicitud($conexion, $idSolicitud);
$filaSolicitud = pg_fetch_assoc($res);

if($condicion == 'verificacion' || $condicion == 'verificacionVUE'){
    $qOrdenPago=$cce->obtenerIdOrdenPagoXtipoOperacionSinGrupo($conexion, $idSolicitud , 'lims');
}

if($condicion == 'pago'){
    echo '<input type="hidden" class= "abrirPago" id="'.$idSolicitud.'-'.$filaSolicitud['cliente_identificacion'].'-'.'pago'.'-lims-tarifarioNuevo'.'" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitudSinGrupo" data-destino="ordenPago" />';
}else if ($condicion == 'verificacionVUE' && pg_num_rows($qOrdenPago)!=0){
    echo '<input type="hidden" class= "abrirPago" id="'.$idSolicitud.'-'.$filaSolicitud['cliente_identificacion'].'-'.'verificacionVUE'.'-lims-tarifarioNuevo-'.'" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitudSinGrupo" data-destino="ordenPago" />';
}else if ($condicion == 'verificacion' && pg_num_rows($qOrdenPago)!=0){
    echo '<input type="hidden" class= "abrirPago" id="'.$idSolicitud.'-'.$filaSolicitud['cliente_identificacion'].'-'.'verificacion'.'-lims-'.pg_fetch_result($qOrdenPago, 0, 'id_pago').'" data-rutaAplicacion="financiero" data-opcion="finalizarMontoSolicitudSinGrupo" data-destino="ordenPago" />';
}

$totalOtros = pg_fetch_result($cl->totalOtrosPaquetes($conexion, $idSolicitud), 0, 'totalOtros');

?>

<header>
	<h1>Solicitud de Análisis de Laboratorio</h1>
</header>

<fieldset>
	<legend>Información del Solicitante</legend>

	<div data-linea="1">
		<label>Nombre/Razón Social: </label> <?php echo $filaSolicitud['razon_social']; ?>
	</div>

	<div data-linea="2">
		<label>CI / RUC / RISE: </label> <?php echo $filaSolicitud['cliente_identificacion']; ?>
	</div>

	<div data-linea="4">
		<label>Provincia: </label> <?php echo $filaSolicitud['provincia']; ?>
	</div>

	<div data-linea="5">
		<label>Dirección: </label> <?php echo $filaSolicitud['direccion']; ?>
	</div>

	<div data-linea="6">
		<label>Teléfono: </label> <?php echo $filaSolicitud['telefono']; ?>
	</div>

</fieldset>

<fieldset>

	<legend>Información de las Muestras</legend>

	<div data-linea="6">
			<table id="tbSitiosAreasProductos" style="width: 100%">
				<thead>
					<tr>
						<th style="width: 5%;">Nº</th>
						<th style="width: 10%;">Tarifario</th>
						<th style="width: 25%;">Paquetes</th>
						<th style="width: 15%;">Cantidad Solicitada</th>
						<th style="width: 15%;">Precio Unitario Tarifario</th>
						<th style="width: 15%;">Precio Referencial LIMS</th>
						<th style="width: 15%;">Total por Ítem</th>
					</tr>
				</thead>
				<tbody>
				<?php				
    				$res1 = $cl->abrirSolicitudPaquetes($conexion, $idSolicitud);
    				$i = 1;
    
    				while ($fila = pg_fetch_assoc($res1)){
    					echo '<tr>' . 
    							'<td>' . $i ++ . '</td>' . 
    							'<td>' . $fila['codigo'] . '</td>' . 
    							'<td>' . $fila['descripcion'] . '</td>' . 
    							'<td>' . $fila['cantidad_paquetes'] . '</td>' .
    							'<td>' . $fila['precio_paquete'] . '</td>' .
    							'<td>' . $fila['precio_lims'] . '</td>' .
    							'<td>' . $fila['total_item'] . '</td>' .
    					'</tr>';
    				}
				?>
				</tbody>
			</table>
		</div>
		
		<div data-linea="7">
    		<label>Total a Facturar por Otros Servicios de Laboratorio (04.21.001): $</label> <?php echo $totalOtros; ?>
    	</div>
</fieldset>


<div id="ordenPago"></div>

<script type="text/javascript">

	$(document).ready(function(){
		abrir($(".abrirPago"),null,false);
		distribuirLineas();		
	});

</script>