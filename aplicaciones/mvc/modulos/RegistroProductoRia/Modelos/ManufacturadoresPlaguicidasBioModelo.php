<?php
 /**
 * Modelo ManufacturadoresPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo   ManufacturadoresPlaguicidasBioLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    ManufacturadoresPlaguicidasBioModelo
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class ManufacturadoresPlaguicidasBioModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único de la tabla
		*/
		protected $idManufacturador;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador del registro de fabricante o formulador
		*/
		protected $idFabricanteFormulador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del manufacturadores_plaguicidas_bio del producto
		*/
		protected $manufacturador;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador del país de origen
		*/
		protected $idPaisOrigen;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del país de origen
		*/
		protected $paisOrigen;

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
	* Nombre de la tabla: manufacturadores_plaguicidas_bio
	* 
	 */
	Private $tabla="manufacturadores_plaguicidas_bio";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_manufacturador";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_registro_productos"."manufacturadores_plaguicidas_bio_id_manufacturador_seq'; 



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
		throw new \Exception('Clase Modelo: ManufacturadoresPlaguicidasBioModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: ManufacturadoresPlaguicidasBioModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idManufacturador
	*
	*Identificador único de la tabla
	*
	* @parámetro Integer $idManufacturador
	* @return IdManufacturador
	*/
	public function setIdManufacturador($idManufacturador)
	{
	  $this->idManufacturador = (Integer) $idManufacturador;
	    return $this;
	}

	/**
	* Get idManufacturador
	*
	* @return null|Integer
	*/
	public function getIdManufacturador()
	{
		return $this->idManufacturador;
	}

	/**
	* Set idFabricanteFormulador
	*
	*Identificador del registro de fabricante o formulador
	*
	* @parámetro Integer $idFabricanteFormulador
	* @return IdFabricanteFormulador
	*/
	public function setIdFabricanteFormulador($idFabricanteFormulador)
	{
	  $this->idFabricanteFormulador = (Integer) $idFabricanteFormulador;
	    return $this;
	}

	/**
	* Get idFabricanteFormulador
	*
	* @return null|Integer
	*/
	public function getIdFabricanteFormulador()
	{
		return $this->idFabricanteFormulador;
	}

	/**
	* Set manufacturador
	*
	*Nombre del manufacturadores_plaguicidas_bio del producto
	*
	* @parámetro String $manufacturador
	* @return Manufacturador
	*/
	public function setManufacturador($manufacturador)
	{
	  $this->manufacturador = (String) $manufacturador;
	    return $this;
	}

	/**
	* Get manufacturador
	*
	* @return null|String
	*/
	public function getManufacturador()
	{
		return $this->manufacturador;
	}

	/**
	* Set idPaisOrigen
	*
	*Identificador del país de origen
	*
	* @parámetro Integer $idPaisOrigen
	* @return IdPaisOrigen
	*/
	public function setIdPaisOrigen($idPaisOrigen)
	{
	  $this->idPaisOrigen = (Integer) $idPaisOrigen;
	    return $this;
	}

	/**
	* Get idPaisOrigen
	*
	* @return null|Integer
	*/
	public function getIdPaisOrigen()
	{
		return $this->idPaisOrigen;
	}

	/**
	* Set paisOrigen
	*
	*Nombre del país de origen
	*
	* @parámetro String $paisOrigen
	* @return PaisOrigen
	*/
	public function setPaisOrigen($paisOrigen)
	{
	  $this->paisOrigen = (String) $paisOrigen;
	    return $this;
	}

	/**
	* Get paisOrigen
	*
	* @return null|String
	*/
	public function getPaisOrigen()
	{
		return $this->paisOrigen;
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
	* @return ManufacturadoresPlaguicidasBioModelo
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
