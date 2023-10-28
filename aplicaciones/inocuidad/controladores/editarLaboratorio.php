<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 22/02/18
 * Time: 13:09
 */

 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'ControladorLaboratorio.php';
require_once '../../../clases/Conexion.php';
require_once '../Modelo/Laboratorio.php';
require_once '../controladores/ControladorMailLaboratorioRechazo.php';

$mensaje = array();
$mensaje['estado'] = 'error';
$mensaje['mensaje'] = 'Ha ocurrido un error!'; 


try{
    $conexion = new Conexion();
    $controladorLaboratorio=new ControladorLaboratorio();
    $ControladorMailLaboratorioRechazo = new ControladorMailLaboratorioRechazo($conexion);

    $ic_analisis_muestra_id     = isset($_POST['ic_analisis_muestra_id']) ? $_POST['ic_analisis_muestra_id'] : null;
    $ic_muestra_id              = isset($_POST['ic_muestra_id']) ? $_POST['ic_muestra_id'] : null;
    $observaciones              = isset($_POST['observaciones']) ? $_POST['observaciones'] : null;
    $fecha_recepcion_muestra = isset($_POST['fecha_recepcion_muestra']) ? $_POST['fecha_recepcion_muestra'] : null;
    $fecha_analisis_muestra = isset($_POST['fecha_analisis_muestra']) ? $_POST['fecha_analisis_muestra'] : null;
    $numero_informe_lab = isset($_POST['numero_informe_lab']) ? $_POST['numero_informe_lab'] : null;
    $numero_memorando = isset($_POST['numero_memorando']) ? $_POST['numero_memorando'] : null;
    $observacion_rechazo = isset($_POST['observacion_rechazo']) ? $_POST['observacion_rechazo'] : null;
    $rechazo = isset($_POST['ic_obs_rechazo']) ? $_POST['ic_obs_rechazo'] : null;

    $arrryDetalleMuestraId = isset($_POST['ic_detalle_muestra_id']) ? $_POST['ic_detalle_muestra_id'] : null;
    $arrayCodigoMuestraLaboratorio = isset($_POST['cod_muestra_lab']) ? $_POST['cod_muestra_lab'] : null;
    $arrayCodigoMuestra = isset($_POST['cod_muestra']) ? $_POST['cod_muestra'] : null;
    $arrayAnalito = isset($_POST['analito']) ? $_POST['analito'] : null;
    $arrayResiduos = isset($_POST['residuos']) ? $_POST['residuos'] : null;
    $arrayMetodo = isset($_POST['metodo']) ? $_POST['metodo'] : null;
    $arrayLmr = isset($_POST['lmr']) ? $_POST['lmr'] : null;

    $laboratorio = new Laboratorio($ic_analisis_muestra_id, $ic_muestra_id, true);
    $laboratorio->setObservaciones($observaciones);
    $laboratorio->setFechaRecepcionMuestra($fecha_recepcion_muestra);
    $laboratorio->setFechaAnalisisMuestra($fecha_analisis_muestra);
    $laboratorio->setNumeroInformeLab($numero_informe_lab);
    $laboratorio->setNumeroMemorando($numero_memorando);
    $laboratorio->setObservacionRechazo($observacion_rechazo);

    if($rechazo == 'rechazado'){
        $arrayParametros = array(
            'ic_muestra_id' => $ic_muestra_id,
            'ic_analisis_muestra_id' => $ic_analisis_muestra_id,
        );
        $mensaje['mensaje'] = $ControladorMailLaboratorioRechazo->enviarMailLaboratorio( $arrayParametros);
        $mensaje['mensaje'] = $controladorLaboratorio->saveAndUpdateLaboratorio($laboratorio,$rechazo);
    }
         //Guardamos el registro principal del laboratorio
        if ($rechazo != 'rechazado'){
            $mensaje['mensaje'] = $controladorLaboratorio->saveAndUpdateLaboratorio($laboratorio,$rechazo);
            $mensaje['mensaje'] =$controladorLaboratorio->saveAndUpdateDetalleMuestra($arrryDetalleMuestraId, $arrayCodigoMuestraLaboratorio, $arrayCodigoMuestra, $arrayAnalito, $arrayResiduos, $arrayMetodo, $arrayLmr, $ic_muestra_id);
        }
        

        //Iniciamos auditoria de laboratorio
        $auditoria = new ControladorAuditoria();
        $auditoria->auditarRegistroUpdate($_SESSION['usuario'],$laboratorio);

        if($mensaje['mensaje']==null){
            $registroValores = $controladorLaboratorio->getRegistroValores($ic_analisis_muestra_id);
        //Para cada valor registrado en laboratorio, recorremos los registros almacenando los valores.
        /* @var $registro RegistroValor */
            foreach ($registroValores as $registro){
                $ic_registro_valor_id = $registro->getIcRegistroValorId();
                $valor = isset($_POST['valor_'.$ic_registro_valor_id]) ? $_POST['valor_'.$ic_registro_valor_id] : 0;
                $obs   = isset($_POST['obs_'.$ic_registro_valor_id]) ? $_POST['obs_'.$ic_registro_valor_id] : null;

                $registro->setValor($valor);
                $registro->setObservaciones($obs);

                //Almacenamos Valores
                $mensaje['mensaje'] = $controladorLaboratorio->saveAndUpdateRegistroValor($registro);
                //Auditoria de los valores
                $auditoria->auditarRegistroUpdate($_SESSION['usuario'],$registro);
            }
    }

    if($mensaje['mensaje']!=null){
        $mensaje['estado'] = 'error';
    }else{
        $mensaje['estado'] = 'exito';
        $mensaje['mensaje'] = 'Los datos fueron actualizados';
    }
    $conexion->desconectar();
    echo json_encode($mensaje);
   
} catch (Exception $ex){
    pg_close($conexion);
    $mensaje['estado'] = 'error';
    $mensaje['mensaje'] = "Error al ejecutar sentencia";
    echo json_encode($mensaje);
}