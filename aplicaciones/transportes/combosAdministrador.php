<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorUsuarios.php';
require_once '../../clases/ControladorAreas.php';
require_once '../../clases/ControladorCatastro.php';

$conexion = new Conexion();
$cu = new ControladorUsuarios();
$ca = new ControladorAreas();
$cc = new ControladorCatastro();

$provincia = htmlspecialchars ($_POST['provinciaOcupante'],ENT_NOQUOTES,'UTF-8');
$oficina = htmlspecialchars ($_POST['oficinaOcupante'],ENT_NOQUOTES,'UTF-8');
$formulario = htmlspecialchars ($_POST['nombreFormulario'],ENT_NOQUOTES,'UTF-8');
   
    if($oficina != null){
        
        $ocupantes = $cc->obtenerUsuarioXOficinaXProvincia($conexion, $provincia, $oficina);
        
        echo '<label>Administrador:</label>
			<select id="administrador" name="administrador" required>
			<option value="" selected="selected" >Seleccione....</option>';
        while ($fila = pg_fetch_assoc($ocupantes)){
            echo '<option value="' . $fila['identificador'] . '" data-area="'.$fila['id_gestion'].'">' . strtoupper($fila['apellido'] .' '. $fila['nombre']) . ' - ' . $fila['nombre_puesto'] . '</option>';
        }
        echo '</select>';
    }else{
        
        $oficina = $cc->obtenerOficinaXProvincia($conexion, $provincia);
        
        echo '<label>Oficina:</label>
			<select id="oficinaOcupante" name="oficinaOcupante" required>
			<option value="" selected="selected" >Seleccione....</option>';
        while ($fila = pg_fetch_assoc($oficina)){
            echo '<option value="' . $fila['oficina'] . '">' .  $fila['oficina'] . '</option>';
        }
        echo '</select>';
    }
    
?>

<script type="text/javascript">
var formulario = <?php echo json_encode($formulario); ?>;

	$(document).ready(function(){
		distribuirLineas();	
	});

	$("#oficinaOcupante").change(function(event){

		$("#dSubOcupante").text("");

		$("#formularioAdministrador").attr('data-opcion', 'combosAdministrador');
	    $("#formularioAdministrador").attr('data-destino', 'dSubOcupanteAdmin');
	    abrir($("#formularioAdministrador"), event, false); //Se ejecuta ajax
	 });
</script>
