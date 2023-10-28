<?php
 /**
 * Modelo TransitoDetalleProductosModelo
 *
 * Este archivo se complementa con el archivo   TransitoDetalleProductosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-11-08
 * @uses    TransitoDetalleProductosModelo
 * @package TransitoInternacional
 * @subpackage Modelos
 */
  namespace Agrodb\TransitoInternacional\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class TransitoDetalleProductosModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único del registro
		*/
		protected $idTransitoDetalleProductos;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de tránsito internacional
		*/
		protected $idTransitoInternacional;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de creación del registro
		*/
		protected $fechaCreacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Número de Solicitud VUE
		*/
		protected $reqNo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Número de la subpartida arancelaria
		*/
		protected $subpartidaArancelaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Descripción de la subpartida arancelaria
		*/
		protected $subpartidaArancelariaDescripcion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id del tipo de producto
		*/
		protected $idTipoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del tipo deproducto
		*/
		protected $nombreTipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id del subtipo de producto
		*/
		protected $idSubtipoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del subtipo de producto
		*/
		protected $nombreSubtipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id del producto
		*/
		protected $idProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código de producto VUE
		*/
		protected $codigoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del producto
		*/
		protected $nombreProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id de unidad de medida para peso
		*/
		protected $idUnidadPeso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la unidad de medida para peso
		*/
		protected $nombreUnidadPeso;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id de unidad de media para cantidad
		*/
		protected $idUnidadCantidad;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la unidad de medida para cantidad
		*/
		protected $nombreUnidadCantidad;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Cantidad de producto
		*/
		protected $cantidadProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Peso del producto en kilos
		*/
		protected $pesoKilos;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_transito_internacional";

	/**
	* Nombre de la tabla: transito_detalle_productos
	* 
	 */
	Private $tabla="transito_detalle_productos";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_transito_detalle_productos";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_transito_internacional"."TransitoDetalleProductos_id_transito_detalle_productos_seq'; 



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
		throw new \Exception('Clase Modelo: TransitoDetalleProductosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: TransitoDetalleProductosModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_transito_internacional
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idTransitoDetalleProductos
	*
	*Identificador único del registro
	*
	* @parámetro Integer $idTransitoDetalleProductos
	* @return IdTransitoDetalleProductos
	*/
	public function setIdTransitoDetalleProductos($idTransitoDetalleProductos)
	{
	  $this->idTransitoDetalleProductos = (Integer) $idTransitoDetalleProductos;
	    return $this;
	}

	/**
	* Get idTransitoDetalleProductos
	*
	* @return null|Integer
	*/
	public function getIdTransitoDetalleProductos()
	{
		return $this->idTransitoDetalleProductos;
	}

	/**
	* Set idTransitoInternacional
	*
	*Identificador de tránsito internacional
	*
	* @parámetro Integer $idTransitoInternacional
	* @return IdTransitoInternacional
	*/
	public function setIdTransitoInternacional($idTransitoInternacional)
	{
	  $this->idTransitoInternacional = (Integer) $idTransitoInternacional;
	    return $this;
	}

	/**
	* Get idTransitoInternacional
	*
	* @return null|Integer
	*/
	public function getIdTransitoInternacional()
	{
		return $this->idTransitoInternacional;
	}

	/**
	* Set fechaCreacion
	*
	*Fecha de creación del registro
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
	* Set reqNo
	*
	*Número de Solicitud VUE
	*
	* @parámetro String $reqNo
	* @return ReqNo
	*/
	public function setReqNo($reqNo)
	{
	  $this->reqNo = (String) $reqNo;
	    return $this;
	}

	/**
	* Get reqNo
	*
	* @return null|String
	*/
	public function getReqNo()
	{
		return $this->reqNo;
	}

	/**
	* Set subpartidaArancelaria
	*
	*Número de la subpartida arancelaria
	*
	* @parámetro String $subpartidaArancelaria
	* @return SubpartidaArancelaria
	*/
	public function setSubpartidaArancelaria($subpartidaArancelaria)
	{
	  $this->subpartidaArancelaria = (String) $subpartidaArancelaria;
	    return $this;
	}

	/**
	* Get subpartidaArancelaria
	*
	* @return null|String
	*/
	public function getSubpartidaArancelaria()
	{
		return $this->subpartidaArancelaria;
	}

	/**
	* Set subpartidaArancelariaDescripcion
	*
	*Descripción de la subpartida arancelaria
	*
	* @parámetro String $subpartidaArancelariaDescripcion
	* @return SubpartidaArancelariaDescripcion
	*/
	public function setSubpartidaArancelariaDescripcion($subpartidaArancelariaDescripcion)
	{
	  $this->subpartidaArancelariaDescripcion = (String) $subpartidaArancelariaDescripcion;
	    return $this;
	}

	/**
	* Get subpartidaArancelariaDescripcion
	*
	* @return null|String
	*/
	public function getSubpartidaArancelariaDescripcion()
	{
		return $this->subpartidaArancelariaDescripcion;
	}

	/**
	* Set idTipoProducto
	*
	*Id del tipo de producto
	*
	* @parámetro Integer $idTipoProducto
	* @return IdTipoProducto
	*/
	public function setIdTipoProducto($idTipoProducto)
	{
	  $this->idTipoProducto = (Integer) $idTipoProducto;
	    return $this;
	}

	/**
	* Get idTipoProducto
	*
	* @return null|Integer
	*/
	public function getIdTipoProducto()
	{
		return $this->idTipoProducto;
	}

	/**
	* Set nombreTipoProducto
	*
	*Nombre del tipo deproducto
	*
	* @parámetro String $nombreTipoProducto
	* @return NombreTipoProducto
	*/
	public function setNombreTipoProducto($nombreTipoProducto)
	{
	  $this->nombreTipoProducto = (String) $nombreTipoProducto;
	    return $this;
	}

	/**
	* Get nombreTipoProducto
	*
	* @return null|String
	*/
	public function getNombreTipoProducto()
	{
		return $this->nombreTipoProducto;
	}

	/**
	* Set idSubtipoProducto
	*
	*Id del subtipo de producto
	*
	* @parámetro Integer $idSubtipoProducto
	* @return IdSubtipoProducto
	*/
	public function setIdSubtipoProducto($idSubtipoProducto)
	{
	  $this->idSubtipoProducto = (Integer) $idSubtipoProducto;
	    return $this;
	}

	/**
	* Get idSubtipoProducto
	*
	* @return null|Integer
	*/
	public function getIdSubtipoProducto()
	{
		return $this->idSubtipoProducto;
	}

	/**
	* Set nombreSubtipoProducto
	*
	*Nombre del subtipo de producto
	*
	* @parámetro String $nombreSubtipoProducto
	* @return NombreSubtipoProducto
	*/
	public function setNombreSubtipoProducto($nombreSubtipoProducto)
	{
	  $this->nombreSubtipoProducto = (String) $nombreSubtipoProducto;
	    return $this;
	}

	/**
	* Get nombreSubtipoProducto
	*
	* @return null|String
	*/
	public function getNombreSubtipoProducto()
	{
		return $this->nombreSubtipoProducto;
	}

	/**
	* Set idProducto
	*
	*Id del producto
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
	* Set codigoProducto
	*
	*Código de producto VUE
	*
	* @parámetro String $codigoProducto
	* @return CodigoProducto
	*/
	public function setCodigoProducto($codigoProducto)
	{
	  $this->codigoProducto = (String) $codigoProducto;
	    return $this;
	}

	/**
	* Get codigoProducto
	*
	* @return null|String
	*/
	public function getCodigoProducto()
	{
		return $this->codigoProducto;
	}

	/**
	* Set nombreProducto
	*
	*Nombre del producto
	*
	* @parámetro String $nombreProducto
	* @return NombreProducto
	*/
	public function setNombreProducto($nombreProducto)
	{
	  $this->nombreProducto = (String) $nombreProducto;
	    return $this;
	}

	/**
	* Get nombreProducto
	*
	* @return null|String
	*/
	public function getNombreProducto()
	{
		return $this->nombreProducto;
	}

	/**
	* Set idUnidadPeso
	*
	*Id de unidad de medida para peso
	*
	* @parámetro Integer $idUnidadPeso
	* @return IdUnidadPeso
	*/
	public function setIdUnidadPeso($idUnidadPeso)
	{
	  $this->idUnidadPeso = (Integer) $idUnidadPeso;
	    return $this;
	}

	/**
	* Get idUnidadPeso
	*
	* @return null|Integer
	*/
	public function getIdUnidadPeso()
	{
		return $this->idUnidadPeso;
	}

	/**
	* Set nombreUnidadPeso
	*
	*Nombre de la unidad de medida para peso
	*
	* @parámetro String $nombreUnidadPeso
	* @return NombreUnidadPeso
	*/
	public function setNombreUnidadPeso($nombreUnidadPeso)
	{
	  $this->nombreUnidadPeso = (String) $nombreUnidadPeso;
	    return $this;
	}

	/**
	* Get nombreUnidadPeso
	*
	* @return null|String
	*/
	public function getNombreUnidadPeso()
	{
		return $this->nombreUnidadPeso;
	}

	/**
	* Set idUnidadCantidad
	*
	*Id de unidad de media para cantidad
	*
	* @parámetro Integer $idUnidadCantidad
	* @return IdUnidadCantidad
	*/
	public function setIdUnidadCantidad($idUnidadCantidad)
	{
	  $this->idUnidadCantidad = (Integer) $idUnidadCantidad;
	    return $this;
	}

	/**
	* Get idUnidadCantidad
	*
	* @return null|Integer
	*/
	public function getIdUnidadCantidad()
	{
		return $this->idUnidadCantidad;
	}

	/**
	* Set nombreUnidadCantidad
	*
	*Nombre de la unidad de medida para cantidad
	*
	* @parámetro String $nombreUnidadCantidad
	* @return NombreUnidadCantidad
	*/
	public function setNombreUnidadCantidad($nombreUnidadCantidad)
	{
	  $this->nombreUnidadCantidad = (String) $nombreUnidadCantidad;
	    return $this;
	}

	/**
	* Get nombreUnidadCantidad
	*
	* @return null|String
	*/
	public function getNombreUnidadCantidad()
	{
		return $this->nombreUnidadCantidad;
	}

	/**
	* Set cantidadProducto
	*
	*Cantidad de producto
	*
	* @parámetro String $cantidadProducto
	* @return CantidadProducto
	*/
	public function setCantidadProducto($cantidadProducto)
	{
	  $this->cantidadProducto = (String) $cantidadProducto;
	    return $this;
	}

	/**
	* Get cantidadProducto
	*
	* @return null|String
	*/
	public function getCantidadProducto()
	{
		return $this->cantidadProducto;
	}

	/**
	* Set pesoKilos
	*
	*Peso del producto en kilos
	*
	* @parámetro String $pesoKilos
	* @return PesoKilos
	*/
	public function setPesoKilos($pesoKilos)
	{
	  $this->pesoKilos = (String) $pesoKilos;
	    return $this;
	}

	/**
	* Get pesoKilos
	*
	* @return null|String
	*/
	public function getPesoKilos()
	{
		return $this->pesoKilos;
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
	* @return TransitoDetalleProductosModelo
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
