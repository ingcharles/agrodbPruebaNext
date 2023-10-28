<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorVehiculos.php';
require_once '../../clases/ControladorUsuarios.php';

$conexion = new Conexion();
$cv = new ControladorVehiculos();
$cu = new ControladorUsuarios();

$res = $cv->abrirVehiculo($conexion, $_POST['id']);
$vehiculo= pg_fetch_assoc($res);

//Identificador Usuario Administrador o Apoyo de Transportes
if($_SESSION['usuario'] != '' && $_SESSION['usuario']!=$vehiculo['identificador_registro']){
	$identificadorUsuarioRegistro = $_SESSION['usuario'];
}else if($_SESSION['usuario'] != '' && $_SESSION['usuario']==$vehiculo['identificador_registro']){
	$identificadorUsuarioRegistro = $vehiculo['identificador_registro'];
}else{
	$identificadorUsuarioRegistro = '';
}

//Tipo de usuario
$perfil = $cu->buscarPerfilUsuarioXCodigo($conexion, $identificadorUsuarioRegistro, 'PFL_ADM_NAC');

if(pg_num_rows($perfil) != 0){
    $tipoUsuario = 'Administrador';
}else{
    $tipoUsuario = 'Usuario';
}

$matriculaciones = $cv->obtenerMatriculacionXVehiculo($conexion, $vehiculo['placa']);

?>


<header>
	<h1>Datos del vehículo</h1>
</header>
	
	<fieldset>
		<legend> Vehículo placa <?php echo $vehiculo['placa'];?></legend>
		
		<div data-linea="1">
			<label>Placa </label>
				<?php echo $vehiculo['placa'];?>
		</div>
		
		<div data-linea="2">
		
		<label>Marca</label> 
			<?php echo $vehiculo['marca'];?> 
			
		</div>
		
		<div data-linea="2">
			
		<label>Modelo</label> 
			<?php echo $vehiculo['modelo'];?> 
			
		</div>
		
		<div data-linea="3">
				
		<label>Tipo</label> 
			<?php echo $vehiculo['tipo'];?>
			
		</div>
		
		<div data-linea="3">			
	
		<label>Tipo Combustible</label>
			<?php echo $vehiculo['combustible'];?>
		
		</div>	
	</fieldset>	
	

	<form id="nuevaMatricula" data-rutaAplicacion="transportes" data-opcion="guardarNuevaMatricula" data-accionEnExito="ACTUALIZAR" data-destino="detalleItem" method="post">
		<input type="hidden" id="placa" name="placa" value="<?php echo $vehiculo['placa'];?>">
		<input type='hidden' id='identificadorUsuarioRegistro' name='identificadorUsuarioRegistro' value="<?php echo $identificadorUsuarioRegistro;?>" />
		
		<fieldset>
			<legend>Documentos de Matriculación del Vehículo</legend>	
			
			<div data-linea="1">
				<label>Tipo de Documento</label>
				<select id="tipoDocumento" name="tipoDocumento" required>
					<option value="">Seleccione....</option>
					<option value="Certificado de Matriculación Anual">Certificado de Matriculación Anual</option>
					<option value="Matrícula del Vehículo">Matrícula del Vehículo</option>
				</select>	
			</div>
			
			<div data-linea="2">
				<label>Fecha inicio:</label>
				<input id="fechaInicio" name="fechaInicio" type="date"  required="required"/>
			</div>
			
			<div data-linea="3">
				<label>Documento anexo:</label>
				<input type="file" class="archivo" name="informe" accept="application/pdf" /> 
				<input type="hidden" class="rutaArchivo" name="archivo" required="required"  />
				<div class="estadoCarga">En espera de archivo... (Tamaño máximo: <?php echo ini_get('upload_max_filesize');?>B)</div>
				<button type="button" class="subirArchivo" data-rutaCarga="aplicaciones/transportes/matriculas/<?php echo $vehiculo['placa']?>">Subir archivo</button>
			</div>
			
			<button type="submit" class="mas">Añadir matrícula</button>		

		</fieldset>
	</form>
	
	<fieldset>
		<legend>Documentos anexos</legend>
		
		<table id="matriculas">
    		<tr>
				<th>Placa</th>
				<th>Tipo Documento</th>
				<th>Fecha Inicio</th>
				<th>Fecha Fin</th>
				<th>Archivo</th>
				<th>Estado</th>
				<th></th>
    		</tr>
    		
			<?php 
			     while ($matricula = pg_fetch_assoc($matriculaciones)){
			         echo $cv->imprimirLineaMatricula($matricula['id_matriculacion'], $matricula['placa'], $matricula['tipo_documento'], $matricula['fecha_inicio'], $matricula['fecha_fin'], $matricula['ruta_documento'], 'transportes', $matricula['estado_documento'], $tipoUsuario);
				}
			?>
		</table>
	</fieldset>
	
</body>

<script type="text/javascript">
	$(document).ready(function(){
		distribuirLineas();		
	});
	
	acciones("#nuevaMatricula","#matriculas");
	
	/*$("#fechaInicio").datepicker({
		      changeMonth: true,
		      changeYear: true
		});*/
		    
	$('button.subirArchivo').click(function (event) {
	
        var boton = $(this);
        var archivo = boton.parent().find(".archivo");
        var rutaArchivo = boton.parent().find(".rutaArchivo");
        var extension = archivo.val().split('.');
        var estado = boton.parent().find(".estadoCarga");
        numero = Math.floor(Math.random()*100000000);
        
        if (extension[extension.length - 1].toUpperCase() == 'PDF') {
            subirArchivo(archivo, $("#placa").val() +"_"+numero, boton.attr("data-rutaCarga"), rutaArchivo, new carga(estado, archivo, boton)); 
        } else {
            estado.html('Formato incorrecto, solo se admite archivos en formato PDF');
            archivo.val("0");
        }        
    });
	
</script>