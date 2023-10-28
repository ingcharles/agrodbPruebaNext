<?php 
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorEstructuraFuncionarios.php';

$conexion = new Conexion();
$cef = new ControladorEstructuraFuncionarios();

?>
<header>
    <nav>
        <form id="formularioUsuario" data-rutaAplicacion='evaluaciones' data-opcion='' data-destino="detalleItem" action="aplicaciones/evaluaciones/generarReporteEvaluacion.php" method="post">
			<input type='hidden' id='tipo' name='tipo' value="Interna" />
			<input type='hidden' id='opcion' name='opcion' value="reporteInterno" />
			
            <table>
                <tbody>
                <tr>        		
        			<td>Área:</td> 
        			<td colspan="3">
        				<select id="idArea" name="idArea" required>
        					<option value="">Seleccione....</option>
        					<?php 
        					   $coordinaciones = $cef->obtenerEstructuraPlantaCentralGeneral($conexion);
            					
            					while ($fila = pg_fetch_assoc($coordinaciones)){
            					    echo '<option value="' . $fila['id_area'] . '">' . $fila['nombre'] . '</option>';
        						}
        					?>
        				</select>	
        			</td>		
        		</tr>
        		<tr>
                    <td>Evaluación:</td><td colspan="3"><div id="dSubEvaluacion"></div></td>
                </tr>
                <tr>
                    <td>Identificador:</td>
                    <td><input name="identificadorFiltro" id="identificadorFiltro" type="text"></td>
                </tr>
                <tr>
                    <td>Fecha inicial:</td>
                    <td><input name="fechaInicio" id="fechaInicio" type="text" required readonly></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <button>Generar reporte</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </nav>
</header>
<script>
    $(document).ready(function () {
        var fecha = new Date();
        fecha.setMonth(fecha.getMonth() - 3);
        $("#fechaInicio").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '-5:+0',
            dateFormat: "yy-mm-dd",
            defaultDate: -1
        }).datepicker('setDate', fecha);
    });
    
    $("#idArea").change(function(event){
		$("#dSubEvaluacion").text("");
		
		$("#formularioUsuario").attr('data-opcion', 'combosEvaluaciones');
	    $("#formularioUsuario").attr('data-destino', 'dSubEvaluacion');
	    abrir($("#formularioUsuario"), event, false); //Se ejecuta ajax
	 });
</script>

