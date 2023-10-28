<?php
/**
 * Modelo TipoProductosModelo
 *
 * Este archivo se complementa con el archivo TipoProductosLogicaNegocio.
 *
 * @author AGROCALIDAD
 * @date    2019-09-10
 * @uses TipoProductosModelo
 * @package RequisitoComercializacion
 * @subpackage Modelos
 */
namespace Agrodb\Catalogos\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class TipoProductosModelo extends ModeloBase{

	/**
	 *
	 * @var Integer Campo requerido
	 *      Campo visible en el formulario
	 *     
	 */
	protected $idTipoProducto;

	/**
	 *
	 * @var String Campo requerido
	 *      Campo visible en el formulario
	 *     
	 */
	protected $nombre;

	/**
	 *
	 * @var Integer Campo requerido
	 *      Campo visible en el formulario
	 *     
	 */
	protected $estado;

	/**
	 *
	 * @var String Campo requerido
	 *      Campo visible en el formulario
	 *     
	 */
	protected $idArea;

	/**
	 *
	 * @var Date Campo requerido
	 *      Campo visible en el formulario
	 *     
	 */
	protected $fechaCreacion;

	/**
	 *
	 * @var Date Campo requerido
	 *      Campo visible en el formulario
	 *     
	 */
	protected $fechaModificacion;

	/**
	 *
	 * @var String Campo requerido
	 *      Campo visible en el formulario
	 *     
	 */
	protected $codificacionTipoProducto;

	/**
	 *
	 * @var String Campo requerido
	 *      Campo visible en el formulario
	 *     
	 */
	protected $codificacionHub;

	/**
	 * Campos del formulario
	 *
	 * @var array
	 */
	private $campos = Array();

	/**
	 * Nombre del esquema
	 */
	private $esquema = "g_catalogos";

	/**
	 * Nombre de la tabla: tipo_productos
	 */
	private $tabla = "tipo_productos";

	/**
	 * Clave primaria
	 */
	private $clavePrimaria = "id_tipo_producto";

	/**
	 * Secuencia
	 */
	private $secuencial = 'g_catalogos"."tipo_productos_id_tipo_producto_seq';

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
			throw new \Exception('Clase Modelo: TipoProductosModelo. Propiedad especificada invalida: set' . $name);
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
			throw new \Exception('Clase Modelo: TipoProductosModelo. Propiedad especificada invalida: get' . $name);
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
	 * Get g_catalogos
	 *
	 * @return null
	 */
	public function getEsquema(){
		return $this->esquema;
	}

	/**
	 * Set idTipoProducto
	 *
	 *
	 *
	 * @parámetro Integer $idTipoProducto
	 * @return IdTipoProducto
	 */
	public function setIdTipoProducto($idTipoProducto){
		$this->idTipoProducto = (integer) $idTipoProducto;
		return $this;
	}

	/**
	 * Get idTipoProducto
	 *
	 * @return null|Integer
	 */
	public function getIdTipoProducto(){
		return $this->idTipoProducto;
	}

	/**
	 * Set nombre
	 *
	 *
	 *
	 * @parámetro String $nombre
	 * @return Nombre
	 */
	public function setNombre($nombre){
		$this->nombre = (string) $nombre;
		return $this;
	}

	/**
	 * Get nombre
	 *
	 * @return null|String
	 */
	public function getNombre(){
		return $this->nombre;
	}

	/**
	 * Set estado
	 *
	 *
	 *
	 * @parámetro Integer $estado
	 * @return Estado
	 */
	public function setEstado($estado){
		$this->estado = (integer) $estado;
		return $this;
	}

	/**
	 * Get estado
	 *
	 * @return null|Integer
	 */
	public function getEstado(){
		return $this->estado;
	}

	/**
	 * Set idArea
	 *
	 *
	 *
	 * @parámetro String $idArea
	 * @return IdArea
	 */
	public function setIdArea($idArea){
		$this->idArea = (string) $idArea;
		return $this;
	}

	/**
	 * Get idArea
	 *
	 * @return null|String
	 */
	public function getIdArea(){
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
	 * Set fechaModificacion
	 *
	 *
	 *
	 * @parámetro Date $fechaModificacion
	 * @return FechaModificacion
	 */
	public function setFechaModificacion($fechaModificacion){
		$this->fechaModificacion = (string) $fechaModificacion;
		return $this;
	}

	/**
	 * Get fechaModificacion
	 *
	 * @return null|Date
	 */
	public function getFechaModificacion(){
		return $this->fechaModificacion;
	}

	/**
	 * Set codificacionTipoProducto
	 *
	 *
	 *
	 * @parámetro String $codificacionTipoProducto
	 * @return CodificacionTipoProducto
	 */
	public function setCodificacionTipoProducto($codificacionTipoProducto){
		$this->codificacionTipoProducto = (string) $codificacionTipoProducto;
		return $this;
	}

	/**
	 * Get codificacionTipoProducto
	 *
	 * @return null|String
	 */
	public function getCodificacionTipoProducto(){
		return $this->codificacionTipoProducto;
	}

	/**
	 * Set codificacionHub
	 *
	 *
	 *
	 * @parámetro String $codificacionHub
	 * @return CodificacionHub
	 */
	public function setCodificacionHub($codificacionHub){
		$this->codificacionHub = (string) $codificacionHub;
		return $this;
	}

	/**
	 * Get codificacionHub
	 *
	 * @return null|String
	 */
	public function getCodificacionHub(){
		return $this->codificacionHub;
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
	 * @return TipoProductosModelo
	 */
	public function buscar($id){
		return $this->setOptions(parent::buscar($this->clavePrimaria . " = " . $id));
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
		return parent::buscarLista($where, $order);
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
