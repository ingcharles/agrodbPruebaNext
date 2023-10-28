<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 17/02/18
 * Time: 23:50
 */

require_once '../Modelo/Muestra.php';
require_once '../Util.php';
require_once '../controladores/ControladorProducto.php';
require_once '../Modelo/MuestraRapidaValor.php';

class ServiceMuestraDAO
{
    /*
     * Devuelve solamente las muestras activas
     * */
    public function getAllMuestras($conexion){
        $queryAll="SELECT ic_requerimiento_id, ic_muestra_id, fecha_muestreo, codigo_muestras, 
               canton_id, parroquia_id, tipo_empresa, finca_id, utm_x, utm_y, 
               registro_importador, permiso_fitosanitario, tecnico_id, ic_resultado_decision_id, 
               activo, estado, provincia_id, origen_muestra_id, nombre_rep_legal, 
               pais_procedencia_id, tipo_muestra_id, fecha_envio_lab,cantidad_muestras_lab,cantidad_contra_muestra,ultimo_insumo_aplicado_id,produccion_estimada,
               fecha_ultima_aplicacion,tecnica_muestreo,medio_refrigeracion,observaciones
          FROM g_inocuidad.ic_muestra
          WHERE estado AND activo
          ORDER BY ic_requerimiento_id";

        return executeArrayQuery($conexion,$queryAll);
    }

    public function getAllMuestrasExistentes($conexion){
        $queryAll="SELECT ic_requerimiento_id, ic_muestra_id, fecha_muestreo, codigo_muestras, 
               canton_id, parroquia_id, tipo_empresa, finca_id, utm_x, utm_y, 
               registro_importador, permiso_fitosanitario, tecnico_id, ic_resultado_decision_id, 
               activo, estado, provincia_id, origen_muestra_id, nombre_rep_legal, 
               pais_procedencia_id, tipo_muestra_id, fecha_envio_lab,cantidad_muestras_lab,cantidad_contra_muestra,ultimo_insumo_aplicado_id,produccion_estimada,
               fecha_ultima_aplicacion,tecnica_muestreo,medio_refrigeracion,observaciones
          FROM g_inocuidad.ic_muestra
          ORDER BY ic_requerimiento_id";

        return executeArrayQuery($conexion,$queryAll);
    }

