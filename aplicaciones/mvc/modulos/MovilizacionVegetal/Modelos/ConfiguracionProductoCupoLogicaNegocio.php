<?php
/**
 * Lógica del negocio de ConfiguracionProductoCupoModelo
 *
 * Este archivo se complementa con el archivo ConfiguracionProductoCupoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-12-07
 * @uses    ConfiguracionProductoCupoLogicaNegocio
 * @package MovilizacionVegetal
 * @subpackage Modelos
 */
namespace Agrodb\MovilizacionVegetal\Modelos;

use Agrodb\MovilizacionVegetal\Modelos\IModelo;

class ConfiguracionProductoCupoLogicaNegocio implements IModelo
{

    private $modeloConfiguracionProductoCupo = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloConfiguracionProductoCupo = new ConfiguracionProductoCupoModelo();
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        $tablaModelo = new ConfiguracionProductoCupoModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdConfiguracionProductoCupo() != null && $tablaModelo->getIdConfiguracionProductoCupo() > 0) {
            $datosBd['fecha_actualizacion'] = 'now()';
            return $this->modeloConfiguracionProductoCupo->actualizar($datosBd, $tablaModelo->getIdConfiguracionProductoCupo());
        } else {
            unset($datosBd["id_configuracion_producto_cupo"]);
            return $this->modeloConfiguracionProductoCupo->guardar($datosBd);
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
        $this->modeloConfiguracionProductoCupo->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return ConfiguracionProductoCupoModelo
     */
    public function buscar($id)
    {
        return $this->modeloConfiguracionProductoCupo->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloConfiguracionProductoCupo->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloConfiguracionProductoCupo->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarConfiguracionProductoCupo()
    {
        $consulta = "SELECT 
                    	cpc.id_configuracion_producto_cupo
                    	, tp.nombre AS nombre_tipo_producto
                    	, stp.nombre AS nombre_subtipo_producto
                    	, p.nombre_comun AS nombre_producto
                    	, cpc.estado_configuracion_producto_cupo
                    	, cpc.fecha_creacion
                    FROM 
                    	g_movilizacion_vegetal.configuracion_producto_cupo cpc
                    	INNER JOIN g_catalogos.tipo_productos tp ON tp.id_tipo_producto = cpc.id_tipo_producto
                    	INNER JOIN g_catalogos.subtipo_productos stp ON stp.id_subtipo_producto = cpc.id_subtipo_producto
                    	INNER JOIN g_catalogos.productos p ON p.id_producto = cpc.id_producto
                    ORDER BY cpc.id_configuracion_producto_cupo ASC";
        return $this->modeloConfiguracionProductoCupo->ejecutarSqlNativo($consulta);
    }
}
