<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 17/02/18
 * Time: 23:40
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../Modelo/Muestra.php';
require_once '../servicios/ServiceMuestraDAO.php';
require_once '../servicios/ServiceLaboratorioDAO.php';
require_once '../controladores/ControladorCatalogosInc.php';
require_once '../Modelo/Caso.php';
require_once '../../../clases/Conexion.php';
require_once '../Modelo/MuestraRapidaValor.php';
require_once '../controladores/ControladorLaboratorio.php';

require_once '../controladores/ControladorRequerimiento.php';


class ControladorMuestra
{
    private $conexion;
    private $servicios;
    private $servicioLaboratorio;
    private $controladorLaboratorio;

    private $controladorRequerimiento;

    public function __construct($conexion)
    {
        $this->conexion = $conexion==null ? new Conexion() : $conexion;
        $this->servicios = new ServiceMuestraDAO();
        $this->servicioLaboratorio = new ServiceLaboratorioDAO();
        $this->controladorLaboratorio = new ControladorLaboratorio();

        $this->controladorRequerimiento = new ControladorRequerimiento();
    }

    public function getAllMuestras($conexion){}

    public function getAllMuestrasExistentes($conexion){}

    public function getMuestra($ic_muestra_id){
        $resultado=null;
        try{
            $resultado=$this->servicios->getMuestraById($ic_muestra_id,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }
    public function getMuestraXIdRequerimiento($ic_requerimiento_id){
        $resultado=null;
        try{
            $resultado=$this->servicios->getMuestraByIdRequerimeinto($ic_requerimiento_id,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function saveAndUpdateMuestra(Muestra $muestra,$conexion){
        $resultado=null;
        try{
            $resultado=$this->servicios->saveAndUpdateMuestra($muestra,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    /*
     * Construye los articulos visibles para el paso Muestra del usuario logeado.
     * */
    public function listArticles($usuario){
        $resultado=null;
        try{
            $controladorCatalogo = new ControladorCatalogosInc();
            $muestras=$this->servicios->getAllMuestrasInStep($usuario, $this->conexion);
           
            $resultado="";
            $ic_tipo_requerimiento_id=0;
            $provincia_id=0;
            $changed = false;
           
            /* @var $muestra Muestra */
            foreach ($muestras as $muestra){
                if($ic_tipo_requerimiento_id!=$muestra->getIcTipoRequerimientoId()){
                    if($ic_tipo_requerimiento_id!=0){
                        $resultado.="</div>";
                    }
                    $ic_tipo_requerimiento_id=$muestra->getIcTipoRequerimientoId();
                    $nombre_tipo_requerimiento = $controladorCatalogo->obtenerNombreTipoRequerimiento($ic_tipo_requerimiento_id);
                    $resultado.= "<div id='muestras-container'>";
                    $resultado.= "<h2>$nombre_tipo_requerimiento</h2>";
                }
                if($muestra->getProvinciaId()!=null && $provincia_id!=$muestra->getProvinciaId()){
                    if($provincia_id=!0){
                        $resultado.="</div>";
                    }
                    $provincia_id=$muestra->getProvinciaId();
                    $nombre_provincia = $controladorCatalogo->obtenerNombreProvincia($provincia_id);
                    $resultado.= "<div id='provincia-container'>";
                    $resultado.= "<h3>$nombre_provincia</h3>";
                }

               
                $ic_muestra_id = $muestra->getIcmuestraId();
                
                if($muestra->getFechaCreacionRegistro() != ''){
                    $array = explode("-", $muestra->getFechaCreacionRegistro());
                    $fechaCreacion = ($array[2]."/".$array[1]."/".$array[0]);
                }else{
                    $fechaCreacion = "---_--_--";
                }
               
                $nombre = "Caso N° ".$muestra->getIcRequerimientoId()."<br><br><div style='width:100%;text-align: center'>".$fechaCreacion."</div>"; 
                $descripcion = $muestra->getTipoEmpresa()=="NC" ? "Nacional":($muestra->getTipoEmpresa()=="IM" ? "Importacion":$muestra->getProducto());
                $color = $muestra->getTipoEmpresa()=="NC" || $muestra->getTipoEmpresa()=="IM" ? "#7acff;" : "#D46A6A;";
                $resultado.= "<article 
                                id='$ic_muestra_id'
                                style='background-color:$color'
                                class='item'
                                data-rutaAplicacion='inocuidad'
                                data-opcion='./vistas/icMuestraEditar' 
                                ondragstart='drag(event)' 
                                draggable='true' 
                                data-destino='detalleItem'>
                                    <span class='ordinal'>$ic_muestra_id</span>
                                    <span>$nombre</span>
                                    <aside><small>$descripcion</small></aside>
                                </article>";
            }
            $resultado.="</div>";
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function actualizaContramuestra($idMuestra,$cantidadContraMuestra){
        $resultado=null;
        try{
            $resultado = $this->servicios->updateContraMuestra($idMuestra,$cantidadContraMuestra, $this->conexion);
        }catch (Exception $e){
            $resultado=$e->getMessage();
        }

        return $resultado;
    }

    public function creaLaboratorio($idMuestra,$cantidadContraMuestra){
        $resultado=null;
        try{
            $muestra = $this->getMuestra($idMuestra);
            $resultado=$this->servicioLaboratorio->creaLaboratorioMuestra($muestra,$cantidadContraMuestra,$this->conexion);
            //Auditoria
            $auditoria = new ControladorAuditoria();
            $auditoria->incrementarNumeroNotificacion($muestra->getTecnicoId());
            $controladorCaso = new ControladorRequerimiento();
            $caso = $controladorCaso->recuperarRequerimiento($muestra->getIcRequerimientoId());
            $auditoria->reducirNumeroNotificacion($caso->getInspectorId());
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function saveAndUpdateMuestraRapidaValor(MuestraRapidaValor $registroValor){
        $resultado=null;
        try{
            $resultado=$this->servicios->saveAndUpdateMuestraRapidaValor($registroValor,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function getRegistroMuestraRapidaValores($ic_muestra_id){
        $resultado=null;
        try{
            $resultado=$this->servicios->getAllMuestraRapidaValorByMuestra($ic_muestra_id,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function listMuestraRapidaValores($ic_muestra_id){
        $resultado=null;
        try{
            $controladorCatalogo = new ControladorCatalogosInc();
            $registros=$this->servicios->getAllMuestraRapidaValorByMuestra($ic_muestra_id,$this->conexion);
            $resultado="";
            /* @var $registro MuestraRapidaValor */
            $identificador=($_SESSION['usuario']);
            $resPerfil = $this->controladorRequerimiento->PerfilUsuario($identificador);
            if (pg_num_rows($resPerfil) > 0) {
               $bloquearInputs = "disabled";
            } else {
                $bloquearInputs="";          
            }
            foreach ($registros as $registro){
                $ic_muestra_rapida_id   = $registro->getIcMuestraRapidaId();
                $valor                  = $registro->getValor();
                $observaciones          = $registro->getObservaciones();

                $insumo = $controladorCatalogo->obtenerInsumoById($registro->getIcInsumoId());
                $uidadm = $controladorCatalogo->obtenerUnidadMedidadById($registro->getUm());


                $resultado.="<tr id='$ic_muestra_rapida_id'>";
                $resultado.="   <td>$insumo</td>";
                $resultado.="   <td>$uidadm</td>";
                $resultado.="   <td><input style='width: 95%' value=\"$valor\" type=\"text\" id=\"valor_$ic_muestra_rapida_id\" name=\"valor_$ic_muestra_rapida_id\" class=\"decimal\" data-required ".$bloquearInputs."/></td>";
                $resultado.="   <td><textarea id=\"obs_$ic_muestra_rapida_id\" name=\"obs_$ic_muestra_rapida_id\" cols=\"5\" rows=\"3\" data-required  ".$bloquearInputs.">$observaciones</textarea></td>";
                $resultado.="</tr>";
            }
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function getMuestraRO($idMuestra){
        $muestra=$this->servicios->getMuestraRO($idMuestra,$this->conexion);
        $header="<fieldset class='fieldset-resumen'> <table class='table-resumen'>";
        $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Muestra</label></td></tr>";
        if($muestra!=null){
            $header.="<tr><td><label class='resumen-titulo'>Fecha de Muestras</label></td><td><label class='resumen-contenido'>".$this->formatoFecha($muestra['fecha_muestreo'])."</label></td></tr>";
            $header.="<tr><td><label class='resumen-titulo'>Código Muestras</label></td><td><label class='resumen-contenido'>".$muestra['codigo_muestras']."</label></td></tr>";
            $header.="<tr><td><label class='resumen-titulo'>Provincia</label></td><td><label class='resumen-contenido'>".$muestra['provincia']."</label></td></tr>";
            $header.="<tr><td><label class='resumen-titulo'>Tipo de Producto</label></td><td><label class='resumen-contenido'>".$muestra['empresa']."</label></td></tr>";
            $header.="<tr><td><label class='resumen-titulo'>Técnico Responsable</label></td><td><label class='resumen-contenido'>". $muestra['tecnico_responsable'] ."</label></td></tr>";
            if($muestra['tipo_empresa']=="IM") {//Importacion
                $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Importación</label></td></tr>";
                $header .= "<tr><td><label class='resumen-titulo'>Número Permiso Fitosanitario</label></td><td><label class='resumen-contenido'>" . $muestra['permiso_fitosanitario'] . "</label></td></tr>";
                $header .= "<tr><td><label class='resumen-titulo'>Nombre Rep. Legal</label></td><td><label class='resumen-contenido'>" . $muestra['nombre_rep_legal'] . "</label></td></tr>";
                $header .= "<tr><td><label class='resumen-titulo'>Razón Social de Importador</label></td><td><label class='resumen-contenido'>" . $muestra['razon_social_importador'] . "</label></td></tr>";
                $header .= "<tr><td><label class='resumen-titulo'>Pais de Origen</label></td><td><label class='resumen-contenido'>" . $muestra['pais_origen'] . "</label></td></tr>";
                
            }else{
                $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Nacional</label></td></tr>";
                $header .= "<tr><td><label class='resumen-titulo'>Nombre Rep. Legal</label></td><td><label class='resumen-contenido'>" . $muestra['nombre_rep_legal'] . "</label></td></tr>";
                $header.="<tr><td><label class='resumen-titulo'>Origen Muestra</label></td><td><label class='resumen-contenido'>".$muestra['origen_muestra']."</label></td></tr>";
                $header .= "<tr><td><label class='resumen-titulo'>Nombre Establecimiento</label></td><td><label class='resumen-contenido'>" . $muestra['nombre_establecimiento'] . "</label></td></tr>";
                $header .= "<tr><td><label class='resumen-titulo'>Certificado Sanitario De Origen y Movilización</label></td><td><label class='resumen-contenido'>" . $muestra['certificacion_sanitaria'] . "</label></td></tr>";
                $header .= "<tr><td><label class='resumen-titulo'>Certificado Zoosanitario de producción y movilidad</label></td><td><label class='resumen-contenido'>" . $muestra['certificacion_zoosanitario'] . "</label></td></tr>";
            }

            $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Datos Muestra</label></td></tr>";
            $header.="<tr><td><label class='resumen-titulo'>Fecha Envío</label></td><td><label class='resumen-contenido'>".$this->formatoFecha($muestra['fecha_envio_lab'])."</label></td></tr>";
            $header.="<tr><td><label class='resumen-titulo'>Cantidad Muestras</label></td><td><label class='resumen-contenido'>".$muestra['cantidad_muestras_lab']."</label></td></tr>";
            $header.="<tr><td><label class='resumen-titulo'>Cantidad Contra Muestra</label></td><td><label class='resumen-contenido'>".$muestra['cantidad_contra_muestra']."</label></td></tr>";
            $header.="<tr><td><label class='resumen-titulo'>Observaciones</label></td><td><label class='resumen-contenido'>".$muestra['observaciones']."</label></td></tr>";

            $muestraValor=$this->servicios->getResultadoMuestraRapidaDatos($idMuestra,$this->conexion);
           
        }
        $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Detalle de Muestra</label></td></tr>";
        $header.='<table id="registroValores" border=1 style="width:100%;border-color: #afafaf;display: table"  class="tablaMatriz">';
        $header.='<thead>';
        $header.='<tr>';
        $header.=' <th style="width:25%" >Código de la muestra Laboratorio</th>';
        $header.=' <th style="width:15%" >Identificación de Campo de la Muestra</th>';
        $header.=' <th style="width:15%" >Analito detectado</th>';
        $header.='<th style="width:45%" >Residuos encontrados (ug/kg)</th>';
        $header.='<th style="width:45%" >Método</th>';
        $header.='<th style="width:45%" >LMR**(ug/kg)</th>';
        $header.='</tr>';
        $header.='</thead>';
        $header.='<tbody> '.$this->controladorLaboratorio->listRegistroValoresDetalleMuestra($idMuestra).'</tbody>';
        $header.='</table>';


        $header.="</table> </fieldset>";
        return $header;
    }

    public function tablaDetalleMuestra(){

    }

    private function formatoFecha($fecha){
       
            $date = new DateTime($fecha);
       
        return $date->format('d/m/Y');
    }

}