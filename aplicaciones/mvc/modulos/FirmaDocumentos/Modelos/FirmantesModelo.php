<?php
/**
 * Modelo FirmantesModelo
 *
 * Este archivo se complementa con el archivo FirmantesLogicaNegocio.
 *
 * @author AGROCALIDAD
 * @date    2022-01-14
 * @uses FirmantesModelo
 * @package FirmaDocumentos
 * @subpackage Modelos
 */
namespace Agrodb\FirmaDocumentos\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class FirmantesModelo extends ModeloBase{

	/**
	 *
	 * @var String Campo requerido
	 *      Campo visible en el formulario
	 *      Identificador unico de la tabla
	 */
	protected $identificador;

	/**
	 *
	 * @var String Campo requerido
	 *      Campo visible en el formulario
	 *      Ruta completa del archivo de firma
	 */
	protected $rutaArchivo;

	/**
	 *
	 * @var String Campo requerido
	 *      Campo visible en el formulario
	 *      Calve del archivo de firma
	 */
	protected $clave;

	/**
	 *
	 * @var Date Campo requerido
	 *      Campo visible en el formulario
	 *      Fecha de caducidad del certificado
	 */
	protected $fechaCaducidadCertificado;

	/**
	 *
	 * @var Date Campo requerido
	 *      Campo visible en el formulario
	 *      Fecha de creación del registro de firma
	 */
	protected $fechaCreacion;

	/**
	 *
	 * @var String Campo requerido
	 *      Campo visible en el formulario
	 *      Estado del registro de firma
	 */
	protected $estado;

	/**
	 * Campos del formulario
	 *
	 * @var array
	 */
	private $campos = Array();

	/**
	 * Nombre del esquema
	 */
	private $esquema = "g_firma_documentos";

	/**
	 * Nombre de la tabla: firmantes
	 */
	private $tabla = "firmantes";

	/**
	 * Clave primaria
	 */
	private $clavePrimaria = "identificador";

	/**
	 * Secuencia
	 */
	private $secuencial = 'g_firma_documentos"."firmantes_identificador_seq';

	/**
	 * Constructor
	 * $datos - Puede ser los campos del formualario que deben considir con los campos de la tabla
	 *
	 * @parámetro  array|null $datos
	 * @retorna void
	 */
	public function __construct(array $datos = null){
		if (is_array($datos)){
			$this->setOptions($datos);
		}
		$features = new \Zend\Db\TableGateway\Feature\SequenceFeature($this->clavePrimaria, $this->secuencial);
		parent::__construct($this->esquema, $this->tabla, $features);
	}

	/**
	 * Permitir el acceso a la propiedad
	 *
	 * @parámetro  string $name
	 * @parámetro  mixed $value
	 * @retorna void
	 */
	public function __set($name, $value){
		$method = 'set' . $name;
		if (! method_exists($this, $method)){
			throw new \Exception('Clase Modelo: FirmantesModelo. Propiedad especificada invalida: set' . $name);
		}
		$this->$method($value);
	}

	/**
	 * Permitir el acceso a la propiedad
	 *
	 * @parámetro  string $name
	 * @retorna mixed
	 */
	public function __get($name){
		$method = 'get' . $name;
		if (! method_exists($this, $method)){
			throw new \Exception('Clase Modelo: FirmantesModelo. Propiedad especificada invalida: get' . $name);
		}
		return $this->$method();
	}

