<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 05/02/18
 * Time: 22:35
 */
require_once '../Modelo/Lmr.php';
class ServiceLmrDAO
{
    /**
     * ServiceLmrDAO constructor.
     */
    public function __construct()
    {
    }

    public function getAllLmrs($conexion){
        $queryAll=" SELECT ic_lmr_id, nombre, descripcion, parametro_id";
        $queryAll.=" FROM g_inocuidad.ic_lmr";
        $queryAll.=" ORDER BY parametro_id";

        $filas = array();
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            while ($filasLmr = pg_fetch_assoc($result)) {
                $lmr = new Lmr($filasLmr['ic_lmr_id'],$filasLmr['nombre'],$filasLmr['descripcion'],$filasLmr['parametro_id']);
                array_push($filas, $lmr);
            }
        }catch(Exception $exc){
            return array();
        }
        return $filas;
    }

    public function getLmrById($lmrId,$conexion){
       
        $queryAll=" SELECT ic_lmr_id, nombre, descripcion,parametro_id 
                    FROM g_inocuidad.ic_lmr 
                    WHERE ic_lmr_id=$lmrId";
      
        try{
            $result = $conexion->ejecutarConsulta($queryAll);
            while ($filasLmr = pg_fetch_assoc($result)) {
                $lmr = new Lmr($filasLmr['ic_lmr_id'],$filasLmr['nombre'],$filasLmr['descripcion'],$filasLmr['parametro_id']);
            }
        }catch(Exception $exc){
            return new Lmr();
        }
        return $lmr;
    }

    public function saveAndUpdateLmr(Lmr $lmr,$conexion){
        $result=null;
        $querySave="";
        $sequenceQuery ="SELECT nextval('g_inocuidad.ic_lmr_ic_lmr_id_seq')";
        if(isset($lmr)) {

            $ic_lmr_id = $lmr->getIcLmrId();
            $nombre = $lmr->getNombre();
            $descripcion = $lmr->getDescripcion();
            $parametro_id = $lmr->getPArametroId();

            if ($lmr->getIcLmrId() != null) {
                $querySave = " UPDATE g_inocuidad.ic_lmr";
                $querySave .= "   SET nombre='$nombre', descripcion='$descripcion', parametro_id=$parametro_id";
                $querySave .= " WHERE ic_lmr_id=$ic_lmr_id";
            } else {
                $ic_lmr_id = $this->obtenerSecuencial($conexion,$sequenceQuery);
                $querySave = " INSERT INTO g_inocuidad.ic_lmr(ic_lmr_id,nombre, descripcion, parametro_id)";
                $querySave .= " VALUES($ic_lmr_id,'$nombre','$descripcion', $parametro_id)";
            }
            try{
                $result=$conexion->ejecutarConsulta($querySave);
                $result=$ic_lmr_id;
            }catch (Exception $exc){
                $result = $exc->getMessage();
            }

            return $result;
        }
    }

    public function deleteLmr($lmrId,$conexion){
        $queryDelete="DELETE FROM g_inocuidad.ic_lmr WHERE ic_lmr_id=$lmrId";
        $result = $conexion->ejecutarConsulta($queryDelete);
        return $result;
    }
    private function obtenerSecuencial($conexion,$querySequence){
        $res=$conexion->ejecutarConsulta($querySequence);
        $sec=pg_fetch_assoc($res);
        return $sec['nextval'];
    }

    
}