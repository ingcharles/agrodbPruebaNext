<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';

$conexion = new Conexion();
$ce = new ControladorEvaluaciones();

$idArea = htmlspecialchars ($_POST['idArea'],ENT_NOQUOTES,'UTF-8');
$tipo = htmlspecialchars ($_POST['tipoEvaluacion'],ENT_NOQUOTES,'UTF-8');
$opcion = htmlspecialchars ($_POST['opcion'],ENT_NOQUOTES,'UTF-8');
$identificador = htmlspecialchars ($_POST['identificadorUsuario'],ENT_NOQUOTES,'UTF-8');

        $evaluaciones = pg_fetch_assoc($ce->informacionUsuarioInterno($conexion, $identificador));
        
        echo '<div data-linea="1">
        <label>Identificador:</label>
        <input type="text" id="identificadorUsuario" name="identificadorUsuario" required="required" readonly="readonly" value="'.$identificador.'"/>
        </div>
        <div data-linea="5">
        <label>Nombre:</label>
        <input type="text" id="nombreUsuario" name="nombreUsuario" required="required" readonly="readonly" value="'.$evaluaciones['nombre'].'"/>
        </div>
        <div data-linea="6">
        <label>Apellido:</label>
        <input type="text" id="apellidoUsuario" name="apellidoUsuario" required="required" readonly="readonly" value="'.$evaluaciones['apellido'].'"/>
        </div>';

?>

<script type="text/javascript">

	$(document).ready(function(){
		distribuirLineas();	
	});

</script>
