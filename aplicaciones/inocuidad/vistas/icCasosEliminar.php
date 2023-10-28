<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../controladores/ControladorCatalogosInc.php';
require_once '../controladores/ControladorRequerimiento.php';
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 28/01/18
 * Time: 19:09
 */
$controladorCatalogos = new ControladorCatalogosInc();
$controladorRequerimiento= new ControladorRequerimiento();

$productos=$controladorCatalogos->obtenerComboCatalogosOpciones("PRODUCTOS");
$programasCatalogo=$controladorCatalogos->obtenerComboCatalogosOpciones("PROGRAMAS");
$fuentesDenunciaCatalogo=$controladorCatalogos->obtenerComboCatalogosOpciones("FUENTE_DENUNCIA");
// $tipoRequerimiento=$controladorCatalogos->obtenerComboCatalogosOpciones("REQUERIMIENTOS");
$provincias=$controladorCatalogos->obtenerComboCatalogosOpciones("PROVINCIAS");
$paises=$controladorCatalogos->obtenerComboCatalogosOpciones("PAISES");
$idCaso = $_POST['elementos'];
$disabled='false';
$caso=null;
$identificador=($_SESSION['usuario']);

$resPerfil = $controladorRequerimiento->PerfilUsuario($identificador);
    
if (pg_num_rows($resPerfil) > 0) {
    $banderaPerfil = true;
} else {
    $banderaPerfil = false;
}


$caso = $controladorRequerimiento->recuperarRequerimiento($idCaso);
$tipoRequerimiento=$controladorCatalogos->obtenerComboCatalogosOpcionesPerfil("REQUERIMIENTOS","REPORTE");



?>
<!DOCTYPE html>
<html>
<head>
    <script src="aplicaciones/inocuidad/js/inocuidad_root.js" type="text/javascript"/>
    <meta charset="utf-8">
    <link rel='stylesheet' href='aplicaciones/inocuidad/estilos/global.css' >
</head>
<body>
<header>
    <h1>Detalle del caso</h1>
