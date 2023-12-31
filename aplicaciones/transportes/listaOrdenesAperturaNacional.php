<?php
session_start();
?>

<header>
	<h1>Reapertura de Órdenes Generadas - Nacional</h1>
	<nav>
	<form id="listaOrdenesAperturaNacional" data-rutaAplicacion="transportes" data-opcion="listaOrdenesAperturaNacionalFiltrado" data-destino="tabla">
		<table class="filtro">
			<tr>
				<th>Orden</th>

				<td>Número:</td>
				
				<td>
					<input type="text" id="numeroOrden" name="numeroOrden" required="required"/>
				</td>
				
				<td>Tipo:</td>
				
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
	$("#listaOrdenesAperturaNacional").submit(function(e){
		abrir($(this),e,false);
	});
	
	$(document).ready(function(){
		$("#listadoItems").removeClass("comunes");
		$("#listadoItems").addClass("lista");
		$("#detalleItem").html('<div class="mensajeInicial">Seleccione una orden para visualizar.</div>');
	});
</script>
