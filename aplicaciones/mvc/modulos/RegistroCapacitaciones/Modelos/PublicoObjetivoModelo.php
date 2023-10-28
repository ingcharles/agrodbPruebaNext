<?php
 /**
 * Modelo PublicoObjetivoModelo
 *
 * Este archivo se complementa con el archivo   PublicoObjetivoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    PublicoObjetivoModelo
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class PublicoObjetivoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla publico objetivo
		*/
		protected $idPublicoObjetivo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacenara el nombre del publico objetivo
		*/
		protected $nombrePublico;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Estado del nombre campo que se inactivara cuando el administrador desactive el nombre siendo 1='activo' y 0='inactivo'
		*/
		protected $estado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla Cursos Capacitaciones
		*/
		protected $idCursoCapacitacion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla Catalogo Público
		*/
		protected $idCatalogoPublico;

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
	* Nombre de la tabla: publico_objetivo
	* 
	 */
	Private $tabla="publico_objetivo";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_publico_objetivo";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_administracion_capacitaciones"."publico_objetivo_id_publico_objetivo_seq'; 



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
		throw new \Exception('Clase Modelo: PublicoObjetivoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: PublicoObjetivoModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idPublicoObjetivo
	*
	*Identificador de la tabla publico objetivo
	*
	* @parámetro Integer $idPublicoObjetivo
	* @return IdPublicoObjetivo
	*/
	public function setIdPublicoObjetivo($idPublicoObjetivo)
	{
	  $this->idPublicoObjetivo = (Integer) $idPublicoObjetivo;
	    return $this;
	}

	/**
	* Get idPublicoObjetivo
	*
	* @return null|Integer
	*/
	public function getIdPublicoObjetivo()
	{
		return $this->idPublicoObjetivo;
	}

	/**
	* Set nombrePublico
	*
	*Campo que almacenara el nombre del publico objetivo
	*
	* @parámetro String $nombrePublico
	* @return NombrePublico
	*/
	public function setNombrePublico($nombrePublico)
	{
	  $this->nombrePublico = (String) $nombrePublico;
	    return $this;
	}

	/**
	* Get nombrePublico
	*
	* @return null|String
	*/
	public function getNombrePublico()
	{
		return $this->nombrePublico;
	}

	/**
	* Set estado
	*
	*Estado del nombre campo que se inactivara cuando el administrador desactive el nombre siendo 1='activo' y 0='inactivo'
	*
	* @parámetro Integer $estado
	* @return Estado
	*/
	public function setEstado($estado)
	{
	  $this->estado = (Integer) $estado;
	    return $this;
	}

	/**
	* Get estado
	*
	* @return null|Integer
	*/
	public function getEstado()
	{
		return $this->estado;
	}

	/**
	* Set idCursoCapacitacion
	*
	*Identificador de la tabla Cursos Capacitaciones
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
	* Set idCatalogoPublico
	*
	*Identificador de la tabla Catalogo Público
	*
	* @parámetro Integer $idCatalogoPublico
	* @return IdCatalogoPublico
	*/
	public function setIdCatalogoPublico($idCatalogoPublico)
	{
	  $this->idCatalogoPublico = (Integer) $idCatalogoPublico;
	    return $this;
	}

	/**
	* Get idCatalogoPublico
	*
	* @return null|Integer
	*/
	public function getIdCatalogoPublico()
	{
		return $this->idCatalogoPublico;
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
	* @return PublicoObjetivoModelo
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
