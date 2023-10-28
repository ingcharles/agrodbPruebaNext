<?php
 /**
 * Lógica del negocio de DetalleFactorRiesgoModelo
 *
 * Este archivo se complementa con el archivo DetalleFactorRiesgoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    DetalleFactorRiesgoLogicaNegocio
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\HistoriasClinicas\Modelos\IModelo;
 
class DetalleFactorRiesgoLogicaNegocio implements IModelo 
{

	 private $modeloDetalleFactorRiesgo = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloDetalleFactorRiesgo = new DetalleFactorRiesgoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new DetalleFactorRiesgoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdDetalleFactorRiesgo() != null && $tablaModelo->getIdDetalleFactorRiesgo() > 0) {
		return $this->modeloDetalleFactorRiesgo->actualizar($datosBd, $tablaModelo->getIdDetalleFactorRiesgo());
		} else {
		unset($datosBd["id_detalle_factor_riesgo"]);
		return $this->modeloDetalleFactorRiesgo->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloDetalleFactorRiesgo->borrar($id);
	}

	public function borrarPorParametro($param, $value){
		$this->modeloDetalleFactorRiesgo->borrarPorParametro($param, $value);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return DetalleFactorRiesgoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloDetalleFactorRiesgo->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloDetalleFactorRiesgo->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloDetalleFactorRiesgo->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarDetalleFactorRiesgo()
	{
	$consulta = "SELECT * FROM ".$this->modeloDetalleFactorRiesgo->getEsquema().". detalle_factor_riesgo";
		 return $this->modeloDetalleFactorRiesgo->ejecutarSqlNativo($consulta);
	}

	/**
	 * Columnas de la tabla g_historias_clinicas.detalle_factor_riesgo
	 *
	 * @return string
	 */
	public function columnas(){
		$columnas = array(
			'id_factor_riesgo',
			'id_subtipo_proced_medico');
		return $columnas;
	}

}
