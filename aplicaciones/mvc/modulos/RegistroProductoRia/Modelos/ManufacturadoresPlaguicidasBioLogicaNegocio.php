<?php
 /**
 * Lógica del negocio de ManufacturadoresPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo ManufacturadoresPlaguicidasBioControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    ManufacturadoresPlaguicidasBioLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\RegistroProductoRia\Modelos\IModelo;
 
class ManufacturadoresPlaguicidasBioLogicaNegocio implements IModelo 
{

	 private $modeloManufacturadoresPlaguicidasBio = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloManufacturadoresPlaguicidasBio = new ManufacturadoresPlaguicidasBioModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new ManufacturadoresPlaguicidasBioModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdManufacturador() != null && $tablaModelo->getIdManufacturador() > 0) {
		return $this->modeloManufacturadoresPlaguicidasBio->actualizar($datosBd, $tablaModelo->getIdManufacturador());
		} else {
		unset($datosBd["id_manufacturador"]);
		return $this->modeloManufacturadoresPlaguicidasBio->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloManufacturadoresPlaguicidasBio->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return ManufacturadoresPlaguicidasBioModelo
	*/
	public function buscar($id)
	{
		return $this->modeloManufacturadoresPlaguicidasBio->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloManufacturadoresPlaguicidasBio->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloManufacturadoresPlaguicidasBio->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarManufacturadoresPlaguicidasBio()
	{
	$consulta = "SELECT * FROM ".$this->modeloManufacturadoresPlaguicidasBio->getEsquema().". manufacturadores_plaguicidas_bio";
		 return $this->modeloManufacturadoresPlaguicidasBio->ejecutarSqlNativo($consulta);
	}

}
