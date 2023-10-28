<?php
 /**
 * Lógica del negocio de UnidadesFitosanitariasModelo
 *
 * Este archivo se complementa con el archivo UnidadesFitosanitariasControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    UnidadesFitosanitariasLogicaNegocio
 * @package Catalogos
 * @subpackage Modelos
 */
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Catalogos\Modelos\IModelo;
 
class UnidadesFitosanitariasLogicaNegocio implements IModelo 
{

	 private $modeloUnidadesFitosanitarias = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloUnidadesFitosanitarias = new UnidadesFitosanitariasModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new UnidadesFitosanitariasModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdUnidadFitosantaria() != null && $tablaModelo->getIdUnidadFitosantaria() > 0) {
		return $this->modeloUnidadesFitosanitarias->actualizar($datosBd, $tablaModelo->getIdUnidadFitosantaria());
		} else {
		unset($datosBd["id_unidad_fitosantaria"]);
		return $this->modeloUnidadesFitosanitarias->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloUnidadesFitosanitarias->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return UnidadesFitosanitariasModelo
	*/
	public function buscar($id)
	{
		return $this->modeloUnidadesFitosanitarias->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloUnidadesFitosanitarias->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloUnidadesFitosanitarias->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarUnidadesFitosanitarias()
	{
	$consulta = "SELECT * FROM ".$this->modeloUnidadesFitosanitarias->getEsquema().". unidades_fitosanitarias";
		 return $this->modeloUnidadesFitosanitarias->ejecutarSqlNativo($consulta);
	}

}
