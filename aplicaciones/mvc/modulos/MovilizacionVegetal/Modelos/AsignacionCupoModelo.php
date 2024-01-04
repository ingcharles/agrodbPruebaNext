<?php
 /**
 * Modelo AsignacionCupoModelo
 *
 * Este archivo se complementa con el archivo   AsignacionCupoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-12-08
 * @uses    AsignacionCupoModelo
 * @package MovilizacionVegetal
 * @subpackage Modelos
 */
  namespace Agrodb\MovilizacionVegetal\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class AsignacionCupoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idAsignacionCupo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idSitio;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idArea;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $lote;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idUnidadMedida;
		/**
		* @var Decimal
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $cupoAsignado;
		/**
		* @var Decimal
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $cupoAdicional;
		/**
		* @var Decimal
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $cupoDisponible;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $identificadorResponsable;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaCreacion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaActualizacion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $anioAsignacionCupo;

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
	* Nombre de la tabla: asignacion_cupo
	* 
	 */
	Private $tabla="asignacion_cupo";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_asignacion_cupo";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_movilizacion_vegetal"."asignacion_cupo_id_asignacion_cupo_seq'; 



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
		throw new \Exception('Clase Modelo: AsignacionCupoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: AsignacionCupoModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idAsignacionCupo
	*
	*
	*
	* @parámetro Integer $idAsignacionCupo
	* @return IdAsignacionCupo
	*/
	public function setIdAsignacionCupo($idAsignacionCupo)
	{
	  $this->idAsignacionCupo = (Integer) $idAsignacionCupo;
	    return $this;
	}

	/**
	* Get idAsignacionCupo
	*
	* @return null|Integer
	*/
	public function getIdAsignacionCupo()
	{
		return $this->idAsignacionCupo;
	}

	/**
	* Set idSitio
	*
	*
	*
	* @parámetro Integer $idSitio
	* @return IdSitio
	*/
	public function setIdSitio($idSitio)
	{
	  $this->idSitio = (Integer) $idSitio;
	    return $this;
	}

	/**
	* Get idSitio
	*
	* @return null|Integer
	*/
	public function getIdSitio()
	{
		return $this->idSitio;
	}

	/**
	* Set idArea
	*
	*
	*
	* @parámetro Integer $idArea
	* @return IdArea
	*/
	public function setIdArea($idArea)
	{
	  $this->idArea = (Integer) $idArea;
	    return $this;
	}

	/**
	* Get idArea
	*
	* @return null|Integer
	*/
	public function getIdArea()
	{
		return $this->idArea;
	}

	/**
	* Set idProducto
	*
	*
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
	* Set lote
	*
	*
	*
	* @parámetro String $lote
	* @return Lote
	*/
	public function setLote($lote)
	{
	  $this->lote = (String) $lote;
	    return $this;
	}

	/**
	* Get lote
	*
	* @return null|String
	*/
	public function getLote()
	{
		return $this->lote;
	}

	/**
	* Set idUnidadMedida
	*
	*
	*
	* @parámetro Integer $idUnidadMedida
	* @return IdUnidadMedida
	*/
	public function setIdUnidadMedida($idUnidadMedida)
	{
	  $this->idUnidadMedida = (Integer) $idUnidadMedida;
	    return $this;
	}

	/**
	* Get idUnidadMedida
	*
	* @return null|Integer
	*/
	public function getIdUnidadMedida()
	{
		return $this->idUnidadMedida;
	}

	/**
	* Set cupoAsignado
	*
	*
	*
	* @parámetro Decimal $cupoAsignado
	* @return CupoAsignado
	*/
	public function setCupoAsignado($cupoAsignado)
	{
	  $this->cupoAsignado = (Double) $cupoAsignado;
	    return $this;
	}

	/**
	* Get cupoAsignado
	*
	* @return null|Decimal
	*/
	public function getCupoAsignado()
	{
		return $this->cupoAsignado;
	}

	/**
	* Set cupoAdicional
	*
	*
	*
	* @parámetro Decimal $cupoAdicional
	* @return CupoAdicional
	*/
	public function setCupoAdicional($cupoAdicional)
	{
	  $this->cupoAdicional = (Double) $cupoAdicional;
	    return $this;
	}

	/**
	* Get cupoAdicional
	*
	* @return null|Decimal
	*/
	public function getCupoAdicional()
	{
		return $this->cupoAdicional;
	}

	/**
	* Set cupoDisponible
	*
	*
	*
	* @parámetro Decimal $cupoDisponible
	* @return CupoDisponible
	*/
	public function setCupoDisponible($cupoDisponible)
	{
	  $this->cupoDisponible = (Double) $cupoDisponible;
	    return $this;
	}

	/**
	* Get cupoDisponible
	*
	* @return null|Decimal
	*/
	public function getCupoDisponible()
	{
		return $this->cupoDisponible;
	}

	/**
	* Set identificadorResponsable
	*
	*
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
	*
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
	*
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
	* Set anioAsignacionCupo
	*
	*
	*
	* @parámetro Integer $anioAsignacionCupo
	* @return AnioAsignacionCupo
	*/
	public function setAnioAsignacionCupo($anioAsignacionCupo)
	{
	  $this->anioAsignacionCupo = (Integer) $anioAsignacionCupo;
	    return $this;
	}

	/**
	* Get anioAsignacionCupo
	*
	* @return null|Integer
	*/
	public function getAnioAsignacionCupo()
	{
		return $this->anioAsignacionCupo;
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
	* @return AsignacionCupoModelo
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
