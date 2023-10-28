<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorImportacionMuestras.php';
require_once '../../clases/ControladorRevisionSolicitudesVUE.php';

$conexion = new Conexion();
$cim = new ControladorImportacionMuestras();
$crs = new ControladorRevisionSolicitudesVUE();

$qImportacionMuestras = $cim->abrirImportacionMuestras($conexion, $_POST['id']);
$importacionMuestras = pg_fetch_assoc($qImportacionMuestras);

$qImportacionMuestrasProductos = $cim->abrirImportacionMuestrasProductos($conexion, $_POST['id']);

$identificadorOperador = $importacionMuestras['identificador_importador'];
$estado = $importacionMuestras['estado'];
$tipoAreaSolicitud = $importacionMuestras['codigo_tipo_solicitud'];

$qDocumentos = $cim->abrirDocumentosImportacionMuestras($conexion, $_POST['id']);

?>

<header>
	<h1>Solicitud de Importación de Muestras</h1>
</header>
	
<div id="estado"></div>

<div class="pestania">
	
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
				<label>Medio de transporte: </label> <?php echo $importacionMuestras['nombre_medio_transporte']; ?>
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
</div>

<!-- SECCION DE REVISIÓN DE PRODUCTOS PARA IMPORTACION -->
<div class="pestania">
	<form id="evaluarDocumentosSolicitud" data-rutaAplicacion="revisionFormularios" data-opcion="evaluarDocumentosSolicitud" data-accionEnExito="ACTUALIZAR">
		<input type="hidden" name="inspector" value="<?php echo $_SESSION['usuario'];?>"/>
		<input type="hidden" name="idSolicitud" value="<?php echo $_POST['id'];?>"/>
		<input type="hidden" name="tipoSolicitud" value="ImportacionMuestrasVUE"/>
		<input type="hidden" name="tipoInspector" value="Documental"/>
		<input type="hidden" name="idVue" value="<?php echo $importacionMuestras['req_no'];?>"/>
		<input type="hidden" name="identificadorOperador" value="<?php echo $identificadorOperador;?>"/>
		<input type="hidden" name="tipoAreaSolicitud" value="<?php echo $tipoAreaSolicitud;?>"/>
		
		<fieldset>
			<legend>Resultado de Revisión</legend>					
				<div data-linea="6">
					<label>Resultado: </label>
						<select id="resultadoDocumento" name="resultadoDocumento">
							<option value="">Seleccione....</option>
							<?php echo ($tipoAreaSolicitud=='IAF'?'<option value="pago">Aprobar revisión documental</option>':'<option value="aprobado">Aprobar solicitud</option>')?>
							<option value="subsanacion">Subsanación</option>
							<option value="rechazado">Solicitud rechazada</option>
						</select>
				</div>	
				<div data-linea="2">
					<label>Observaciones: </label>
					<input type="text" id="observacionDocumento" name="observacionDocumento" maxlength="500"/>
				</div>
				
		</fieldset>
		
		<button type="submit" class="guardar">Enviar resultado</button>			
	</form> 
</div>

<script type="text/javascript">
var estado= <?php echo json_encode($estado); ?>;

	$(document).ready(function(){
		distribuirLineas();
		construirAnimacion($(".pestania"));	

		$("#evaluarDocumentosSolicitud").hide();
		
		if(estado == "enviado" || estado == "asignadoDocumental"){
			$("#evaluarDocumentosSolicitud").show();
		}else{
			$("#evaluarDocumentosSolicitud").hide();
		}

	});

	$("#evaluarDocumentosSolicitud").submit(function(event){
		event.preventDefault();
		chequearCamposInspeccionDocumental(this);
	});

	function chequearCamposInspeccionDocumental(form){
		$(".alertaCombo").removeClass("alertaCombo");
		var error = false;

		if(!$.trim($("#resultadoDocumento").val())){
			error = true;
			$("#resultadoDocumento").addClass("alertaCombo");
		}

		if(!$.trim($("#observacionDocumento").val())){
			error = true;
			$("#observacionDocumento").addClass("alertaCombo");
		}
		
		if (error){
			$("#estado").html("Por favor revise la información ingresada.").addClass('alerta');
		}else{
			$('#evaluarDocumentosSolicitud').attr('data-opcion','evaluarDocumentosSolicitud');
			ejecutarJson(form);
		}
	}
	
	
</script>
