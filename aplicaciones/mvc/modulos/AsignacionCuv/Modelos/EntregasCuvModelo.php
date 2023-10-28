<?php
 /**
 * Modelo EntregasCuvModelo
 *
 * Este archivo se complementa con el archivo   EntregasCuvLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    EntregasCuvModelo
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class EntregasCuvModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo opcional
		* Campo visible en el formulario
		* Llave principal de la tabla
		*/
		protected $idEntregasCuv;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Llave foránea (redundante) de la tabla g_asignacion_cuv.solicitud_asignacion_cuv(Origen)
		*/
		protected $idSolicitudAsignacionCuv;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Rango inicial de cuv que pueden ser asignados
		*/
		protected $codigoCuvInicio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Rango final de cuv que pueden ser asignados
		*/
		protected $codigoCuvFin;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Cantidad que se requiere asignar a cada provincia
		*/
		protected $cantidad;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Estado de la asignacion
		*/
		protected $estado;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha en la que se entrego los cuvs
		*/
		protected $fechaEntrega;

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
	* Nombre de la tabla: entregas_cuv
	* 
	 */
	Private $tabla="entregas_cuv";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_entregas_cuv";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_asignacion_cuv"."entregas_cuv_id_entregas_cuv_seq'; 



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
		throw new \Exception('Clase Modelo: EntregasCuvModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: EntregasCuvModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idEntregasCuv
	*
	*Llave principal de la tabla
	*
	* @parámetro Integer $idEntregasCuv
	* @return IdEntregasCuv
	*/
	public function setIdEntregasCuv($idEntregasCuv)
	{
	  $this->idEntregasCuv = (Integer) $idEntregasCuv;
	    return $this;
	}

	/**
	* Get idEntregasCuv
	*
	* @return null|Integer
	*/
	public function getIdEntregasCuv()
	{
		return $this->idEntregasCuv;
	}

	/**
	* Set idSolicitudAsignacionCuv
	*
	*Llave foránea (redundante) de la tabla g_asignacion_cuv.solicitud_asignacion_cuv(Origen)
	*
	* @parámetro Integer $idSolicitudAsignacionCuv
	* @return IdSolicitudAsignacionCuv
	*/
	public function setIdSolicitudAsignacionCuv($idSolicitudAsignacionCuv)
	{
	  $this->idSolicitudAsignacionCuv = (Integer) $idSolicitudAsignacionCuv;
	    return $this;
	}

	/**
	* Get idSolicitudAsignacionCuv
	*
	* @return null|Integer
	*/
	public function getIdSolicitudAsignacionCuv()
	{
		return $this->idSolicitudAsignacionCuv;
	}

	/**
	* Set codigoCuvInicio
	*
	*Rango inicial de cuv que pueden ser asignados
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
	*Rango final de cuv que pueden ser asignados
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
	* Set cantidad
	*
	*Cantidad que se requiere asignar a cada provincia
	*
	* @parámetro Integer $cantidad
	* @return Cantidad
	*/
	public function setCantidad($cantidad)
	{
	  $this->cantidad = (Integer) $cantidad;
	    return $this;
	}

	/**
	* Get cantidad
	*
	* @return null|Integer
	*/
	public function getCantidad()
	{
		return $this->cantidad;
	}

	/**
	* Set estado
	*
	*Estado de la asignacion
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
	* Set fechaEntrega
	*
	*Fecha en la que se entrego los cuvs
	*
	* @parámetro Date $fechaEntrega
	* @return FechaEntrega
	*/
	public function setFechaEntrega($fechaEntrega)
	{
	  $this->fechaEntrega = (String) $fechaEntrega;
	    return $this;
	}

	/**
	* Get fechaEntrega
	*
	* @return null|Date
	*/
	public function getFechaEntrega()
	{
		return $this->fechaEntrega;
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
	* @return EntregasCuvModelo
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
