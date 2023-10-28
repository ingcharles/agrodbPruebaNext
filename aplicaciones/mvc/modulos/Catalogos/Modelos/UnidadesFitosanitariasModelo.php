<?php
 /**
 * Modelo UnidadesFitosanitariasModelo
 *
 * Este archivo se complementa con el archivo   UnidadesFitosanitariasLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    UnidadesFitosanitariasModelo
 * @package Catalogos
 * @subpackage Modelos
 */
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class UnidadesFitosanitariasModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla
		*/
		protected $idUnidadFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el código de la unidad de medida
		*/
		protected $codigoUnidadFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la unidad de medida
		*/
		protected $nombreUnidadFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre en ingles de la unidad de medida
		*/
		protected $nombreUnidadFitosanitariaIngles;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el tipo de unidad de medida
		*/
		protected $tipoUnidadFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el esatdo de la unidad de medida
		*/
		protected $estadoUnidadFitosanitaria;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de creacion del registro
		*/
		protected $fechaCreacion;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_catalogos";

	/**
	* Nombre de la tabla: unidades_fitosanitarias
	* 
	 */
	Private $tabla="unidades_fitosanitarias";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_unidad_fitosanitaria";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_catalogos"."UnidadesFitosanitarias_id_unidad_fitosanitaria_seq'; 



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
		throw new \Exception('Clase Modelo: UnidadesFitosanitariasModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: UnidadesFitosanitariasModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_catalogos
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idUnidadFitosanitaria
	*
	*Identificador unico de la tabla
	*
	* @parámetro Integer $idUnidadFitosanitaria
	* @return IdUnidadFitosanitaria
	*/
	public function setIdUnidadFitosanitaria($idUnidadFitosanitaria)
	{
	  $this->idUnidadFitosanitaria = (Integer) $idUnidadFitosanitaria;
	    return $this;
	}

	/**
	* Get idUnidadFitosanitaria
	*
	* @return null|Integer
	*/
	public function getIdUnidadFitosanitaria()
	{
		return $this->idUnidadFitosanitaria;
	}

	/**
	* Set codigoUnidadFitosanitaria
	*
	*Campo que almacena el código de la unidad de medida
	*
	* @parámetro String $codigoUnidadFitosanitaria
	* @return CodigoUnidadFitosanitaria
	*/
	public function setCodigoUnidadFitosanitaria($codigoUnidadFitosanitaria)
	{
	  $this->codigoUnidadFitosanitaria = (String) $codigoUnidadFitosanitaria;
	    return $this;
	}

	/**
	* Get codigoUnidadFitosanitaria
	*
	* @return null|String
	*/
	public function getCodigoUnidadFitosanitaria()
	{
		return $this->codigoUnidadFitosanitaria;
	}

	/**
	* Set nombreUnidadFitosanitaria
	*
	*Campo que almacena el nombre de la unidad de medida
	*
	* @parámetro String $nombreUnidadFitosanitaria
	* @return NombreUnidadFitosanitaria
	*/
	public function setNombreUnidadFitosanitaria($nombreUnidadFitosanitaria)
	{
	  $this->nombreUnidadFitosanitaria = (String) $nombreUnidadFitosanitaria;
	    return $this;
	}

	/**
	* Get nombreUnidadFitosanitaria
	*
	* @return null|String
	*/
	public function getNombreUnidadFitosanitaria()
	{
		return $this->nombreUnidadFitosanitaria;
	}

	/**
	* Set nombreUnidadFitosanitariaIngles
	*
	*Campo que almacena el nombre en ingles de la unidad de medida
	*
	* @parámetro String $nombreUnidadFitosanitariaIngles
	* @return NombreUnidadFitosanitariaIngles
	*/
	public function setNombreUnidadFitosanitariaIngles($nombreUnidadFitosanitariaIngles)
	{
	  $this->nombreUnidadFitosanitariaIngles = (String) $nombreUnidadFitosanitariaIngles;
	    return $this;
	}

	/**
	* Get nombreUnidadFitosanitariaIngles
	*
	* @return null|String
	*/
	public function getNombreUnidadFitosanitariaIngles()
	{
		return $this->nombreUnidadFitosanitariaIngles;
	}

	/**
	* Set tipoUnidadFitosanitaria
	*
	*Campo que almacena el tipo de unidad de medida
	*
	* @parámetro String $tipoUnidadFitosanitaria
	* @return TipoUnidadFitosanitaria
	*/
	public function setTipoUnidadFitosanitaria($tipoUnidadFitosanitaria)
	{
	  $this->tipoUnidadFitosanitaria = (String) $tipoUnidadFitosanitaria;
	    return $this;
	}

	/**
	* Get tipoUnidadFitosanitaria
	*
	* @return null|String
	*/
	public function getTipoUnidadFitosanitaria()
	{
		return $this->tipoUnidadFitosanitaria;
	}

	/**
	* Set estadoUnidadFitosanitaria
	*
	*Campo que almacena el esatdo de la unidad de medida
	*
	* @parámetro String $estadoUnidadFitosanitaria
	* @return EstadoUnidadFitosanitaria
	*/
	public function setEstadoUnidadFitosanitaria($estadoUnidadFitosanitaria)
	{
	  $this->estadoUnidadFitosanitaria = (String) $estadoUnidadFitosanitaria;
	    return $this;
	}

	/**
	* Get estadoUnidadFitosanitaria
	*
	* @return null|String
	*/
	public function getEstadoUnidadFitosanitaria()
	{
		return $this->estadoUnidadFitosanitaria;
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
	* @return UnidadesFitosanitariasModelo
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
