<?php

/**
 * Plantilla de métodos de la clase modelo a implementar en la lógica del negocio
 *
 *
 * @property  AGROCALIDAD
 * @author    Carlos Anchundia
 * @date      2022-12-20
 * @uses      IModelo
 * @package   RegistroProductoRia
 * @subpackage Modelos
 */

namespace Agrodb\RegistroProductoRia\Modelos;


interface IModelo
{

    /**
     * Guarda el registro actual
     * @param array $datos
     */
    public function guardar(array $datos);

    /**
     * Borra el registro actual
     * @param int $id
     */
    public function borrar($id);

    /**
     * Busca todos los registros
     *
     */
    public function buscarTodo();

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null);

}
