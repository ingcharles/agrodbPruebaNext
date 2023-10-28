<?php
/**
 * Lógica del negocio de FabricantesFormuladoresModelo
 *
 * Este archivo se complementa con el archivo FabricantesFormuladoresControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-20
 * @uses    FabricantesFormuladoresLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\RegistroProductoRia\Modelos;

use Agrodb\RegistroProductoRia\Modelos\IModelo;

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

}
