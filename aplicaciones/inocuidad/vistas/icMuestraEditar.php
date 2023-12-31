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
require_once '../controladores/ControladorProducto.php';

$ic_muestra_id = $_POST['id'];

$controladorMuestra= new ControladorMuestra(null);
$controladorRequerimiento = new ControladorRequerimiento();
$muestra = $ic_muestra_id=='_nuevo'?null:$controladorMuestra->getMuestra($ic_muestra_id);
$requerimiento = $controladorRequerimiento->recuperarRequerimiento($muestra->getIcRequerimientoId());
$controladorProducto = new ControladorProducto();
$producto = $controladorProducto->getProducto($requerimiento->getProductoId());

$controladorCatalogos = new ControladorCatalogosInc();

$tipoMuestra=$controladorCatalogos->obtenerComboCatalogosOpciones("TIPO_MUESTRA");
$provincias=$controladorCatalogos->obtenerComboCatalogosOpciones("PROVINCIAS");
$paises=$controladorCatalogos->obtenerComboCatalogosOpciones("PAISES");
//LABORATORIO
$insumos = $controladorCatalogos->obtenerComboCatalogosOpcionesParam("INSUMO_APLICADO",$ic_muestra_id);
$tecnicasMuestreo = $controladorCatalogos->obtenerComboCatalogosOpciones("TECNICAS_MUESTREO");
$mediosRefrigeracion = $controladorCatalogos->obtenerComboCatalogosOpciones("MEDIOS_REFRIGERACION");

$identificador=($_SESSION['usuario']);
$resPerfil = $controladorRequerimiento->PerfilUsuario($identificador);
$resRequerimiento = pg_fetch_assoc($controladorRequerimiento->obtenerTipoRequerimiento($requerimiento->getProgramaId()));
$valor = $resRequerimiento['nombre'];

$palabra = strpos($resRequerimiento['nombre'], 'Veterinarios');

if ($palabra !== false){
    //muestra solo veterinarios
    $origenMuestra=$controladorCatalogos->obtenerComboCatalogosOpcionesParam("ORIGEN_MUESTRA_TIPO",'veterinario');
}else{
    //muestra todos los catalogos excepto veterinarios
    $origenMuestra=$controladorCatalogos->obtenerComboCatalogosOpciones("ORIGEN_MUESTRA");
}


  $muestras = 0;
if (pg_num_rows($resPerfil) > 0) {
    $banderaPerfil = 1;
    $muestras = $muestra->getCantidadMuestrasLab();
} else {
    $banderaPerfil = 0;
    if ($muestra->getCantidadMuestrasLab() % 2 == 0){
        $muestras = ($muestra->getCantidadMuestrasLab()/2);
    }else{
        $muestras = $muestra->getCantidadMuestrasLab();
    }
   
}


