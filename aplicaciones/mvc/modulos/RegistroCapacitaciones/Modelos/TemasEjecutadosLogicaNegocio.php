<?php
 /**
 * Lógica del negocio de TemasEjecutadosModelo
 *
 * Este archivo se complementa con el archivo TemasEjecutadosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    TemasEjecutadosLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\RegistroCapacitaciones\Modelos\IModelo;
 
class TemasEjecutadosLogicaNegocio implements IModelo 
{

	 private $modeloTemasEjecutados = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloTemasEjecutados = new TemasEjecutadosModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new TemasEjecutadosModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdTemaEjecutado() != null && $tablaModelo->getIdTemaEjecutado() > 0) {
		return $this->modeloTemasEjecutados->actualizar($datosBd, $tablaModelo->getIdTemaEjecutado());
		} else {
		unset($datosBd["id_tema_ejecutado"]);
		return $this->modeloTemasEjecutados->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloTemasEjecutados->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return TemasEjecutadosModelo
	*/
	public function buscar($id)
	{
		return $this->modeloTemasEjecutados->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloTemasEjecutados->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloTemasEjecutados->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarTemasEjecutados()
	{
	$consulta = "SELECT * FROM ".$this->modeloTemasEjecutados->getEsquema().". temas_ejecutados";
		 return $this->modeloTemasEjecutados->ejecutarSqlNativo($consulta);
	}

	
	public function obtenerTemasEjecutadosXCursoCapacitacion($id){
		$consulta = " SELECT te.nombre_temas_ejecutado, te.id_curso_impartido 
		 FROM g_administracion_capacitaciones.temas_ejecutados te
		WHERE te.id_curso_impartido = $id";
		return $this->modeloTemasEjecutados->ejecutarSqlNativo($consulta);
	}

	public function obtenerTemasEjecutadosXid($idTemaCurso){
		$consulta = " SELECT te.nombre_temas_ejecutado, te.id_curso_impartido 
		 FROM g_administracion_capacitaciones.temas_ejecutados te
		WHERE te.id_tema_curso = $idTemaCurso";
		return $this->modeloTemasEjecutados->ejecutarSqlNativo($consulta);
	}

}
