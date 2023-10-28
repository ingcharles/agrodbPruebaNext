<?php
/**
 * Lógica del negocio de PresentacionesModelo
 *
 * Este archivo se complementa con el archivo PresentacionesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-20
 * @uses    PresentacionesLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\RegistroProductoRia\Modelos;

use Agrodb\RegistroProductoRia\Modelos\IModelo;

class PresentacionesLogicaNegocio implements IModelo
{

    private $modeloPresentaciones = null;


    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloPresentaciones = new PresentacionesModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(array $datos)
    {
        $tablaModelo = new PresentacionesModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdPresentacion() != null && $tablaModelo->getIdPresentacion() > 0) {
            return $this->modeloPresentaciones->actualizar($datosBd, $tablaModelo->getIdPresentacion());
        } else {
            unset($datosBd["id_presentacion"]);
            return $this->modeloPresentaciones->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modeloPresentaciones->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return PresentacionesModelo
     */
    public function buscar($id)
    {
        return $this->modeloPresentaciones->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloPresentaciones->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloPresentaciones->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarPresentaciones()
    {
        $consulta = "SELECT * FROM " . $this->modeloPresentaciones->getEsquema() . ". presentaciones";
        return $this->modeloPresentaciones->ejecutarSqlNativo($consulta);
    }

    /**
     * Genera subcodigo de inocuidad
     *
     * @return ResultSet
     */
    public function obtenerSubcodigoPresentacion ($idSolicitudRegistroProducto){

        $consulta = "SELECT
                	    COALESCE(MAX(CAST(p.subcodigo as  numeric(5))),0)+1 as codigo
                	FROM
                	    g_registro_productos.presentaciones p
                	  WHERE
                	        p.id_solicitud_registro_producto = '" . $idSolicitudRegistroProducto . "';";

        return $this->modeloPresentaciones->ejecutarSqlNativo($consulta);

    }

}
