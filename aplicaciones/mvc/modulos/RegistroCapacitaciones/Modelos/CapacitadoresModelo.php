<?php
 /**
 * Modelo CapacitadoresModelo
 *
 * Este archivo se complementa con el archivo   CapacitadoresLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    CapacitadoresModelo
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class CapacitadoresModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* identificador de la tabla capacitadores
		*/
		protected $idCapacitador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* campo que amacenarael identificador del capacitador registrago
		*/
		protected $identificadorCapacitador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* campo que almacenara lso nombres del capacitador
		*/
		protected $nombreCapacitador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* campo que almacenara el nombre de la institucion del capacitador
		*/
		protected $institucion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* campos que almacenara el id de la provincia
		*/
		protected $idProvincia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* campo que almacenara el nombre de la provincia
		*/
		protected $nombreProvincia;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* campo que alacenara el id del pais
		*/
		protected $idPais;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* campo que almacenara el nombre del pais
		*/
		protected $nombrePais;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* campo que almacena el id de la tabla curso impartido
		*/
		protected $idCursoImpartido;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* campo que almacenara el tipo de capacitador
		*/
		protected $tipoCapacitador;

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
	* Nombre de la tabla: capacitadores
	* 
	 */
	Private $tabla="capacitadores";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_capacitador";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_administracion_capacitaciones"."Capacitadores_id_capacitador_seq'; 



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
		throw new \Exception('Clase Modelo: CapacitadoresModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: CapacitadoresModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idCapacitador
	*
	*identificador de la tabla capacitadores
	*
	* @parámetro Integer $idCapacitador
	* @return IdCapacitador
	*/
	public function setIdCapacitador($idCapacitador)
	{
	  $this->idCapacitador = (Integer) $idCapacitador;
	    return $this;
	}

	/**
	* Get idCapacitador
	*
	* @return null|Integer
	*/
	public function getIdCapacitador()
	{
		return $this->idCapacitador;
	}

	/**
	* Set identificadorCapacitador
	*
	*campo que amacenarael identificador del capacitador registrago
	*
	* @parámetro String $identificadorCapacitador
	* @return IdentificadorCapacitador
	*/
	public function setIdentificadorCapacitador($identificadorCapacitador)
	{
	  $this->identificadorCapacitador = (String) $identificadorCapacitador;
	    return $this;
	}

	/**
	* Get identificadorCapacitador
	*
	* @return null|String
	*/
	public function getIdentificadorCapacitador()
	{
		return $this->identificadorCapacitador;
	}

	/**
	* Set nombreCapacitador
	*
	*campo que almacenara lso nombres del capacitador
	*
	* @parámetro String $nombreCapacitador
	* @return NombreCapacitador
	*/
	public function setNombreCapacitador($nombreCapacitador)
	{
	  $this->nombreCapacitador = (String) $nombreCapacitador;
	    return $this;
	}

	/**
	* Get nombreCapacitador
	*
	* @return null|String
	*/
	public function getNombreCapacitador()
	{
		return $this->nombreCapacitador;
	}

	/**
	* Set institucion
	*
	*campo que almacenara el nombre de la institucion del capacitador
	*
	* @parámetro String $institucion
	* @return Institucion
	*/
	public function setInstitucion($institucion)
	{
	  $this->institucion = (String) $institucion;
	    return $this;
	}

	/**
	* Get institucion
	*
	* @return null|String
	*/
	public function getInstitucion()
	{
		return $this->institucion;
	}

	/**
	* Set idProvincia
	*
	*campos que almacenara el id de la provincia
	*
	* @parámetro Integer $idProvincia
	* @return IdProvincia
	*/
	public function setIdProvincia($idProvincia)
	{
	  $this->idProvincia = (Integer) $idProvincia;
	    return $this;
	}

	/**
	* Get idProvincia
	*
	* @return null|Integer
	*/
	public function getIdProvincia()
	{
		return $this->idProvincia;
	}

	/**
	* Set nombreProvincia
	*
	*campo que almacenara el nombre de la provincia
	*
	* @parámetro String $nombreProvincia
	* @return NombreProvincia
	*/
	public function setNombreProvincia($nombreProvincia)
	{
	  $this->nombreProvincia = (String) $nombreProvincia;
	    return $this;
	}

	/**
	* Get nombreProvincia
	*
	* @return null|String
	*/
	public function getNombreProvincia()
	{
		return $this->nombreProvincia;
	}

	/**
	* Set idPais
	*
	*campo que alacenara el id del pais
	*
	* @parámetro Integer $idPais
	* @return IdPais
	*/
	public function setIdPais($idPais)
	{
	  $this->idPais = (Integer) $idPais;
	    return $this;
	}

	/**
	* Get idPais
	*
	* @return null|Integer
	*/
	public function getIdPais()
	{
		return $this->idPais;
	}

	/**
	* Set nombrePais
	*
	*campo que almacenara el nombre del pais
	*
	* @parámetro String $nombrePais
	* @return NombrePais
	*/
	public function setNombrePais($nombrePais)
	{
	  $this->nombrePais = (String) $nombrePais;
	    return $this;
	}

	/**
	* Get nombrePais
	*
	* @return null|String
	*/
	public function getNombrePais()
	{
		return $this->nombrePais;
	}

	/**
	* Set idCursoImpartido
	*
	*campo que almacena el id de la tabla curso impartido
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
	* Set tipoCapacitador
	*
	*campo que almacenara el tipo de capacitador
	*
	* @parámetro String $tipoCapacitador
	* @return TipoCapacitador
	*/
	public function setTipoCapacitador($tipoCapacitador)
	{
	  $this->tipoCapacitador = (String) $tipoCapacitador;
	    return $this;
	}

	/**
	* Get tipoCapacitador
	*
	* @return null|String
	*/
	public function getTipoCapacitador()
	{
		return $this->tipoCapacitador;
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
	* @return CapacitadoresModelo
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
