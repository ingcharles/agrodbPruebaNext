<?php
/**
 * Created by PhpStorm.
 * User: advance
 * Date: 2/1/18
 * Time: 9:36 PM
 */
require_once '../Modelo/Caso.php';
require_once '../Util.php';
require_once '../controladores/ControladorAuditoria.php';
class ServiceCasoDAO
{

    /**
     * ServiceCasoDAO constructor.
     */
    public function __construct()
    {

    }

    public function saveAndUpdateCaso(Caso $caso,$conexion,$numero_casos,$casoObtenido){

        $querySave = null;
        $queries = array();
        $result=null;
        $sequenceQuery ='SELECT nextval(\'g_inocuidad.ic_requerimiento_ic_requerimiento_id_seq\')';
        $util = new Util();
        if(isset($caso)){
            
            $programaId=$caso->getProgramaId()!=null&$caso->getProgramaId()!=''?$caso->getProgramaId():0;
            $casoId=$caso->getId();
            $fuente=$caso->getFuenteId()!=null?$caso->getFuenteId():0;
            $producto=$caso->getProductoId()!=null?$caso->getProductoId():0;
            $pais=$caso->getPaisId()!=null?$caso->getPaisId():0;
            $provincia=$caso->getProvinciaId()!=null?$caso->getProvinciaId():0;
            $inspector=$caso->getInspectorId()!=null?$caso->getInspectorId():null;
            $mercaderia=$caso->getOrigenMercaderiaId()!=null?$caso->getOrigenMercaderiaId():0;
            $tipoReque=$caso->getTipoRequerimientoId()!=null?$caso->getTipoRequerimientoId():0;
            $fecha=$caso->getFechaSolicitud();
            $nombreDenuncia=$caso->getNombreDenunciante();
            $datosDenuncia=$caso->getDatosDenunciante();
            $descripcionDenuncia=$caso->getDescripcionDenuncia();
            $observacion=$caso->getObservacion();
            $numeroMuestras=$caso->getNumeroMuestras()!=null?$caso->getNumeroMuestras():0;
            $fecha_inspeccion=$caso->getFechaInspeccion()!=null&&$caso->getFechaInspeccion()!=0?$caso->getFechaInspeccion():null;
            $fecha_inspeccion_mes=$caso->getFechaInspeccionMes()!=null ? $caso->getFechaInspeccionMes():null;
            $fecha_notificacion=$caso->getFechaNotificacion()!=null&&$caso->getFechaNotificacion()!=0?$caso->getFechaNotificacion():null;
            $fecNotFormated=$util->formatDate($fecha_notificacion);
            $fecInspFormated=$util->formatDate($fecha_inspeccion);
            $fecha_denuncia=$caso->getFechaDenuncia()!=null&&$caso->getFechaDenuncia()!=0?$caso->getFechaDenuncia():null;
            $fecDenunciaFormated=$util->formatDate($fecha_denuncia);
            $usuario_id=$caso->getUsuarioId();
            $provinciaAplicacion=$caso->getProvinciaAplicacion()!=null?$caso->getProvinciaAplicacion():'';
            $observacionTecnico=$caso->getObservacionTecnico()!=null?$caso->getObservacionTecnico():'';
            $estadoRegistro=$caso->getEstadoRegistro()!=null?$caso->getEstadoRegistro():'';

            if (isset($casoObtenido) && (pg_num_rows($casoObtenido) > 0) &&  $inspector != ''){
                $datosCasoObtenido=pg_fetch_assoc($casoObtenido);
                if($datosCasoObtenido['estado_registro'] == 'casoCreado' || $datosCasoObtenido['estado_registro'] == 'casoGenerado' || $datosCasoObtenido['estado_registro'] == 'rechazadoPlanificador'){
                    $datosCasoObtenido['estado_registro'] == 'rechazadoPlanificador' ? $observacion = '':'';
                    $querySave="UPDATE g_inocuidad.ic_requerimiento ";
                    $querySave.=" SET ic_fuente_denuncia_id=$fuente,";
                    $querySave.=" pais_notificacion_id=$pais, provincia_id=$provincia, inspector_id='$inspector',";
                    $querySave.=" origen_mercaderia_id=$mercaderia,";
                    $querySave.=" nombre_denunciante='$nombreDenuncia', datos_denunciante='$datosDenuncia', descripcion_denuncia='$descripcionDenuncia', ";
                    $querySave.=$fecDenunciaFormated==null||strlen($fecDenunciaFormated)==0?"fecha_denuncia=null":"fecha_denuncia='$fecDenunciaFormated'";
                    $querySave.=" , ";
                    $querySave.=" observacion='$observacion', ";
                    $querySave.=$fecInspFormated==null||strlen($fecInspFormated)==0?"fecha_inspeccion=null":"fecha_inspeccion='$fecInspFormated'";
                    $querySave.=",";
                    $querySave.=$fecNotFormated==null||strlen($fecNotFormated)==0?"fecha_notificacion=null":"fecha_notificacion='$fecNotFormated'";
                    $querySave.=",";
                    $querySave.=" provincia_aplicacion='$provinciaAplicacion', observacion_tecnico='$observacionTecnico', estado_registro='$estadoRegistro', fecha_inspeccion_mes='$fecha_inspeccion_mes'";
                    $querySave.=" WHERE  ic_requerimiento_id=$casoId ";
                    if($programaId!=null){
                        $querySave.=" AND programa_id=$programaId";
    
                    }
                    // $queries[]=$querySave;
                    $result = $conexion->ejecutarConsulta($querySave);
                }  
            }
            

            if($caso->getId()!=null && ($datosCasoObtenido['estado_registro'] == 'casoCreado')){
                if($numero_casos == 1){
                    $numero_casos = $datosCasoObtenido['numero_muestras'];
                    $querySaveHistorial="INSERT INTO g_inocuidad.ic_historial_acciones(
                                identificador_usuario, fecha_creacion_registro, ic_requerimiento_id, accion)
                                VALUES ('$inspector', now(), $casoId, 'El inspector con CI: ".$inspector." ha generado el número de casos establecidos por el planificador');";
                    $result = $conexion->ejecutarConsulta($querySaveHistorial);
                }
               
                if($numero_casos == $datosCasoObtenido['numero_muestras']){
                    $numeroDuplicador = ($numero_casos - 1);
                }else if ($numero_casos < $numeroMuestras){
                    $numeroDuplicador = $numero_casos;
                }

                
                $sequenceGrupoQuery ='SELECT nextval(\'g_inocuidad.ic_requerimiento_id_grupo_seq\')';
                $grupoId=$this->obtenerSecuencial($conexion,$sequenceGrupoQuery);
                for($i=0;$i<$numeroDuplicador;$i++){

                    $querySave="INSERT INTO g_inocuidad.ic_requerimiento (programa_id, ic_fuente_denuncia_id, ic_producto_id, pais_notificacion_id, provincia_id, inspector_id, origen_mercaderia_id, 
                    ic_tipo_requerimiento_id, fecha_solicitud, nombre_denunciante, datos_denunciante, descripcion_denuncia, observacion, numero_muestras, 
                    fecha_inspeccion, fecha_denuncia, fuente_denuncia_id, fecha_notificacion, id_grupo, cancelado, motivo_cancelacion, usuario_id, 
                    fecha_creacion_registro, provincia_aplicacion, observacion_tecnico, estado_registro,fecha_inspeccion_mes) 
                    (SELECT programa_id,ic_fuente_denuncia_id, ic_producto_id, pais_notificacion_id, provincia_id, inspector_id, origen_mercaderia_id, 
                    ic_tipo_requerimiento_id, fecha_solicitud, nombre_denunciante, datos_denunciante, descripcion_denuncia, observacion, numero_muestras, 
                    fecha_inspeccion, fecha_denuncia, fuente_denuncia_id, fecha_notificacion, id_grupo, cancelado, motivo_cancelacion, usuario_id, 
                    fecha_creacion_registro, provincia_aplicacion, observacion_tecnico, estado_registro,fecha_inspeccion_mes
                     FROM g_inocuidad.ic_requerimiento WHERE ic_requerimiento_id = $casoId)";

                    $queries[]=$querySave;
                }

            }else if ($caso->getId()==null){
                $sequenceGrupoQuery ='SELECT nextval(\'g_inocuidad.ic_requerimiento_id_grupo_seq\')';
                $grupoId=$this->obtenerSecuencial($conexion,$sequenceGrupoQuery);
                $numero_casos = 1;
                for($i=0;$i<$numero_casos;$i++){
                    $casoId=$this->obtenerSecuencial($conexion,$sequenceQuery);


                    $querySave="INSERT INTO g_inocuidad.ic_requerimiento ";
                    $querySave.="( ic_requerimiento_id, ic_fuente_denuncia_id, ic_producto_id,";
                    $querySave.=" pais_notificacion_id, provincia_id, inspector_id, origen_mercaderia_id,";
                    $querySave.=" ic_tipo_requerimiento_id, fecha_solicitud, nombre_denunciante,";
                    $querySave.=" datos_denunciante, descripcion_denuncia, observacion, numero_muestras,";
                    $querySave.=" fecha_inspeccion, fecha_notificacion, id_grupo, usuario_id, fecha_denuncia,estado_registro";
                    if($programaId!=null){
                        $querySave.=", programa_id";
                    }
                    $querySave.=")";
                    $querySave.="  VALUES($casoId,$fuente,$producto,$pais,$provincia,'$inspector',";
                    $querySave.="$mercaderia,$tipoReque,now(),'$nombreDenuncia','$datosDenuncia','$descripcionDenuncia','$observacion',$numeroMuestras,";
                    $querySave.=$fecInspFormated==null?"null":"'$fecInspFormated'";
                    $querySave.=",";
                    $querySave.=$fecNotFormated=null || strlen($fecNotFormated)==0?"null":"'$fecNotFormated'";
                    $querySave.=",$grupoId,'$usuario_id',";
                    $querySave.=$fecDenunciaFormated==null?"null":"'$fecDenunciaFormated'";
                    $querySave.=",";
                    $querySave.=$estadoRegistro==null?"null":"'$estadoRegistro'";
                    if($programaId!=null){
                        $querySave.=" ,$programaId";
                    }
                    $querySave.=")";
                    $queries[]=$querySave;
                }
            }

