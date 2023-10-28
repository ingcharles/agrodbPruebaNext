<?php
 /**
 * Lógica del negocio de ExamenRealizadoModelo
 *
 * Este archivo se complementa con el archivo ExamenRealizadoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    ExamenRealizadoLogicaNegocio
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\HistoriasClinicas\Modelos\IModelo;
 
class ExamenRealizadoLogicaNegocio implements IModelo 
{

	 private $modeloExamenRealizado = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloExamenRealizado = new ExamenRealizadoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new ExamenRealizadoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdExamenRealizado() != null && $tablaModelo->getIdExamenRealizado() > 0) {
		return $this->modeloExamenRealizado->actualizar($datosBd, $tablaModelo->getIdExamenRealizado());
		} else {
		unset($datosBd["id_examen_realizado"]);
		return $this->modeloExamenRealizado->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloExamenRealizado->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return ExamenRealizadoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloExamenRealizado->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloExamenRealizado->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloExamenRealizado->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarExamenRealizado()
	{
	$consulta = "SELECT * FROM ".$this->modeloExamenRealizado->getEsquema().". examen_realizado";
		 return $this->modeloExamenRealizado->ejecutarSqlNativo($consulta);
	}

}
