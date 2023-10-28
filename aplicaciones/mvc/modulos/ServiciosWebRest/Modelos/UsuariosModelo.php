<?php
 /**
 * Modelo UsuariosModelo
 *
 * Este archivo se complementa con el archivo   UsuariosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-01-26
 * @uses    UsuariosModelo
 * @package ServiciosWebRest
 * @subpackage Modelos
 */
  namespace Agrodb\ServiciosWebRest\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class UsuariosModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idUsuario;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $identificador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $clave;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $token;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $tipoCliente;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaCreacionUsuario;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaCreacionToken;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaActualizacionToken;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $tiempoRenovacionToken;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $periodo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $correo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $informacion;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_servicios_web";

	/**
	* Nombre de la tabla: usuarios
	* 
	 */
	Private $tabla="usuarios";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_usuario";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_servicios_web"."Usuarios_id_usuario_seq'; 



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
		throw new \Exception('Clase Modelo: UsuariosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: UsuariosModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_servicios_web
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idUsuario
	*
	*
	*
	* @parámetro Integer $idUsuario
	* @return IdUsuario
	*/
	public function setIdUsuario($idUsuario)
	{
	  $this->idUsuario = (Integer) $idUsuario;
	    return $this;
	}

	/**
	* Get idUsuario
	*
	* @return null|Integer
	*/
	public function getIdUsuario()
	{
		return $this->idUsuario;
	}

	/**
	* Set identificador
	*
	*
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
	* Set clave
	*
	*
	*
	* @parámetro String $clave
	* @return Clave
	*/
	public function setClave($clave)
	{
	  $this->clave = (String) $clave;
	    return $this;
	}

	/**
	* Get clave
	*
	* @return null|String
	*/
	public function getClave()
	{
		return $this->clave;
	}

	/**
	* Set token
	*
	*
	*
	* @parámetro String $token
	* @return Token
	*/
	public function setToken($token)
	{
	  $this->token = (String) $token;
	    return $this;
	}

	/**
	* Get token
	*
	* @return null|String
	*/
	public function getToken()
	{
		return $this->token;
	}

	/**
	* Set tipoCliente
	*
	*
	*
	* @parámetro String $tipoCliente
	* @return TipoCliente
	*/
	public function setTipoCliente($tipoCliente)
	{
	  $this->tipoCliente = (String) $tipoCliente;
	    return $this;
	}

	/**
	* Get tipoCliente
	*
	* @return null|String
	*/
	public function getTipoCliente()
	{
		return $this->tipoCliente;
	}

	/**
	* Set fechaCreacionUsuario
	*
	*
	*
	* @parámetro Date $fechaCreacionUsuario
	* @return FechaCreacionUsuario
	*/
	public function setFechaCreacionUsuario($fechaCreacionUsuario)
	{
	  $this->fechaCreacionUsuario = (String) $fechaCreacionUsuario;
	    return $this;
	}

	/**
	* Get fechaCreacionUsuario
	*
	* @return null|Date
	*/
	public function getFechaCreacionUsuario()
	{
		return $this->fechaCreacionUsuario;
	}

	/**
	* Set fechaCreacionToken
	*
	*
	*
	* @parámetro Date $fechaCreacionToken
	* @return FechaCreacionToken
	*/
	public function setFechaCreacionToken($fechaCreacionToken)
	{
	  $this->fechaCreacionToken = (String) $fechaCreacionToken;
	    return $this;
	}

	/**
	* Get fechaCreacionToken
	*
	* @return null|Date
	*/
	public function getFechaCreacionToken()
	{
		return $this->fechaCreacionToken;
	}

	/**
	* Set fechaActualizacionToken
	*
	*
	*
	* @parámetro Date $fechaActualizacionToken
	* @return FechaActualizacionToken
	*/
	public function setFechaActualizacionToken($fechaActualizacionToken)
	{
	  $this->fechaActualizacionToken = (String) $fechaActualizacionToken;
	    return $this;
	}

	/**
	* Get fechaActualizacionToken
	*
	* @return null|Date
	*/
	public function getFechaActualizacionToken()
	{
		return $this->fechaActualizacionToken;
	}

	/**
	* Set tiempoRenovacionToken
	*
	*
	*
	* @parámetro Integer $tiempoRenovacionToken
	* @return TiempoRenovacionToken
	*/
	public function setTiempoRenovacionToken($tiempoRenovacionToken)
	{
	  $this->tiempoRenovacionToken = (Integer) $tiempoRenovacionToken;
	    return $this;
	}

	/**
	* Get tiempoRenovacionToken
	*
	* @return null|Integer
	*/
	public function getTiempoRenovacionToken()
	{
		return $this->tiempoRenovacionToken;
	}

	/**
	* Set periodo
	*
	*
	*
	* @parámetro String $periodo
	* @return Periodo
	*/
	public function setPeriodo($periodo)
	{
	  $this->periodo = (String) $periodo;
	    return $this;
	}

	/**
	* Get periodo
	*
	* @return null|String
	*/
	public function getPeriodo()
	{
		return $this->periodo;
	}

	/**
	* Set correo
	*
	*
	*
	* @parámetro String $correo
	* @return Correo
	*/
	public function setCorreo($correo)
	{
	  $this->correo = (String) $correo;
	    return $this;
	}

	/**
	* Get correo
	*
	* @return null|String
	*/
	public function getCorreo()
	{
		return $this->correo;
	}

	/**
	* Set informacion
	*
	*
	*
	* @parámetro String $informacion
	* @return Informacion
	*/
	public function setInformacion($informacion)
	{
	  $this->informacion = (String) $informacion;
	    return $this;
	}

	/**
	* Get informacion
	*
	* @return null|String
	*/
	public function getInformacion()
	{
		return $this->informacion;
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
	* @return UsuariosModelo
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
