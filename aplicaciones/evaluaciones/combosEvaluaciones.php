<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEvaluaciones.php';

$conexion = new Conexion();
$ce = new ControladorEvaluaciones();

$idArea = htmlspecialchars ($_POST['idArea'],ENT_NOQUOTES,'UTF-8');
$tipo = htmlspecialchars ($_POST['tipo'],ENT_NOQUOTES,'UTF-8');
$opcion = htmlspecialchars ($_POST['opcion'],ENT_NOQUOTES,'UTF-8');

switch ($opcion){
    
    case 'formularioExterno':
        $evaluaciones = $ce->listarEvaluacionesXAreaXTipo($conexion, $idArea, $tipo);
        
        echo '<label>Evaluación:</label>
			<select id="idEvaluacion" name="idEvaluacion" required>
			<option value="">Seleccione....</option>';
        while ($fila = pg_fetch_assoc($evaluaciones)){
            echo '<option value="' . $fila['id_evaluacion'] . '">' . $fila['nombre'] . '</option>';
        }
        echo '</select>';
    break;
    
    case 'reporteExterno':
        $evaluaciones = $ce->listarEvaluacionesXAreaXTipo($conexion, $idArea, $tipo);
        
        echo '<td><select id="idEvaluacion" name="idEvaluacion" required>
			<option value="">Seleccione....</option>';
        while ($fila = pg_fetch_assoc($evaluaciones)){
            echo '<option value="' . $fila['id_evaluacion'] . '">' . $fila['nombre'] . '</option>';
        }
        echo '</select></td>';
    break;
    
    case 'formularioInterno':
        $evaluaciones = $ce->listarEvaluacionesXAreaXTipo($conexion, $idArea, $tipo);
        
        echo '<label>Evaluación:</label>
			<select id="idEvaluacion" name="idEvaluacion" required>
			<option value="">Seleccione....</option>';
        while ($fila = pg_fetch_assoc($evaluaciones)){
            echo '<option value="' . $fila['id_evaluacion'] . '">' . $fila['nombre'] . '</option>';
        }
        echo '</select>';
        break;
        
    case 'reporteInterno':
        $evaluaciones = $ce->listarEvaluacionesXAreaXTipo($conexion, $idArea, $tipo);
        
        echo '<td><select id="idEvaluacion" name="idEvaluacion" required>
			<option value="">Seleccione....</option>';
        while ($fila = pg_fetch_assoc($evaluaciones)){
            echo '<option value="' . $fila['id_evaluacion'] . '">' . $fila['nombre'] . '</option>';
        }
        echo '</select></td>';
        break;
    
    default:
        echo 'Tipo desconocido';
}
?>

<script type="text/javascript">

	$(document).ready(function(){
		distribuirLineas();	
	});

</script>
