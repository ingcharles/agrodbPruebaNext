<?php
 /**
 * Lógica del negocio de PartidasArancelariasPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo PartidasArancelariasPlaguicidasBioControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    PartidasArancelariasPlaguicidasBioLogicaNegocio
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\RegistroProductoRia\Modelos\IModelo;
 
class PartidasArancelariasPlaguicidasBioLogicaNegocio implements IModelo 
{

	 private $modeloPartidasArancelariasPlaguicidasBio = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloPartidasArancelariasPlaguicidasBio = new PartidasArancelariasPlaguicidasBioModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new PartidasArancelariasPlaguicidasBioModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdPartidaArancelaria() != null && $tablaModelo->getIdPartidaArancelaria() > 0) {
		return $this->modeloPartidasArancelariasPlaguicidasBio->actualizar($datosBd, $tablaModelo->getIdPartidaArancelaria());
		} else {
		unset($datosBd["id_partida_arancelaria"]);
		return $this->modeloPartidasArancelariasPlaguicidasBio->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloPartidasArancelariasPlaguicidasBio->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return PartidasArancelariasPlaguicidasBioModelo
	*/
	public function buscar($id)
	{
		return $this->modeloPartidasArancelariasPlaguicidasBio->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloPartidasArancelariasPlaguicidasBio->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloPartidasArancelariasPlaguicidasBio->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarPartidasArancelariasPlaguicidasBio()
	{
	$consulta = "SELECT * FROM ".$this->modeloPartidasArancelariasPlaguicidasBio->getEsquema().". partidas_arancelarias_plaguicidas_bio";
		 return $this->modeloPartidasArancelariasPlaguicidasBio->ejecutarSqlNativo($consulta);
	}

}
