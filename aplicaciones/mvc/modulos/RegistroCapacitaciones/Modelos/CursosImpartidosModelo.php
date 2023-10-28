<?php
 /**
 * Modelo CursosImpartidosModelo
 *
 * Este archivo se complementa con el archivo   CursosImpartidosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-08-31
 * @uses    CursosImpartidosModelo
 * @package RegistroCapacitaciones
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroCapacitaciones\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class CursosImpartidosModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla cursos impartidos
		*/
		protected $idCursoImpartido;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* identificador de la tabla Capacitadores
		*/
		protected $identificador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que va almacenar el nombre de la parroquia
		*/
		protected $sitio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que va a almacenar la conclusion del curso registrado
		*/
		protected $conclusion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que va a almacenar el total de las personas que asistieron a la capacitacion
		*/
		protected $totalAsistentes;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el link de los archivos adjuntados en las capacitaciones registradas
		*/
		protected $archivoConstanciaAsistentes;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el link de los archivos adjuntados en las capacitaciones registradas
		*/
		protected $archivoEvidencia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de las capacitaciones registradas
		*/
		protected $nombreCapacitacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el tipo de cacpacitacion registrada
		*/
		protected $tipo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla cursos capacitaciones
		*/
		protected $idCursoCapacitacion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* identificador de la tabla localizacion
		*/
		protected $idProvincia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que va almacenar el nombre de la provincia
		*/
		protected $nombreProvincia;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* identificador de la tabla localizacion
		*/
		protected $idCanton;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que va almacenar el nombre del canton
		*/
		protected $nombreCanton;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* identificador de la tabla localizacion
		*/
		protected $idParroquia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $nombreParroquia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla area
		*/
		protected $idCoordinacion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* identificador de la tabla area
		*/
		protected $idDireccion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* identificador de la tabla a rea
		*/
		protected $idArea;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaCreacion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaEjecucion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* identificador de l atabla area
		*/
		protected $idOficina;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacenara el nombre de la oficina de la tabla area
		*/
		protected $nombreOficina;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_administracion_capacitaciones";

	/**
	* Nombre de la tabla: cursos_impartidos
	* 
	 */
	Private $tabla="cursos_impartidos";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_curso_impartido";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_administracion_capacitaciones"."cursos_impartidos_id_curso_impartido_seq'; 



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
		throw new \Exception('Clase Modelo: CursosImpartidosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: CursosImpartidosModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_administracion_capacitaciones
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idCursoImpartido
	*
	*Identificador de la tabla cursos impartidos
	*
	* @parámetro Integer $idCursoImpartido
	* @return IdCursoImpartido
	*/
	public function setIdCursoImpartido($idCursoImpartido)
	{
	  $this->idCursoImpartido = (Integer) $idCursoImpartido;
	    return $this;
	}

	/**
	* Get idCursoImpartido
	*
	* @return null|Integer
	*/
	public function getIdCursoImpartido()
	{
		return $this->idCursoImpartido;
	}

	/**
	* Set identificador
	*
	*identificador de la tabla Capacitadores
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
	* Set sitio
	*
	*Campo que va almacenar el nombre de la parroquia
	*
	* @parámetro String $sitio
	* @return Sitio
	*/
	public function setSitio($sitio)
	{
	  $this->sitio = (String) $sitio;
	    return $this;
	}

	/**
	* Get sitio
	*
	* @return null|String
	*/
	public function getSitio()
	{
		return $this->sitio;
	}

	/**
	* Set conclusion
	*
	*Campo que va a almacenar la conclusion del curso registrado
	*
	* @parámetro String $conclusion
	* @return Conclusion
	*/
	public function setConclusion($conclusion)
	{
	  $this->conclusion = (String) $conclusion;
	    return $this;
	}

	/**
	* Get conclusion
	*
	* @return null|String
	*/
	public function getConclusion()
	{
		return $this->conclusion;
	}

	/**
	* Set totalAsistentes
	*
	*Campo que va a almacenar el total de las personas que asistieron a la capacitacion
	*
	* @parámetro Integer $totalAsistentes
	* @return TotalAsistentes
	*/
	public function setTotalAsistentes($totalAsistentes)
	{
	  $this->totalAsistentes = (Integer) $totalAsistentes;
	    return $this;
	}

	/**
	* Get totalAsistentes
	*
	* @return null|Integer
	*/
	public function getTotalAsistentes()
	{
		return $this->totalAsistentes;
	}

	/**
	* Set archivoConstanciaAsistentes
	*
	*Campo que almacena el link de los archivos adjuntados en las capacitaciones registradas
	*
	* @parámetro String $archivoConstanciaAsistentes
	* @return ArchivoConstanciaAsistentes
	*/
	public function setArchivoConstanciaAsistentes($archivoConstanciaAsistentes)
	{
	  $this->archivoConstanciaAsistentes = (String) $archivoConstanciaAsistentes;
	    return $this;
	}

	/**
	* Get archivoConstanciaAsistentes
	*
	* @return null|String
	*/
	public function getArchivoConstanciaAsistentes()
	{
		return $this->archivoConstanciaAsistentes;
	}

	/**
	* Set archivoEvidencia
	*
	*Campo que almacena el link de los archivos adjuntados en las capacitaciones registradas
	*
	* @parámetro String $archivoEvidencia
	* @return ArchivoEvidencia
	*/
	public function setArchivoEvidencia($archivoEvidencia)
	{
	  $this->archivoEvidencia = (String) $archivoEvidencia;
	    return $this;
	}

	/**
	* Get archivoEvidencia
	*
	* @return null|String
	*/
	public function getArchivoEvidencia()
	{
		return $this->archivoEvidencia;
	}

	/**
	* Set nombreCapacitacion
	*
	*Campo que almacena el nombre de las capacitaciones registradas
	*
	* @parámetro String $nombreCapacitacion
	* @return NombreCapacitacion
	*/
	public function setNombreCapacitacion($nombreCapacitacion)
	{
	  $this->nombreCapacitacion = (String) $nombreCapacitacion;
	    return $this;
	}

	/**
	* Get nombreCapacitacion
	*
	* @return null|String
	*/
	public function getNombreCapacitacion()
	{
		return $this->nombreCapacitacion;
	}

	/**
	* Set tipo
	*
	*Campo que almacena el tipo de cacpacitacion registrada
	*
	* @parámetro String $tipo
	* @return Tipo
	*/
	public function setTipo($tipo)
	{
	  $this->tipo = (String) $tipo;
	    return $this;
	}

	/**
	* Get tipo
	*
	* @return null|String
	*/
	public function getTipo()
	{
		return $this->tipo;
	}

	/**
	* Set idCursoCapacitacion
	*
	*Identificador de la tabla cursos capacitaciones
	*
	* @parámetro Integer $idCursoCapacitacion
	* @return IdCursoCapacitacion
	*/
	public function setIdCursoCapacitacion($idCursoCapacitacion)
	{
	  $this->idCursoCapacitacion = (Integer) $idCursoCapacitacion;
	    return $this;
	}

	/**
	* Get idCursoCapacitacion
	*
	* @return null|Integer
	*/
	public function getIdCursoCapacitacion()
	{
		return $this->idCursoCapacitacion;
	}

	/**
	* Set idProvincia
	*
	*identificador de la tabla localizacion
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
	* Set nombreProvincia
	*
	*Campo que va almacenar el nombre de la provincia
	*
	* @parámetro String $nombreProvincia
	* @return NombreProvincia
	*/
	public function setNombreProvincia($nombreProvincia)
	{
	  $this->nombreProvincia = (String) $nombreProvincia;
	    return $this;
	}

	/**
	* Get nombreProvincia
	*
	* @return null|String
	*/
	public function getNombreProvincia()
	{
		return $this->nombreProvincia;
	}

	/**
	* Set idCanton
	*
	*identificador de la tabla localizacion
	*
	* @parámetro Integer $idCanton
	* @return IdCanton
	*/
	public function setIdCanton($idCanton)
	{
	  $this->idCanton = (Integer) $idCanton;
	    return $this;
	}

	/**
	* Get idCanton
	*
	* @return null|Integer
	*/
	public function getIdCanton()
	{
		return $this->idCanton;
	}

	/**
	* Set nombreCanton
	*
	*Campo que va almacenar el nombre del canton
	*
	* @parámetro String $nombreCanton
	* @return NombreCanton
	*/
	public function setNombreCanton($nombreCanton)
	{
	  $this->nombreCanton = (String) $nombreCanton;
	    return $this;
	}

	/**
	* Get nombreCanton
	*
	* @return null|String
	*/
	public function getNombreCanton()
	{
		return $this->nombreCanton;
	}

	/**
	* Set idParroquia
	*
	*identificador de la tabla localizacion
	*
	* @parámetro Integer $idParroquia
	* @return IdParroquia
	*/
	public function setIdParroquia($idParroquia)
	{
	  $this->idParroquia = (Integer) $idParroquia;
	    return $this;
	}

	/**
	* Get idParroquia
	*
	* @return null|Integer
	*/
	public function getIdParroquia()
	{
		return $this->idParroquia;
	}

	/**
	* Set nombreParroquia
	*
	*
	*
	* @parámetro String $nombreParroquia
	* @return NombreParroquia
	*/
	public function setNombreParroquia($nombreParroquia)
	{
	  $this->nombreParroquia = (String) $nombreParroquia;
	    return $this;
	}

	/**
	* Get nombreParroquia
	*
	* @return null|String
	*/
	public function getNombreParroquia()
	{
		return $this->nombreParroquia;
	}

	/**
	* Set idCoordinacion
	*
	*Identificador de la tabla area
	*
	* @parámetro String $idCoordinacion
	* @return IdCoordinacion
	*/
	public function setIdCoordinacion($idCoordinacion)
	{
	  $this->idCoordinacion = (String) $idCoordinacion;
	    return $this;
	}

	/**
	* Get idCoordinacion
	*
	* @return null|String
	*/
	public function getIdCoordinacion()
	{
		return $this->idCoordinacion;
	}

	/**
	* Set idDireccion
	*
	*identificador de la tabla area
	*
	* @parámetro String $idDireccion
	* @return IdDireccion
	*/
	public function setIdDireccion($idDireccion)
	{
	  $this->idDireccion = (String) $idDireccion;
	    return $this;
	}

	/**
	* Get idDireccion
	*
	* @return null|String
	*/
	public function getIdDireccion()
	{
		return $this->idDireccion;
	}

	/**
	* Set idArea
	*
	*identificador de la tabla a rea
	*
	* @parámetro String $idArea
	* @return IdArea
	*/
	public function setIdArea($idArea)
	{
	  $this->idArea = (String) $idArea;
	    return $this;
	}

	/**
	* Get idArea
	*
	* @return null|String
	*/
	public function getIdArea()
	{
		return $this->idArea;
	}

	/**
	* Set fechaCreacion
	*
	*
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
	* Set fechaEjecucion
	*
	*
	*
	* @parámetro Date $fechaEjecucion
	* @return FechaEjecucion
	*/
	public function setFechaEjecucion($fechaEjecucion)
	{
	  $this->fechaEjecucion = (String) $fechaEjecucion;
	    return $this;
	}

	/**
	* Get fechaEjecucion
	*
	* @return null|Date
	*/
	public function getFechaEjecucion()
	{
		return $this->fechaEjecucion;
	}

	/**
	* Set idOficina
	*
	*identificador de l atabla area
	*
	* @parámetro Integer $idOficina
	* @return IdOficina
	*/
	public function setIdOficina($idOficina)
	{
	  $this->idOficina = (Integer) $idOficina;
	    return $this;
	}

	/**
	* Get idOficina
	*
	* @return null|Integer
	*/
	public function getIdOficina()
	{
		return $this->idOficina;
	}

	/**
	* Set nombreOficina
	*
	*Campo que almacenara el nombre de la oficina de la tabla area
	*
	* @parámetro String $nombreOficina
	* @return NombreOficina
	*/
	public function setNombreOficina($nombreOficina)
	{
	  $this->nombreOficina = (String) $nombreOficina;
	    return $this;
	}

	/**
	* Get nombreOficina
	*
	* @return null|String
	*/
	public function getNombreOficina()
	{
		return $this->nombreOficina;
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
	* @return CursosImpartidosModelo
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
