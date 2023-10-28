<?php
/**
 * Lógica del negocio de OrganismosInspeccionModelo
 *
 * Este archivo se complementa con el archivo OrganismosInspeccionControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-10-21
 * @uses    OrganismosInspeccionLogicaNegocio
 * @package EnsayoEficacia
 * @subpackage Modelos
 */

namespace Agrodb\EnsayoEficacia\Modelos;

use Agrodb\EnsayoEficacia\Modelos\IModelo;

class OrganismosInspeccionLogicaNegocio implements IModelo
{

    private $modeloOrganismosInspeccion = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloOrganismosInspeccion = new OrganismosInspeccionModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new OrganismosInspeccionModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdOrganismoInspeccion() != null && $tablaModelo->getIdOrganismoInspeccion() > 0) {
            return $this->modeloOrganismosInspeccion->actualizar($datosBd, $tablaModelo->getIdOrganismoInspeccion());
        } else {
            unset($datosBd["id_organismo_inspeccion"]);
            return $this->modeloOrganismosInspeccion->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloOrganismosInspeccion->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return OrganismosInspeccionModelo
     */
    public function buscar($id)
    {
        return $this->modeloOrganismosInspeccion->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloOrganismosInspeccion->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloOrganismosInspeccion->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarOrganismosInspeccion()
    {
        $consulta = "SELECT * FROM " . $this->modeloOrganismosInspeccion->getEsquema() . ". organismos_inspeccion";
        return $this->modeloOrganismosInspeccion->ejecutarSqlNativo($consulta);
    }

}
