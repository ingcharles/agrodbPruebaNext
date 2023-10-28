<?php
 /**
 * Modelo ActividadManejoIntegradoModelo
 *
 * Este archivo se complementa con el archivo   ActividadManejoIntegradoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-23
 * @uses    ActividadManejoIntegradoModelo
 * @package ServiciosWebRest
 * @subpackage Modelos
 */
namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class ActividadManejoIntegradoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $id;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Codigo Unico Al registrar
		*/
		protected $idRegistro;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre representativo del catalogo
		*/
		protected $nombre;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre representativo al tipo o area que pertenece el catalogo
		*/
		protected $tipo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Codigo del tipo de catalogo si un caso lo requiera
		*/
		protected $codigo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Estado por defecto 1 activo
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
	* Nombre de la tabla: actividad_manejo_integrado
	* 
	 */
	Private $tabla="actividad_manejo_integrado";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_catalogos"."ActividadManejoIntegrado_id_seq'; 



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
		throw new \Exception('Clase Modelo: ActividadManejoIntegradoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: ActividadManejoIntegradoModelo. Propiedad especificada invalida: get'.$name);
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
	* Set id
	*
	*
	*
	* @parámetro Integer $id
	* @return Id
	*/
	public function setId($id)
	{
	  $this->id = (Integer) $id;
	    return $this;
	}

	/**
	* Get id
	*
	* @return null|Integer
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* Set idRegistro
	*
	*Codigo Unico Al registrar
	*
	* @parámetro String $idRegistro
	* @return IdRegistro
	*/
	public function setIdRegistro($idRegistro)
	{
	  $this->idRegistro = (String) $idRegistro;
	    return $this;
	}

	/**
	* Get idRegistro
	*
	* @return null|String
	*/
	public function getIdRegistro()
	{
		return $this->idRegistro;
	}

	/**
	* Set nombre
	*
	*Nombre representativo del catalogo
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
	* Set tipo
	*
	*Nombre representativo al tipo o area que pertenece el catalogo
	*
	* @parámetro String $tipo
	* @return Tipo
	*/
	public function setTipo($tipo)
	{
	  $this->tipo = (String) $tipo;
	    return $this;
	}

	/**
	* Get tipo
	*
	* @return null|String
	*/
	public function getTipo()
	{
		return $this->tipo;
	}

	/**
	* Set codigo
	*
	*Codigo del tipo de catalogo si un caso lo requiera
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
	* Set estado
	*
	*Estado por defecto 1 activo
	*
	* @parámetro Integer $estado
	* @return Estado
	*/
	public function setEstado($estado)
	{
	  $this->estado = (Integer) $estado;
	    return $this;
	}

	/**
	* Get estado
	*
	* @return null|Integer
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
	* @return ActividadManejoIntegradoModelo
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
