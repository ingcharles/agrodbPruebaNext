<?php
 /**
 * Modelo ActividadEnfermedadModelo
 *
 * Este archivo se complementa con el archivo   ActividadEnfermedadLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    ActividadEnfermedadModelo
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class ActividadEnfermedadModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idActividadEnfermedad;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idHistoriaClinica;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Se define el tipo para diferenciar entre actividades extras y enfermedad actual.
		*/
		protected $tipo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Se agregara la descripcion tanto de actividades extras o enfermedad actual.
		*/
		protected $descripcion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaCreacion;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_historias_clinicas";

	/**
	* Nombre de la tabla: actividad_enfermedad
	* 
	 */
	Private $tabla="actividad_enfermedad";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_actividad_enfermedad";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_historias_clinicas"."actividad_enfermedad_id_actividad_enfermedad_seq'; 



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
		throw new \Exception('Clase Modelo: ActividadEnfermedadModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: ActividadEnfermedadModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_historias_clinicas
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idActividadEnfermedad
	*
	*
	*
	* @parámetro Integer $idActividadEnfermedad
	* @return IdActividadEnfermedad
	*/
	public function setIdActividadEnfermedad($idActividadEnfermedad)
	{
	  $this->idActividadEnfermedad = (Integer) $idActividadEnfermedad;
	    return $this;
	}

	/**
	* Get idActividadEnfermedad
	*
	* @return null|Integer
	*/
	public function getIdActividadEnfermedad()
	{
		return $this->idActividadEnfermedad;
	}

	/**
	* Set idHistoriaClinica
	*
	*
	*
	* @parámetro Integer $idHistoriaClinica
	* @return IdHistoriaClinica
	*/
	public function setIdHistoriaClinica($idHistoriaClinica)
	{
	  $this->idHistoriaClinica = (Integer) $idHistoriaClinica;
	    return $this;
	}

	/**
	* Get idHistoriaClinica
	*
	* @return null|Integer
	*/
	public function getIdHistoriaClinica()
	{
		return $this->idHistoriaClinica;
	}

	/**
	* Set tipo
	*
	*Se define el tipo para diferenciar entre actividades extras y enfermedad actual.
	*
	* @parámetro String $tipo
	* @return Tipo
	*/
	public function setTipo($tipo)
	{
	  $this->tipo = (String) $tipo;
	    return $this;
	}

	/**
	* Get tipo
	*
	* @return null|String
	*/
	public function getTipo()
	{
		return $this->tipo;
	}

	/**
	* Set descripcion
	*
	*Se agregara la descripcion tanto de actividades extras o enfermedad actual.
	*
	* @parámetro String $descripcion
	* @return Descripcion
	*/
	public function setDescripcion($descripcion)
	{
	  $this->descripcion = (String) $descripcion;
	    return $this;
	}

	/**
	* Get descripcion
	*
	* @return null|String
	*/
	public function getDescripcion()
	{
		return $this->descripcion;
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
	* @return ActividadEnfermedadModelo
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
