<?php
 /**
 * Lógica del negocio de PublicoAsistenteModelo
 *
 * Este archivo se complementa con el archivo PublicoAsistenteControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    PublicoAsistenteLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\RegistroCapacitaciones\Modelos\IModelo;
 
class PublicoAsistenteLogicaNegocio implements IModelo 
{

	 private $modeloPublicoAsistente = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloPublicoAsistente = new PublicoAsistenteModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new PublicoAsistenteModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdPublicoAsistente() != null && $tablaModelo->getIdPublicoAsistente() > 0) {
		return $this->modeloPublicoAsistente->actualizar($datosBd, $tablaModelo->getIdPublicoAsistente());
		} else {
		unset($datosBd["id_publico_asistente"]);
		return $this->modeloPublicoAsistente->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloPublicoAsistente->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return PublicoAsistenteModelo
	*/
	public function buscar($id)
	{
		return $this->modeloPublicoAsistente->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloPublicoAsistente->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloPublicoAsistente->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarPublicoAsistente()
	{
	$consulta = "SELECT * FROM ".$this->modeloPublicoAsistente->getEsquema().". publico_asistente";
		 return $this->modeloPublicoAsistente->ejecutarSqlNativo($consulta);
	}
	
	public function obtenerPublicoAsistenteXIdCursoImpartido($idCursoImpartido){
	    $consulta = "SELECT id_publico_asistente, genero, cantidad, id_curso_impartido
	    FROM g_administracion_capacitaciones.publico_asistente
	    where id_curso_impartido= $idCursoImpartido";
		 return $this->modeloPublicoAsistente->ejecutarSqlNativo($consulta);
	}
}
