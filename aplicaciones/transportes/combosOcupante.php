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

if($provincia == 'Pichincha'){
    
    if($oficina != null){
        
        $ocupantes = $cc->obtenerUsuarioXOficinaXProvincia($conexion, $provincia, $oficina);
        
        echo '<label>Ocupante:</label>
			<select id="ocupante" name="ocupante" required>
			<option value="" selected="selected" >Seleccione....</option>';
        while ($fila = pg_fetch_assoc($ocupantes)){
            echo '<option value="' . $fila['identificador'] . '" data-area="'.$fila['id_gestion'].'">' . strtoupper($fila['apellido'] .' '. $fila['nombre']) . ' - ' . $fila['nombre_puesto'] . '</option>';
        }
        echo '	<option value="Otro">Otro</option>
		  </select>';
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
    
}else{
    
    $ocupantes = $cc->obtenerUsuarioXOficinaXProvincia($conexion, $provincia, $oficina);
    
    echo '<label>Ocupante:</label>
			<select id="ocupante" name="ocupante" required>
			<option value="" selected="selected" >Seleccione....</option>';
    while ($fila = pg_fetch_assoc($ocupantes)){
        echo '<option value="' . $fila['identificador'] . '" data-area="'.$fila['id_gestion'].'">' . strtoupper($fila['apellido'] .' '. $fila['nombre']) . ' - ' . $fila['nombre_puesto'] . '</option>';
    }
    echo '	<option value="Otro">Otro</option>
		  </select>';
}

?>

<script type="text/javascript">
var formulario = <?php echo json_encode($formulario); ?>;

	$(document).ready(function(){
		distribuirLineas();	
	});

	$('#ocupante').change(function(){

		$("#area").val($('#ocupante option:selected').attr('data-area'));
		
		if($('#ocupante option:selected').attr("value")=="Otro"){
			$("#opcion_ocupante").show();
			$("#area").val(" ");
		}else{
			$("#opcion_ocupante").hide();
		}
			 
	});

	$("#oficinaOcupante").change(function(event){

		$("#dSubOcupante").text("");

		$("#formulario").attr('data-opcion', 'combosOcupante');
	    $("#formulario").attr('data-destino', 'dSubOcupante');
	    abrir($("#formulario"), event, false); //Se ejecuta ajax
	 });
</script>
