<?php
/**
 * Lógica del negocio de AplicacionesModelo
 *
 * Este archivo se complementa con el archivo AplicacionesControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-01-31
 * @uses    AplicacionesLogicaNegocio
 * @package Programas
 * @subpackage Modelos
 */
namespace Agrodb\Programas\Modelos;

use Agrodb\Laboratorios\Modelos\LaboratoriosModelo;
use Agrodb\Programas\Modelos\IModelo;

class AplicacionesLogicaNegocio implements IModelo
{

    private $modeloAplicaciones = null;

    /**
     * Constructor
     *
     * @retorna void
     */
    public function __construct()
    {
        $this->modeloAplicaciones = new AplicacionesModelo();
    }

    /**
     * Guarda el registro actual
     *
     * @param array $datos
     * @return int
     */
    public function guardarAplicacion(Array $datos)
    {
        $tablaModelo = new AplicacionesModelo($datos);
        $datosBd = $tablaModelo->getPrepararDatos();
        if ($tablaModelo->getIdAplicacion() != null && $tablaModelo->getIdAplicacion() > 0) {
            return $this->modeloAplicaciones->actualizar($datosBd, $tablaModelo->getIdAplicacion());
        } else {
            unset($datosBd["id_aplicacion"]);
            return $this->modeloAplicaciones->guardar($datosBd);
        }
    }
    
    public function guardar(LaboratoriosModelo $tabla){
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
        $this->modeloAplicaciones->borrar($id);
    }

    /**
     *
     * Buscar un registro de con la clave primaria
     *
     * @param int $id
     * @return AplicacionesModelo
     */
    public function buscar($id)
    {
        return $this->modeloAplicaciones->buscar($id);
    }

    /**
     * Busca todos los registros
     *
     * @return array|ResultSet
     */
    public function buscarTodo()
    {
        return $this->modeloAplicaciones->buscarTodo();
    }

    /**
     * Busca una lista de acuerdo a los parámetros <params> enviados.
     *
     * @return array|ResultSet
     */
    public function buscarLista($where = null, $order = null, $count = null, $offset = null)
    {
        return $this->modeloAplicaciones->buscarLista($where, $order, $count, $offset);
    }

    /**
     * Ejecuta una consulta(SQL) personalizada .
     *
     * @return array|ResultSet
     */
    public function buscarAplicaciones()
    {
        $consulta = "SELECT * FROM " . $this->modeloAplicaciones->getEsquema() . ". aplicaciones";
        return $this->modeloAplicaciones->ejecutarSqlNativo($consulta);
    }
    
    /**
     * Ejecuta una consulta(SQL) personalizada para obtener los datos de las
     * aplicaciones
     *
     * @return array|ResultSet
     */
    public function obtenerAplicacionesXArea($idArea, $tipoUsuario=null)
    {
        $busqueda = '';
        if($tipoUsuario!=null){
            if($tipoUsuario=='Interno' || $tipoUsuario=='Profesionales'){
                $busqueda = " '$tipoUsuario' = ANY (tipo_usuario) and ";
            }else if($tipoUsuario=='InternoProfesionales'){
                $busqueda = " 'Interno' = ANY (tipo_usuario) and 'Profesionales' = ANY (tipo_usuario) and ";
            }else if($tipoUsuario=='Externo'){
                $busqueda = " 'Externo' = ANY (tipo_usuario) and ";
            }else{
                $busqueda = '';
            }
        }else{
            $busqueda = '';
        }
        
        $consulta = "SELECT
                        *
                    FROM
                        g_programas.aplicaciones
                    WHERE
                    	'$idArea' = ANY (id_area) and
                        $busqueda
                        estado_aplicacion = 'activo';";
        
        return $this->modeloAplicaciones->ejecutarSqlNativo($consulta);
    }
}