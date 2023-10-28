<?php
 /**
 * Lógica del negocio de AditivoToxicologicoModelo
 *
 * Este archivo se complementa con el archivo AditivoToxicologicoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    AditivoToxicologicoLogicaNegocio
 * @package Catalogos
 * @subpackage Modelos
 */
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Catalogos\Modelos\IModelo;
 
class AditivoToxicologicoLogicaNegocio implements IModelo 
{

	 private $modeloAditivoToxicologico = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloAditivoToxicologico = new AditivoToxicologicoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new AditivoToxicologicoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdAditivoToxicologico() != null && $tablaModelo->getIdAditivoToxicologico() > 0) {
		return $this->modeloAditivoToxicologico->actualizar($datosBd, $tablaModelo->getIdAditivoToxicologico());
		} else {
		unset($datosBd["id_aditivo_toxicologico"]);
		return $this->modeloAditivoToxicologico->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloAditivoToxicologico->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return AditivoToxicologicoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloAditivoToxicologico->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloAditivoToxicologico->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloAditivoToxicologico->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarAditivoToxicologico()
	{
	$consulta = "SELECT * FROM ".$this->modeloAditivoToxicologico->getEsquema().". aditivo_toxicologico";
		 return $this->modeloAditivoToxicologico->ejecutarSqlNativo($consulta);
	}

}
