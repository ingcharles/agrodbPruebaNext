<?php
/**
 * Lógica del negocio de ComposicionesModelo
 *
 * Este archivo se complementa con el archivo ComposicionesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-13
 * @uses    ComposicionesLogicaNegocio
 * @package ModificacionProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\ModificacionProductoRia\Modelos;

use Agrodb\ModificacionProductoRia\Modelos\IModelo;

class ComposicionesLogicaNegocio implements IModelo
{

    private $modeloComposiciones = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloComposiciones = new ComposicionesModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new ComposicionesModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdComposicion() != null && $tablaModelo->getIdComposicion() > 0) {
            return $this->modeloComposiciones->actualizar($datosBd, $tablaModelo->getIdComposicion());
        } else {
            unset($datosBd["id_composicion"]);
            return $this->modeloComposiciones->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloComposiciones->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return ComposicionesModelo
     */
    public function buscar($id)
    {
        return $this->modeloComposiciones->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloComposiciones->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloComposiciones->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarComposiciones()
    {
        $consulta = "SELECT * FROM " . $this->modeloComposiciones->getEsquema() . ". composiciones";
        return $this->modeloComposiciones->ejecutarSqlNativo($consulta);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     * Buscar usos usando filtros.
     *
     * @return array|ResultSet
     */
    public function buscarComposicionesOrigenDestino($arrayParametros)
    {
        $consulta = "SELECT
                            tmc.id_composicion,
                            tmc.id_detalle_solicitud_producto,
                            COALESCE(tmc.id_ingrediente_activo, ci.id_ingrediente_activo) as id_ingrediente_activo,
                            COALESCE(tmc.ingrediente_activo, ci.ingrediente_activo) as ingrediente_activo,
                            COALESCE(tmc.id_tipo_componente, ci.id_tipo_componente) as id_tipo_componente,
                            COALESCE(tmc.tipo_componente, ci.tipo_componente) as tipo_componente,
                            COALESCE(tmc.concentracion, ci.concentracion) as concentracion,
                            COALESCE(tmc.unidad_medida, ci.unidad_medida) as unidad_medida,
                            tmc.id_tabla_origen,
                            tmc.estado,
                            ci.id_composicion as id_composicion_origen
                        FROM                            
                            (SELECT 
                            	mc.id_composicion,
                                mc.id_detalle_solicitud_producto,
                                mc.id_ingrediente_activo,
                                mc.ingrediente_activo,
                                mc.id_tipo_componente,
                                mc.tipo_componente,
                                mc.concentracion,
                                mc.unidad_medida,
                                mc.id_tabla_origen,
                                mc.estado
                            FROM 
                            	g_modificacion_productos.composiciones mc
                            	INNER JOIN g_modificacion_productos.detalle_solicitudes_productos dsp ON dsp.id_detalle_solicitud_producto = mc.id_detalle_solicitud_producto
                            	INNER JOIN g_modificacion_productos.solicitudes_productos sp ON sp.id_solicitud_producto = dsp.id_solicitud_producto
							WHERE
							 	dsp.id_detalle_solicitud_producto = '".$arrayParametros['id_detalle_solicitud_producto']."'
                            ) tmc
	                        FULL OUTER JOIN  g_catalogos.composicion_inocuidad as ci ON ci.id_composicion = tmc.id_tabla_origen
                        WHERE 
                            tmc.id_detalle_solicitud_producto = '".$arrayParametros['id_detalle_solicitud_producto']."'
                            ".(isset($arrayParametros['id_producto']) ? " or ci.id_producto = '".$arrayParametros['id_producto']."'" : "")."
                        ORDER BY
                        	tmc.id_composicion;";

        return $this->modeloComposiciones->ejecutarSqlNativo($consulta);
    }
}
