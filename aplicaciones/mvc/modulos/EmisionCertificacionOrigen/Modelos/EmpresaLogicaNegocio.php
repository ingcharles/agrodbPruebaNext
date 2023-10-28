<?php
 /**
 * Lógica del negocio de EmpresaModelo
 *
 * Este archivo se complementa con el archivo EmpresaControlador.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    EmpresaLogicaNegocio
 * @package EmisionCertificacionOrigen
 * @subpackage Modelos
 */
  namespace Agrodb\EmisionCertificacionOrigen\Modelos;
  
  use Agrodb\EmisionCertificacionOrigen\Modelos\IModelo;
  use Agrodb\EmisionCertificacionOrigen\Modelos\EmpleadoModelo;
  use Agrodb\Core\Excepciones\GuardarExcepcion;
 
class EmpresaLogicaNegocio implements IModelo 
{

	 private $modeloEmpresa = null;
	 private $modeloEmpleado = null;


	/**
	* Constructor
	* 
	* @retorna void
	 */
	 public function __construct()
	{
	 $this->modeloEmpresa = new EmpresaModelo();
	 $this->modeloEmpleado = new EmpleadoModelo();
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		try{
	
			
			//insertar datos empresa
			if($datos['banderaEmpresa']){
				$tablaModelo = new EmpresaModelo($datos);
				$procesoIngreso = $this->modeloEmpresa->getAdapter()
					->getDriver()
					->getConnection();
				$procesoIngreso->beginTransaction();
				$datosBd = $tablaModelo->getPrepararDatos();
					unset($datosBd["id_empresa"]);
					$idEmpresa = $this->modeloEmpresa->guardar($datosBd);
				$procesoIngreso->commit();
			}else{
				$idEmpresa = $datos['idEmpresaObtenida'];
			}
				
			//insertar datos empleado
			if($datos['banderaEmpleado']){
				$tablaModelo = new EmpleadoModelo($datos);
				$procesoIngreso = $this->modeloEmpleado->getAdapter()
					->getDriver()
					->getConnection();
				$procesoIngreso->beginTransaction();
				$datosBd = $tablaModelo->getPrepararDatos();
					unset($datosBd["id_empleado"]);
					$idEmpleado = $this->modeloEmpleado->guardar($datosBd);
				$procesoIngreso->commit();
			
			}else{
				$idEmpleado = $datos['idEmpleadoObtenido'];
			}

			// //tabla empresa-empleados
			if(($datos['banderaEmpresaEmpleado'])){
			$statement = $this->modeloEmpresa->getAdapter()
				->getDriver()
				->createStatement();
			$arrayParametros = array(
				'id_empleado' => $idEmpleado,
				'id_empresa' => $idEmpresa,
				'estado' => "activo",
			);
			$sqlInsertar = $this->modeloEmpresa->guardarSql('empresa_empleado', $this->modeloEmpresa->getEsquema());
			$sqlInsertar->columns(array_keys($arrayParametros));
			$sqlInsertar->values($arrayParametros, $sqlInsertar::VALUES_MERGE);
			$sqlInsertar->prepareStatement($this->modeloEmpresa->getAdapter(), $statement);
			$statement->execute();
			
			}
				
		
		
		}catch (GuardarExcepcion $ex){
			$procesoIngreso->rollback();
			throw new \Exception($ex->getMessage());
		}
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		$this->modeloEmpresa->borrar($id);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return EmpresaModelo
	*/
	public function buscar($id)
	{
		return $this->modeloEmpresa->buscar($id);
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return $this->modeloEmpresa->buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return $this->modeloEmpresa->buscarLista($where, $order, $count, $offset);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function buscarEmpresa()
	{
	$consulta = "SELECT * FROM ".$this->modeloEmpresa->getEsquema().". empresa";
		 return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function obtenerDatosUsuario($arrayParametros){
		if (isset($arrayParametros['identificador']) && $arrayParametros['identificador'] !=""){
			$identificador = "'".$arrayParametros['identificador']."'";
		}else{
			$identificador = "NULL";
		}

		if (isset($arrayParametros['nombreEmpleado']) && $arrayParametros['nombreEmpleado'] !=""){
			$nombresEmpleado = "'%".$arrayParametros['nombreEmpleado']."%'";
		}else{
			$nombresEmpleado = "NULL";
		}
		
		$consulta = "SELECT
								opv.identificador
								,case when opv.razon_social = '' then opv.nombre_representante ||' '|| opv.apellido_representante else opv.razon_social end nombres
						FROM g_operadores.operadores opv
						WHERE
							($identificador is NULL or opv.identificador = $identificador)
							and ($nombresEmpleado is NULL or case when opv.razon_social = '' then coalesce(opv.nombre_representante ||' '|| opv.apellido_representante ) else opv.razon_social end ilike $nombresEmpleado)
						ORDER BY nombres ASC;";

		
		return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function buscarEmpresaRegistrada($identificadorEmpresa,$nombreEmpresa){
		$consulta = "SELECT * FROM g_emision_certificacion_origen.empresa
					WHERE identificador_empresa = '".$identificadorEmpresa."' and nombre_empresa ='".$nombreEmpresa."'";
		return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function buscarEmpleadoRegistrado($identificadorEmpleado,$nombreEmpleado,$idEmpleado){
		if (isset($idEmpleado) && $idEmpleado != ''){
			$busqueda = "INNER JOIN g_emision_certificacion_origen.empresa_empleado ep
				        ON ep.id_empleado = empl.id_empleado 
						WHERE empl.id_empleado = ".$idEmpleado." and ep.estado = 'activo'";
			$estado = ", ep.estado";
		}else{
			$busqueda = "WHERE empl.identificador_empleado = '".$identificadorEmpleado."' and empl.nombres_empleado ='".$nombreEmpleado."'";
			$estado = "";
		}
		$consulta = "SELECT empl.id_empleado, empl.nombres_empleado, empl.identificador_empleado".$estado."
						 FROM g_emision_certificacion_origen.empleado empl
					 $busqueda";
		return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function buscarEmpresaEmpleadoRegistrado($idEmpleado,$idEmpresa){
		if(isset($idEmpresa) && $idEmpresa != 'NULL' ){
			$busqueda = "and id_empresa =".$idEmpresa."";
		}else{
			$busqueda = " ";
		}
		$consulta = "SELECT * FROM g_emision_certificacion_origen.empresa_empleado
					WHERE id_empleado = ".$idEmpleado . " ".$busqueda." and estado = 'activo'";
		return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function buscarEmpleadosPorEmpresa($identificadorEmpresa)
	{
		$consulta = "SELECT emp.id_empresa, empl.id_empleado, CONCAT(substring(emp.nombre_empresa,0, 30) , '...') as nombre_empresa, empl.nombres_empleado, ep.estado 
				FROM g_emision_certificacion_origen.empresa emp
  					INNER JOIN g_emision_certificacion_origen.empresa_empleado ep
   					ON emp.id_empresa = ep.id_empresa
   					INNER JOIN  g_emision_certificacion_origen.empleado empl
   					ON empl.id_empleado = ep.id_empleado
  				WHERE emp.identificador_empresa = '".$identificadorEmpresa."' and ep.fecha_actualizacion is null ";
		 return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function cambiarEstadoEmpleado($arrayParametros)
	{
			$consulta = " UPDATE g_emision_certificacion_origen.empresa_empleado
							SET estado = 'inactivo', fecha_actualizacion = 'now()'
							WHERE id_empleado = " . $arrayParametros['idEmpleado'] . " and id_empresa = " . $arrayParametros['idEmpresa'] . ";";
			return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
			
				
	}

	public function buscarEmpresaPorEmpleado($identificadorEmpleado)
	{

		$consulta = "SELECT emp.identificador_empresa from g_emision_certificacion_origen.empleado empl
		INNER JOIN g_emision_certificacion_origen.empresa_empleado ep
		ON ep.id_empleado = empl.id_empleado
		INNER JOIN g_emision_certificacion_origen.empresa emp
		ON emp.id_empresa = ep.id_empresa
		WHERE empl.identificador_empleado = '".$identificadorEmpleado."' and estado = 'activo'";
		return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}


	public function registrarEmpleadoEmpresa($arrayParametros){
		$consulta=" INSERT INTO g_emision_certificacion_origen.empresa_empleado(
			 id_empleado, id_empresa,estado)
			VALUES (" . $arrayParametros['idEmpleado'] . "," . $arrayParametros['idEmpresa'] . ", 'activo');";
		return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function activarModulo($identificador_empleado){
			$consulta="INSERT INTO g_programas.aplicaciones_registradas(id_aplicacion, identificador, cantidad_notificacion, mensaje_notificacion) 
			SELECT  (select id_aplicacion from g_programas.aplicaciones where codificacion_aplicacion ='PRG_EMI_CERT_ORI'),'".$identificador_empleado."',0,'notificaciones' 
			WHERE NOT EXISTS 
			(SELECT identificador FROM g_programas.aplicaciones_registradas WHERE identificador = '".$identificador_empleado."' and id_aplicacion = (select id_aplicacion from g_programas.aplicaciones where codificacion_aplicacion ='PRG_EMI_CERT_ORI'));";
			return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function activarPerfil($identificador_empleado){
		$consulta="INSERT INTO g_usuario.usuarios_perfiles 
		SELECT  '".$identificador_empleado."',(SELECT id_perfil FROM g_usuario.perfiles WHERE codificacion_perfil = 'PFL_EMI_CERT_EMP')  
		WHERE NOT EXISTS 
		(SELECT identificador FROM  g_usuario.usuarios_perfiles WHERE identificador = '".$identificador_empleado."' and id_perfil =(SELECT id_perfil FROM g_usuario.perfiles WHERE codificacion_perfil = 'PFL_EMI_CERT_EMP'));";
		return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
	}

	public function eliminarModulo($identificador_empleado){
		$consulta="DELETE FROM g_programas.aplicaciones_registradas 
		WHERE id_aplicacion = (SELECT id_aplicacion FROM g_programas.aplicaciones WHERE codificacion_aplicacion='PRG_EMI_CERT_ORI') AND identificador = '".$identificador_empleado."';";
		return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
}

public function eliminarPerfil($identificador_empleado){
	$consulta="DELETE FROM g_usuario.usuarios_perfiles 
				WHERE identificador ='".$identificador_empleado."' AND id_perfil = (SELECT id_perfil FROM g_usuario.perfiles WHERE codificacion_perfil='PFL_EMI_CERT_EMP');";
	return $this->modeloEmpresa->ejecutarSqlNativo($consulta);
}


	//PRG_EMI_CERT_ORI
}
