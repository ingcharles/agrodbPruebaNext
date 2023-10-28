<?php
 /**
 * Modelo RedistribucionCuvModelo
 *
 * Este archivo se complementa con el archivo   RedistribucionCuvLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    RedistribucionCuvModelo
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class RedistribucionCuvModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Llave principal de la tabla
		*/
		protected $idRedistribucionCuv;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Llave foránea (redundante) de la tabla g_asignacion_cuv.solicitud_redistribucion_cuv(Origen)
		*/
		protected $idSolicitudRedistribucionCuv;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Rango inicial de cuv que pueden ser redistribuidos
		*/
		protected $codigoCuvInicio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Rango final de cuv que pueden ser redistribuidos
		*/
		protected $codigoCuvFin;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Estado de la redistribucion
		*/
		protected $estado;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha en la que se realiza la redistribución
		*/
		protected $fechaRedistribucion;

				/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Cantidad reasignada de la redistribucion
		*/
		protected $cantidadReasignada;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_asignacion_cuv";

	/**
	* Nombre de la tabla: redistribucion_cuv
	* 
	 */
	Private $tabla="redistribucion_cuv";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_redistribucion_cuv";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_asignacion_cuv"."redistribucion_cuv_id_redistribucion_cuv_seq'; 



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
		throw new \Exception('Clase Modelo: RedistribucionCuvModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: RedistribucionCuvModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_asignacion_cuv
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idRedistribucionCuv
	*
	*Llave principal de la tabla
	*
	* @parámetro Integer $idRedistribucionCuv
	* @return IdRedistribucionCuv
	*/
	public function setIdRedistribucionCuv($idRedistribucionCuv)
	{
	  $this->idRedistribucionCuv = (Integer) $idRedistribucionCuv;
	    return $this;
	}

	/**
	* Get idRedistribucionCuv
	*
	* @return null|Integer
	*/
	public function getIdRedistribucionCuv()
	{
		return $this->idRedistribucionCuv;
	}

	/**
	* Set idSolicitudRedistribucionCuv
	*
	*Llave foránea (redundante) de la tabla g_asignacion_cuv.solicitud_redistribucion_cuv(Origen)
	*
	* @parámetro Integer $idSolicitudRedistribucionCuv
	* @return IdSolicitudRedistribucionCuv
	*/
	public function setIdSolicitudRedistribucionCuv($idSolicitudRedistribucionCuv)
	{
	  $this->idSolicitudRedistribucionCuv = (Integer) $idSolicitudRedistribucionCuv;
	    return $this;
	}

	/**
	* Get idSolicitudRedistribucionCuv
	*
	* @return null|Integer
	*/
	public function getIdSolicitudRedistribucionCuv()
	{
		return $this->idSolicitudRedistribucionCuv;
	}

	/**
	* Set codigoCuvInicio
	*
	*Rango inicial de cuv que pueden ser redistribuidos
	*
	* @parámetro String $codigoCuvInicio
	* @return CodigoCuvInicio
	*/
	public function setCodigoCuvInicio($codigoCuvInicio)
	{
	  $this->codigoCuvInicio = (String) $codigoCuvInicio;
	    return $this;
	}

	/**
	* Get codigoCuvInicio
	*
	* @return null|String
	*/
	public function getCodigoCuvInicio()
	{
		return $this->codigoCuvInicio;
	}

	/**
	* Set codigoCuvFin
	*
	*Rango final de cuv que pueden ser redistribuidos
	*
	* @parámetro String $codigoCuvFin
	* @return CodigoCuvFin
	*/
	public function setCodigoCuvFin($codigoCuvFin)
	{
	  $this->codigoCuvFin = (String) $codigoCuvFin;
	    return $this;
	}

	/**
	* Get codigoCuvFin
	*
	* @return null|String
	*/
	public function getCodigoCuvFin()
	{
		return $this->codigoCuvFin;
	}

	/**
	* Set estado
	*
	*Estado de la redistribucion
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
	* Set fechaRedistribucion
	*
	*Fecha en la que se realiza la redistribución
	*
	* @parámetro Date $fechaRedistribucion
	* @return FechaRedistribucion
	*/
	public function setFechaRedistribucion($fechaRedistribucion)
	{
	  $this->fechaRedistribucion = (String) $fechaRedistribucion;
	    return $this;
	}

	/**
	* Get fechaRedistribucion
	*
	* @return null|Date
	*/
	public function getFechaRedistribucion()
	{
		return $this->fechaRedistribucion;
	}

		/**
	* Set cantidad_reasignada
	*
	*cantidad_reasignada de la redistribucion
	*
	* @parámetro String $estado
	* @return Estado
	*/
	public function setCantidadReasignada($cantidadReasignada)
	{
	  $this->cantidadReasignada = (String) $cantidadReasignada;
	    return $this;
	}

	/**
	* Get cantidad_reasignada
	*
	* @return null|String
	*/
	public function getCantidadReasignada()
	{
		return $this->cantidadReasignada;
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
	* @return RedistribucionCuvModelo
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
