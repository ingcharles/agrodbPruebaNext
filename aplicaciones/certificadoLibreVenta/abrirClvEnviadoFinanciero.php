<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCatalogos.php';
require_once '../../clases/ControladorRegistroOperador.php';
require_once '../../clases/ControladorClv.php';
require_once '../../clases/ControladorRevisionSolicitudesVUE.php';

$conexion = new Conexion();
$cc = new ControladorCatalogos();
$cr = new ControladorRegistroOperador();
$cl  = new ControladorClv();
$crs = new ControladorRevisionSolicitudesVUE();

$idSolicitud = $_POST['id'];
$identificadorInspector = $_SESSION['usuario'];


$cClv	  = $cl->listarCertificados($conexion,$idSolicitud);
$dClv     = $cl->listarDetalleCertificados($conexion,$idSolicitud);
$dcClv	  = $cl->listarDocumentos($conexion,$idSolicitud);

$cTitular = $cr->buscarOperador($conexion,$cClv[0]['idTitular']);

//Obtener monto a pagar
if($cClv[0]['estado']=='verificacion'){
	$qIdGrupo = $crs->buscarIdGrupo($conexion, $idSolicitud, 'CLV', 'Financiero');
	$idGrupo = pg_fetch_assoc($qIdGrupo);
	//Obtener monto a pagar
	$qDatosPago = $crs->buscarIdImposicionTasa($conexion, $idGrupo['id_grupo'], 'CLV', 'Financiero');
	$datosPago = pg_fetch_assoc($qDatosPago);
}


//Obtener datos de entidades bancarias
$qEntidadesBancarias = $cc->listarEntidadesBancariasAgrocalidad($conexion);
?>

<header>
	<h1>Certificado de libre venta</h1>
</header>

	<div id="estado"></div>
	
