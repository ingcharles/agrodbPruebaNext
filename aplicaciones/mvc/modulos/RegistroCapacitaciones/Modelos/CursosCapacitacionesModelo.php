<?php
 /**
 * Modelo CursosCapacitacionesModelo
 *
 * Este archivo se complementa con el archivo   CursosCapacitacionesLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    CursosCapacitacionesModelo
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class CursosCapacitacionesModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla cursos capacitaciones
		*/
		protected $idCursoCapacitacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que alamacenara el nombre del curso de pacacitacion
		*/
		protected $nombreCurso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla catastro
		*/
		protected $identificador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de la creación del registro de capacitación
		*/
		protected $fechaCreacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $normativa;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla area
		*/
		protected $idCoordinacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla area
		*/
		protected $idDireccion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla area
		*/
		protected $idArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el objetivo de la capacitacion registrada
		*/
		protected $objetivo;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_administracion_capacitaciones";

	/**
	* Nombre de la tabla: cursos_capacitaciones
	* 
	 */
	Private $tabla="cursos_capacitaciones";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_curso_capacitacion";



	/**
	*Secuencia                                                     
*/                              
		 private $secuencial = 'g_administracion_capacitaciones"."cursos_capacitaciones_id_curso_capacitacion_seq'; 




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
		throw new \Exception('Clase Modelo: CursosCapacitacionesModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: CursosCapacitacionesModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_administracion_capacitaciones
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idCursoCapacitacion
	*
	*Identificador de la tabla cursos capacitaciones
	*
	* @parámetro Integer $idCursoCapacitacion
	* @return IdCursoCapacitacion
	*/
	public function setIdCursoCapacitacion($idCursoCapacitacion)
	{
	  $this->idCursoCapacitacion = (Integer) $idCursoCapacitacion;
	    return $this;
	}

	/**
	* Get idCursoCapacitacion
	*
	* @return null|Integer
	*/
	public function getIdCursoCapacitacion()
	{
		return $this->idCursoCapacitacion;
	}

	/**
	* Set nombreCurso
	*
	*Campo que alamacenara el nombre del curso de pacacitacion
	*
	* @parámetro String $nombreCurso
	* @return NombreCurso
	*/
	public function setNombreCurso($nombreCurso)
	{
	  $this->nombreCurso = (String) $nombreCurso;
	    return $this;
	}

	/**
	* Get nombreCurso
	*
	* @return null|String
	*/
	public function getNombreCurso()
	{
		return $this->nombreCurso;
	}

	/**
	* Set identificador
	*
	*Identificador de la tabla catastro
	*
	* @parámetro String $identificador
	* @return Identificador
	*/
	public function setIdentificador($identificador)
	{
	  $this->identificador = (String) $identificador;
	    return $this;
	}

	/**
	* Get identificador
	*
	* @return null|String
	*/
	public function getIdentificador()
	{
		return $this->identificador;
	}

	/**
	* Set fechaCreacion
	*
	*Fecha de la creación del registro de capacitación
	*
	* @parámetro String $fechaCreacion
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
	* @return null|String
	*/
	public function getFechaCreacion()
	{
		return $this->fechaCreacion;
	}

	/**
	* Set normativa
	*
	*
	*
	* @parámetro String $normativa
	* @return Normativa
	*/
	public function setNormativa($normativa)
	{
	  $this->normativa = (String) $normativa;
	    return $this;
	}

	/**
	* Get normativa
	*
	* @return null|String
	*/
	public function getNormativa()
	{
		return $this->normativa;
	}

	/**
	* Set idCoordinacion
	*
	*Identificador de la tabla area
	*
	* @parámetro String $idCoordinacion
	* @return IdCoordinacion
	*/
	public function setIdCoordinacion($idCoordinacion)
	{
	  $this->idCoordinacion = (String) $idCoordinacion;
	    return $this;
	}

	/**
	* Get idCoordinacion
	*
	* @return null|String
	*/
	public function getIdCoordinacion()
	{
		return $this->idCoordinacion;
	}

	/**
	* Set idDireccion
	*
	*Identificador de la tabla area
	*
	* @parámetro String $idDireccion
	* @return IdDireccion
	*/
	public function setIdDireccion($idDireccion)
	{
	  $this->idDireccion = (String) $idDireccion;
	    return $this;
	}

	/**
	* Get idDireccion
	*
	* @return null|String
	*/
	public function getIdDireccion()
	{
		return $this->idDireccion;
	}

	/**
	* Set idArea
	*
	*Identificador de la tabla area
	*
	* @parámetro String $idArea
	* @return IdArea
	*/
	public function setIdArea($idArea)
	{
	  $this->idArea = (String) $idArea;
	    return $this;
	}

	/**
	* Get idArea
	*
	* @return null|String
	*/
	public function getIdArea()
	{
		return $this->idArea;
	}

	/**
	* Set objetivo
	*
	*Campo que almacena el objetivo de la capacitacion registrada
	*
	* @parámetro String $objetivo
	* @return Objetivo
	*/
	public function setObjetivo($objetivo)
	{
	  $this->objetivo = (String) $objetivo;
	    return $this;
	}

	/**
	* Get objetivo
	*
	* @return null|String
	*/
	public function getObjetivo()
	{
		return $this->objetivo;
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
	* @return CursosCapacitacionesModelo
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
