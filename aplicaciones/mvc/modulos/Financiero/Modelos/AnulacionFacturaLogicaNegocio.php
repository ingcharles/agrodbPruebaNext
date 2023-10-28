<?php
/**
 * Lógica del negocio de AnulacionFacturaModelo
 *
 * Este archivo se complementa con el archivo AnulacionFacturaControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    AnulacionFacturaLogicaNegocio
 * @package Financiero
 * @subpackage Modelos
 */
namespace Agrodb\Financiero\Modelos;

use Agrodb\Financiero\Modelos\IModelo;
use Agrodb\Core\Excepciones\GuardarExcepcion;

class AnulacionFacturaLogicaNegocio implements IModelo
{

    private $modeloAnulacionFactura = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloAnulacionFactura = new AnulacionFacturaModelo();
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        $tablaModelo = new AnulacionFacturaModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdAnulacionFactura() != null && $tablaModelo->getIdAnulacionFactura() > 0) {
            return $this->modeloAnulacionFactura->actualizar($datosBd, $tablaModelo->getIdAnulacionFactura());
        } else {
            unset($datosBd["id_anulacion_factura"]);
            return $this->modeloAnulacionFactura->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     *
     * @param
     *            string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloAnulacionFactura->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return AnulacionFacturaModelo
     */
    public function buscar($id)
    {
        return $this->modeloAnulacionFactura->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloAnulacionFactura->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloAnulacionFactura->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarAnulacionFactura()
    {
        $consulta = "SELECT * FROM " . $this->modeloAnulacionFactura->getEsquema() . ". anulacion_factura";
        return $this->modeloAnulacionFactura->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarAnulacionFacturaPorIdAnulacionFactura($idAnulacionFactura)
    {
        $consulta = "SELECT
                        op.id_pago
                        , op.ruc_institucion
                        , op.numero_establecimiento || '-' || op.punto_emision || '-' || op.numero_factura AS numero_factura
                        , op.factura
                        , op.total_pagar
                        , af.numero_glpi
                        , af.motivo_anulacion
                    FROM
                        g_financiero.anulacion_factura af
                    INNER JOIN g_financiero.orden_pago op ON op.id_pago = af.id_pago
                    WHERE
                        af.id_anulacion_factura = '" . $idAnulacionFactura . "'";
        return $this->modeloAnulacionFactura->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarFiltroAnulacionFactura($arrayParametros)
    {
        
        $ruc = $arrayParametros['ruc'];
        $numeroEstablecimiento = $arrayParametros['numero_establecimiento'];
        $numeroFactura = $arrayParametros['numero_factura'];
        $fechaInicio = $arrayParametros['fecha_inicio'];
        $fechaFin = $arrayParametros['fecha_fin'];
        
        $ruc = ($ruc == "") ? "NULL" : "'" . $ruc . "'";
        $numeroEstablecimiento = ($numeroEstablecimiento == "") ? "NULL" : "'" . $numeroEstablecimiento . "'";
        $numeroFactura = ($numeroFactura == "") ? "NULL" : "'" . $numeroFactura . "'";
        $fechaInicio = ($fechaInicio == "") ? "NULL" : "'" . $fechaInicio . " 00:00:00'";
        $fechaFin = ($fechaFin == "") ? "NULL" : "'" . $fechaFin . " 24:00:00'";
        
        $consulta = "SELECT
                        op.id_pago
                        , op.ruc_institucion
                        , op.numero_establecimiento || '-' || op.punto_emision || '-' || op.numero_factura AS numero_factura
                        , op.factura
                        , op.total_pagar
                        , af.id_anulacion_factura
                        , af.numero_glpi
                        , af.motivo_anulacion
                        , af.fecha_anulacion_factura 
                    FROM
                        g_financiero.anulacion_factura af
                    INNER JOIN g_financiero.orden_pago op ON op.id_pago = af.id_pago
                    WHERE
                        (" . $ruc . " is NULL or op.ruc_institucion = " . $ruc . ")
                        AND (" . $numeroEstablecimiento . " is NULL or op.numero_establecimiento = " . $numeroEstablecimiento . ")
                        AND (" . $numeroFactura . " is NULL or op.numero_factura = " . $numeroFactura . ")
                        AND (" . $fechaInicio . " is NULL or af.fecha_anulacion_factura >= " . $fechaInicio . ")
                        AND (" . $fechaFin . " is NULL or af.fecha_anulacion_factura <= " . $fechaFin . ")";
        return $this->modeloAnulacionFactura->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Metodo que guarda la anulacion de factura
     *
     * @param array $datos
     * @return int
     */
    public function enviarSolicitud(Array $datos){
            
        $resultado = $this->guardarAnulacion($datos);
            
        $arrayResultado = $resultado->current()->anular_factura;            
        $arrayResultado = json_decode($arrayResultado, true);
                         
        return $arrayResultado;
   
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function guardarAnulacion($arrayParametros)
    {
        
        $ruc = $arrayParametros['ruc_institucion'];
        $numero_establecimiento = $arrayParametros['numero_establecimiento'];
        $numero_factura = $arrayParametros['numero_factura']; 
        $numero_glpi = $arrayParametros['numero_glpi']; 
        $motivo_anulacion = $arrayParametros['motivo_anulacion'];
        $identificador_usuario = $arrayParametros['identificador_usuario'];
        
        $consulta = "SELECT * FROM g_financiero.anular_factura('" . $ruc . "', '" . $numero_establecimiento ."', '" . $numero_factura ."', '" . $numero_glpi ."', '" . $motivo_anulacion ."', '" . $identificador_usuario ."')";
        return $this->modeloAnulacionFactura->ejecutarSqlNativo($consulta);
    }
    
}