if ($requerimiento->getInspectorId() == $_SESSION['usuario']){
    $cedula = $_SESSION['usuario'];
    $nombre = $_SESSION['datosUsuario'];
}else{
    $cedula = $requerimiento->getInspectorId();
    $nombre = $controladorCatalogos->obtenerComboCatalogosOpcionesParam("DATOS_TECNICO",$requerimiento->getInspectorId());
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="aplicaciones/inocuidad/js/inocuidad_root.js" type="text/javascript"/>
    <meta charset="utf-8">

</head>
<body>
<div id="estado"></div>
<table class="soloImpresion">
    <tr>
        <td>
            <div>
                <h2>Resumen del caso</h2>
            </div>
            <?php echo $controladorRequerimiento->getCasoRO($muestra->getIcRequerimientoId()); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div>
                <h2>Datos de la muestra</h2>
            </div>
            <form id="editarMuestra"  data-rutaAplicacion="inocuidad" data-opcion="controladores/editarMuestra">
                <input type="hidden" id="ic_requerimiento_id" name="ic_requerimiento_id" value="<?php echo $muestra->getIcRequerimientoId() ?>">
                <input type="hidden" id="ic_muestra_id" name="ic_muestra_id" value="<?php echo $muestra->getIcMuestraId() ?>">
                <input type="hidden" id="perfilUsuario" name="perfilUsuario" value=" <?php echo $banderaPerfil ?>">
                <input type="hidden" id="tecnico_id" name="tecnico_id" value="<?php echo $cedula ?>" />
                <input type="hidden" id="fecha_estimada" name="fecha_estimada" value="<?php echo $requerimiento->getFechaInspeccionMes(); ?>" />
                <input type="hidden" id="codigoProvincia_id" name="codigoProvincia_id" value="<?php echo $muestra->getProvinciaId(); ?>" />
                
                <fieldset>
                    <legend>Toma de la Muestra</legend>
                    <div data-linea="2">
                        <label>Fecha de Muestreo</label>
                        <input type="text" id="fecha_muestreo" name="fecha_muestreo" readonly="readonly" data-required value="<?php echo $muestra==null?'':(new DateTime($muestra->getFechaMuestreo()))->format('d/m/Y'); ?>"/>
                    </div>
                    <div data-linea="3">
                        <label>Código de la Muestra</label>
                        <input type="text" id="codigo_muestras" name="codigo_muestras" data-required value="<?php echo $muestra==null?'':$muestra->getCodigoMuestras(); ?>"/>
                    </div>
                    <?php if($requerimiento->getTipoRequerimientoId()!=3){ ?>
                        <div data-linea="4">
                            <label>Provincia</label>
                            <select id="provincia_id" name="provincia_id" data-required>
                                <option value="">Seleccione ...</option>
                            </select>
                        </div>
                        <div data-linea="5">
                            <label>Cantón</label>
                            <select id="canton_id" name="canton_id" data-required disabled="disabled">
                                <option value="">Seleccione ...</option>
                            </select>
                        </div>
                        <div data-linea="6">
                            <label>Parroquia</label>
                            <select id="parroquia_id" name="parroquia_id" data-required disabled="disabled">
                                <option value="">Seleccione ...</option>
                            </select>
                        </div>
                    <?php }?>
                    <br>
                    <div style="width: 100%">
                        <label>Técnico Responsable</label>

                        <input type="text"  name="<?php echo $cedula ?>" value="<?php echo $nombre ?>" readonly style="width: 75%;"/>
                        
                        <!--<a class="material_link" onclick="loadTecnicos()"><i class="material-icons">search</i></a>
                        <input id="tecnico_filtrado" type="checkbox" checked value="true"> Filtrado--!>
                    </div>
                    <div data-linea="8">
                        <table id="tecnico_props" style="width: 98%"></table>
                    </div>
                    <div data-linea="9">
                        <label>Tipo de producto</label><br>
                        <?php if($requerimiento->getTipoRequerimientoId()!=3){ ?>
                            <input id="NC" type="radio" name="tipo_empresa" value="NC" <?php echo $muestra==null?'checked':($muestra->getTipoEmpresa()=="NC"?'checked':($muestra->getTipoEmpresa()!="IM"?'checked':'')); ?> >Nacional<br>
                            <input id="IM" type="radio" name="tipo_empresa" value="IM" <?php echo $muestra==null?'':($muestra->getTipoEmpresa()=="IM"?'checked':''); ?>>Importación<br>
                        <?php }else{?>
                            <input type="radio" name="tipo_empresa" value="IM" checked>Importación<br>
                        <?php } ?>
                    </div>
                </fieldset>
                <fieldset id="section_NC" style="
                    <?php
                        if($requerimiento->getTipoRequerimientoId()!=3) {
                            echo $muestra == null ? 'display: block' : ($muestra->getTipoEmpresa() == "NC" ? 'display: block' : ($muestra->getTipoEmpresa() != "IM" ? 'display: block' : 'display: none'));
                        }else
                            echo 'display: none';
                    ?>
                ">
                <legend>Origen y Destino de la Muestra</legend>
                    <div data-linea="1">
                        <label>Nombre del Representante Legal (Nacional o Empresa Importadora)</label>
                        <input  id="nombre_representante" name="nombre_representante" type="text"  value="<?php echo ($muestra->getNombreRepLegal()); ?>"/>
                    </div>
                    <div data-linea="2">
                        <label>Origen Muestra</label>
                        <select id="origen_muestra_id" name="origen_muestra_id"  data-required>
                            <option value="">Seleccione origen ... </option>
                        </select>
                    </div>
                    <div data-linea="3" id="select_finca">
                        <label>Finca</label>
                        <select id="finca_id" name="finca_id"  disabled="disabled" data-required>
                            <option value="">Seleccione finca ... </option>
                        </select>
                    </div>
                    <div data-linea="4">
                        <label>Nombre del Establecimiento</label>
                        <input  id="nombre_establecimiento" name="nombre_establecimiento" type="text" readonly value="<?php echo ($muestra->getNombreEstablecimiento()); ?>"/>
                    </div>
                    <div data-linea="5" id="line_direccion">
                        <label>Dirección del Establecimiento</label>
                        <input  id="direccion_establecimiento" name="direccion_establecimiento" type="text" readonly value="<?php echo ($muestra->getDireccionEstablecimiento()); ?>"/>
                    </div>
                    <div data-linea="6">
                        <label>Certificado Sanitario De Origen y Movilización</label>
                        <input  id="certificacion_sanitaria" name="certificacion_sanitaria" type="text" value="<?php echo ($muestra->getCertificacionSanitaria()); ?>"/>
                    </div>
                    <div data-linea="7">
                        <label>Certificado Zoosanitario de producción y movilidad</label>
                        <input  id="certificado_zoosanitario" name="certificado_zoosanitario" type="text" value="<?php echo ($muestra->getCertificacionZoosanitario()); ?>"/>
                    </div>
                    
                    <div data-linea="8">
                        <table id="finca_props" style="width: 98%; display:none"></table>
                    </div>
                    <div data-linea="9" id="coordenada_x" style ="display:none">
                        <label>utm-x</label>
                        <input readonly=true id="utm_x" name="utm_x" type="text" id="codigoMuestras" value="<?php echo $muestra==null?'':$muestra->getUtmX(); ?>"/>
                    </div>
                    <div data-linea="10" id="coordenada_y" style ="display:none">
                        <label>utm-y</label>
                        <input eadonly=true id="utm_y" name="utm_y" type="text" id="codigoMuestras" value="<?php echo $muestra==null?'':$muestra->getUtmY(); ?>"/>
                    </div>
                    <div data-linea="11" id="btn_coordenadas" style ="display:none">
                        <input id="open_mapa" type="button" class="regresar" value="Ver Mapa" />
                    </div>
                </fieldset>
                <fieldset id="section_IM" style="
                    <?php
                        if($requerimiento->getTipoRequerimientoId()!=3) {
                            echo $muestra == null ? 'display: none' : ($muestra->getTipoEmpresa() == "IM" ? 'display: block' : 'display: none');
                        }else
                            echo 'display: block';
                    ?>
                        ">
                    <legend>Importación</legend>
                    <div data-linea="1">
                        <label>Número Permiso Zoosanitario de Importación (VUE)</label>
                        <input type="text" id="permiso_fitosanitario" name="permiso_fitosanitario" data-required value="<?php echo $muestra==null?'':$muestra->getPermisoFitosanitario(); ?>"/>
                    </div>
                    <div data-linea="2">
                        <label>Nombre del Representante Legal (Nacional o Empresa Importadora)</label>
                        <input type="text" readonly=true id="nombre_rep_legal" name="nombre_rep_legal" data-required value="<?php echo $muestra==null?'':$muestra->getNombreRepLegal(); ?>"/>
                    </div>
                    
                    <div data-linea="3">
                        <label>Razón Social de Importador</label>
                        <input type="text" readonly=true id="razon_social_importador" name="razon_social_importador" data-required value="<?php echo $muestra==null?'':$muestra->getRazonSocialImportador(); ?>"/>
                    </div>
                    <div data-linea="4" style="display:none">
                        <table id="importador_props" style="width: 98%"></table>
                    </div>
                    <div data-linea="5">
                        <label>Pais de Origen</label>
                        <input type="text" readonly=true id="pais_origen" name="pais_origen" data-required value="<?php echo $muestra==null?'':$muestra->getPaisOrigen(); ?>"/>
                    </div>
                </fieldset>
                <fieldset id="fs_detalle">
                    <legend>Datos de Muestra</legend>
                    <div data-linea="1">
                        <label for="fecha_envio_lab">Fecha envío</label>
                        <input type="text" id="fecha_envio_lab" name="fecha_envio_lab" readonly="readonly" data-required value="<?php echo $muestra==null?'':(new DateTime($muestra->getFechaEnvioLab()))->format('d/m/Y'); ?>"/>
                    </div>
                    <br>
                    <div data-linea="2">
                        <label for="cantidad_muestras_lab">Cantidad de Muestras</label>
                        <input type="text" id="cantidad_muestras_lab" name="cantidad_muestras_lab" readonly="readonly" class="numeric" data-required value="<?php echo $muestra==null?'':$muestras; ?>">
                    </div>
                    <br>
                    <div data-linea="3">
                        <label for="cantidad_contra_muestra">Cantidad Contra Muestra</label>
                        <input type="text" id="cantidad_contra_muestra" name="cantidad_contra_muestra" readonly="readonly" class="numeric" data-required value="<?php echo $muestra==null?'':$muestras; ?>">
                    </div>
                    <br>
                    <label for="observaciones">Observaciones</label>
                    <div data-linea="4">
                        <textarea id="observaciones" name="observaciones" cols="10" rows="10"><?php echo $muestra==null?'':$muestra->getObservaciones(); ?></textarea>
                    </div>
                </fieldset>
                <?php if($producto->getMuestraRapida()=="S"){ ?>
                    <div>
                        <!-- <h2>Muestra Rápida</h2>--!>
                    </div>
                    <fieldset id="tablaMuestraRapida">
                        <legend>Muestra Rápida</legend>
                        <table id="registroValores" border=1 style="width:100%;border-color: #afafaf"  class="tablaMatriz">
                            <thead>
                            <tr>
                                <th style="width:25%" >Insumo</th>
                                <th style="width:15%" >Unidad M.</th>
                                <th style="width:15%" >Valor</th>
                                <th style="width:45%" >Observaciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $controladorMuestra->listMuestraRapidaValores($muestra->getIcMuestraId());?>
                            </tbody>
                        </table>
                    </fieldset>
                <?php } ?>
                <div id="controls">
                    <table style="width: 100%">
                        <tr>
                            <td><button id="guardar" type="submit" class="guardar">Guardar</button></td>
                            <td><button id="enviar" type="button" class="guardar" <?php echo $muestra->getTipoEmpresa()==null?  "disabled='disabled'":"" ?> >Enviar</button></td>
                            <td><button id="file-attach" type="button" class="subirArchivo adjunto"
                                        data-view='[{"tabla":"g_inocuidad.ic_requerimiento", "registro":"<?php echo $requerimiento->getId();?>"},{"tabla":"g_inocuidad.ic_muestra", "registro":"<?php echo $muestra->getIcMuestraId();?>"}]'
                                        data-tabla="g_inocuidad.ic_muestra"
                                        data-registro="<?php echo $muestra->getIcMuestraId();?>">Adjuntos</button></td>
                        </tr>
                    </table>
                </div>
            </form>
            <form id="enviarMuestra" data-rutaAplicacion="inocuidad" data-opcion="controladores/editarMuestraCreaLaboratorio" method="post">
                <input type="hidden" id="ic_muestra_id" name="ic_muestra_id" value="<?php echo $muestra->getIcMuestraId() ?>">
            </form>
        </td>
    </tr>
</table>
<div id="includedAdjunto"></div>

<div id="dialog">
    <div id="map_canvas" style="width:500px;height:380px;"></div>
</div>

</body>
<script src="aplicaciones/inocuidad/js/icMuestraEditar.js"/>
<script src="aplicaciones/inocuidad/js/gmaps.js"/>

<script>

    var array_Combo =<?php echo json_encode($provincias);?>;
    for(var i=0; i<array_Combo.length; i++){
        $('#provincia_id').append(array_Combo[i]);
    }

    array_Combo =<?php echo json_encode($origenMuestra);?>;
    for(var i=0; i<array_Combo.length; i++){
        $('#origen_muestra_id').append(array_Combo[i]);
    }

    array_Combo =<?php echo json_encode($tipoMuestra);?>;
    for(var i=0; i<array_Combo.length; i++){
        $('#tipo_muestra_id').append(array_Combo[i]);
    }

    array_Combo =<?php echo json_encode($paises);?>;
    for(var i=0; i<array_Combo.length; i++){
        $('#pais_procedencia_id').append(array_Combo[i]);
    }

    var array_Combo =<?php echo json_encode($insumos);?>;
    for(var i=0; i<array_Combo.length; i++){
        $('#ultimo_insumo_aplicado_id').append(array_Combo[i]);
    }
    array_Combo =<?php echo json_encode($tecnicasMuestreo);?>;
    for(var i=0; i<array_Combo.length; i++){
        $('#tecnica_muestreo').append(array_Combo[i]);
    }
    array_Combo =<?php echo json_encode($mediosRefrigeracion);?>;
    for(var i=0; i<array_Combo.length; i++){
        $('#medio_refrigeracion').append(array_Combo[i]);
    }

    <?php if($muestra!=null){?>
        <?php if($requerimiento->getTipoRequerimientoId()!=3){ ?>
            <?php if($muestra-> getProvinciaId()!=null && $muestra-> getProvinciaId() > 0){?>
                cargarValorDefecto("provincia_id","<?php echo $muestra->getProvinciaId();?>");
                refreshOpciones('<?php echo $muestra->getProvinciaId();?>',$('#canton_id'),'CANTONES',function(){
                    cargarValorDefecto("canton_id","<?php echo $muestra->getCantonId();?>");
                });

                <?php if($muestra->getCantonId()>0){ ?>
                    refreshOpciones('<?php echo $muestra->getCantonId();?>',$('#parroquia_id'),'PARROQUIAS',function(){
                        cargarValorDefecto("parroquia_id","<?php echo $muestra->getParroquiaId();?>");
                        cargarFincas(function () {
                            showFincaProperties('<?php echo $muestra->getFincaId();?>');
                            cargarValorDefecto("finca_id","<?php echo $muestra->getFincaId();?>");
                        });
                    });
                <?php }else{ ?>
                    $("#canton_id").prop('disabled', false);
                <?php } ?>
            <?php }else{?>
                cargarValorDefecto("provincia_id","<?php echo $requerimiento->getProvinciaId();?>");
                refreshOpciones('<?php echo $requerimiento->getProvinciaId();?>',$('#canton_id'),'CANTONES');
                $("#canton_id").prop('disabled', false);
            <?php }?>
            
        <?php }?>
        cargarValorDefecto("origen_muestra_id","<?php echo $muestra->getOrigenMuestraId();?>");
        cargarValorDefecto("pais_procedencia_id","<?php echo $muestra->getPaisProcedenciaId();?>");
        loadSelectedTecnico("<?php echo $muestra->getTecnicoId();?>");
        cargarValorDefecto("tipo_muestra_id","<?php echo $muestra->getTipoMuestraId();?>");
        cargarValorDefecto("ultimo_insumo_aplicado_id","<?php echo $muestra->getUltimoInsumoAplicadoId();?>");
        cargarValorDefecto("tecnica_muestreo","<?php echo $muestra->getTecnicaMuestreo();?>");
        cargarValorDefecto("medio_refrigeracion","<?php echo $muestra->getMedioRefrigeracion();?>");
    <?php } ?>

    $("#editarMuestra").submit(function(event){
        $("#provincia_id").prop('disabled', false);
        $("#canton_id").prop('disabled', false);
        $("#parroquia_id").prop('disabled', false);
        event.preventDefault();
        if(validarRequeridos($("#editarMuestra"))){
            ejecutarJson($(this),new resetFormulario($("#editarMuestra")));
        }else
            mostrarMensaje("Por favor revise los campos obligatorios.","FALLO");
    });

    $("#enviar").on("click",function(){
        console.log("Guarda Laboratorio");
        $("#enviarMuestra").submit();
    });

    $("#enviarMuestra").submit(function(event){
        event.preventDefault();
        ejecutarJson($(this),new resetFormulario($("#editarMuestra")));
        $("#enviarMuestra")[0].reset();
        $("#enviar").prop('disabled', 'disabled');
    });
    if($('#perfilUsuario').val() == 1){
        $("#canton_id").prop('disabled', true);
    }  
</script>
</html>