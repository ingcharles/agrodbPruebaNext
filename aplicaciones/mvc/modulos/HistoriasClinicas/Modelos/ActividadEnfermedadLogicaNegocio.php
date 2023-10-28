<?php
 /**
 * Lógica del negocio de ActividadEnfermedadModelo
 *
 * Este archivo se complementa con el archivo ActividadEnfermedadControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    ActividadEnfermedadLogicaNegocio
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\HistoriasClinicas\Modelos\IModelo;
 
class ActividadEnfermedadLogicaNegocio implements IModelo 
{

	 private $modeloActividadEnfermedad = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloActividadEnfermedad = new ActividadEnfermedadModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new ActividadEnfermedadModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdActividadEnfermedad() != null && $tablaModelo->getIdActividadEnfermedad() > 0) {
		return $this->modeloActividadEnfermedad->actualizar($datosBd, $tablaModelo->getIdActividadEnfermedad());
		} else {
		unset($datosBd["id_actividad_enfermedad"]);
		return $this->modeloActividadEnfermedad->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloActividadEnfermedad->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return ActividadEnfermedadModelo
	*/
	public function buscar($id)
	{
		return $this->modeloActividadEnfermedad->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloActividadEnfermedad->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloActividadEnfermedad->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarActividadEnfermedad()
	{
	$consulta = "SELECT * FROM ".$this->modeloActividadEnfermedad->getEsquema().". actividad_enfermedad";
		 return $this->modeloActividadEnfermedad->ejecutarSqlNativo($consulta);
	}

}
