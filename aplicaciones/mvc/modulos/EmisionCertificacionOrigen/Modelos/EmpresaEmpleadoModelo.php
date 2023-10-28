<?php
 /**
 * Modelo EmpresaEmpleadoModelo
 *
 * Este archivo se complementa con el archivo   EmpresaEmpleadoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    EmpresaEmpleadoModelo
 * @package EmisionCertificacionOrigen
 * @subpackage Modelos
 */
  namespace Agrodb\EmisionCertificacionOrigen\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class EmpresaEmpleadoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idEmpresaEmpleado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idEmpleado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idEmpresa;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $estado;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaCreacion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaActualizacion;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_emision_certificacion_origen";

	/**
	* Nombre de la tabla: empresa_empleado
	* 
	 */
	Private $tabla="empresa_empleado";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_empresa_empleado";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_emision_certificacion_origen"."EmpresaEmpleado_id_empresa_empleado_seq'; 



	/**
	* Constructor
	* $datos - Puede ser los campos del formualario que deben considir con los campos de la tabla
	* @parámetro  array|null $datos
	* @retorna void
	 */
	public function __construct(array $datos = null)
	{
		if (is_array($datos)) 
		{
			$this->setOptions($datos);
		}
			$features = new \Zend\Db\TableGateway\Feature\SequenceFeature($this->clavePrimaria, $this->secuencial);
			parent::__construct($this->esquema,$this->tabla, $features);
	}

	/**
	* Permitir el acceso a la propiedad
	* 
	* @parámetro  string $name 
	* @parámetro  mixed $value 
	* @retorna void
	*/
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (!method_exists($this, $method)) 
	{
		throw new \Exception('Clase Modelo: EmpresaEmpleadoModelo. Propiedad especificada invalida: set'.$name);
	}
	$this->$method($value);
	}

	/**
	* Permitir el acceso a la propiedad
	* 
	* @parámetro  string $name 
	* @retorna mixed
	*/
	public function __get($name)
	{
	$method = 'get' . $name;
	if (!method_exists($this, $method))
	{
	  throw new \Exception('Clase Modelo: EmpresaEmpleadoModelo. Propiedad especificada invalida: get'.$name);
	}
	return $this->$method();
	}

	/**
	* Llena el modelo con datos
	* 
	* @parámetro  array $datos 
	* @retorna Modelo
	*/
	 public function setOptions(array $datos)
	{
	$methods = get_class_methods($this);
	foreach ($datos as $key => $value) 
	{
	$key_original = $key;
	 if (strpos($key, '_') > 0) {
	 $aux = preg_replace_callback(" /[-_]([a-z]+)/ ", function($string) {
	return ucfirst($string[1]);
	 }, ucwords($key));
	  $key = $aux;
	}
	$method = 'set' . ucfirst($key);
	if (in_array($method, $methods)) 
	{
	$this->$method($value);
	$this->campos[$key_original] = $key;
	}
	}
	return $this;
	}
	 /**
	 * Recupera los datos validados del modelo y lo retorna en un arreglo
	 *  
	 * @return Array  
	 */
	public function getPrepararDatos()
	 {
	 $claseArray = get_object_vars($this);
	   foreach ($this->campos as $key => $value) {
	 $this->campos[$key] = $claseArray[lcfirst($value)];
	}
	return $this->campos;
	 }

	/**
	* Set $esquema
	*
	* Nombre del esquema del módulo 
	*
	* @parámetro $esquema
	* @return Nombre del esquema de la base de datos
	*/
	public function setEsquema($esquema)
	{
	  $this->esquema = $esquema;
	    return $this;
	}

	/**
	* Get g_emision_certificacion_origen
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idEmpresaEmpleado
	*
	*
	*
	* @parámetro Integer $idEmpresaEmpleado
	* @return IdEmpresaEmpleado
	*/
	public function setIdEmpresaEmpleado($idEmpresaEmpleado)
	{
	  $this->idEmpresaEmpleado = (Integer) $idEmpresaEmpleado;
	    return $this;
	}

	/**
	* Get idEmpresaEmpleado
	*
	* @return null|Integer
	*/
	public function getIdEmpresaEmpleado()
	{
		return $this->idEmpresaEmpleado;
	}

	/**
	* Set idEmpleado
	*
	*
	*
	* @parámetro Integer $idEmpleado
	* @return IdEmpleado
	*/
	public function setIdEmpleado($idEmpleado)
	{
	  $this->idEmpleado = (Integer) $idEmpleado;
	    return $this;
	}

	/**
	* Get idEmpleado
	*
	* @return null|Integer
	*/
	public function getIdEmpleado()
	{
		return $this->idEmpleado;
	}

	/**
	* Set idEmpresa
	*
	*
	*
	* @parámetro Integer $idEmpresa
	* @return IdEmpresa
	*/
	public function setIdEmpresa($idEmpresa)
	{
	  $this->idEmpresa = (Integer) $idEmpresa;
	    return $this;
	}

	/**
	* Get idEmpresa
	*
	* @return null|Integer
	*/
	public function getIdEmpresa()
	{
		return $this->idEmpresa;
	}

	/**
	* Set estado
	*
	*
	*
	* @parámetro String $estado
	* @return Estado
	*/
	public function setEstado($estado)
	{
	  $this->estado = (String) $estado;
	    return $this;
	}

	/**
	* Get estado
	*
	* @return null|String
	*/
	public function getEstado()
	{
		return $this->estado;
	}

	/**
	* Set fechaCreacion
	*
	*
	*
	* @parámetro Date $fechaCreacion
	* @return FechaCreacion
	*/
	public function setFechaCreacion($fechaCreacion)
	{
	  $this->fechaCreacion = (String) $fechaCreacion;
	    return $this;
	}

	/**
	* Get fechaCreacion
	*
	* @return null|Date
	*/
	public function getFechaCreacion()
	{
		return $this->fechaCreacion;
	}

	/**
	* Set fechaActualizacion
	*
	*
	*
	* @parámetro Date $fechaActualizacion
	* @return FechaActualizacion
	*/
	public function setFechaActualizacion($fechaActualizacion)
	{
	  $this->fechaActualizacion = (String) $fechaActualizacion;
	    return $this;
	}

	/**
	* Get fechaActualizacion
	*
	* @return null|Date
	*/
	public function getFechaActualizacion()
	{
		return $this->fechaActualizacion;
	}

	/**
	* Guarda el registro actual
	* @param array $datos
	* @return int
	*/
	public function guardar(Array $datos)
	{
		return parent::guardar($datos);
	}

	/**
	* Actualiza un registro actual
	* @param array $datos
	* @param int $id
	* @return int
	*/
	public function actualizar(Array $datos,$id)
	{
		 return parent::actualizar($datos, $this->clavePrimaria . " = " . $id);
	}

	/**
	* Borra el registro actual
	* @param string Where|array $where
	* @return int
	*/
	public function borrar($id)
	{
		return parent::borrar($this->clavePrimaria . " = " . $id);
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
		return $this->setOptions(parent::buscar($this->clavePrimaria . " = " . $id));
		return $this;
	}

	/**
	* Busca todos los registros
	*
	* @return array|ResultSet
	*/
	public function buscarTodo()
	{
		return parent::buscarTodo();
	}

	/**
	* Busca una lista de acuerdo a los parámetros <params> enviados.
	*
	* @return array|ResultSet
	*/
	public function buscarLista($where=null, $order=null, $count=null, $offset=null)
	{
		return parent::buscarLista($where);
	}

	/**
	* Ejecuta una consulta(SQL) personalizada .
	*
	* @return array|ResultSet
	*/
	public function ejecutarConsulta($consulta)
	{
		 return parent::ejecutarConsulta($consulta);
	}

}
