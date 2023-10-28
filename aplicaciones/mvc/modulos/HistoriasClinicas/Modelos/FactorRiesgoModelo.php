<?php
 /**
 * Modelo FactorRiesgoModelo
 *
 * Este archivo se complementa con el archivo   FactorRiesgoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2023-06-02
 * @uses    FactorRiesgoModelo
 * @package HistoriasClinicas
 * @subpackage Modelos
 */
  namespace Agrodb\HistoriasClinicas\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class FactorRiesgoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idFactorRiesgo;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idHistoriaClinica;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $cargoFactor;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $actividadesFactor;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $medidasFactor;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaCreacion;

		/**
		 *
		 * @var Integer Campo requerido
		 *      Campo visible en el formulario
		 *      Llave foránea de la tabla procedimiento_medico
		 */
		protected $idProcedimientoMedico;

		/**
		 *
		 * @var Integer Campo requerido
		 *      Campo visible en el formulario
		 *      Llave foránea de la tabla tipo_procedimiento_medico
		 */
		protected $idTipoProcedimientoMedico;

		protected $otrosFactor;


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
	* Nombre de la tabla: factor_riesgo
	* 
	 */
	Private $tabla="factor_riesgo";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_factor_riesgo";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_historias_clinicas"."factor_riesgo_id_factor_riesgo_seq'; 



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
		throw new \Exception('Clase Modelo: FactorRiesgoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: FactorRiesgoModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idFactorRiesgo
	*
	*
	*
	* @parámetro Integer $idFactorRiesgo
	* @return IdFactorRiesgo
	*/
	public function setIdFactorRiesgo($idFactorRiesgo)
	{
	  $this->idFactorRiesgo = (Integer) $idFactorRiesgo;
	    return $this;
	}

	/**
	* Get idFactorRiesgo
	*
	* @return null|Integer
	*/
	public function getIdFactorRiesgo()
	{
		return $this->idFactorRiesgo;
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
	* Set cargoFactor
	*
	*
	*
	* @parámetro String $cargoFactor
	* @return CargoFactor
	*/
	public function setCargoFactor($cargoFactor)
	{
	  $this->cargoFactor = (String) $cargoFactor;
	    return $this;
	}

	/**
	* Get cargoFactor
	*
	* @return null|String
	*/
	public function getCargoFactor()
	{
		return $this->cargoFactor;
	}

	/**
	* Set actividadesFactor
	*
	*
	*
	* @parámetro String $actividadesFactor
	* @return ActividadesFactor
	*/
	public function setActividadesFactor($actividadesFactor)
	{
	  $this->actividadesFactor = (String) $actividadesFactor;
	    return $this;
	}

	/**
	* Get actividadesFactor
	*
	* @return null|String
	*/
	public function getActividadesFactor()
	{
		return $this->actividadesFactor;
	}

	/**
	* Set medidasFactor
	*
	*
	*
	* @parámetro String $medidasFactor
	* @return MedidasFactor
	*/
	public function setMedidasFactor($medidasFactor)
	{
	  $this->medidasFactor = (String) $medidasFactor;
	    return $this;
	}

	/**
	* Get medidasFactor
	*
	* @return null|String
	*/
	public function getMedidasFactor()
	{
		return $this->medidasFactor;
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
	 * Set idProcedimientoMedico
	 *
	 * Llave foránea de la tabla procedimiento_medico
	 *
	 * @parámetro Integer $idProcedimientoMedico
	 * @return IdProcedimientoMedico
	 */
	public function setIdProcedimientoMedico($idProcedimientoMedico){
		$this->idProcedimientoMedico = (integer) $idProcedimientoMedico;
		return $this;
	}

	/**
	 * Get idProcedimientoMedico
	 *
	 * @return null|Integer
	 */
	public function getIdProcedimientoMedico(){
		return $this->idProcedimientoMedico;
	}

	/**
	 * Set idTipoProcedimientoMedico
	 *
	 * Llave foránea de la tabla tipo_procedimiento_medico
	 *
	 * @parámetro Integer $idTipoProcedimientoMedico
	 * @return IdTipoProcedimientoMedico
	 */
	public function setIdTipoProcedimientoMedico($idTipoProcedimientoMedico){
		$this->idTipoProcedimientoMedico = (integer) $idTipoProcedimientoMedico;
		return $this;
	}

	/**
	 * Get idTipoProcedimientoMedico
	 *
	 * @return null|Integer
	 */
	public function getIdTipoProcedimientoMedico(){
		return $this->idTipoProcedimientoMedico;
	}


	public function setOtrosFactor($otrosFactor)
	{
	  $this->otrosFactor = (String) $otrosFactor;
	    return $this;
	}

	public function getOtrosFactor()
	{
		return $this->otrosFactor;
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
	* @return FactorRiesgoModelo
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
