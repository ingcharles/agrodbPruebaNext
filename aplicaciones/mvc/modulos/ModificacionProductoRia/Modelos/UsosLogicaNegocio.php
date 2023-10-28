<?php
/**
 * Lógica del negocio de UsosModelo
 *
 * Este archivo se complementa con el archivo UsosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-13
 * @uses    UsosLogicaNegocio
 * @package ModificacionProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\ModificacionProductoRia\Modelos;

use Agrodb\ModificacionProductoRia\Modelos\IModelo;

class UsosLogicaNegocio implements IModelo
{

    private $modeloUsos = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloUsos = new UsosModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new UsosModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdUso() != null && $tablaModelo->getIdUso() > 0) {
            return $this->modeloUsos->actualizar($datosBd, $tablaModelo->getIdUso());
        } else {
            unset($datosBd["id_uso"]);
            return $this->modeloUsos->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloUsos->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return UsosModelo
     */
    public function buscar($id)
    {
        return $this->modeloUsos->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloUsos->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloUsos->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarUsos()
    {
        $consulta = "SELECT * FROM " . $this->modeloUsos->getEsquema() . ". usos";
        return $this->modeloUsos->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     * Buscar usos usando filtros.
     *
     * @return array|ResultSet
     */
    public function buscarUsoOrigenDestinoPlaguicida($arrayParametros)
    {
        $consulta = "SELECT
                            tmpu.id_uso,
                            tmpu.id_detalle_solicitud_producto,
                            COALESCE(tmpu.id_cultivo, upp.id_cultivo) as id_cultivo,
                            COALESCE(tmpu.nombre_cultivo, upp.cultivo_nombre_comun) as nombre_cultivo,
                            COALESCE(tmpu.nombre_cientifico_cultivo, upp.cultivo_nombre_cientifico) as nombre_cientifico_cultivo,
                            COALESCE(tmpu.id_plaga, upp.id_plaga) as id_plaga,
                            COALESCE(tmpu.nombre_plaga, upp.plaga_nombre_comun) as nombre_plaga,
                            COALESCE(tmpu.nombre_cientifico_plaga, upp.plaga_nombre_cientifico) as nombre_cientifico_plaga,
                            COALESCE(tmpu.dosis, upp.dosis) as dosis,
                            COALESCE(tmpu.unidad_dosis, upp.unidad_dosis) as unidad_dosis,
                            COALESCE(tmpu.periodo_carencia, upp.periodo_carencia) as periodo_carencia,
                            COALESCE(tmpu.gasto_agua, upp.gasto_agua) as gasto_agua,
                            COALESCE(tmpu.unidad_gasto_agua, upp.unidad_gasto_agua) as unidad_gasto_agua,
                            tmpu.estado,
                            upp.id_uso as id_uso_origen
                        FROM                            
                            (SELECT
                                mpu.id_tabla_origen,
                            	mpu.id_uso,
                                mpu.id_detalle_solicitud_producto,
                                mpu.id_cultivo,
                                mpu.nombre_cultivo,
                                mpu.nombre_cientifico_cultivo,
                                mpu.id_plaga,
                                mpu.nombre_plaga,
                                mpu.nombre_cientifico_plaga,
                                mpu.dosis,
                                mpu.unidad_dosis,
                                mpu.periodo_carencia,
                                mpu.gasto_agua,
                                mpu.unidad_gasto_agua,
                                mpu.estado
                            FROM 
                            	g_modificacion_productos.usos mpu
                            	INNER JOIN g_modificacion_productos.detalle_solicitudes_productos dsp ON dsp.id_detalle_solicitud_producto = mpu.id_detalle_solicitud_producto
                            	INNER JOIN g_modificacion_productos.solicitudes_productos sp ON sp.id_solicitud_producto = dsp.id_solicitud_producto
							WHERE
							 	dsp.id_detalle_solicitud_producto = '" . $arrayParametros['id_detalle_solicitud_producto'] . "'
                            ) tmpu
	                        FULL OUTER JOIN  g_catalogos.usos_productos_plaguicidas as upp ON upp.id_uso = tmpu.id_tabla_origen
                        WHERE 
                            tmpu.id_detalle_solicitud_producto = '" . $arrayParametros['id_detalle_solicitud_producto'] . "'
                            " . (isset($arrayParametros['id_producto']) ? " or upp.id_producto = '" . $arrayParametros['id_producto'] . "'" : "") . "
                        ORDER BY
                        	tmpu.id_uso;";

        return $this->modeloUsos->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     * Buscar usos usando filtros.
     *
     * @return array|ResultSet
     */
    public function buscarUsoOrigenDestinoVeterinarioFertilizantes($arrayParametros)
    {
        $consulta = "  SELECT
                            mpu.id_uso,
                            mpu.id_detalle_solicitud_producto,
                            COALESCE(mpu.id_uso_producto, piu.id_uso) as id_uso_producto,
                            COALESCE(mpu.id_especie, piu.id_especie) as id_especie,
                            COALESCE(mpu.nombre_especie, piu.nombre_especie) as nombre_especie,
                            COALESCE(mpu.aplicado_a, piu.aplicado_a) as aplicado_a,
                            COALESCE(mpu.instalacion, piu.instalacion) as instalacion,
                            mpu.estado,
                            piu.id_producto_uso as id_uso_origen,
                            e.nombre as nombre_especie_tipo,
	                        u.nombre_uso
                        FROM 
                            g_modificacion_productos.usos as mpu
	                        FULL OUTER JOIN  g_catalogos.producto_inocuidad_uso as piu ON piu.id_producto_uso = mpu.id_tabla_origen
                            LEFT JOIN g_catalogos.especies e ON e.id_especies = piu.id_especie OR e.id_especies = mpu.id_especie
	                        LEFT JOIN g_catalogos.usos u ON u.id_uso = piu.id_uso OR u.id_uso = mpu.id_uso_producto
                        WHERE 
                            mpu.id_detalle_solicitud_producto = '" . $arrayParametros['id_detalle_solicitud_producto'] . "'
                            " . (isset($arrayParametros['id_producto']) ? " or piu.id_producto = '" . $arrayParametros['id_producto'] . "'" : "") . "
                        ORDER BY
                        	mpu.id_uso;";

        return $this->modeloUsos->ejecutarSqlNativo($consulta);
    }
}
