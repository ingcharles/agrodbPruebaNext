<?php
 /**
 * Modelo ActividadesManejoIntegradoModelo
 *
 * Este archivo se complementa con el archivo   ActividadesManejoIntegradoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-05-25
 * @uses    ActividadesManejoIntegradoModelo
 * @package Actividad Manejo Integrado
 * @subpackage Modelos
 */
namespace Agrodb\FormulariosInspeccion\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
  class ActividadesManejoIntegradoModelo extends ModeloBase 
  {
  
		  /**
		  * @var Integer
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $id;
		  /**
		  * @var Integer
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $idTablet;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * Código provincia
		  */
		  protected $codigoProvincia;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * Provincia
		  */
		  protected $provincia;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * Código cantón
		  */
		  protected $codigoCanton;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * Cantón
		  */
		  protected $canton;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * Código parroquia
		  */
		  protected $codigoParroquia;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * Parroquia
		  */
		  protected $parroquia;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * X
		  */
		  protected $coordenadaX;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * Y
		  */
		  protected $coordenadaY;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * Z
		  */
		  protected $coordenadaZ;
		  /**
		  * @var Date
		  * Campo requerido
		  * Campo visible en el formulario
		  * Fecha en la hora que se registra la actividad en campo
		  */
		  protected $fechaRegistroActividad;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $usuarioId;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $usuario;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $tabletId;
		  /**
		  * @var String
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $tabletVersionBase;
		  /**
		  * @var Date
		  * Campo requerido
		  * Campo visible en el formulario
		  * Fecha de registro en el Guia
		  */
		  protected $fechaIngresoGuia;
		  /**
		  * @var Integer
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $semanaActual;
		  /**
		  * @var Integer
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $idAccionMip;
		  /**
		  * @var Decimal
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $mtdInicial;
		  /**
		  * @var Integer
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $idPlagaObjetivo;
		  /**
		  * @var Integer
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $idEscenario;
		  /**
		  * @var Integer
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $idEspecieHortofruticola;
		  /**
		  * @var Decimal
		  * Campo requerido
		  * Campo visible en el formulario
		  * Registro del area en la cual se elvanta la actividad
		  */
		  protected $superficie;
		  /**
		  * @var Decimal
		  * Campo requerido
		  * Campo visible en el formulario
		  * 
		  */
		  protected $mtdFinal;
  
	  /**
	  * Campos del formulario 
	  * @var array 
	   */
	  Private $campos = Array();
  
	  /**
	  * Nombre del esquema 
	  * 
	   */
	  Private $esquema ="f_inspeccion";
  
	  /**
	  * Nombre de la tabla: actividades_manejo_integrado
	  * 
	   */
	  Private $tabla="actividades_manejo_integrado";
  
	  /**
	  *Clave primaria
  */
		   private $clavePrimaria = "id";
  
  
  
	  /**
	  *Secuencia
  */
		   private $secuencial = 'f_inspeccion"."ActividadesManejoIntegrado_id_seq'; 
  
  
  
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
		  throw new \Exception('Clase Modelo: ActividadesManejoIntegradoModelo. Propiedad especificada invalida: set'.$name);
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
		throw new \Exception('Clase Modelo: ActividadesManejoIntegradoModelo. Propiedad especificada invalida: get'.$name);
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
	  * Get f_inspeccion
	  *
	  * @return null|
	  */
	  public function getEsquema()
	  {
		   return $this->esquema;
	  }
  
	  /**
	  * Set id
	  *
	  *
	  *
	  * @parámetro Integer $id
	  * @return Id
	  */
	  public function setId($id)
	  {
		$this->id = (Integer) $id;
		  return $this;
	  }
  
	  /**
	  * Get id
	  *
	  * @return null|Integer
	  */
	  public function getId()
	  {
		  return $this->id;
	  }
  
	  /**
	  * Set idTablet
	  *
	  *
	  *
	  * @parámetro Integer $idTablet
	  * @return IdTablet
	  */
	  public function setIdTablet($idTablet)
	  {
		$this->idTablet = (Integer) $idTablet;
		  return $this;
	  }
  
	  /**
	  * Get idTablet
	  *
	  * @return null|Integer
	  */
	  public function getIdTablet()
	  {
		  return $this->idTablet;
	  }
  
	  /**
	  * Set codigoProvincia
	  *
	  *Código provincia
	  *
	  * @parámetro String $codigoProvincia
	  * @return CodigoProvincia
	  */
	  public function setCodigoProvincia($codigoProvincia)
	  {
		$this->codigoProvincia = (String) $codigoProvincia;
		  return $this;
	  }
  
	  /**
	  * Get codigoProvincia
	  *
	  * @return null|String
	  */
	  public function getCodigoProvincia()
	  {
		  return $this->codigoProvincia;
	  }
  
	  /**
	  * Set provincia
	  *
	  *Provincia
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
	  * Set codigoCanton
	  *
	  *Código cantón
	  *
	  * @parámetro String $codigoCanton
	  * @return CodigoCanton
	  */
	  public function setCodigoCanton($codigoCanton)
	  {
		$this->codigoCanton = (String) $codigoCanton;
		  return $this;
	  }
  
	  /**
	  * Get codigoCanton
	  *
	  * @return null|String
	  */
	  public function getCodigoCanton()
	  {
		  return $this->codigoCanton;
	  }
  
	  /**
	  * Set canton
	  *
	  *Cantón
	  *
	  * @parámetro String $canton
	  * @return Canton
	  */
	  public function setCanton($canton)
	  {
		$this->canton = (String) $canton;
		  return $this;
	  }
  
	  /**
	  * Get canton
	  *
	  * @return null|String
	  */
	  public function getCanton()
	  {
		  return $this->canton;
	  }
  
	  /**
	  * Set codigoParroquia
	  *
	  *Código parroquia
	  *
	  * @parámetro String $codigoParroquia
	  * @return CodigoParroquia
	  */
	  public function setCodigoParroquia($codigoParroquia)
	  {
		$this->codigoParroquia = (String) $codigoParroquia;
		  return $this;
	  }
  
	  /**
	  * Get codigoParroquia
	  *
	  * @return null|String
	  */
	  public function getCodigoParroquia()
	  {
		  return $this->codigoParroquia;
	  }
  
	  /**
	  * Set parroquia
	  *
	  *Parroquia
	  *
	  * @parámetro String $parroquia
	  * @return Parroquia
	  */
	  public function setParroquia($parroquia)
	  {
		$this->parroquia = (String) $parroquia;
		  return $this;
	  }
  
	  /**
	  * Get parroquia
	  *
	  * @return null|String
	  */
	  public function getParroquia()
	  {
		  return $this->parroquia;
	  }
  
	  /**
	  * Set coordenadaX
	  *
	  *X
	  *
	  * @parámetro String $coordenadaX
	  * @return CoordenadaX
	  */
	  public function setCoordenadaX($coordenadaX)
	  {
		$this->coordenadaX = (String) $coordenadaX;
		  return $this;
	  }
  
	  /**
	  * Get coordenadaX
	  *
	  * @return null|String
	  */
	  public function getCoordenadaX()
	  {
		  return $this->coordenadaX;
	  }
  
	  /**
	  * Set coordenadaY
	  *
	  *Y
	  *
	  * @parámetro String $coordenadaY
	  * @return CoordenadaY
	  */
	  public function setCoordenadaY($coordenadaY)
	  {
		$this->coordenadaY = (String) $coordenadaY;
		  return $this;
	  }
  
	  /**
	  * Get coordenadaY
	  *
	  * @return null|String
	  */
	  public function getCoordenadaY()
	  {
		  return $this->coordenadaY;
	  }
  
	  /**
	  * Set coordenadaZ
	  *
	  *Z
	  *
	  * @parámetro String $coordenadaZ
	  * @return CoordenadaZ
	  */
	  public function setCoordenadaZ($coordenadaZ)
	  {
		$this->coordenadaZ = (String) $coordenadaZ;
		  return $this;
	  }
  
	  /**
	  * Get coordenadaZ
	  *
	  * @return null|String
	  */
	  public function getCoordenadaZ()
	  {
		  return $this->coordenadaZ;
	  }
  
	  /**
	  * Set fechaRegistroActividad
	  *
	  *Fecha en la hora que se registra la actividad en campo
	  *
	  * @parámetro Date $fechaRegistroActividad
	  * @return FechaRegistroActividad
	  */
	  public function setFechaRegistroActividad($fechaRegistroActividad)
	  {
		$this->fechaRegistroActividad = (String) $fechaRegistroActividad;
		  return $this;
	  }
  
	  /**
	  * Get fechaRegistroActividad
	  *
	  * @return null|Date
	  */
	  public function getFechaRegistroActividad()
	  {
		  return $this->fechaRegistroActividad;
	  }
  
	  /**
	  * Set usuarioId
	  *
	  *
	  *
	  * @parámetro String $usuarioId
	  * @return UsuarioId
	  */
	  public function setUsuarioId($usuarioId)
	  {
		$this->usuarioId = (String) $usuarioId;
		  return $this;
	  }
  
	  /**
	  * Get usuarioId
	  *
	  * @return null|String
	  */
	  public function getUsuarioId()
	  {
		  return $this->usuarioId;
	  }
  
	  /**
	  * Set usuario
	  *
	  *
	  *
	  * @parámetro String $usuario
	  * @return Usuario
	  */
	  public function setUsuario($usuario)
	  {
		$this->usuario = (String) $usuario;
		  return $this;
	  }
  
	  /**
	  * Get usuario
	  *
	  * @return null|String
	  */
	  public function getUsuario()
	  {
		  return $this->usuario;
	  }
  
	  /**
	  * Set tabletId
	  *
	  *
	  *
	  * @parámetro String $tabletId
	  * @return TabletId
	  */
	  public function setTabletId($tabletId)
	  {
		$this->tabletId = (String) $tabletId;
		  return $this;
	  }
  
	  /**
	  * Get tabletId
	  *
	  * @return null|String
	  */
	  public function getTabletId()
	  {
		  return $this->tabletId;
	  }
  
	  /**
	  * Set tabletVersionBase
	  *
	  *
	  *
	  * @parámetro String $tabletVersionBase
	  * @return TabletVersionBase
	  */
	  public function setTabletVersionBase($tabletVersionBase)
	  {
		$this->tabletVersionBase = (String) $tabletVersionBase;
		  return $this;
	  }
  
	  /**
	  * Get tabletVersionBase
	  *
	  * @return null|String
	  */
	  public function getTabletVersionBase()
	  {
		  return $this->tabletVersionBase;
	  }
  
	  /**
	  * Set fechaIngresoGuia
	  *
	  *Fecha de registro en el Guia
	  *
	  * @parámetro Date $fechaIngresoGuia
	  * @return FechaIngresoGuia
	  */
	  public function setFechaIngresoGuia($fechaIngresoGuia)
	  {
		$this->fechaIngresoGuia = (String) $fechaIngresoGuia;
		  return $this;
	  }
  
	  /**
	  * Get fechaIngresoGuia
	  *
	  * @return null|Date
	  */
	  public function getFechaIngresoGuia()
	  {
		  return $this->fechaIngresoGuia;
	  }
  
	  /**
	  * Set semanaActual
	  *
	  *
	  *
	  * @parámetro Integer $semanaActual
	  * @return SemanaActual
	  */
	  public function setSemanaActual($semanaActual)
	  {
		$this->semanaActual = (Integer) $semanaActual;
		  return $this;
	  }
  
	  /**
	  * Get semanaActual
	  *
	  * @return null|Integer
	  */
	  public function getSemanaActual()
	  {
		  return $this->semanaActual;
	  }
  
	  /**
	  * Set idAccionMip
	  *
	  *
	  *
	  * @parámetro Integer $idAccionMip
	  * @return IdAccionMip
	  */
	  public function setIdAccionMip($idAccionMip)
	  {
		$this->idAccionMip = (Integer) $idAccionMip;
		  return $this;
	  }
  
	  /**
	  * Get idAccionMip
	  *
	  * @return null|Integer
	  */
	  public function getIdAccionMip()
	  {
		  return $this->idAccionMip;
	  }
  
	  /**
	  * Set mtdInicial
	  *
	  *
	  *
	  * @parámetro Decimal $mtdInicial
	  * @return MtdInicial
	  */
	  public function setMtdInicial($mtdInicial)
	  {
		$this->mtdInicial = (Double) $mtdInicial;
		  return $this;
	  }
  
	  /**
	  * Get mtdInicial
	  *
	  * @return null|Decimal
	  */
	  public function getMtdInicial()
	  {
		  return $this->mtdInicial;
	  }
  
	  /**
	  * Set idPlagaObjetivo
	  *
	  *
	  *
	  * @parámetro Integer $idPlagaObjetivo
	  * @return IdPlagaObjetivo
	  */
	  public function setIdPlagaObjetivo($idPlagaObjetivo)
	  {
		$this->idPlagaObjetivo = (Integer) $idPlagaObjetivo;
		  return $this;
	  }
  
	  /**
	  * Get idPlagaObjetivo
	  *
	  * @return null|Integer
	  */
	  public function getIdPlagaObjetivo()
	  {
		  return $this->idPlagaObjetivo;
	  }
  
	  /**
	  * Set idEscenario
	  *
	  *
	  *
	  * @parámetro Integer $idEscenario
	  * @return IdEscenario
	  */
	  public function setIdEscenario($idEscenario)
	  {
		$this->idEscenario = (Integer) $idEscenario;
		  return $this;
	  }
  
	  /**
	  * Get idEscenario
	  *
	  * @return null|Integer
	  */
	  public function getIdEscenario()
	  {
		  return $this->idEscenario;
	  }
  
	  /**
	  * Set idEspecieHortofruticola
	  *
	  *
	  *
	  * @parámetro Integer $idEspecieHortofruticola
	  * @return IdEspecieHortofruticola
	  */
	  public function setIdEspecieHortofruticola($idEspecieHortofruticola)
	  {
		$this->idEspecieHortofruticola = (Integer) $idEspecieHortofruticola;
		  return $this;
	  }
  
	  /**
	  * Get idEspecieHortofruticola
	  *
	  * @return null|Integer
	  */
	  public function getIdEspecieHortofruticola()
	  {
		  return $this->idEspecieHortofruticola;
	  }
  
	  /**
	  * Set superficie
	  *
	  *Registro del area en la cual se elvanta la actividad
	  *
	  * @parámetro Decimal $superficie
	  * @return Superficie
	  */
	  public function setSuperficie($superficie)
	  {
		$this->superficie = (Double) $superficie;
		  return $this;
	  }
  
	  /**
	  * Get superficie
	  *
	  * @return null|Decimal
	  */
	  public function getSuperficie()
	  {
		  return $this->superficie;
	  }
  
	  /**
	  * Set mtdFinal
	  *
	  *
	  *
	  * @parámetro Decimal $mtdFinal
	  * @return MtdFinal
	  */
	  public function setMtdFinal($mtdFinal)
	  {
		$this->mtdFinal = (Double) $mtdFinal;
		  return $this;
	  }
  
	  /**
	  * Get mtdFinal
	  *
	  * @return null|Decimal
	  */
	  public function getMtdFinal()
	  {
		  return $this->mtdFinal;
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
	  * @return ActividadesManejoIntegradoModelo
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
  