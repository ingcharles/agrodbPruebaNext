<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEmpleados.php';

$conexion = new Conexion();
$ce = new ControladorEmpleados();
$res = $ce->obtenerDatosCredencial($conexion, $_SESSION['usuario']);
$empleado = pg_fetch_assoc($res);
$foto = $empleado['fotografia'];
?>

<header>
	<h1>Credencial</h1>
</header>

<fieldset>
	<legend>Descargar Credencial</legend>

	<div style="display: block; text-align: center;">

		<?php 
			if($foto != ''){
		 ?>
				<img name="frente" class="" src="aplicaciones/uath/credencialfoto.php"></img>
		<?php
			}
			else{
				echo '<p> Por favor agregue una foto en la opción Personales para generar la credencial. </p>';
			}
		?>
	</div>

</fieldset>

<div>
	<?php
		if($foto != ''){
			echo '<button><a href="aplicaciones/uath/archivosPerfilPublico/credenciales/' . md5($_SESSION['usuario']) . '.png" download> Descargar </a></button>';
		}
	?>
</div>