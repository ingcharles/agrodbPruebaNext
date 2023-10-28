<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 28/01/18
 * Time: 20:50
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../controladores/ControladorCatalogosInc.php';
require_once '../controladores/ControladorRequerimiento.php';
require_once '../controladores/ControladorMuestra.php';
require_once '../controladores/ControladorLaboratorio.php';

$ic_analisis_muestra_id = $_POST['id'];

$controladorMuestra= new ControladorMuestra(null);
$controladorRequerimiento = new ControladorRequerimiento();
$controladorLaboratorio = new ControladorLaboratorio();

$controladorCatalogos = new ControladorCatalogosInc();
$estadoModLab=$controladorCatalogos->obtenerEstadoModuloLaboratorio();

$laboratorio = ($ic_analisis_muestra_id=='_nuevo'?null:$controladorLaboratorio->getLaboratorio($ic_analisis_muestra_id));

$muestra = null;
if($laboratorio!=null)
    $muestra = $controladorMuestra->getMuestra($laboratorio->getIcMuestraId());

$identificador=($_SESSION['usuario']);
$resPerfil = $controladorRequerimiento->PerfilUsuario($identificador);
if (pg_num_rows($resPerfil) > 0) {
    $banderaPerfil = 1;
} else {
    $banderaPerfil = 0;  
}

?>
<!DOCTYPE html>
<html>
<head>
    <script src="aplicaciones/inocuidad/js/inocuidad_root.js" type="text/javascript"/>
    
    <meta charset="utf-8">
