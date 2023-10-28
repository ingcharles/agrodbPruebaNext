<?php
 /**
 * Modelo DistritosModelo
 *
 * Este archivo se complementa con el archivo   DistritosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    DistritosModelo
 * @package Financiero
 * @subpackage Modelos
 */
  namespace Agrodb\Financiero\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class DistritosModelo extends ModeloBase 
{

		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $ruc;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $razonSocial;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombreComercial;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $direccion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $obligadoLlevarContabilidad;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $telefono;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $representante;
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
	Private $esquema ="g_financiero";

	/**
	* Nombre de la tabla: distritos
	* 
	 */
	Private $tabla="distritos";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "ruc";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_financiero"."Distritos_ruc_seq'; 



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
		throw new \Exception('Clase Modelo: DistritosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: DistritosModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_financiero
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set ruc
	*
	*
	*
	* @parámetro String $ruc
	* @return Ruc
	*/
	public function setRuc($ruc)
	{
	  $this->ruc = (String) $ruc;
	    return $this;
	}

	/**
	* Get ruc
	*
	* @return null|String
	*/
	public function getRuc()
	{
		return $this->ruc;
	}

	/**
	* Set razonSocial
	*
	*
	*
	* @parámetro String $razonSocial
	* @return RazonSocial
	*/
	public function setRazonSocial($razonSocial)
	{
	  $this->razonSocial = (String) $razonSocial;
	    return $this;
	}

	/**
	* Get razonSocial
	*
	* @return null|String
	*/
	public function getRazonSocial()
	{
		return $this->razonSocial;
	}

	/**
	* Set nombreComercial
	*
	*
	*
	* @parámetro String $nombreComercial
	* @return NombreComercial
	*/
	public function setNombreComercial($nombreComercial)
	{
	  $this->nombreComercial = (String) $nombreComercial;
	    return $this;
	}

	/**
	* Get nombreComercial
	*
	* @return null|String
	*/
	public function getNombreComercial()
	{
		return $this->nombreComercial;
	}

	/**
	* Set direccion
	*
	*
	*
	* @parámetro String $direccion
	* @return Direccion
	*/
	public function setDireccion($direccion)
	{
	  $this->direccion = (String) $direccion;
	    return $this;
	}

	/**
	* Get direccion
	*
	* @return null|String
	*/
	public function getDireccion()
	{
		return $this->direccion;
	}

	/**
	* Set obligadoLlevarContabilidad
	*
	*
	*
	* @parámetro String $obligadoLlevarContabilidad
	* @return ObligadoLlevarContabilidad
	*/
	public function setObligadoLlevarContabilidad($obligadoLlevarContabilidad)
	{
	  $this->obligadoLlevarContabilidad = (String) $obligadoLlevarContabilidad;
	    return $this;
	}

	/**
	* Get obligadoLlevarContabilidad
	*
	* @return null|String
	*/
	public function getObligadoLlevarContabilidad()
	{
		return $this->obligadoLlevarContabilidad;
	}

	/**
	* Set telefono
	*
	*
	*
	* @parámetro String $telefono
	* @return Telefono
	*/
	public function setTelefono($telefono)
	{
	  $this->telefono = (String) $telefono;
	    return $this;
	}

	/**
	* Get telefono
	*
	* @return null|String
	*/
	public function getTelefono()
	{
		return $this->telefono;
	}

	/**
	* Set representante
	*
	*
	*
	* @parámetro String $representante
	* @return Representante
	*/
	public function setRepresentante($representante)
	{
	  $this->representante = (String) $representante;
	    return $this;
	}

	/**
	* Get representante
	*
	* @return null|String
	*/
	public function getRepresentante()
	{
		return $this->representante;
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
	* @return DistritosModelo
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
