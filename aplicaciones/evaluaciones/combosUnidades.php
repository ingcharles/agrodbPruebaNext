<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEstructuraFuncionarios.php';

$conexion = new Conexion();
$ce = new ControladorEstructuraFuncionarios();

$idArea = htmlspecialchars ($_POST['idArea'],ENT_NOQUOTES,'UTF-8');
$tipo = htmlspecialchars ($_POST['tipo'],ENT_NOQUOTES,'UTF-8');
$opcion = htmlspecialchars ($_POST['tipoEvaluacion'],ENT_NOQUOTES,'UTF-8');

switch ($opcion){
    case 'Nacional':
        
        echo '<label>Usuarios:</label>
			<select id="tipoUsuario" name="tipoUsuario" required>
			<option value="">Seleccione....</option>
            <option value="Todos">Todos (Funcionarios-Servicios Profesionales)</option>
            <option value="Internos">Funcionarios Internos</option>
            </select>';
        break;
        
    case 'Unidad':
        
        $unidades = $ce->obtenerEstructuraPlantaCentral($conexion);
        
        echo '<label>Coordinación/Dirección:</label>
			<select id="idUnidad" name="idUnidad" required>
			<option value="">Seleccione....</option>';
        while ($fila = pg_fetch_assoc($unidades)){
            echo '<option value="' . $fila['id_area'] . '">' . $fila['nombre'] . '</option>';
        }
        echo '</select>';
        break;
        
    case 'Individual':
        
        echo '<div data-linea="1">
        <label>Identificador:</label>
        <input type="text" id="identificadorUsuario" name="identificadorUsuario" data-er="^[0-9]+$" required="required" maxlength="10"/>
        </div>
            
        <div data-linea="2">
        <div id="dSubDatosUsuario"></div>
        </div>';
        break;
        
    default:
        echo 'Tipo desconocido';
}
   
?>

<script type="text/javascript">

	$(document).ready(function(){
		distribuirLineas();	
	});
	
	$("#identificadorUsuario").change(function(event){
		$("#nombreUsuario").val("");
		$("#apellidoUsuario").val("");
		
		$("#formularioUsuario").attr('data-opcion', 'combosUsuarios');
	    $("#formularioUsuario").attr('data-destino', 'dSubUsuario');
	    abrir($("#formularioUsuario"), event, false); //Se ejecuta ajax
	});

</script>