    public function getAllMuestrasInStep($usuario,$conexion){
     
        $queryAll="SELECT mu.ic_requerimiento_id, ic_muestra_id, fecha_muestreo, codigo_muestras, 
               canton_id, parroquia_id, tipo_empresa, finca_id, utm_x, utm_y, 
               registro_importador, permiso_fitosanitario, tecnico_id, ic_resultado_decision_id, 
               activo, estado, mu.provincia_id, origen_muestra_id, nombre_rep_legal, 
               pais_procedencia_id, tipo_muestra_id, ic_tipo_requerimiento_id,
               fecha_envio_lab,cantidad_muestras_lab,cantidad_contra_muestra,ultimo_insumo_aplicado_id,produccion_estimada,
               fecha_ultima_aplicacion,tecnica_muestreo,medio_refrigeracion,observaciones,nombre_establecimiento,direccion_establecimiento,certificacion_sanitaria,
               certificacion_zoosanitario,razon_social_importador,pais_origen,to_char( req.fecha_creacion_registro, 'YYYY-MM-DD') as fecha_creacion_registro , pro.nombre 
          FROM g_inocuidad.ic_muestra mu
          JOIN g_inocuidad.ic_requerimiento req on mu.ic_requerimiento_id = req.ic_requerimiento_id
          JOIN g_inocuidad.ic_producto pro on pro.ic_producto_id = req.ic_producto_id
          WHERE REQ.cancelado='N' AND req.estado_registro in ('aprobadoPlanificador','casoGenerado','enviadoMuestra') AND ic_muestra_id NOT IN (SELECT ic_muestra_id FROM g_inocuidad.ic_analisis_muestra)
          AND CASE WHEN g_inocuidad.buscar_rol('PFL_CONF_INOC','$usuario') THEN 1=1 ELSE req.inspector_id='$usuario' END group by mu.ic_requerimiento_id, ic_muestra_id, fecha_muestreo, codigo_muestras, canton_id, parroquia_id, tipo_empresa, finca_id, utm_x,
            utm_y, registro_importador, permiso_fitosanitario, tecnico_id, ic_resultado_decision_id, activo, estado, mu.provincia_id, origen_muestra_id,
            nombre_rep_legal, pais_procedencia_id, tipo_muestra_id, ic_tipo_requerimiento_id, fecha_envio_lab,cantidad_muestras_lab,cantidad_contra_muestra,
            ultimo_insumo_aplicado_id,produccion_estimada, fecha_ultima_aplicacion,tecnica_muestreo,medio_refrigeracion,observaciones,nombre_establecimiento,
            direccion_establecimiento,certificacion_sanitaria, certificacion_zoosanitario,razon_social_importador,pais_origen,req.fecha_creacion_registro, pro.nombre   ORDER BY 
            ic_tipo_requerimiento_id, mu.provincia_id ";


        $filas = array();
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            while ($filasProducto = pg_fetch_assoc($result)) {
                $muestra = new Muestra($filasProducto['ic_requerimiento_id'],  $filasProducto['ic_muestra_id'],
                    $filasProducto['fecha_muestreo'],  $filasProducto['codigo_muestras'],  $filasProducto['canton_id'],
                    $filasProducto['parroquia_id'],  $filasProducto['tipo_empresa'],  $filasProducto['finca_id'],
                    $filasProducto['utm_x'],  $filasProducto['utm_y'],  $filasProducto['registro_importador'],
                    $filasProducto['permiso_fitosanitario'],  $filasProducto['tecnico_id'],
                    $filasProducto['ic_resultado_decision_id'],  $filasProducto['activo'],  $filasProducto['estado'],
                    $filasProducto['provincia_id'],  $filasProducto['origen_muestra_id'],  $filasProducto['nombre_rep_legal'],
                    $filasProducto['pais_procedencia_id'],  $filasProducto['tipo_muestra_id'],
                    $filasProducto['fecha_envio_lab'],
                    $filasProducto['cantidad_muestras_lab'],
                    $filasProducto['cantidad_contra_muestra'],
                    $filasProducto['ultimo_insumo_aplicado_id'],
                    $filasProducto['produccion_estimada'],
                    $filasProducto['fecha_ultima_aplicacion'],
                    $filasProducto['tecnica_muestreo'],
                    $filasProducto['medio_refrigeracion'],
                    $filasProducto['observaciones'],
                    $filasProducto['nombre_establecimiento'],
                    $filasProducto['direccion_establecimiento'], 
                    $filasProducto['certificacion_sanitaria'],
                    $filasProducto['certificacion_zoosanitario'],
                    $filasProducto['razon_social_importador'],
                    $filasProducto['pais_origen']);
                $muestra->setIcTipoRequerimientoId($filasProducto['ic_tipo_requerimiento_id']);
                $muestra->setFechaCreacionRegistro($filasProducto['fecha_creacion_registro']);
                $muestra->setProducto($filasProducto['nombre']);
                array_push($filas, $muestra);
            }

        }catch(Exception $exc){
            return array();
        }
        return $filas;
    }


    private function executeArrayQuery($conexion,$queryAll){
        $filas = array();
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            while ($filasProducto = pg_fetch_assoc($result)) {
                $muestra = new Muestra($filasProducto['ic_requerimiento_id'],  $filasProducto['ic_muestra_id'],
                    $filasProducto['fecha_muestreo'],  $filasProducto['codigo_muestras'],  $filasProducto['canton_id'],
                    $filasProducto['parroquia_id'],  $filasProducto['tipo_empresa'],  $filasProducto['finca_id'],
                    $filasProducto['utm_x'],  $filasProducto['utm_y'],  $filasProducto['registro_importador'],
                    $filasProducto['permiso_fitosanitario'],  $filasProducto['tecnico_id'],
                    $filasProducto['ic_resultado_decision_id'],  $filasProducto['activo'],  $filasProducto['estado'],
                    $filasProducto['provincia_id'],  $filasProducto['origen_muestra_id'],  $filasProducto['nombre_rep_legal'],
                    $filasProducto['pais_procedencia_id'],  $filasProducto['tipo_muestra_id'],
                    $filasProducto['fecha_envio_lab'],
                    $filasProducto['cantidad_muestras_lab'],
                    $filasProducto['cantidad_contra_muestra'],
                    $filasProducto['ultimo_insumo_aplicado_id'],
                    $filasProducto['produccion_estimada'],
                    $filasProducto['fecha_ultima_aplicacion'],
                    $filasProducto['tecnica_muestreo'],
                    $filasProducto['medio_refrigeracion'],
                    $filasProducto['observaciones']);
                array_push($filas, $muestra);
            }
        }catch(Exception $exc){
            return array();
        }
        return $filas;
    }

    public function getMuestraByIdRequerimeinto($ic_muestra_id,$conexion){
        $queryAll="SELECT
                    distinct dm.residuo ,
                        (SELECT NOMBRE FROM G_INOCUIDAD.IC_INSUMO WHERE ic_insumo_id = pi.ic_insumo_id) as insumo,
                        (SELECT NOMBRE FROM G_INOCUIDAD.IC_LMR WHERE ic_lmr_id = pi.ic_lmr_id) as lmr,
                        (SELECT um.nombre || ' (' || um.codigo || ')' FROM g_catalogos.unidades_medidas um WHERE um.id_unidad_medida = pi.um::numeric) as unidad_medida,
                        limite_minimo,
                        limite_maximo,
                        valor,
                        rv.ic_muestra_id
                    FROM g_inocuidad.ic_producto_muestra_rapida pi
                    JOIN g_inocuidad.ic_muestra_rapida rv ON pi.ic_producto_id = rv.ic_producto_id AND pi.ic_insumo_id = rv.ic_insumo_id
                    JOIN g_inocuidad.ic_detalle_muestra dm ON dm.ic_muestra_id = rv.ic_muestra_id AND dm.analito = (SELECT NOMBRE FROM G_INOCUIDAD.IC_INSUMO WHERE ic_insumo_id = pi.ic_insumo_id)
                    Join g_inocuidad.ic_muestra mu on mu.ic_muestra_id = rv.ic_muestra_id
                    WHERE mu.ic_requerimiento_id = $ic_muestra_id";

        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            $banderaReporte= true;
            while ($residuo = pg_fetch_assoc($result)) {
               
                $patron = '/[^0-9.,]/';
                $valor=$residuo['residuo'];
                if (preg_match($patron, $valor)) {
                    $banderaReporte=false;
                }
            }
        }catch(Exception $exc){
            return $banderaReporte=false;
        }
        return $banderaReporte;
    }

    public function getMuestraById($ic_muestra_id,$conexion){
        $queryAll="SELECT ic_requerimiento_id, ic_muestra_id, fecha_muestreo, codigo_muestras, 
               canton_id, parroquia_id, tipo_empresa, finca_id, utm_x, utm_y, 
               registro_importador, permiso_fitosanitario, tecnico_id, ic_resultado_decision_id, 
               activo, estado, provincia_id, origen_muestra_id, nombre_rep_legal, 
               pais_procedencia_id, tipo_muestra_id, fecha_envio_lab,cantidad_muestras_lab,cantidad_contra_muestra,ultimo_insumo_aplicado_id,produccion_estimada,
               fecha_ultima_aplicacion,tecnica_muestreo,medio_refrigeracion,observaciones,nombre_establecimiento,direccion_establecimiento,certificacion_sanitaria,
               certificacion_zoosanitario,razon_social_importador,pais_origen
          FROM g_inocuidad.ic_muestra
          WHERE ic_muestra_id = $ic_muestra_id";

        $muestra = null;
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            while ($filasProducto = pg_fetch_assoc($result)) {
                $muestra = new Muestra($filasProducto['ic_requerimiento_id'],  $filasProducto['ic_muestra_id'],
                    $filasProducto['fecha_muestreo'],  $filasProducto['codigo_muestras'],  $filasProducto['canton_id'],
                    $filasProducto['parroquia_id'],  $filasProducto['tipo_empresa'],  $filasProducto['finca_id'],
                    $filasProducto['utm_x'],  $filasProducto['utm_y'],  $filasProducto['registro_importador'],
                    $filasProducto['permiso_fitosanitario'],  $filasProducto['tecnico_id'],
                    $filasProducto['ic_resultado_decision_id'],  $filasProducto['activo'],  $filasProducto['estado'],
                    $filasProducto['provincia_id'],  $filasProducto['origen_muestra_id'],  $filasProducto['nombre_rep_legal'],
                    $filasProducto['pais_procedencia_id'],  $filasProducto['tipo_muestra_id'],
                    $filasProducto['fecha_envio_lab'],
                    $filasProducto['cantidad_muestras_lab'],
                    $filasProducto['cantidad_contra_muestra'],
                    $filasProducto['ultimo_insumo_aplicado_id'],
                    $filasProducto['produccion_estimada'],
                    $filasProducto['fecha_ultima_aplicacion'],
                    $filasProducto['tecnica_muestreo'],
                    $filasProducto['medio_refrigeracion'],
                    $filasProducto['observaciones'],
                    $filasProducto['nombre_establecimiento'],
                    $filasProducto['direccion_establecimiento'], 
                    $filasProducto['certificacion_sanitaria'],
                    $filasProducto['certificacion_zoosanitario'],
                    $filasProducto['razon_social_importador'],
                    $filasProducto['pais_origen']);
            }
        }catch(Exception $exc){
            return new Muestra();
        }
        return $muestra;
    }

    public function saveAndUpdateMuestra(Muestra $muestra,$conexion){
        $result=null;
        $querySave="";
        $util = new Util();
        if(isset($muestra)) {

            $ic_requerimiento_id        = $muestra->getIcRequerimientoId();
            $ic_muestra_id              = $muestra->getIcMuestraId();
            $fecha_muestreo             = $util->formatDate($muestra->getFechaMuestreo());
            $codigo_muestras            = $muestra->getCodigoMuestras();
            $provincia_id               = $muestra->getProvinciaId();
            $canton_id                  = $muestra->getCantonId();
            $parroquia_id               = $muestra->getParroquiaId();
            $tipo_empresa               = $muestra->getTipoEmpresa();

            $finca_id                   = $muestra->getFincaId();
            $utm_x                      = $muestra->getUtmX()!=null?$muestra->getUtmX():0;
            $utm_y                      = $muestra->getUtmY()!=null?$muestra->getUtmY():0;
            $registro_importador        = $muestra->getRegistroImportador();
            $permiso_fitosanitario      = $muestra->getPermisoFitosanitario();
            $tecnico_id                 = $muestra->getTecnicoId()!=null?$muestra->getTecnicoId():null;
            $ic_resultado_decision_id   = $muestra->getIcResultadoDecisionId()!=null?$muestra->getIcResultadoDecisionId():0;
            $activo                     = $muestra->getActivo();
            $estado                     = $muestra->getEstado();
            $origen_muestra_id          = $muestra->getOrigenMuestraId()!=null?$muestra->getOrigenMuestraId():0;
            $nombre_rep_legal           = $muestra->getNombreRepLegal();
            $pais_procedencia_id        = $muestra->getPaisProcedenciaId()!=null?$muestra->getPaisProcedenciaId():0;
            $tipo_muestra_id            = $muestra->getTipoMuestraId()!=null?$muestra->getTipoMuestraId():0;


            $fecha_envio_lab           = $util->formatDate($muestra->getFechaEnvioLab());
            $cantidad_muestras_lab     = $muestra->getCantidadMuestrasLab();
            $cantidad_contra_muestra   = $muestra->getCantidadContraMuestra();
            $ultimo_insumo_aplicado_id = $muestra->getUltimoInsumoAplicadoId();
            $produccion_estimada       = $muestra->getProduccionEstimada();
            $fecha_ultima_aplicacion   = $util->formatDate($muestra->getFechaUltimaAplicacion());
            $tecnica_muestreo          = $muestra->getTecnicaMuestreo();
            $medio_refrigeracion       = $muestra->getMedioRefrigeracion();
            $observaciones             = $muestra->getObservaciones();

            //agregado Elvis

            $nombre_establecimiento = $muestra->getNombreEstablecimiento();
            $direccion_establecimiento = $muestra->getDireccionEstablecimiento();
            $certificacion_sanitaria = $muestra->getCertificacionSanitaria();
            $certificado_zoosanitario = $muestra->getCertificacionZoosanitario();
        
            $razon_social_importador = $muestra->getRazonSocialImportador();
            $pais_origen = $muestra->getPaisOrigen();



            if ($muestra->getIcMuestraId() != null) {
                $querySave = " UPDATE g_inocuidad.ic_muestra
                   SET ic_requerimiento_id=$ic_requerimiento_id, fecha_muestreo='$fecha_muestreo', codigo_muestras='$codigo_muestras', 
                       canton_id=$canton_id, parroquia_id=$parroquia_id, tipo_empresa='$tipo_empresa', finca_id=$finca_id, utm_x='$utm_x', 
                       utm_y='$utm_y', registro_importador='$registro_importador', permiso_fitosanitario='$permiso_fitosanitario', tecnico_id='$tecnico_id', 
                       ic_resultado_decision_id=$ic_resultado_decision_id, provincia_id=$provincia_id, 
                       origen_muestra_id=$origen_muestra_id, nombre_rep_legal='$nombre_rep_legal', pais_procedencia_id=$pais_procedencia_id, 
                       tipo_muestra_id=$tipo_muestra_id,
                       fecha_envio_lab='$fecha_envio_lab',
                       cantidad_muestras_lab=$cantidad_muestras_lab,
                       cantidad_contra_muestra=$cantidad_contra_muestra,
                       ultimo_insumo_aplicado_id=$ultimo_insumo_aplicado_id,
                       produccion_estimada=$produccion_estimada,
                       tecnica_muestreo='$tecnica_muestreo',
                       medio_refrigeracion='$medio_refrigeracion',
                       observaciones='$observaciones',
                       nombre_establecimiento = '$nombre_establecimiento',
                       certificacion_zoosanitario = '$certificado_zoosanitario',
                       razon_social_importador = '$razon_social_importador',
                       pais_origen = '$pais_origen',
                       direccion_establecimiento = '$direccion_establecimiento',
                       certificacion_sanitaria = '$certificacion_sanitaria'
                   WHERE ic_muestra_id=$ic_muestra_id";

            }else
               throw new Exception("La muestra debe originarse en el Caso [ic_muestra_id = null]");

            try{
              
                $conexion->ejecutarConsulta($querySave);
            }catch (Exception $exc){
                $result = "Existe un problema con la información. Revise los valores duplicados.";
            }

            return $result;
        }
    }

    public function updateContraMuestra($idMuestra, $cantidadContraMuestra, $conexion){
        $queryUpdate = "UPDATE g_inocuidad.ic_muestra SET cantidad_contra_muestra = $cantidadContraMuestra WHERE ic_muestra_id = $idMuestra";
        $result=$conexion->ejecutarConsulta($queryUpdate);

        return $result;
    }

    public function creaMuestraCaso($idCaso, $conexion,$ic_producto_id, $provincia_id, $arrayParametros){
        $result=null;
        $querySave="";
        $controladorRequerimiento = new ControladorRequerimiento();
        if(isset($idCaso)) {
            $arrayMuestras = array();
            if ($arrayParametros['tipo_requerimiento_id'] == 'DN' || $arrayParametros['tipo_requerimiento_id'] == 'NE' ){
                $sequenceQuery ='SELECT nextval(\'g_inocuidad.ic_muestra_ic_muestra_id_seq\')';
                $muestraId=$this->obtenerSecuencial($conexion,$sequenceQuery);
                $caso = $controladorRequerimiento->recuperarRequerimiento($idCaso);
                $cantidad_muestras = $caso->getNumeroMuestras();
                $cantidadContraMuestra = 1;
                $querySave="INSERT INTO g_inocuidad.ic_muestra (ic_muestra_id,ic_requerimiento_id,provincia_id,cantidad_muestras_lab, cantidad_contra_muestra) 
                        VALUES ($muestraId,$idCaso,$provincia_id,$cantidad_muestras,$cantidadContraMuestra)";
               
                $result=$conexion->ejecutarConsulta($querySave);
                //actualizar estado_registro tabla requerimiento
                $query ="UPDATE g_inocuidad.ic_requerimiento
                        SET  estado_registro ='enviadoMuestra' WHERE ic_requerimiento_id = ".$idCaso."";
                $update = $conexion->ejecutarConsulta($query);
                $result=$muestraId;
                    array_push($arrayMuestras, $result);
                    //Verificamos si el producto necesita muestra rapida
                    $controladorProducto = new ControladorProducto();
                    $producto = $controladorProducto->getProducto($ic_producto_id);
                    if($producto->getMuestraRapida()=='S')
                        $this->creaRegistroValorMuestraRapida($muestraId,$ic_producto_id,$conexion);
            }else{

                $queryConsultaCasos=" SELECT  r.ic_requerimiento_id
                            FROM g_inocuidad.ic_requerimiento r
                            INNER JOIN g_catalogos.localizacion loc
                            ON loc.id_localizacion = r.provincia_aplicacion
                            WHERE ic_producto_id = ".$arrayParametros['cod_producto']." AND provincia_id = ".$arrayParametros['cod_provincia']."  
                            AND programa_id = ".$arrayParametros['cod_programa']." AND ic_tipo_requerimiento_id = ".$arrayParametros['tipo_requerimiento_id']." 
                            AND numero_muestras = ".$arrayParametros['muestras']." ORDER BY r.ic_requerimiento_id ASC";

                $result = $conexion->ejecutarConsulta($queryConsultaCasos);

                $arrayRequerimiento = array();
               
                while ($fila = pg_fetch_assoc($result)) {
                    array_push($arrayRequerimiento, $fila['ic_requerimiento_id']);
                }

                 if($arrayParametros['respuesta'] == "rechazar" && $arrayParametros['tipo_requerimiento_id'] == '1'){
                    foreach ($arrayRequerimiento as $valor) {
                        $idCaso = $valor;
                        //actualizar estado_registro tabla requerimiento cuando rechaza el planificador
                        $query ="UPDATE g_inocuidad.ic_requerimiento
                                SET  estado_registro ='rechazadoPlanificador', observacion ='". $arrayParametros['observacion_planificador_envio']."'
                                 WHERE ic_requerimiento_id = ".$idCaso."";
                            $update = $conexion->ejecutarConsulta($query);
                    }
                    array_push($arrayMuestras, '');
                }else{

                    $i=0;
                    foreach ($arrayRequerimiento as $valor) {

                        $idCaso = $valor;
                        $sequenceQuery ='SELECT nextval(\'g_inocuidad.ic_muestra_ic_muestra_id_seq\')';
                        $muestraId=$this->obtenerSecuencial($conexion,$sequenceQuery);
                        $caso = $controladorRequerimiento->recuperarRequerimiento($idCaso);
                        $cantidad_muestras = $caso->getNumeroMuestras();
                        $cantidadContraMuestra = 1;
                        $querySave="INSERT INTO g_inocuidad.ic_muestra (ic_muestra_id,ic_requerimiento_id,provincia_id,cantidad_muestras_lab, cantidad_contra_muestra) 
                                    VALUES ($muestraId,$idCaso,$provincia_id,$cantidad_muestras,$cantidadContraMuestra)";
                        $result=$conexion->ejecutarConsulta($querySave);
                        $id_muestra=$muestraId;

                        //actualizar estado_registro tabla requerimiento
                        $query ="UPDATE g_inocuidad.ic_requerimiento
                                        SET  estado_registro ='aprobadoPlanificador' WHERE ic_requerimiento_id = ".$idCaso."";
                        $update = $conexion->ejecutarConsulta($query);
                        
                        //Verificamos si el producto necesita muestra rapida
                        $controladorProducto = new ControladorProducto();
                        $producto = $controladorProducto->getProducto($ic_producto_id);
                        if($producto->getMuestraRapida()=='S'){
                            $this->creaRegistroValorMuestraRapida($muestraId,$ic_producto_id,$conexion);
                        }
                        array_push($arrayMuestras, $id_muestra);
                        $i++;
                    }
                }
            }    
        }else{
            throw new Exception("La muestra debe originarse en el Caso [ic_muestra_id = null]");
        }
    return $arrayMuestras;
    }

    public function creaRegistroValorMuestraRapida($muestraId, $ic_producto_id,$conexion){
        $controladorProducto = new ControladorProducto();
        $productoInsumos = $controladorProducto->listarProductosInsumosMuestraRapida($ic_producto_id);

        /* @var $insumo ProductoInsumo*/
        foreach ($productoInsumos as $insumo) {
            $sequenceQuery = 'SELECT nextval(\'g_inocuidad.ic_muestra_rapida_ic_muestra_rapida_id_seq\')';
            $muestraRapidaId = $this->obtenerSecuencial($conexion, $sequenceQuery);

            $ic_producto_id     =$insumo->getIcProductoId();
            $ic_insumo_id       =$insumo->getIcInsumoId();
            $um                 =$insumo->getUm();

            $querySave="INSERT INTO g_inocuidad.ic_muestra_rapida(
                            ic_muestra_rapida_id, ic_muestra_id, ic_producto_id, 
                            ic_insumo_id, valor, observaciones, um)
                    VALUES ($muestraRapidaId, $muestraId, $ic_producto_id, 
                            $ic_insumo_id, 0, NULL , $um)";

            try{
                $result=$conexion->ejecutarConsulta($querySave);
            }catch (Exception $exc){
                $result = $exc;
            }
        }
    }

    public function saveAndUpdateMuestraRapidaValor(MuestraRapidaValor $registroValor, $conexion)
    {
        $result = null;
        $querySave = "";
        if (isset($registroValor)) {
            $ic_muestra_rapida_id   = $registroValor->getIcMuestraRapidaId();
            $valor                  = $registroValor->getValor();
            $observaciones          = $registroValor->getObservaciones();

            $querySave = "UPDATE g_inocuidad.ic_muestra_rapida
                           SET valor=$valor, observaciones='$observaciones'
                         WHERE ic_muestra_rapida_id=$ic_muestra_rapida_id";

            try{
                $conexion->ejecutarConsulta($querySave);
            }catch (Exception $exc){
                $result = $exc;
            }

            return $result;

        }
    }

    public function getAllMuestraRapidaValorByMuestra($ic_muestra_id,$conexion){
        $queryAll=" SELECT ic_muestra_rapida_id, ic_muestra_id, ic_producto_id, ic_insumo_id, 
                       valor, observaciones, um
                  FROM g_inocuidad.ic_muestra_rapida
                  WHERE ic_muestra_id=$ic_muestra_id";

        $filas = array();
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            while ($filasProducto = pg_fetch_assoc($result)) {
                $muestraRapidaValor = new MuestraRapidaValor($filasProducto['ic_muestra_rapida_id'],$filasProducto['ic_muestra_id'],
                    $filasProducto['ic_producto_id'],$filasProducto['ic_insumo_id'],$filasProducto['valor'],
                    $filasProducto['observaciones'],$filasProducto['um']);
                array_push($filas, $muestraRapidaValor);
            }
        }catch(Exception $exc){
            return array();
        }
        return $filas;
    }

    function getResultadoMuestraRapidaDatos($ic_muestra_id,$conexion){
        $queryAll = "select  (SELECT NOMBRE FROM G_INOCUIDAD.IC_INSUMO WHERE ic_insumo_id = pi.ic_insumo_id) as insumo,
                      (select um.nombre||' ('||um.codigo||')' from g_catalogos.unidades_medidas um where um.id_unidad_medida = pi.um::numeric) as unidad_medida
                      ,limite_minimo,limite_maximo,valor,observaciones
                    from g_inocuidad.ic_producto_muestra_rapida pi
                    join g_inocuidad.ic_muestra_rapida rv on pi.ic_producto_id = rv.ic_producto_id and pi.ic_insumo_id = rv.ic_insumo_id
                    where ic_muestra_id =$ic_muestra_id";
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            $filasPrd = pg_fetch_all($result);
            return $filasPrd;
        }catch (Exception $exc){
            return null;
        }
    }

    public function getMuestraRO($muestra_id,$conexion){
        $queryAll = "select * from G_INOCUIDAD.IC_V_MUESTRA WHERE ic_muestra_id=$muestra_id";
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            $filasPrd = pg_fetch_assoc($result);
            return $filasPrd;
        }catch (Exception $exc){
            return null;
        }
    }

    private function obtenerSecuencial($conexion,$querySequence){
        $res=$conexion->ejecutarConsulta($querySequence);
        $sec=pg_fetch_assoc($res);
        return $sec['nextval'];
    }

    public function actualizarEstadoRequerimientoInspector($conexion,$ic_requerimiento_id){
       
        if(isset($ic_requerimiento_id)) {
          
            $querySave="UPDATE g_inocuidad.ic_requerimiento
                        SET estado_registro = 'porAprobar'
                        WHERE ic_requerimiento_id = $ic_requerimiento_id;";
        }else
            throw new Exception("La muestra debe originarse en el Caso [ic_muestra_id = null]");

        try{
            $result=$conexion->ejecutarConsulta($querySave);
            
        }catch (Exception $exc){
            $result = $exc;
        }

        return $result;
    }



}