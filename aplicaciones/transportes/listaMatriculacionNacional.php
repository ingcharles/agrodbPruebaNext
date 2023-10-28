<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCatalogos.php';
require_once '../../clases/ControladorAplicaciones.php';

$conexion = new Conexion();
$cc = new ControladorCatalogos();
?>

<header>
	<h1>Revisión de Órdenes Generadas - Nacional</h1>
	<nav  class="width: 100%;">
	<form id="formulario" data-rutaAplicacion="transportes" data-opcion="listaMatriculacionNacionalFiltrado" data-destino="tabla">
		<table class="filtro">
			<tr>
				<th>Orden</th>
			</tr>
			<tr>
				<td>Placa:</td>
				
				<td>
					<input type="text" id="placaFiltro" name="placaFiltro"/>
				</td>
			</tr>
			<tr>	
				<td>Provincia:</td>
				
				<td>
					<select id="provinciaFiltro" name="provinciaFiltro">
						<option value="">Provincia....</option>
        					<?php 
        						$provincias = $cc->listarSitiosLocalizacion($conexion,'PROVINCIAS');
        						foreach ($provincias as $provincia){
        						    echo '<option value="' . $provincia['nombre'] . '">' . $provincia['nombre'] . '</option>';
        						}
        					?>
					</select>
				</td>
			</tr>
			<tr >	
				<td class="ofiFiltro">Oficina:</td>
				
				<td>
					<div id="dSubOficina"></div>
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
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione un vehículo para visualizar.</div>');
	});
	
	$("#provinciaFiltro").change(function(event){
		$(".ofiFiltro").hide();
    	$("#dSubOficina").text("");
    	
    	if($("#provinciaFiltro option:selected").val() != ''){
        	$("#formulario").attr('data-opcion', 'combosOficinas');
            $("#formulario").attr('data-destino', 'dSubOficina');
            abrir($("#formulario"), event, false); //Se ejecuta ajax
            $(".ofiFiltro").show();
        }else{
            $(".ofiFiltro").hide();
        	$("#dSubOficina").text("");
        }
     });
     
     $("#formulario").submit(function(e){
		$("#formulario").attr('data-opcion', 'listaMatriculacionNacionalFiltrado');
        $("#formulario").attr('data-destino', 'tabla');
        
		abrir($(this),e,false);
	});
</script>
