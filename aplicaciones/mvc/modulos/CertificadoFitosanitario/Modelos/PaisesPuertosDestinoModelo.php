<?php
 /**
 * Modelo PaisesPuertosDestinoModelo
 *
 * Este archivo se complementa con el archivo   PaisesPuertosDestinoLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    PaisesPuertosDestinoModelo
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
  namespace Agrodb\CertificadoFitosanitario\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class PaisesPuertosDestinoModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único de la tabla
		*/
		protected $idPaisPuertoDestino;
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
		* Identificador de la tabla localización (país destino)
		*/
		protected $idPaisDestino;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del país de destino
		*/
		protected $nombrePaisDestino;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla puertos (puerto destino)
		*/
		protected $idPuertoDestino;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del puerto de destino
		*/
		protected $nombrePuertoDestino;

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
	* Nombre de la tabla: paises_puertos_destino
	* 
	 */
	Private $tabla="paises_puertos_destino";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_pais_puerto_destino";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_certificado_fitosanitario"."paises_puertos_destino_id_pais_puerto_destino_seq'; 



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
		throw new \Exception('Clase Modelo: PaisesPuertosDestinoModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: PaisesPuertosDestinoModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idPaisPuertoDestino
	*
	*Identificador único de la tabla
	*
	* @parámetro Integer $idPaisPuertoDestino
	* @return IdPaisPuertoDestino
	*/
	public function setIdPaisPuertoDestino($idPaisPuertoDestino)
	{
	  $this->idPaisPuertoDestino = (Integer) $idPaisPuertoDestino;
	    return $this;
	}

	/**
	* Get idPaisPuertoDestino
	*
	* @return null|Integer
	*/
	public function getIdPaisPuertoDestino()
	{
		return $this->idPaisPuertoDestino;
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
	* Set idPaisDestino
	*
	*Identificador de la tabla localización (país destino)
	*
	* @parámetro Integer $idPaisDestino
	* @return IdPaisDestino
	*/
	public function setIdPaisDestino($idPaisDestino)
	{
	  $this->idPaisDestino = (Integer) $idPaisDestino;
	    return $this;
	}

	/**
	* Get idPaisDestino
	*
	* @return null|Integer
	*/
	public function getIdPaisDestino()
	{
		return $this->idPaisDestino;
	}

	/**
	* Set nombrePaisDestino
	*
	*Campo que almacena el nombre del país de destino
	*
	* @parámetro String $nombrePaisDestino
	* @return NombrePaisDestino
	*/
	public function setNombrePaisDestino($nombrePaisDestino)
	{
	  $this->nombrePaisDestino = (String) $nombrePaisDestino;
	    return $this;
	}

	/**
	* Get nombrePaisDestino
	*
	* @return null|String
	*/
	public function getNombrePaisDestino()
	{
		return $this->nombrePaisDestino;
	}

	/**
	* Set idPuertoDestino
	*
	*Identificador de la tabla puertos (puerto destino)
	*
	* @parámetro Integer $idPuertoDestino
	* @return IdPuertoDestino
	*/
	public function setIdPuertoDestino($idPuertoDestino)
	{
	  $this->idPuertoDestino = (Integer) $idPuertoDestino;
	    return $this;
	}

	/**
	* Get idPuertoDestino
	*
	* @return null|Integer
	*/
	public function getIdPuertoDestino()
	{
		return $this->idPuertoDestino;
	}

	/**
	* Set nombrePuertoDestino
	*
	*Campo que almacena el nombre del puerto de destino
	*
	* @parámetro String $nombrePuertoDestino
	* @return NombrePuertoDestino
	*/
	public function setNombrePuertoDestino($nombrePuertoDestino)
	{
	  $this->nombrePuertoDestino = (String) $nombrePuertoDestino;
	    return $this;
	}

	/**
	* Get nombrePuertoDestino
	*
	* @return null|String
	*/
	public function getNombrePuertoDestino()
	{
		return $this->nombrePuertoDestino;
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
	* @return PaisesPuertosDestinoModelo
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