</head>
<body>
<table class="soloImpresion">
    <tr>
        <td>
            <div>
                <h2>Resumen del caso</h2>
            </div>
            <?php echo $controladorRequerimiento->getCasoRO($muestra->getIcRequerimientoId()); ?>
            <?php echo $controladorMuestra->getMuestraRO($laboratorio->getIcMuestraId()); ?>
        </td>
    </tr>
    <tr>
        <td style="display: table-cell;width: 100%;">
            <div>
                <h2>Datos Laboratorio</h2>
            </div>
            <form id="actualizaLaboratorio" data-rutaAplicacion="inocuidad" data-opcion="controladores/editarLaboratorio">
                <input type="hidden" id="ic_analisis_muestra_id" name="ic_analisis_muestra_id" value="<?php echo $laboratorio->getIcAnalisisMuestraId() ?>"/>
                <input type="hidden" id="ic_muestra_id" name="ic_muestra_id" value="<?php echo $laboratorio->getIcMuestraId() ?>"/>
                <input type="hidden" id="perfilUsuario" name="perfilUsuario" value=" <?php echo $banderaPerfil ?>">
                
                <fieldset id="fsregistroValores">
                    <legend>Muestra</legend>
                    <table id="registroValores" border=1 style="width:100%;border-color: #afafaf;display: table"  class="tablaMatriz">
                        <thead>
                        <tr>
                            <th style="width:25%" >Código de la muestra Laboratorio</th>
                            <th style="width:15%" >Identificación de Campo de la Muestra</th>
                            <th style="width:15%" >Analito detectado</th>
                            <th style="width:45%" >Residuos encontrados (ug/kg)</th>
                            <th style="width:45%" >Método</th>
                            <th style="width:45%" >LMR**(ug/kg)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $controladorLaboratorio->listRegistroValores($laboratorio->getIcMuestraId());?>
                        </tbody>
                    </table>
                </fieldset>

                <fieldset id="fs_detalle">
                    <legend>Datos de Laboratorio</legend>
                    <div data-linea="1">
                        <label>Fecha de recepción de la muestra</label>
                        <input type="text"  id="fecha_recepcion_muestra" name="fecha_recepcion_muestra" readonly="readonly" data-required value="<?php echo $muestra==null?'':(new DateTime($laboratorio->getFechaRecepcionMuestra()))->format('d/m/Y'); ?>"/>
                    </div>
                    <div data-linea="2">
                        <label>Fecha de análisis de la muestra</label>
                        <input type="text"  id="fecha_analisis_muestra" name="fecha_analisis_muestra" readonly="readonly" data-required value="<?php echo $muestra==null?'':(new DateTime($laboratorio->getFechaAnalisisMuestra()))->format('d/m/Y'); ?>"/>
                    </div>
                    <div data-linea="3">
                        <label>Nº informe de Laboratorio</label>
                        <input type="text"  id="numero_informe_lab" name="numero_informe_lab" data-required value="<?php echo $muestra==null?'':$laboratorio->getNumeroInformeLab(); ?>"/>
                    </div>
                    <div data-linea="4">
                        <label>Nº de Memorando</label>
                        <input type="text"  id="numero_memorando" name="numero_memorando" data-required value="<?php echo $muestra==null?'':$laboratorio->getNumeroMemorando(); ?>"/>
                    </div>
                    <label for="observaciones">Observaciones</label>
                    <div data-linea="5">
                       <textarea id="observaciones" name="observaciones" cols="10" rows="10"><?php echo $laboratorio==null?'':$laboratorio->getObservaciones(); ?></textarea>
                    </div>
                    <?php if($estadoModLab=="true"){?>
                    <div data-linea="2">
                        <button type="button" id="labSolicitud">Crear solicitud laboratorio</button>
                    </div>
                    <?php }?>
                </fieldset>
                <fieldset id="fs_detalle_rechazo">
                    <legend>Observación Rechazo</legend>
                    <label for="observaciones">Observaciones rechazo: </label>
                    <div data-linea="5">
                       <textarea id="observacion_rechazo" name="observacion_rechazo" cols="10" rows="10"><?php echo $laboratorio==null?'':$laboratorio->getObservaciones(); ?></textarea>
                       <input type="hidden" id="ic_obs_rechazo" name="ic_obs_rechazo" >
                    </div>
                </fieldset>
                <div id="controls">
                    <table style="width: 100%; display: table">
                        <tr>
                            <td><button id="guardar" type="submit" class="guardar">Guardar</button></td>
                            <td><button id="enviar" type="button" class="guardar" <?php echo $laboratorio->getObservaciones()==null?  "disabled='disabled'":"" ?>>Enviar</button></td>
                            <td><button id="rechazar" type="submit" class="eliminar" style = "background:red"><i class="fa fa-times "></i>  Rechazar</button></td>
                            <td><button id="file-attach" type="button" class="subirArchivo adjunto"
                                        data-view='[{"tabla":"g_inocuidad.ic_analisis_muestra", "registro":"<?php echo $laboratorio->getIcAnalisisMuestraId();?>"}]'
                                        data-tabla="g_inocuidad.ic_analisis_muestra"
                                        data-registro="<?php echo $laboratorio->getIcAnalisisMuestraId();?>">Adjuntos</button></td>
                        </tr>
                    </table>
                </div>
            </form>
            <form id="enviarLaboratorio" data-rutaAplicacion="inocuidad" data-opcion="controladores/editarLaboratorioCreaEvaluacion" method="post">
                <input type="hidden" id="ic_analisis_muestra_id" name="ic_analisis_muestra_id" value="<?php echo $laboratorio->getIcAnalisisMuestraId() ?>">
            </form>
        </td>
    </tr>
</table>
<div id="includedAdjunto"></div>
</body>
<script>


    $("#enviar").on("click",function(){
        console.log("Guarda Evaluacion");
        $("#enviarLaboratorio").submit();
    });

    $("#enviarLaboratorio").submit(function(event){
        event.preventDefault();
        ejecutarJson($(this),new resetFormulario($("#actualizaLaboratorio")));
        $("#enviarLaboratorio")[0].reset();
        $("#enviar").prop('disabled', 'disabled');
    });

</script>
<script src="aplicaciones/inocuidad/js/icLaboratorioEditar.js"/>
</html>