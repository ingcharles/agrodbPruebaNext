<?php
 /**
 * Modelo TransitoInternacionalModelo
 *
 * Este archivo se complementa con el archivo   TransitoInternacionalLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-11-08
 * @uses    TransitoInternacionalModelo
 * @package TransitoInternacional
 * @subpackage Modelos
 */
  namespace Agrodb\TransitoInternacional\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class TransitoInternacionalModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único del registro
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
		* Número de a solicitud en VUE
		*/
		protected $reqNo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Número de documento en VUE
		*/
		protected $numeroDocumento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del documento de solicitud
		*/
		protected $nombreDocumento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código de función de documento en VUE
		*/
		protected $codigoFuncionDocumento;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de solicitud del trámite en VUE
		*/
		protected $fechaSolicitud;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id de ciudad de solicitud
		*/
		protected $idCiudadSolicitud;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código de la ciudad de solicitud VUE
		*/
		protected $codigoCiudadSolicitud;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la ciudad de solicitud
		*/
		protected $nombreCiudadSolicitud;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código de tipo producto VUE
		*/
		protected $codigoTipoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del tipo de producto
		*/
		protected $nombreTipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id de ciudad de emisión
		*/
		protected $idCiudadEmision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código ciudad de emisión VUE
		*/
		protected $codigoCiudadEmision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de ciudad de emisión
		*/
		protected $nombreCiudadEmision;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de inicio de vigencia de la solicitud
		*/
		protected $fechaInicioVigencia;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de fin de vigencia de la solicitud
		*/
		protected $fechaFinVigencia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Identificador del solicitante
		*/
		protected $identificadorSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre o razón social del solicitante
		*/
		protected $nombreSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del representante legal del solicitante
		*/
		protected $representanteLegalSolicitante;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id de la prvincia del solicitante
		*/
		protected $idProvinciaSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código de la provincia del solicitante VUE
		*/
		protected $codigoProvinciaSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la provincia del solicitante
		*/
		protected $nombreProvinciaSolicitante;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id del cantón del solicitante
		*/
		protected $idCantonSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código del cantón del solicitante VUE
		*/
		protected $codigoCantonSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del cantón del solicitante
		*/
		protected $nombreCantonSolicitante;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id de la parroquia del solicitante
		*/
		protected $idParroquiaSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código de la parroquia del solicitante VUE
		*/
		protected $codigoParroquiaSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la parroquia del solicitante
		*/
		protected $nombreParroquiaSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Dirección del solicitante
		*/
		protected $direccionSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Teléfono del solicitante
		*/
		protected $telefonoSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Fax del solicitante
		*/
		protected $faxSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Correo electrónico del solicitante
		*/
		protected $correoSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Clasificación del importador VUE
		*/
		protected $clasificacionImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Identificador del importador
		*/
		protected $identificadorImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre del importador
		*/
		protected $nombreImportador;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Id del cantón del importador
		*/
		protected $idCantonImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoCantonImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombreCantonImportador;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idParroquiaImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoParroquiaImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombreParroquiaImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $direccionImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $correoImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $representanteLegalImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $telefonoImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $celularImportador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoRegimenAduanero;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombreRegimenAduanero;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idPaisOrigen;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoPaisOrigen;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombrePaisOrigen;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idPaisProcedencia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoPaisProcedencia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombrePaisProcedencia;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idPaisDestino;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoPaisDestino;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombrePaisDestino;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idUbicacionEnvio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoUbicacionEnvio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombreUbicacionEnvio;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idPuntoIngreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoPuntoIngreso;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombrePuntoIngreso;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idPuntoSalida;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoPuntoSalida;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombrePuntoSalida;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idMedioTransporte;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoMedioTransporte;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombreMedioTransporte;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $placaVehiculo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $rutaSeguir;
		/**
		* @var String
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
		protected $identificadorTecnico;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $observacionTecnico;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Ruta del documento con los requisitos fitosanitarios para tránsito internacional
		*/
		protected $informeRequisitos;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $codigoCertificado;

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
	* Nombre de la tabla: transito_internacional
	* 
	 */
	Private $tabla="transito_internacional";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_transito_internacional";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_transito_internacional"."TransitoInternacional_id_transito_internacional_seq'; 



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
		throw new \Exception('Clase Modelo: TransitoInternacionalModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: TransitoInternacionalModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idTransitoInternacional
	*
	*Identificador único del registro
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
	*Número de a solicitud en VUE
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
	* Set numeroDocumento
	*
	*Número de documento en VUE
	*
	* @parámetro String $numeroDocumento
	* @return NumeroDocumento
	*/
	public function setNumeroDocumento($numeroDocumento)
	{
	  $this->numeroDocumento = (String) $numeroDocumento;
	    return $this;
	}

	/**
	* Get numeroDocumento
	*
	* @return null|String
	*/
	public function getNumeroDocumento()
	{
		return $this->numeroDocumento;
	}

	/**
	* Set nombreDocumento
	*
	*Nombre del documento de solicitud
	*
	* @parámetro String $nombreDocumento
	* @return NombreDocumento
	*/
	public function setNombreDocumento($nombreDocumento)
	{
	  $this->nombreDocumento = (String) $nombreDocumento;
	    return $this;
	}

	/**
	* Get nombreDocumento
	*
	* @return null|String
	*/
	public function getNombreDocumento()
	{
		return $this->nombreDocumento;
	}

	/**
	* Set codigoFuncionDocumento
	*
	*Código de función de documento en VUE
	*
	* @parámetro String $codigoFuncionDocumento
	* @return CodigoFuncionDocumento
	*/
	public function setCodigoFuncionDocumento($codigoFuncionDocumento)
	{
	  $this->codigoFuncionDocumento = (String) $codigoFuncionDocumento;
	    return $this;
	}

	/**
	* Get codigoFuncionDocumento
	*
	* @return null|String
	*/
	public function getCodigoFuncionDocumento()
	{
		return $this->codigoFuncionDocumento;
	}

	/**
	* Set fechaSolicitud
	*
	*Fecha de solicitud del trámite en VUE
	*
	* @parámetro Date $fechaSolicitud
	* @return FechaSolicitud
	*/
	public function setFechaSolicitud($fechaSolicitud)
	{
	  $this->fechaSolicitud = (String) $fechaSolicitud;
	    return $this;
	}

	/**
	* Get fechaSolicitud
	*
	* @return null|Date
	*/
	public function getFechaSolicitud()
	{
		return $this->fechaSolicitud;
	}

	/**
	* Set idCiudadSolicitud
	*
	*Id de ciudad de solicitud
	*
	* @parámetro Integer $idCiudadSolicitud
	* @return IdCiudadSolicitud
	*/
	public function setIdCiudadSolicitud($idCiudadSolicitud)
	{
	  $this->idCiudadSolicitud = (Integer) $idCiudadSolicitud;
	    return $this;
	}

	/**
	* Get idCiudadSolicitud
	*
	* @return null|Integer
	*/
	public function getIdCiudadSolicitud()
	{
		return $this->idCiudadSolicitud;
	}

	/**
	* Set codigoCiudadSolicitud
	*
	*Código de la ciudad de solicitud VUE
	*
	* @parámetro String $codigoCiudadSolicitud
	* @return CodigoCiudadSolicitud
	*/
	public function setCodigoCiudadSolicitud($codigoCiudadSolicitud)
	{
	  $this->codigoCiudadSolicitud = (String) $codigoCiudadSolicitud;
	    return $this;
	}

	/**
	* Get codigoCiudadSolicitud
	*
	* @return null|String
	*/
	public function getCodigoCiudadSolicitud()
	{
		return $this->codigoCiudadSolicitud;
	}

	/**
	* Set nombreCiudadSolicitud
	*
	*Nombre de la ciudad de solicitud
	*
	* @parámetro String $nombreCiudadSolicitud
	* @return NombreCiudadSolicitud
	*/
	public function setNombreCiudadSolicitud($nombreCiudadSolicitud)
	{
	  $this->nombreCiudadSolicitud = (String) $nombreCiudadSolicitud;
	    return $this;
	}

	/**
	* Get nombreCiudadSolicitud
	*
	* @return null|String
	*/
	public function getNombreCiudadSolicitud()
	{
		return $this->nombreCiudadSolicitud;
	}

	/**
	* Set codigoTipoProducto
	*
	*Código de tipo producto VUE
	*
	* @parámetro String $codigoTipoProducto
	* @return CodigoTipoProducto
	*/
	public function setCodigoTipoProducto($codigoTipoProducto)
	{
	  $this->codigoTipoProducto = (String) $codigoTipoProducto;
	    return $this;
	}

	/**
	* Get codigoTipoProducto
	*
	* @return null|String
	*/
	public function getCodigoTipoProducto()
	{
		return $this->codigoTipoProducto;
	}

	/**
	* Set nombreTipoProducto
	*
	*Nombre del tipo de producto
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
	* Set idCiudadEmision
	*
	*Id de ciudad de emisión
	*
	* @parámetro Integer $idCiudadEmision
	* @return IdCiudadEmision
	*/
	public function setIdCiudadEmision($idCiudadEmision)
	{
	  $this->idCiudadEmision = (Integer) $idCiudadEmision;
	    return $this;
	}

	/**
	* Get idCiudadEmision
	*
	* @return null|Integer
	*/
	public function getIdCiudadEmision()
	{
		return $this->idCiudadEmision;
	}

	/**
	* Set codigoCiudadEmision
	*
	*Código ciudad de emisión VUE
	*
	* @parámetro String $codigoCiudadEmision
	* @return CodigoCiudadEmision
	*/
	public function setCodigoCiudadEmision($codigoCiudadEmision)
	{
	  $this->codigoCiudadEmision = (String) $codigoCiudadEmision;
	    return $this;
	}

	/**
	* Get codigoCiudadEmision
	*
	* @return null|String
	*/
	public function getCodigoCiudadEmision()
	{
		return $this->codigoCiudadEmision;
	}

	/**
	* Set nombreCiudadEmision
	*
	*Nombre de ciudad de emisión
	*
	* @parámetro String $nombreCiudadEmision
	* @return NombreCiudadEmision
	*/
	public function setNombreCiudadEmision($nombreCiudadEmision)
	{
	  $this->nombreCiudadEmision = (String) $nombreCiudadEmision;
	    return $this;
	}

	/**
	* Get nombreCiudadEmision
	*
	* @return null|String
	*/
	public function getNombreCiudadEmision()
	{
		return $this->nombreCiudadEmision;
	}

	/**
	* Set fechaInicioVigencia
	*
	*Fecha de inicio de vigencia de la solicitud
	*
	* @parámetro Date $fechaInicioVigencia
	* @return FechaInicioVigencia
	*/
	public function setFechaInicioVigencia($fechaInicioVigencia)
	{
	  $this->fechaInicioVigencia = (String) $fechaInicioVigencia;
	    return $this;
	}

	/**
	* Get fechaInicioVigencia
	*
	* @return null|Date
	*/
	public function getFechaInicioVigencia()
	{
		return $this->fechaInicioVigencia;
	}

	/**
	* Set fechaFinVigencia
	*
	*Fecha de fin de vigencia de la solicitud
	*
	* @parámetro Date $fechaFinVigencia
	* @return FechaFinVigencia
	*/
	public function setFechaFinVigencia($fechaFinVigencia)
	{
	  $this->fechaFinVigencia = (String) $fechaFinVigencia;
	    return $this;
	}

	/**
	* Get fechaFinVigencia
	*
	* @return null|Date
	*/
	public function getFechaFinVigencia()
	{
		return $this->fechaFinVigencia;
	}

	/**
	* Set identificadorSolicitante
	*
	*Identificador del solicitante
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
	* Set nombreSolicitante
	*
	*Nombre o razón social del solicitante
	*
	* @parámetro String $nombreSolicitante
	* @return NombreSolicitante
	*/
	public function setNombreSolicitante($nombreSolicitante)
	{
	  $this->nombreSolicitante = (String) $nombreSolicitante;
	    return $this;
	}

	/**
	* Get nombreSolicitante
	*
	* @return null|String
	*/
	public function getNombreSolicitante()
	{
		return $this->nombreSolicitante;
	}

	/**
	* Set representanteLegalSolicitante
	*
	*Nombre del representante legal del solicitante
	*
	* @parámetro String $representanteLegalSolicitante
	* @return RepresentanteLegalSolicitante
	*/
	public function setRepresentanteLegalSolicitante($representanteLegalSolicitante)
	{
	  $this->representanteLegalSolicitante = (String) $representanteLegalSolicitante;
	    return $this;
	}

	/**
	* Get representanteLegalSolicitante
	*
	* @return null|String
	*/
	public function getRepresentanteLegalSolicitante()
	{
		return $this->representanteLegalSolicitante;
	}

	/**
	* Set idProvinciaSolicitante
	*
	*Id de la prvincia del solicitante
	*
	* @parámetro Integer $idProvinciaSolicitante
	* @return IdProvinciaSolicitante
	*/
	public function setIdProvinciaSolicitante($idProvinciaSolicitante)
	{
	  $this->idProvinciaSolicitante = (Integer) $idProvinciaSolicitante;
	    return $this;
	}

	/**
	* Get idProvinciaSolicitante
	*
	* @return null|Integer
	*/
	public function getIdProvinciaSolicitante()
	{
		return $this->idProvinciaSolicitante;
	}

	/**
	* Set codigoProvinciaSolicitante
	*
	*Código de la provincia del solicitante VUE
	*
	* @parámetro String $codigoProvinciaSolicitante
	* @return CodigoProvinciaSolicitante
	*/
	public function setCodigoProvinciaSolicitante($codigoProvinciaSolicitante)
	{
	  $this->codigoProvinciaSolicitante = (String) $codigoProvinciaSolicitante;
	    return $this;
	}

	/**
	* Get codigoProvinciaSolicitante
	*
	* @return null|String
	*/
	public function getCodigoProvinciaSolicitante()
	{
		return $this->codigoProvinciaSolicitante;
	}

	/**
	* Set nombreProvinciaSolicitante
	*
	*Nombre de la provincia del solicitante
	*
	* @parámetro String $nombreProvinciaSolicitante
	* @return NombreProvinciaSolicitante
	*/
	public function setNombreProvinciaSolicitante($nombreProvinciaSolicitante)
	{
	  $this->nombreProvinciaSolicitante = (String) $nombreProvinciaSolicitante;
	    return $this;
	}

	/**
	* Get nombreProvinciaSolicitante
	*
	* @return null|String
	*/
	public function getNombreProvinciaSolicitante()
	{
		return $this->nombreProvinciaSolicitante;
	}

	/**
	* Set idCantonSolicitante
	*
	*Id del cantón del solicitante
	*
	* @parámetro Integer $idCantonSolicitante
	* @return IdCantonSolicitante
	*/
	public function setIdCantonSolicitante($idCantonSolicitante)
	{
	  $this->idCantonSolicitante = (Integer) $idCantonSolicitante;
	    return $this;
	}

	/**
	* Get idCantonSolicitante
	*
	* @return null|Integer
	*/
	public function getIdCantonSolicitante()
	{
		return $this->idCantonSolicitante;
	}

	/**
	* Set codigoCantonSolicitante
	*
	*Código del cantón del solicitante VUE
	*
	* @parámetro String $codigoCantonSolicitante
	* @return CodigoCantonSolicitante
	*/
	public function setCodigoCantonSolicitante($codigoCantonSolicitante)
	{
	  $this->codigoCantonSolicitante = (String) $codigoCantonSolicitante;
	    return $this;
	}

	/**
	* Get codigoCantonSolicitante
	*
	* @return null|String
	*/
	public function getCodigoCantonSolicitante()
	{
		return $this->codigoCantonSolicitante;
	}

	/**
	* Set nombreCantonSolicitante
	*
	*Nombre del cantón del solicitante
	*
	* @parámetro String $nombreCantonSolicitante
	* @return NombreCantonSolicitante
	*/
	public function setNombreCantonSolicitante($nombreCantonSolicitante)
	{
	  $this->nombreCantonSolicitante = (String) $nombreCantonSolicitante;
	    return $this;
	}

	/**
	* Get nombreCantonSolicitante
	*
	* @return null|String
	*/
	public function getNombreCantonSolicitante()
	{
		return $this->nombreCantonSolicitante;
	}

	/**
	* Set idParroquiaSolicitante
	*
	*Id de la parroquia del solicitante
	*
	* @parámetro Integer $idParroquiaSolicitante
	* @return IdParroquiaSolicitante
	*/
	public function setIdParroquiaSolicitante($idParroquiaSolicitante)
	{
	  $this->idParroquiaSolicitante = (Integer) $idParroquiaSolicitante;
	    return $this;
	}

	/**
	* Get idParroquiaSolicitante
	*
	* @return null|Integer
	*/
	public function getIdParroquiaSolicitante()
	{
		return $this->idParroquiaSolicitante;
	}

	/**
	* Set codigoParroquiaSolicitante
	*
	*Código de la parroquia del solicitante VUE
	*
	* @parámetro String $codigoParroquiaSolicitante
	* @return CodigoParroquiaSolicitante
	*/
	public function setCodigoParroquiaSolicitante($codigoParroquiaSolicitante)
	{
	  $this->codigoParroquiaSolicitante = (String) $codigoParroquiaSolicitante;
	    return $this;
	}

	/**
	* Get codigoParroquiaSolicitante
	*
	* @return null|String
	*/
	public function getCodigoParroquiaSolicitante()
	{
		return $this->codigoParroquiaSolicitante;
	}

	/**
	* Set nombreParroquiaSolicitante
	*
	*Nombre de la parroquia del solicitante
	*
	* @parámetro String $nombreParroquiaSolicitante
	* @return NombreParroquiaSolicitante
	*/
	public function setNombreParroquiaSolicitante($nombreParroquiaSolicitante)
	{
	  $this->nombreParroquiaSolicitante = (String) $nombreParroquiaSolicitante;
	    return $this;
	}

	/**
	* Get nombreParroquiaSolicitante
	*
	* @return null|String
	*/
	public function getNombreParroquiaSolicitante()
	{
		return $this->nombreParroquiaSolicitante;
	}

	/**
	* Set direccionSolicitante
	*
	*Dirección del solicitante
	*
	* @parámetro String $direccionSolicitante
	* @return DireccionSolicitante
	*/
	public function setDireccionSolicitante($direccionSolicitante)
	{
	  $this->direccionSolicitante = (String) $direccionSolicitante;
	    return $this;
	}

	/**
	* Get direccionSolicitante
	*
	* @return null|String
	*/
	public function getDireccionSolicitante()
	{
		return $this->direccionSolicitante;
	}

	/**
	* Set telefonoSolicitante
	*
	*Teléfono del solicitante
	*
	* @parámetro String $telefonoSolicitante
	* @return TelefonoSolicitante
	*/
	public function setTelefonoSolicitante($telefonoSolicitante)
	{
	  $this->telefonoSolicitante = (String) $telefonoSolicitante;
	    return $this;
	}

	/**
	* Get telefonoSolicitante
	*
	* @return null|String
	*/
	public function getTelefonoSolicitante()
	{
		return $this->telefonoSolicitante;
	}

	/**
	* Set faxSolicitante
	*
	*Fax del solicitante
	*
	* @parámetro String $faxSolicitante
	* @return FaxSolicitante
	*/
	public function setFaxSolicitante($faxSolicitante)
	{
	  $this->faxSolicitante = (String) $faxSolicitante;
	    return $this;
	}

	/**
	* Get faxSolicitante
	*
	* @return null|String
	*/
	public function getFaxSolicitante()
	{
		return $this->faxSolicitante;
	}

	/**
	* Set correoSolicitante
	*
	*Correo electrónico del solicitante
	*
	* @parámetro String $correoSolicitante
	* @return CorreoSolicitante
	*/
	public function setCorreoSolicitante($correoSolicitante)
	{
	  $this->correoSolicitante = (String) $correoSolicitante;
	    return $this;
	}

	/**
	* Get correoSolicitante
	*
	* @return null|String
	*/
	public function getCorreoSolicitante()
	{
		return $this->correoSolicitante;
	}

	/**
	* Set clasificacionImportador
	*
	*Clasificación del importador VUE
	*
	* @parámetro String $clasificacionImportador
	* @return ClasificacionImportador
	*/
	public function setClasificacionImportador($clasificacionImportador)
	{
	  $this->clasificacionImportador = (String) $clasificacionImportador;
	    return $this;
	}

	/**
	* Get clasificacionImportador
	*
	* @return null|String
	*/
	public function getClasificacionImportador()
	{
		return $this->clasificacionImportador;
	}

	/**
	* Set identificadorImportador
	*
	*Identificador del importador
	*
	* @parámetro String $identificadorImportador
	* @return IdentificadorImportador
	*/
	public function setIdentificadorImportador($identificadorImportador)
	{
	  $this->identificadorImportador = (String) $identificadorImportador;
	    return $this;
	}

	/**
	* Get identificadorImportador
	*
	* @return null|String
	*/
	public function getIdentificadorImportador()
	{
		return $this->identificadorImportador;
	}

	/**
	* Set nombreImportador
	*
	*Nombre del importador
	*
	* @parámetro String $nombreImportador
	* @return NombreImportador
	*/
	public function setNombreImportador($nombreImportador)
	{
	  $this->nombreImportador = (String) $nombreImportador;
	    return $this;
	}

	/**
	* Get nombreImportador
	*
	* @return null|String
	*/
	public function getNombreImportador()
	{
		return $this->nombreImportador;
	}

	/**
	* Set idCantonImportador
	*
	*Id del cantón del importador
	*
	* @parámetro Integer $idCantonImportador
	* @return IdCantonImportador
	*/
	public function setIdCantonImportador($idCantonImportador)
	{
	  $this->idCantonImportador = (Integer) $idCantonImportador;
	    return $this;
	}

	/**
	* Get idCantonImportador
	*
	* @return null|Integer
	*/
	public function getIdCantonImportador()
	{
		return $this->idCantonImportador;
	}

	/**
	* Set codigoCantonImportador
	*
	*
	*
	* @parámetro String $codigoCantonImportador
	* @return CodigoCantonImportador
	*/
	public function setCodigoCantonImportador($codigoCantonImportador)
	{
	  $this->codigoCantonImportador = (String) $codigoCantonImportador;
	    return $this;
	}

	/**
	* Get codigoCantonImportador
	*
	* @return null|String
	*/
	public function getCodigoCantonImportador()
	{
		return $this->codigoCantonImportador;
	}

	/**
	* Set nombreCantonImportador
	*
	*
	*
	* @parámetro String $nombreCantonImportador
	* @return NombreCantonImportador
	*/
	public function setNombreCantonImportador($nombreCantonImportador)
	{
	  $this->nombreCantonImportador = (String) $nombreCantonImportador;
	    return $this;
	}

	/**
	* Get nombreCantonImportador
	*
	* @return null|String
	*/
	public function getNombreCantonImportador()
	{
		return $this->nombreCantonImportador;
	}

	/**
	* Set idParroquiaImportador
	*
	*
	*
	* @parámetro Integer $idParroquiaImportador
	* @return IdParroquiaImportador
	*/
	public function setIdParroquiaImportador($idParroquiaImportador)
	{
	  $this->idParroquiaImportador = (Integer) $idParroquiaImportador;
	    return $this;
	}

	/**
	* Get idParroquiaImportador
	*
	* @return null|Integer
	*/
	public function getIdParroquiaImportador()
	{
		return $this->idParroquiaImportador;
	}

	/**
	* Set codigoParroquiaImportador
	*
	*
	*
	* @parámetro String $codigoParroquiaImportador
	* @return CodigoParroquiaImportador
	*/
	public function setCodigoParroquiaImportador($codigoParroquiaImportador)
	{
	  $this->codigoParroquiaImportador = (String) $codigoParroquiaImportador;
	    return $this;
	}

	/**
	* Get codigoParroquiaImportador
	*
	* @return null|String
	*/
	public function getCodigoParroquiaImportador()
	{
		return $this->codigoParroquiaImportador;
	}

	/**
	* Set nombreParroquiaImportador
	*
	*
	*
	* @parámetro String $nombreParroquiaImportador
	* @return NombreParroquiaImportador
	*/
	public function setNombreParroquiaImportador($nombreParroquiaImportador)
	{
	  $this->nombreParroquiaImportador = (String) $nombreParroquiaImportador;
	    return $this;
	}

	/**
	* Get nombreParroquiaImportador
	*
	* @return null|String
	*/
	public function getNombreParroquiaImportador()
	{
		return $this->nombreParroquiaImportador;
	}

	/**
	* Set direccionImportador
	*
	*
	*
	* @parámetro String $direccionImportador
	* @return DireccionImportador
	*/
	public function setDireccionImportador($direccionImportador)
	{
	  $this->direccionImportador = (String) $direccionImportador;
	    return $this;
	}

	/**
	* Get direccionImportador
	*
	* @return null|String
	*/
	public function getDireccionImportador()
	{
		return $this->direccionImportador;
	}

	/**
	* Set correoImportador
	*
	*
	*
	* @parámetro String $correoImportador
	* @return CorreoImportador
	*/
	public function setCorreoImportador($correoImportador)
	{
	  $this->correoImportador = (String) $correoImportador;
	    return $this;
	}

	/**
	* Get correoImportador
	*
	* @return null|String
	*/
	public function getCorreoImportador()
	{
		return $this->correoImportador;
	}

	/**
	* Set representanteLegalImportador
	*
	*
	*
	* @parámetro String $representanteLegalImportador
	* @return RepresentanteLegalImportador
	*/
	public function setRepresentanteLegalImportador($representanteLegalImportador)
	{
	  $this->representanteLegalImportador = (String) $representanteLegalImportador;
	    return $this;
	}

	/**
	* Get representanteLegalImportador
	*
	* @return null|String
	*/
	public function getRepresentanteLegalImportador()
	{
		return $this->representanteLegalImportador;
	}

	/**
	* Set telefonoImportador
	*
	*
	*
	* @parámetro String $telefonoImportador
	* @return TelefonoImportador
	*/
	public function setTelefonoImportador($telefonoImportador)
	{
	  $this->telefonoImportador = (String) $telefonoImportador;
	    return $this;
	}

	/**
	* Get telefonoImportador
	*
	* @return null|String
	*/
	public function getTelefonoImportador()
	{
		return $this->telefonoImportador;
	}

	/**
	* Set celularImportador
	*
	*
	*
	* @parámetro String $celularImportador
	* @return CelularImportador
	*/
	public function setCelularImportador($celularImportador)
	{
	  $this->celularImportador = (String) $celularImportador;
	    return $this;
	}

	/**
	* Get celularImportador
	*
	* @return null|String
	*/
	public function getCelularImportador()
	{
		return $this->celularImportador;
	}

	/**
	* Set codigoRegimenAduanero
	*
	*
	*
	* @parámetro String $codigoRegimenAduanero
	* @return CodigoRegimenAduanero
	*/
	public function setCodigoRegimenAduanero($codigoRegimenAduanero)
	{
	  $this->codigoRegimenAduanero = (String) $codigoRegimenAduanero;
	    return $this;
	}

	/**
	* Get codigoRegimenAduanero
	*
	* @return null|String
	*/
	public function getCodigoRegimenAduanero()
	{
		return $this->codigoRegimenAduanero;
	}

	/**
	* Set nombreRegimenAduanero
	*
	*
	*
	* @parámetro String $nombreRegimenAduanero
	* @return NombreRegimenAduanero
	*/
	public function setNombreRegimenAduanero($nombreRegimenAduanero)
	{
	  $this->nombreRegimenAduanero = (String) $nombreRegimenAduanero;
	    return $this;
	}

	/**
	* Get nombreRegimenAduanero
	*
	* @return null|String
	*/
	public function getNombreRegimenAduanero()
	{
		return $this->nombreRegimenAduanero;
	}

	/**
	* Set idPaisOrigen
	*
	*
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
	* Set codigoPaisOrigen
	*
	*
	*
	* @parámetro String $codigoPaisOrigen
	* @return CodigoPaisOrigen
	*/
	public function setCodigoPaisOrigen($codigoPaisOrigen)
	{
	  $this->codigoPaisOrigen = (String) $codigoPaisOrigen;
	    return $this;
	}

	/**
	* Get codigoPaisOrigen
	*
	* @return null|String
	*/
	public function getCodigoPaisOrigen()
	{
		return $this->codigoPaisOrigen;
	}

	/**
	* Set nombrePaisOrigen
	*
	*
	*
	* @parámetro String $nombrePaisOrigen
	* @return NombrePaisOrigen
	*/
	public function setNombrePaisOrigen($nombrePaisOrigen)
	{
	  $this->nombrePaisOrigen = (String) $nombrePaisOrigen;
	    return $this;
	}

	/**
	* Get nombrePaisOrigen
	*
	* @return null|String
	*/
	public function getNombrePaisOrigen()
	{
		return $this->nombrePaisOrigen;
	}

	/**
	* Set idPaisProcedencia
	*
	*
	*
	* @parámetro Integer $idPaisProcedencia
	* @return IdPaisProcedencia
	*/
	public function setIdPaisProcedencia($idPaisProcedencia)
	{
	  $this->idPaisProcedencia = (Integer) $idPaisProcedencia;
	    return $this;
	}

	/**
	* Get idPaisProcedencia
	*
	* @return null|Integer
	*/
	public function getIdPaisProcedencia()
	{
		return $this->idPaisProcedencia;
	}

	/**
	* Set codigoPaisProcedencia
	*
	*
	*
	* @parámetro String $codigoPaisProcedencia
	* @return CodigoPaisProcedencia
	*/
	public function setCodigoPaisProcedencia($codigoPaisProcedencia)
	{
	  $this->codigoPaisProcedencia = (String) $codigoPaisProcedencia;
	    return $this;
	}

	/**
	* Get codigoPaisProcedencia
	*
	* @return null|String
	*/
	public function getCodigoPaisProcedencia()
	{
		return $this->codigoPaisProcedencia;
	}

	/**
	* Set nombrePaisProcedencia
	*
	*
	*
	* @parámetro String $nombrePaisProcedencia
	* @return NombrePaisProcedencia
	*/
	public function setNombrePaisProcedencia($nombrePaisProcedencia)
	{
	  $this->nombrePaisProcedencia = (String) $nombrePaisProcedencia;
	    return $this;
	}

	/**
	* Get nombrePaisProcedencia
	*
	* @return null|String
	*/
	public function getNombrePaisProcedencia()
	{
		return $this->nombrePaisProcedencia;
	}

	/**
	* Set idPaisDestino
	*
	*
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
	* Set codigoPaisDestino
	*
	*
	*
	* @parámetro String $codigoPaisDestino
	* @return CodigoPaisDestino
	*/
	public function setCodigoPaisDestino($codigoPaisDestino)
	{
	  $this->codigoPaisDestino = (String) $codigoPaisDestino;
	    return $this;
	}

	/**
	* Get codigoPaisDestino
	*
	* @return null|String
	*/
	public function getCodigoPaisDestino()
	{
		return $this->codigoPaisDestino;
	}

	/**
	* Set nombrePaisDestino
	*
	*
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
	* Set idUbicacionEnvio
	*
	*
	*
	* @parámetro Integer $idUbicacionEnvio
	* @return IdUbicacionEnvio
	*/
	public function setIdUbicacionEnvio($idUbicacionEnvio)
	{
	  $this->idUbicacionEnvio = (Integer) $idUbicacionEnvio;
	    return $this;
	}

	/**
	* Get idUbicacionEnvio
	*
	* @return null|Integer
	*/
	public function getIdUbicacionEnvio()
	{
		return $this->idUbicacionEnvio;
	}

	/**
	* Set codigoUbicacionEnvio
	*
	*
	*
	* @parámetro String $codigoUbicacionEnvio
	* @return CodigoUbicacionEnvio
	*/
	public function setCodigoUbicacionEnvio($codigoUbicacionEnvio)
	{
	  $this->codigoUbicacionEnvio = (String) $codigoUbicacionEnvio;
	    return $this;
	}

	/**
	* Get codigoUbicacionEnvio
	*
	* @return null|String
	*/
	public function getCodigoUbicacionEnvio()
	{
		return $this->codigoUbicacionEnvio;
	}

	/**
	* Set nombreUbicacionEnvio
	*
	*
	*
	* @parámetro String $nombreUbicacionEnvio
	* @return NombreUbicacionEnvio
	*/
	public function setNombreUbicacionEnvio($nombreUbicacionEnvio)
	{
	  $this->nombreUbicacionEnvio = (String) $nombreUbicacionEnvio;
	    return $this;
	}

	/**
	* Get nombreUbicacionEnvio
	*
	* @return null|String
	*/
	public function getNombreUbicacionEnvio()
	{
		return $this->nombreUbicacionEnvio;
	}

	/**
	* Set idPuntoIngreso
	*
	*
	*
	* @parámetro Integer $idPuntoIngreso
	* @return IdPuntoIngreso
	*/
	public function setIdPuntoIngreso($idPuntoIngreso)
	{
	  $this->idPuntoIngreso = (Integer) $idPuntoIngreso;
	    return $this;
	}

	/**
	* Get idPuntoIngreso
	*
	* @return null|Integer
	*/
	public function getIdPuntoIngreso()
	{
		return $this->idPuntoIngreso;
	}

	/**
	* Set codigoPuntoIngreso
	*
	*
	*
	* @parámetro String $codigoPuntoIngreso
	* @return CodigoPuntoIngreso
	*/
	public function setCodigoPuntoIngreso($codigoPuntoIngreso)
	{
	  $this->codigoPuntoIngreso = (String) $codigoPuntoIngreso;
	    return $this;
	}

	/**
	* Get codigoPuntoIngreso
	*
	* @return null|String
	*/
	public function getCodigoPuntoIngreso()
	{
		return $this->codigoPuntoIngreso;
	}

	/**
	* Set nombrePuntoIngreso
	*
	*
	*
	* @parámetro String $nombrePuntoIngreso
	* @return NombrePuntoIngreso
	*/
	public function setNombrePuntoIngreso($nombrePuntoIngreso)
	{
	  $this->nombrePuntoIngreso = (String) $nombrePuntoIngreso;
	    return $this;
	}

	/**
	* Get nombrePuntoIngreso
	*
	* @return null|String
	*/
	public function getNombrePuntoIngreso()
	{
		return $this->nombrePuntoIngreso;
	}

	/**
	* Set idPuntoSalida
	*
	*
	*
	* @parámetro Integer $idPuntoSalida
	* @return IdPuntoSalida
	*/
	public function setIdPuntoSalida($idPuntoSalida)
	{
	  $this->idPuntoSalida = (Integer) $idPuntoSalida;
	    return $this;
	}

	/**
	* Get idPuntoSalida
	*
	* @return null|Integer
	*/
	public function getIdPuntoSalida()
	{
		return $this->idPuntoSalida;
	}

	/**
	* Set codigoPuntoSalida
	*
	*
	*
	* @parámetro String $codigoPuntoSalida
	* @return CodigoPuntoSalida
	*/
	public function setCodigoPuntoSalida($codigoPuntoSalida)
	{
	  $this->codigoPuntoSalida = (String) $codigoPuntoSalida;
	    return $this;
	}

	/**
	* Get codigoPuntoSalida
	*
	* @return null|String
	*/
	public function getCodigoPuntoSalida()
	{
		return $this->codigoPuntoSalida;
	}

	/**
	* Set nombrePuntoSalida
	*
	*
	*
	* @parámetro String $nombrePuntoSalida
	* @return NombrePuntoSalida
	*/
	public function setNombrePuntoSalida($nombrePuntoSalida)
	{
	  $this->nombrePuntoSalida = (String) $nombrePuntoSalida;
	    return $this;
	}

	/**
	* Get nombrePuntoSalida
	*
	* @return null|String
	*/
	public function getNombrePuntoSalida()
	{
		return $this->nombrePuntoSalida;
	}

	/**
	* Set idMedioTransporte
	*
	*
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
	* Set codigoMedioTransporte
	*
	*
	*
	* @parámetro String $codigoMedioTransporte
	* @return CodigoMedioTransporte
	*/
	public function setCodigoMedioTransporte($codigoMedioTransporte)
	{
	  $this->codigoMedioTransporte = (String) $codigoMedioTransporte;
	    return $this;
	}

	/**
	* Get codigoMedioTransporte
	*
	* @return null|String
	*/
	public function getCodigoMedioTransporte()
	{
		return $this->codigoMedioTransporte;
	}

	/**
	* Set nombreMedioTransporte
	*
	*
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
	* Set placaVehiculo
	*
	*
	*
	* @parámetro String $placaVehiculo
	* @return PlacaVehiculo
	*/
	public function setPlacaVehiculo($placaVehiculo)
	{
	  $this->placaVehiculo = (String) $placaVehiculo;
	    return $this;
	}

	/**
	* Get placaVehiculo
	*
	* @return null|String
	*/
	public function getPlacaVehiculo()
	{
		return $this->placaVehiculo;
	}

	/**
	* Set rutaSeguir
	*
	*
	*
	* @parámetro String $rutaSeguir
	* @return RutaSeguir
	*/
	public function setRutaSeguir($rutaSeguir)
	{
	  $this->rutaSeguir = (String) $rutaSeguir;
	    return $this;
	}

	/**
	* Get rutaSeguir
	*
	* @return null|String
	*/
	public function getRutaSeguir()
	{
		return $this->rutaSeguir;
	}

	/**
	* Set estado
	*
	*
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
	* Set identificadorTecnico
	*
	*
	*
	* @parámetro String $identificadorTecnico
	* @return IdentificadorTecnico
	*/
	public function setIdentificadorTecnico($identificadorTecnico)
	{
	  $this->identificadorTecnico = (String) $identificadorTecnico;
	    return $this;
	}

	/**
	* Get identificadorTecnico
	*
	* @return null|String
	*/
	public function getIdentificadorTecnico()
	{
		return $this->identificadorTecnico;
	}

	/**
	* Set observacionTecnico
	*
	*
	*
	* @parámetro String $observacionTecnico
	* @return ObservacionTecnico
	*/
	public function setObservacionTecnico($observacionTecnico)
	{
	  $this->observacionTecnico = (String) $observacionTecnico;
	    return $this;
	}

	/**
	* Get observacionTecnico
	*
	* @return null|String
	*/
	public function getObservacionTecnico()
	{
		return $this->observacionTecnico;
	}

	/**
	* Set informeRequisitos
	*
	*Ruta del documento con los requisitos fitosanitarios para tránsito internacional
	*
	* @parámetro String $informeRequisitos
	* @return InformeRequisitos
	*/
	public function setInformeRequisitos($informeRequisitos)
	{
	  $this->informeRequisitos = (String) $informeRequisitos;
	    return $this;
	}

	/**
	* Get informeRequisitos
	*
	* @return null|String
	*/
	public function getInformeRequisitos()
	{
		return $this->informeRequisitos;
	}

	/**
	* Set codigoCertificado
	*
	*
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
	* @return TransitoInternacionalModelo
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
