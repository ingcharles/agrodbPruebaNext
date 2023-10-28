<?php
 /**
 * Modelo DistribucionInicialCuvModelo
 *
 * Este archivo se complementa con el archivo   DistribucionInicialCuvLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-03-21
 * @uses    DistribucionInicialCuvModelo
 * @package AsignacionCuv
 * @subpackage Modelos
 */
  namespace Agrodb\AsignacionCuv\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class DistribucionInicialCuvModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo oculto en el formulario o manejado internamente
		* Llave principal de la tabla
		*/
		protected $idDistribucionInicialCuv;
		/**
		* @var Integer
		* Campo requerido
		* Campo oculto en el formulario o manejado internamente
		* Llave foránea (redundante) de la tabla g_catalogos.localizacion
		*/
		protected $idProvincia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* nombre de la provincia elegida
		*/
		protected $provincia;
		/**
		* @var String
		* Campo requerido
		* Campo oculto en el formulario o manejado internamente
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
		* Código Inicial de los CUV
		*/
		protected $codigoCuvInicio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código Final de los CUV
		*/
		protected $codigoCuvFin;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $cantidad;

		/**
		* @var String
		* Campo requerido
		* Campo oculto en el formulario o manejado internamente
		* Estado de los registros: asignado, pendiente_asignacion, null
		*/
		protected $estado;
		/**
		* @var String
		* Campo requerido
		* Campo oculto en el formulario o manejado internamente
		* Cédula del usuario que realiza la distribución.
		*/
		protected $identificador;
		/**
		* @var Date
		* Campo requerido
		* Campo oculto en el formulario o manejado internamente
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
	* Nombre de la tabla: distribucion_inicial_cuv
	* 
	 */
	Private $tabla="distribucion_inicial_cuv";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_distribucion_inicial_cuv";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_asignacion_cuv"."distribucion_inicial_cuv_id_distribucion_inicial_cuv_seq'; 



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
		throw new \Exception('Clase Modelo: DistribucionInicialCuvModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: DistribucionInicialCuvModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idDistribucionInicialCuv
	*
	*Llave principal de la tabla
	*
	* @parámetro Integer $idDistribucionInicialCuv
	* @return IdDistribucionInicialCuv
	*/
	public function setIdDistribucionInicialCuv($idDistribucionInicialCuv)
	{
	  $this->idDistribucionInicialCuv = (Integer) $idDistribucionInicialCuv;
	    return $this;
	}

	/**
	* Get idDistribucionInicialCuv
	*
	* @return null|Integer
	*/
	public function getIdDistribucionInicialCuv()
	{
		return $this->idDistribucionInicialCuv;
	}

	/**
	* Set idProvincia
	*
	*Llave foránea (redundante) de la tabla g_catalogos.localizacion
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
	*nombre de la provincia elegida
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
	* Set codigoCuvInicio
	*
	*Código Inicial de los CUV
	*
	* @parámetro String $codigoCuvInicio
	* @return CodigoCuvInicio
	*/
	public function setCodigoCuvInicio($codigoCuvInicio)
	{
	  $this->codigoCuvInicio = (String) $codigoCuvInicio;
	    return $this;
	}

	/**
	* Get codigoCuvInicio
	*
	* @return null|String
	*/
	public function getCodigoCuvInicio()
	{
		return $this->codigoCuvInicio;
	}

	/**
	* Set codigoCuvFin
	*
	*Código Final de los CUV
	*
	* @parámetro String $codigoCuvFin
	* @return CodigoCuvFin
	*/
	public function setCodigoCuvFin($codigoCuvFin)
	{
	  $this->codigoCuvFin = (String) $codigoCuvFin;
	    return $this;
	}

	/**
	* Get codigoCuvFin
	*
	* @return null|String
	*/
	public function getCodigoCuvFin()
	{
		return $this->codigoCuvFin;
	}

	/**
	* Set cantidad
	*
	*Cantidad de CUVS que se van a distribuir a provincia
	*
	* @parámetro String $cantidad
	* @return Cantidad
	*/
	public function setCantidad($cantidad)
	{
	  $this->cantidad = (String) $cantidad;
	    return $this;
	}

	/**
	* Get cantidad
	*
	* @return null|String
	*/
	public function getCantidad()
	{
		return $this->cantidad;
	}

	/**
	* Set estado
	*
	*Estado de los registros: asignado, pendiente_asignacion, null
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
	* Set identificador
	*
	*Cédula del usuario que realiza la distribución.
	*
	* @parámetro String $identificador
	* @return Identificador
	*/
	public function setIdentificador($identificador)
	{
	  $this->identificador = (String) $identificador;
	    return $this;
	}

	/**
	* Get identificador
	*
	* @return null|String
	*/
	public function getIdentificador()
	{
		return $this->identificador;
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
	* @return DistribucionInicialCuvModelo
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
