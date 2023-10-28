<?php
 /**
 * Lógica del negocio de TransitoDetalleProductosModelo
 *
 * Este archivo se complementa con el archivo TransitoDetalleProductosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-11-08
 * @uses    TransitoDetalleProductosLogicaNegocio
 * @package TransitoInternacional
 * @subpackage Modelos
 */
  namespace Agrodb\TransitoInternacional\Modelos;
  
  use Agrodb\TransitoInternacional\Modelos\IModelo;
 
class TransitoDetalleProductosLogicaNegocio implements IModelo 
{

	 private $modeloTransitoDetalleProductos = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloTransitoDetalleProductos = new TransitoDetalleProductosModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new TransitoDetalleProductosModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdTransitoDetalleProductos() != null && $tablaModelo->getIdTransitoDetalleProductos() > 0) {
		return $this->modeloTransitoDetalleProductos->actualizar($datosBd, $tablaModelo->getIdTransitoDetalleProductos());
		} else {
		unset($datosBd["id_transito_detalle_productos"]);
		return $this->modeloTransitoDetalleProductos->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloTransitoDetalleProductos->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return TransitoDetalleProductosModelo
	*/
	public function buscar($id)
	{
		return $this->modeloTransitoDetalleProductos->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloTransitoDetalleProductos->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloTransitoDetalleProductos->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarTransitoDetalleProductos()
	{
	$consulta = "SELECT * FROM ".$this->modeloTransitoDetalleProductos->getEsquema().". transito_detalle_productos";
		 return $this->modeloTransitoDetalleProductos->ejecutarSqlNativo($consulta);
	}

}
