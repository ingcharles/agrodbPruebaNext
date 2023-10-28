<?php
 /**
 * Lógica del negocio de UsosProductosPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo UsosProductosPlaguicidasBioControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    UsosProductosPlaguicidasBioLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\RegistroProductoRia\Modelos\IModelo;
 
class UsosProductosPlaguicidasBioLogicaNegocio implements IModelo 
{

	 private $modeloUsosProductosPlaguicidasBio = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloUsosProductosPlaguicidasBio = new UsosProductosPlaguicidasBioModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new UsosProductosPlaguicidasBioModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdUso() != null && $tablaModelo->getIdUso() > 0) {
		return $this->modeloUsosProductosPlaguicidasBio->actualizar($datosBd, $tablaModelo->getIdUso());
		} else {
		unset($datosBd["id_uso"]);
		return $this->modeloUsosProductosPlaguicidasBio->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloUsosProductosPlaguicidasBio->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return UsosProductosPlaguicidasBioModelo
	*/
	public function buscar($id)
	{
		return $this->modeloUsosProductosPlaguicidasBio->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloUsosProductosPlaguicidasBio->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloUsosProductosPlaguicidasBio->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarUsosProductosPlaguicidasBio()
	{
	$consulta = "SELECT * FROM ".$this->modeloUsosProductosPlaguicidasBio->getEsquema().". usos_productos_plaguicidas_bio";
		 return $this->modeloUsosProductosPlaguicidasBio->ejecutarSqlNativo($consulta);
	}

}
