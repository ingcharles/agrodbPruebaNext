<?php
/**
 * Lógica del negocio de ConfigurarEstadoInspeccionPaisModelo
 *
 * Este archivo se complementa con el archivo ConfigurarEstadoInspeccionPaisControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    ConfigurarEstadoInspeccionPaisLogicaNegocio
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
namespace Agrodb\InspeccionFitosanitaria\Modelos;

use Agrodb\InspeccionFitosanitaria\Modelos\IModelo;

class ConfigurarEstadoInspeccionPaisLogicaNegocio implements IModelo
{

    private $modeloConfigurarEstadoInspeccionPais = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloConfigurarEstadoInspeccionPais = new ConfigurarEstadoInspeccionPaisModelo();
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        $tablaModelo = new ConfigurarEstadoInspeccionPaisModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdEstadoInspeccionPais() != null && $tablaModelo->getIdEstadoInspeccionPais() > 0) {
            return $this->modeloConfigurarEstadoInspeccionPais->actualizar($datosBd, $tablaModelo->getIdEstadoInspeccionPais());
        } else {
            unset($datosBd["id_estado_inspeccion_pais"]);
            return $this->modeloConfigurarEstadoInspeccionPais->guardar($datosBd);
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
        $this->modeloConfigurarEstadoInspeccionPais->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return ConfigurarEstadoInspeccionPaisModelo
     */
    public function buscar($id)
    {
        return $this->modeloConfigurarEstadoInspeccionPais->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloConfigurarEstadoInspeccionPais->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloConfigurarEstadoInspeccionPais->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarConfigurarEstadoInspeccionPais()
    {
        $consulta = "SELECT * FROM " . $this->modeloConfigurarEstadoInspeccionPais->getEsquema() . ". configurar_estado_inspeccion_pais ORDER BY id_estado_inspeccion_pais ASC";
        return $this->modeloConfigurarEstadoInspeccionPais->ejecutarSqlNativo($consulta);
    }
}
