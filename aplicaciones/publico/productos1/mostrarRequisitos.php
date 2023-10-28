
<?php
require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorRequisitos.php';

$conexion = new Conexion();
$cr = new controladorRequisitos();
 
echo '<table class="noImprimir">
		<tr><td></td></tr>
		<tr><td><span class="detalleImpreso" >Requisito que únicamente se muestra en el certificado impreso.</span></td></tr>
	</table>';
 
echo '<div class="soloImpresion">
		<h1>Requisitos de comercio exterior para productos</h1>
		<h2>Agrocalidad - Ecuador</h2>
	</div>';


for ($n = 0; $n < count ( $_POST['producto']); $n++){
	$producto = pg_fetch_assoc($cr->mostrarDatosGeneralesDeProducto($conexion, $_POST['producto'][$n]));
?>

<hr />
<fieldset>
	<legend>Datos generales</legend>
	<table>
		<tr>
			<th>Tipo</th>
			<td><?php echo $producto['tipo']?></td>
		</tr>
		<tr>
			<th>Subtipo</th>
			<td><?php echo $producto['subtipo']?></td>
		</tr>
		<tr>
			<th>Nombre de producto <i>(nombre científico)</i>
			</th>
			<td><?php echo $producto['producto']?> <i>(<?php echo $producto['cientifico']?>)
			</i></td>
		</tr>
		<tr>
			<th>Partida recomendada</th>
			<td><?php echo $producto['partida_arancelaria']?></td>
		</tr>
		<tr>
			<th>Unidad de medida según arancel</th>
			<td><?php echo $producto['unidad_medida']?></td>
		</tr>
		<tr>
			<th>Código de Agrocalidad</th>
			<td>A<?php echo $producto['codigo_producto']?>
			</td>
		</tr>
	</table>

</fieldset>
<?php
if($_POST['tipoRequisito']!="('Importación','Exportación','Tránsito')"){
$requisitos=$cr->mostrarRequisitosFiltro($conexion, $_POST['tipoArea'], $_POST['pais'], $_POST['tipoRequisito'],$_POST['producto'][$n]);
	
while ($registro = pg_fetch_assoc($requisitos)) {
	$requisitoPais = json_decode($registro[row_to_json], true);
	if(count((array)$requisitoPais['requisito_pais'])>0){
		echo '<fieldset class="requisitos ocultado">' ;
			echo '<legend>' . $requisitoPais['nombre_pais'] . '</legend>';
			echo  '<div class="mapa">'.
					'<button type="button" class="mas"><span></span></button>';
			echo '<div style="display:none" class="mensajeImpresion"></div>';
		
		
			$requisitosDeExportacion = array();
			$requisitosDeImportacion = array();
			$requisitosDeTransito = array();
			 
			foreach ((array)$requisitoPais['requisito_pais'] as $tipoRequisito) { //CASTING A ARRAY PARA EVITAR EL WARNING
		            $requisitoTemporal = '<tr ><td class="ordinal"' . $tipoRequisito['orden'] . '</td><td class="requisito"><pre>';
		            if ($tipoRequisito['detalle']!='')
		            	$requisitoTemporal .= $tipoRequisito['detalle'] . '<br/>';
		
		            if($tipoRequisito['detalle_impreso'] != '')
		            	$requisitoTemporal .= '<span class="detalleImpreso">' . $tipoRequisito['detalle_impreso'] . '</span>';
		            $requisitoTemporal .= '</pre></td></tr>';
		
		            if ($tipoRequisito['tipo'] == 'Exportación'){
		            	$requisitosDeExportacion[] = $requisitoTemporal;
		          	} else if($tipoRequisito['tipo'] == 'Importación'){
		            	$requisitosDeImportacion[] = $requisitoTemporal;
					}else if($tipoRequisito['tipo'] == 'Tránsito'){
						$requisitosDeTransito[] = $requisitoTemporal;
					}
		   
		        }
		
		         
		        if (count($requisitosDeExportacion)) {
		            echo '<div class="exp">Requisitos para exportación</div>' .
		              '<div><table class="exp">';
		            foreach ($requisitosDeExportacion as $tipoRequisito)
		            	echo $tipoRequisito;
		            echo '</table></div>';
		        }
		        if (count($requisitosDeImportacion)) {
		            echo '<div class="imp">Requisitos para importación</div>' .
		              '<div><table class="imp">';
		            foreach ($requisitosDeImportacion as $tipoRequisito)
		            	echo $tipoRequisito;
		            echo '</table></div>';
		        }
		        
		        if (count($requisitosDeTransito)) {
		        	echo '<div class="tra">Requisitos para tránsito internacional</div>' .
		        			'<div><table class="tra">';
		        	foreach ($requisitosDeTransito as $tipoRequisito)
		        		echo $tipoRequisito;
		        	echo '</table></div>';
		        }

			echo '</fieldset>';
		}
}
}

if($_POST['tipoArea']=='IAV' || $_POST['tipoArea']=='IAF'){
$res=$cr->buscarDatosEspecificosProductosIAVIAP($conexion, $_POST['tipoArea'], $_POST['producto'][$n]);

echo '<fieldset>
		<legend>Datos Especificos</legend>
		<table>';
		while ($registro = pg_fetch_assoc($res)) {
			$usoss=null;
			$presentaciones=null;
			$formuladores=null;
			$composiciones = null;
			$registros = json_decode($registro[row_to_json], true);
			
			echo '<tr><th>Número de registro</th>';
			echo '<td style="text-aling=right;">'.$registros['numero_registro'].'</td>';
			echo '</tr>';
			
			echo '<tr><th>Titular</th>';
			echo '<td>'.$registros['razon_social'].'</td>';
			echo '</tr>';
			
			echo'<tr>';		
			echo'<th>Fabricante/Formulador</th>';
			foreach ((array)$registros['formulador'] as $formulador) {
				$formuladores.=$formulador['nombre_ff'].' - '.$formulador['pais_origen'].', ';
			}
			echo '<td>'.rtrim ($formuladores, ' ,' ).'</td></tr>';
			
			echo'<tr><th>Uso Autorizado</th>';
			foreach ((array)$registros['usos'] as $usos) {
				$usoss.=$usos['nombre_uso'].' Aplicado a '. $usos['nombre_producto_inocuidad'].', ';
			}
			echo '<td>'.rtrim ($usoss, ' ,' ).'</td></tr>';
			
			echo'<tr><th>Presentaciones</th>';
			foreach ((array)$registros['presentacion'] as $presentacion) {
				$presentaciones.=$presentacion['presentacion'].' '.$presentacion['unidad_medida'].', ';
			}
			echo '<td>'. rtrim ($presentaciones, ' ,' ).'</td></tr>';
			
			if($_POST['tipoArea']!='IAV'){
				echo'<tr><th>Composición</th>';
				foreach ((array)$registros['composicion'] as $composicion) {
					$composiciones.= $composicion['tipo_componente'].': '.$composicion['ingrediente_activo'].' '.$composicion['concentracion'].' '.$composicion['unidad_medida'].' + ';
				}
				echo '<td>'. rtrim ($composiciones, ' +' ).'</td></tr>';
			}			
		}
		
		echo '</table>
		</fieldset>';

}else if($_POST['tipoArea']=='IAP' ){
    $res=$cr->buscarDatosEspecificosProductosIAVIAP($conexion, $_POST['tipoArea'], $_POST['producto'][$n]);
    
    echo '<fieldset>
		<legend>Datos Especificos Plaguicidas</legend>
		<table>';
    while ($registro = pg_fetch_assoc($res)) {
        $usoss=null;
        $presentaciones=null;
        $formuladores=null;
        $composiciones = null;
        $registros = json_decode($registro[row_to_json], true);
        
        echo '<tr><th>Número de registro</th>';
        echo '<td style="text-aling=right;">'.$registros['numero_registro'].'</td>';
        echo '</tr>';
        
        echo '<tr><th>Titular</th>';
        echo '<td>'.$registros['razon_social'].'</td>';
        echo '</tr>';
        
        echo'<tr>';
        echo'<th>Fabricante/Formulador</th>';
        foreach ((array)$registros['formulador'] as $formulador) {
            $formuladores.=$formulador['tipo'].': '.$formulador['nombre_ff'].' - '.$formulador['pais_origen'].' , ';
        }
        echo '<td>'.rtrim ($formuladores, ' ,' ).'</td></tr>';
        
        echo'<tr><th>Uso Autorizado</th>';
        foreach ((array)$registros['usos'] as $usos) {
            $usoss.='Cultivo: '.$usos['cultivo_nombre_comun'].' <i>('.$usos['cultivo_nombre_cientifico'].')</i>, Plaga: ' . $usos['plaga_nombre_comun'].' <i>('.$usos['plaga_nombre_cientifico'].
            ')</i>, Dosis: ' . $usos['dosis'].' '.$usos['unidad_dosis'].', Gasto Agua: ' . $usos['gasto_agua'].' '.$usos['unidad_gasto_agua'].', Periodo carencia: '.$usos['periodo_carencia'].'; ';
        }
        echo '<td>'.rtrim ($usoss, ' ;' ).'</td></tr>';
        
        echo'<tr><th>Presentaciones</th>';
        foreach ((array)$registros['presentacion'] as $presentacion) {
            $presentaciones.='Partida: ' . $presentacion['partida_arancelaria'].' '.$presentacion['codigo_complementario'].' '.$presentacion['codigo_suplementario'].' - '.
                'Cod Producto: ' . $presentacion['codigo_producto'].' - '.'Presentación: '.$presentacion['presentacion'].' '.$presentacion['unidad_medida'].', ';
        }
        echo '<td>'. rtrim ($presentaciones, ' ,' ).'</td></tr>';
        
        echo'<tr><th>Composición</th>';
        foreach ((array)$registros['composicion'] as $composicion) {
            $composiciones.= $composicion['tipo_componente'].' '.$composicion['ingrediente_activo'].' '.$composicion['concentracion'].' '.$composicion['unidad_medida'].', ';
        }
        echo '<td>'. rtrim ($composiciones, ' +' ).'</td></tr>';
        
        echo '<tr><th>Estabilidad</th>';
        echo '<td>'.$registros['estabilidad'].'</td>';
        echo '</tr>';
        
        echo '<tr><th>Formulación</th>';
        echo '<td>'.$registros['formulacion'].'</td>';
        echo '</tr>';
        
        echo '<tr><th>Categoría Toxicológica</th>';
        echo '<td>'.$registros['categoria_toxicologica'].'</td>';
        echo '</tr>';
        
        echo '<tr><th>Período de Reingreso</th>';
        echo '<td>'.$registros['periodo_reingreso'].'</td>';
        echo '</tr>';
        
        echo '<tr><th>Fecha de registro</th>';
        echo '<td>'.$registros['fecha'].'</td>';
        echo '</tr>';
        
        echo '<tr><th>Estado del Registro</th>';
        echo '<td>'.$registros['estado'].'</td>';
        echo '</tr>';

    }
    
    echo '</table>
		</fieldset>';
    
}
}


?>


<script>

    $(document).ready(function(){

        $("fieldset.requisitos table").each(function(){
            $(this).find(".ordinal").each(function(contador){
                $(this).html("R" + (contador+1));
            });
        });
        
        $("fieldset div.mapa button").each(function () {
            $(this).parent().find("div").hide();
        });
       
    });


	$("fieldset").on("click","div.mapa button",function () {
	   visualizarPantalla = $(this).parent().find("div");
	   visualizarImpreso =$(this).parent().parent();
        if ($(this).hasClass("mas")) {
            $(this).removeClass("mas");
            $(this).addClass("menos");
            visualizarPantalla.show();
            visualizarImpreso.removeClass("ocultado");
        } else {
        	$(this).removeClass("menos");
            $(this).addClass("mas");
            visualizarPantalla.hide();
            visualizarImpreso.addClass("ocultado");
        }
    });
    

</script>
