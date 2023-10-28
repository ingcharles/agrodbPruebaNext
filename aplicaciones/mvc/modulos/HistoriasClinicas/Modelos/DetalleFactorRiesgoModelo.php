<?php
 /**
 * Modelo DetalleFactorRiesgoModelo
 *
 * Este archivo se complementa con el archivo   DetalleFactorRiesgoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    DetalleFactorRiesgoModelo
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class DetalleFactorRiesgoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idDetalleFactorRiesgo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idFactorRiesgo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idSubtipoProcedMedico;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
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
	Private $esquema ="g_historias_clinicas";

	/**
	* Nombre de la tabla: detalle_factor_riesgo
	* 
	 */
	Private $tabla="detalle_factor_riesgo";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_detalle_factor_riesgo";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_historias_clinicas"."DetalleFactorRiesgo_id_detalle_factor_riesgo_seq'; 



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
		throw new \Exception('Clase Modelo: DetalleFactorRiesgoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: DetalleFactorRiesgoModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idDetalleFactorRiesgo
	*
	*
	*
	* @parámetro Integer $idDetalleFactorRiesgo
	* @return IdDetalleFactorRiesgo
	*/
	public function setIdDetalleFactorRiesgo($idDetalleFactorRiesgo)
	{
	  $this->idDetalleFactorRiesgo = (Integer) $idDetalleFactorRiesgo;
	    return $this;
	}

	/**
	* Get idDetalleFactorRiesgo
	*
	* @return null|Integer
	*/
	public function getIdDetalleFactorRiesgo()
	{
		return $this->idDetalleFactorRiesgo;
	}

	/**
	* Set idFactorRiesgo
	*
	*
	*
	* @parámetro Integer $idFactorRiesgo
	* @return IdFactorRiesgo
	*/
	public function setIdFactorRiesgo($idFactorRiesgo)
	{
	  $this->idFactorRiesgo = (Integer) $idFactorRiesgo;
	    return $this;
	}

	/**
	* Get idFactorRiesgo
	*
	* @return null|Integer
	*/
	public function getIdFactorRiesgo()
	{
		return $this->idFactorRiesgo;
	}

	/**
	* Set idSubtipoProcedMedico
	*
	*
	*
	* @parámetro Integer $idSubtipoProcedMedico
	* @return IdSubtipoProcedMedico
	*/
	public function setIdSubtipoProcedMedico($idSubtipoProcedMedico)
	{
	  $this->idSubtipoProcedMedico = (Integer) $idSubtipoProcedMedico;
	    return $this;
	}

	/**
	* Get idSubtipoProcedMedico
	*
	* @return null|Integer
	*/
	public function getIdSubtipoProcedMedico()
	{
		return $this->idSubtipoProcedMedico;
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

	public function borrarPorParametro($param, $value){
		return parent::borrar($param . " = " . $value);
	}

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return DetalleFactorRiesgoModelo
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
