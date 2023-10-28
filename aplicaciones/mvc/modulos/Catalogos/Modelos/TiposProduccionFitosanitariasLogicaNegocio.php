<?php
 /**
 * Lógica del negocio de TiposProduccionFitosanitariasModelo
 *
 * Este archivo se complementa con el archivo TiposProduccionFitosanitariasControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    TiposProduccionFitosanitariasLogicaNegocio
 * @package Catalogos
 * @subpackage Modelos
 */
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Catalogos\Modelos\IModelo;
 
class TiposProduccionFitosanitariasLogicaNegocio implements IModelo 
{

	 private $modeloTiposProduccionFitosanitarias = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloTiposProduccionFitosanitarias = new TiposProduccionFitosanitariasModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new TiposProduccionFitosanitariasModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdTipoProduccionFitosanitaria() != null && $tablaModelo->getIdTipoProduccionFitosanitaria() > 0) {
		return $this->modeloTiposProduccionFitosanitarias->actualizar($datosBd, $tablaModelo->getIdTipoProduccionFitosanitaria());
		} else {
		unset($datosBd["id_tipo_produccion_fitosanitaria"]);
		return $this->modeloTiposProduccionFitosanitarias->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloTiposProduccionFitosanitarias->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return TiposProduccionFitosanitariasModelo
	*/
	public function buscar($id)
	{
		return $this->modeloTiposProduccionFitosanitarias->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloTiposProduccionFitosanitarias->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloTiposProduccionFitosanitarias->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarTiposProduccionFitosanitarias()
	{
	$consulta = "SELECT * FROM ".$this->modeloTiposProduccionFitosanitarias->getEsquema().". tipos_produccion_fitosanitarias";
		 return $this->modeloTiposProduccionFitosanitarias->ejecutarSqlNativo($consulta);
	}

}
