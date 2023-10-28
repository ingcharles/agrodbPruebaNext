<?php
 /**
 * Lógica del negocio de ClasificacionProductoModelo
 *
 * Este archivo se complementa con el archivo ClasificacionProductoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-09-10
 * @uses    ClasificacionProductoLogicaNegocio
 * @package ModificacionProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\ModificacionProductoRia\Modelos;
  
  use Agrodb\ModificacionProductoRia\Modelos\IModelo;
 
class ClasificacionProductoLogicaNegocio implements IModelo 
{

	 private $modeloClasificacionProducto = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloClasificacionProducto = new ClasificacionProductoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new ClasificacionProductoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdClasificacionProducto() != null && $tablaModelo->getIdClasificacionProducto() > 0) {
		return $this->modeloClasificacionProducto->actualizar($datosBd, $tablaModelo->getIdClasificacionProducto());
		} else {
		unset($datosBd["id_clasificacion_producto"]);
		return $this->modeloClasificacionProducto->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloClasificacionProducto->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return ClasificacionProductoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloClasificacionProducto->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloClasificacionProducto->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloClasificacionProducto->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarClasificacionProducto()
	{
	$consulta = "SELECT * FROM ".$this->modeloClasificacionProducto->getEsquema().". clasificacion_producto";
		 return $this->modeloClasificacionProducto->ejecutarSqlNativo($consulta);
	}

}
