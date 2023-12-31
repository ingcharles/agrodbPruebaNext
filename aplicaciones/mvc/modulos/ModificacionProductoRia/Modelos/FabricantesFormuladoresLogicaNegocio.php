<?php
/**
 * Lógica del negocio de FabricantesFormuladoresModelo
 *
 * Este archivo se complementa con el archivo FabricantesFormuladoresControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-13
 * @uses    FabricantesFormuladoresLogicaNegocio
 * @package ModificacionProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\ModificacionProductoRia\Modelos;

use Agrodb\ModificacionProductoRia\Modelos\IModelo;

class FabricantesFormuladoresLogicaNegocio implements IModelo
{

    private $modeloFabricantesFormuladores = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloFabricantesFormuladores = new FabricantesFormuladoresModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new FabricantesFormuladoresModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdFabricanteFormulador() != null && $tablaModelo->getIdFabricanteFormulador() > 0) {
            return $this->modeloFabricantesFormuladores->actualizar($datosBd, $tablaModelo->getIdFabricanteFormulador());
        } else {
            unset($datosBd["id_fabricante_formulador"]);
            return $this->modeloFabricantesFormuladores->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloFabricantesFormuladores->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return FabricantesFormuladoresModelo
     */
    public function buscar($id)
    {
        return $this->modeloFabricantesFormuladores->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloFabricantesFormuladores->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloFabricantesFormuladores->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarFabricantesFormuladores()
    {
        $consulta = "SELECT * FROM " . $this->modeloFabricantesFormuladores->getEsquema() . ". fabricantes_formuladores";
        return $this->modeloFabricantesFormuladores->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     * Buscar usos usando filtros.
     *
     * @return array|ResultSet
     */
    public function buscarFabricanteFormuladorOrigenDestino($arrayParametros)
    {

        $consulta = "SELECT
                        tmff.id_fabricante_formulador,
                        tmff.id_detalle_solicitud_producto,
                        COALESCE(tmff.tipo, ff.tipo) as tipo,
                        COALESCE(tmff.nombre, ff.nombre) as nombre,
                        COALESCE(tmff.id_pais_origen, ff.id_pais_origen) as id_pais_origen,
                        COALESCE(tmff.nombre_pais_origen, ff.pais_origen) as nombre_pais_origen,
                        tmff.id_tabla_origen,
                        COALESCE(tmff.estado, ff.estado) as estado,
                        ff.id_fabricante_formulador as id_fabricante_formulador_origen
                     FROM
                        (SELECT
                            mff.id_fabricante_formulador,
                            mff.id_detalle_solicitud_producto,
                            mff.tipo,
                            mff.nombre,
                            mff.id_pais_origen,
                            mff.nombre_pais_origen,
                            mff.id_tabla_origen,
                            mff.estado
                          FROM
                            g_modificacion_productos.fabricantes_formuladores as mff
                            INNER JOIN g_modificacion_productos.detalle_solicitudes_productos dsp ON dsp.id_detalle_solicitud_producto = mff.id_detalle_solicitud_producto
                            INNER JOIN g_modificacion_productos.solicitudes_productos sp ON sp.id_solicitud_producto = dsp.id_solicitud_producto
                          WHERE
                            dsp.id_detalle_solicitud_producto = '".$arrayParametros['id_detalle_solicitud_producto']."'
                            ) tmff
                        FULL OUTER JOIN  g_catalogos.fabricante_formulador as ff ON ff.id_fabricante_formulador = tmff.id_tabla_origen
                    WHERE
                        tmff.id_detalle_solicitud_producto = '".$arrayParametros['id_detalle_solicitud_producto']."'
                        ".(isset($arrayParametros['id_producto']) ? " or ff.id_producto = '".$arrayParametros['id_producto']."'" : "")."
                    ORDER BY
                        tmff.id_fabricante_formulador;";

        return $this->modeloFabricantesFormuladores->ejecutarSqlNativo($consulta);
    }

}
