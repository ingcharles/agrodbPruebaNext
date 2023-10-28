<?php
/**
 * Lógica del negocio de ComposicionesModelo
 *
 * Este archivo se complementa con el archivo ComposicionesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-20
 * @uses    ComposicionesLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\RegistroProductoRia\Modelos;

use Agrodb\RegistroProductoRia\Modelos\IModelo;

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

}
