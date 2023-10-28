<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCertificados.php';
require_once '../../clases/ControladorRevisionSolicitudesVUE.php';
require_once '../../clases/ControladorImportacionMuestras.php';
require_once '../../clases/ControladorCatalogos.php';

$conexion = new Conexion();
$crs = new ControladorRevisionSolicitudesVUE();
$cim = new ControladorImportacionMuestras();
$cc = new ControladorCatalogos();
$cce = new ControladorCertificados();

$idSolicitud = $_POST['id'];
$identificadorInspector = $_SESSION['usuario'];
$condicion = $_POST['opcion'];

$qImportacionMuestras = $cim->abrirImportacionMuestras($conexion, $_POST['id']);
$importacionMuestras = pg_fetch_assoc($qImportacionMuestras);

$qImportacionMuestrasProductos = $cim->abrirImportacionMuestrasProductos($conexion, $_POST['id']);

$identificadorOperador = $importacionMuestras['identificador_importador'];
$estado = $importacionMuestras['estado'];
$tipoAreaSolicitud = $importacionMuestras['codigo_tipo_solicitud'];

$qDocumentos = $cim->abrirDocumentosImportacionMuestras($conexion, $_POST['id']);

$estadoActual = $importacionMuestras['estado'];



if($estadoActual == 'verificacion' || $estadoActual == 'verificacionVUE'){
	$qIdGrupo = $crs->buscarIdGrupo($conexion, $idSolicitud, 'ImportacionMuestrasVUE', 'Financiero');
	$idGrupo = pg_fetch_assoc($qIdGrupo);
	//Obtener monto a pagar
	$qDatosPago = $crs->buscarIdImposicionTasa($conexion, $idGrupo['id_grupo'], 'ImportacionMuestrasVUE', 'Financiero');
	$datosPago = pg_fetch_assoc($qDatosPago);
}

if($idGrupo['id_grupo'] != ''){
	$ordenPago = $cce->obtenerIdOrdenPagoXtipoOperacion($conexion, $idGrupo['id_grupo'], $idSolicitud, 'ImportacionMuestrasVUE');
}



if($condicion == 'pago'){
    echo '<input type="hidden" class= "abrirPago" id="'.$idSolicitud.'-'.$importacionMuestras['identificador_importador'].'-'.$estadoActual.'-ImportacionMuestrasVUE-tarifarioNuevo" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-idOpcion = "'.$importacionMuestras['req_no'].'" data-nombre = "'.$idGrupo['id_grupo'].'"/>';
}else if ($condicion == 'verificacionVUE' && pg_num_rows($ordenPago)!=0){
    echo '<input type="hidden" class= "abrirPago" id="'.$idSolicitud.'-'.$importacionMuestras['identificador_importador'].'-'.$estadoActual.'-ImportacionMuestrasVUE-tarifarioNuevo" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-idOpcion = "'.$importacionMuestras['req_no'].'" data-nombre = "'.$idGrupo['id_grupo'].'"/>';
}else if ($condicion == 'verificacion' && pg_num_rows($ordenPago) == 0){
    echo '<input type="hidden" class= "abrirPago" id="'.$idSolicitud.'-'.$importacionMuestras['identificador_importador'].'-pago-ImportacionMuestrasVUE-tarifarioAntiguo" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-idOpcion = "'.$importacionMuestras['req_no'].'" data-nombre = "'.$idGrupo['id_grupo'].'"/>';
}else if ($condicion == 'verificacion' && pg_num_rows($ordenPago) != 0){
	$numeroOrdenPago = pg_fetch_result($ordenPago, 0, 'id_pago');
	echo '<input type="hidden" class= "abrirPago" id="'.$idSolicitud.'-'.$importacionMuestras['identificador_importador'].'-'.$estadoActual.'-ImportacionMuestrasVUE-'.$numeroOrdenPago.'" data-rutaAplicacion="financiero" data-opcion="finalizarMontoSolicitud" data-destino="ordenPago" data-idOpcion = "'.$importacionMuestras['req_no'].'" data-nombre = "'.$idGrupo['id_grupo'].'"/>';
}

?>

<header>
	<h1>Solicitud de Importación de Muestras</h1>
</header>
	
