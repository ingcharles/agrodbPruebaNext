<?php
 /**
 * Modelo PresentacionesPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo   PresentacionesPlaguicidasBioLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    PresentacionesPlaguicidasBioModelo
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class PresentacionesPlaguicidasBioModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único del registro
		*/
		protected $idPresentacion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador del registro de código complementario y suplementario
		*/
		protected $idCodigoComplementarioSuplementario;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la presentación del producto
		*/
		protected $presentacion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la unidad de medida de la presentación
		*/
		protected $idUnidad;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Codigo de la unidad de medida de la presentación del producto
		*/
		protected $unidad;

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
	* Nombre de la tabla: presentaciones_plaguicidas_bio
	* 
	 */
	Private $tabla="presentaciones_plaguicidas_bio";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_presentacion";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_registro_productos"."presentaciones_plaguicidas_bio_id_presentacion_seq'; 



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
		throw new \Exception('Clase Modelo: PresentacionesPlaguicidasBioModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: PresentacionesPlaguicidasBioModelo. Propiedad especificada invalida: get'.$name);
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
	*Identificador único del registro
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
	* Set idCodigoComplementarioSuplementario
	*
	*Identificador del registro de código complementario y suplementario
	*
	* @parámetro Integer $idCodigoComplementarioSuplementario
	* @return IdCodigoComplementarioSuplementario
	*/
	public function setIdCodigoComplementarioSuplementario($idCodigoComplementarioSuplementario)
	{
	  $this->idCodigoComplementarioSuplementario = (Integer) $idCodigoComplementarioSuplementario;
	    return $this;
	}

	/**
	* Get idCodigoComplementarioSuplementario
	*
	* @return null|Integer
	*/
	public function getIdCodigoComplementarioSuplementario()
	{
		return $this->idCodigoComplementarioSuplementario;
	}

	/**
	* Set presentacion
	*
	*Nombre de la presentación del producto
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
	* Set idUnidad
	*
	*Identificador de la unidad de medida de la presentación
	*
	* @parámetro Integer $idUnidad
	* @return IdUnidad
	*/
	public function setIdUnidad($idUnidad)
	{
	  $this->idUnidad = (Integer) $idUnidad;
	    return $this;
	}

	/**
	* Get idUnidad
	*
	* @return null|Integer
	*/
	public function getIdUnidad()
	{
		return $this->idUnidad;
	}

	/**
	* Set unidad
	*
	*Codigo de la unidad de medida de la presentación del producto
	*
	* @parámetro String $unidad
	* @return Unidad
	*/
	public function setUnidad($unidad)
	{
	  $this->unidad = (String) $unidad;
	    return $this;
	}

	/**
	* Get unidad
	*
	* @return null|String
	*/
	public function getUnidad()
	{
		return $this->unidad;
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
	* @return PresentacionesPlaguicidasBioModelo
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
