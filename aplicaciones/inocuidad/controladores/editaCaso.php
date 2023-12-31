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
require_once '../../../clases/Conexion.php';
require_once '../Modelo/Caso.php';
require_once '../controladores/ControladorMailCasosPlanificadorEnviarInspectorCaso.php';

$conexion = new Conexion();
$controladorRequerimiento=new ControladorRequerimiento($conexion);
$ControladorMailCasosPlanificadorEnviarInspectorCaso = new ControladorMailCasosPlanificadorEnviarInspectorCaso($conexion);

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!';

//Capturo info desde el formulario por POST
$programaId=isset($_POST['programa_id']) ? $_POST['programa_id'] : 0;
$requerimientoId=isset($_POST['ic_requerimiento_id']) ? $_POST['ic_requerimiento_id'] : null;
$fuenteId=isset($_POST['fuente_denuncia_id']) ||!''==$_POST['fuente_denuncia_id']? $_POST['fuente_denuncia_id'] : 0;
$productoId=isset($_POST['ic_producto_id']) ? $_POST['ic_producto_id'] : 0;
$paisId=isset($_POST['pais_notificacion_id']) ? $_POST['pais_notificacion_id'] : 0;
$provinciaId=isset($_POST['provincia_id']) ? $_POST['provincia_id'] : 0;
if($provinciaId==0){
    $provinciaId=isset($_POST['provincia_denuncia_id']) ? $_POST['provincia_denuncia_id'] : 0;
}
$inspectorId=isset($_POST['inspector_id']) ? $_POST['inspector_id'] : 0;
$origenMercaderiaId=isset($_POST['origen_mercaderia_id']) ? $_POST['origen_mercaderia_id'] : 0;
$tipoRequerimientoId=isset($_POST['ic_tipo_requerimiento_id']) ? $_POST['ic_tipo_requerimiento_id'] : 0;


$tipoReq='';
//Se cambia autosecuencial, para que siempre coincidan los IDs de los tipos de requerimientos.
switch($tipoRequerimientoId){
    case 'PV':
        $tipoReq=1;
        if($_POST['ic_requerimiento_id'] == ''){
            $estadoRegistro = 'casoCreado';
           
        }else{
            $estadoRegistro = 'casoGenerado';
           
        }
        break;
    case 'DN':
        $tipoReq=2;
        if($_POST['ic_requerimiento_id'] == '' ){
            $estadoRegistro = 'denunciaCreado';
           
        }else{
            $estadoRegistro = 'denunciaGenerado';
        }
        break;
    case 'NE':
        $tipoReq=3;
        if($_POST['ic_requerimiento_id'] == '' ){
            $estadoRegistro = 'notificacionCreado';
            $provinciaId=$_SESSION['idProvincia'];
        }else{
            $estadoRegistro = 'notificacionGenerado';
            $provinciaId=$_SESSION['idProvincia'];
        }
    break;
}
$fechaSolicitud=isset($_POST['fecha_solicitud']) ? $_POST['fecha_solicitud'] : 0;
$nombreDenunciante=isset($_POST['nombre_denunciante']) ? $_POST['nombre_denunciante'] : 'N/A';
$datosDenunciante=isset($_POST['datos_denunciante']) ? $_POST['datos_denunciante'] : 'N/A';
$descripcionDenuncia=isset($_POST['descripcion_denuncia']) ? $_POST['descripcion_denuncia'] : 'N/A';
$observacion=isset($_POST['observacion']) ? $_POST['observacion'] : 'N/A';
$numeroMuestras=isset($_POST['numero_muestras']) ? $_POST['numero_muestras'] : 0;
$fechaInspeccion=isset($_POST['fecha_inspeccion']) ? $_POST['fecha_inspeccion'] : null;
$fechaInspeccionMes=isset($_POST['fecha_inspeccion_mes']) ? $_POST['fecha_inspeccion_mes'] : null;
$fecha_notificacion=isset($_POST['fecha_notificacion']) ? $_POST['fecha_notificacion'] : null;
$fecha_denuncia=isset($_POST['fecha_denuncia']) ? $_POST['fecha_denuncia'] : null;
$numero_casos = isset($_POST['numero_casos']) ? $_POST['numero_casos'] : 1;
$inspectorId=isset($_POST['inspector_id']) ? $_POST['inspector_id'] : 0;
$provinciaAplicacion = isset($_POST['provincia_tecnico_id']) ? $_POST['provincia_tecnico_id'] : '';
$observacionTecnico = isset($_POST['observacion_tecnico']) ? $_POST['observacion_tecnico'] : '';


//Construye un nuevo objeto de Caso
$caso=new Caso($requerimientoId,$programaId,$fuenteId,$productoId,
               $paisId,$provinciaId,$inspectorId,$origenMercaderiaId,
               $tipoReq,$fechaSolicitud,$nombreDenunciante,
               $datosDenunciante,$descripcionDenuncia,$observacion,
               $numeroMuestras,null,null,null, 
               $provinciaAplicacion, $observacionTecnico, $estadoRegistro);
$caso->setFechaDenuncia($fecha_denuncia);
$caso->setFechaInspeccion($fechaInspeccion);
$caso->setFechaInspeccionMes($fechaInspeccionMes);
$caso->setFechaNotificacion($fecha_notificacion);
$caso->setUsuarioId($_SESSION['usuario']);

    //Auditoria
    $auditoria = new ControladorAuditoria();
    $auditType = 'U';
    if($caso->getId()!=null)
        $auditType='I';

//Llama a metodo Guardar de Caso

    $resultado= $controladorRequerimiento->saveAndUpdateCaso($caso,$numero_casos,$requerimientoId);

    if($auditType=='I')
        $auditoria->auditarRegistroUpdate($_SESSION['usuario'],$caso);
    else
        $auditoria->auditarRegistroInsert($_SESSION['usuario'],$caso);
if($resultado==null){
    $mensaje['estado'] = 'exito';
    $mensaje['mensaje'] = 'El registro se ha guardado con éxito!';
    if ($tipoRequerimientoId == "PV" && trim($_POST['perfilUsuario']) == 1 && $_POST['programa_id'] != ''){
        $arrayParametros = array(
            'inspector_id' => $_POST['inspector_id'],
            'usuario_id' => $_SESSION['usuario'] ,
            'programa_id' => $_POST['programa_id'] ,
            'ic_producto_id' => $_POST['ic_producto_id'] ,
            'provincia_id' => $_POST['provincia_id'] ,
            'ic_tipo_requerimiento_id' => $tipoReq ,
            'numero_muestras' => $_POST['numero_muestras'] ,
        );
        $mail = $ControladorMailCasosPlanificadorEnviarInspectorCaso->enviarMailCasoPlanVigilancia( $arrayParametros);
    }
}else
    $mensaje['mensaje'] = $resultado;
echo json_encode($mensaje);
