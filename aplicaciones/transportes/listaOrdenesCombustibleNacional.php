<?php
session_start();
?>

<header>
	<h1>Eliminación de Órdenes Generadas - Nacional</h1>
	<nav>
	<form id="listaOrdenesCombustibleNacional" data-rutaAplicacion="transportes" data-opcion="listaOrdenesCombustibleNacionalFiltrado" data-destino="tabla">
		<table class="filtro">
			<tr>
				<th>Orden</th>

				<td>número:</td>
				
				<td>
					<input type="text" id="numeroOrden" name="numeroOrden" required="required"/>
				</td>
			
				<td>
					<select id="tipoOrden" name="tipoOrden" required="required">
						<option value="Combustible" >Combustible</option>
						<option value="Mantenimiento" >Mantenimiento</option>
						<option value="Movilizacion" >Movilización</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="5"><button>Filtrar lista</button></td>
			</tr>
		</table>
		</form>
		
	</nav>
	
	
</header>



<div id="tabla"></div>
<script>
	$("#listaOrdenesCombustibleNacional").submit(function(e){
		abrir($(this),e,false);
	});
	
	$(document).ready(function(){
		$("#listadoItems").removeClass("comunes");
		$("#listadoItems").addClass("lista");
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione una orden para eliminar.</div>');
	});
</script>
