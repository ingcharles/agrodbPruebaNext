<?php
 /**
 * Lógica del negocio de CapacitadoresModelo
 *
 * Este archivo se complementa con el archivo CapacitadoresControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    CapacitadoresLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\RegistroCapacitaciones\Modelos\IModelo;
 
class CapacitadoresLogicaNegocio implements IModelo 
{

	 private $modeloCapacitadores = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloCapacitadores = new CapacitadoresModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new CapacitadoresModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdCapacitador() != null && $tablaModelo->getIdCapacitador() > 0) {
		return $this->modeloCapacitadores->actualizar($datosBd, $tablaModelo->getIdCapacitador());
		} else {
		unset($datosBd["id_capacitador"]);
		return $this->modeloCapacitadores->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloCapacitadores->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return CapacitadoresModelo
	*/
	public function buscar($id)
	{
		return $this->modeloCapacitadores->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloCapacitadores->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloCapacitadores->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarCapacitadores()
	{
	$consulta = "SELECT * FROM ".$this->modeloCapacitadores->getEsquema().". capacitadores";
		 return $this->modeloCapacitadores->ejecutarSqlNativo($consulta);
	}

	public function obtenerCapacitadoresXIdCursoImpartido($idCursoImpartido){
	   $consulta = "SELECT
	   					nombre_capacitador
						,nombre_provincia
						,nombre_pais
						,tipo_capacitador
					FROM g_administracion_capacitaciones.capacitadores
					WHERE id_curso_impartido = $idCursoImpartido";
		 return $this->modeloCapacitadores->ejecutarSqlNativo($consulta);
	}

}
