<?php
 /**
 * Modelo AditivoToxicologicoModelo
 *
 * Este archivo se complementa con el archivo   AditivoToxicologicoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    AditivoToxicologicoModelo
 * @package Catalogos
 * @subpackage Modelos
 */
  namespace Agrodb\Catalogos\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class AditivoToxicologicoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único del registro
		*/
		protected $idAditivoToxicologico;
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
		* Identificador del creador del registro
		*/
		protected $identificador;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código del área que crea el aditivo
		*/
		protected $area;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre común del aditivo toxicológico
		*/
		protected $nombreComun;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Nombre químico del aditivo toxicológico
		*/
		protected $nombreQuimico;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* CAS del aditivo toxicológico
		*/
		protected $cas;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Fórmula química del aditivo toxicológico
		*/
		protected $formulaQuimica;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Grupo químico del aditivo toxicológico
		*/
		protected $grupoQuimico;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Estado del registro
		*/
		protected $estado;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_catalogos";

	/**
	* Nombre de la tabla: aditivo_toxicologico
	* 
	 */
	Private $tabla="aditivo_toxicologico";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_aditivo_toxicologico";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_catalogos"."AditivoToxicologico_id_aditivo_toxicologico_seq'; 



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
		throw new \Exception('Clase Modelo: AditivoToxicologicoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: AditivoToxicologicoModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_catalogos
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idAditivoToxicologico
	*
	*Identificador único del registro
	*
	* @parámetro Integer $idAditivoToxicologico
	* @return IdAditivoToxicologico
	*/
	public function setIdAditivoToxicologico($idAditivoToxicologico)
	{
	  $this->idAditivoToxicologico = (Integer) $idAditivoToxicologico;
	    return $this;
	}

	/**
	* Get idAditivoToxicologico
	*
	* @return null|Integer
	*/
	public function getIdAditivoToxicologico()
	{
		return $this->idAditivoToxicologico;
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
	* Set identificador
	*
	*Identificador del creador del registro
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
	* Set area
	*
	*Código del área que crea el aditivo
	*
	* @parámetro String $area
	* @return Area
	*/
	public function setArea($area)
	{
	  $this->area = (String) $area;
	    return $this;
	}

	/**
	* Get area
	*
	* @return null|String
	*/
	public function getArea()
	{
		return $this->area;
	}

	/**
	* Set nombreComun
	*
	*Nombre común del aditivo toxicológico
	*
	* @parámetro String $nombreComun
	* @return NombreComun
	*/
	public function setNombreComun($nombreComun)
	{
	  $this->nombreComun = (String) $nombreComun;
	    return $this;
	}

	/**
	* Get nombreComun
	*
	* @return null|String
	*/
	public function getNombreComun()
	{
		return $this->nombreComun;
	}

	/**
	* Set nombreQuimico
	*
	*Nombre químico del aditivo toxicológico
	*
	* @parámetro String $nombreQuimico
	* @return NombreQuimico
	*/
	public function setNombreQuimico($nombreQuimico)
	{
	  $this->nombreQuimico = (String) $nombreQuimico;
	    return $this;
	}

	/**
	* Get nombreQuimico
	*
	* @return null|String
	*/
	public function getNombreQuimico()
	{
		return $this->nombreQuimico;
	}

	/**
	* Set cas
	*
	*CAS del aditivo toxicológico
	*
	* @parámetro String $cas
	* @return Cas
	*/
	public function setCas($cas)
	{
	  $this->cas = (String) $cas;
	    return $this;
	}

	/**
	* Get cas
	*
	* @return null|String
	*/
	public function getCas()
	{
		return $this->cas;
	}

	/**
	* Set formulaQuimica
	*
	*Fórmula química del aditivo toxicológico
	*
	* @parámetro String $formulaQuimica
	* @return FormulaQuimica
	*/
	public function setFormulaQuimica($formulaQuimica)
	{
	  $this->formulaQuimica = (String) $formulaQuimica;
	    return $this;
	}

	/**
	* Get formulaQuimica
	*
	* @return null|String
	*/
	public function getFormulaQuimica()
	{
		return $this->formulaQuimica;
	}

	/**
	* Set grupoQuimico
	*
	*Grupo químico del aditivo toxicológico
	*
	* @parámetro String $grupoQuimico
	* @return GrupoQuimico
	*/
	public function setGrupoQuimico($grupoQuimico)
	{
	  $this->grupoQuimico = (String) $grupoQuimico;
	    return $this;
	}

	/**
	* Get grupoQuimico
	*
	* @return null|String
	*/
	public function getGrupoQuimico()
	{
		return $this->grupoQuimico;
	}

	/**
	* Set estado
	*
	*Estado del registro
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
	* @return AditivoToxicologicoModelo
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
