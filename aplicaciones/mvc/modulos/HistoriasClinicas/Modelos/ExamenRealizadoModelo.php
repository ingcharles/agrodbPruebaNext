<?php
/**
 * Modelo AccidentesLaboralesModelo
 *
 * Este archivo se complementa con el archivo AccidentesLaboralesLogicaNegocio.
 *
 * @author AGROCALIDAD
 * @date    2020-03-16
 * @uses AccidentesLaboralesModelo
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
namespace Agrodb\HistoriasClinicas\Modelos;

use Agrodb\Core\ModeloBase;
use Agrodb\Core\ValidarDatos;

class ExamenRealizadoModelo extends ModeloBase{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idExamenRealizado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idHistoriaClinica;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $tiempoAnios;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $resultado;


		protected $tipoExamen;
	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_historias_clinicas";

	/**
	* Nombre de la tabla: examen_realizado
	* 
	 */
	Private $tabla="examen_realizado";

	/**
	*Clave primaria
*/
	private $clavePrimaria = "id_examen_realizado";



	/**
	*Secuencia
*/
private $secuencial = 'g_historias_clinicas"."examen_realizado_id_examen_realizado_seq'; 



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
		throw new \Exception('Clase Modelo: ExamenRealizadoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: ExamenRealizadoModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_historias_clinicas
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idExamenRealizado
	*
	*
	*
	* @parámetro Integer $idExamenRealizado
	* @return IdExamenRealizado
	*/
	public function setIdExamenRealizado($idExamenRealizado)
	{
	  $this->idExamenRealizado = (Integer) $idExamenRealizado;
	    return $this;
	}

	/**
	* Get idExamenRealizado
	*
	* @return null|Integer
	*/
	public function getIdExamenRealizado()
	{
		return $this->idExamenRealizado;
	}

	/**
	* Set idHistoriaClinica
	*
	*
	*
	* @parámetro Integer $idHistoriaClinica
	* @return IdHistoriaClinica
	*/
	public function setIdHistoriaClinica($idHistoriaClinica)
	{
	  $this->idHistoriaClinica = (Integer) $idHistoriaClinica;
	    return $this;
	}

	/**
	* Get idHistoriaClinica
	*
	* @return null|Integer
	*/
	public function getIdHistoriaClinica()
	{
		return $this->idHistoriaClinica;
	}

	/**
	* Set tiempoAnios
	*
	*
	*
	* @parámetro Integer $tiempoAnios
	* @return TiempoAnios
	*/
	public function setTiempoAnios($tiempoAnios)
	{
	  $this->tiempoAnios = (Integer) $tiempoAnios;
	    return $this;
	}

	/**
	* Get tiempoAnios
	*
	* @return null|Integer
	*/
	public function getTiempoAnios()
	{
		return $this->tiempoAnios;
	}

	/**
	* Set resultado
	*
	*
	*
	* @parámetro String $resultado
	* @return Resultado
	*/
	public function setResultado($resultado)
	{
	  $this->resultado = (String) $resultado;
	    return $this;
	}

	/**
	* Get resultado
	*
	* @return null|String
	*/
	public function getResultado()
	{
		return $this->resultado;
	}



	public function setTipoExamen($tipoExamen)
	{
	  $this->tipoExamen = (String) $tipoExamen;
	    return $this;
	}


	public function getTipoExamen()
	{
		return $this->tipoExamen;
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
	* @return ExamenRealizadoModelo
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
