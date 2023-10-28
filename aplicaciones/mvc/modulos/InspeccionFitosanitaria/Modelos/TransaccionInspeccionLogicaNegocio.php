<?php
 /**
 * Lógica del negocio de TransaccionInspeccionModelo
 *
 * Este archivo se complementa con el archivo TransaccionInspeccionControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-15
 * @uses    TransaccionInspeccionLogicaNegocio
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
  namespace Agrodb\InspeccionFitosanitaria\Modelos;
  
  use Agrodb\InspeccionFitosanitaria\Modelos\IModelo;
 
class TransaccionInspeccionLogicaNegocio implements IModelo 
{

	 private $modeloTransaccionInspeccion = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloTransaccionInspeccion = new TransaccionInspeccionModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new TransaccionInspeccionModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdTransaccionInspeccion() != null && $tablaModelo->getIdTransaccionInspeccion() > 0) {
		return $this->modeloTransaccionInspeccion->actualizar($datosBd, $tablaModelo->getIdTransaccionInspeccion());
		} else {
		unset($datosBd["id_transaccion_inspeccion"]);
		return $this->modeloTransaccionInspeccion->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloTransaccionInspeccion->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return TransaccionInspeccionModelo
	*/
	public function buscar($id)
	{
		return $this->modeloTransaccionInspeccion->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloTransaccionInspeccion->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloTransaccionInspeccion->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarTransaccionInspeccion()
	{
	$consulta = "SELECT * FROM ".$this->modeloTransaccionInspeccion->getEsquema().". transaccion_inspeccion";
		 return $this->modeloTransaccionInspeccion->ejecutarSqlNativo($consulta);
	}

}
