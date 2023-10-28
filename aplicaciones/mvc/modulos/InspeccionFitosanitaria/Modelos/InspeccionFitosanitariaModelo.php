<?php
 /**
 * Modelo InspeccionFitosanitariaModelo
 *
 * Este archivo se complementa con el archivo   InspeccionFitosanitariaLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    InspeccionFitosanitariaModelo
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
  namespace Agrodb\InspeccionFitosanitaria\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class InspeccionFitosanitariaModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla
		*/
		protected $idInspeccionFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el numero de solicitud
		*/
		protected $numeroSolicitud;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador del solicitante de la inspeccion
		*/
		protected $identificadorSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el tipo de solicitud de inspeccion
		*/
		protected $tipoSolicitud;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla g_catalogos.puertos
		*/
		protected $idPuertoEmbarque;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del puerto de embarque
		*/
		protected $nombrePuertoEmbarque;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla g_catalogos.localizacion
		*/
		protected $idPaisDestino;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campoque almacena el nombre del paisde destino
		*/
		protected $nombrePaisDestino;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador del tipo de produccion
		*/
		protected $idTipoProduccion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena los loes de producto
		*/
		protected $lotesProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el tipo de area de inspeccion
		*/
		protected $tipoArea;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_operadores.areas. Identifica el area donde se realizara la inspeccion
		*/
		protected $idArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del area
		*/
		protected $nombreArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo de area donde se realizara la inspeccion
		*/
		protected $codigoArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la direccion de area donde se realizara la inspeccion
		*/
		protected $direccionArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el id de la provincia donde se realizara la inspeccion
		*/
		protected $idProvinciaArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la provincia del area
		*/
		protected $nombreProvinciaArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena latitud
		*/
		protected $latitud;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena longitud
		*/
		protected $longitud;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de inspeccion
		*/
		protected $fechaInspeccion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la hora de inspeccion
		*/
		protected $horaInspeccion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena una observacion
		*/
		protected $observacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador del tecnico revisor
		*/
		protected $identificadorRevisor;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la observacion del tecnico revisor
		*/
		protected $observacionRevisor;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el estado anterior de la solicitud
		*/
		protected $estadoAnteriorInspeccionFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el estado de la solicitud
		*/
		protected $estadoInspeccionFitosanitaria;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de creacion de la solicitud
		*/
		protected $fechaCreacion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de aprobacionn de la solicitud
		*/
		protected $fechaAprobacion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Tiempo de vigencia de la solicitud en dias
		*/
		protected $tiempoVigencia;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de vigencia de la solicitud
		*/
		protected $fechaVigencia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la ruta del certificado de inspeccion
		*/
		protected $rutaCertificadoInspeccion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de desestimiento de la solicitud
		*/
		protected $fechaDesestimiento;

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
	* Nombre de la tabla: inspeccion_fitosanitaria
	* 
	 */
	Private $tabla="inspeccion_fitosanitaria";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_inspeccion_fitosanitaria";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_inspeccion_fitosanitaria"."inspeccion_fitosanitaria_id_inspeccion_fitosanitaria_seq'; 



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
		throw new \Exception('Clase Modelo: InspeccionFitosanitariaModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: InspeccionFitosanitariaModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idInspeccionFitosanitaria
	*
	*Identificador unico de la tabla
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
	* Set numeroSolicitud
	*
	*Campo que almacena el numero de solicitud
	*
	* @parámetro String $numeroSolicitud
	* @return NumeroSolicitud
	*/
	public function setNumeroSolicitud($numeroSolicitud)
	{
	  $this->numeroSolicitud = (String) $numeroSolicitud;
	    return $this;
	}

	/**
	* Get numeroSolicitud
	*
	* @return null|String
	*/
	public function getNumeroSolicitud()
	{
		return $this->numeroSolicitud;
	}

	/**
	* Set identificadorSolicitante
	*
	*Campo que almacena el identificador del solicitante de la inspeccion
	*
	* @parámetro String $identificadorSolicitante
	* @return IdentificadorSolicitante
	*/
	public function setIdentificadorSolicitante($identificadorSolicitante)
	{
	  $this->identificadorSolicitante = (String) $identificadorSolicitante;
	    return $this;
	}

	/**
	* Get identificadorSolicitante
	*
	* @return null|String
	*/
	public function getIdentificadorSolicitante()
	{
		return $this->identificadorSolicitante;
	}

	/**
	* Set tipoSolicitud
	*
	*Campo que almacena el tipo de solicitud de inspeccion
	*
	* @parámetro String $tipoSolicitud
	* @return TipoSolicitud
	*/
	public function setTipoSolicitud($tipoSolicitud)
	{
	  $this->tipoSolicitud = (String) $tipoSolicitud;
	    return $this;
	}

	/**
	* Get tipoSolicitud
	*
	* @return null|String
	*/
	public function getTipoSolicitud()
	{
		return $this->tipoSolicitud;
	}

	/**
	* Set idPuertoEmbarque
	*
	*Identificador de la tabla g_catalogos.puertos
	*
	* @parámetro Integer $idPuertoEmbarque
	* @return IdPuertoEmbarque
	*/
	public function setIdPuertoEmbarque($idPuertoEmbarque)
	{
	  $this->idPuertoEmbarque = (Integer) $idPuertoEmbarque;
	    return $this;
	}

	/**
	* Get idPuertoEmbarque
	*
	* @return null|Integer
	*/
	public function getIdPuertoEmbarque()
	{
		return $this->idPuertoEmbarque;
	}

	/**
	* Set nombrePuertoEmbarque
	*
	*Campo que almacena el nombre del puerto de embarque
	*
	* @parámetro String $nombrePuertoEmbarque
	* @return NombrePuertoEmbarque
	*/
	public function setNombrePuertoEmbarque($nombrePuertoEmbarque)
	{
	  $this->nombrePuertoEmbarque = (String) $nombrePuertoEmbarque;
	    return $this;
	}

	/**
	* Get nombrePuertoEmbarque
	*
	* @return null|String
	*/
	public function getNombrePuertoEmbarque()
	{
		return $this->nombrePuertoEmbarque;
	}

	/**
	* Set idPaisDestino
	*
	*Identificador de la tabla g_catalogos.localizacion
	*
	* @parámetro Integer $idPaisDestino
	* @return IdPaisDestino
	*/
	public function setIdPaisDestino($idPaisDestino)
	{
	  $this->idPaisDestino = (Integer) $idPaisDestino;
	    return $this;
	}

	/**
	* Get idPaisDestino
	*
	* @return null|Integer
	*/
	public function getIdPaisDestino()
	{
		return $this->idPaisDestino;
	}

	/**
	* Set nombrePaisDestino
	*
	*Campoque almacena el nombre del paisde destino
	*
	* @parámetro String $nombrePaisDestino
	* @return NombrePaisDestino
	*/
	public function setNombrePaisDestino($nombrePaisDestino)
	{
	  $this->nombrePaisDestino = (String) $nombrePaisDestino;
	    return $this;
	}

	/**
	* Get nombrePaisDestino
	*
	* @return null|String
	*/
	public function getNombrePaisDestino()
	{
		return $this->nombrePaisDestino;
	}

	/**
	* Set idTipoProduccion
	*
	*Campo que almacena el identificador del tipo de produccion
	*
	* @parámetro Integer $idTipoProduccion
	* @return IdTipoProduccion
	*/
	public function setIdTipoProduccion($idTipoProduccion)
	{
	  $this->idTipoProduccion = (Integer) $idTipoProduccion;
	    return $this;
	}

	/**
	* Get idTipoProduccion
	*
	* @return null|Integer
	*/
	public function getIdTipoProduccion()
	{
		return $this->idTipoProduccion;
	}

	/**
	* Set lotesProducto
	*
	*Campo que almacena los loes de producto
	*
	* @parámetro String $lotesProducto
	* @return LotesProducto
	*/
	public function setLotesProducto($lotesProducto)
	{
	  $this->lotesProducto = (String) $lotesProducto;
	    return $this;
	}

	/**
	* Get lotesProducto
	*
	* @return null|String
	*/
	public function getLotesProducto()
	{
		return $this->lotesProducto;
	}

	/**
	* Set tipoArea
	*
	*Campo que almacena el tipo de area de inspeccion
	*
	* @parámetro String $tipoArea
	* @return TipoArea
	*/
	public function setTipoArea($tipoArea)
	{
	  $this->tipoArea = (String) $tipoArea;
	    return $this;
	}

	/**
	* Get tipoArea
	*
	* @return null|String
	*/
	public function getTipoArea()
	{
		return $this->tipoArea;
	}

	/**
	* Set idArea
	*
	*Identificador unico de la tabla g_operadores.areas. Identifica el area donde se realizara la inspeccion
	*
	* @parámetro Integer $idArea
	* @return IdArea
	*/
	public function setIdArea($idArea)
	{
	  $this->idArea = (Integer) $idArea;
	    return $this;
	}

	/**
	* Get idArea
	*
	* @return null|Integer
	*/
	public function getIdArea()
	{
		return $this->idArea;
	}

	/**
	* Set nombreArea
	*
	*Campo que almacena el nombre del area
	*
	* @parámetro String $nombreArea
	* @return NombreArea
	*/
	public function setNombreArea($nombreArea)
	{
	  $this->nombreArea = (String) $nombreArea;
	    return $this;
	}

	/**
	* Get nombreArea
	*
	* @return null|String
	*/
	public function getNombreArea()
	{
		return $this->nombreArea;
	}

	/**
	* Set codigoArea
	*
	*Campo que almacena el codigo de area donde se realizara la inspeccion
	*
	* @parámetro String $codigoArea
	* @return CodigoArea
	*/
	public function setCodigoArea($codigoArea)
	{
	  $this->codigoArea = (String) $codigoArea;
	    return $this;
	}

	/**
	* Get codigoArea
	*
	* @return null|String
	*/
	public function getCodigoArea()
	{
		return $this->codigoArea;
	}

	/**
	* Set direccionArea
	*
	*Campo que almacena la direccion de area donde se realizara la inspeccion
	*
	* @parámetro String $direccionArea
	* @return DireccionArea
	*/
	public function setDireccionArea($direccionArea)
	{
	  $this->direccionArea = (String) $direccionArea;
	    return $this;
	}

	/**
	* Get direccionArea
	*
	* @return null|String
	*/
	public function getDireccionArea()
	{
		return $this->direccionArea;
	}

	/**
	* Set idProvinciaArea
	*
	*Campo que almacena el id de la provincia donde se realizara la inspeccion
	*
	* @parámetro String $idProvinciaArea
	* @return IdProvinciaArea
	*/
	public function setIdProvinciaArea($idProvinciaArea)
	{
	  $this->idProvinciaArea = (String) $idProvinciaArea;
	    return $this;
	}

	/**
	* Get idProvinciaArea
	*
	* @return null|String
	*/
	public function getIdProvinciaArea()
	{
		return $this->idProvinciaArea;
	}

	/**
	* Set nombreProvinciaArea
	*
	*Campo que almacena el nombre de la provincia del area
	*
	* @parámetro String $nombreProvinciaArea
	* @return NombreProvinciaArea
	*/
	public function setNombreProvinciaArea($nombreProvinciaArea)
	{
	  $this->nombreProvinciaArea = (String) $nombreProvinciaArea;
	    return $this;
	}

	/**
	* Get nombreProvinciaArea
	*
	* @return null|String
	*/
	public function getNombreProvinciaArea()
	{
		return $this->nombreProvinciaArea;
	}

	/**
	* Set latitud
	*
	*Campo que almacena latitud
	*
	* @parámetro String $latitud
	* @return Latitud
	*/
	public function setLatitud($latitud)
	{
	  $this->latitud = (String) $latitud;
	    return $this;
	}

	/**
	* Get latitud
	*
	* @return null|String
	*/
	public function getLatitud()
	{
		return $this->latitud;
	}

	/**
	* Set longitud
	*
	*Campo que almacena longitud
	*
	* @parámetro String $longitud
	* @return Longitud
	*/
	public function setLongitud($longitud)
	{
	  $this->longitud = (String) $longitud;
	    return $this;
	}

	/**
	* Get longitud
	*
	* @return null|String
	*/
	public function getLongitud()
	{
		return $this->longitud;
	}

	/**
	* Set fechaInspeccion
	*
	*Campo que almacena la fecha de inspeccion
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
	* Set horaInspeccion
	*
	*Campo que almacena la hora de inspeccion
	*
	* @parámetro String $horaInspeccion
	* @return HoraInspeccion
	*/
	public function setHoraInspeccion($horaInspeccion)
	{
	  $this->horaInspeccion = (String) $horaInspeccion;
	    return $this;
	}

	/**
	* Get horaInspeccion
	*
	* @return null|String
	*/
	public function getHoraInspeccion()
	{
		return $this->horaInspeccion;
	}

	/**
	* Set observacion
	*
	*Campo que almacena una observacion
	*
	* @parámetro String $observacion
	* @return Observacion
	*/
	public function setObservacion($observacion)
	{
	  $this->observacion = (String) $observacion;
	    return $this;
	}

	/**
	* Get observacion
	*
	* @return null|String
	*/
	public function getObservacion()
	{
		return $this->observacion;
	}

	/**
	* Set identificadorRevisor
	*
	*Campo que almacena el identificador del tecnico revisor
	*
	* @parámetro String $identificadorRevisor
	* @return IdentificadorRevisor
	*/
	public function setIdentificadorRevisor($identificadorRevisor)
	{
	  $this->identificadorRevisor = (String) $identificadorRevisor;
	    return $this;
	}

	/**
	* Get identificadorRevisor
	*
	* @return null|String
	*/
	public function getIdentificadorRevisor()
	{
		return $this->identificadorRevisor;
	}

	/**
	* Set observacionRevisor
	*
	*Campo que almacena la observacion del tecnico revisor
	*
	* @parámetro String $observacionRevisor
	* @return ObservacionRevisor
	*/
	public function setObservacionRevisor($observacionRevisor)
	{
	  $this->observacionRevisor = (String) $observacionRevisor;
	    return $this;
	}

	/**
	* Get observacionRevisor
	*
	* @return null|String
	*/
	public function getObservacionRevisor()
	{
		return $this->observacionRevisor;
	}

	/**
	* Set estadoAnteriorInspeccionFitosanitaria
	*
	*Campo que almacena el estado anterior de la solicitud
	*
	* @parámetro String $estadoAnteriorInspeccionFitosanitaria
	* @return EstadoAnteriorInspeccionFitosanitaria
	*/
	public function setEstadoAnteriorInspeccionFitosanitaria($estadoAnteriorInspeccionFitosanitaria)
	{
	  $this->estadoAnteriorInspeccionFitosanitaria = (String) $estadoAnteriorInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get estadoAnteriorInspeccionFitosanitaria
	*
	* @return null|String
	*/
	public function getEstadoAnteriorInspeccionFitosanitaria()
	{
		return $this->estadoAnteriorInspeccionFitosanitaria;
	}

	/**
	* Set estadoInspeccionFitosanitaria
	*
	*Campo que almacena el estado de la solicitud
	*
	* @parámetro String $estadoInspeccionFitosanitaria
	* @return EstadoInspeccionFitosanitaria
	*/
	public function setEstadoInspeccionFitosanitaria($estadoInspeccionFitosanitaria)
	{
	  $this->estadoInspeccionFitosanitaria = (String) $estadoInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get estadoInspeccionFitosanitaria
	*
	* @return null|String
	*/
	public function getEstadoInspeccionFitosanitaria()
	{
		return $this->estadoInspeccionFitosanitaria;
	}

	/**
	* Set fechaCreacion
	*
	*Fecha de creacion de la solicitud
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
	* Set fechaAprobacion
	*
	*Fecha de aprobacionn de la solicitud
	*
	* @parámetro Date $fechaAprobacion
	* @return FechaAprobacion
	*/
	public function setFechaAprobacion($fechaAprobacion)
	{
	  $this->fechaAprobacion = (String) $fechaAprobacion;
	    return $this;
	}

	/**
	* Get fechaAprobacion
	*
	* @return null|Date
	*/
	public function getFechaAprobacion()
	{
		return $this->fechaAprobacion;
	}

	/**
	* Set tiempoVigencia
	*
	*Tiempo de vigencia de la solicitud en dias
	*
	* @parámetro Integer $tiempoVigencia
	* @return TiempoVigencia
	*/
	public function setTiempoVigencia($tiempoVigencia)
	{
	  $this->tiempoVigencia = (Integer) $tiempoVigencia;
	    return $this;
	}

	/**
	* Get tiempoVigencia
	*
	* @return null|Integer
	*/
	public function getTiempoVigencia()
	{
		return $this->tiempoVigencia;
	}

	/**
	* Set fechaVigencia
	*
	*Fecha de vigencia de la solicitud
	*
	* @parámetro Date $fechaVigencia
	* @return FechaVigencia
	*/
	public function setFechaVigencia($fechaVigencia)
	{
	  $this->fechaVigencia = (String) $fechaVigencia;
	    return $this;
	}

	/**
	* Get fechaVigencia
	*
	* @return null|Date
	*/
	public function getFechaVigencia()
	{
		return $this->fechaVigencia;
	}

	/**
	* Set rutaCertificadoInspeccion
	*
	*Campo que almacena la ruta del certificado de inspeccion
	*
	* @parámetro String $rutaCertificadoInspeccion
	* @return RutaCertificadoInspeccion
	*/
	public function setRutaCertificadoInspeccion($rutaCertificadoInspeccion)
	{
	  $this->rutaCertificadoInspeccion = (String) $rutaCertificadoInspeccion;
	    return $this;
	}

	/**
	* Get rutaCertificadoInspeccion
	*
	* @return null|String
	*/
	public function getRutaCertificadoInspeccion()
	{
		return $this->rutaCertificadoInspeccion;
	}

	/**
	* Set fechaDesestimiento
	*
	*Campo que almacena la fecha de desestimiento de la solicitud
	*
	* @parámetro Date $fechaDesestimiento
	* @return FechaDesestimiento
	*/
	public function setFechaDesestimiento($fechaDesestimiento)
	{
	  $this->fechaDesestimiento = (String) $fechaDesestimiento;
	    return $this;
	}

	/**
	* Get fechaDesestimiento
	*
	* @return null|Date
	*/
	public function getFechaDesestimiento()
	{
		return $this->fechaDesestimiento;
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
	* @return InspeccionFitosanitariaModelo
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
