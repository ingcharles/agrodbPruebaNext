<?php
/**
 * Created by PhpStorm.
 * User: advance
 * Date: 2/1/18
 * Time: 11:46 PM
 */

require_once '../servicios/ServiceCasoDAO.php';
require_once '../servicios/ServiceMuestraDAO.php';
require_once '../Modelo/Caso.php';
require_once '../controladores/ControladorCatalogosInc.php';
require_once '../../../clases/Conexion.php';


class ControladorRequerimiento
{
    private $conexion;
    private $servicios;
    private $servicioMuestra;
    /**
     * ControladorRequerimiento constructor.
     * @param $conexion
     */
    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->servicios = new ServiceCasoDAO();
        $this->servicioMuestra=new ServiceMuestraDAO();
    }
    public function saveAndUpdateCaso(Caso $caso,$numero_casos,$requerimientoId){
        $resultado=null;
        try{
            if($requerimientoId !=''){
                $casoObtenido=$this->servicios->getCasoIngresado($requerimientoId,$this->conexion);
            }else{
                $casoObtenido=null;
            }
           

            $resultado=$this->servicios->saveAndUpdateCaso($caso,$this->conexion,$numero_casos,$casoObtenido);

            if ($resultado === false) {
                $resultado = pg_last_error($this->conexion);
            } else {
                $resultado = null;
            }

        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function listarRequerimientos(){
        $resultado=null;
        try{
            $resultado=$this->servicios->getAllCasos($this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function listarRequerimientosInStep($usuario){
        $resultado=null;

        $resPerfil = pg_fetch_assoc($this->servicios->obtenerPerfilUsuarioCaso($this->conexion,$usuario));
            
        if (is_array($resPerfil)) {
            $banderaPerfil = true;
            
        } else {
            $banderaPerfil = false;
            
        }
        try{
            $resultado=$this->servicios->getAllCasosInStep($usuario,$this->conexion,$banderaPerfil);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function recuperarRequerimiento($id){
        $resultado=null;
        try{
            $resultado=$this->servicios->getCasoById($id,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function PerfilUsuario($identificador){
        $resultado=null;
        try{
            $resultado=$this->servicios->obtenerPerfilUsuarioCaso($this->conexion,$identificador);
                  
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function obtenerTipoRequerimiento($programa_id){
        $resultado=null;
        try{
            $resultado=$this->servicios->obtenerRequerimiento($this->conexion,$programa_id);
                  
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function obtenerTipoCaso($identificador){
        $resultado=null;
        try{
            $resultado=$this->servicios->obtenerPerfilUsuarioCaso($this->conexion,$identificador);
                  
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    /*
     * Construye los articulos visibles para el paso Caso del usuario logeado.
     * */
    public function listArticles($usuario){
        $resultado=null;
        try{
            $requerimientos=$this->listarRequerimientosInStep($usuario);
           
            $catalogos=new ControladorCatalogosInc();
            $resultado="";
            $ic_tipo_requerimiento_id=0;
            $provincia_id=0;
            $changed = false;
            /* @var $caso Caso */

           $perfil = $requerimientos[0];
           $contador = 0;
            $Producto="";
            foreach ($requerimientos as $caso){
                
                if($contador != 0){
                    if($ic_tipo_requerimiento_id!=$caso->getTipoRequerimientoId()){
                        if($ic_tipo_requerimiento_id!=0){
                            $resultado.="</div>";
                        }
                        $ic_tipo_requerimiento_id=$caso->getTipoRequerimientoId();
                        $nombre_tipo_requerimiento = $caso->getTipoRequerimiento();
                        $resultado.= "<div id='requerimiento-container'>";
                        $resultado.= "<h2>$nombre_tipo_requerimiento</h2>";
                    }
                    if($provincia_id!=$caso->getProvinciaId()){
                        if($provincia_id=!0){
                            $resultado.="</div>";
                        }
                        $provincia_id=$caso->getProvinciaId();
                        $nombre_provincia = $catalogos->obtenerNombreProvincia($provincia_id);
                        $resultado.= "<div id='provincia-container'>";
                        $resultado.= "<h3>$nombre_provincia</h3>";
                    }
                    $ic_req_id = $caso->getId();
                    $producto_id=$caso->getNombreProducto();
                    $esta_registro=$caso->getEstadoRegistro();

                    $cadena_de_texto = $esta_registro;
                    $cadena_buscada   = 'porAprobar';
                    $posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);

                    if (strpos($esta_registro, 'porAprobar') !== false) {
                        $color= "#ff8000";
                        $texto= ($perfil==true ? "Aprobar" : "Esperando aprobación");
                    }else if($esta_registro == 'casoCreado'){
                        $color= "#00ff00";
                        $texto= ($perfil==true ? "Enviado a usuario" : "Generar Casos");
                    }else if(strpos($esta_registro, 'casoGenerado') !== false){
                        $color= "#ffff33";
                        $texto= ($perfil==true ? "Enviado a usuario" : "Envia a aprobar");
                    }else if($esta_registro == 'denunciaCreado' || $esta_registro == 'notificacionCreado'){
                        $color= "#ffff33";
                        $texto= ($perfil==true ? "Aprobar" : "Envia a muestra");
                    }else if (strpos($esta_registro, 'rechazadoPlanificador') !== false){
                        $color= "#FF0000";
                        $texto= ($perfil==true ? "Enviado subsanar" : "Rechazo Planificador");
                    }else if (strpos($esta_registro, 'aprobadoPlanificador') !== false){
                        $color= "#ffffff";
                        $texto= ($perfil==true ? "Enviado subsanar" : "Rechazo Planificador");
                    }
                    //en este if agrupamos los casos en el caso de ser inspector
                    if ($perfil == false){
                        if($Producto==''){
                            $resultado.= "<div>";
                        }else if ($Producto!='' && $Producto != $producto_id){
                            $resultado.= "</div>"; 
                        }
                        if ($Producto != $producto_id){
                            $resultado.= "<div>"; 
                        }
                     }
                
                    $resultado.= " <article title='". $texto ."'
                                    id='$ic_req_id'
                                    class='item'
                                    data-rutaAplicacion='inocuidad'
                                    data-opcion='./vistas/icCasosEditar' 
                                    ondragstart='drag(event)' 
                                    draggable='true' 
                                    data-destino='detalleItem'>
                                        <span class='ordinal'>$ic_req_id</span>
                                        <span>$producto_id</span>
                                        <aside style='text-align: right'><small>$nombre_tipo_requerimiento
                                        </small></aside>
                                    
                                        <svg version='1.1' xmlns='http://www.w3.org/2000/svg'
                                        width='16' height='16' viewBox='0 0 120 120' style='float: right; '>
                                    <circle cx='60' cy='60' r='50'
                                            
                                            fill='" . $color . "' />
                                    </svg>
                                        </article>";
                    $Producto = $producto_id;
                } 
                $contador = $contador + 1;   
            }
            $resultado.="</div>";   
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }
    

    /*
     * Construye el resumen del caso para la vitacora
     * */
    public function getCasoRO($idRequerimiento){
        $caso=$this->servicios->getCasoRO($idRequerimiento,$this->conexion);
        $header="<fieldset class='fieldset-header'> <legend>Caso</legend> <table class='table-header'>";
        if($caso!=null){
            $header.="<tr><td><label class='header-titulo'>Número de Caso</label></td><td><label class='header-contenido'>".$caso['ic_requerimiento_id']."</label></td></tr>";
            $header.="<tr><td><label class='header-titulo'>Tipo de Requerimiento</label></td><td><label class='header-contenido'>".$caso['tipo_requerimiento']."</label></td></tr>";
            $header.="<tr><td><label class='header-titulo'>Producto</label></td><td><label class='header-contenido'>".$caso['producto']."</label></td></tr>";
            $header.="<tr><td><label class='header-titulo'>Número de Muestras (Incluido Contramuestras)</label></td><td><label class='header-contenido'>".$caso['numero_muestras']."</label></td></tr>";
            $header.="<tr><td><label class='header-titulo'>Fecha Requerimiento</label></td><td><label class='header-contenido'>".$this->formatoFecha($caso['fecha_solicitud'])."</label></td></tr>";
            $header.="<tr><td><label class='header-titulo'>Inspector</label></td><td><label class='header-contenido'>".$caso['inspector']."</label></td></tr>";
            if($caso['cancelado']=='S'){
                $header .= "<tr class='resumen-subtitulo'><td colspan='2' style='text-align: center;'><label class='resumen-subtitulo-label' style='color: darkred'>*** CANCELADO ***</label></td></tr>";
                $header.="<tr><td><label class='header-titulo'>Detalle</label></td><td><label class='header-contenido' style='color: darkred'>".$caso['motivo_cancelacion']."</label></td></tr>";
                $header.="<tr><td><label>Documento cancelaciòn: </label> <a href='".$caso['ruta_archivo']."' target='_blank' class='archivo_cargado'>Ver documento</a> </td></tr>";
            }
            if($caso['ic_tipo_requerimiento_id']==1){//Plan de vigilancia
                $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Plan de Vigilancia</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Programa</label></td><td><label class='resumen-contenido'>".$caso['programa']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Fecha Estimada de Inspección</label></td><td><label class='resumen-contenido'>".$caso['fecha_inspeccion_mes']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Provincia</label></td><td><label class='resumen-contenido'>".$caso['provincia']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Observación</label></td><td><label class='resumen-contenido'>".$caso['observacion']."</label></td></tr>";
            }else if($caso['ic_tipo_requerimiento_id']==2) {//Denuncia
                $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Denuncia</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Fecha Denuncia</label></td><td><label class='resumen-contenido'>".$this->formatoFecha($caso['fecha_denuncia'])."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Fuente</label></td><td><label class='resumen-contenido'>".$caso['fuente_denuncia']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Nombre Denunciante</label></td><td><label class='resumen-contenido'>".$caso['nombre_denunciante']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Datos Denunciante</label></td><td><label class='resumen-contenido'>".$caso['datos_denunciante']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Provincia</label></td><td><label class='resumen-contenido'>".$caso['provincia']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Observación</label></td><td><label class='resumen-contenido'>".$caso['observacion']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Descripción Denuncia</label></td><td><label class='resumen-contenido'>".$caso['descripcion_denuncia']."</label></td></tr>";
            }else if($caso['ic_tipo_requerimiento_id']==3) {//Notificacion Exterior
                $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Notificación Exterior</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Fecha Notificacion</label></td><td><label class='resumen-contenido'>".$this->formatoFecha($caso['fecha_notificacion'])."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>País Notificación</label></td><td><label class='resumen-contenido'>".$caso['pais_notificacion']."</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Observación</label></td><td><label class='resumen-contenido'>".$caso['observacion']."</label></td></tr>";
            }
            $header.="</table> </fieldset>";
        }

        return $header;
    }

    private function formatoFecha($fecha){
        $date = new DateTime($fecha);
        return $date->format('d/m/Y');
    }

    /*
     * Crea la muestra a partir del requerimiento realizado
     * */
    public function creaMuestra($idRequerimiento,$perfil,$arrayParametros){
        $resultado=null;
        try{
            if($perfil == 1 || ($arrayParametros['tipo_requerimiento_id'] == 'DN' || $arrayParametros['tipo_requerimiento_id'] == 'NE')){
                $caso = $this->servicios->getCasoById($idRequerimiento,$this->conexion);
                $ic_producto_id = $caso->getProductoId();
                $resultado=$this->servicioMuestra->creaMuestraCaso($idRequerimiento,$this->conexion, $ic_producto_id, $caso->getProvinciaId(),$arrayParametros);
                //Auditoria
                $auditoria = new ControladorAuditoria();
                $auditoria->incrementarNumeroNotificacion($caso->getInspectorId());
            }else{
                $resultado=$this->servicioMuestra->actualizarEstadoRequerimientoInspector($this->conexion,$idRequerimiento); 
            }
           

        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;

    }

    public function listarRequerimientosPorParametros($parametros){
       
        $resultado=null;
        try{
            $resultado=$this->servicios->getAllCasosPorParametros($this->conexion,$parametros);

        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }
    

    public function eliminarRequerimientosPorParametros($parametros){
       
        $resultado=null;
        try{
            $resultado=$this->servicios->deleteAllCaso($this->conexion,$parametros);

        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    
}




