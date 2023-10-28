<?php
 /**
 * Lógica del negocio de EmpleadoModelo
 *
 * Este archivo se complementa con el archivo EmpleadoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    EmpleadoLogicaNegocio
 * @package EmisionCertificacionOrigen
 * @subpackage Modelos
 */
  namespace Agrodb\EmisionCertificacionOrigen\Modelos;
  
  use Agrodb\EmisionCertificacionOrigen\Modelos\IModelo;
 
class EmpleadoLogicaNegocio implements IModelo 
{

	 private $modeloEmpleado = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloEmpleado = new EmpleadoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new EmpleadoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdEmpleado() != null && $tablaModelo->getIdEmpleado() > 0) {
		return $this->modeloEmpleado->actualizar($datosBd, $tablaModelo->getIdEmpleado());
		} else {
		unset($datosBd["id_empleado"]);
		return $this->modeloEmpleado->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloEmpleado->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return EmpleadoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloEmpleado->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloEmpleado->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloEmpleado->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarEmpleado()
	{
	$consulta = "SELECT * FROM ".$this->modeloEmpleado->getEsquema().". empleado";
		 return $this->modeloEmpleado->ejecutarSqlNativo($consulta);
	}

}
