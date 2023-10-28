<?php
 /**
 * Modelo CodigosComplementariosSuplementariosPlaguicidasBioModelo
 *
 * Este archivo se complementa con el archivo   CodigosComplementariosSuplementariosPlaguicidasBioLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-12-22
 * @uses    CodigosComplementariosSuplementariosPlaguicidasBioModelo
 * @package RegistroProductoRia
 * @subpackage Modelos
 */
  namespace Agrodb\RegistroProductoRia\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class CodigosComplementariosSuplementariosPlaguicidasBioModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único del registro
		*/
		protected $idCodigoComplementarioSuplementario;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador del registro de la partida arancelaria
		*/
		protected $idPartidaArancelaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Código complememtario de la partida arancelaria
		*/
		protected $codigoComplementario;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Cósigo suplementario de la partida arancelaria
		*/
		protected $codigoSuplementario;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_registro_productos";

	/**
	* Nombre de la tabla: codigos_complementarios_suplementarios_plaguicidas_bio
	* 
	 */
	Private $tabla="codigos_complementarios_suplementarios_plaguicidas_bio";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_codigo_complementario_suplementario";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_registro_productos"."codigos_complementarios_suple_id_codigo_complementario_sup_seq1'; 



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
		throw new \Exception('Clase Modelo: CodigosComplementariosSuplementariosPlaguicidasBioModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: CodigosComplementariosSuplementariosPlaguicidasBioModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_registro_productos
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idCodigoComplementarioSuplementario
	*
	*Identificador único del registro
	*
	* @parámetro Integer $idCodigoComplementarioSuplementario
	* @return IdCodigoComplementarioSuplementario
	*/
	public function setIdCodigoComplementarioSuplementario($idCodigoComplementarioSuplementario)
	{
	  $this->idCodigoComplementarioSuplementario = (Integer) $idCodigoComplementarioSuplementario;
	    return $this;
	}

	/**
	* Get idCodigoComplementarioSuplementario
	*
	* @return null|Integer
	*/
	public function getIdCodigoComplementarioSuplementario()
	{
		return $this->idCodigoComplementarioSuplementario;
	}

	/**
	* Set idPartidaArancelaria
	*
	*Identificador del registro de la partida arancelaria
	*
	* @parámetro Integer $idPartidaArancelaria
	* @return IdPartidaArancelaria
	*/
	public function setIdPartidaArancelaria($idPartidaArancelaria)
	{
	  $this->idPartidaArancelaria = (Integer) $idPartidaArancelaria;
	    return $this;
	}

	/**
	* Get idPartidaArancelaria
	*
	* @return null|Integer
	*/
	public function getIdPartidaArancelaria()
	{
		return $this->idPartidaArancelaria;
	}

	/**
	* Set codigoComplementario
	*
	*Código complememtario de la partida arancelaria
	*
	* @parámetro String $codigoComplementario
	* @return CodigoComplementario
	*/
	public function setCodigoComplementario($codigoComplementario)
	{
	  $this->codigoComplementario = (String) $codigoComplementario;
	    return $this;
	}

	/**
	* Get codigoComplementario
	*
	* @return null|String
	*/
	public function getCodigoComplementario()
	{
		return $this->codigoComplementario;
	}

	/**
	* Set codigoSuplementario
	*
	*Cósigo suplementario de la partida arancelaria
	*
	* @parámetro String $codigoSuplementario
	* @return CodigoSuplementario
	*/
	public function setCodigoSuplementario($codigoSuplementario)
	{
	  $this->codigoSuplementario = (String) $codigoSuplementario;
	    return $this;
	}

	/**
	* Get codigoSuplementario
	*
	* @return null|String
	*/
	public function getCodigoSuplementario()
	{
		return $this->codigoSuplementario;
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
	* @return CodigosComplementariosSuplementariosPlaguicidasBioModelo
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
