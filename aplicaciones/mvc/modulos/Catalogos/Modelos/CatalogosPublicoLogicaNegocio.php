<?php
 /**
 * Lógica del negocio de CatalogosPublicoModelo
 *
 * Este archivo se complementa con el archivo CatalogosPublicoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    CatalogosPublicoLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Catalogos\Modelos\IModelo;
 
class CatalogosPublicoLogicaNegocio implements IModelo 
{

	 private $modeloCatalogosPublico = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloCatalogosPublico = new CatalogosPublicoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new CatalogosPublicoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdCatalogoPublico() != null && $tablaModelo->getIdCatalogoPublico() > 0) {
		return $this->modeloCatalogosPublico->actualizar($datosBd, $tablaModelo->getIdCatalogoPublico());
		} else {
		unset($datosBd["id_catalogo_publico"]);
		return $this->modeloCatalogosPublico->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloCatalogosPublico->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return CatalogosPublicoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloCatalogosPublico->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloCatalogosPublico->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloCatalogosPublico->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarCatalogosPublico()
	{
	$consulta = "SELECT * FROM ".$this->modeloCatalogosPublico->getEsquema().". catalogos_publico";
		 return $this->modeloCatalogosPublico->ejecutarSqlNativo($consulta);
	}

	

}
