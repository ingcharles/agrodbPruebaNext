<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCertificados.php';
require_once '../../clases/ControladorRevisionSolicitudesVUE.php';
require_once '../../clases/ControladorRegistroProductoRia.php';
require_once '../../clases/ControladorCatalogos.php';

$conexion = new Conexion();
$cce = new ControladorCertificados();
$crs = new ControladorRevisionSolicitudesVUE();
$crp = new ControladorRegistroProductoRia();
$cca = new ControladorCatalogos();

$idSolicitud = $_POST['id'];
$condicion = $_POST['opcion'];
$nombreProducto = '';
$productoComun = '';
$tipoPlaguicida = '';
$numeroRegistro = '';

$res = $crp->abrirSolicitud($conexion, $idSolicitud);
$filaSolicitud = pg_fetch_assoc($res);

$estadoActual = $filaSolicitud['estado'];

if ($estadoActual == 'verificacion') {
    $qIdGrupo = $crs->buscarIdGrupo($conexion, $idSolicitud, 'registroProductoRia', 'Financiero');
    $idGrupo = pg_fetch_assoc($qIdGrupo);
}

if ($idGrupo['id_grupo'] != '') {
    $ordenPago = $cce->obtenerIdOrdenPagoXtipoOperacion($conexion, $idGrupo['id_grupo'], $idSolicitud, 'registroProductoRia');
}


if ($condicion == 'pago') {
    echo '<input type="hidden" class= "abrirPago" id="' . $idSolicitud . '-' . $filaSolicitud['identificador_operador'] . '-' . $estadoActual . '-registroProductoRia-tarifarioNuevo-' . $filaSolicitud['forma_pago'] . '" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-nombre = "' . $idGrupo['id_grupo'] . '"/>';
} else if ($condicion == 'verificacionVUE' && pg_num_rows($ordenPago) != 0) {
    echo '<input type="hidden" class= "abrirPago" id="' . $idSolicitud . '-' . $filaSolicitud['identificador_operador'] . '-' . $estadoActual . '-registroProductoRia-tarifarioNuevo-' . $filaSolicitud['forma_pago'] . '" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-nombre = "' . $idGrupo['id_grupo'] . '"/>';
} else if ($condicion == 'verificacion' && pg_num_rows($ordenPago) == 0) {
    echo '<input type="hidden" class= "abrirPago" id="' . $idSolicitud . '-' . $filaSolicitud['identificador_operador'] . '-pago-registroProductoRia-tarifarioAntiguo-' . $filaSolicitud['forma_pago'] . '" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-nombre = "' . $idGrupo['id_grupo'] . '"/>';
} else if ($condicion == 'verificacion' && pg_num_rows($ordenPago) != 0) {
    $numeroOrdenPago = pg_fetch_result($ordenPago, 0, 'id_pago');
    echo '<input type="hidden" class= "abrirPago" id="' . $idSolicitud . '-' . $filaSolicitud['identificador_operador'] . '-' . $estadoActual . '-registroProductoRia-' . $numeroOrdenPago . '" data-rutaAplicacion="financiero" data-opcion="finalizarMontoSolicitud" data-destino="ordenPago" data-nombre = "' . $idGrupo['id_grupo'] . '"/>';
}

switch ($filaSolicitud['tipo_solicitud']){
    case 'bioplaguicidas':
    case 'fertilizantes':
        $nombreProducto = 'Nombre de producto';
        break;
    case 'clonesplaguicidas':
        $nombreProducto = 'Nombre del clon';
        $productoComun = '<div data-linea="5">
                               <label for="nombre_comun">Producto: </label>'. $filaSolicitud['nombre_comun'] .
                        '</div>';
        $tipoPlaguicida = '<div data-linea="2">
                               <label for="tipo_plaguicida">Tipo de plaguicida: </label>'. $filaSolicitud['tipo_plaguicida'] .
                        '</div>';
        $numeroRegistro = '<div data-linea="6">
                               <label for="numero_registro">Número de registro: </label>'. $filaSolicitud['numero_registro'] .
                        '</div>';
        break;
    case 'clonesfertilizantes':
        $nombreProducto = 'Nombre del clon';
        $productoComun = '<div data-linea="5">
                               <label for="nombre_comun">Producto: </label>'. $filaSolicitud['nombre_comun'] .
                        '</div>';
        $numeroRegistro = '<div data-linea="6">
                               <label for="numero_registro">Número de registro: </label>'. $filaSolicitud['numero_registro'] .
                        '</div>';
        break;
}

?>

<header>
    <h1>Solicitud de Registro de Producto</h1>
</header>

<fieldset>
    <legend>Datos generales</legend>
    <div data-linea="1">
        <label>Identificador: </label> <?php echo $filaSolicitud['identificador_operador']; ?>
    </div>

    <div data-linea="2">
        <label>Nombre/Razón Social: </label> <?php echo $filaSolicitud['razon_social']; ?>
    </div>

    <hr/>

    <div data-linea="3">
        <label>Representante Legal: </label> <?php echo $filaSolicitud['representante_legal']; ?>
    </div>

    <div data-linea="4">
        <label>Dirección: </label> <?php echo $filaSolicitud['direccion']; ?>
    </div>

    <div data-linea="5">
        <label>Teléfono: </label> <?php echo $filaSolicitud['telefono']; ?>
    </div>

    <div data-linea="6">
        <label>Correo electrónico: </label> <?php echo $filaSolicitud['correo']; ?>
    </div>

    <div data-linea="7">
        <label>Representante técnico: </label> <?php echo $filaSolicitud['representante_tecnico']; ?>
    </div>

</fieldset>

<fieldset>
    <legend>Producto</legend>
    <div data-linea="1">
        <label for="nombre_tipo_producto">Tipo solicitud: </label> <?php echo $crp->tipoSolicitud($filaSolicitud['tipo_solicitud']); ?>
    </div>
    <?php echo $tipoPlaguicida; ?>
    <div data-linea="3">
        <label for="nombre_tipo_producto">Tipo de producto: </label> <?php echo $filaSolicitud['nombre_tipo_producto']; ?>
    </div>
    <div data-linea="4">
        <label for="nombre_subtipo_producto">Subtipo de producto: </label> <?php echo $filaSolicitud['nombre_subtipo_producto']; ?>
    </div>
    <?php echo $productoComun;?>
    <?php echo $numeroRegistro;?>
    <div data-linea="7">
        <label for="nombre_producto"><?php echo $nombreProducto?>: </label> <?php echo $filaSolicitud['nombre_producto']; ?>
    </div>
    <div data-linea="8">
        <label for="nombre_producto">Categoría toxicológica: </label> <?php echo $filaSolicitud['nombre_categoria_toxicologica']; ?>
    </div>
    <div data-linea="9">
        <label for="requiere_descuento">Descuento: </label> <?php echo $filaSolicitud['requiere_descuento'] === 't' ? 'SI' : 'NO'; ?>
    </div>
</fieldset>

<div id="ordenPago"></div>

<script type="text/javascript">

    $(document).ready(function () {
        abrir($(".abrirPago"), null, false);
        distribuirLineas();
    });

</script>