<?php
/**
 * Created by IntelliJ IDEA.
 * User: antonio
 * Date: 19/02/18
 * Time: 22:45
 */

class Laboratorio implements JsonSerializable
{
    private $ic_analisis_muestra_id;
    private $ic_muestra_id;
    private $activo;
    private $ic_tipo_requerimiento_id;
    private $ic_requerimiento_id;
    private $ic_producto_id;
    private $observaciones;
    private $fecha_recepcion_muestra;
    private $fecha_analisis_muestra;
    private $numero_informe_lab;
    private $numero_memorando;
    private $observacion_rechazo;
    

    /**
     * Laboratorio constructor.
     * @param $ic_analisis_muestra_id
     * @param $ic_muestra_id
     * @param $activo
     */
    public function __construct($ic_analisis_muestra_id, $ic_muestra_id, $activo)
    {
        $this->ic_analisis_muestra_id = $ic_analisis_muestra_id;
        $this->ic_muestra_id = $ic_muestra_id;
        $this->activo = $activo;
        
    }

    public function jsonSerialize() { return get_object_vars($this); }

    /**
     * @return mixed
     */
    public function getIcAnalisisMuestraId()
    {
        return $this->ic_analisis_muestra_id;
    }

    /**
     * @param mixed $ic_analisis_muestra_id
     */
    public function setIcAnalisisMuestraId($ic_analisis_muestra_id)
    {
        $this->ic_analisis_muestra_id = $ic_analisis_muestra_id;
    }

    /**
     * @return mixed
     */
    public function getIcMuestraId()
    {
        return $this->ic_muestra_id;
    }

    /**
     * @param mixed $ic_muestra_id
     */
    public function setIcMuestraId($ic_muestra_id)
    {
        $this->ic_muestra_id = $ic_muestra_id;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param mixed $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return mixed
     */
    public function getIcTipoRequerimientoId()
    {
        return $this->ic_tipo_requerimiento_id;
    }

    /**
     * @param mixed $ic_tipo_requerimiento_id
     */
    public function setIcTipoRequerimientoId($ic_tipo_requerimiento_id)
    {
        $this->ic_tipo_requerimiento_id = $ic_tipo_requerimiento_id;
    }

    /**
     * @return mixed
     */
    public function getIcRequerimientoId()
    {
        return $this->ic_requerimiento_id;
    }

    /**
     * @param mixed $ic_requerimiento_id
     */
    public function setIcRequerimientoId($ic_requerimiento_id)
    {
        $this->ic_requerimiento_id = $ic_requerimiento_id;
    }

    /**
     * @return mixed
     */
    public function getIcProductoId()
    {
        return $this->ic_producto_id;
    }

    /**
     * @param mixed $ic_producto_id
     */
    public function setIcProductoId($ic_producto_id)
    {
        $this->ic_producto_id = $ic_producto_id;
    }

    /**
     * @return mixed
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param mixed $observacion
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

     /**
     * @return mixed
     */
    public function getFechaRecepcionMuestra()
    {
        return $this->fecha_recepcion_muestra;
    }

    /**
     * @param mixed $observacion
     */
    public function setFechaRecepcionMuestra($fecha_recepcion_muestra)
    {
        $this->fecha_recepcion_muestra = $fecha_recepcion_muestra;
    }

     /**
     * @return mixed
     */
    public function getFechaAnalisisMuestra()
    {
        return $this->fecha_analisis_muestra;
    }

    /**
     * @param mixed $observacion
     */
    public function setFechaAnalisisMuestra($fecha_analisis_muestra)
    {
        $this->fecha_analisis_muestra = $fecha_analisis_muestra;
    }

     /**
     * @return mixed
     */
    public function getNumeroInformeLab()
    {
        return $this->numero_informe_lab;
    }

    /**
     * @param mixed $observacion
     */
    public function setNumeroInformeLab($numero_informe_lab)
    {
        $this->numero_informe_lab = $numero_informe_lab;
    }

     /**
     * @return mixed
     */
    public function getNumeroMemorando()
    {
        return $this->numero_memorando;
    }

    /**
     * @param mixed $observacion
     */
    public function setNumeroMemorando($numero_memorando)
    {
        $this->numero_memorando = $numero_memorando;
    }
/**
     * @return mixed
     */
    public function getObservacionRechazo()
    {
        return $this->observacion_rechazo;
    }

    /**
     * @param mixed $observacion
     */
    public function setObservacionRechazo($observacion_rechazo)
    {
        $this->observacion_rechazo = $observacion_rechazo;
    }


}