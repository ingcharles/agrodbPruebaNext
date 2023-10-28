<?php
 /**
 * Modelo TransaccionInspeccionFitosanitariaModelo
 *
 * Este archivo se complementa con el archivo   TransaccionInspeccionFitosanitariaLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    TransaccionInspeccionFitosanitariaModelo
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
  namespace Agrodb\InspeccionFitosanitaria\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class TransaccionInspeccionFitosanitariaModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idTransaccionInspeccionFitosanitaria;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_inspecciones_fitosanitarias.total_inspeccion_fitosanitaria
		*/
		protected $idTotalInspeccionFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena un igreso de cantidad aprobada
		*/
		protected $cantidadAprobadaIngreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena un egreso de cantidad aprobada
		*/
		protected $cantidadAprobadaEgreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el total de cantidad aprobada existente
		*/
		protected $totalCantidadAprobada;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena un ingreso de peso aprobado
		*/
		protected $pesoAprobadoIngreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena un egreso de peso aprobado
		*/
		protected $pesoAprobadoEgreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el total del peso aprobado existente
		*/
		protected $totalPesoAprobado;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
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
	Private $esquema ="g_inspeccion_fitosanitaria";

	/**
	* Nombre de la tabla: transaccion_inspeccion_fitosanitaria
	* 
	 */
	Private $tabla="transaccion_inspeccion_fitosanitaria";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_transaccion_inspeccion_fitosanitaria";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_inspeccion_fitosanitaria"."TransaccionInspeccionFitosanitaria_id_transaccion_inspeccion_fitosanitaria_seq'; 



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
		throw new \Exception('Clase Modelo: TransaccionInspeccionFitosanitariaModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: TransaccionInspeccionFitosanitariaModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idTransaccionInspeccionFitosanitaria
	*
	*
	*
	* @parámetro Integer $idTransaccionInspeccionFitosanitaria
	* @return IdTransaccionInspeccionFitosanitaria
	*/
	public function setIdTransaccionInspeccionFitosanitaria($idTransaccionInspeccionFitosanitaria)
	{
	  $this->idTransaccionInspeccionFitosanitaria = (Integer) $idTransaccionInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get idTransaccionInspeccionFitosanitaria
	*
	* @return null|Integer
	*/
	public function getIdTransaccionInspeccionFitosanitaria()
	{
		return $this->idTransaccionInspeccionFitosanitaria;
	}

	/**
	* Set idTotalInspeccionFitosanitaria
	*
	*Identificador unico de la tabla g_inspecciones_fitosanitarias.total_inspeccion_fitosanitaria
	*
	* @parámetro Integer $idTotalInspeccionFitosanitaria
	* @return IdTotalInspeccionFitosanitaria
	*/
	public function setIdTotalInspeccionFitosanitaria($idTotalInspeccionFitosanitaria)
	{
	  $this->idTotalInspeccionFitosanitaria = (Integer) $idTotalInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get idTotalInspeccionFitosanitaria
	*
	* @return null|Integer
	*/
	public function getIdTotalInspeccionFitosanitaria()
	{
		return $this->idTotalInspeccionFitosanitaria;
	}

	/**
	* Set cantidadAprobadaIngreso
	*
	*Campo que almacena un igreso de cantidad aprobada
	*
	* @parámetro String $cantidadAprobadaIngreso
	* @return CantidadAprobadaIngreso
	*/
	public function setCantidadAprobadaIngreso($cantidadAprobadaIngreso)
	{
	  $this->cantidadAprobadaIngreso = (String) $cantidadAprobadaIngreso;
	    return $this;
	}

	/**
	* Get cantidadAprobadaIngreso
	*
	* @return null|String
	*/
	public function getCantidadAprobadaIngreso()
	{
		return $this->cantidadAprobadaIngreso;
	}

	/**
	* Set cantidadAprobadaEgreso
	*
	*Campo que almacena un egreso de cantidad aprobada
	*
	* @parámetro String $cantidadAprobadaEgreso
	* @return CantidadAprobadaEgreso
	*/
	public function setCantidadAprobadaEgreso($cantidadAprobadaEgreso)
	{
	  $this->cantidadAprobadaEgreso = (String) $cantidadAprobadaEgreso;
	    return $this;
	}

	/**
	* Get cantidadAprobadaEgreso
	*
	* @return null|String
	*/
	public function getCantidadAprobadaEgreso()
	{
		return $this->cantidadAprobadaEgreso;
	}

	/**
	* Set totalCantidadAprobada
	*
	*Campo que almacena el total de cantidad aprobada existente
	*
	* @parámetro String $totalCantidadAprobada
	* @return TotalCantidadAprobada
	*/
	public function setTotalCantidadAprobada($totalCantidadAprobada)
	{
	  $this->totalCantidadAprobada = (String) $totalCantidadAprobada;
	    return $this;
	}

	/**
	* Get totalCantidadAprobada
	*
	* @return null|String
	*/
	public function getTotalCantidadAprobada()
	{
		return $this->totalCantidadAprobada;
	}

	/**
	* Set pesoAprobadoIngreso
	*
	*Campo que almacena un ingreso de peso aprobado
	*
	* @parámetro String $pesoAprobadoIngreso
	* @return PesoAprobadoIngreso
	*/
	public function setPesoAprobadoIngreso($pesoAprobadoIngreso)
	{
	  $this->pesoAprobadoIngreso = (String) $pesoAprobadoIngreso;
	    return $this;
	}

	/**
	* Get pesoAprobadoIngreso
	*
	* @return null|String
	*/
	public function getPesoAprobadoIngreso()
	{
		return $this->pesoAprobadoIngreso;
	}

	/**
	* Set pesoAprobadoEgreso
	*
	*Campo que almacena un egreso de peso aprobado
	*
	* @parámetro String $pesoAprobadoEgreso
	* @return PesoAprobadoEgreso
	*/
	public function setPesoAprobadoEgreso($pesoAprobadoEgreso)
	{
	  $this->pesoAprobadoEgreso = (String) $pesoAprobadoEgreso;
	    return $this;
	}

	/**
	* Get pesoAprobadoEgreso
	*
	* @return null|String
	*/
	public function getPesoAprobadoEgreso()
	{
		return $this->pesoAprobadoEgreso;
	}

	/**
	* Set totalPesoAprobado
	*
	*Campo que almacena el total del peso aprobado existente
	*
	* @parámetro String $totalPesoAprobado
	* @return TotalPesoAprobado
	*/
	public function setTotalPesoAprobado($totalPesoAprobado)
	{
	  $this->totalPesoAprobado = (String) $totalPesoAprobado;
	    return $this;
	}

	/**
	* Get totalPesoAprobado
	*
	* @return null|String
	*/
	public function getTotalPesoAprobado()
	{
		return $this->totalPesoAprobado;
	}

	/**
	* Set fechaRegistro
	*
	*
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
	* @return TransaccionInspeccionFitosanitariaModelo
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
