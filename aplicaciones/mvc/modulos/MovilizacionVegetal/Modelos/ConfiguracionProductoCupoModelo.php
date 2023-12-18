<?php
 /**
 * Modelo ConfiguracionProductoCupoModelo
 *
 * Este archivo se complementa con el archivo   ConfiguracionProductoCupoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-12-07
 * @uses    ConfiguracionProductoCupoModelo
 * @package MovilizacionVegetal
 * @subpackage Modelos
 */
  namespace Agrodb\MovilizacionVegetal\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class ConfiguracionProductoCupoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla
		*/
		protected $idConfiguracionProductoCupo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.tipo_productos
		*/
		protected $idTipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.subtipo_productos
		*/
		protected $idSubtipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.productos
		*/
		protected $idProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el estado de la configuracion
		*/
		protected $estadoConfiguracionProductoCupo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador del funcionario que configura el producto
		*/
		protected $identificadorResponsable;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de creacion del registro
		*/
		protected $fechaCreacion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de actualizacion del registro
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
	Private $esquema ="g_movilizacion_vegetal";

	/**
	* Nombre de la tabla: configuracion_producto_cupo
	* 
	 */
	Private $tabla="configuracion_producto_cupo";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_configuracion_producto_cupo";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_movilizacion_vegetal"."configuracion_producto_cupo_id_configuracion_producto_cupo_seq'; 



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
		throw new \Exception('Clase Modelo: ConfiguracionProductoCupoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: ConfiguracionProductoCupoModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_movilizacion_vegetal
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idConfiguracionProductoCupo
	*
	*Identificador unico de la tabla
	*
	* @parámetro Integer $idConfiguracionProductoCupo
	* @return IdConfiguracionProductoCupo
	*/
	public function setIdConfiguracionProductoCupo($idConfiguracionProductoCupo)
	{
	  $this->idConfiguracionProductoCupo = (Integer) $idConfiguracionProductoCupo;
	    return $this;
	}

	/**
	* Get idConfiguracionProductoCupo
	*
	* @return null|Integer
	*/
	public function getIdConfiguracionProductoCupo()
	{
		return $this->idConfiguracionProductoCupo;
	}

	/**
	* Set idTipoProducto
	*
	*Identificador unico de la tabla g_catalogos.tipo_productos
	*
	* @parámetro Integer $idTipoProducto
	* @return IdTipoProducto
	*/
	public function setIdTipoProducto($idTipoProducto)
	{
	  $this->idTipoProducto = (Integer) $idTipoProducto;
	    return $this;
	}

	/**
	* Get idTipoProducto
	*
	* @return null|Integer
	*/
	public function getIdTipoProducto()
	{
		return $this->idTipoProducto;
	}

	/**
	* Set idSubtipoProducto
	*
	*Identificador unico de la tabla g_catalogos.subtipo_productos
	*
	* @parámetro Integer $idSubtipoProducto
	* @return IdSubtipoProducto
	*/
	public function setIdSubtipoProducto($idSubtipoProducto)
	{
	  $this->idSubtipoProducto = (Integer) $idSubtipoProducto;
	    return $this;
	}

	/**
	* Get idSubtipoProducto
	*
	* @return null|Integer
	*/
	public function getIdSubtipoProducto()
	{
		return $this->idSubtipoProducto;
	}

	/**
	* Set idProducto
	*
	*Identificador unico de la tabla g_catalogos.productos
	*
	* @parámetro Integer $idProducto
	* @return IdProducto
	*/
	public function setIdProducto($idProducto)
	{
	  $this->idProducto = (Integer) $idProducto;
	    return $this;
	}

	/**
	* Get idProducto
	*
	* @return null|Integer
	*/
	public function getIdProducto()
	{
		return $this->idProducto;
	}

	/**
	* Set estadoConfiguracionProductoCupo
	*
	*Campo que almacena el estado de la configuracion
	*
	* @parámetro String $estadoConfiguracionProductoCupo
	* @return EstadoConfiguracionProductoCupo
	*/
	public function setEstadoConfiguracionProductoCupo($estadoConfiguracionProductoCupo)
	{
	  $this->estadoConfiguracionProductoCupo = (String) $estadoConfiguracionProductoCupo;
	    return $this;
	}

	/**
	* Get estadoConfiguracionProductoCupo
	*
	* @return null|String
	*/
	public function getEstadoConfiguracionProductoCupo()
	{
		return $this->estadoConfiguracionProductoCupo;
	}

	/**
	* Set identificadorResponsable
	*
	*Campo que almacena el identificador del funcionario que configura el producto
	*
	* @parámetro String $identificadorResponsable
	* @return IdentificadorResponsable
	*/
	public function setIdentificadorResponsable($identificadorResponsable)
	{
	  $this->identificadorResponsable = (String) $identificadorResponsable;
	    return $this;
	}

	/**
	* Get identificadorResponsable
	*
	* @return null|String
	*/
	public function getIdentificadorResponsable()
	{
		return $this->identificadorResponsable;
	}

	/**
	* Set fechaCreacion
	*
	*Campo que almacena la fecha de creacion del registro
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
	*Campo que almacena la fecha de actualizacion del registro
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
	* @return ConfiguracionProductoCupoModelo
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
