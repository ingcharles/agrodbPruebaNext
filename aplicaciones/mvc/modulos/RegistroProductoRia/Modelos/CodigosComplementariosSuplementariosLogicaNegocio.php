<?php
/**
 * Lógica del negocio de CodigosComplementariosSuplementariosModelo
 *
 * Este archivo se complementa con el archivo CodigosComplementariosSuplementariosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-20
 * @uses    CodigosComplementariosSuplementariosLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\RegistroProductoRia\Modelos;

use Agrodb\RegistroProductoRia\Modelos\IModelo;

class CodigosComplementariosSuplementariosLogicaNegocio implements IModelo
{

    private $modeloCodigosComplementariosSuplementarios = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloCodigosComplementariosSuplementarios = new CodigosComplementariosSuplementariosModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new CodigosComplementariosSuplementariosModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdCodigoComplementarioSuplementario() != null && $tablaModelo->getIdCodigoComplementarioSuplementario() > 0) {
            return $this->modeloCodigosComplementariosSuplementarios->actualizar($datosBd, $tablaModelo->getIdCodigoComplementarioSuplementario());
        } else {
            unset($datosBd["id_codigo_complementario_suplementario"]);
            return $this->modeloCodigosComplementariosSuplementarios->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloCodigosComplementariosSuplementarios->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return CodigosComplementariosSuplementariosModelo
     */
    public function buscar($id)
    {
        return $this->modeloCodigosComplementariosSuplementarios->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloCodigosComplementariosSuplementarios->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloCodigosComplementariosSuplementarios->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarCodigosComplementariosSuplementarios()
    {
        $consulta = "SELECT * FROM " . $this->modeloCodigosComplementariosSuplementarios->getEsquema() . ". codigos_complementarios_suplementarios";
        return $this->modeloCodigosComplementariosSuplementarios->ejecutarSqlNativo($consulta);
    }

}
