<?php
 /**
 * Modelo UnidadesMedidasModelo
 *
 * Este archivo se complementa con el archivo   UnidadesMedidasLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2020-01-03
 * @uses    UnidadesMedidasModelo
 * @package Catalogos
 * @subpackage Modelos
 */
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class UnidadesMedidasModelo extends ModeloBase{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idUnidadMedida;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombre;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $tipoUnidad;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Columna agregada para proceso de registros de insumos dossier agricola, pecuario y ensayos de eficiencia
		*/
		protected $clasificacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $estado;

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
	* Nombre de la tabla: unidades_medidas
	* 
	 */
	Private $tabla="unidades_medidas";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_unidad_medida";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_catalogos"."unidades_medidas_id_unidad_medida_seq';



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
		throw new \Exception('Clase Modelo: UnidadesMedidasModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: UnidadesMedidasModelo. Propiedad especificada invalida: get'.$name);
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
	* Set codigo
	*
	*
	*
	* @parámetro String $codigo
	* @return Codigo
	*/
	public function setCodigo($codigo)
	{
	  $this->codigo = (String) $codigo;
	    return $this;
	}

	/**
	* Get codigo
	*
	* @return null|String
	*/
	public function getCodigo()
	{
		return $this->codigo;
	}

	/**
	* Set nombre
	*
	*
	*
	* @parámetro String $nombre
	* @return Nombre
	*/
	public function setNombre($nombre)
	{
	  $this->nombre = (String) $nombre;
	    return $this;
	}

	/**
	* Get nombre
	*
	* @return null|String
	*/
	public function getNombre()
	{
		return $this->nombre;
	}

	/**
	* Set tipoUnidad
	*
	*
	*
	* @parámetro String $tipoUnidad
	* @return TipoUnidad
	*/
	public function setTipoUnidad($tipoUnidad)
	{
	  $this->tipoUnidad = (String) $tipoUnidad;
	    return $this;
	}

	/**
	* Get tipoUnidad
	*
	* @return null|String
	*/
	public function getTipoUnidad()
	{
		return $this->tipoUnidad;
	}

	/**
	* Set clasificacion
	*
	*Columna agregada para proceso de registros de insumos dossier agricola, pecuario y ensayos de eficiencia
	*
	* @parámetro String $clasificacion
	* @return Clasificacion
	*/
	public function setClasificacion($clasificacion)
	{
	  $this->clasificacion = (String) $clasificacion;
	    return $this;
	}

	/**
	* Get clasificacion
	*
	* @return null|String
	*/
	public function getClasificacion()
	{
		return $this->clasificacion;
	}

	/**
	* Set estado
	*
	*
	*
	* @parámetro String $estado
	* @return Estado
	*/
	public function setEstado($estado)
	{
	  $this->estado = (String) $estado;
	    return $this;
	}

	/**
	* Get estado
	*
	* @return null|String
	*/
	public function getEstado()
	{
		return $this->estado;
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
	* @return UnidadesMedidasModelo
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
