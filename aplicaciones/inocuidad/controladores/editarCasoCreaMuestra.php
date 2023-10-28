<?php
/**
 * Created by PhpStorm.
 * User: ccarrera
 * Date: 2/1/18
 * Time: 11:52 PM
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'ControladorRequerimiento.php';
require_once 'ControladorMuestra.php';
require_once '../../../clases/Conexion.php';
require_once '../Modelo/Caso.php';
require_once '../controladores/ControladorMailCasosInspectorEnviar.php';
require_once '../controladores/ControladorMailCasosPlanificadorEnviar.php';
require_once '../controladores/ControladorMailCasosPlanificadorRechazar.php';

$conexion = new Conexion();
$controladorRequerimiento = new ControladorRequerimiento($conexion);
$controladorMuestra = new ControladorMuestra($conexion);
$controladorMailCasosInspectorEnviar = new ControladorMailCasosInspectorEnviar($conexion);
$ControladorMailCasosPlanificadorEnviar = new ControladorMailCasosPlanificadorEnviar($conexion);
$ControladorMailCasosPlanificadorRechazar = new ControladorMailCasosPlanificadorRechazar($conexion);

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';


$requerimientoId=isset($_POST['ic_requerimiento_id']) ? $_POST['ic_requerimiento_id'] : null;
$perfil = trim($_POST['perfilUsuario']);


$arrayParametros = array(
    'cod_producto' => $_POST['cod_producto'],
    'cod_provincia' => $_POST['cod_provincia'],
    'cod_programa' => $_POST['cod_programa'],
    'tipo_requerimiento_id' => $_POST['tipo_requerimiento_id'],
    'muestras' => $_POST['muestras'],
    'respuesta' => $_POST['respuesta'],
    'observacion_planificador_envio' => $_POST['observacion_planificador_envio'],
    );


//Llama a metodo Guardar de Caso
$resultado= $controladorRequerimiento->creaMuestra($requerimientoId,$perfil,$arrayParametros);

//Creamos a continuación la muestra, a partir del caso.
if($resultado[0]!= ''){
    if($perfil != 0 || $arrayParametros['tipo_requerimiento_id'] == 'DN' || $arrayParametros['tipo_requerimiento_id'] == 'NE'){
        foreach ($resultado as $valor) {
            $muestra = $controladorMuestra->getMuestra($valor);
            $auditoria = new ControladorAuditoria();
            $auditoria->auditarRegistroInsert($_SESSION['usuario'],$muestra);
            // $i++;
        }
        if( trim($_POST['perfilUsuario']) == 1 && $_POST['respuesta'] == 'enviar'){
       
            $mail = $ControladorMailCasosPlanificadorEnviar->enviarMailCasoPlanVigilancia($_POST['ic_requerimiento_id']);
        }
        
    }else{
        $muestra = $controladorMuestra->getMuestra($resultado);
        $auditoria = new ControladorAuditoria();
        $auditoria->auditarRegistroInsert($_SESSION['usuario'],$muestra);
    }
}else{
    
    if($_POST['perfilUsuario'] == 1 && $_POST['respuesta'] == 'rechazar'){
        $arrayParametros = array(
            'ic_requerimiento_id' => $_POST['ic_requerimiento_id'],
            'observacion_planificador_envio' => $_POST['observacion_planificador_envio'],
            'respuesta' => $_POST['respuesta']
        );
        $mail = $ControladorMailCasosPlanificadorRechazar->enviarMailCasoPlanVigilancia($arrayParametros);

    }else{
        $mail = $controladorMailCasosInspectorEnviar->enviarMailCasoPlanVigilancia($_POST['ic_requerimiento_id']);
    }
}

if($resultado!=null){
    $mensaje['estado'] = 'exito';
    $mensaje['mensaje'] = 'Se ha enviado el Caso con Éxito!';
}else{
    $mensaje['estado'] = 'fallo';
    $mensaje['mensaje'] = 'No se pudo registrar el requerimiento!';
}
echo json_encode($mensaje);