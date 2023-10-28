<?php
 /**
 * Modelo SolicitudAsignacionCuvModelo
 *
 * Este archivo se complementa con el archivo   SolicitudAsignacionCuvLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    SolicitudAsignacionCuvModelo
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class SolicitudAsignacionCuvModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Llave principal de la tabla
		*/
		protected $idSolicitudAsignacionCuv;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Llave foránea (redundante) de la tabla g_catalogos.localizacion(Destino)
		*/
		protected $idProvincia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la provincia de la tabla g_catalogos.localizacion(Destino)
		*/
		protected $provincia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Siglas del CUV (PPC)
		*/
		protected $siglas;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Corresponde al año en el que se hizo la carga a la provincia.
		*/
		protected $anio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Es el numero de tres cifras antes del codigo del CUV
		*/
		protected $prefijoCuvNumerico;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Operadores que solicitan cuv para su provincia
		*/
		protected $operadorSolicitante;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Cantidad solicitada para redistribuir
		*/
		protected $cantidadSolicitada;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Técnico encargado de la aprobación revisa la solicitud y verifica la disponibilidad de números CUV en la tabla distribucion_inicial_cuv
		*/
		protected $tecnicoAprobo;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Estado de la las solicitudes aprobado, rechazado
		*/
		protected $estadoSolicitud;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Estado de la tabla
		*/
		protected $estado;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Observaciones de la solicitud
		*/
		protected $observaciones;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Identificador del operador solicitante
		*/
		protected $operadorSolicitanteIdentificador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* identificador del tecnico que aprobo la solicitud
		*/
		protected $tecnicoAproboIdentificador;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Fecha de creación del registro
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
	Private $esquema ="g_asignacion_cuv";

	/**
	* Nombre de la tabla: solicitud_asignacion_cuv
	* 
	 */
	Private $tabla="solicitud_asignacion_cuv";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_solicitud_asignacion_cuv";



	/**
	*Secuencia 
*/
		 private $secuencial = 'g_asignacion_cuv"."solicitud_asignacion_cuv_id_solicitud_asignacion_cuv_seq'; 



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
		throw new \Exception('Clase Modelo: SolicitudAsignacionCuvModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: SolicitudAsignacionCuvModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idSolicitudAsignacionCuv
	*
	*Llave principal de la tabla
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
	* Set idProvincia
	*
	*Llave foránea (redundante) de la tabla g_catalogos.localizacion(Destino)
	*
	* @parámetro Integer $idProvincia
	* @return IdProvincia
	*/
	public function setIdProvincia($idProvincia)
	{
	  $this->idProvincia = (Integer) $idProvincia;
	    return $this;
	}

	/**
	* Get idProvincia
	*
	* @return null|Integer
	*/
	public function getIdProvincia()
	{
		return $this->idProvincia;
	}

	/**
	* Set provincia
	*
	*Nombre de la provincia de la tabla g_catalogos.localizacion(Destino)
	*
	* @parámetro String $provincia
	* @return Provincia
	*/
	public function setProvincia($provincia)
	{
	  $this->provincia = (String) $provincia;
	    return $this;
	}

	/**
	* Get provincia
	*
	* @return null|String
	*/
	public function getProvincia()
	{
		return $this->provincia;
	}

	/**
	* Set siglas
	*
	*Siglas del CUV (PPC)
	*
	* @parámetro String $siglas
	* @return Siglas
	*/
	public function setSiglas($siglas)
	{
	  $this->siglas = (String) $siglas;
	    return $this;
	}

	/**
	* Get siglas
	*
	* @return null|String
	*/
	public function getSiglas()
	{
		return $this->siglas;
	}

	/**
	* Set anio
	*
	*Corresponde al año en el que se hizo la carga a la provincia.
	*
	* @parámetro Integer $anio
	* @return Anio
	*/
	public function setAnio($anio)
	{
	  $this->anio = (Integer) $anio;
	    return $this;
	}

	/**
	* Get anio
	*
	* @return null|Integer
	*/
	public function getAnio()
	{
		return $this->anio;
	}

	/**
	* Set prefijoCuvNumerico
	*
	*Es el numero de tres cifras antes del codigo del CUV
	*
	* @parámetro String $prefijoCuvNumerico
	* @return PrefijoCuvNumerico
	*/
	public function setPrefijoCuvNumerico($prefijoCuvNumerico)
	{
	  $this->prefijoCuvNumerico = (String) $prefijoCuvNumerico;
	    return $this;
	}

	/**
	* Get prefijoCuvNumerico
	*
	* @return null|String
	*/
	public function getPrefijoCuvNumerico()
	{
		return $this->prefijoCuvNumerico;
	}

	/**
	* Set operadorSolicitante
	*
	*Operadores que solicitan cuv para su provincia
	*
	* @parámetro String $operadorSolicitante
	* @return OperadorSolicitante
	*/
	public function setOperadorSolicitante($operadorSolicitante)
	{
	  $this->operadorSolicitante = (String) $operadorSolicitante;
	    return $this;
	}

	/**
	* Get operadorSolicitante
	*
	* @return null|String
	*/
	public function getOperadorSolicitante()
	{
		return $this->operadorSolicitante;
	}

	/**
	* Set cantidadSolicitada
	*
	*Cantidad solicitada para redistribuir
	*
	* @parámetro String $cantidadSolicitada
	* @return CantidadSolicitada
	*/
	public function setCantidadSolicitada($cantidadSolicitada)
	{
	  $this->cantidadSolicitada = (String) $cantidadSolicitada;
	    return $this;
	}

	/**
	* Get cantidadSolicitada
	*
	* @return null|String
	*/
	public function getCantidadSolicitada()
	{
		return $this->cantidadSolicitada;
	}

	/**
	* Set tecnicoAprobo
	*
	*Técnico encargado de la aprobación revisa la solicitud y verifica la disponibilidad de números CUV en la tabla distribucion_inicial_cuv
	*
	* @parámetro String $tecnicoAprobo
	* @return TecnicoAprobo
	*/
	public function setTecnicoAprobo($tecnicoAprobo)
	{
	  $this->tecnicoAprobo = (String) $tecnicoAprobo;
	    return $this;
	}

	/**
	* Get tecnicoAprobo
	*
	* @return null|String
	*/
	public function getTecnicoAprobo()
	{
		return $this->tecnicoAprobo;
	}

	/**
	* Set estadoSolicitud
	*
	*Estado de la las solicitudes aprobado, rechazado
	*
	* @parámetro String $estadoSolicitud
	* @return EstadoSolicitud
	*/
	public function setEstadoSolicitud($estadoSolicitud)
	{
	  $this->estadoSolicitud = (String) $estadoSolicitud;
	    return $this;
	}

	/**
	* Get estadoSolicitud
	*
	* @return null|String
	*/
	public function getEstadoSolicitud()
	{
		return $this->estadoSolicitud;
	}

	/**
	* Set estado
	*
	*Estado de la tabla
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
	* Set observaciones
	*
	*Observaciones de la solicitud
	*
	* @parámetro String $observaciones
	* @return Observaciones
	*/
	public function setObservaciones($observaciones)
	{
	  $this->observaciones = (String) $observaciones;
	    return $this;
	}

	/**
	* Get observaciones
	*
	* @return null|String
	*/
	public function getObservaciones()
	{
		return $this->observaciones;
	}

	/**
	* Set operadorSolicitanteIdentificador
	*
	*Identificador del operador solicitante
	*
	* @parámetro String $operadorSolicitanteIdentificador
	* @return OperadorSolicitanteIdentificador
	*/
	public function setOperadorSolicitanteIdentificador($operadorSolicitanteIdentificador)
	{
	  $this->operadorSolicitanteIdentificador = (String) $operadorSolicitanteIdentificador;
	    return $this;
	}

	/**
	* Get operadorSolicitanteIdentificador
	*
	* @return null|String
	*/
	public function getOperadorSolicitanteIdentificador()
	{
		return $this->operadorSolicitanteIdentificador;
	}

	/**
	* Set tecnicoAproboIdentificador
	*
	*identificador del tecnico que aprobo la solicitud
	*
	* @parámetro String $tecnicoAproboIdentificador
	* @return TecnicoAproboIdentificador
	*/
	public function setTecnicoAproboIdentificador($tecnicoAproboIdentificador)
	{
	  $this->tecnicoAproboIdentificador = (String) $tecnicoAproboIdentificador;
	    return $this;
	}

	/**
	* Get tecnicoAproboIdentificador
	*
	* @return null|String
	*/
	public function getTecnicoAproboIdentificador()
	{
		return $this->tecnicoAproboIdentificador;
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
	* @return SolicitudAsignacionCuvModelo
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
