<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorPAPP.php';

$conexion = new Conexion();
$cp = new ControladorPAPP();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

</head>
<body>

<header>
	<h1>Confirmar reinicio del catálogos</h1>
</header>

<div id="estado"></div>

	<p>Los <b>catálogos registrados para el año <?php echo date('Y')-1;?></b> serán <b>habilitados para el año <?php echo date('Y');?> </b></p>
	
	<form id="reiniciarCatalogos" data-rutaAplicacion="poa" data-opcion="reiniciarCatalogos" data-accionEnExito="ACTUALIZAR" >
    			
    	<button id="detalle" type="submit" class="guardar" >Reiniciar catálogos</button>
	
	</form>
	
</body>

<script type="text/javascript">

$(document).ready(function(){
	distribuirLineas();
});

$("#reiniciarCatalogos").submit(function(event){
  	event.preventDefault();
	ejecutarJson($(this));

});
</script>

</html>
