<?php
 /**
 * Lógica del negocio de DistritosModelo
 *
 * Este archivo se complementa con el archivo DistritosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    DistritosLogicaNegocio
 * @package Financiero
 * @subpackage Modelos
 */
  namespace Agrodb\Financiero\Modelos;
  
  use Agrodb\Financiero\Modelos\IModelo;
 
class DistritosLogicaNegocio implements IModelo 
{

	 private $modeloDistritos = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloDistritos = new DistritosModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new DistritosModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getRuc() != null && $tablaModelo->getRuc() > 0) {
		return $this->modeloDistritos->actualizar($datosBd, $tablaModelo->getRuc());
		} else {
		unset($datosBd["ruc"]);
		return $this->modeloDistritos->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloDistritos->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return DistritosModelo
	*/
	public function buscar($id)
	{
		return $this->modeloDistritos->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloDistritos->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloDistritos->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarDistritos()
	{
	$consulta = "SELECT * FROM ".$this->modeloDistritos->getEsquema().". distritos";
		 return $this->modeloDistritos->ejecutarSqlNativo($consulta);
	}

}
