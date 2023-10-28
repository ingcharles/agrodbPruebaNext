<?php
/**
 * Lógica del negocio de ManufacturadoresModelo
 *
 * Este archivo se complementa con el archivo ManufacturadoresControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-13
 * @uses    ManufacturadoresLogicaNegocio
 * @package ModificacionProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\ModificacionProductoRia\Modelos;

use Agrodb\ModificacionProductoRia\Modelos\IModelo;

class ManufacturadoresLogicaNegocio implements IModelo
{

    private $modeloManufacturadores = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloManufacturadores = new ManufacturadoresModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new ManufacturadoresModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdManufacturador() != null && $tablaModelo->getIdManufacturador() > 0) {
            return $this->modeloManufacturadores->actualizar($datosBd, $tablaModelo->getIdManufacturador());
        } else {
            unset($datosBd["id_manufacturador"]);
            return $this->modeloManufacturadores->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloManufacturadores->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return ManufacturadoresModelo
     */
    public function buscar($id)
    {
        return $this->modeloManufacturadores->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloManufacturadores->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloManufacturadores->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarManufacturadores()
    {
        $consulta = "SELECT * FROM " . $this->modeloManufacturadores->getEsquema() . ". manufacturadores";
        return $this->modeloManufacturadores->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     * Buscar usos usando filtros.
     *
     * @return array|ResultSet
     */
    public function buscarManufacturadorOrigenDestino($arrayParametros)
    {
        $consulta = "  SELECT
                            tmd.id_manufacturador,
                            tmd.id_detalle_solicitud_producto,
                            COALESCE(tmd.id_fabricante_formulador, mo.id_fabricante_formulador) as id_fabricante_formulador,
                            COALESCE(tmd.manufacturador, mo.manufacturador) as manufacturador,
                            COALESCE(tmd.id_pais_origen, mo.id_pais_origen) as id_pais_origen,
                            COALESCE(tmd.pais_origen, mo.pais_origen) as pais_origen,
                            tmd.id_tabla_origen,
                            COALESCE(tmd.estado, mo.estado) as estado,
                            mo.id_manufacturador as id_manufacturador_origen,
                            ff.tipo ||' - '|| ff.nombre ||' - '|| ff.pais_origen as fabricante_formulador
                        FROM                            
                            (SELECT 
                            	md.id_manufacturador,
                                md.id_detalle_solicitud_producto,
                                md.id_fabricante_formulador,
                                md.manufacturador,
                                md.id_pais_origen,
                                md.pais_origen,
                                md.id_tabla_origen,
                                md.estado
                            FROM 
                            	g_modificacion_productos.manufacturadores md
                            	INNER JOIN g_modificacion_productos.detalle_solicitudes_productos dsp ON dsp.id_detalle_solicitud_producto = md.id_detalle_solicitud_producto
                            	INNER JOIN g_modificacion_productos.solicitudes_productos sp ON sp.id_solicitud_producto = dsp.id_solicitud_producto
							WHERE
							 	dsp.id_detalle_solicitud_producto = '" . $arrayParametros['id_detalle_solicitud_producto'] . "'
                            ) tmd
                            FULL OUTER JOIN  g_catalogos.manufacturador as mo ON mo.id_manufacturador = tmd.id_tabla_origen
                            INNER JOIN g_catalogos.fabricante_formulador ff ON ff.id_fabricante_formulador = mo.id_fabricante_formulador OR ff.id_fabricante_formulador = tmd.id_fabricante_formulador
                        WHERE 
                            tmd.id_detalle_solicitud_producto = '" . $arrayParametros['id_detalle_solicitud_producto'] . "'
                            " . (isset($arrayParametros['id_producto']) ? " or ff.id_producto = '" . $arrayParametros['id_producto'] . "'" : "") . "
                        ORDER BY
                        	tmd.id_manufacturador;";

        return $this->modeloManufacturadores->ejecutarSqlNativo($consulta);
    }
}
