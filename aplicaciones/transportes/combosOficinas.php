<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCatastro.php';

$conexion = new Conexion();
$cc = new ControladorCatastro();

$provincia = htmlspecialchars ($_POST['provinciaFiltro'],ENT_NOQUOTES,'UTF-8');

   
    if($provincia != null){
        
        $oficina = $cc->obtenerOficinaXProvincia($conexion, $provincia);
        
        echo '
			<select id="oficinaFiltro" name="oficinaFiltro" >
			<option value="" selected="selected" >Seleccione....</option>';
        while ($fila = pg_fetch_assoc($oficina)){
            echo '<option value="' . $fila['oficina'] . '">' .  $fila['oficina'] . '</option>';
        }
        echo '</select>';
    }


?>

<script type="text/javascript">

	$(document).ready(function(){
		distribuirLineas();	
	});

</script>
