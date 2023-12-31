<?php
 /**
 * Modelo PaisesPuertosTransitoModelo
 *
 * Este archivo se complementa con el archivo   PaisesPuertosTransitoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    PaisesPuertosTransitoModelo
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
  namespace Agrodb\CertificadoFitosanitario\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class PaisesPuertosTransitoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único de la tabla
		*/
		protected $idPaisPuertoTransito;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla certificado_fitosanitario (llave foránea)
		*/
		protected $idCertificadoFitosanitario;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla localización (país tránsito)
		*/
		protected $idPaisTransito;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del país de tránsito
		*/
		protected $nombrePaisTransito;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla puertos (puerto tránsito)
		*/
		protected $idPuertoTransito;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del puerto de tránsito
		*/
		protected $nombrePuertoTransito;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla medios de transporte
		*/
		protected $idMedioTransporteTransito;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del medio de transporte de tránsito
		*/
		protected $nombreMedioTransporteTransito;

	/**
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_certificado_fitosanitario";

	/**
	* Nombre de la tabla: paises_puertos_transito
	* 
	 */
	Private $tabla="paises_puertos_transito";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_pais_puerto_transito";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_certificado_fitosanitario"."paises_puertos_transito_id_pais_puerto_transito_seq'; 



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
		throw new \Exception('Clase Modelo: PaisesPuertosTransitoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: PaisesPuertosTransitoModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_certificado_fitosanitario
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idPaisPuertoTransito
	*
	*Identificador único de la tabla
	*
	* @parámetro Integer $idPaisPuertoTransito
	* @return IdPaisPuertoTransito
	*/
	public function setIdPaisPuertoTransito($idPaisPuertoTransito)
	{
	  $this->idPaisPuertoTransito = (Integer) $idPaisPuertoTransito;
	    return $this;
	}

	/**
	* Get idPaisPuertoTransito
	*
	* @return null|Integer
	*/
	public function getIdPaisPuertoTransito()
	{
		return $this->idPaisPuertoTransito;
	}

	/**
	* Set idCertificadoFitosanitario
	*
	*Identificador de la tabla certificado_fitosanitario (llave foránea)
	*
	* @parámetro Integer $idCertificadoFitosanitario
	* @return IdCertificadoFitosanitario
	*/
	public function setIdCertificadoFitosanitario($idCertificadoFitosanitario)
	{
	  $this->idCertificadoFitosanitario = (Integer) $idCertificadoFitosanitario;
	    return $this;
	}

	/**
	* Get idCertificadoFitosanitario
	*
	* @return null|Integer
	*/
	public function getIdCertificadoFitosanitario()
	{
		return $this->idCertificadoFitosanitario;
	}

	/**
	* Set idPaisTransito
	*
	*Identificador de la tabla localización (país tránsito)
	*
	* @parámetro Integer $idPaisTransito
	* @return IdPaisTransito
	*/
	public function setIdPaisTransito($idPaisTransito)
	{
	  $this->idPaisTransito = (Integer) $idPaisTransito;
	    return $this;
	}

	/**
	* Get idPaisTransito
	*
	* @return null|Integer
	*/
	public function getIdPaisTransito()
	{
		return $this->idPaisTransito;
	}

	/**
	* Set nombrePaisTransito
	*
	*Campo que almacena el nombre del país de tránsito
	*
	* @parámetro String $nombrePaisTransito
	* @return NombrePaisTransito
	*/
	public function setNombrePaisTransito($nombrePaisTransito)
	{
	  $this->nombrePaisTransito = (String) $nombrePaisTransito;
	    return $this;
	}

	/**
	* Get nombrePaisTransito
	*
	* @return null|String
	*/
	public function getNombrePaisTransito()
	{
		return $this->nombrePaisTransito;
	}

	/**
	* Set idPuertoTransito
	*
	*Identificador de la tabla puertos (puerto tránsito)
	*
	* @parámetro Integer $idPuertoTransito
	* @return IdPuertoTransito
	*/
	public function setIdPuertoTransito($idPuertoTransito)
	{
	  $this->idPuertoTransito = (Integer) $idPuertoTransito;
	    return $this;
	}

	/**
	* Get idPuertoTransito
	*
	* @return null|Integer
	*/
	public function getIdPuertoTransito()
	{
		return $this->idPuertoTransito;
	}

	/**
	* Set nombrePuertoTransito
	*
	*Campo que almacena el nombre del puerto de tránsito
	*
	* @parámetro String $nombrePuertoTransito
	* @return NombrePuertoTransito
	*/
	public function setNombrePuertoTransito($nombrePuertoTransito)
	{
	  $this->nombrePuertoTransito = (String) $nombrePuertoTransito;
	    return $this;
	}

	/**
	* Get nombrePuertoTransito
	*
	* @return null|String
	*/
	public function getNombrePuertoTransito()
	{
		return $this->nombrePuertoTransito;
	}

	/**
	* Set idMedioTransporteTransito
	*
	*Identificador de la tabla medios de transporte
	*
	* @parámetro Integer $idMedioTransporteTransito
	* @return IdMedioTransporteTransito
	*/
	public function setIdMedioTransporteTransito($idMedioTransporteTransito)
	{
	  $this->idMedioTransporteTransito = (Integer) $idMedioTransporteTransito;
	    return $this;
	}

	/**
	* Get idMedioTransporteTransito
	*
	* @return null|Integer
	*/
	public function getIdMedioTransporteTransito()
	{
		return $this->idMedioTransporteTransito;
	}

	/**
	* Set nombreMedioTransporteTransito
	*
	*Campo que almacena el nombre del medio de transporte de tránsito
	*
	* @parámetro String $nombreMedioTransporteTransito
	* @return NombreMedioTransporteTransito
	*/
	public function setNombreMedioTransporteTransito($nombreMedioTransporteTransito)
	{
	  $this->nombreMedioTransporteTransito = (String) $nombreMedioTransporteTransito;
	    return $this;
	}

	/**
	* Get nombreMedioTransporteTransito
	*
	* @return null|String
	*/
	public function getNombreMedioTransporteTransito()
	{
		return $this->nombreMedioTransporteTransito;
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
	* @return PaisesPuertosTransitoModelo
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
