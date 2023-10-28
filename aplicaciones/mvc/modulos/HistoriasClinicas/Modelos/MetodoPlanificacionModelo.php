<?php
 /**
 * Modelo MetodoPlanificacionModelo
 *
 * Este archivo se complementa con el archivo   MetodoPlanificacionLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    MetodoPlanificacionModelo
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class MetodoPlanificacionModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idMetodoPlanificacion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idHistoriaClinica;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $tipoMetodo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $hijosVivos;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $hijosMuertos;

		protected $otroMetodo;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_historias_clinicas";

	/**
	* Nombre de la tabla: metodo_planificacion
	* 
	 */
	Private $tabla="metodo_planificacion";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_metodo_planificacion";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_historias_clinicas"."metodo_planificacion_id_metodo_planificacion_seq'; 



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
		throw new \Exception('Clase Modelo: MetodoPlanificacionModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: MetodoPlanificacionModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_historias_clinicas
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idMetodoPlanificacion
	*
	*
	*
	* @parámetro Integer $idMetodoPlanificacion
	* @return IdMetodoPlanificacion
	*/
	public function setIdMetodoPlanificacion($idMetodoPlanificacion)
	{
	  $this->idMetodoPlanificacion = (Integer) $idMetodoPlanificacion;
	    return $this;
	}

	/**
	* Get idMetodoPlanificacion
	*
	* @return null|Integer
	*/
	public function getIdMetodoPlanificacion()
	{
		return $this->idMetodoPlanificacion;
	}

	/**
	* Set idHistoriaClinica
	*
	*
	*
	* @parámetro Integer $idHistoriaClinica
	* @return IdHistoriaClinica
	*/
	public function setIdHistoriaClinica($idHistoriaClinica)
	{
	  $this->idHistoriaClinica = (Integer) $idHistoriaClinica;
	    return $this;
	}

	/**
	* Get idHistoriaClinica
	*
	* @return null|Integer
	*/
	public function getIdHistoriaClinica()
	{
		return $this->idHistoriaClinica;
	}

	/**
	* Set tipoMetodo
	*
	*
	*
	* @parámetro String $tipoMetodo
	* @return TipoMetodo
	*/
	public function setTipoMetodo($tipoMetodo)
	{
	  $this->tipoMetodo = (String) $tipoMetodo;
	    return $this;
	}

	/**
	* Get tipoMetodo
	*
	* @return null|String
	*/
	public function getTipoMetodo()
	{
		return $this->tipoMetodo;
	}

	/**
	* Set hijosVivos
	*
	*
	*
	* @parámetro Integer $hijosVivos
	* @return HijosVivos
	*/
	public function setHijosVivos($hijosVivos)
	{
	  $this->hijosVivos = (Integer) $hijosVivos;
	    return $this;
	}

	/**
	* Get hijosVivos
	*
	* @return null|Integer
	*/
	public function getHijosVivos()
	{
		return $this->hijosVivos;
	}

	/**
	* Set hijosMuertos
	*
	*
	*
	* @parámetro Integer $hijosMuertos
	* @return HijosMuertos
	*/
	public function setHijosMuertos($hijosMuertos)
	{
	  $this->hijosMuertos = (Integer) $hijosMuertos;
	    return $this;
	}

	/**
	* Get hijosMuertos
	*
	* @return null|Integer
	*/
	public function getHijosMuertos()
	{
		return $this->hijosMuertos;
	}


	public function setOtroMetodo($otroMetodo)
	{
	  $this->otroMetodo = (String) $otroMetodo;
	    return $this;
	}

	public function getOtroMetodo()
	{
		return $this->otroMetodo;
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
	* @return MetodoPlanificacionModelo
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
