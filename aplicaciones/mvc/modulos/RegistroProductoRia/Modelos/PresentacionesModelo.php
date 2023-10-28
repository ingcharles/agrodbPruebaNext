<?php
 /**
 * Modelo PresentacionesModelo
 *
 * Este archivo se complementa con el archivo   PresentacionesLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-20
 * @uses    PresentacionesModelo
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class PresentacionesModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla
		*/
		protected $idPresentacion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Llave foranea de la tabla solicitudes registro de producto
		*/
		protected $idSolicitudRegistroProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombr de la presentacion del producto
		*/
		protected $presentacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Codigo de la unidad de medida
		*/
		protected $unidadMedida;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la unidad de medida
		*/
		protected $nombreUnidadMedida;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Subcodigo secuencial relacionado con la cantidad de presentaciones ingresadas par ael producto
		*/
		protected $subcodigo;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_registro_productos";

	/**
	* Nombre de la tabla: presentaciones
	* 
	 */
	Private $tabla="presentaciones";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_presentacion";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_registro_productos"."presentaciones_id_presentacion_seq';



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
		throw new \Exception('Clase Modelo: PresentacionesModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: PresentacionesModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_registro_productos
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idPresentacion
	*
	*Identificador unico de la tabla
	*
	* @parámetro Integer $idPresentacion
	* @return IdPresentacion
	*/
	public function setIdPresentacion($idPresentacion)
	{
	  $this->idPresentacion = (Integer) $idPresentacion;
	    return $this;
	}

	/**
	* Get idPresentacion
	*
	* @return null|Integer
	*/
	public function getIdPresentacion()
	{
		return $this->idPresentacion;
	}

	/**
	* Set idSolicitudRegistroProducto
	*
	*Llave foranea de la tabla solicitudes registro de producto
	*
	* @parámetro Integer $idSolicitudRegistroProducto
	* @return IdSolicitudRegistroProducto
	*/
	public function setIdSolicitudRegistroProducto($idSolicitudRegistroProducto)
	{
	  $this->idSolicitudRegistroProducto = (Integer) $idSolicitudRegistroProducto;
	    return $this;
	}

	/**
	* Get idSolicitudRegistroProducto
	*
	* @return null|Integer
	*/
	public function getIdSolicitudRegistroProducto()
	{
		return $this->idSolicitudRegistroProducto;
	}

	/**
	* Set presentacion
	*
	*Nombr de la presentacion del producto
	*
	* @parámetro String $presentacion
	* @return Presentacion
	*/
	public function setPresentacion($presentacion)
	{
	  $this->presentacion = (String) $presentacion;
	    return $this;
	}

	/**
	* Get presentacion
	*
	* @return null|String
	*/
	public function getPresentacion()
	{
		return $this->presentacion;
	}

	/**
	* Set unidadMedida
	*
	*Codigo de la unidad de medida
	*
	* @parámetro String $unidadMedida
	* @return UnidadMedida
	*/
	public function setUnidadMedida($unidadMedida)
	{
	  $this->unidadMedida = (String) $unidadMedida;
	    return $this;
	}

	/**
	* Get unidadMedida
	*
	* @return null|String
	*/
	public function getUnidadMedida()
	{
		return $this->unidadMedida;
	}

	/**
	* Set nombreUnidadMedida
	*
	*Nombre de la unidad de medida
	*
	* @parámetro String $nombreUnidadMedida
	* @return NombreUnidadMedida
	*/
	public function setNombreUnidadMedida($nombreUnidadMedida)
	{
	  $this->nombreUnidadMedida = (String) $nombreUnidadMedida;
	    return $this;
	}

	/**
	* Get nombreUnidadMedida
	*
	* @return null|String
	*/
	public function getNombreUnidadMedida()
	{
		return $this->nombreUnidadMedida;
	}

	/**
	* Set subcodigo
	*
	*Subcodigo secuencial relacionado con la cantidad de presentaciones ingresadas par ael producto
	*
	* @parámetro String $subcodigo
	* @return Subcodigo
	*/
	public function setSubcodigo($subcodigo)
	{
	  $this->subcodigo = (String) $subcodigo;
	    return $this;
	}

	/**
	* Get subcodigo
	*
	* @return null|String
	*/
	public function getSubcodigo()
	{
		return $this->subcodigo;
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
	* @return PresentacionesModelo
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
