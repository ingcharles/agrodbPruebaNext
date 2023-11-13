<?php

require_once '../../../clases/Conexion.php';
require_once '../../../clases/ControladorUsuarios.php';
require_once '../../../clases/ControladorMonitoreo.php';
require_once '../../../clases/ControladorAplicaciones.php';
require_once '../../../clases/ControladorMovilizacionVegetal.php';
require_once '../../../clases/ControladorGestionAplicacionesPerfiles.php';

if($_SERVER['REMOTE_ADDR'] == ''){
//if (1) {
    $conexion = new Conexion();
    $cu = new ControladorUsuarios();
    $cm = new ControladorMonitoreo();
    $ca = new ControladorAplicaciones();
    $cmv = new ControladorMovilizacionVegetal();
    $cgap = new ControladorGestionAplicacionesPerfiles();


    $resultadoMonitoreo = $cm->obtenerCronPorCodigoEstado($conexion, 'CRON_ASIG_MOVI_VEGE');

    if($resultadoMonitoreo){
    //if (1) {

        define('IN_MSG', '<br/> >>> ');

        $fecha = date("Y-m-d h:m:s");
        echo IN_MSG . '<p><strong> INICIO REGISTRO ASIGNACION MÓDULO DE MOVILIZACIÓN DE PRODUCTOS DE SANIDAD VEGETAL ' . $fecha . '</strong></p>';

        $qSolicitudProducto = $cmv->obtenerIdentificadorAsignarAplicacion($conexion);

        while ($solicitudProducto = pg_fetch_assoc($qSolicitudProducto)) {

            $identificadorOperador = $solicitudProducto['identificador_operador'];

            echo IN_MSG . '<p> Inicio inserción de aplicacion perfil' . $identificadorOperador . '</p>';

            $modulosAgregados = "('PRG_MOV_VEG'),";
            $perfilesAgregados = "('PFL_USR_MOV'),";

            $qGrupoAplicacion = $cgap->obtenerGrupoAplicacion($conexion, '(' . rtrim($modulosAgregados, ',') . ')');

            if (pg_num_rows($qGrupoAplicacion) > 0) {
                while ($filaAplicacion = pg_fetch_assoc($qGrupoAplicacion)) {
                    if (pg_num_rows($ca->obtenerAplicacionPerfil($conexion, $filaAplicacion['id_aplicacion'], $identificadorOperador)) == 0) {
                        $cgap->guardarGestionAplicacion($conexion, $identificadorOperador, $filaAplicacion['codificacion_aplicacion']);
                        $qGrupoPerfiles = $cgap->obtenerGrupoPerfilXAplicacion($conexion, $filaAplicacion['id_aplicacion'], '(' . rtrim($perfilesAgregados, ',') . ')');
                        while ($filaPerfil = pg_fetch_assoc($qGrupoPerfiles)) {
                            $cgap->guardarGestionPerfil($conexion, $identificadorOperador, $filaPerfil['codificacion_perfil']);
                        }
                    } else {
                        $qGrupoPerfiles = $cgap->obtenerGrupoPerfilXAplicacion($conexion, $filaAplicacion['id_aplicacion'], '(' . rtrim($perfilesAgregados, ',') . ')');
                        while ($filaPerfil = pg_fetch_assoc($qGrupoPerfiles)) {
                            $qPerfil = $cu->obtenerPerfilUsuario($conexion, $filaPerfil['id_perfil'], $identificadorOperador);
                            if (pg_num_rows($qPerfil) == 0)
                                $cgap->guardarGestionPerfil($conexion, $identificadorOperador, $filaPerfil['codificacion_perfil']);
                        }
                    }
                }
            }

            echo IN_MSG . '<p> Fin inserción en aplicacion perfil</p>';

        }

        echo IN_MSG . '<p><strong> FIN REGISTRO ASIGNACION DE MÓDULO DE MOVILIZACIÓN DE PRODUCTOS DE SANIDAD VEGETAL  ' . $fecha . '</strong></p>';

    }

} else {

    $minutoS1 = microtime(true);
    $minutoS2 = microtime(true);
    $tiempo = $minutoS2 - $minutoS1;
    $xcadenota = "FECHA " . date("d/m/Y") . " " . date("H:i:s");
    $xcadenota .= "; IP REMOTA " . $_SERVER['REMOTE_ADDR'];
    $xcadenota .= "; SERVIDOR HTTP " . $_SERVER['HTTP_REFERER'];
    $xcadenota .= "; SEGUNDOS " . $tiempo . "\n";
    $arch = fopen("../../../aplicaciones/logs/cron/asignacion_modulo_movilizacion_sanidad_vegetal" . date("d-m-Y") . ".txt", "a+");
    fwrite($arch, $xcadenota);
    fclose($arch);

}


?>