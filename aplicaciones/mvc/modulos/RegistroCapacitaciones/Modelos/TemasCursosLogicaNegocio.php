<?php
 /**
 * Lógica del negocio de TemasCursosModelo
 *
 * Este archivo se complementa con el archivo TemasCursosControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    TemasCursosLogicaNegocio
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\RegistroCapacitaciones\Modelos\IModelo;
 
class TemasCursosLogicaNegocio implements IModelo 
{

	 private $modeloTemasCursos = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloTemasCursos = new TemasCursosModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new TemasCursosModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdTemaCurso() != null && $tablaModelo->getIdTemaCurso() > 0) {
		return $this->modeloTemasCursos->actualizar($datosBd, $tablaModelo->getIdTemaCurso());
		} else {
		unset($datosBd["id_tema_curso"]);
		return $this->modeloTemasCursos->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloTemasCursos->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return TemasCursosModelo
	*/
	public function buscar($id)
	{
		return $this->modeloTemasCursos->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloTemasCursos->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloTemasCursos->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarTemasCursos()
	{
	$consulta = "SELECT * FROM ".$this->modeloTemasCursos->getEsquema().". temas_cursos";
		 return $this->modeloTemasCursos->ejecutarSqlNativo($consulta);
	}

	public function obtenerTemasXCursoCapacitacion($id){
		$consulta = "SELECT cc.id_curso_capacitacion , tc.id_tema_curso ,tc.nombre_tema , cc.nombre_curso
						from g_administracion_capacitaciones.cursos_capacitaciones cc 
						INNER JOIN g_administracion_capacitaciones.temas_cursos tc 
								ON tc.id_curso_capacitacion = cc.id_curso_capacitacion 
						where cc.id_curso_capacitacion = $id";
		return $this->modeloTemasCursos->ejecutarSqlNativo($consulta);
	}

}
