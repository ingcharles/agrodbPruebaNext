<?php
 /**
 * Modelo TemasEjecutadosModelo
 *
 * Este archivo se complementa con el archivo   TemasEjecutadosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    TemasEjecutadosModelo
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class TemasEjecutadosModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla temas ejecutados
		*/
		protected $idTemaEjecutado;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campos que almacena el nombre del tema registrdo
		*/
		protected $nombreTemasEjecutado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla cursos impartidos
		*/
		protected $idCursoImpartido;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idTemaCurso;

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
	* Nombre de la tabla: temas_ejecutados
	* 
	 */
	Private $tabla="temas_ejecutados";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_tema_ejecutado";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_administracion_capacitaciones"."TemasEjecutados_id_tema_ejecutado_seq'; 



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
		throw new \Exception('Clase Modelo: TemasEjecutadosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: TemasEjecutadosModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idTemaEjecutado
	*
	*Identificador de la tabla temas ejecutados
	*
	* @parámetro Integer $idTemaEjecutado
	* @return IdTemaEjecutado
	*/
	public function setIdTemaEjecutado($idTemaEjecutado)
	{
	  $this->idTemaEjecutado = (Integer) $idTemaEjecutado;
	    return $this;
	}

	/**
	* Get idTemaEjecutado
	*
	* @return null|Integer
	*/
	public function getIdTemaEjecutado()
	{
		return $this->idTemaEjecutado;
	}

	/**
	* Set nombreTemasEjecutado
	*
	*Campos que almacena el nombre del tema registrdo
	*
	* @parámetro String $nombreTemasEjecutado
	* @return NombreTemasEjecutado
	*/
	public function setNombreTemasEjecutado($nombreTemasEjecutado)
	{
	  $this->nombreTemasEjecutado = (String) $nombreTemasEjecutado;
	    return $this;
	}

	/**
	* Get nombreTemasEjecutado
	*
	* @return null|String
	*/
	public function getNombreTemasEjecutado()
	{
		return $this->nombreTemasEjecutado;
	}

	/**
	* Set idCursoImpartido
	*
	*Identificador de la tabla cursos impartidos
	*
	* @parámetro Integer $idCursoImpartido
	* @return IdCursoImpartido
	*/
	public function setIdCursoImpartido($idCursoImpartido)
	{
	  $this->idCursoImpartido = (Integer) $idCursoImpartido;
	    return $this;
	}

	/**
	* Get idCursoImpartido
	*
	* @return null|Integer
	*/
	public function getIdCursoImpartido()
	{
		return $this->idCursoImpartido;
	}

	/**
	* Set idTemaCurso
	*
	*
	*
	* @parámetro Integer $idTemaCurso
	* @return IdTemaCurso
	*/
	public function setIdTemaCurso($idTemaCurso)
	{
	  $this->idTemaCurso = (Integer) $idTemaCurso;
	    return $this;
	}

	/**
	* Get idTemaCurso
	*
	* @return null|Integer
	*/
	public function getIdTemaCurso()
	{
		return $this->idTemaCurso;
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
	* @return TemasEjecutadosModelo
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
