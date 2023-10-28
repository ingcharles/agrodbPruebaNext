<?php
 /**
 * Modelo TemasCursosModelo
 *
 * Este archivo se complementa con el archivo   TemasCursosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    TemasCursosModelo
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class TemasCursosModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla temas cursos
		*/
		protected $idTemaCurso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacenara el nombre del tema de la tabla temas cursos
		*/
		protected $nombreTema;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacenara el estado de la tabla temas cursos siendo 1="activo" y 0="inactivo"
		*/
		protected $estado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla Cursos Capacitaiones
		*/
		protected $idCursoCapacitacion;

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
	* Nombre de la tabla: temas_cursos
	* 
	 */
	Private $tabla="temas_cursos";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_tema_curso";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_administracion_capacitaciones"."temas_cursos_id_tema_curso_seq'; 



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
		throw new \Exception('Clase Modelo: TemasCursosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: TemasCursosModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idTemaCurso
	*
	*Identificador de la tabla temas cursos
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
	* Set nombreTema
	*
	*Campo que almacenara el nombre del tema de la tabla temas cursos
	*
	* @parámetro String $nombreTema
	* @return NombreTema
	*/
	public function setNombreTema($nombreTema)
	{
	  $this->nombreTema = (String) $nombreTema;
	    return $this;
	}

	/**
	* Get nombreTema
	*
	* @return null|String
	*/
	public function getNombreTema()
	{
		return $this->nombreTema;
	}

	/**
	* Set estado
	*
	*Campo que almacenara el estado de la tabla temas cursos siendo 1="activo" y 0="inactivo"
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
	*Identificador de la tabla Cursos Capacitaiones
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
	* @return TemasCursosModelo
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
