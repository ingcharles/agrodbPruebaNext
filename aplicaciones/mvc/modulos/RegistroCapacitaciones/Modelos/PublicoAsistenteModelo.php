<?php
 /**
 * Modelo PublicoAsistenteModelo
 *
 * Este archivo se complementa con el archivo   PublicoAsistenteLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    PublicoAsistenteModelo
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class PublicoAsistenteModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla publico asistente
		*/
		protected $idPublicoAsistente;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el genero de un publico registrado
		*/
		protected $genero;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad de un publico registrado
		*/
		protected $cantidad;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla cursos Impartidos
		*/
		protected $idCursoImpartido;

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
	* Nombre de la tabla: publico_asistente
	* 
	 */
	Private $tabla="publico_asistente";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_publico_asistente";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_administracion_capacitaciones"."PublicoAsistente_id_publico_asistente_seq'; 



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
		throw new \Exception('Clase Modelo: PublicoAsistenteModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: PublicoAsistenteModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idPublicoAsistente
	*
	*Identificador de la tabla publico asistente
	*
	* @parámetro Integer $idPublicoAsistente
	* @return IdPublicoAsistente
	*/
	public function setIdPublicoAsistente($idPublicoAsistente)
	{
	  $this->idPublicoAsistente = (Integer) $idPublicoAsistente;
	    return $this;
	}

	/**
	* Get idPublicoAsistente
	*
	* @return null|Integer
	*/
	public function getIdPublicoAsistente()
	{
		return $this->idPublicoAsistente;
	}

	/**
	* Set genero
	*
	*Campo que almacena el genero de un publico registrado
	*
	* @parámetro String $genero
	* @return Genero
	*/
	public function setGenero($genero)
	{
	  $this->genero = (String) $genero;
	    return $this;
	}

	/**
	* Get genero
	*
	* @return null|String
	*/
	public function getGenero()
	{
		return $this->genero;
	}

	/**
	* Set cantidad
	*
	*Campo que almacena la cantidad de un publico registrado
	*
	* @parámetro Integer $cantidad
	* @return Cantidad
	*/
	public function setCantidad($cantidad)
	{
	  $this->cantidad = (Integer) $cantidad;
	    return $this;
	}

	/**
	* Get cantidad
	*
	* @return null|Integer
	*/
	public function getCantidad()
	{
		return $this->cantidad;
	}

	/**
	* Set idCursoImpartido
	*
	*Identificador de la tabla cursos Impartidos
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
	* @return PublicoAsistenteModelo
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
