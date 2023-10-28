<?php
 /**
 * Modelo CertificadoFitosanitarioModelo
 *
 * Este archivo se complementa con el archivo   CertificadoFitosanitarioLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    CertificadoFitosanitarioModelo
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
  namespace Agrodb\CertificadoFitosanitario\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class CertificadoFitosanitarioModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único de la tabla
		*/
		protected $idCertificadoFitosanitario;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código del certificado generado por el sistema
		*/
		protected $codigoCertificado;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la identificación del solicitante del certificado
		*/
		protected $identificadorSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el RUC/Cédula del exportador
		*/
		protected $identificadorExportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo poa del exportador
		*/
		protected $codigoPoa;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el tipo de certificado 1.ornamentales, 2.musaceas, 3.otros
		*/
		protected $tipoSolicitud;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla idiomas
		*/
		protected $idIdioma;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el estado del certificado
		*/
		protected $estadoCertificado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador de tipo de produccion
		*/
		protected $idTipoProduccion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla localización (país origen), siempre es Ecuador
		*/
		protected $idPaisOrigen;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de embarque
		*/
		protected $fechaEmbarque;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla medios de transporte
		*/
		protected $idMedioTransporte;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del medio de transporte
		*/
		protected $nombreMedioTransporte;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla puertos (puerto embarque)
		*/
		protected $idPuertoEmbarque;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificador de la provincia del puerto de embarque para direccionar la revison documental
		*/
		protected $idProvinciaPuertoEmbarque;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del puerto de embarque
		*/
		protected $nombrePuertoEmbarque;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena información referente a la exportación
		*/
		protected $nombreMarca;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena información adicional de la exportacion
		*/
		protected $informacionAdicional;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena información del certificado de importacion
		*/
		protected $codigoCertificadoImportacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del consiganatario
		*/
		protected $nombreConsignatario;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la dirección del consignatario
		*/
		protected $direccionConsignatario;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la forma de pago
		*/
		protected $formaPago;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que identifica si requiere descuento
		*/
		protected $descuento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el motivo del descuento
		*/
		protected $motivoDescuento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que identifica si se va a realizar reimpresión de certificado 1.SI, 2.NO
		*/
		protected $esReemplazo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el motivo del reemplazo de la solicitud
		*/
		protected $motivoReemplazo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el id del certificado reemplazado
		*/
		protected $idCertificadoReemplazo;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la última fecha de revisión del certificado
		*/
		protected $fechaRevision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el el último tipo de revisión del certificado
		*/
		protected $tipoRevision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el último identificador que realiza la revisión del certificado
		*/
		protected $identificadorRevision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la última observación realizada al certificado
		*/
		protected $observacionRevision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el motivo de desestimiento de la solicitud
		*/
		protected $motivoDesestimiento;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de registro del certificado
		*/
		protected $fechaCreacionCertificado;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de aprobacion del certificado
		*/
		protected $fechaAprobacionCertificado;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que indica si el certificado ha sido impreso
		*/
		protected $certificado;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que identifica el estado del certificado fitosanitario en transmision
		*/
		protected $estadoEphyto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Observación de resultado de Ephyto enviado a HUB
		*/
		protected $observacionEphyto;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de eliminacion del certificado
		*/
		protected $fechaAnulacionCertificado;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha en la que se reemplazo un certificado
		*/
		protected $fechaReemplazoCertificado;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_certificado_fitosanitario";

	/**
	* Nombre de la tabla: certificado_fitosanitario
	* 
	 */
	Private $tabla="certificado_fitosanitario";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_certificado_fitosanitario";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_certificado_fitosanitario"."certificado_fitosanitario_id_certificado_fitosanitario_seq'; 



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
		throw new \Exception('Clase Modelo: CertificadoFitosanitarioModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: CertificadoFitosanitarioModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_certificado_fitosanitario
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idCertificadoFitosanitario
	*
	*Identificador único de la tabla
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
	* Set codigoCertificado
	*
	*Código del certificado generado por el sistema
	*
	* @parámetro String $codigoCertificado
	* @return CodigoCertificado
	*/
	public function setCodigoCertificado($codigoCertificado)
	{
	  $this->codigoCertificado = (String) $codigoCertificado;
	    return $this;
	}

	/**
	* Get codigoCertificado
	*
	* @return null|String
	*/
	public function getCodigoCertificado()
	{
		return $this->codigoCertificado;
	}

	/**
	* Set identificadorSolicitante
	*
	*Campo que almacena la identificación del solicitante del certificado
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
	* Set identificadorExportador
	*
	*Campo que almacena el RUC/Cédula del exportador
	*
	* @parámetro String $identificadorExportador
	* @return IdentificadorExportador
	*/
	public function setIdentificadorExportador($identificadorExportador)
	{
	  $this->identificadorExportador = (String) $identificadorExportador;
	    return $this;
	}

	/**
	* Get identificadorExportador
	*
	* @return null|String
	*/
	public function getIdentificadorExportador()
	{
		return $this->identificadorExportador;
	}

	/**
	* Set codigoPoa
	*
	*Campo que almacena el codigo poa del exportador
	*
	* @parámetro String $codigoPoa
	* @return CodigoPoa
	*/
	public function setCodigoPoa($codigoPoa)
	{
	  $this->codigoPoa = (String) $codigoPoa;
	    return $this;
	}

	/**
	* Get codigoPoa
	*
	* @return null|String
	*/
	public function getCodigoPoa()
	{
		return $this->codigoPoa;
	}

	/**
	* Set tipoSolicitud
	*
	*Campo que almacena el tipo de certificado 1.ornamentales, 2.musaceas, 3.otros
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
	* Set idIdioma
	*
	*Identificador unico de la tabla idiomas
	*
	* @parámetro Integer $idIdioma
	* @return IdIdioma
	*/
	public function setIdIdioma($idIdioma)
	{
	  $this->idIdioma = (Integer) $idIdioma;
	    return $this;
	}

	/**
	* Get idIdioma
	*
	* @return null|Integer
	*/
	public function getIdIdioma()
	{
		return $this->idIdioma;
	}

	/**
	* Set estadoCertificado
	*
	*Campo que almacena el estado del certificado
	*
	* @parámetro String $estadoCertificado
	* @return EstadoCertificado
	*/
	public function setEstadoCertificado($estadoCertificado)
	{
	  $this->estadoCertificado = (String) $estadoCertificado;
	    return $this;
	}

	/**
	* Get estadoCertificado
	*
	* @return null|String
	*/
	public function getEstadoCertificado()
	{
		return $this->estadoCertificado;
	}

	/**
	* Set idTipoProduccion
	*
	*Campo que almacena el identificador de tipo de produccion
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
	* Set idPaisOrigen
	*
	*Identificador de la tabla localización (país origen), siempre es Ecuador
	*
	* @parámetro Integer $idPaisOrigen
	* @return IdPaisOrigen
	*/
	public function setIdPaisOrigen($idPaisOrigen)
	{
	  $this->idPaisOrigen = (Integer) $idPaisOrigen;
	    return $this;
	}

	/**
	* Get idPaisOrigen
	*
	* @return null|Integer
	*/
	public function getIdPaisOrigen()
	{
		return $this->idPaisOrigen;
	}

	/**
	* Set fechaEmbarque
	*
	*Campo que almacena la fecha de embarque
	*
	* @parámetro Date $fechaEmbarque
	* @return FechaEmbarque
	*/
	public function setFechaEmbarque($fechaEmbarque)
	{
	  $this->fechaEmbarque = (String) $fechaEmbarque;
	    return $this;
	}

	/**
	* Get fechaEmbarque
	*
	* @return null|Date
	*/
	public function getFechaEmbarque()
	{
		return $this->fechaEmbarque;
	}

	/**
	* Set idMedioTransporte
	*
	*Identificador de la tabla medios de transporte
	*
	* @parámetro Integer $idMedioTransporte
	* @return IdMedioTransporte
	*/
	public function setIdMedioTransporte($idMedioTransporte)
	{
	  $this->idMedioTransporte = (Integer) $idMedioTransporte;
	    return $this;
	}

	/**
	* Get idMedioTransporte
	*
	* @return null|Integer
	*/
	public function getIdMedioTransporte()
	{
		return $this->idMedioTransporte;
	}

	/**
	* Set nombreMedioTransporte
	*
	*Campo que almacena el nombre del medio de transporte
	*
	* @parámetro String $nombreMedioTransporte
	* @return NombreMedioTransporte
	*/
	public function setNombreMedioTransporte($nombreMedioTransporte)
	{
	  $this->nombreMedioTransporte = (String) $nombreMedioTransporte;
	    return $this;
	}

	/**
	* Get nombreMedioTransporte
	*
	* @return null|String
	*/
	public function getNombreMedioTransporte()
	{
		return $this->nombreMedioTransporte;
	}

	/**
	* Set idPuertoEmbarque
	*
	*Identificador de la tabla puertos (puerto embarque)
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
	* Set idProvinciaPuertoEmbarque
	*
	*Campo que almacena el identificador de la provincia del puerto de embarque para direccionar la revison documental
	*
	* @parámetro Integer $idProvinciaPuertoEmbarque
	* @return IdProvinciaPuertoEmbarque
	*/
	public function setIdProvinciaPuertoEmbarque($idProvinciaPuertoEmbarque)
	{
	  $this->idProvinciaPuertoEmbarque = (Integer) $idProvinciaPuertoEmbarque;
	    return $this;
	}

	/**
	* Get idProvinciaPuertoEmbarque
	*
	* @return null|Integer
	*/
	public function getIdProvinciaPuertoEmbarque()
	{
		return $this->idProvinciaPuertoEmbarque;
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
	* Set nombreMarca
	*
	*Campo que almacena información referente a la exportación
	*
	* @parámetro String $nombreMarca
	* @return NombreMarca
	*/
	public function setNombreMarca($nombreMarca)
	{
	  $this->nombreMarca = (String) $nombreMarca;
	    return $this;
	}

	/**
	* Get nombreMarca
	*
	* @return null|String
	*/
	public function getNombreMarca()
	{
		return $this->nombreMarca;
	}

	/**
	* Set informacionAdicional
	*
	*Campo que almacena información adicional de la exportacion
	*
	* @parámetro String $informacionAdicional
	* @return InformacionAdicional
	*/
	public function setInformacionAdicional($informacionAdicional)
	{
	  $this->informacionAdicional = (String) $informacionAdicional;
	    return $this;
	}

	/**
	* Get informacionAdicional
	*
	* @return null|String
	*/
	public function getInformacionAdicional()
	{
		return $this->informacionAdicional;
	}

	/**
	* Set codigoCertificadoImportacion
	*
	*Campo que almacena información del certificado de importacion
	*
	* @parámetro String $codigoCertificadoImportacion
	* @return CodigoCertificadoImportacion
	*/
	public function setCodigoCertificadoImportacion($codigoCertificadoImportacion)
	{
	  $this->codigoCertificadoImportacion = (String) $codigoCertificadoImportacion;
	    return $this;
	}

	/**
	* Get codigoCertificadoImportacion
	*
	* @return null|String
	*/
	public function getCodigoCertificadoImportacion()
	{
		return $this->codigoCertificadoImportacion;
	}

	/**
	* Set nombreConsignatario
	*
	*Campo que almacena el nombre del consiganatario
	*
	* @parámetro String $nombreConsignatario
	* @return NombreConsignatario
	*/
	public function setNombreConsignatario($nombreConsignatario)
	{
	  $this->nombreConsignatario = (String) $nombreConsignatario;
	    return $this;
	}

	/**
	* Get nombreConsignatario
	*
	* @return null|String
	*/
	public function getNombreConsignatario()
	{
		return $this->nombreConsignatario;
	}

	/**
	* Set direccionConsignatario
	*
	*Campo que almacena la dirección del consignatario
	*
	* @parámetro String $direccionConsignatario
	* @return DireccionConsignatario
	*/
	public function setDireccionConsignatario($direccionConsignatario)
	{
	  $this->direccionConsignatario = (String) $direccionConsignatario;
	    return $this;
	}

	/**
	* Get direccionConsignatario
	*
	* @return null|String
	*/
	public function getDireccionConsignatario()
	{
		return $this->direccionConsignatario;
	}

	/**
	* Set formaPago
	*
	*Campo que almacena la forma de pago
	*
	* @parámetro String $formaPago
	* @return FormaPago
	*/
	public function setFormaPago($formaPago)
	{
	  $this->formaPago = (String) $formaPago;
	    return $this;
	}

	/**
	* Get formaPago
	*
	* @return null|String
	*/
	public function getFormaPago()
	{
		return $this->formaPago;
	}

	/**
	* Set descuento
	*
	*Campo que identifica si requiere descuento
	*
	* @parámetro String $descuento
	* @return Descuento
	*/
	public function setDescuento($descuento)
	{
	  $this->descuento = (String) $descuento;
	    return $this;
	}

	/**
	* Get descuento
	*
	* @return null|String
	*/
	public function getDescuento()
	{
		return $this->descuento;
	}

	/**
	* Set motivoDescuento
	*
	*Campo que almacena el motivo del descuento
	*
	* @parámetro String $motivoDescuento
	* @return MotivoDescuento
	*/
	public function setMotivoDescuento($motivoDescuento)
	{
	  $this->motivoDescuento = (String) $motivoDescuento;
	    return $this;
	}

	/**
	* Get motivoDescuento
	*
	* @return null|String
	*/
	public function getMotivoDescuento()
	{
		return $this->motivoDescuento;
	}

	/**
	* Set esReemplazo
	*
	*Campo que identifica si se va a realizar reimpresión de certificado 1.SI, 2.NO
	*
	* @parámetro String $esReemplazo
	* @return EsReemplazo
	*/
	public function setEsReemplazo($esReemplazo)
	{
	  $this->esReemplazo = (String) $esReemplazo;
	    return $this;
	}

	/**
	* Get esReemplazo
	*
	* @return null|String
	*/
	public function getEsReemplazo()
	{
		return $this->esReemplazo;
	}

	/**
	* Set motivoReemplazo
	*
	*Campo que almacena el motivo del reemplazo de la solicitud
	*
	* @parámetro String $motivoReemplazo
	* @return MotivoReemplazo
	*/
	public function setMotivoReemplazo($motivoReemplazo)
	{
	  $this->motivoReemplazo = (String) $motivoReemplazo;
	    return $this;
	}

	/**
	* Get motivoReemplazo
	*
	* @return null|String
	*/
	public function getMotivoReemplazo()
	{
		return $this->motivoReemplazo;
	}

	/**
	* Set idCertificadoReemplazo
	*
	*Campo que almacena el id del certificado reemplazado
	*
	* @parámetro Integer $idCertificadoReemplazo
	* @return IdCertificadoReemplazo
	*/
	public function setIdCertificadoReemplazo($idCertificadoReemplazo)
	{
	  $this->idCertificadoReemplazo = (Integer) $idCertificadoReemplazo;
	    return $this;
	}

	/**
	* Get idCertificadoReemplazo
	*
	* @return null|Integer
	*/
	public function getIdCertificadoReemplazo()
	{
		return $this->idCertificadoReemplazo;
	}

	/**
	* Set fechaRevision
	*
	*Campo que almacena la última fecha de revisión del certificado
	*
	* @parámetro Date $fechaRevision
	* @return FechaRevision
	*/
	public function setFechaRevision($fechaRevision)
	{
	  $this->fechaRevision = (String) $fechaRevision;
	    return $this;
	}

	/**
	* Get fechaRevision
	*
	* @return null|Date
	*/
	public function getFechaRevision()
	{
		return $this->fechaRevision;
	}

	/**
	* Set tipoRevision
	*
	*Campo que almacena el el último tipo de revisión del certificado
	*
	* @parámetro String $tipoRevision
	* @return TipoRevision
	*/
	public function setTipoRevision($tipoRevision)
	{
	  $this->tipoRevision = (String) $tipoRevision;
	    return $this;
	}

	/**
	* Get tipoRevision
	*
	* @return null|String
	*/
	public function getTipoRevision()
	{
		return $this->tipoRevision;
	}

	/**
	* Set identificadorRevision
	*
	*Campo que almacena el último identificador que realiza la revisión del certificado
	*
	* @parámetro String $identificadorRevision
	* @return IdentificadorRevision
	*/
	public function setIdentificadorRevision($identificadorRevision)
	{
	  $this->identificadorRevision = (String) $identificadorRevision;
	    return $this;
	}

	/**
	* Get identificadorRevision
	*
	* @return null|String
	*/
	public function getIdentificadorRevision()
	{
		return $this->identificadorRevision;
	}

	/**
	* Set observacionRevision
	*
	*Campo que almacena la última observación realizada al certificado
	*
	* @parámetro String $observacionRevision
	* @return ObservacionRevision
	*/
	public function setObservacionRevision($observacionRevision)
	{
	  $this->observacionRevision = (String) $observacionRevision;
	    return $this;
	}

	/**
	* Get observacionRevision
	*
	* @return null|String
	*/
	public function getObservacionRevision()
	{
		return $this->observacionRevision;
	}

	/**
	* Set motivoDesestimiento
	*
	*Campo que almacena el motivo de desestimiento de la solicitud
	*
	* @parámetro String $motivoDesestimiento
	* @return MotivoDesestimiento
	*/
	public function setMotivoDesestimiento($motivoDesestimiento)
	{
	  $this->motivoDesestimiento = (String) $motivoDesestimiento;
	    return $this;
	}

	/**
	* Get motivoDesestimiento
	*
	* @return null|String
	*/
	public function getMotivoDesestimiento()
	{
		return $this->motivoDesestimiento;
	}

	/**
	* Set fechaCreacionCertificado
	*
	*Campo que almacena la fecha de registro del certificado
	*
	* @parámetro Date $fechaCreacionCertificado
	* @return FechaCreacionCertificado
	*/
	public function setFechaCreacionCertificado($fechaCreacionCertificado)
	{
	  $this->fechaCreacionCertificado = (String) $fechaCreacionCertificado;
	    return $this;
	}

	/**
	* Get fechaCreacionCertificado
	*
	* @return null|Date
	*/
	public function getFechaCreacionCertificado()
	{
		return $this->fechaCreacionCertificado;
	}

	/**
	* Set fechaAprobacionCertificado
	*
	*Campo que almacena la fecha de aprobacion del certificado
	*
	* @parámetro Date $fechaAprobacionCertificado
	* @return FechaAprobacionCertificado
	*/
	public function setFechaAprobacionCertificado($fechaAprobacionCertificado)
	{
	  $this->fechaAprobacionCertificado = (String) $fechaAprobacionCertificado;
	    return $this;
	}

	/**
	* Get fechaAprobacionCertificado
	*
	* @return null|Date
	*/
	public function getFechaAprobacionCertificado()
	{
		return $this->fechaAprobacionCertificado;
	}

	/**
	* Set certificado
	*
	*Campo que indica si el certificado ha sido impreso
	*
	* @parámetro String $certificado
	* @return Certificado
	*/
	public function setCertificado($certificado)
	{
	  $this->certificado = (String) $certificado;
	    return $this;
	}

	/**
	* Get certificado
	*
	* @return null|String
	*/
	public function getCertificado()
	{
		return $this->certificado;
	}

	/**
	* Set estadoEphyto
	*
	*Campo que identifica el estado del certificado fitosanitario en transmision
	*
	* @parámetro String $estadoEphyto
	* @return EstadoEphyto
	*/
	public function setEstadoEphyto($estadoEphyto)
	{
	  $this->estadoEphyto = (String) $estadoEphyto;
	    return $this;
	}

	/**
	* Get estadoEphyto
	*
	* @return null|String
	*/
	public function getEstadoEphyto()
	{
		return $this->estadoEphyto;
	}

	/**
	* Set observacionEphyto
	*
	*Observación de resultado de Ephyto enviado a HUB
	*
	* @parámetro String $observacionEphyto
	* @return ObservacionEphyto
	*/
	public function setObservacionEphyto($observacionEphyto)
	{
	  $this->observacionEphyto = (String) $observacionEphyto;
	    return $this;
	}

	/**
	* Get observacionEphyto
	*
	* @return null|String
	*/
	public function getObservacionEphyto()
	{
		return $this->observacionEphyto;
	}

	/**
	* Set fechaAnulacionCertificado
	*
	*Campo que almacena la fecha de eliminacion del certificado
	*
	* @parámetro Date $fechaAnulacionCertificado
	* @return FechaAnulacionCertificado
	*/
	public function setFechaAnulacionCertificado($fechaAnulacionCertificado)
	{
	  $this->fechaAnulacionCertificado = (String) $fechaAnulacionCertificado;
	    return $this;
	}

	/**
	* Get fechaAnulacionCertificado
	*
	* @return null|Date
	*/
	public function getFechaAnulacionCertificado()
	{
		return $this->fechaAnulacionCertificado;
	}

	/**
	* Set fechaReemplazoCertificado
	*
	*Campo que almacena la fecha en la que se reemplazo un certificado
	*
	* @parámetro Date $fechaReemplazoCertificado
	* @return FechaReemplazoCertificado
	*/
	public function setFechaReemplazoCertificado($fechaReemplazoCertificado)
	{
	  $this->fechaReemplazoCertificado = (String) $fechaReemplazoCertificado;
	    return $this;
	}

	/**
	* Get fechaReemplazoCertificado
	*
	* @return null|Date
	*/
	public function getFechaReemplazoCertificado()
	{
		return $this->fechaReemplazoCertificado;
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
	* @return CertificadoFitosanitarioModelo
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
