<?php
session_start();

require_once '../../clases/Conexion.php';
require_once '../../clases/ControladorChat.php';


$mensaje = array();
$mensaje['estado'] = 'exito';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

$data  = json_decode($_POST['data'], true);

$userId = htmlentities($_POST['usuario'],  ENT_NOQUOTES);
$msg = htmlspecialchars($_POST['mensaje'],  ENT_NOQUOTES, "UTF-8");
$contacto = htmlentities($_POST['contacto'],  ENT_NOQUOTES);
$contactos= explode("_",$contacto);
$conexion = new Conexion();
$cc = new ControladorChat();

////////////////////////////////////////////// link ////////////////
$cadena_origen= $msg;

//enlaces normales
$cadena_resultante= preg_replace("/((http|https|www)[^\s]+)/", '<a target="_blank" href="$1">$0</a>', $cadena_origen);

//enlaces con solamente www, si es así le añado el http://
$cadena_resultante= preg_replace("/href=\"www/", 'href="http://www', $cadena_resultante);

//enlaces de twitter
$cadena_resultante = preg_replace("/(@[^\s]+)/", '<a target=\"_blank\"  href="http://twitter.com/intent/user?screen_name=$1">$0</a>', $cadena_resultante);
$cadena_resultante = preg_replace("/(#[^\s]+)/", '<a target=\"_blank\"  href="http://twitter.com/search?q=$1">$0</a>', $cadena_resultante);
//////////////////////////////fin link //////////////////////

try{
    
    try {
        
        $items = array();
        
        $conexion->ejecutarConsulta("begin;");
        $result= $cc->enviarMensaje($conexion, $userId, $cadena_resultante, $contactos[1]);
       
        
        if($num=pg_num_rows($result)>0){
            $val= pg_fetch_row($result);
            $fecha = $val[0];
        }else{
            $fecha = "error";
        }
            
        $mensaje['estado'] = 'exito';
        $mensaje['mensaje'] = $cadena_resultante;
        $mensaje['fecha'] = $fecha;
        
        $conexion->ejecutarConsulta("commit;");        
        
    } catch (Exception $ex){
        $conexion->ejecutarConsulta("rollback;");
        $mensaje['estado'] = $conexion->mensajeError;
        $mensaje['mensaje'] = $ex->getMessage();
        
    } finally {
        $conexion->desconectar();
    }
} catch (Exception $ex) {
    $mensaje['estado'] = $conexion->mensajeError;
    $mensaje['mensaje'] = $ex->getMessage();
    echo json_encode($mensaje);
} finally {
    echo json_encode($mensaje);
}
?>