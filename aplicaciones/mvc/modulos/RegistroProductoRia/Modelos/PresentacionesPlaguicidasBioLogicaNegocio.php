<?php
 /**
 * Lógica del negocio de PresentacionesPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo PresentacionesPlaguicidasBioControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    PresentacionesPlaguicidasBioLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\RegistroProductoRia\Modelos\IModelo;
 
class PresentacionesPlaguicidasBioLogicaNegocio implements IModelo 
{

	 private $modeloPresentacionesPlaguicidasBio = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloPresentacionesPlaguicidasBio = new PresentacionesPlaguicidasBioModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new PresentacionesPlaguicidasBioModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdPresentacion() != null && $tablaModelo->getIdPresentacion() > 0) {
		return $this->modeloPresentacionesPlaguicidasBio->actualizar($datosBd, $tablaModelo->getIdPresentacion());
		} else {
		unset($datosBd["id_presentacion"]);
		return $this->modeloPresentacionesPlaguicidasBio->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloPresentacionesPlaguicidasBio->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return PresentacionesPlaguicidasBioModelo
	*/
	public function buscar($id)
	{
		return $this->modeloPresentacionesPlaguicidasBio->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloPresentacionesPlaguicidasBio->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloPresentacionesPlaguicidasBio->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarPresentacionesPlaguicidasBio()
	{
	$consulta = "SELECT * FROM ".$this->modeloPresentacionesPlaguicidasBio->getEsquema().". presentaciones_plaguicidas_bio";
		 return $this->modeloPresentacionesPlaguicidasBio->ejecutarSqlNativo($consulta);
	}

}
