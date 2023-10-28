<?php
 /**
 * Lógica del negocio de ResultadoOrganosModelo
 *
 * Este archivo se complementa con el archivo ResultadoOrganosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2019-05-27
 * @uses    ResultadoOrganosLogicaNegocio
 * @package InspeccionAntePostMortemCF
 * @subpackage Modelos
 */
  namespace Agrodb\InspeccionAntePostMortemCF\Modelos;
  
  use Agrodb\InspeccionAntePostMortemCF\Modelos\IModelo;
 
class ResultadoOrganosLogicaNegocio implements IModelo 
{

	 private $modeloResultadoOrganos = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloResultadoOrganos = new ResultadoOrganosModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new ResultadoOrganosModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdResultadoOrganos() != null && $tablaModelo->getIdResultadoOrganos() > 0) {
		return $this->modeloResultadoOrganos->actualizar($datosBd, $tablaModelo->getIdResultadoOrganos());
		} else {
		unset($datosBd["id_resultado_organos"]);
		return $this->modeloResultadoOrganos->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloResultadoOrganos->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return ResultadoOrganosModelo
	*/
	public function buscar($id)
	{
		return $this->modeloResultadoOrganos->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloResultadoOrganos->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloResultadoOrganos->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarResultadoOrganos()
	{
	$consulta = "SELECT * FROM ".$this->modeloResultadoOrganos->getEsquema().". resultado_organos";
		 return $this->modeloResultadoOrganos->ejecutarSqlNativo($consulta);
	}
	/**
	 * Columnas para guardar junto con el formulario
	 * @return string[]
	 */
	public function columnas()
	{
		$columnas = array(
			'id_detalle_post_animales',
			'organo_decomisado',
			'razon_decomiso',
			'num_organos_decomisados'
		);
		return $columnas;
	}

}