</header>
<div id="estado"></div>

            <form id="eliminarCaso"   data-rutaAplicacion="inocuidad" data-opcion="controladores/editaCaso" method="post">
                <input type="text" id="ic_requerimiento_id" name="ic_requerimiento_id"
                       value="<?php echo $_POST['elementos']?>">
                       <input type="text" id="perfilUsuario" name="perfilUsuario"
                       value=" <?php echo $banderaPerfil ?>">

                       <input type="text" id="provincia" name="provincia"
                       value="<?php echo $caso==null?'':$caso->getProvinciaAplicacion()?>">

                       <input type="text" id="eliminar" 
                       value="eliminar">
                       
                <fieldset>
                    <legend>Caso</legend>
                    <div data-linea="2">
                        <label>Tipo de Requerimiento</label>
                        <select id="ic_tipo_requerimiento_id" name="ic_tipo_requerimiento_id" disabled="disabled" data-required>
                            <option value="">Seleccione el tipo de caso ...</option>

                        </select>
                    </div>
                    <div data-linea="3" id="divPrograma">
                        <label>Programa</label>
                        <select id="programa_id" name="programa_id" data-required >
                            <option value="">Tipo programa....</option>
                        </select>
                    </div>
                    <div data-linea="4">
                        <label>Producto</label>
                        <select id="ic_producto_id" name="ic_producto_id"  disabled="disabled" data-required>
                            <option value="">Seleccione el producto ...</option>
                        </select>
                    </div>

                    <div data-linea="1" id="fechaSolicitudCaso">
                        <label>Fecha Solicitud</label>
                        <input type="text" id="fecha_solicitud"  readonly="readonly"
                               value="<?php if($caso!=null){
                                   $dateSol = new DateTime($caso->getFechaCreacionRegistro());
                                   echo $dateSol->format('d/m/Y');
                               }?>" disabled="disabled" data-required/>
                    </div>
                    <!-tabla que muestra los datos del inspector-!>
                        <table id="muestraRapida" style="width:95%"  class="tablaMatriz">
                            <thead>
                                <tr>
                                    <th>Contaminantes</th>
                                    <th>Parámetros</th>
                                    <th>Unidad Medida</th>
                                    <th>Lim. Mínimo</th>
                                    <th>Lim. Máximo</th>
                                </tr>
                            </thead>
                        <tbody>
                        </tbody>
                        </table>
                        <p class="nota" id="idLabel" style="color:red">Este producto no cuenta con Muestras Rápidas..!!<b>
                    
                    <div data-linea="5" id="duplicadorCasos">
                        <label>N° de Muestras (Incl. Contramuestras)</label>
                        <input type="number" id="numero_muestras" name="numero_muestras" class="numeric"
                               value="<?php echo $caso==null?'2':$caso->getNumeroMuestras()?>" data-required/>
                    </div>

                    <div data-linea = "6" id="cantidadRegistros" >
                        <label > Cantidad de Registros(Duplicador de Casos):</label >
                      
                        <input type = "number" id = "numero_casos" name = "numero_casos" class="numeric" value="<?php echo $caso==null?'':$caso->getNumeroMuestras()?>" data-required />
                        
                    </div >

                    <div data-linea="3" id="provinciaPlanificador">
                        <label>Provincia</label>
                        <select id="provincia_id" name="provincia_id" data-required>
                            <option value="">Seleccione una provincia ...</option>
                        </select>
                    </div>

                    <div data-linea = "7" id="muestrasFaltantes" >
                        <label > Número de Muestras Faltantes:</label >
                        <input type = "number" id = "muestras_faltantes" class="numeric"/>
                    </div >
                    
                    <div data-linea = "8" id="obsAdministrador" >
                        <label>Observación Planificador:</label>
                        <textarea id="observacionPlanificador"  rows="3"><?php echo $caso!=null?$caso->getObservacion():""; ?></textarea>
                    </div>
                    
                   
                </fieldset>

                <fieldset id="section_PVtecnico" style="display: none">
                    <legend>Plan de Vigilanciaeeeeeeeeee</legend>
                    <div data-linea="1">
                        <label>Fecha Estimada de Inspección</label>
                        <input type="text" id="fecha_inspeccion" name="fecha_inspeccion" readonly="readonly"
                               value="<?php if($caso!=null){
                                   $dateSol = new DateTime($caso->getFechaInspeccion());
                                   echo $dateSol->format('d/m/Y');
                               }?>" data-required/>
                    </div>

                    <div data-linea = "2">
                    <label>Provincia Aplicación:</label>
                        <select id="provincia_tecnico_id" name="provincia_tecnico_id" data-required>
                            <option value="">Seleccione una provincia ...</option>
                        </select>
                    </div >

                    <div data-linea = "8" id="obsTecnicoCaso" >
                        <label>Observacion Técnico:</label>
                        <textarea id="observacion_tecnico"  name = "observacion_tecnico" rows="3"><?php echo $caso!=null?$caso->getObservacionTecnico():""; ?></textarea>
                    </div>
                </fieldset>    

                <fieldset id="section_DN" style="display: none">
                    <legend>Denuncia</legend>

                    <div data-linea="1">
                        <label>Fecha Denuncia</label>
                        <input type="text" id="fecha_denuncia" name="fecha_denuncia" readonly="readonly"
                               value="<?php if($caso!=null){
                                   $dateSol = new DateTime($caso->getFechaDenuncia());
                                   echo $dateSol->format('d/m/Y');
                               }?> " data-required/>
                    </div>
                    <div data-linea="2">
                        <label>Fuente</label>
                        <select id="fuente_denuncia_id" name="fuente_denuncia_id"  data-required>
                            <option value="">Seleccione la fuente de la denuncia ...</option>
                        </select>
                    </div>
                    <div data-linea="3">
                        <label>Nombre Denunciante</label>
                        <input type="text" id="nombre_denunciante" name="nombre_denunciante"
                               value="<?php echo $caso==null?'':$caso->getNombreDenunciante()?>" data-required/>
                    </div>
                    <div data-linea="4">
                        <label>Datos Denunciante</label>
                        <input type="text" id="datos_denunciante" name="datos_denunciante"
                               value="<?php echo $caso==null?'':$caso->getDatosDenunciante()?>" data-required/>
                    </div>
                    <label>Descripción denuncia</label>
                    <div data-linea="5">
                        <textarea id="descripcion_denuncia" name="descripcion_denuncia" rows="3" />
                    </div>
                    <div data-linea="6">
                        <label>Provincia</label>
                        <select id="provincia_denuncia_id" name="provincia_denuncia_id" data-required>
                            <option value="">Seleccione una provincia ...</option>
                        </select>
                    </div>
                </fieldset>

                <fieldset id="section_NE" style="display: none">
                    <legend>Notificación del Exterior</legend>

                    <div data-linea="1">
                        <label>Fecha Notificación</label>
                        <input type="text" id="fecha_notificacion" name="fecha_notificacion" readonly="readonly"
                               value="<?php if($caso!=null){
                                   $dateSol = new DateTime($caso->getFechaNotificacion());
                                   echo $dateSol->format('d/m/Y');
                               }?>" data-required/>
                    </div>
                    <div data-linea="2">
                        <label>País que notifica</label>
                        <select id="pais_notificacion_id" name="pais_notificacion_id"  data-required>
                            <option value="">Seleccione país ... </option>
                        </select>
                    </div>
                </fieldset>
                <fieldset id="section_OBS" style="display: none">
                    <legend>Responsable</legend>
                    <div>
                        <label id="lblInspector">Inspector</label>
                        <select id="inspector_id" name="inspector_id" data-required>
                            <option value="">Seleccione un inspector ...</option>
                        </select>
                        <a class="material_link" onclick="loadInspectores()" id="btnSearch"><i class="material-icons">search</i></a>
                    </div>
                    <div data-linea="1">
                        <table id="inspector_props" style="width: 98%"></table>
                    </div>
                    <label>Observacion</label>
                    <div data-linea="2">
                        <textarea id="observacion" name="observacion" rows="3"><?php echo $caso!=null?$caso->getObservacion():""; ?></textarea>
                    </div>
                </fieldset>
                <!-tabla que muestra el numero de casos creados-!>
                <fieldset id="section_casos" style="display: none">
                <legend>Detalle de Casos por usuario</legend>
                    <table id="casosCreados" style="width:95%"  class="tablaMatriz">
                                <thead>
                                    <tr>
                                        <th>Fecha estimada de Inspección</th>
                                        <th>Provincia</th>
                                        <th>Observación</th>
                                    </tr>
                                </thead>
                            <tbody>
                            </tbody>
                            </table>
                    <p class="nota" id="idLabelCasos" style="color:red">Aun no se han creado registros para este caso..!!<b>
                </fieldset> 
                <td><button id="eliminar" type="submit" class="guardar" >Eliminar</button></td>
            </form>
