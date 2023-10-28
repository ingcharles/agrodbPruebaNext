<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 05/02/18
 * Time: 10:13
 */
require_once '../servicios/ServiceLmrDAO.php';
require_once '../Modelo/Lmr.php';
require_once '../../../clases/Conexion.php';
require_once '../controladores/ControladorCatalogosInc.php';
class ControladorLmr
{
    private $conexion;
    private $servicios;

    /**
     * ControladorLmr constructor.
     */
    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->servicios = new ServiceLmrDAO();
    }

    public function saveAndUpdateLmr(Lmr $lmr){
        $resultado=null;
        try{
            $resultado=$this->servicios->saveAndUpdateLmr($lmr,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function listarLmrs(){
        $resultado=null;
        try{
            $resultado=$this->servicios->getAllLmrs($this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    public function getLmr($ic_lmr_id){
        $resultado=null;
        try{
            $resultado=$this->servicios->getLmrById($ic_lmr_id,$this->conexion);
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }

    /*
     * Construye los lmr visibles
     * */
    public function listArticles(){
        $resultado=null;
        try{
            $controladorCatalogo = new ControladorCatalogosInc();
            $lmrs=$this->servicios->getAllLmrs($this->conexion);
            $resultado="";
            $parametro_id=0;
          
            foreach ($lmrs as $lmr){
           
                $parametro_id;
                if($parametro_id!=$lmr->getParametroId()){
                
                    if($parametro_id!=0){
                        $resultado.="</div>";
                    }
                    $parametro_id=$lmr->getParametroId();
                    $nombre_programa = $controladorCatalogo->obtenerNombreProgramaParametro($parametro_id);
                    if($nombre_programa != ""){
                        $resultado.= "<div id='insumos-container'>";
                        $resultado.= "<h2>$nombre_programa</h2>";
                        $bandera=true;
                    }else{
                        $bandera=false;
                    }
                }
                if($bandera){
                    $ic_lmr_id = $lmr->getIcLmrId();
                    $nombre = strlen($lmr->getNombre())>45?substr($lmr->getNombre(),0,45):$lmr->getNombre();
                    $descripcion = strlen($lmr->getDescripcion())>29?substr($lmr->getDescripcion(),0,29):$lmr->getDescripcion();
                    $resultado.= "<article
                                    id='$ic_lmr_id'
                                    class='item'
                                    data-rutaAplicacion='inocuidad'
                                    data-opcion='./vistas/adminLmrsEditar' 
                                    ondragstart='drag(event)' 
                                    draggable='true' 
                                    data-destino='detalleItem'>
                                        <span class='ordinal'>$ic_lmr_id</span>
                                        <span>$nombre</span>
                                        <aside><small>$descripcion</small></aside>
                                    </article>";
                }
            }
            $resultado.="</div>";
        }catch(Exception $e){
            $resultado=$e->getMessage();
        }
        return $resultado;
    }
}