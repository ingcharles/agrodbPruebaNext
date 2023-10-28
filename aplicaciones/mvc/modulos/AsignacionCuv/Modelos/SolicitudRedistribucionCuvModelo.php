<?php
 /**
 * Modelo SolicitudRedistribucionCuvModelo
 *
 * Este archivo se complementa con el archivo   SolicitudRedistribucionCuvLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    SolicitudRedistribucionCuvModelo
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class SolicitudRedistribucionCuvModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Llave principal de la tabla
		*/
		protected $idSolicitudRedistribucionCuv;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Siglas del CUV (PPC)
		*/
		protected $siglas;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Corresponde al aÃ±o en el que se hizo la carga a la provincia.
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
		* @var Integer
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Llave forÃ¡nea (redundante) de la tabla g_catalogos.localizacion(Destino) que tiene cuvs disponibles
		*/
		protected $idProvinciaOrigen;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre de la provincia origen de la tabla g_catalogos.localizacion(Destino) que va a dar sus CUV
		*/
		protected $provinciaOrigen;
		/**
		* @var Integer
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Llave forÃ¡nea (redundante) de la tabla g_catalogos.localizacion(Destino) que va a recibir los cuvs
		*/
		protected $idProvinciaDestino;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Nombre de la provincia destino de la tabla g_catalogos.localizacion(Destino) que va a recibir sus CUV
		*/
		protected $provinciaDestino;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* TÃ©cnico encargado de enviar la solicitud
		*/
		protected $tecnicoProvincia;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Cantidad que solicita la provincia destino
		*/
		protected $cantidadSolicitada;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* TÃ©cnico de planta central encargado de aprobar la solicitud
		*/
		protected $tecnicoPlantaCentral;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Estado de la las solicitudes pendiente, pendiente envio, pendiente asignacion, aprobado
		*/
		protected $estadoSolicitud;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Estado de la tabla
		*/
		protected $estado;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Observaciones de la solicitud
		*/
		protected $observaciones;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Identificador del tecnico de provincia
		*/
		protected $tecnicoProvinciaIdentificador;
		/**
		* @var String
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* identificador del tecnico que aprobo la solicitud
		*/
		protected $tecnicoPlantaCentralIdentificador;
		/**
		* @var Date
		* Campo opcional
		* Campo oculto en el formulario o manejado internamente
		* Fecha de creaciÃ³n del registro
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
	* Nombre de la tabla: solicitud_redistribucion_cuv
	* 
	 */
	Private $tabla="solicitud_redistribucion_cuv";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_solicitud_redistribucion_cuv";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_asignacion_cuv"."solicitud_redistribucion_cuv_id_solicitud_redistribucion_cu_seq'; 



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
		throw new \Exception('Clase Modelo: SolicitudRedistribucionCuvModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: SolicitudRedistribucionCuvModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idSolicitudRedistribucionCuv
	*
	*Llave principal de la tabla
	*
	* @parámetro Integer $idSolicitudRedistribucionCuv
	* @return IdSolicitudRedistribucionCuv
	*/
	public function setIdSolicitudRedistribucionCuv($idSolicitudRedistribucionCuv)
	{
	  $this->idSolicitudRedistribucionCuv = (Integer) $idSolicitudRedistribucionCuv;
	    return $this;
	}

	/**
	* Get idSolicitudRedistribucionCuv
	*
	* @return null|Integer
	*/
	public function getIdSolicitudRedistribucionCuv()
	{
		return $this->idSolicitudRedistribucionCuv;
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
	*Corresponde al aÃ±o en el que se hizo la carga a la provincia.
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
	* Set idProvinciaOrigen
	*
	*Llave forÃ¡nea (redundante) de la tabla g_catalogos.localizacion(Destino) que tiene cuvs disponibles
	*
	* @parámetro Integer $idProvinciaOrigen
	* @return IdProvinciaOrigen
	*/
	public function setIdProvinciaOrigen($idProvinciaOrigen)
	{
	  $this->idProvinciaOrigen = (Integer) $idProvinciaOrigen;
	    return $this;
	}

	/**
	* Get idProvinciaOrigen
	*
	* @return null|Integer
	*/
	public function getIdProvinciaOrigen()
	{
		return $this->idProvinciaOrigen;
	}

	/**
	* Set provinciaOrigen
	*
	*Nombre de la provincia origen de la tabla g_catalogos.localizacion(Destino) que va a dar sus CUV
	*
	* @parámetro String $provinciaOrigen
	* @return ProvinciaOrigen
	*/
	public function setProvinciaOrigen($provinciaOrigen)
	{
	  $this->provinciaOrigen = (String) $provinciaOrigen;
	    return $this;
	}

	/**
	* Get provinciaOrigen
	*
	* @return null|String
	*/
	public function getProvinciaOrigen()
	{
		return $this->provinciaOrigen;
	}

	/**
	* Set idProvinciaDestino
	*
	*Llave forÃ¡nea (redundante) de la tabla g_catalogos.localizacion(Destino) que va a recibir los cuvs
	*
	* @parámetro Integer $idProvinciaDestino
	* @return IdProvinciaDestino
	*/
	public function setIdProvinciaDestino($idProvinciaDestino)
	{
	  $this->idProvinciaDestino = (Integer) $idProvinciaDestino;
	    return $this;
	}

	/**
	* Get idProvinciaDestino
	*
	* @return null|Integer
	*/
	public function getIdProvinciaDestino()
	{
		return $this->idProvinciaDestino;
	}

	/**
	* Set provinciaDestino
	*
	*Nombre de la provincia destino de la tabla g_catalogos.localizacion(Destino) que va a recibir sus CUV
	*
	* @parámetro String $provinciaDestino
	* @return ProvinciaDestino
	*/
	public function setProvinciaDestino($provinciaDestino)
	{
	  $this->provinciaDestino = (String) $provinciaDestino;
	    return $this;
	}

	/**
	* Get provinciaDestino
	*
	* @return null|String
	*/
	public function getProvinciaDestino()
	{
		return $this->provinciaDestino;
	}

	/**
	* Set tecnicoProvincia
	*
	*TÃ©cnico encargado de enviar la solicitud
	*
	* @parámetro String $tecnicoProvincia
	* @return TecnicoProvincia
	*/
	public function setTecnicoProvincia($tecnicoProvincia)
	{
	  $this->tecnicoProvincia = (String) $tecnicoProvincia;
	    return $this;
	}

	/**
	* Get tecnicoProvincia
	*
	* @return null|String
	*/
	public function getTecnicoProvincia()
	{
		return $this->tecnicoProvincia;
	}

	/**
	* Set cantidadSolicitada
	*
	*Cantidad que solicita la provincia destino
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
	* Set tecnicoPlantaCentral
	*
	*TÃ©cnico de planta central encargado de aprobar la solicitud
	*
	* @parámetro String $tecnicoPlantaCentral
	* @return TecnicoPlantaCentral
	*/
	public function setTecnicoPlantaCentral($tecnicoPlantaCentral)
	{
	  $this->tecnicoPlantaCentral = (String) $tecnicoPlantaCentral;
	    return $this;
	}

	/**
	* Get tecnicoPlantaCentral
	*
	* @return null|String
	*/
	public function getTecnicoPlantaCentral()
	{
		return $this->tecnicoPlantaCentral;
	}

	/**
	* Set estadoSolicitud
	*
	*Estado de la las solicitudes pendiente, pendiente envio, pendiente asignacion, aprobado
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
	* Set tecnicoProvinciaIdentificador
	*
	*Identificador del tecnico de provincia
	*
	* @parámetro String $tecnicoProvinciaIdentificador
	* @return TecnicoProvinciaIdentificador
	*/
	public function setTecnicoProvinciaIdentificador($tecnicoProvinciaIdentificador)
	{
	  $this->tecnicoProvinciaIdentificador = (String) $tecnicoProvinciaIdentificador;
	    return $this;
	}

	/**
	* Get tecnicoProvinciaIdentificador
	*
	* @return null|String
	*/
	public function getTecnicoProvinciaIdentificador()
	{
		return $this->tecnicoProvinciaIdentificador;
	}

	/**
	* Set tecnicoPlantaCentralIdentificador
	*
	*identificador del tecnico que aprobo la solicitud
	*
	* @parámetro String $tecnicoPlantaCentralIdentificador
	* @return TecnicoPlantaCentralIdentificador
	*/
	public function setTecnicoPlantaCentralIdentificador($tecnicoPlantaCentralIdentificador)
	{
	  $this->tecnicoPlantaCentralIdentificador = (String) $tecnicoPlantaCentralIdentificador;
	    return $this;
	}

	/**
	* Get tecnicoPlantaCentralIdentificador
	*
	* @return null|String
	*/
	public function getTecnicoPlantaCentralIdentificador()
	{
		return $this->tecnicoPlantaCentralIdentificador;
	}

	/**
	* Set fechaCreacion
	*
	*Fecha de creaciÃ³n del registro
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
	* @return SolicitudRedistribucionCuvModelo
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
