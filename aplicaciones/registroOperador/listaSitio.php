<?php 
	session_start();
	require_once '../../clases/Conexion.php';
	require_once '../../clases/ControladorRegistroOperador.php';
	require_once '../../clases/ControladorAplicaciones.php';
	require_once '../../clases/GoogleAnalitica.php';
	
	function reemplazarCaracteres($cadena){
		$cadena = str_replace('á', 'a', $cadena);
		$cadena = str_replace('é', 'e', $cadena);
		$cadena = str_replace('í', 'i', $cadena);
		$cadena = str_replace('ó', 'o', $cadena);
		$cadena = str_replace('ú', 'u', $cadena);
		$cadena = str_replace('ñ', 'n', $cadena);
		$cadena = strtolower(str_replace(' ', '', $cadena));
		return $cadena;
	}
	
	function reemplazarCadenaCaracteres($cadena){
		$cadena = str_replace('á', 'a', $cadena);
		$cadena = str_replace('é', 'e', $cadena);
		$cadena = str_replace('í', 'i', $cadena);
		$cadena = str_replace('ó', 'o', $cadena);
		$cadena = str_replace('ú', 'u', $cadena);
		$cadena = str_replace('ñ', 'n', $cadena);
		$cadena = str_replace('Á', 'A', $cadena);
		$cadena = str_replace('É', 'E', $cadena);
		$cadena = str_replace('Í', 'I', $cadena);
		$cadena = str_replace('Ó', 'O', $cadena);
		$cadena = str_replace('Ú', 'U', $cadena);
		$cadena = str_replace('Ñ', 'N', $cadena);
		return $cadena;
	}

	$filtro = '';
	if(isset($_POST['provinciaFiltro']) and $_POST['provinciaFiltro'] != ''){
		$filtro = $filtro . " unaccent(s.provincia) ilike unaccent('%" . $_POST['provinciaFiltro'] . "%') and ";
	}
	if(isset($_POST['cantonFiltro']) and $_POST['cantonFiltro'] != ''){
		$filtro = $filtro . " unaccent(s.canton) ilike unaccent('%" . $_POST['cantonFiltro'] . "%') and ";
	}
	if(isset($_POST['nombre_lugar']) and $_POST['nombre_lugar'] != ''){
		$filtro = $filtro . " unaccent(s.nombre_lugar) ilike unaccent('%" . $_POST['nombre_lugar'] . "%') and ";
	}
	if(isset($_POST['codigo']) and $_POST['codigo'] != ''){
		$filtro = $filtro . " unaccent(s.identificador_operador || '.' || s.codigo_provincia || s.codigo) ilike unaccent('%" . $_POST['codigo'] . "%') and ";
	}
	if(isset($_POST['estado_sitio']) and $_POST['estado_sitio'] != ''){
		$filtro = $filtro . " unaccent(s.estado) ilike unaccent('%" . $_POST['estado_sitio'] . "%') and ";
	}
	
	$conexion = new Conexion();
	$cr = new ControladorRegistroOperador();
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
<body>


	<header>
		<h1>Sitios</h1>
	</header>

	<header>
		<nav>
			<form id="filtrarSitios" data-rutaAplicacion="registroOperador" data-opcion="listaSitio" data-destino="areaTrabajo #listadoItems" >
				<input type="hidden" name="opcion" value="<?php echo $_POST['opcion']; ?>" />
				<input type="hidden" id="identificadorResponsableH" name="identificadorResponsableH" value="<?php echo $_SESSION['usuario']; ?>" />

				<table class="filtro" style='width: 100%;' >
					<tbody>
					<tr>
						<th colspan="4">Busar por:</th>					
					</tr>

					<tr>
						<td align="left">Provincia:</td>
						<td>
							<select id="provinciaFiltro" name="provinciaFiltro" style="width: 100%;">
								<option value=''>Seleccionar...</option>
					            <?php
						            $tipo = 'provincia';
						            $res = $cr->listarSitiosFiltradosCombos($conexion, $_SESSION['usuario'], $tipo);
						            while($fila = pg_fetch_assoc($res)){
						                echo "<option value='".$fila['provincia']."'>".$fila['provincia']."</option>";
						            }
					            ?>
					        </select>
				    	</td>
					</tr>

					<tr>
						<td align="left">Cantón:</td>
						<td>
							<select id="cantonFiltro" name="cantonFiltro" style="width: 100%;">
								<option value=''>Seleccionar...</option>
					            <?php
						            $tipo = 'canton';
						            $res = $cr->listarSitiosFiltradosCombos($conexion, $_SESSION['usuario'], $tipo);
						            while($fila = pg_fetch_assoc($res)){
						                echo "<option value='".$fila['canton']."'>".$fila['canton']."</option>";
						            }
					            ?>
					        </select>
				    	</td>
					</tr>
					<tr>
						<td align="left">Nombre del sitio:</td>
						<td ><input id="nombre_lugar" type="text" name="nombre_lugar" style="width: 100%;"/></td>		
					</tr>
					<tr>
						<td align="left">Código del sitio:</td>
						<td ><input id="codigo" type="text" name="codigo" style="width: 100%;"/></td>		
					</tr>
					<tr>
						<td align="left">Estado:</td>
						<td>
							<select id="estado_sitio" name="estado_sitio" style="width: 100%;">
								<option value=''>Seleccionar...</option>
					            <?php
						            $tipo = 'estado';
						            $res = $cr->listarSitiosFiltradosCombos($conexion, $_SESSION['usuario'], $tipo);
						            while($fila = pg_fetch_assoc($res)){
						                echo "<option value='".$fila['estado']."'>".$fila['estado']."</option>";
						            }
					            ?>
					        </select>
				    	</td>				
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
	</header>
	

	<header>
		<nav>
			<?php 

				$ca = new ControladorAplicaciones();
				$res = $ca->obtenerAccionesPermitidas($conexion, $_POST["opcion"], $_SESSION['usuario']);
				while($fila = pg_fetch_assoc($res)){
					echo '<a href="#"
							id="' . $fila['estilo'] . '"
							data-destino="detalleItem"
							data-opcion="' . $fila['pagina'] . '"
							data-rutaAplicacion="' . $fila['ruta'] . '"
							>'.(($fila['estilo']=='_seleccionar')?'<div id="cantidadItemsSeleccionados">0</div>':''). $fila['descripcion'] . '</a>';
				}
			?>
		</nav>
	</header>


	<?php
		
		$res = $cr->listarSitiosFiltrados($conexion, $_SESSION['usuario'], $filtro);
		$contador = 0;

		while($fila = pg_fetch_assoc($res))
		{
			$categoria = reemplazarCaracteres($fila['provincia']);
			$itemsFiltrados[] = array('<tr
								id="'.$fila['id_sitio'].'"
								class="item"
								data-rutaAplicacion="registroOperador"
								data-opcion="abrirSitio"
								ondragstart="drag(event)"
								draggable="true"
								data-destino="detalleItem">
								<td style="white-space:nowrap;"><b>'.++$contador.'</b></td>
								<td>'.$fila['identificador_operador'].'.'.$fila['codigo_provincia'].$fila['codigo'].'</td>
								<td>'.$fila['provincia'].'</td>
								<td>'.$fila['canton'].'</td>
								<td>'.$fila['nombre_lugar'].'</td>
								<td>'.$fila['estado'].'</td>
							</tr>');
		}
	?>		


	<div id="paginacion" class="normal"></div>
	<table id="tablaItems">
		<thead>
			<tr>
				<th>#</th>
				<th>Código del sitio</th>
				<th>Provincia</th>
				<th>Cantón</th>
				<th>Nombre del sitio</th>	
				<th>Estado</th>
		</thead>
		<tbody>
		</tbody>
	</table>

<script>
$(document).ready(function(){
	 $(document).ready(function(){
		$("#listadoItems").removeClass("comunes");
		$("#listadoItems").addClass("lista");
		construirPaginacion($("#paginacion"),<?php echo json_encode($itemsFiltrados);?>);	
	});

	$("#filtrarSitios").submit(function(event){
		event.preventDefault();
		$(".alertaCombo").removeClass("alertaCombo");
		var error = false;
		
		if(!error){
			abrir($(this),event,false);
			$("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un registro para revisarlo.</div>');
		}	
	});
});
</script>

</body>
</html>