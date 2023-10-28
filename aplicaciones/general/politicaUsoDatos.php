<?php
session_start();
require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorUsuarios.php';

$conexion = new Conexion();
$cu = new ControladorUsuarios();

$identificador = $_SESSION['usuario'];
$aceptarPolitica = true;

$cu->actualizarPoliticaProteccionDatos($conexion, $aceptarPolitica, $identificador);

echo json_encode(array(
    'validacion' => 'Exito'
));
