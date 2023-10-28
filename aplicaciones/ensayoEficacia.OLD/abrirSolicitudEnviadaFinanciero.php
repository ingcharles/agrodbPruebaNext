<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorCertificados.php';
require_once '../../clases/ControladorRevisionSolicitudesVUE.php';
require_once '../../clases/ControladorEnsayoEficacia.php';
require_once '../../clases/ControladorCatalogos.php';

$conexion = new Conexion();
$cce = new ControladorCertificados();
$crs = new ControladorRevisionSolicitudesVUE();
$cee = new ControladorEnsayoEficacia();
$cca = new ControladorCatalogos();

$idSolicitud = $_POST['id'];
$condicion = $_POST['opcion'];

$res = $cee->abrirSolicitud($conexion, $idSolicitud);
$filaSolicitud = pg_fetch_assoc($res);

$estadoActual = $filaSolicitud['estado'];

if ($estadoActual == 'verificacion') {
    $qIdGrupo = $crs->buscarIdGrupo($conexion, $idSolicitud, 'ensayoEficacia', 'Financiero');
    $idGrupo = pg_fetch_assoc($qIdGrupo);
}

if ($idGrupo['id_grupo'] != '') {
    $ordenPago = $cce->obtenerIdOrdenPagoXtipoOperacion($conexion, $idGrupo['id_grupo'], $idSolicitud, 'ensayoEficacia');
}


if ($condicion == 'pago') {
    echo '<input type="hidden" class= "abrirPago" id="' . $idSolicitud . '-' . $filaSolicitud['identificador_operador'] . '-' . $estadoActual . '-ensayoEficacia-tarifarioNuevo-' . $filaSolicitud['forma_pago'] . '" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-nombre = "' . $idGrupo['id_grupo'] . '"/>';
} else if ($condicion == 'verificacionVUE' && pg_num_rows($ordenPago) != 0) {
    echo '<input type="hidden" class= "abrirPago" id="' . $idSolicitud . '-' . $filaSolicitud['identificador_operador'] . '-' . $estadoActual . '-ensayoEficacia-tarifarioNuevo-' . $filaSolicitud['forma_pago'] . '" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-nombre = "' . $idGrupo['id_grupo'] . '"/>';
} else if ($condicion == 'verificacion' && pg_num_rows($ordenPago) == 0) {
    echo '<input type="hidden" class= "abrirPago" id="' . $idSolicitud . '-' . $filaSolicitud['identificador_operador'] . '-pago-ensayoEficacia-tarifarioAntiguo-' . $filaSolicitud['forma_pago'] . '" data-rutaAplicacion="financiero" data-opcion="asignarMontoSolicitud" data-destino="ordenPago" data-nombre = "' . $idGrupo['id_grupo'] . '"/>';
} else if ($condicion == 'verificacion' && pg_num_rows($ordenPago) != 0) {
    $numeroOrdenPago = pg_fetch_result($ordenPago, 0, 'id_pago');
    echo '<input type="hidden" class= "abrirPago" id="' . $idSolicitud . '-' . $filaSolicitud['identificador_operador'] . '-' . $estadoActual . '-ensayoEficacia-' . $numeroOrdenPago . '" data-rutaAplicacion="financiero" data-opcion="finalizarMontoSolicitud" data-destino="ordenPago" data-nombre = "' . $idGrupo['id_grupo'] . '"/>';
}

?>

<header>
    <h1>Solicitud de Ensayo de Eficacia</h1>
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
    <legend>Datos de solicitud</legend>
    <div data-linea="1">
        <label>Tipo de solicitud: </label> <?php echo $cee->tipoSolicitud($filaSolicitud['tipo_solicitud']); ?>
    </div>

    <div data-linea="2">
        <label>Tipo de producto: </label> <?php echo $cee->tipoProducto($filaSolicitud['tipo_producto']); ?>
    </div>

    <div data-linea="3">
        <label>Producto: </label> <?php echo $filaSolicitud['producto']; ?>
    </div>

    <div data-linea="4">
        <label>Título del ensayo: </label> <?php echo $filaSolicitud['titulo_ensayo']; ?>
    </div>

    <div data-linea="5">
        <label>Categoría toxicológica: </label> <?php echo $filaSolicitud['nombre_categoria_toxicologica']; ?>
    </div>
</fieldset>

<fieldset>
    <legend>Datos de solicitud</legend>
    <div data-linea="1">
        <label>Ficha técnica: </label> <?php echo $filaSolicitud['ruta_ficha_tecnica'] == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$filaSolicitud['ruta_ficha_tecnica'].' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>'; ?>
    </div>

    <div data-linea="2">
        <label>Permiso de importación de muestra: </label> <?php echo $filaSolicitud['ruta_permiso_importacion_muestra'] == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$filaSolicitud['ruta_permiso_importacion_muestra'].' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>'; ?>
    </div>

    <div data-linea="3">
        <label>Protocolo: </label> <?php echo $filaSolicitud['ruta_protocolo'] == '0' ? '<span class="alerta">No ha subido ningún archivo aún</span>':'<a href='.$filaSolicitud['ruta_protocolo'].' target="_blank" class="archivo_cargado" id="archivo_cargado">Archivo Cargado</a>'; ?>
    </div>

</fieldset>

<div id="ordenPago"></div>

<script type="text/javascript">

    $(document).ready(function () {
        abrir($(".abrirPago"), null, false);
        distribuirLineas();
    });

</script>