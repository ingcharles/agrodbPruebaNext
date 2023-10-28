<?php
 /**
 * Lógica del negocio de PublicoMetaModelo
 *
 * Este archivo se complementa con el archivo PublicoMetaControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    PublicoMetaLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\RegistroCapacitaciones\Modelos\IModelo;
 
class PublicoMetaLogicaNegocio implements IModelo 
{

	 private $modeloPublicoMeta = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloPublicoMeta = new PublicoMetaModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new PublicoMetaModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdPublicoMeta() != null && $tablaModelo->getIdPublicoMeta() > 0) {
		return $this->modeloPublicoMeta->actualizar($datosBd, $tablaModelo->getIdPublicoMeta());
		} else {
		unset($datosBd["id_publico_meta"]);
		return $this->modeloPublicoMeta->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloPublicoMeta->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return PublicoMetaModelo
	*/
	public function buscar($id)
	{
		return $this->modeloPublicoMeta->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloPublicoMeta->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloPublicoMeta->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarPublicoMeta()
	{
	$consulta = "SELECT * FROM ".$this->modeloPublicoMeta->getEsquema().". publico_meta";
		 return $this->modeloPublicoMeta->ejecutarSqlNativo($consulta);
	}

	public function obtenerPublicoMetaXCursoCapacitacion($id){
		$consulta = " SELECT pm.id_curso_impartido, pm.id_publico_meta, pm.nombre_publico  FROM g_administracion_capacitaciones.cursos_impartidos ci
		INNER JOIN g_administracion_capacitaciones.publico_meta pm	
		ON pm.id_curso_impartido = ci.id_curso_impartido
		WHERE ci.id_curso_impartido =$id";
		return $this->modeloPublicoMeta->ejecutarSqlNativo($consulta);
	}

	public function obtenerPublicoMetaXid($idPublicoObjetivo){
		$consulta = " SELECT pm.id_publico_meta,pm.id_publico_objetivo,pm.id_curso_impartido
		 			  FROM g_administracion_capacitaciones.publico_meta pm
					  WHERE pm.id_publico_objetivo = $idPublicoObjetivo";
		return $this->modeloPublicoMeta->ejecutarSqlNativo($consulta);
	}

}
