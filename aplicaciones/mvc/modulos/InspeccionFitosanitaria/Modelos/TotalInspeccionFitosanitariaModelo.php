<?php
 /**
 * Modelo TotalInspeccionFitosanitariaModelo
 *
 * Este archivo se complementa con el archivo   TotalInspeccionFitosanitariaLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    TotalInspeccionFitosanitariaModelo
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
  namespace Agrodb\InspeccionFitosanitaria\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class TotalInspeccionFitosanitariaModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla
		*/
		protected $idTotalInspeccionFitosanitaria;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla inspeccion_fitosanitaria
		*/
		protected $idInspeccionFitosanitaria;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador del subtipo de producto inspeccionado
		*/
		protected $idSubtipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador del producto inspeccionado
		*/
		protected $idProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del producto inspeccionado
		*/
		protected $nombreProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el ingreso de informacion de la cantidad aprobada
		*/
		protected $cantidadAprobadaIngreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el egreso de informacion de la cantidad aprobada
		*/
		protected $cantidadAprobadaEgreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad total del producto inspeccionado
		*/
		protected $totalCantidadAprobada;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el ingreso de informacion del peso aprobado
		*/
		protected $pesoAprobadoIngreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el egreso de informacion del peso aprobado
		*/
		protected $pesoAprobadoEgreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el peso total del producto inspeccionado
		*/
		protected $totalPesoAprobado;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad aprobada del producto inspeccionado
		*/
		protected $cantidadAprobada;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador unico de la unidad de la cantidad
		*/
		protected $idUnidadCantidadProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el peso aprobado del producto inspeccionado
		*/
		protected $pesoAprobado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador unico de la unidad del peso
		*/
		protected $idUnidadPesoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador unico del tipo de tratamiento
		*/
		protected $idTipoTratamiento;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador unico del tratamiento
		*/
		protected $idTratamiento;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador unico de duracion
		*/
		protected $idDuracion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad de la duracion
		*/
		protected $duracion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador unico de la temperatura
		*/
		protected $idTemperatura;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad de la temperatura
		*/
		protected $temperatura;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha del tratamiento
		*/
		protected $fechaTratamiento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el producto quimico
		*/
		protected $productoQuimico;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador unico de la concentracion
		*/
		protected $idConcentracion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad de la concentracion
		*/
		protected $concentracion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador del certificado fitosanitario asociado al consumo
		*/
		protected $idCertificadoFitosanitario;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaRegistro;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaActualizacion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de inspeccion del producto
		*/
		protected $fechaInspeccion;

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
	* Nombre de la tabla: total_inspeccion_fitosanitaria
	* 
	 */
	Private $tabla="total_inspeccion_fitosanitaria";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_total_inspeccion_fitosanitaria";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_inspeccion_fitosanitaria"."TotalInspeccionFitosanitaria_id_total_inspeccion_fitosanitaria_seq'; 



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
		throw new \Exception('Clase Modelo: TotalInspeccionFitosanitariaModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: TotalInspeccionFitosanitariaModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idTotalInspeccionFitosanitaria
	*
	*Identificador unico de la tabla
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
	* Set idInspeccionFitosanitaria
	*
	*Identificador unico de la tabla inspeccion_fitosanitaria
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
	* Set idSubtipoProducto
	*
	*Campo que almacena el identificador del subtipo de producto inspeccionado
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
	* Set idProducto
	*
	*Campo que almacena el identificador del producto inspeccionado
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
	* Set nombreProducto
	*
	*Campo que almacena el nombre del producto inspeccionado
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
	* Set cantidadAprobadaIngreso
	*
	*Campo que almacena el ingreso de informacion de la cantidad aprobada
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
	*Campo que almacena el egreso de informacion de la cantidad aprobada
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
	*Campo que almacena la cantidad total del producto inspeccionado
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
	*Campo que almacena el ingreso de informacion del peso aprobado
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
	*Campo que almacena el egreso de informacion del peso aprobado
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
	*Campo que almacena el peso total del producto inspeccionado
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
	* Set cantidadAprobada
	*
	*Campo que almacena la cantidad aprobada del producto inspeccionado
	*
	* @parámetro String $cantidadAprobada
	* @return CantidadAprobada
	*/
	public function setCantidadAprobada($cantidadAprobada)
	{
	  $this->cantidadAprobada = (String) $cantidadAprobada;
	    return $this;
	}

	/**
	* Get cantidadAprobada
	*
	* @return null|String
	*/
	public function getCantidadAprobada()
	{
		return $this->cantidadAprobada;
	}

	/**
	* Set idUnidadCantidadProducto
	*
	*Campo que almacena el identificador unico de la unidad de la cantidad
	*
	* @parámetro Integer $idUnidadCantidadProducto
	* @return IdUnidadCantidadProducto
	*/
	public function setIdUnidadCantidadProducto($idUnidadCantidadProducto)
	{
	  $this->idUnidadCantidadProducto = (Integer) $idUnidadCantidadProducto;
	    return $this;
	}

	/**
	* Get idUnidadCantidadProducto
	*
	* @return null|Integer
	*/
	public function getIdUnidadCantidadProducto()
	{
		return $this->idUnidadCantidadProducto;
	}

	/**
	* Set pesoAprobado
	*
	*Campo que almacena el peso aprobado del producto inspeccionado
	*
	* @parámetro String $pesoAprobado
	* @return PesoAprobado
	*/
	public function setPesoAprobado($pesoAprobado)
	{
	  $this->pesoAprobado = (String) $pesoAprobado;
	    return $this;
	}

	/**
	* Get pesoAprobado
	*
	* @return null|String
	*/
	public function getPesoAprobado()
	{
		return $this->pesoAprobado;
	}

	/**
	* Set idUnidadPesoProducto
	*
	*Campo que almacena el identificador unico de la unidad del peso
	*
	* @parámetro Integer $idUnidadPesoProducto
	* @return IdUnidadPesoProducto
	*/
	public function setIdUnidadPesoProducto($idUnidadPesoProducto)
	{
	  $this->idUnidadPesoProducto = (Integer) $idUnidadPesoProducto;
	    return $this;
	}

	/**
	* Get idUnidadPesoProducto
	*
	* @return null|Integer
	*/
	public function getIdUnidadPesoProducto()
	{
		return $this->idUnidadPesoProducto;
	}

	/**
	* Set idTipoTratamiento
	*
	*Campo que almacena el identificador unico del tipo de tratamiento
	*
	* @parámetro Integer $idTipoTratamiento
	* @return IdTipoTratamiento
	*/
	public function setIdTipoTratamiento($idTipoTratamiento)
	{
	  $this->idTipoTratamiento = (Integer) $idTipoTratamiento;
	    return $this;
	}

	/**
	* Get idTipoTratamiento
	*
	* @return null|Integer
	*/
	public function getIdTipoTratamiento()
	{
		return $this->idTipoTratamiento;
	}

	/**
	* Set idTratamiento
	*
	*Campo que almacena el identificador unico del tratamiento
	*
	* @parámetro Integer $idTratamiento
	* @return IdTratamiento
	*/
	public function setIdTratamiento($idTratamiento)
	{
	  $this->idTratamiento = (Integer) $idTratamiento;
	    return $this;
	}

	/**
	* Get idTratamiento
	*
	* @return null|Integer
	*/
	public function getIdTratamiento()
	{
		return $this->idTratamiento;
	}

	/**
	* Set idDuracion
	*
	*Campo que almacena el identificador unico de duracion
	*
	* @parámetro Integer $idDuracion
	* @return IdDuracion
	*/
	public function setIdDuracion($idDuracion)
	{
	  $this->idDuracion = (Integer) $idDuracion;
	    return $this;
	}

	/**
	* Get idDuracion
	*
	* @return null|Integer
	*/
	public function getIdDuracion()
	{
		return $this->idDuracion;
	}

	/**
	* Set duracion
	*
	*Campo que almacena la cantidad de la duracion
	*
	* @parámetro String $duracion
	* @return Duracion
	*/
	public function setDuracion($duracion)
	{
	  $this->duracion = (String) $duracion;
	    return $this;
	}

	/**
	* Get duracion
	*
	* @return null|String
	*/
	public function getDuracion()
	{
		return $this->duracion;
	}

	/**
	* Set idTemperatura
	*
	*Campo que almacena el identificador unico de la temperatura
	*
	* @parámetro Integer $idTemperatura
	* @return IdTemperatura
	*/
	public function setIdTemperatura($idTemperatura)
	{
	  $this->idTemperatura = (Integer) $idTemperatura;
	    return $this;
	}

	/**
	* Get idTemperatura
	*
	* @return null|Integer
	*/
	public function getIdTemperatura()
	{
		return $this->idTemperatura;
	}

	/**
	* Set temperatura
	*
	*Campo que almacena la cantidad de la temperatura
	*
	* @parámetro String $temperatura
	* @return Temperatura
	*/
	public function setTemperatura($temperatura)
	{
	  $this->temperatura = (String) $temperatura;
	    return $this;
	}

	/**
	* Get temperatura
	*
	* @return null|String
	*/
	public function getTemperatura()
	{
		return $this->temperatura;
	}

	/**
	* Set fechaTratamiento
	*
	*Campo que almacena la fecha del tratamiento
	*
	* @parámetro Date $fechaTratamiento
	* @return FechaTratamiento
	*/
	public function setFechaTratamiento($fechaTratamiento)
	{
	  $this->fechaTratamiento = (String) $fechaTratamiento;
	    return $this;
	}

	/**
	* Get fechaTratamiento
	*
	* @return null|Date
	*/
	public function getFechaTratamiento()
	{
		return $this->fechaTratamiento;
	}

	/**
	* Set productoQuimico
	*
	*Campo que almacena el producto quimico
	*
	* @parámetro String $productoQuimico
	* @return ProductoQuimico
	*/
	public function setProductoQuimico($productoQuimico)
	{
	  $this->productoQuimico = (String) $productoQuimico;
	    return $this;
	}

	/**
	* Get productoQuimico
	*
	* @return null|String
	*/
	public function getProductoQuimico()
	{
		return $this->productoQuimico;
	}

	/**
	* Set idConcentracion
	*
	*Campo que almacena el identificador unico de la concentracion
	*
	* @parámetro Integer $idConcentracion
	* @return IdConcentracion
	*/
	public function setIdConcentracion($idConcentracion)
	{
	  $this->idConcentracion = (Integer) $idConcentracion;
	    return $this;
	}

	/**
	* Get idConcentracion
	*
	* @return null|Integer
	*/
	public function getIdConcentracion()
	{
		return $this->idConcentracion;
	}

	/**
	* Set concentracion
	*
	*Campo que almacena la cantidad de la concentracion
	*
	* @parámetro String $concentracion
	* @return Concentracion
	*/
	public function setConcentracion($concentracion)
	{
	  $this->concentracion = (String) $concentracion;
	    return $this;
	}

	/**
	* Get concentracion
	*
	* @return null|String
	*/
	public function getConcentracion()
	{
		return $this->concentracion;
	}

	/**
	* Set idCertificadoFitosanitario
	*
	*Campo que almacena el identificador del certificado fitosanitario asociado al consumo
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
	* Set fechaActualizacion
	*
	*
	*
	* @parámetro Date $fechaActualizacion
	* @return FechaActualizacion
	*/
	public function setFechaActualizacion($fechaActualizacion)
	{
	  $this->fechaActualizacion = (String) $fechaActualizacion;
	    return $this;
	}

	/**
	* Get fechaActualizacion
	*
	* @return null|Date
	*/
	public function getFechaActualizacion()
	{
		return $this->fechaActualizacion;
	}

	/**
	* Set fechaInspeccion
	*
	*Campo que almacena la fecha de inspeccion del producto
	*
	* @parámetro Date $fechaInspeccion
	* @return FechaInspeccion
	*/
	public function setFechaInspeccion($fechaInspeccion)
	{
	  $this->fechaInspeccion = (String) $fechaInspeccion;
	    return $this;
	}

	/**
	* Get fechaInspeccion
	*
	* @return null|Date
	*/
	public function getFechaInspeccion()
	{
		return $this->fechaInspeccion;
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
	* @return TotalInspeccionFitosanitariaModelo
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
