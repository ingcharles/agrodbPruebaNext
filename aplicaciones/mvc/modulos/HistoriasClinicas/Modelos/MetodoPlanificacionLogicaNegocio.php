<?php
 /**
 * Lógica del negocio de MetodoPlanificacionModelo
 *
 * Este archivo se complementa con el archivo MetodoPlanificacionControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    MetodoPlanificacionLogicaNegocio
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\HistoriasClinicas\Modelos\IModelo;
 
class MetodoPlanificacionLogicaNegocio implements IModelo 
{

	 private $modeloMetodoPlanificacion = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloMetodoPlanificacion = new MetodoPlanificacionModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new MetodoPlanificacionModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdMetodoPlanificacion() != null && $tablaModelo->getIdMetodoPlanificacion() > 0) {
		return $this->modeloMetodoPlanificacion->actualizar($datosBd, $tablaModelo->getIdMetodoPlanificacion());
		} else {
		unset($datosBd["id_metodo_planificacion"]);
		return $this->modeloMetodoPlanificacion->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloMetodoPlanificacion->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return MetodoPlanificacionModelo
	*/
	public function buscar($id)
	{
		return $this->modeloMetodoPlanificacion->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloMetodoPlanificacion->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloMetodoPlanificacion->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarMetodoPlanificacion()
	{
	$consulta = "SELECT * FROM ".$this->modeloMetodoPlanificacion->getEsquema().". metodo_planificacion";
		 return $this->modeloMetodoPlanificacion->ejecutarSqlNativo($consulta);
	}

}
