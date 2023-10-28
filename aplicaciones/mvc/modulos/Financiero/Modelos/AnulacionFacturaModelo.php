<?php
 /**
 * Modelo AnulacionFacturaModelo
 *
 * Este archivo se complementa con el archivo   AnulacionFacturaLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    AnulacionFacturaModelo
 * @package Financiero
 * @subpackage Modelos
 */
  namespace Agrodb\Financiero\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class AnulacionFacturaModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla
		*/
		protected $idAnulacionFactura;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla orden_pago
		*/
		protected $idPago;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador del usuario que realiza la anulacion
		*/
		protected $identificadorUsuario;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el numero de GLPI de solicitud de anulacion
		*/
		protected $numeroGlpi;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el motivo de anulacion de la factura
		*/
		protected $motivoAnulacion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almecena la fecha de anulacion de la factura
		*/
		protected $fechaAnulacionFactura;

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
	* Nombre de la tabla: anulacion_factura
	* 
	 */
	Private $tabla="anulacion_factura";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_anulacion_factura";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_financiero"."anulacion_factura_id_anulacion_factura_seq'; 



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
		throw new \Exception('Clase Modelo: AnulacionFacturaModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: AnulacionFacturaModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idAnulacionFactura
	*
	*Identificador unico de la tabla
	*
	* @parámetro Integer $idAnulacionFactura
	* @return IdAnulacionFactura
	*/
	public function setIdAnulacionFactura($idAnulacionFactura)
	{
	  $this->idAnulacionFactura = (Integer) $idAnulacionFactura;
	    return $this;
	}

	/**
	* Get idAnulacionFactura
	*
	* @return null|Integer
	*/
	public function getIdAnulacionFactura()
	{
		return $this->idAnulacionFactura;
	}

	/**
	* Set idPago
	*
	*Identificador de la tabla orden_pago
	*
	* @parámetro Integer $idPago
	* @return IdPago
	*/
	public function setIdPago($idPago)
	{
	  $this->idPago = (Integer) $idPago;
	    return $this;
	}

	/**
	* Get idPago
	*
	* @return null|Integer
	*/
	public function getIdPago()
	{
		return $this->idPago;
	}

	/**
	* Set identificadorUsuario
	*
	*Campo que almacena el identificador del usuario que realiza la anulacion
	*
	* @parámetro String $identificadorUsuario
	* @return IdentificadorUsuario
	*/
	public function setIdentificadorUsuario($identificadorUsuario)
	{
	  $this->identificadorUsuario = (String) $identificadorUsuario;
	    return $this;
	}

	/**
	* Get identificadorUsuario
	*
	* @return null|String
	*/
	public function getIdentificadorUsuario()
	{
		return $this->identificadorUsuario;
	}

	/**
	* Set numeroGlpi
	*
	*Campo que almacena el numero de GLPI de solicitud de anulacion
	*
	* @parámetro Integer $numeroGlpi
	* @return NumeroGlpi
	*/
	public function setNumeroGlpi($numeroGlpi)
	{
	  $this->numeroGlpi = (Integer) $numeroGlpi;
	    return $this;
	}

	/**
	* Get numeroGlpi
	*
	* @return null|Integer
	*/
	public function getNumeroGlpi()
	{
		return $this->numeroGlpi;
	}

	/**
	* Set motivoAnulacion
	*
	*Campo que almacena el motivo de anulacion de la factura
	*
	* @parámetro String $motivoAnulacion
	* @return MotivoAnulacion
	*/
	public function setMotivoAnulacion($motivoAnulacion)
	{
	  $this->motivoAnulacion = (String) $motivoAnulacion;
	    return $this;
	}

	/**
	* Get motivoAnulacion
	*
	* @return null|String
	*/
	public function getMotivoAnulacion()
	{
		return $this->motivoAnulacion;
	}

	/**
	* Set fechaAnulacionFactura
	*
	*Campo que almecena la fecha de anulacion de la factura
	*
	* @parámetro Date $fechaAnulacionFactura
	* @return FechaAnulacionFactura
	*/
	public function setFechaAnulacionFactura($fechaAnulacionFactura)
	{
	  $this->fechaAnulacionFactura = (String) $fechaAnulacionFactura;
	    return $this;
	}

	/**
	* Get fechaAnulacionFactura
	*
	* @return null|Date
	*/
	public function getFechaAnulacionFactura()
	{
		return $this->fechaAnulacionFactura;
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
	* @return AnulacionFacturaModelo
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
