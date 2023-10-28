<?php
 /**
 * Lógica del negocio de CategoriaSubtipoProcedimientoModelo
 *
 * Este archivo se complementa con el archivo CategoriaSubtipoProcedimientoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    CategoriaSubtipoProcedimientoLogicaNegocio
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\HistoriasClinicas\Modelos\IModelo;
 
class CategoriaSubtipoProcedimientoLogicaNegocio implements IModelo 
{

	 private $modeloCategoriaSubtipoProcedimiento = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloCategoriaSubtipoProcedimiento = new CategoriaSubtipoProcedimientoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new CategoriaSubtipoProcedimientoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdCategoriaSubtipoProcedimiento() != null && $tablaModelo->getIdCategoriaSubtipoProcedimiento() > 0) {
		return $this->modeloCategoriaSubtipoProcedimiento->actualizar($datosBd, $tablaModelo->getIdCategoriaSubtipoProcedimiento());
		} else {
		unset($datosBd["id_categoria_subtipo_procedimiento"]);
		return $this->modeloCategoriaSubtipoProcedimiento->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloCategoriaSubtipoProcedimiento->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return CategoriaSubtipoProcedimientoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloCategoriaSubtipoProcedimiento->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloCategoriaSubtipoProcedimiento->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloCategoriaSubtipoProcedimiento->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarCategoriaSubtipoProcedimiento()
	{
	$consulta = "SELECT * FROM ".$this->modeloCategoriaSubtipoProcedimiento->getEsquema().". categoria_subtipo_procedimiento";
		 return $this->modeloCategoriaSubtipoProcedimiento->ejecutarSqlNativo($consulta);
	}

}
