<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorAplicaciones.php';
require_once '../../clases/ControladorRegistroOperador.php';

$conexion = new Conexion();

$ca = new ControladorAplicaciones('registroOperador', 'asociarDocumentoAnexo');

$filtro = '';
if(isset($_POST['sitioNombre']) and $_POST['sitioNombre'] != ''){
	$filtro = $filtro . " unaccent(st.nombre_lugar) ilike unaccent('%" . $_POST['sitioNombre'] . "%') and ";
}
if(isset($_POST['areaNombre']) and $_POST['areaNombre'] != ''){
	$filtro = $filtro . " unaccent(a.nombre_area) ilike unaccent('%" . $_POST['areaNombre'] . "%') and ";
}
if(isset($_POST['operacionNombre']) and $_POST['operacionNombre'] != ''){
	$filtro = $filtro . " unaccent(top.nombre) ilike unaccent('%" . $_POST['operacionNombre'] . "%') and ";
}
if(isset($_POST['provinciaNombre']) and $_POST['provinciaNombre'] != ''){
	$filtro = $filtro . " unaccent(st.provincia) ilike unaccent('%" . $_POST['provinciaNombre'] . "%') and ";
}
if(isset($_POST['operacionEstado']) and $_POST['operacionEstado'] != ''){
	$filtro = $filtro . " unaccent(o.estado) ilike unaccent('%" . $_POST['operacionEstado'] . "%') and ";
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

	<header>
		<h1>Cargar anexos</h1>
	</header>

	<header>
		<nav>
			<form id="filtrarProcesosCargarAnexo" data-rutaAplicacion="registroOperador" data-opcion="listarOperacionesAAsociar" data-destino="areaTrabajo #listadoItems" >
				<input type="hidden" name="opcion" value="<?php echo $_POST['opcion']; ?>" />
				<input type="hidden" id="identificadorResponsableH" name="identificadorResponsableH" value="<?php echo $_SESSION['usuario']; ?>" />

				<table class="filtro" style='width: 100%;' >
					<tbody>
					<tr>
						<th colspan="4">Busar por:</th>					
					</tr>
					<tr>
						<td align="left">Sitio:</td>
						<td><input id="sitioNombre" type="text" name="sitioNombre"/></td>
					</tr>
					<tr>
						<td align="left">Área:</td>
						<td><input id="areaNombre" type="text" name="areaNombre"/></td>
					</tr>
					<tr>
						<td align="left">Tipo Operación:</td>
						<td ><input id="operacionNombre" type="text" name="operacionNombre"/></td>		
					</tr>
					<tr>
						<td align="left">Estado:</td>
						<td ><input id="operacionEstado" type="text" name="operacionEstado"/></td>		
					</tr>
					<tr>
						<td align="left">Provincia:</td>
						<td><input id="provinciaNombre" type="text" name="provinciaNombre"></td>					
					</tr>		
					<tr>
						<td colspan="4" style='text-align:center'><button>Buscar</button></td>	
					</tr>
					<tr>
						<td colspan="4" style='text-align:center' id="mensajeError"></td>
					</tr>
					</tbody>
				</table>
			</form>
		</nav>

		<?php
		$cr = new ControladorRegistroOperador();
		$res = $cr->listarOperacionesQueRequierenAnexos($conexion, $_SESSION['usuario'], $filtro);
		$itemsFiltrados[] = array();

		while($fila = pg_fetch_assoc($res))
		{

			$clase = '';
			if($fila['estado']=='cargarAdjunto'){
				$estado = 'Cargar documentos';
			}else{
				$estado = 'Subsanar documentos';
			}

			$nombreArea = $cr->buscarNombreAreaPorSitioPorTipoOperacion($conexion, $fila['id_tipo_operacion'], $identificadorOperador, $fila['id_sitio'], $fila['id_operacion']);

			$codigoSitio = $fila['id_sitio'].'-'.$categoria;
			$nombreSitio = $fila['nombre_lugar'];
			$itemsFiltrados[] = array('<tr
								id="'.$fila['id_operacion'].'"
								class="item"
								data-rutaAplicacion="registroOperador"
								data-opcion="asociarDocumentoAnexo"
								ondragstart="drag(event)"
								draggable="true"
								data-destino="detalleItem">
								<td style="white-space:nowrap;"><b>'.++$contador.'</b></td>
								<td>'.$fila['id_operacion'].'</td>
								<td>'.$fila['nombre_lugar'].'</td>
								<td>'.$nombreArea.'</td>
								<td>'.$fila['nombre_tipo_operacion'].'</td>
								<td>'.$fila['estado'].'</td>
								<td>'.$fila['provincia'].'</td>
							</tr>');
																						  
		}
	?>		
	</header>

	<header>
		<nav>
			<?php 
			$res = $ca->obtenerAccionesPermitidas($conexion, $_POST["opcion"], $identificadorOperador);
			while($fila = pg_fetch_assoc($res)){
				echo '<a href="#"
						id="' . $fila['estilo'] . '"
						data-destino="detalleItem"
						data-opcion="' . $fila['pagina'] . '"
						data-rutaAplicacion="' . $fila['ruta'] . '">'.(($fila['estilo']=='_seleccionar')?'<div id="cantidadItemsSeleccionados">0</div>':''). $fila['descripcion'] . '</a>';
			}
		?>
		</nav>
	</header>

	<div id="paginacion" class="normal"></div>
	<table id="tablaItems">
		<thead>
			<tr>
				<th>#</th>
				<th>Id Operación</th>
				<th>Sitio</th>
				<th>Área</th>
				<th>Tipo Operación</th>	
				<th>Estado</th>			
				<th>Provincia</th>			
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

<script>
    $(document).ready(function(){
		$("#listadoItems").removeClass("comunes");
		$("#listadoItems").addClass("lista");
		construirPaginacion($("#paginacion"),<?php echo json_encode($itemsFiltrados);?>);	
	});

	$("#filtrarProcesosCargarAnexo").submit(function(event){
		event.preventDefault();
		$(".alertaCombo").removeClass("alertaCombo");
		var error = false;
		
		if(!error){
			abrir($(this),event,false);
			$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un registro para revisarlo.</div>');
		}	
	});
</script>

</body>
</html>