            //se guardan los registros de historial de inspector
            if($caso->getId()!=null && ($datosCasoObtenido['estado_registro'] == 'casoGenerado') && isset($casoObtenido) && (pg_num_rows($casoObtenido) > 0)){
                
					if( $datosCasoObtenido['fecha_inspeccion_mes'] != $fecha_inspeccion_mes){
                        $querySaveHistorial="INSERT INTO g_inocuidad.ic_historial_acciones(
                            identificador_usuario, fecha_creacion_registro, ic_requerimiento_id, accion)
                            VALUES ('$inspector', now(), $casoId, 'El inspector ha cambiado la fecha estimada de inspección');";
                        $result = $conexion->ejecutarConsulta($querySaveHistorial);
                    }
                    if( $datosCasoObtenido['observacion_tecnico'] != $observacionTecnico){
                        $querySaveHistorial="INSERT INTO g_inocuidad.ic_historial_acciones(
                            identificador_usuario, fecha_creacion_registro, ic_requerimiento_id, accion)
                            VALUES ('$inspector', now(), $casoId, 'El inspector a realizado un cambio en la observación');";
                        $result = $conexion->ejecutarConsulta($querySaveHistorial);  
                    }
                    if( $datosCasoObtenido['provincia_aplicacion'] != $provinciaAplicacion){
                        $querySaveHistorial="INSERT INTO g_inocuidad.ic_historial_acciones(
                            identificador_usuario, fecha_creacion_registro, ic_requerimiento_id, accion)
                            VALUES ('$inspector', now(), $casoId, 'El inspector ha cambiado la provincia de aplicación');";
                        $result = $conexion->ejecutarConsulta($querySaveHistorial);
                    }					                
            }
           
            try{
           
                foreach($queries as $query) {
                    $result = $conexion->ejecutarConsulta($query);
                }
                $result=$casoId;
            }catch (Exception $exc){
                $result = $exc->getMessage();
            }

            return $result;
        }

    }


    public function cancelarRegistro($ic_requerimiento_id, $mensaje,$archivo,$usuario, $conexion){
        try{
            $querySave="UPDATE g_inocuidad.ic_requerimiento set cancelado='S', motivo_cancelacion='$mensaje', ruta_archivo='$archivo' WHERE ic_requerimiento_id = $ic_requerimiento_id";
            $result=$conexion->ejecutarConsulta($querySave);
            //Auditoria
            $caso = $this->getCasoById($ic_requerimiento_id,$conexion);
            $auditoria = new ControladorAuditoria();
            $auditoria->auditarRegistroCancelar($usuario,$caso);
        }catch(Exception $exc){
            return $exc->getMessage();
        }
        return $result;
    }

    public function obtenerPerfilUsuarioCaso($conexion,$idUsuario){
        
		$res = $conexion->ejecutarConsulta("SELECT
											usper.identificador,
											per.nombre as perfil,
											per.codificacion_perfil,
											femp.nombre || ' ' || femp.apellido as usuario
										FROM
											g_usuario.usuarios_perfiles AS usper
											INNER JOIN g_usuario.perfiles AS per ON per.id_perfil = usper.id_perfil
											INNER JOIN g_usuario.usuarios us ON us.identificador = usper.identificador
											INNER JOIN g_uath.ficha_empleado femp ON us.identificador = femp.identificador
										WHERE
											usper.identificador = '$idUsuario' AND 
											per.estado=1 AND 
											us.estado=1 AND
											per.codificacion_perfil = 'PFL_CONF_INOC';");		
                                             

        return $res ;
	}

    public function obtenerRequerimiento($conexion,$programa_id){
        
		$res = $conexion->ejecutarConsulta("SELECT ic_catalogo_id, grupo, nombre, valor, valor_num, descripcion, referencia_id, tipo 
                                            FROM g_inocuidad.ic_catalogo WHERE ic_catalogo_id = $programa_id;");		
                                             

        return $res ;
	}


    public function getAllCasosInStep($usuario, $conexion,$banderaPerfil){

        $condicion = " ";
        $clapsula ="";
        $groupBy=" ";
        $clausula="";

        //true cuando es administrador
        if($banderaPerfil){
            $condicion = "r.usuario_id = '".$usuario."'";
            $clapsula ="min(ic_requerimiento_id) as ic_requerimiento_id, STRING_AGG(r.estado_registro,',') as estado_registro";
            $groupBy=" GROUP BY r.programa_id,  ic_fuente_denuncia_id, r.ic_producto_id, 
                        pais_notificacion_id, provincia_id, inspector_id, origen_mercaderia_id, 
                        r.ic_tipo_requerimiento_id, fecha_solicitud, nombre_denunciante, 
                        datos_denunciante, descripcion_denuncia, observacion, numero_muestras, 
                        p.nombre , tr.nombre";
            $clausula = "AND r.estado_registro NOT IN ('aprobadoPlanificador','rechazadoPlanificador')";           
        }else{
            $condicion = "(r.usuario_id='".$usuario."' or r.inspector_id = '".$usuario."')";
            $clapsula ="ic_requerimiento_id, r.estado_registro";
            $groupBy=" ";
            $clausula="";
        }

        $queryAll="SELECT r.programa_id, " . $clapsula  . ", ic_fuente_denuncia_id, r.ic_producto_id, 
        pais_notificacion_id, provincia_id, inspector_id, origen_mercaderia_id, 
        r.ic_tipo_requerimiento_id, fecha_solicitud, nombre_denunciante, 
        datos_denunciante, descripcion_denuncia, observacion, numero_muestras, '' as programa_n, 
        p.nombre as nombre_producto, tr.nombre as nombre_requerimiento
        FROM g_inocuidad.ic_requerimiento r, g_inocuidad.ic_producto p, g_inocuidad.ic_tipo_requerimiento tr
        WHERE r.cancelado='N'".$clausula." AND r.ic_producto_id = p.ic_producto_id 
        AND r.ic_tipo_requerimiento_id = tr.ic_tipo_requerimiento_id
        AND (r.obs_eliminacion ='' or r.obs_eliminacion  is null)
        AND r.ic_requerimiento_id NOT IN (SELECT ic_requerimiento_id FROM g_inocuidad.ic_muestra)
        AND CASE WHEN g_inocuidad.buscar_rol('PFL_CONF_INOC','$usuario') THEN 1=1 ELSE $condicion END
        " . $groupBy  . "
        ORDER BY r.ic_tipo_requerimiento_id, provincia_id, fecha_solicitud DESC";

        $filas = array();
        try {
            $result = $conexion->ejecutarConsulta($queryAll);
         
            while ($filasPrd = pg_fetch_assoc($result)) {
                
                    $caso = new Caso($filasPrd['ic_requerimiento_id'], $filasPrd['programa_id'], $filasPrd['ic_fuente_denuncia_id'], $filasPrd['ic_producto_id'],
                    $filasPrd['pais_notificacion_id'], $filasPrd['provincia_id'], $filasPrd['inspector_id'], $filasPrd['origen_mercaderia_id'],
                    $filasPrd['ic_tipo_requerimiento_id'], $filasPrd['fecha_solicitud'], $filasPrd['nombre_denunciante'], $filasPrd['datos_denunciante'],
                    $filasPrd['descripcion_denuncia'], $filasPrd['observacion'], $filasPrd['numero_muestras'], $filasPrd['programa_n'],$filasPrd['nombre_producto'],
                    $filasPrd['nombre_requerimiento'], isset($filasPrd['provincia_aplicacion'])?$filasPrd['provincia_aplicacion']:'', isset($filasPrd['observacion_tecnico'])?$filasPrd['observacion_tecnico']:'', isset($filasPrd['estado_registro'])?$filasPrd['estado_registro']:'');
                    array_push($filas, $caso);

            }

         
            
        }catch(Exception $exc){
            return array();
        }
        array_unshift($filas, $banderaPerfil);
        return $filas;
    }

    public function getAllCasos($conexion){
        $queryAll="SELECT r.programa_id, ic_requerimiento_id, ic_fuente_denuncia_id, r.ic_producto_id, ";
        $queryAll.=" pais_notificacion_id, provincia_id, inspector_id, origen_mercaderia_id, ";
        $queryAll.=" r.ic_tipo_requerimiento_id, fecha_solicitud, nombre_denunciante, ";
        $queryAll.=" datos_denunciante, descripcion_denuncia, observacion, numero_muestras, '' as programa_n, ";
        $queryAll.=" p.nombre as nombre_producto, tr.nombre as nombre_requerimiento, r.provincia_aplicacion, r.observacion_tecnico, r.estado_registro";
        $queryAll.=" FROM g_inocuidad.ic_requerimiento r, g_inocuidad.ic_producto p, g_inocuidad.ic_tipo_requerimiento tr";
        $queryAll.=" WHERE r.ic_producto_id = p.ic_producto_id ";
        $queryAll.=" AND r.ic_tipo_requerimiento_id = tr.ic_tipo_requerimiento_id";

        $filas = array();
        try {
            $result = $conexion->ejecutarConsulta($queryAll);

            while ($filasPrd = pg_fetch_assoc($result)) {
                $caso = new Caso($filasPrd['ic_requerimiento_id'], $filasPrd['programa_id'], $filasPrd['ic_fuente_denuncia_id'], $filasPrd['ic_producto_id'],
                    $filasPrd['pais_notificacion_id'], $filasPrd['provincia_id'], $filasPrd['inspector_id'], $filasPrd['origen_mercaderia_id'],
                    $filasPrd['ic_tipo_requerimiento_id'], $filasPrd['fecha_solicitud'], $filasPrd['nombre_denunciante'], $filasPrd['datos_denunciante'],
                    $filasPrd['descripcion_denuncia'], $filasPrd['observacion'], $filasPrd['numero_muestras'], $filasPrd['programa_n'],$filasPrd['nombre_producto'],
                    $filasPrd['nombre_requerimiento'], $filasPrd['provincia_aplicacion'], $filasPrd['observacion_tecnico'], $filasPrd['estado_registro']);
                array_push($filas, $caso);
            }
        }catch(Exception $exc){
            return array();
        }
        return $filas;
    }

    public function getCasoById($requerimientoId,$conexion){
        
        $caso = null;
        $queryAll="SELECT r.programa_id, ic_requerimiento_id, ic_fuente_denuncia_id, r.ic_producto_id, ";
        $queryAll.=" pais_notificacion_id, provincia_id, inspector_id, origen_mercaderia_id, ";
        $queryAll.=" r.ic_tipo_requerimiento_id, fecha_solicitud, nombre_denunciante, ";
        $queryAll.=" datos_denunciante, descripcion_denuncia, observacion, numero_muestras, '' as programa_n, ";
        $queryAll.=" p.nombre as nombre_producto, tr.nombre as nombre_requerimiento, ";
        $queryAll.=" r.fecha_inspeccion as fecha_inspeccion, fecha_notificacion as fecha_notificacion , fecha_denuncia as fecha_denuncia, r.provincia_aplicacion, r.observacion_tecnico, r.estado_registro, to_char( r.fecha_creacion_registro, 'YYYY-MM-DD') as fecha_creacion_registro, r.fecha_inspeccion_mes";
        $queryAll.=" FROM g_inocuidad.ic_requerimiento r, g_inocuidad.ic_producto p, g_inocuidad.ic_tipo_requerimiento tr";
        $queryAll.=" WHERE r.ic_producto_id = p.ic_producto_id ";
        $queryAll.=" AND r.ic_tipo_requerimiento_id = tr.ic_tipo_requerimiento_id";
        $queryAll.=" AND ic_requerimiento_id = $requerimientoId";

        try {
            $result = $conexion->ejecutarConsulta($queryAll);
            while ($filasPrd = pg_fetch_assoc($result)) {
            $caso = new Caso($filasPrd['ic_requerimiento_id'], $filasPrd['programa_id'], $filasPrd['ic_fuente_denuncia_id'], $filasPrd['ic_producto_id'],
                $filasPrd['pais_notificacion_id'], $filasPrd['provincia_id'], $filasPrd['inspector_id'], $filasPrd['origen_mercaderia_id'],
                $filasPrd['ic_tipo_requerimiento_id'], $filasPrd['fecha_solicitud'], $filasPrd['nombre_denunciante'], $filasPrd['datos_denunciante'],
                $filasPrd['descripcion_denuncia'], $filasPrd['observacion'], $filasPrd['numero_muestras'],
                $filasPrd['programa_n'],$filasPrd['nombre_producto'],
                $filasPrd['nombre_requerimiento'], $filasPrd['provincia_aplicacion'], $filasPrd['observacion_tecnico'], $filasPrd['estado_registro']);
                $caso->setFechaInspeccion($filasPrd['fecha_inspeccion']);
                $caso->setFechaInspeccionMes($filasPrd['fecha_inspeccion_mes']);
                $caso->setFechaNotificacion($filasPrd['fecha_notificacion']);
                $caso->setFechaDenuncia($filasPrd['fecha_denuncia']);
                $caso->setFechaCreacionRegistro($filasPrd['fecha_creacion_registro']);
                $caso->setProgramaId($filasPrd['programa_id']);
            }
        }catch(Exception $exc){
            return new Caso();
        }
        return $caso;
    }

    public function getCasoRO($requerimientoId,$conexion){
        $queryAll = "select * from G_INOCUIDAD.IC_V_REQUERIMIENTO WHERE ic_requerimiento_id=$requerimientoId";
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            $filasPrd = pg_fetch_assoc($result);
            return $filasPrd;
        }catch (Exception $exc){
            return null;
        }
    }

    public function getCasoIngresado($requerimientoId,$conexion){
        $queryAll = "select * from G_INOCUIDAD.IC_REQUERIMIENTO WHERE ic_requerimiento_id=$requerimientoId";
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
           
            return $result;
        }catch (Exception $exc){
            return null;
        }
    }

    public function deleteCaso($requerimientoId,$conexion){
        $queryDelete="DELETE FROM g_inocuidad.ic_requerimiento WHERE ic_requerimiento_id=$requerimientoId";
        $result = $conexion->ejecutarConsulta($queryDelete);
        return $result;
    }

    public function deleteAllCaso($conexion,$parametros){
        $objParametros= json_decode($parametros);
        $queryDelete="UPDATE g_inocuidad.ic_requerimiento
        SET obs_eliminacion='eliminado en la fase de caso'
         WHERE ic_requerimiento_id = ".$objParametros->{'requerimiento_id'}." 
         AND ic_producto_id = ".$objParametros->{'producto_id'}." 
         AND provincia_id = ".$objParametros->{'provincia_id'}."  
        AND programa_id = ".$objParametros->{'programa_id'}." 
        AND ic_tipo_requerimiento_id = ".$objParametros->{'ic_tipo_requerimiento_id'}." 
        AND numero_muestras = ".$objParametros->{'numero_muestras'}."";
        $result = $conexion->ejecutarConsulta($queryDelete);
        return $result;
    }


    public function formatDate($dateString){
        $date = new DateTime($dateString);
        return $date->format('Y/m/d H:i:s');
    }

    private function obtenerSecuencial($conexion,$querySequence){
        $res=$conexion->ejecutarConsulta($querySequence);
        $sec=pg_fetch_assoc($res);
        return $sec['nextval'];
    }


    public function getAllCasosPorParametros($conexion,$parametros){
         $objParametros= json_decode($parametros);

        $query=" SELECT  r.ic_requerimiento_id, fecha_inspeccion_mes as fecha_inspeccion, loc.nombre, observacion_tecnico,r.numero_muestras,r.estado_registro 
                        FROM g_inocuidad.ic_requerimiento r
                        INNER JOIN g_catalogos.localizacion loc
                        ON loc.id_localizacion = r.provincia_aplicacion
                        WHERE ic_producto_id = ".$objParametros->{'producto_id'}." AND provincia_id = ".$objParametros->{'provincia_id'}."  
                        AND programa_id = ".$objParametros->{'programa_id'}." AND ic_tipo_requerimiento_id = ".$objParametros->{'ic_tipo_requerimiento_id'}." 
                        AND numero_muestras = ".$objParametros->{'numero_muestras'}." AND estado_registro  IN ('porAprobar')";       
        try {
            $result = $conexion->ejecutarConsulta($query);
            $contadorRegistros=0;
            $totalMuestras=0;
            if(pg_num_rows($result) > 0){
                while ($fila = pg_fetch_assoc($result)) {
                
                    if($fila['estado_registro'] == 'porAprobar'){
                        $contadorRegistros=$contadorRegistros+1;
                    }
                    $res[] = array('ic_requerimiento_id'=>$fila['ic_requerimiento_id'],'fecha_inspeccion'=>$fila['fecha_inspeccion'],'nombre'=>$fila['nombre'],'observacion_tecnico'=>$fila['observacion_tecnico']);
                    $totalMuestras=$fila['numero_muestras'];
                }
            array_unshift($res, $contadorRegistros,$totalMuestras);
            }else{
                $res=null;
            }
               

        }catch(Exception $exc){
            return array();
        }

        return $res;
    }

    public function buscarDatosCasosPlanVigilancia($conexion,$parametros){
       
            $res = $conexion->ejecutarConsulta("SELECT r.inspector_id, r.ic_producto_id, r.provincia_id, r.numero_muestras, r.id_grupo, r.ic_tipo_requerimiento_id, r.usuario_id
                                                FROM g_inocuidad.ic_requerimiento r
                                                WHERE ic_requerimiento_id = $parametros;");
        return $res ;

    }
    public function buscarDatosPlanificadorInspector($conexion,$id_muestra){
       
        $res = $conexion->ejecutarConsulta("SELECT r.inspector_id, r.usuario_id, mu.codigo_muestras
                                            FROM g_inocuidad.ic_requerimiento r
                                            INNER JOIN g_inocuidad.ic_muestra mu
                                            ON mu.ic_requerimiento_id = r.ic_requerimiento_id
                                            WHERE mu.ic_muestra_id =  $id_muestra;");
        return $res ;

    }
    

    public function buscarDatosCasosPlanVigilanciaPorParametros($conexion,$parametros){
           
        $res = $conexion->ejecutarConsulta("SELECT r.inspector_id, r.ic_producto_id, r.provincia_id, r.numero_muestras, r.id_grupo, r.ic_tipo_requerimiento_id, r.usuario_id
                                            FROM g_inocuidad.ic_requerimiento r
                                            WHERE inspector_id = '".$parametros['inspector_id']."' AND ic_producto_id = ".$parametros['ic_producto_id']." AND provincia_id = ".$parametros['provincia_id']."
                                            AND ic_tipo_requerimiento_id= ".$parametros['ic_tipo_requerimiento_id']." AND numero_muestras=".$parametros['numero_muestras']." AND id_grupo=".$parametros['id_grupo']."");
        return $res ;

    }

    public function buscarDatosInspectorPlanVigilancia($conexion,$arrayParametros){
       
        $res = $conexion->ejecutarConsulta("SELECT STRING_AGG(r.ic_requerimiento_id::text,',') AS codigo,l.nombre as nombreProvincia, (fp.nombre || ' ' || fp.apellido) AS nombrePlanificador,fp.mail_personal, fp.mail_institucional , (fi.nombre || ' ' || fi.apellido) AS nombreInspector,
                                                    count(r.ic_requerimiento_id) as contador, r.numero_muestras
                                            FROM g_inocuidad.ic_requerimiento r
                                            INNER JOIN  g_catalogos.localizacion l on l.id_localizacion = r.provincia_id
                                            INNER JOIN g_uath.ficha_empleado fp on fp.identificador = r.usuario_id
                                            INNER JOIN g_uath.ficha_empleado fi on fi.identificador = r.inspector_id
                                            WHERE r.usuario_id = '".$arrayParametros['usuario_id']."'AND r.inspector_id = '".$arrayParametros['inspector_id']."' AND r.ic_producto_id = ".$arrayParametros['ic_producto_id']." 
                                                AND r.provincia_id = ".$arrayParametros['provincia_id']." AND r.numero_muestras = ".$arrayParametros['numero_muestras']." 
                                                AND r.id_grupo = ".$arrayParametros['id_grupo']." AND estado_registro = 'porAprobar'
                                            GROUP BY fp.nombre, fp.apellido, l.nombre,fp.mail_personal, fp.mail_institucional, r.numero_muestras,fi.nombre , fi.apellido;");
        return $res ;

    }
    
    public function buscarDatosDestinatario($conexion,$arrayParametros){
       
        $res = $conexion->ejecutarConsulta("SELECT (f.nombre || ' ' || f.apellido) AS nombrePlanificador,f.mail_personal, f.mail_institucional ,
                                                    (f.nombre || ' ' || f.apellido) AS nombreInspector
                                            FROM g_uath.ficha_empleado f
                                            WHERE identificador = '$arrayParametros' AND estado_empleado = 'activo';");
        return $res ;

    }

    public function buscarDatosInspectorPlanVigilanciaPlanificador($conexion,$arrayParametros){
        
       

        $res = $conexion->ejecutarConsulta("SELECT dc.provincia, (fp.nombre || ' ' || fp.apellido) AS nombreInspector,fp.mail_personal, fp.mail_institucional , (fi.nombre || ' ' || fi.apellido) AS nombrePlanificador    
                                            FROM g_inocuidad.ic_requerimiento r
                                            INNER JOIN  g_uath.datos_contrato dc on dc.identificador = r.inspector_id
                                            INNER JOIN g_uath.ficha_empleado fp on fp.identificador = r.inspector_id  
                                            INNER JOIN g_uath.ficha_empleado fi on fi.identificador = r.usuario_id 
                                            WHERE r.usuario_id = '".$arrayParametros['usuario_id']."' AND r.inspector_id = '".$arrayParametros['inspector_id']."'                                              
                                            GROUP BY fp.nombre, fp.apellido,dc.provincia,fp.mail_personal, fp.mail_institucional, r.numero_muestras,fi.nombre , fi.apellido limit 1
                                            ");
        return $res ;

    }

    public function obtenerIdCasoCreado($conexion,$arrayParametros){
        
        $res = $conexion->ejecutarConsulta("SELECT max (ic_requerimiento_id) as ic_requerimiento_id
                                            FROM g_inocuidad.ic_requerimiento
                                            where programa_id = ".$arrayParametros['programa_id']." and ic_producto_id = ".$arrayParametros['ic_producto_id']." and provincia_id = ".$arrayParametros['provincia_id']."
                                            and inspector_id = '".$arrayParametros['inspector_id']."' and ic_tipo_requerimiento_id = ".$arrayParametros['ic_tipo_requerimiento_id']."
                                            and numero_muestras = ".$arrayParametros['numero_muestras']." and usuario_id = '".$arrayParametros['usuario_id']."'");
        return $res ;

    }

    public function buscarDatosPlanificadorPlanVigilancia($conexion,$arrayParametros){

        if(isset($arrayParametros['respuesta']) && ($arrayParametros['respuesta'] == 'rechazar')){
            $condicion = 'rechazadoPlanificador';
        }else{
            $condicion = 'aprobadoPlanificador';
        }

        $res = $conexion->ejecutarConsulta("SELECT STRING_AGG(r.ic_requerimiento_id::text,',') AS codigo,l.nombre as nombreProvincia, (fp.nombre || ' ' || fp.apellido) AS nombreInspector,fp.mail_personal, fp.mail_institucional , (fi.nombre || ' ' || fi.apellido) AS nombrePlanificador,
                                                    count(r.ic_requerimiento_id) as contador, r.numero_muestras
                                            FROM g_inocuidad.ic_requerimiento r
                                            INNER JOIN  g_catalogos.localizacion l on l.id_localizacion = r.provincia_id
                                            INNER JOIN g_uath.ficha_empleado fp on fp.identificador = r.inspector_id
                                            INNER JOIN g_uath.ficha_empleado fi on fi.identificador = r.usuario_id
                                            WHERE r.inspector_id = '".$arrayParametros['inspector_id']."'AND r.usuario_id = '".$arrayParametros['usuario_id']."' AND r.ic_producto_id = ".$arrayParametros['ic_producto_id']." 
                                                AND r.provincia_id = ".$arrayParametros['provincia_id']." AND r.numero_muestras = ".$arrayParametros['numero_muestras']." 
                                                AND r.id_grupo = ".$arrayParametros['id_grupo']." AND estado_registro = '".$condicion."'
                                            GROUP BY fp.nombre, fp.apellido, l.nombre,fp.mail_personal, fp.mail_institucional, r.numero_muestras,fi.nombre , fi.apellido;");
        return $res ;

    }
    
    public function actualizarEstadoMailRequerimientoInspector($conexion,$parametros){

        $res = $conexion->ejecutarConsulta("UPDATE g_inocuidad.ic_requerimiento 
                                            SET mail_planificador = 'mailEnviadoAprobado'
                                            WHERE ic_requerimiento_id = $parametros;");

        
        return $res ;

    }

    public function actualizarEstadoMailRequerimientoPlanificador($conexion,$parametros,$observacion){


        $res = $conexion->ejecutarConsulta("UPDATE g_inocuidad.ic_requerimiento 
                                            SET mail_planificador = 'mailEnviadoRechazadoPlanificador', observacion ='".$observacion."'
                                            WHERE ic_requerimiento_id = $parametros;");
                                           
        return $res ;

    }

}