<div class="pestania">
	
	<?php 
		if($cClv[0]['idVue'] != ''){
			echo '<fieldset>
				<legend>Información de la Solicitud</legend>
					<div data-linea="1">
						<label>Identificación VUE: </label> '. $cClv[0]["idVue"] .'
					</div>
			</fieldset>';
		}
	?>
	<fieldset>
		<legend>Información del titular</legend>
			<div data-linea="3">
				<label>RUC / Cédula: </label> <?php echo pg_fetch_result($cTitular, 0, 'identificador'); ?> 
			</div>
			
			<div data-linea="4">
				<label>Nombre: </label> <?php echo pg_fetch_result($cTitular, 0, 'nombre_representante') . ' ' . pg_fetch_result($cTitular, 0, 'apellido_representante'); ?>
			</div>
			
			<div data-linea="7">
				<label>Provincia: </label> <?php echo pg_fetch_result($cTitular, 0, 'provincia'); ?>
			</div>
			
			<div data-linea="7">
				<label>Cantón: </label> <?php echo pg_fetch_result($cTitular, 0, 'canton'); ?>
			</div>
			
			<div data-linea="8">
				<label>Parroquia: </label> <?php echo pg_fetch_result($cTitular, 0, 'parroquia'); ?>
			</div>
			
			<div data-linea="9">
				<label>Dirección: </label> <?php echo pg_fetch_result($cTitular, 0, 'direccion'); ?> 
			</div>
	</fieldset>	
	
	<fieldset id="informacionOperador">
			<legend>Información Operador</legend>
			
			<div data-linea="9">
				<label>Nombre Operador: </label> <?php echo $cClv[0]['nombreDatoCertificado']; ?> 
			</div>
			
			<div data-linea="10">
				<label>Dirección Operador: </label> <?php echo $cClv[0]['direccionDatoCertificado']; ?> 
			</div>
			
	</fieldset>		
	
	<fieldset id="informacionProductoClv">
			 <legend>Información del producto <?php echo ($cClv[0]['tipoProducto'] == 'IAV'?'Veterinario':'Plaguicida'); ?></legend>	
			    <div data-linea="14">
					<label>Tipo de producto: </label> <?php echo ($cClv[0]['tipoProducto'] == 'IAV'?'Veterinario':'Plaguicida'); ?> 
				</div>
				<div data-linea="14">
					<label>Tipo operación: </label> <?php echo $cClv[0]['tipoDatoCertificado']; ?> 
				</div>		
			 	<div data-linea="15">								
					<label>Producto: </label> <?php echo $cClv[0]['nombre_producto']; ?>
				</div>
				<div data-linea="16">
				    <label>Subpartida: </label> <?php echo $pClv[0]['subpartida']; ?>	
				 </div>
				 
				<?php 
					 if ($cClv[0]['tipoProducto'] == 'IAP'){
				  		echo '<div data-linea="17">
								<label>Formulación VUE: </label>' .$pClv[0]['formulacion'] .
							'</div>
							<div data-linea="17">
								<label>Formulación GUIA: </label>' .$pClv[0]['formulacionGuia'] .
							'</div>
							<div data-linea="18">
								<label>Composición: </label>' .$pClv[0]['composicionGuia'] .
							'</div>';
					 }else{
					 	echo '<div data-linea="16">
						 		<label>Forma farmacética: </label>' . $pClv[0]['formulacionGuia'] .
						 	'</div>';
					 }
				?>
							
				<div data-linea="19">
					<label>Clasifición: </label> <?php echo $pClv[0]['clasificacion']; ?>
				</div>												
	</fieldset>
	
	<?php 
	//IMPRESION DE DOCUMENTOS
	
		if(count($dcClv)>0){
			$i=1;
		
			echo'<div id="documentos" >
					<fieldset>
						<legend>Documentos adjuntos</legend>
							<table>
								<tr>
									<td><label>#</label></td>
									<td><label>Nombre</label></td>
									<td><label>Enlace</label></td>
								</tr>';
		
			foreach ($dcClv as $documento){
					echo '<tr>
						  	<td>'.$i.'</td>
							<td>'.$documento['tipoArchivo'].'</td>
							<td>
								<form id="f_'.$i.'" action="aplicaciones/general/accederDocumentoFTP.php" method="post" enctype="multipart/form-data" target="_blank">
									<input name="rutaArchivo" value="'.$documento['rutaArchivo'].'" type="hidden">
									<input name="nombreArchivo" value="'.$documento['tipoArchivo'].'.pdf" type="hidden">
									<input name="idVue" value="'.$documento['idVue'].'" type="hidden">
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
		
	<fieldset id="informacionProducto">
			<legend>Descripción del producto</legend>
					
			<div data-linea="6">
				<label>Tipo de producto: </label> <?php echo ($cClv[0]['tipoProducto']=="IAV"?'Inocuidad de Alimentos Veterinarios':'Inocuidad de Alimentos Plaguicidas'); ?> 
			</div>
			
			<div data-linea="11">
				<label>Fecha vigencia: </label> <?php echo date('j/n/Y',strtotime($cClv[0]['fechaVigenciaProducto'])); ?>
			</div>
			
			<div data-linea="11">
				<label>Fecha inscripcion: </label> <?php echo date('j/n/Y',strtotime($cClv[0]['fechaInscripcionProducto'])); ?>
			</div>
			
			<div data-linea="15">
				<label>Forma Farmaceútica: </label> <?php echo $cClv[0]['formaFarmaceutica']; ?>
			</div>
			
			<div data-linea="17">
				<label>Formulación: </label> <?php echo $cClv[0]['formulacion']; ?>
			</div>
			
			<?php 
				if($cClv[0]['tipoProducto'] == 'IAV') {
                  echo "<div data-linea='16'>
                      		 <label>Uso: </label>" . $cClv[0]['usoProducto'] . "
				 		</div>
				 		
				 		<div data-linea='19'>
                      		 <label>Especies: </label>" . $cClv[0]['especie']. "
				  		</div>
                  		
                  		<div data-linea='13'>
                  				<label>Presentación comercial: </label> " . $cClv[0]['presentacionComercial'] ."
                  		</div>
                  		
                  		<div data-linea='14'>
                  				<label>Clasificación: </label> ". $cClv[0]['clasificacionProducto']."
                  		</div>";
				}
			?>
	</fieldset>

<?php 
	//DETALLE DE PRODUCTOS
	if($cClv[0]['tipoProducto'] == 'IAP'  && count($dClv) > 0){
		echo '<fieldset>
				<legend>Composición Plaguicida</legend>;
			      	<table>
						<tr>
							<td><label>#</label></td>
							<td><label>Ingrediente activo</label></td> 
							<td><label>Concentración</label></td>
						</tr>';
				$i=1;
				
				foreach ($dClv as $detalleProducto){
					echo '<tr>
							<td>'.$i.'</td>
							<td>' . $detalleProducto['ingredienteActivo'] . ' </td>
						  	<td>' . number_format($detalleProducto['concentracion'], 2) . ' '. $detalleProducto['unidadMedida'] . ' </td>
						</tr>';			
					$i++;
					
				}
		echo '</table>
			</fieldset>';
	}
	
	if($cClv[0]['tipoProducto'] == 'IAV' && count($dClv) > 0) {
		$i=1;
		
		echo '<fieldset>
				<legend>Composición Veterinario</legend>;
					<table>
						<tr>
							<td><label>#</label></td>
							<td><label>Nombre</label></td>
							<td><label>Cantidad</label></td>
							<td><label>Descripción</label></td>
						</tr>';
		
		foreach ($dClv as $detalleProducto){
			echo '<tr>
					<td>' . $i . '</td>
					<td>' . $detalleProducto['composicionDeclarada'] . ' </td>
					<td>' . number_format($detalleProducto['cantidadComposicion'],2) . ' ' . $detalleProducto['unidadMedida'] . ' </td>
					<td>' . $detalleProducto['descripcionComposicion'] . ' </td>
				  </tr>';
			$i++;
				
		}
		echo '</table>
		</fieldset>';
	}		
	
?>

</div>

<!-- SECCION DE REVISIÓN DE PAGOS PARA CLV -->
<div class="pestania">	 
	
	<form id="asignarMonto" data-rutaAplicacion="revisionFormularios" data-opcion="asignarMontoSolicitud" data-accionEnExito="ACTUALIZAR">
		<input type="hidden" name="inspector" value="<?php echo $identificadorInspector;?>"/> <!-- INSPECTOR -->
		<input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud;?>"/>
		<input type="hidden" name="tipoSolicitud" value="CLV"/>
		<input type="hidden" name="tipoInspector" value="Financiero"/>
		<input type="hidden" name="estado" value="verificacionVUE"/>
		<input type="hidden" name="idVue" value="<?php echo $cClv[0]['idVue'];?>"/>
		
		<fieldset>
			<legend>Valor a cancelar</legend>
				<div data-linea="11" >		
					<p class="nota">Por favor ingrese el valor a cancelar por el certificado.</p>
					
					<label>Monto: </label>
						<input type="text" id="monto" name="monto" placeholder="Ej: 10.56" data-er="^[0-9]+(\.[0-9]{1,3})?$"/>
				</div>
		</fieldset>			
		<button type="submit" class="guardar">Autorizar pago</button>
	</form>	
	
	<form id="verificarPago" data-rutaAplicacion="revisionFormularios" data-opcion="verificarPagoSolicitud" data-accionEnExito="ACTUALIZAR">
		<input type="hidden" name="inspector" value="<?php echo $identificadorInspector;?>"/> <!-- INSPECTOR -->
		<input type="hidden" name="idSolicitud" value="<?php echo $idSolicitud;?>"/>
		<input type="hidden" name="tipoSolicitud" value="CLV"/>
		<input type="hidden" name="tipoInspector" value="Financiero"/>
		<input type="hidden" name="estado" value="inspeccion"/>
		<input type="hidden" name="idOperador" value="<?php echo $cTitular[0]['idTitular'];?>"/>
		<input type="hidden" name="idVue" value="<?php echo $cClv[0]['idVue'];?>"/>
		<input type="hidden" name="idGrupo" value="<?php echo $idGrupo['id_grupo'];?>"/>
		
		<fieldset id="factura">
				<legend>Pago de arancel</legend>
					<div data-linea="12" >
						<label>Monto a pagar: </label> $ <?php 
							if(pg_num_rows($qDatosPago) != 0){
								echo $datosPago['monto']; 
							}						
						?>
					</div>
		</fieldset>
		
		<fieldset>
			<legend>Resultado de Revisión</legend>
								
				<div data-linea="5">
					<label>Número de factura: </label>
						<input type="text" id="numeroFactura" name="numeroFactura" placeholder="Ej: 00234" data-er="^[0-9-]+$"/>
				</div>
				
				<div data-linea="6">
					<label>Entidad bancaria</label>
						<select id="codigoBanco" name="codigoBanco">
							<option value="">Seleccione....</option>
							<?php 
								while ($fila = pg_fetch_assoc($qEntidadesBancarias)){
									echo '<option value="'.$fila['id_banco']. '" data-codigovue="'.$fila['codigo_vue'].'">'. $fila['nombre'] .'</option>';
								}
							?>
						</select>
						
						<input type="hidden" id="nombreBanco" name="nombreBanco"></input>
				</div>	
				
				<div data-linea="7">
					<label>Monto recaudado: </label>
						<input type="text" id="montoRecaudado" name="montoRecaudado" placeholder="Ej: 153" data-er="^[0-9]+(\.[0-9]{1,3})?$" value="<?php echo$datosPago['monto_recaudado']; ?>"/>
				</div>
				
				<div data-linea="7">
					<label>Fecha de facturación: </label>
						<input type="text" id="fechaFacturacion" name="fechaFacturacion" value="<?php echo $datosPago['fecha_facturacion']; ?>"/>
				</div>
					
				<div data-linea="8">
					<label>Resultado</label>
						<select id="resultado" name="resultado">
							<option value="">Seleccione....</option>
							<option value="aprobado">Confirmar pago</option>
						</select>
				</div>	
				
				<div data-linea="9">
					<label>Observaciones</label>
						<input type="text" id="observacion" name="observacion"/>
				</div>
		</fieldset>
		
		<button type="submit" class="guardar">Finalizar proceso</button>
	</form>
</div>
<script type="text/javascript">
var estado= <?php echo json_encode($cClv[0]['estado']); ?>;
var banco = <?php echo json_encode($datosPago['codigo_banco']);?>;

$(document).ready(function(){
	distribuirLineas();
	construirAnimacion($(".pestania"));
	
	$("#verificarPago").hide();
	$("#asignarMonto").hide();

	if(estado == 'pago'){
		$("#asignarMonto").show();
	}else if(estado == 'verificacion'){
		$("#verificarPago").show();
	}

	if($("#montoRecaudado").val().length >= 1){
		$("#montoRecaudado").prop("readonly",true);
	}

	if($("#fechaFacturacion").val().length >= 1){
		$("#fechaFacturacion").prop("readonly",true);
	}else{
		$("#fechaFacturacion").datepicker({
		    changeMonth: true,
		    changeYear: true
		  });
	}

	if(banco == '456'){
		$("#codigoBanco").find('option[data-codigovue="'+banco+'"]').prop("selected","selected");
		$("#codigoBanco").attr("disabled","disabled");
		$('#nombreBanco').val($("#codigoBanco  option:selected").text());
	}else{
		cargarValorDefecto("codigoBanco","<?php echo $datosPago['codigo_banco'];?>");
	}
	
});

$("#codigoBanco").change(function(){
	$('#nombreBanco').val($("#codigoBanco  option:selected").text());

});


$("#asignarMonto").submit(function(event){
	event.preventDefault();
	chequearCamposAsignarMonto(this);
});

$("#verificarPago").submit(function(event){
	event.preventDefault();
	chequearCamposVerificarPago(this);
});

function esCampoValido(elemento){
	var patron = new RegExp($(elemento).attr("data-er"),"g");
	return patron.test($(elemento).val());
}

function chequearCamposAsignarMonto(form){
	$(".alertaCombo").removeClass("alertaCombo");
	var error = false;

	if(!$.trim($("#monto").val()) || !esCampoValido("#monto")){
		error = true;
		$("#monto").addClass("alertaCombo");
	}
	
	if (error){
		$("#estado").html("Por favor ingrese solamente decimales con dos dígitos.").addClass('alerta');
	}else{
		ejecutarJson(form);
	}
}

function chequearCamposVerificarPago(form){
	$(".alertaCombo").removeClass("alertaCombo");
	var error = false;

	if(!$.trim($("#codigoBanco").val())){
		error = true;
		$("#codigoBanco").addClass("alertaCombo");
	}

	if(!$.trim($("#montoRecaudado").val()) || !esCampoValido("#montoRecaudado")){
		error = true;
		$("#montoRecaudado").addClass("alertaCombo");
	}

	if(!$.trim($("#fechaFacturacion").val())){
		error = true;
		$("#fechaFacturacion").addClass("alertaCombo");
	}

	if(!$.trim($("#resultado").val()) || !esCampoValido("#resultado")){
		error = true;
		$("#resultado").addClass("alertaCombo");
	}

	if(!$.trim($("#observacion").val()) || !esCampoValido("#observacion")){
		error = true;
		$("#observacion").addClass("alertaCombo");
	}
	
	if (error){
		$("#estado").html("Por favor revise la información ingresada.").addClass('alerta');
	}else{
		ejecutarJson(form);
	}
}
</script>