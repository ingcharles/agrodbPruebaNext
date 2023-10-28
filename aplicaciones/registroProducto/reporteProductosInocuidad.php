<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorAplicaciones.php';
require_once '../../clases/ControladorCatalogos.php';

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
	<header> </header>
	<div>
		<h2>Reporte Productos Insumos Agrícolas</h2>
	</div>

	<form id='reporteProductosInocuidad'
		action="aplicaciones/registroProducto/reporteImprimirProductosInocuidadPlaguicidaNuevo.php"
		data-rutaAplicacion='registroProducto' target="_self" method="post">
		<div style="text-align: center;">
			<button type="submit">Generar reporte Excel</button>
		</div>
	</form>

	<form id='reporteProductosInocuidadVUE'
		action="aplicaciones/registroProducto/reporteImprimirProductosInocuidadPlaguicidaNuevoVUE.php"
		data-rutaAplicacion='registroProducto' target="_self" method="post">
		<div style="text-align: center;">
			<button type="submit">Generar reporte VUE en Excel</button>
		</div>
	</form>
	<div>
		<h2>Reporte Productos Insumos Veterinarios</h2>
	</div>

	<form id='reporteProductosInocuidad'
		action="aplicaciones/registroProducto/reporteImprimirProductosInocuidadVeterinaria.php"
		data-rutaAplicacion='registroProducto' target="_self" method="post">
		<div style="text-align: center;">
			<button type="submit">Generar reporte Excel</button>
		</div>
	</form>
	
	<div>
		<h2>Reporte Productos Registro de Insumos Fertilizantes</h2>
	</div>

	<form id='reporteProductosRegistroInsumosFretilizante'
		action="aplicaciones/registroProducto/reporteImprimirProductosInsumosFertilizante.php"
		data-rutaAplicacion='registroProducto' target="_self" method="post">
		<div style="text-align: center;">
			<button type="submit">Generar reporte Excel</button>
		</div>
	</form>
	
</body>
<script>
	$(document).ready(function(){

		$("#detalleItem").html('<div class="mensajeInicial">Reportes productos inocuidad.</div>');
	});
</script>
</html>
