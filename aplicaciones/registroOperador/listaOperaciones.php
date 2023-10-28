<?php 
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorRegistroOperador.php';
require_once '../../clases/ControladorAplicaciones.php';

set_time_limit(360);
$identificadorOperador = $_SESSION['usuario'];

$filtro = '';
	if(isset($_POST['nombre_sitio']) and $_POST['nombre_sitio'] != ''){
		$filtro = $filtro . " unaccent(st.nombre_lugar) ilike unaccent('%" . $_POST['nombre_sitio'] . "%') and ";
	}
	if(isset($_POST['nombre_operador']) and $_POST['nombre_operador'] != ''){
		$filtro = $filtro . " unaccent(o.razon_social) ilike unaccent('%" . $_POST['nombre_operador'] . "%') and ";
	}
	if(isset($_POST['provincia']) and $_POST['provincia'] != ''){
		$filtro = $filtro . " unaccent(st.provincia) ilike unaccent('%" . $_POST['provincia'] . "%') and ";
	}
	if(isset($_POST['nombre_tipo_operacion']) and $_POST['nombre_tipo_operacion'] != ''){
		$filtro = $filtro . " unaccent(t.nombre) ilike unaccent('%" . $_POST['nombre_tipo_operacion'] . "%') and ";
	}
	if(isset($_POST['estado_operacion']) and $_POST['estado_operacion'] != ''){
		$filtro = $filtro . " unaccent(s.estado) ilike unaccent('%" . $_POST['estado_operacion'] . "%') and ";
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
		<h1>Solicitudes</h1>
	</header>

	<header>
		<nav>
			<form id="filtrarOperaciones" data-rutaAplicacion="registroOperador" data-opcion="listaOperaciones" data-destino="areaTrabajo #listadoItems" >
				<input type="hidden" name="opcion" value="<?php echo $_POST['opcion']; ?>" />
				<input type="hidden" id="identificadorResponsableH" name="identificadorResponsableH" value="<?php echo $_SESSION['usuario']; ?>" />

				<table class="filtro" style='width: 100%;' >
					<tbody>
					<tr>
						<th colspan="4">Busar por:</th>					
					</tr>

					<tr>
						<td align="left">Nombre del sitio:</td>
						<td ><input id="nombre_sitio" type="text" name="nombre_sitio" style="width: 100%;"/></td>		
					</tr>

					<tr>
						<td align="left">Nombre operador/miembro:</td>
						<td ><input id="nombre_operador" type="text" name="nombre_operador" style="width: 100%;"/></td>		
					</tr>

					<tr>
						<td align="left">Nombre del área:</td>
						<td ><input id="nombre_area" type="text" name="nombre_area" style="width: 100%;"/></td>		
					</tr>

					<tr>
						<td align="left">Provincia:</td>
						<td>
							<select id="provincia" name="provincia" style="width: 100%;">
								<option value=''>Seleccionar...</option>
					            <?php
						            $tipo = 'st.provincia';
						            $res = $cr->listarOperacionesOperadorFiltradosCombos($conexion, $_SESSION['usuario'], " not in ('eliminado')", $tipo);
						            while($fila = pg_fetch_assoc($res)){
						                echo "<option value='".$fila['provincia']."'>".$fila['provincia']."</option>";
						            }
					            ?>
					        </select>
				    	</td>
					</tr>

					<tr>
						<td align="left">Operación:</td>
						<td>
							<select id="nombre_tipo_operacion" name="nombre_tipo_operacion" style="width: 100%;">
								<option value=''>Seleccionar...</option>
					            <?php
						            $tipo = 't.nombre';
						            $res = $cr->listarOperacionesOperadorFiltradosCombos($conexion, $_SESSION['usuario'], " not in ('eliminado')", $tipo);
						            while($fila = pg_fetch_assoc($res)){
						                echo "<option value='".$fila['nombre']."'>".$fila['nombre']."</option>";
						            }
					            ?>
					        </select>
				    	</td>
					</tr>

					<tr>
						<td align="left">Estado:</td>
						<td>
							<select id="estado_operacion" name="estado_operacion" style="width: 100%;">
								<option value=''>Seleccionar...</option>
					            <?php
						            $tipo = 'a.estado';
						            $res = $cr->listarOperacionesOperadorFiltradosCombos($conexion, $_SESSION['usuario'], " not in ('eliminado')", $tipo);
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

	
	<?php
		$res = $cr->listarOperacionesOperadorFiltrados($conexion, $identificadorOperador, " not in ('eliminado')", 20, 0, null, $filtro);
		while($fila = pg_fetch_assoc($res)){
			$nombreArea = $cr->buscarNombreAreaPorSitioPorTipoOperacion($conexion, $fila['id_tipo_operacion'], $identificadorOperador, $fila['id_sitio'], $fila['id_operacion']);
			$nombreSitio = $fila['nombre_lugar'];

			$validar = true;
			if(isset($_POST['nombre_area']) and $_POST['nombre_area'] != ''){
				if (strpos(strtolower($nombreArea), strtolower($_POST['nombre_area'])) !== false) 
				{
					$validar = true;
				}
				else{
					$validar = false;
				}
			}
			
			if($validar){
				$itemsFiltrados[] = array('<tr
								id="'.$fila['id_operacion'].'"
								class="item"
								data-rutaAplicacion="registroOperador"
								data-opcion="abrirOperacion"
								ondragstart="drag(event)"
								draggable="true"
								data-destino="detalleItem">
								<td style="white-space:nowrap;"><b>'.++$contador.'</b></td>
								<td>'.$nombreSitio.'</td>
								<td>'.$fila['razon_social'].'</td>
								<td>'.$fila['provincia'].'</td>
								<td>'.$fila['nombre_tipo_operacion'].'</td>
								<td>'.$nombreArea.'</td>
								<td>'.$fila['operacion_estado'].'</td>
								<td>'.$fila['area_estado'].'</td>
							</tr>');
			}
			
		}
	?>		

	<div id="paginacion" class="normal"></div>
	<table id="tablaItems">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre del sitio</th>
				<th>Nombre operador/miembro</th>
				<th>Provincia</th>
				<th>Operación</th>
				<th>Nombre del área</th>
				<th>Fase</th>
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

	$("#filtrarOperaciones").submit(function(event){
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