<div id="includedAdjunto"></div>

<div id="includedHistorial"></div>


</body>
<script src="aplicaciones/inocuidad/js/icCasosEditar_Inspectores.js"/>
<script>

   
       
    var array_comboTipoProducto = <?php echo json_encode($productos);?>;
    var array_ComboProgramas = <?php echo json_encode($programasCatalogo);?>;
    var array_Requerimientos = <?php echo json_encode($tipoRequerimiento);?>;
    var array_Provincias =<?php echo json_encode($provincias);?>;
    var array_Paises=<?php echo json_encode($paises)?>;
    var array_FuenteDenuncia=<?php echo json_encode($fuentesDenunciaCatalogo)?>;
    for(var i=0; i<array_comboTipoProducto.length; i++){
        $('#ic_producto_id'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ).append(array_comboTipoProducto[i]);
    }
    for(var i=0; i<array_ComboProgramas.length; i++){
        $('#programa_id').append(array_ComboProgramas[i]);
    }
    for(var i=0; i<array_Requerimientos.length; i++){
        $('#ic_tipo_requerimiento_id').append(array_Requerimientos[i]);
    }
    for(var i=0; i<array_Provincias.length; i++){
        $('#provincia_id').append(array_Provincias[i]);
        $('#provincia_tecnico_id').append(array_Provincias[i]);
        $('#provincia_denuncia_id').append(array_Provincias[i]);

    }
    for(var i=0; i<array_Paises.length; i++){

        $('#pais_notificacion_id').append(array_Paises[i]);

    }

    for(var i=0; i<array_FuenteDenuncia.length; i++){
        $('#fuente_denuncia_id').append(array_FuenteDenuncia[i]);
    }

    <?php if($caso!=null){?>
    cargarValorDefecto("ic_producto_id","<?php echo $caso->getProductoId();?>");


    var req=<?php echo $caso->getTipoRequerimientoId();?>;
    var tipoReq='';
    switch (req){
        case 1:
            tipoReq='PV';
           
            cargarValorDefecto("programa_id",<?php echo $caso->getProgramaId()?>);
            cargarValorDefecto("provincia_id",<?php echo $caso->getProvinciaId()?>);
            cargarValorDefecto("provincia_tecnico_id",<?php echo $caso->getProvinciaAplicacion()?>);


            break;
        case 2:
            tipoReq='DN';
            cargarValorDefecto("fuente_denuncia_id",<?php echo $caso->getFuenteId()?>);
            cargarValorDefecto("provincia_id",<?php echo $caso->getProvinciaId()?>);
            cargarValorDefecto("provincia_denuncia_id",<?php echo $caso->getProvinciaId()?>);
            $("textarea#descripcion_denuncia").text('<?php echo $caso->getDescripcionDenuncia(); ?>');


            break;
        case 3:
            tipoReq='NE';
            cargarValorDefecto("pais_notificacion_id",<?php echo $caso->getPaisId()?>);
            cargarValorDefecto("origen_mercaderia_id",<?php echo $caso->getOrigenMercaderiaId()?>);


            break;
    }
    loadSelectedInspector("<?php echo $caso->getInspectorId()?>");
    cargarValorDefecto("ic_tipo_requerimiento_id",tipoReq);
     <?php }?>


</script>
<script src="aplicaciones/inocuidad/js/icCasosEliminar.js"/>
</html>
