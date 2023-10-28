<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 20/02/18
 * Time: 23:31
 */

require_once "../Modelo/Laboratorio.php";
require_once "../Modelo/RegistroValor.php";
require_once "../servicios/ServiceLaboratorioDAO.php";

require_once '../controladores/ControladorRequerimiento.php';

class ControladorLaboratorio
{
    private $conexion;
    private $servicios;
    private $servicioAnalisis;

    private $controladorRequerimiento;

    public function __construct()
    {
        $this->conexion =  new Conexion();
        $this->servicios = new ServiceLaboratorioDAO();
        $this->controladorRequerimiento = new ControladorRequerimiento();
    }

    public function getLaboratorio($ic_analisis_laboratorio_id){
        $resultado=null;
        try{
            $resultado=$this->servicios->getLaboratorioById($ic_analisis_laboratorio_id,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    /*Establece el registro de laboratorio con estado desactivado(Cuando el registro pasa análsis)*/
    public function desactivarLaboratorio($icAnalisisMuestraId){
        $resultado=null;
        try{
            $resultado=$this->servicios->desactivarLaboratorio($icAnalisisMuestraId,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function saveAndUpdateLaboratorio(Laboratorio $laboratorio,$rechazo){
        $resultado=null;
        try{
            $resultado=$this->servicios->saveAndUpdateLaboratorio($laboratorio,$rechazo,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }
    public function saveAndUpdateDetalleMuestra($arrryDetalleMuestraId, $arrayCodigoMuestraLaboratorio, $arrayCodigoMuestra, $arrayAnalito, $arrayResiduos, $arrayMetodo, $arrayLmr, $ic_muestra_id){
        $resultado=null;
        try{
            $resultado=$this->servicios->saveAndUpdateDetalleMuestra($arrryDetalleMuestraId, $arrayCodigoMuestraLaboratorio, $arrayCodigoMuestra, $arrayAnalito, $arrayResiduos, $arrayMetodo, $arrayLmr, $ic_muestra_id, $this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function saveAndUpdateRegistroValor(RegistroValor $registroValor){
        $resultado=null;
        try{
            $resultado=$this->servicios->saveAndUpdateRegistroValor($registroValor,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function getRegistroValores($ic_analisis_muestra_id){
        $resultado=null;
        try{
            $resultado=$this->servicios->getAllRegistroValorByLaboratorio($ic_analisis_muestra_id,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    /*
     * Construye la tabla de registro valores mostrada en laboratorio
     * */
    public function listRegistroValores($ic_muestra_id){
        $identificador=($_SESSION['usuario']);
        $resPerfil = $this->controladorRequerimiento->PerfilUsuario($identificador);
        if (pg_num_rows($resPerfil) > 0) {
           
           $bloquearInputs = "disabled";
        } else {
            $bloquearInputs="";          
        }
        $resultado=null;
        try{
            $registros="";
            $registros=$this->servicios->getAllRegistroValorByDetalleMuestra($ic_muestra_id,$this->conexion);
            $contador = pg_num_rows($registros);
            if (pg_num_rows($registros) == 0){
                $registros=$this->servicios->getAllRegistroValorByMuestra($ic_muestra_id,$this->conexion);
            }
            
            $resultado="";
           $contador = 0;
            while ($fila = pg_fetch_assoc($registros)) {
                $ic_detalle_muestra_id= isset($fila['ic_detalle_muestra_id']) ? $fila['ic_detalle_muestra_id'] : '' ;
                $nombreAnalito = $fila['analito'];
                $codigo_muestras = $fila['identificacion_campo_muestra'];
                $descripcion = $fila['metodo'];
                $parametronombre = $fila['lmr'];

                $codigoMuestra = isset($fila['codigo_muestra']) ? $fila['codigo_muestra'] : '' ;
                $residuo = isset($fila['residuo']) ? $fila['residuo'] : '' ;
                
                $resultado.="<tr id='$ic_detalle_muestra_id'><input type='hidden' id='ic_detalle_muestra_id' name='ic_detalle_muestra_id[".$contador."]' value=".$ic_detalle_muestra_id.">";
                $resultado.="   <td><input type='text' id='cod_muestra_lab' name='cod_muestra_lab[".$contador."]' class='valorInputMuestra' value='".$codigoMuestra."'".$bloquearInputs."></td>";
                $resultado.="   <td>$codigo_muestras<input type='hidden' id='cod_muestra_lab' name='cod_muestra[".$contador."]' value='".$codigo_muestras."'></td>";
                $resultado.="   <td>$nombreAnalito <input type='hidden' id='analito' name='analito[".$contador."]' value='".$nombreAnalito."'></td>";
                $resultado.="   <td><input type='text' id='residuo' name='residuos[".$contador."]' class='valorInputResiduo' value='".$residuo."'".$bloquearInputs."></td>";
                $resultado.="   <td>".$descripcion." <input type='hidden' id='metodo' name='metodo[".$contador."]' value='".$descripcion."'".$bloquearInputs."></td>";
                $resultado.="   <td>$parametronombre <input type='hidden' id='lmr' name='lmr[".$contador."]' value='".$parametronombre."'".$bloquearInputs."></td>";
                $resultado.="</tr>";
                $contador ++;
            }
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function listRegistroValoresDetalleMuestra($ic_muestra_id){
        $resultado=null;
        try{
            $registros="";
            $registros=$this->servicios->getAllRegistroValorByDetalleMuestra($ic_muestra_id,$this->conexion);
                       
            $resultado="";
            $contador = 0;
            while ($fila = pg_fetch_assoc($registros)) {
                $ic_detalle_muestra_id= isset($fila['ic_detalle_muestra_id']) ? $fila['ic_detalle_muestra_id'] : '' ;
                



                $codigoMuestra = isset($fila['codigo_muestra']) ? $fila['codigo_muestra'] : '' ;
                $codigo_muestras = $fila['identificacion_campo_muestra'];
                $nombreAnalito = $fila['analito'];
                $residuo = htmlspecialchars(isset($fila['residuo']) ? $fila['residuo'] : '');
                $descripcion = $fila['metodo'];
                $parametronombre = $fila['lmr'];




                
                $resultado.="<tr id='$ic_detalle_muestra_id'><input type='hidden' id='ic_detalle_muestra_id' name='ic_detalle_muestra_id[".$contador."]' value=".$ic_detalle_muestra_id.">";
                $resultado.="   <td>$codigoMuestra</td>";
                $resultado.="   <td>$codigo_muestras</td>";
                $resultado.="   <td>$nombreAnalito</td>";
                $resultado.="   <td>$residuo</td>";
                $resultado.="   <td>$descripcion</td>";
                $resultado.="   <td>$parametronombre</td>";
                $resultado.="</tr>";
                $contador ++;
            }
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function reemplazarEspacios($texto_original){
        $texto_modificado = str_replace(" ", "_", $texto_original);
        return $texto_modificado;
    }

    /*
     * Construye los articulos visibles para el paso Laboratorio del usuario logeado.
     * */
    public function listArticles(){
        $resultado=null;
        try{
            $controladorCatalogo = new ControladorCatalogosInc();
            $laboratorios=$this->servicios->getAllLaboratorioInStep($this->conexion);
            $resultado="";
            $ic_tipo_requerimiento_id=0;
            $nombre_producto="";
            $changed = false;
            /* @var $laboratorio Laboratorio */
            foreach ($laboratorios as $laboratorio){
                if($ic_tipo_requerimiento_id!=$laboratorio->getIcTipoRequerimientoId()){
                    if($ic_tipo_requerimiento_id!=0){
                        $resultado.="</div>";
                    }
                    $ic_tipo_requerimiento_id=$laboratorio->getIcTipoRequerimientoId();
                    $nombre_tipo_requerimiento = $controladorCatalogo->obtenerNombreTipoRequerimiento($ic_tipo_requerimiento_id);
                    $resultado.= "<div id='laboratorio-container'>";
                    $resultado.= "<h2>$nombre_tipo_requerimiento</h2>";
                }
                $nombre_producto = $controladorCatalogo->obtenerNombreIcProducto($laboratorio->getIcProductoId());
                $ic_analisis_muestra_id = $laboratorio->getIcAnalisisMuestraId();
                $nombre = "Caso N° ".$laboratorio->getIcRequerimientoId();
                $color = $laboratorio->getObservaciones()!=null ? "#7acff;" : "#D46A6A;";
                $resultado.= "<article 
                                id='$ic_analisis_muestra_id'
                                style='background-color:$color'
                                class='item'
                                data-rutaAplicacion='inocuidad'
                                data-opcion='./vistas/icLaboratorioEditar' 
                                ondragstart='drag(event)' 
                                draggable='true' 
                                data-destino='detalleItem'>
                                    <span class='ordinal'>$ic_analisis_muestra_id</span>
                                    <span>$nombre</span>
                                    <aside><small>$nombre_producto</small></aside>
                                </article>";
            }
            $resultado.="</div>";
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    /*
     * Construye el resumen de laboratorio para la vitacora
     * */
    public function getLaboratorioRO($idLaboratorio){
        $registros=$this->servicios->getLaboratorioRO($idLaboratorio,$this->conexion);
        
            $header="<fieldset class='fieldset-resumen'> <table class='table-resumen'>";
            $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Laboratorio</label></td></tr>";
            $hasHeader = false;
        if (is_array($registros) && count($registros) >0){
                foreach ($registros as $laboratorio){
                    if(!$hasHeader){
                        $header .= "<tr class='resumen-subtitulo'><td colspan='2'><label class='resumen-subtitulo-label'>Registro de Valores</label></td></tr>";
                        $hasHeader=true;
                    }
                    $header .= "<tr><td colspan='2' style='background-color: #eeeeee' class='header-titulo'>". $laboratorio['insumo'] ." - ". $laboratorio['unidad_medida'] ."</td></tr>";
                    $header .= "<tr><td><label class='resumen-titulo'>Valor</label></td><td><label class='resumen-contenido'>" . $laboratorio['valor'] . "</label></td></tr>";
                    $header .= "<tr><td><label class='resumen-titulo'>Observación</label></td><td><label class='resumen-contenido'>" . $laboratorio['obs'] . "</label></td></tr>";
                }
            
            $header.="</table> </fieldset>";
        }    
        return $header;
    }
}