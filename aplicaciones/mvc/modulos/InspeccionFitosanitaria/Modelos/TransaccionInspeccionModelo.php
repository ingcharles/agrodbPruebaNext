<?php
 /**
 * Modelo TransaccionInspeccionModelo
 *
 * Este archivo se complementa con el archivo   TransaccionInspeccionLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    TransaccionInspeccionModelo
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
  namespace Agrodb\InspeccionFitosanitaria\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class TransaccionInspeccionModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idTransaccionInspeccion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_inspecciones_fitosanitarias.inspeccion_fitosanitaria
		*/
		protected $idInspeccionFitosanitaria;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_inspecciones_fitosanitarias.productos_inspeccion_fitosanitaria
		*/
		protected $idProductoInspeccionFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el valor de ingreso de la cantidad
		*/
		protected $valorIngreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el valor de egreso de la cantidad
		*/
		protected $valorEgreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el valor total de la cantidad
		*/
		protected $valorTotal;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_certificado_fitosanitario.certificado_fitosanitario
		*/
		protected $idCertificadoFitosanitario;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de creacion del registro
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
	Private $esquema ="g_inspeccion_fitosanitaria";

	/**
	* Nombre de la tabla: transaccion_inspeccion
	* 
	 */
	Private $tabla="transaccion_inspeccion";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_transaccion_inspeccion";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_inspeccion_fitosanitaria"."transaccion_inspeccion_id_transaccion_inspeccion_seq'; 



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
		throw new \Exception('Clase Modelo: TransaccionInspeccionModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: TransaccionInspeccionModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_inspeccion_fitosanitaria
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idTransaccionInspeccion
	*
	*
	*
	* @parámetro Integer $idTransaccionInspeccion
	* @return IdTransaccionInspeccion
	*/
	public function setIdTransaccionInspeccion($idTransaccionInspeccion)
	{
	  $this->idTransaccionInspeccion = (Integer) $idTransaccionInspeccion;
	    return $this;
	}

	/**
	* Get idTransaccionInspeccion
	*
	* @return null|Integer
	*/
	public function getIdTransaccionInspeccion()
	{
		return $this->idTransaccionInspeccion;
	}

	/**
	* Set idInspeccionFitosanitaria
	*
	*Identificador unico de la tabla g_inspecciones_fitosanitarias.inspeccion_fitosanitaria
	*
	* @parámetro Integer $idInspeccionFitosanitaria
	* @return IdInspeccionFitosanitaria
	*/
	public function setIdInspeccionFitosanitaria($idInspeccionFitosanitaria)
	{
	  $this->idInspeccionFitosanitaria = (Integer) $idInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get idInspeccionFitosanitaria
	*
	* @return null|Integer
	*/
	public function getIdInspeccionFitosanitaria()
	{
		return $this->idInspeccionFitosanitaria;
	}

	/**
	* Set idProductoInspeccionFitosanitaria
	*
	*Identificador unico de la tabla g_inspecciones_fitosanitarias.productos_inspeccion_fitosanitaria
	*
	* @parámetro Integer $idProductoInspeccionFitosanitaria
	* @return IdProductoInspeccionFitosanitaria
	*/
	public function setIdProductoInspeccionFitosanitaria($idProductoInspeccionFitosanitaria)
	{
	  $this->idProductoInspeccionFitosanitaria = (Integer) $idProductoInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get idProductoInspeccionFitosanitaria
	*
	* @return null|Integer
	*/
	public function getIdProductoInspeccionFitosanitaria()
	{
		return $this->idProductoInspeccionFitosanitaria;
	}

	/**
	* Set valorIngreso
	*
	*Campo que almacena el valor de ingreso de la cantidad
	*
	* @parámetro String $valorIngreso
	* @return ValorIngreso
	*/
	public function setValorIngreso($valorIngreso)
	{
	  $this->valorIngreso = (String) $valorIngreso;
	    return $this;
	}

	/**
	* Get valorIngreso
	*
	* @return null|String
	*/
	public function getValorIngreso()
	{
		return $this->valorIngreso;
	}

	/**
	* Set valorEgreso
	*
	*Campo que almacena el valor de egreso de la cantidad
	*
	* @parámetro String $valorEgreso
	* @return ValorEgreso
	*/
	public function setValorEgreso($valorEgreso)
	{
	  $this->valorEgreso = (String) $valorEgreso;
	    return $this;
	}

	/**
	* Get valorEgreso
	*
	* @return null|String
	*/
	public function getValorEgreso()
	{
		return $this->valorEgreso;
	}

	/**
	* Set valorTotal
	*
	*Campo que almacena el valor total de la cantidad
	*
	* @parámetro String $valorTotal
	* @return ValorTotal
	*/
	public function setValorTotal($valorTotal)
	{
	  $this->valorTotal = (String) $valorTotal;
	    return $this;
	}

	/**
	* Get valorTotal
	*
	* @return null|String
	*/
	public function getValorTotal()
	{
		return $this->valorTotal;
	}

	/**
	* Set idCertificadoFitosanitario
	*
	*Identificador unico de la tabla g_certificado_fitosanitario.certificado_fitosanitario
	*
	* @parámetro Integer $idCertificadoFitosanitario
	* @return IdCertificadoFitosanitario
	*/
	public function setIdCertificadoFitosanitario($idCertificadoFitosanitario)
	{
	  $this->idCertificadoFitosanitario = (Integer) $idCertificadoFitosanitario;
	    return $this;
	}

	/**
	* Get idCertificadoFitosanitario
	*
	* @return null|Integer
	*/
	public function getIdCertificadoFitosanitario()
	{
		return $this->idCertificadoFitosanitario;
	}

	/**
	* Set fechaCreacion
	*
	*Campo que almacena la fecha de creacion del registro
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

	/**
	*
	* Buscar un registro de con la clave primaria
	*
	* @param  int $id
	* @return TransaccionInspeccionModelo
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
