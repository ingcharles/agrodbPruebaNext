<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorAplicaciones.php';
require_once '../controladores/ControladorLaboratorio.php';
$conexion = new Conexion();
?>
<!DOCTYPE html>
<html>
<head>
    <script src="aplicaciones/inocuidad/js/inocuidad_root.js" type="text/javascript"/>
    <meta charset="utf-8">
</head>
<body>
<header>
    <h1>Análisis Muestra</h1>
    <nav>

        <?php
        $ca = new ControladorAplicaciones();
        $res = $ca->obtenerAccionesPermitidas($conexion, $_POST["opcion"], $_SESSION['usuario']);

        while($fila = pg_fetch_assoc($res)){
            echo '<a href="#"
                            id="' . $fila['estilo'] . '"
                            data-destino="detalleItem"
                            data-opcion="' . $fila['pagina'] . '"
                            data-rutaAplicacion="' . $fila['ruta'] . '"
                            >'.(($fila['estilo']=='_seleccionar')?'<div id="cantidadItemsSeleccionados">0</div>':''). $fila['descripcion'] . '</a>';

        }
        ?>
    </nav>
</header>
<?php
    $controladorLaboratorio = new ControladorLaboratorio();
    echo $controladorLaboratorio->listArticles();
?>
</body>
<script>
    $(document).ready(function(){
        $("#listadoItems").removeClass("programas");
        $("#listadoItems").addClass("comunes");
        $("#detalleItem").html('<div class="mensajeInicial">Arrastre aquí una ficha para editarla.</div>');
    });
</script>
</html>