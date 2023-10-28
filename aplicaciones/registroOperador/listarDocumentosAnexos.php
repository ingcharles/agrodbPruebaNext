<?php
    session_start();
    require_once '../../clases/Conexion.php';
    require_once '../../clases/ControladorAplicaciones.php';
    require_once '../../clases/ControladorRegistroOperador.php';

    
    function reemplazarCaracteres($cadena){
    	
    	$cadena = str_replace('á', 'a', $cadena);
    	$cadena = str_replace('é', 'e', $cadena);
    	$cadena = str_replace('í', 'i', $cadena);
    	$cadena = str_replace('ó', 'o', $cadena);
    	$cadena = str_replace('ú', 'u', $cadena);
    	$cadena = str_replace('ñ', 'n', $cadena);
    
    	$cadena = str_replace('Á', 'A', $cadena);
    	$cadena = str_replace('É', 'E', $cadena);
    	$cadena = str_replace('Í', 'I', $cadena);
    	$cadena = str_replace('Ó', 'O', $cadena);
    	$cadena = str_replace('Ú', 'U', $cadena);
    	$cadena = str_replace('Ñ', 'N', $cadena);
    
    	return $cadena;
    }

    $filtro = '';
    if(isset($_POST['tipo_documento']) and $_POST['tipo_documento'] != ''){
        $filtro = $filtro . " unaccent(nombre_documento) ilike unaccent('%" . $_POST['tipo_documento'] . "%') and ";
    }
    if(isset($_POST['descripcion_documento']) and $_POST['descripcion_documento'] != ''){
        $filtro = $filtro . " unaccent(oda.descripcion) ilike unaccent('%" . $_POST['descripcion_documento'] . "%') and ";
    }
    if(isset($_POST['fecha_documento']) and $_POST['fecha_documento'] != ''){
        $filtro = $filtro . " TO_CHAR(oda.fecha, 'DD/MM/YYYY') = '" . $_POST['fecha_documento'] . "' and ";
    }

    $conexion = new Conexion();
    $cr = new ControladorRegistroOperador();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

    <header>
        <h1>Documentos</h1>
    </header>

    <header>
        <nav>
            <form id="filtrarDocumentosAnexos" data-rutaAplicacion="registroOperador" data-opcion="listarDocumentosAnexos" data-destino="areaTrabajo #listadoItems" >
                <input type="hidden" name="opcion" value="<?php echo $_POST['opcion']; ?>" />
                <input type="hidden" id="identificadorResponsableH" name="identificadorResponsableH" value="<?php echo $_SESSION['usuario']; ?>" />

                <table class="filtro" style='width: 100%;' >
                    <tbody>
                    <tr>
                        <th colspan="4">Busar por:</th>                 
                    </tr>

                    <tr>
                        <td align="left">Tipo de documento:</td>
                        <td ><input id="tipo_documento" type="text" name="tipo_documento" style="width: 100%;"/></td>       
                    </tr>

                    <tr>
                        <td align="left">Descripción:</td>
                        <td ><input id="descripcion_documento" type="text" name="descripcion_documento" style="width: 100%;"/></td>     
                    </tr>

                    <tr>
                        <td align="left">Fecha de carga:</td>
                        <td ><input id="fecha_documento" type="text" name="fecha_documento" style="width: 100%;"/></td>     
                    </tr>

                    <tr>
                        <td colspan="4" style='text-align:center'><button>Buscar</button></td>  
                    </tr>
                    <tr>
                        <td colspan="4" style='text-align:center' id="mensajeError"></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </nav>
    </header>

<header>
    <nav>

        <?php
            $ca = new ControladorAplicaciones('registroOperador', 'abrirDocumentoAnexo');
            $res = $ca->obtenerAccionesPermitidas($conexion, $_POST["opcion"], $_SESSION['usuario']);

            while ($fila = pg_fetch_assoc($res)) {
                echo '<a href="#"
						id="' . $fila['estilo'] . '"
						data-destino="detalleItem"
						data-opcion="' . $fila['pagina'] . '"
						data-rutaAplicacion="' . $fila['ruta'] . '"
						>' . (($fila['estilo'] == '_seleccionar') ? '<div id="cantidadItemsSeleccionados">0</div>' : '') . $fila['descripcion'] . '</a>';
            }
        ?>
    </nav>
</header>

    <?php
        
        $res = $cr->listarDocumentosAnexosFiltro($conexion, $_SESSION['usuario'], $filtro);
        $contador = 0;

        while($fila = pg_fetch_assoc($res))
        {
            $categoria = reemplazarCaracteres($fila['provincia']);
            $itemsFiltrados[] = array('<tr
                                id="'.$fila['id'].'"
                                class="item"
                                data-rutaAplicacion="registroOperador"
                                data-opcion="abrirDocumentoAnexo"
                                ondragstart="drag(event)"
                                draggable="true"
                                data-destino="detalleItem">
                                <td style="white-space:nowrap;"><b>'.++$contador.'</b></td>
                                <td>'.$fila['nombre_documento'].'.'.$fila['codigo_provincia'].$fila['codigo'].'</td>
                                <td>'.$fila['descr'].'</td>
                                <td>'.$fila['fecha_formateada'].'</td>
                            </tr>');
        }
    ?>      


<div id="paginacion" class="normal"></div>
<table id="tablaItems">
    <thead>
        <tr>
            <th>#</th>
            <th>Tipo de documento</th>
            <th>Descripción</th>
            <th>fecha de carga</th>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
$(document).ready(function(){
     $(document).ready(function(){
        $("#listadoItems").removeClass("comunes");
        $("#listadoItems").addClass("lista");
        construirPaginacion($("#paginacion"),<?php echo json_encode($itemsFiltrados);?>);   
    });

    $("#filtrarDocumentosAnexos").submit(function(event){
        event.preventDefault();
        $(".alertaCombo").removeClass("alertaCombo");
        var error = false;
        
        if(!error){
            abrir($(this),event,false);
            $("#detalleItem").html('<div class="mensajeInicial">Arrastre aqui un registro para revisarlo.</div>');
        }   
    });

    $("#fecha_documento").datepicker({
        changeMonth: true,
        changeYear: true
      });
});
</script>

</body>
</html>