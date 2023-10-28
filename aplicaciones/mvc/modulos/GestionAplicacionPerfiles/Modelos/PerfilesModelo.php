<?php
 /**
 * Modelo PerfilesModelo
 *
 * Este archivo se complementa con el archivo   PerfilesLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2019-03-20
 * @uses    PerfilesModelo
 * @package GestionAplicacionPerfiles
 * @subpackage Modelos
 */
  namespace Agrodb\GestionAplicacionPerfiles\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class PerfilesModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único de la tabla
		*/
		protected $idPerfil;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Número de cédula del funcionario
		*/
		protected $identificador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código del perfil ha ser asignada
		*/
		protected $codificacionPerfil;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Estado del proceso de asiganción false -> por asignar, true -> asignado
		*/
		protected $estado;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de registro
		*/
		protected $fechaRegistro;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_gestion_aplicaciones_perfiles";

	/**
	* Nombre de la tabla: perfiles
	* 
	 */
	Private $tabla="perfiles";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_perfil";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_gestion_aplicaciones_perfiles"."perfiles_id_perfil_seq';



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
		throw new \Exception('Clase Modelo: PerfilesModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: PerfilesModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_gestion_aplicaciones_perfiles
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idPerfil
	*
	*Identificador único de la tabla
	*
	* @parámetro Integer $idPerfil
	* @return IdPerfil
	*/
	public function setIdPerfil($idPerfil)
	{
	  $this->idPerfil = (Integer) $idPerfil;
	    return $this;
	}

	/**
	* Get idPerfil
	*
	* @return null|Integer
	*/
	public function getIdPerfil()
	{
		return $this->idPerfil;
	}

	/**
	* Set identificador
	*
	*Número de cédula del funcionario
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
	* Set codificacionPerfil
	*
	*Código del perfil ha ser asignada
	*
	* @parámetro String $codificacionPerfil
	* @return CodificacionPerfil
	*/
	public function setCodificacionPerfil($codificacionPerfil)
	{
	  $this->codificacionPerfil = (String) $codificacionPerfil;
	    return $this;
	}

	/**
	* Get codificacionPerfil
	*
	* @return null|String
	*/
	public function getCodificacionPerfil()
	{
		return $this->codificacionPerfil;
	}

	/**
	* Set estado
	*
	*Estado del proceso de asiganción false -> por asignar, true -> asignado
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
	* Set fechaRegistro
	*
	*Fecha de registro
	*
	* @parámetro Date $fechaRegistro
	* @return FechaRegistro
	*/
	public function setFechaRegistro($fechaRegistro)
	{
	  $this->fechaRegistro = (String) $fechaRegistro;
	    return $this;
	}

	/**
	* Get fechaRegistro
	*
	* @return null|Date
	*/
	public function getFechaRegistro()
	{
		return $this->fechaRegistro;
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
	* @return PerfilesModelo
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
