<?php
 /**
 * Lógica del negocio de EnsayosEficaciaPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo EnsayosEficaciaPlaguicidasBioControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    EnsayosEficaciaPlaguicidasBioLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\RegistroProductoRia\Modelos\IModelo;
 
class EnsayosEficaciaPlaguicidasBioLogicaNegocio implements IModelo 
{

	 private $modeloEnsayosEficaciaPlaguicidasBio = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloEnsayosEficaciaPlaguicidasBio = new EnsayosEficaciaPlaguicidasBioModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new EnsayosEficaciaPlaguicidasBioModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdEnsayoEficacia() != null && $tablaModelo->getIdEnsayoEficacia() > 0) {
		return $this->modeloEnsayosEficaciaPlaguicidasBio->actualizar($datosBd, $tablaModelo->getIdEnsayoEficacia());
		} else {
		unset($datosBd["id_ensayo_eficacia"]);
		return $this->modeloEnsayosEficaciaPlaguicidasBio->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloEnsayosEficaciaPlaguicidasBio->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return EnsayosEficaciaPlaguicidasBioModelo
	*/
	public function buscar($id)
	{
		return $this->modeloEnsayosEficaciaPlaguicidasBio->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloEnsayosEficaciaPlaguicidasBio->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloEnsayosEficaciaPlaguicidasBio->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarEnsayosEficaciaPlaguicidasBio()
	{
	$consulta = "SELECT * FROM ".$this->modeloEnsayosEficaciaPlaguicidasBio->getEsquema().". ensayos_eficacia_plaguicidas_bio";
		 return $this->modeloEnsayosEficaciaPlaguicidasBio->ejecutarSqlNativo($consulta);
	}

}
