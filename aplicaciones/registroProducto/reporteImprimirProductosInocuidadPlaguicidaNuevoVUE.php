<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCatalogos.php';

$conexion = new Conexion();
$cc = new ControladorCatalogos();

//Generar reporte

    $ext   = '.xls';
    $idProducto = $_POST['idProducto'];
    
    $nomReporte = 'PartidasVUE' . $ext;
    
    header("Content-Disposition: attachment; filename=".$nomReporte."");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    echo '
                <html LANG="es">
                    <head>
                        <meta http-equiv="Content-Type" content="vnd.ms-excel;charset=utf-8">
                        <style type="text/css">
                            .formato {
                            	mso-style-parent: style0;
                            	mso-number-format: "\@";
                            }
                        </style>
                    </head>
                    <body>
                    	<div id="tabla">
                    		<table id="tablaReporteVacunaAnimal" class="soloImpresion">
                    			<thead>
                    				<tr>
                    					<th style="text-align:center;">Subpartida Arancelaria</th>
                    					<th style="text-align:center;">Codigo de Producto</th>
                    					<th style="text-align:center;">Descripcion de Producto</th>
                    					<th style="text-align:center;">Utilizacion</th>
                    				</tr>
                                    <tr>
                    					<th style="text-align:center;">-</th>
                    					<th style="text-align:center;">-</th>
                    					<th style="text-align:center;">-</th>
                    					<th style="text-align:center;">-</th>
                    				</tr>
                                    <tr>
                    					<th style="text-align:center;">prdt_hc</th>
                    					<th style="text-align:center;">prdt_cd</th>
                    					<th style="text-align:center;">prdt_desc</th>
                    					<th style="text-align:center;">use_fg</th>
                    				</tr>
                    			</thead>
                    			<tbody>
             ';
    $registros = null;
    $res = $cc-> reporteProductoPlaguicidaVUECompleto($conexion);
    
    if(pg_num_rows($res) > 0){
        while ($registros = pg_fetch_assoc($res)) {
            echo '<tr>';
            echo '    <td class="formato">'.$registros['partida_arancelaria'].$registros['codigo_complementario'].$registros['codigo_suplementario'].'</td>';
            echo '    <td class="formato">A'.$registros['codigo_producto'].'</td>';
            echo '    <td class="formato">'.$registros['nombre_comun'].'</td>';
            echo '    <td class="formato">S</td>';
            echo '</tr>';
            
            $presentaciones = null;
            $res1 = $cc-> reporteProductoPresentacionPlaguicidaVUECompleto($conexion, $registros['id_producto']);
            
            if(pg_num_rows($res1) > 0){
                while ($presentaciones = pg_fetch_assoc($res1)) {
                    echo '<tr>';
                    echo '    <td class="formato">'.$presentaciones['partida_arancelaria'].$presentaciones['codigo_complementario'].$presentaciones['codigo_suplementario'].'</td>';
                    echo '    <td class="formato">A'.$presentaciones['codigo_producto'].$presentaciones['codigo_presentacion'].'</td>';
                    echo '    <td class="formato">'.$presentaciones['nombre_comun'].';'.$presentaciones['presentacion'].' '.$presentaciones['unidad'].'</td>';
                    echo '    <td class="formato">S</td>';
                    echo '</tr>';
                }
            }
        }
    }
    
    echo '
                    			</tbody>
                    		</table>
                    	</div>
                	</body>
                </html>
            ';

?>