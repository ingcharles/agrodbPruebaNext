<?php
 /**
 * Lógica del negocio de EmpresaEmpleadoModelo
 *
 * Este archivo se complementa con el archivo EmpresaEmpleadoControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    EmpresaEmpleadoLogicaNegocio
 * @package EmisionCertificacionOrigen
 * @subpackage Modelos
 */
  namespace Agrodb\EmisionCertificacionOrigen\Modelos;
  
  use Agrodb\EmisionCertificacionOrigen\Modelos\IModelo;
 
class EmpresaEmpleadoLogicaNegocio implements IModelo 
{

	 private $modeloEmpresaEmpleado = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloEmpresaEmpleado = new EmpresaEmpleadoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		$tablaModelo = new EmpresaEmpleadoModelo($datos);
		$datosBd = $tablaModelo->getPrepararDatos();
		if ($tablaModelo->getIdEmpresaEmpleado() != null && $tablaModelo->getIdEmpresaEmpleado() > 0) {
		return $this->modeloEmpresaEmpleado->actualizar($datosBd, $tablaModelo->getIdEmpresaEmpleado());
		} else {
		unset($datosBd["id_empresa_empleado"]);
		return $this->modeloEmpresaEmpleado->guardar($datosBd);
	}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloEmpresaEmpleado->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return EmpresaEmpleadoModelo
	*/
	public function buscar($id)
	{
		return $this->modeloEmpresaEmpleado->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloEmpresaEmpleado->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloEmpresaEmpleado->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarEmpresaEmpleado()
	{
	$consulta = "SELECT * FROM ".$this->modeloEmpresaEmpleado->getEsquema().". empresa_empleado";
		 return $this->modeloEmpresaEmpleado->ejecutarSqlNativo($consulta);
	}

	public function listarEmpleadosCentroFaenamiento($arrayParametros)
	{
		$condicion = '';

		if ($arrayParametros['identificador'] !=''){
			$condicion = "WHERE empl.identificador_empleado = '".$arrayParametros['identificador']. "'";
		}
		if ($arrayParametros['nombre_empleado'] !='' || $arrayParametros['apellido_empleado'] !=''){
			$condicion .="AND (empl.nombres_empleado) ilike ('%".$arrayParametros['nombre_empleado']." ".$arrayParametros['apellido_empleado']."%') ";
		}
	    
	    $consulta = "SELECT * FROM g_emision_certificacion_origen.empresa_empleado emp_empl
					INNER JOIN g_emision_certificacion_origen.empresa emp
					ON emp_empl.id_empresa = emp.id_empresa
					INNER JOIN g_emision_certificacion_origen.empleado empl
					ON empl.id_empleado = emp_empl.id_empleado $condicion";
	    return $this->modeloEmpresaEmpleado->ejecutarSqlNativo($consulta);
	}

}
