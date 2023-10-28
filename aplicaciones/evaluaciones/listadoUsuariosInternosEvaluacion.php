<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCatalogos.php';
require_once '../../clases/ControladorAplicaciones.php';

$conexion = new Conexion();
$cc = new ControladorCatalogos();
?>

<header>
	<h1>Revisión de Usuarios Internos para Evaluación</h1>
	<nav  class="width: 100%;">
	<form id="formulario" data-rutaAplicacion="evaluaciones" data-opcion="listadoUsuariosInternosEvaluacionFiltrado" data-destino="tabla">
		<table class="filtro">
			<tr>
				<th>Usuario</th>
			</tr>
			<tr>	
				<td>Identificador:</td>				
				<td>
					<input type="text" id="usuarioFiltro" name="usuarioFiltro" required="required"/>
				</td>
			</tr>

			<tr>
				<td colspan="5"><button>Filtrar lista</button></td>
			</tr>
		</table>
		</form>
	</nav>
	<nav>	
		<?php 

			
			$ca = new ControladorAplicaciones();
			$res = $ca->obtenerAccionesPermitidas($conexion, $_POST["opcion"], $_SESSION['usuario']);
			//data-rutaAplicacion="' . $fila['ruta'] .'"
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

<div id="tabla"></div>
<script>
	
	$(document).ready(function(){
		$(".ofiFiltro").hide();
		$("#listadoItems").addClass("lista");
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione un usuario para visualizar.</div>');
	});
	
	$("#formulario").submit(function(e){
		$("#formulario").attr('data-opcion', 'listadoUsuariosInternosEvaluacionFiltrado');
        $("#formulario").attr('data-destino', 'tabla');
        
		abrir($(this),e,false);
	});
</script>
