<?php

/**
 * Lógica del negocio de  FiebreaftosaModelo
 *
 * Este archivo se complementa con el archivo   FiebreaftosaControlador.
 *
 * @author DATASTAR
 * @uses       FiebreaftosaLogicaNegocio
 * @package Laboratorios
 * @subpackage Modelo
 */

namespace Agrodb\Laboratorios\Modelos;

use Agrodb\Laboratorios\Modelos\IModelo;

class FiebreaftosaLogicaNegocio implements IModelo
{

    private $modelo = null;

    /**
     * Constructor
     * 
     * @retorna void
     */
    public function __construct()
    {
        $this->modelo = new FiebreaftosaModelo();
    }

    /**
     * Guarda el registro actual
     * @param array $datos
     * @return int
     */
    public function guardar(Array $datos)
    {
        $tablaModelo = new FiebreaftosaModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdFiebreaftosa() != null && $tablaModelo->getIdFiebreaftosa() > 0)
        {
            return $this->modelo->actualizar($datosBd, $tablaModelo->getIdFiebreaftosa());
        } else
        {
            unset($datosBd["id_fiebre_aftosa"]);
            return $this->modelo->guardar($datosBd);
        }
    }

    /**
     * Borra el registro actual
     * @param string Where|array $where
     * @return int
     */
    public function borrar($id)
    {
        $this->modelo->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param  int $id
     * @return FiebreaftosaModelo
     */
    public function buscar($id)
    {
        return $this->modelo->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modelo->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modelo->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarFiebreaftosa()
    {
        $consulta = "SELECT * FROM " . $this->modelo->getEsquema() . ". fiebre_aftosa";
        return $this->modelo->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Columnas de la tabla g_laboratorios.fiebre_aftosa
     * @return string
     */
    public function columnas() {
        $columnas = array(
            'id_laboratorio',
            'codigo_sifae',
            'codigo_laboratorio',
            'nombre_muestra'
        );
        return $columnas;
    }

}