<div id="estado"></div>
	
	<fieldset>
			<legend>Certificado de Importación de Muestras</legend>
			
			<div data-linea="0">
				<label>Tipo de Certificado: </label> <?php echo $importacionMuestras['nombre_tipo_solicitud']; ?> 
			</div>
			
			<div data-linea="1">
				<label>Razón social solicitante: </label> <?php echo $importacionMuestras['razon_social_solicitante']; ?> 
			</div>
			
			<div data-linea="2">
				<label>Representante legal importador: </label> <?php echo  $importacionMuestras['representante_legal_importador']; ?> <br/>
			</div>
			
			<div data-linea="3">
				<label>Estado de solicitud: </label><?php echo ($estado=='aprobado'? '<span class="exito">'.$estado.'</span>': '<span class="alerta">Solicitud en revisión documental</span>'); ?>
			</div>
			
	</fieldset>
	
	<fieldset>
		<legend>Datos del Exportador</legend>	
			
			<div data-linea="4">
				<label>Nombre exportador: </label> <?php echo $importacionMuestras['nombre_exportador']; ?> 
			</div>
			
			<div data-linea="5">
				<label>Dirección Exportador: </label> <?php echo $importacionMuestras['direccion_exportador']; ?>
			</div>
	</fieldset>
	
	<fieldset>
		<legend>Datos de Importación de Muestras</legend>		
			
			<div data-linea="6">
				<label>Régimen aduanero: </label> <?php echo $importacionMuestras['nombre_regimen_aduanero']; ?> 
			</div>
			
			<div data-linea="7">
				<label>País de origen: </label> <?php echo $importacionMuestras['nombre_pais_origen']; ?>
			</div>
			
			<div data-linea="7">
				<label>País de embarque: </label> <?php echo $importacionMuestras['nombre_pais_embarque']; ?>
			</div>
			
			<div data-linea="8">
				<label>Puerto de embarque: </label> <?php echo $importacionMuestras['nombre_puerto_embarque']; ?>
			</div>
			
			<div data-linea="9">
				<label>País de destino: </label> <?php echo $importacionMuestras['nombre_pais_destino']; ?>
			</div>
			
			<div data-linea="9">
				<label>Puerto de destino: </label> <?php echo $importacionMuestras['nombre_puerto_destino']; ?>
			</div>	
			
			<div data-linea="10">
				<label>Nombre embarcador: </label> <?php echo $importacionMuestras['nombre_embarcador']; ?>
			</div>
			
			<div data-linea="11">
				<label>Medio de transporte: </label> <?php echo $importacionMuestras['nombre_punto_ingreso']; ?>
			</div>
			
			<div data-linea="11">
				<label>Unidad de moneda: </label> <?php echo $importacionMuestras['nombre_unidad_moneda']; ?>
			</div>			
			
	</fieldset>
	
	
	<?php 
	
	$i=1;
	while ($producto = pg_fetch_assoc($qImportacionMuestrasProductos)){
		echo '
		<fieldset>
			<legend>Muestra de importación ' . $i . '</legend>
			
				<div data-linea="12">
					<label>Partida arancelaria: </label> ' . $producto['subpartida'] . ' <br/>
				</div>

                <div data-linea="13">
					<label>Nombre del producto: </label> ' . $producto['nombre_producto'] . ' <br/>
				</div>

				<div data-linea="14">
					<label>Cantidad: </label> ' . $producto['cantidad_producto'] . ' ' . $producto['unidad_medida_producto'] . ' <br/>
				</div>
				<div data-linea="14">
					<label>Peso neto: </label> ' . $producto['peso'] . ' ' . $producto['unidad_peso'] . ' <br/>
				</div>

                <div data-linea="15">
					<label>Valor FOB: </label> ' . $producto['valor_fob'] . ' <br/>
				</div>
				<div data-linea="15">
					<label>Valor CIF: </label> ' . $producto['valor_cif'] . ' <br/>
				</div>';
				
				

		echo '</fieldset>';
		$i++;
	}
	
	//IMPRESION DE DOCUMENTOS
	$i=1;
	if(count($qDocumentos)>0){
	    
	    echo'<div id="documentos" >
					<fieldset>
						<legend>Documentos adjuntos</legend>
			    
								<table>
									<tr>
										<td><label>#</label></td>
										<td><label>Nombre</label></td>
										<td><label>Enlace</label></td>
									</tr>';
	    
	    
	    foreach ($qDocumentos as $documento){
	        echo '<tr>
						  	<td>'.$i.'</td>
							<td>'.$documento['tipoArchivo'].'</td>
							<td>
								<form id="f_'.$i.'" action="aplicaciones/general/accederDocumentoFTP.php" method="post" enctype="multipart/form-data" target="_blank">
									<input name="rutaArchivo" value="'.$documento['rutaArchivo'].'" type="hidden">
									<input name="nombreArchivo" value="'.$documento['tipoArchivo'].'.pdf" type="hidden">
									<input name="idVue" value="'.$documento['reqNo'].'" type="hidden">
									<button type="submit" name="boton">Descargar</button>
								</form>
							</td>
						 </tr>';
	        $i++;
	    }
	    
	    echo '</table>
			</fieldset>
			</div>';
	}
	
	
	?>	

<div id="ordenPago"></div>

<script type="text/javascript">
var estado= <?php echo json_encode($estadoActual); ?>;

	$(document).ready(function(){
		abrir($(".abrirPago"),null,false);
		distribuirLineas();		
	});
</script>