	/**
	 * Llena el modelo con datos
	 *
	 * @parámetro  array $datos
	 * @retorna Modelo
	 */
	public function setOptions(array $datos){
		$methods = get_class_methods($this);
		foreach ($datos as $key => $value){
			$key_original = $key;
			if (strpos($key, '_') > 0){
				$aux = preg_replace_callback(" /[-_]([a-z]+)/ ", function ($string){
					return ucfirst($string[1]);
				}, ucwords($key));
				$key = $aux;
			}
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)){
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
	public function getPrepararDatos(){
		$claseArray = get_object_vars($this);
		foreach ($this->campos as $key => $value){
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
	public function setEsquema($esquema){
		$this->esquema = $esquema;
		return $this;
	}

	/**
	 * Get g_firma_documentos
	 *
	 * @return null
	 */
	public function getEsquema(){
		return $this->esquema;
	}

	/**
	 * Set identificador
	 *
	 * Identificador unico de la tabla
	 *
	 * @parámetro String $identificador
	 * @return Identificador
	 */
	public function setIdentificador($identificador){
		$this->identificador = (string) $identificador;
		return $this;
	}

	/**
	 * Get identificador
	 *
	 * @return null|String
	 */
	public function getIdentificador(){
		return $this->identificador;
	}

	/**
	 * Set rutaArchivo
	 *
	 * Ruta completa del archivo de firma
	 *
	 * @parámetro String $rutaArchivo
	 * @return RutaArchivo
	 */
	public function setRutaArchivo($rutaArchivo){
		$this->rutaArchivo = (string) $rutaArchivo;
		return $this;
	}

	/**
	 * Get rutaArchivo
	 *
	 * @return null|String
	 */
	public function getRutaArchivo(){
		return $this->rutaArchivo;
	}

	/**
	 * Set clave
	 *
	 * Calve del archivo de firma
	 *
	 * @parámetro String $clave
	 * @return Clave
	 */
	public function setClave($clave){
		$this->clave = (string) $clave;
		return $this;
	}

	/**
	 * Get clave
	 *
	 * @return null|String
	 */
	public function getClave(){
		return $this->clave;
	}

	/**
	 * Set fechaCaducidadCertificado
	 *
	 * Fecha de caducidad del certificado
	 *
	 * @parámetro Date $fechaCaducidadCertificado
	 * @return FechaCaducidadCertificado
	 */
	public function setFechaCaducidadCertificado($fechaCaducidadCertificado){
		$this->fechaCaducidadCertificado = (string) $fechaCaducidadCertificado;
		return $this;
	}

	/**
	 * Get fechaCaducidadCertificado
	 *
	 * @return null|Date
	 */
	public function getFechaCaducidadCertificado(){
		return $this->fechaCaducidadCertificado;
	}

	/**
	 * Set fechaCreacion
	 *
	 * Fecha de creación del registro de firma
	 *
	 * @parámetro Date $fechaCreacion
	 * @return FechaCreacion
	 */
	public function setFechaCreacion($fechaCreacion){
		$this->fechaCreacion = (string) $fechaCreacion;
		return $this;
	}

	/**
	 * Get fechaCreacion
	 *
	 * @return null|Date
	 */
	public function getFechaCreacion(){
		return $this->fechaCreacion;
	}

	/**
	 * Set estado
	 *
	 * Estado del registro de firma
	 *
	 * @parámetro String $estado
	 * @return Estado
	 */
	public function setEstado($estado){
		$this->estado = (string) $estado;
		return $this;
	}

	/**
	 * Get estado
	 *
	 * @return null|String
	 */
	public function getEstado(){
		return $this->estado;
	}

	/**
	 * Guarda el registro actual
	 *
	 * @param array $datos
	 * @return int
	 */
	public function guardar(Array $datos){
		return parent::guardar($datos);
	}

	/**
	 * Actualiza un registro actual
	 *
	 * @param array $datos
	 * @param int $id
	 * @return int
	 */
	public function actualizar(Array $datos, $id){
		return parent::actualizar($datos, $this->clavePrimaria . " = " . $id);
	}

	/**
	 * Borra el registro actual
	 *
	 * @param
	 *        	string Where|array $where
	 * @return int
	 */
	public function borrar($id){
		return parent::borrar($this->clavePrimaria . " = " . $id);
	}

	/**
	 *
	 * Buscar un registro de con la clave primaria
	 *
	 * @param int $id
	 * @return FirmantesModelo
	 */
	public function buscar($id){
		return $this->setOptions(parent::buscar($this->clavePrimaria . " = " ."'$id'"));
		return $this;
	}

	/**
	 * Busca todos los registros
	 *
	 * @return array|ResultSet
	 */
	public function buscarTodo(){
		return parent::buscarTodo();
	}

	/**
	 * Busca una lista de acuerdo a los parámetros <params> enviados.
	 *
	 * @return array|ResultSet
	 */
	public function buscarLista($where = null, $order = null, $count = null, $offset = null){
		return parent::buscarLista($where);
	}

	/**
	 * Ejecuta una consulta(SQL) personalizada .
	 *
	 * @return array|ResultSet
	 */
	public function ejecutarConsulta($consulta){
		return parent::ejecutarConsulta($consulta);
	}
}
