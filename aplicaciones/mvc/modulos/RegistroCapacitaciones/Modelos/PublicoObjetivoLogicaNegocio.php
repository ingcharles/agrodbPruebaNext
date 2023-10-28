<?php
 /**
 * Lógica del negocio de PublicoObjetivoModelo
 *
 * Este archivo se complementa con el archivo PublicoObjetivoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    PublicoObjetivoLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\RegistroCapacitaciones\Modelos\IModelo;
 
class PublicoObjetivoLogicaNegocio implements IModelo 
{

	 private $modeloPublicoObjetivo = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloPublicoObjetivo = new PublicoObjetivoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new PublicoObjetivoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdPublicoObjetivo() != null && $tablaModelo->getIdPublicoObjetivo() > 0) {
		return $this->modeloPublicoObjetivo->actualizar($datosBd, $tablaModelo->getIdPublicoObjetivo());
		} else {
		unset($datosBd["id_publico_objetivo"]);
		return $this->modeloPublicoObjetivo->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloPublicoObjetivo->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return PublicoObjetivoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloPublicoObjetivo->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloPublicoObjetivo->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloPublicoObjetivo->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarPublicoObjetivo()
	{
	$consulta = "SELECT * FROM ".$this->modeloPublicoObjetivo->getEsquema().". publico_objetivo";
		 return $this->modeloPublicoObjetivo->ejecutarSqlNativo($consulta);
	}

	public function obtenerPublicoObjetivoXCursoCapacitacion($idCursoCapacitacion){
		$consulta = "SELECT cc.id_curso_capacitacion, po.id_publico_objetivo, po.nombre_publico FROM g_administracion_capacitaciones.cursos_capacitaciones cc
					INNER JOIN g_administracion_capacitaciones.publico_objetivo po	
						ON po.id_curso_capacitacion = cc.id_curso_capacitacion
					WHERE cc.id_curso_capacitacion = $idCursoCapacitacion";
		return $this->modeloPublicoObjetivo->ejecutarSqlNativo($consulta);
	}


}
