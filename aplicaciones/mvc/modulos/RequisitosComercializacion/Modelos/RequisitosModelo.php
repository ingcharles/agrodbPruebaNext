<?php
 /**
 * Modelo RequisitosModelo
 *
 * Este archivo se complementa con el archivo   RequisitosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2019-09-10
 * @uses    RequisitosModelo
 * @package RequisitoComercializacion
 * @subpackage Modelos
 */
  namespace Agrodb\RequisitosComercializacion\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class RequisitosModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idRequisito;
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
		protected $rutaArchivo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $estado;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $tipo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $detalle;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $detalleImpreso;
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
		protected $fechaModificacion;
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
		protected $identificadorCreacionRequisito;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $identificadorModificacionRequisito;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_requisitos";

	/**
	* Nombre de la tabla: requisitos
	* 
	 */
	Private $tabla="requisitos";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_requisito";



	/**
	*Secuencia
*/
		 private $secuencial = '"Requisitos_"id_requisito_seq'; 



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
		throw new \Exception('Clase Modelo: RequisitosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: RequisitosModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_requisitos
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idRequisito
	*
	*
	*
	* @parámetro Integer $idRequisito
	* @return IdRequisito
	*/
	public function setIdRequisito($idRequisito)
	{
	  $this->idRequisito = (Integer) $idRequisito;
	    return $this;
	}

	/**
	* Get idRequisito
	*
	* @return null|Integer
	*/
	public function getIdRequisito()
	{
		return $this->idRequisito;
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
	* Set rutaArchivo
	*
	*
	*
	* @parámetro String $rutaArchivo
	* @return RutaArchivo
	*/
	public function setRutaArchivo($rutaArchivo)
	{
	  $this->rutaArchivo = (String) $rutaArchivo;
	    return $this;
	}

	/**
	* Get rutaArchivo
	*
	* @return null|String
	*/
	public function getRutaArchivo()
	{
		return $this->rutaArchivo;
	}

	/**
	* Set estado
	*
	*
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
	* Set idArea
	*
	*
	*
	* @parámetro String $idArea
	* @return IdArea
	*/
	public function setIdArea($idArea)
	{
	  $this->idArea = (String) $idArea;
	    return $this;
	}

	/**
	* Get idArea
	*
	* @return null|String
	*/
	public function getIdArea()
	{
		return $this->idArea;
	}

	/**
	* Set tipo
	*
	*
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
	* Set detalle
	*
	*
	*
	* @parámetro String $detalle
	* @return Detalle
	*/
	public function setDetalle($detalle)
	{
	  $this->detalle = (String) $detalle;
	    return $this;
	}

	/**
	* Get detalle
	*
	* @return null|String
	*/
	public function getDetalle()
	{
		return $this->detalle;
	}

	/**
	* Set detalleImpreso
	*
	*
	*
	* @parámetro String $detalleImpreso
	* @return DetalleImpreso
	*/
	public function setDetalleImpreso($detalleImpreso)
	{
	  $this->detalleImpreso = (String) $detalleImpreso;
	    return $this;
	}

	/**
	* Get detalleImpreso
	*
	* @return null|String
	*/
	public function getDetalleImpreso()
	{
		return $this->detalleImpreso;
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
	* Set fechaModificacion
	*
	*
	*
	* @parámetro Date $fechaModificacion
	* @return FechaModificacion
	*/
	public function setFechaModificacion($fechaModificacion)
	{
	  $this->fechaModificacion = (String) $fechaModificacion;
	    return $this;
	}

	/**
	* Get fechaModificacion
	*
	* @return null|Date
	*/
	public function getFechaModificacion()
	{
		return $this->fechaModificacion;
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
	* Set identificadorCreacionRequisito
	*
	*
	*
	* @parámetro String $identificadorCreacionRequisito
	* @return IdentificadorCreacionRequisito
	*/
	public function setIdentificadorCreacionRequisito($identificadorCreacionRequisito)
	{
	  $this->identificadorCreacionRequisito = (String) $identificadorCreacionRequisito;
	    return $this;
	}

	/**
	* Get identificadorCreacionRequisito
	*
	* @return null|String
	*/
	public function getIdentificadorCreacionRequisito()
	{
		return $this->identificadorCreacionRequisito;
	}

	/**
	* Set identificadorModificacionRequisito
	*
	*
	*
	* @parámetro String $identificadorModificacionRequisito
	* @return IdentificadorModificacionRequisito
	*/
	public function setIdentificadorModificacionRequisito($identificadorModificacionRequisito)
	{
	  $this->identificadorModificacionRequisito = (String) $identificadorModificacionRequisito;
	    return $this;
	}

	/**
	* Get identificadorModificacionRequisito
	*
	* @return null|String
	*/
	public function getIdentificadorModificacionRequisito()
	{
		return $this->identificadorModificacionRequisito;
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
	* @return RequisitosModelo
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
