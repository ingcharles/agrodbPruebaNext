<?php
 /**
 * Lógica del negocio de RedistribucionCuvModelo
 *
 * Este archivo se complementa con el archivo RedistribucionCuvControlador.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    RedistribucionCuvLogicaNegocio
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\AsignacionCuv\Modelos\IModelo;
 
class RedistribucionCuvLogicaNegocio implements IModelo 
{

	 private $modeloRedistribucionCuv = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloRedistribucionCuv = new RedistribucionCuvModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new RedistribucionCuvModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdRedistribucionCuv() != null && $tablaModelo->getIdRedistribucionCuv() > 0) {
		return $this->modeloRedistribucionCuv->actualizar($datosBd, $tablaModelo->getIdRedistribucionCuv());
		} else {
		unset($datosBd["id_redistribucion_cuv"]);
		return $this->modeloRedistribucionCuv->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloRedistribucionCuv->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return RedistribucionCuvModelo
	*/
	public function buscar($id)
	{
		return $this->modeloRedistribucionCuv->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloRedistribucionCuv->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloRedistribucionCuv->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarRedistribucionCuv()
	{
	$consulta = "SELECT * FROM ".$this->modeloRedistribucionCuv->getEsquema().". redistribucion_cuv";
		 return $this->modeloRedistribucionCuv->ejecutarSqlNativo($consulta);
	}

	public function buscarRedistribucionPoridSolicitud($id)
	{
		$consulta = "SELECT 
		* 
	FROM 
		g_asignacion_cuv.redistribucion_cuv redCuv
	WHERE 
		redCuv.id_solicitud_redistribucion_cuv = '{$id}' 
	AND redCuv.estado = '1';";
	$result = $this->modeloRedistribucionCuv->ejecutarConsulta($consulta);
	// Utilizar fetch para obtener el primer objeto
	return $result->current();
	}
	public function buscarRedistribucionPoridSolicitudNativo($id)
	{
		$consulta = "SELECT 
		* 
	FROM 
		g_asignacion_cuv.redistribucion_cuv redCuv
	WHERE 
		redCuv.id_solicitud_redistribucion_cuv = '{$id}' 
	AND redCuv.estado = '1';";
	return $this->modeloRedistribucionCuv->ejecutarSqlNativo($consulta);
	}

}
