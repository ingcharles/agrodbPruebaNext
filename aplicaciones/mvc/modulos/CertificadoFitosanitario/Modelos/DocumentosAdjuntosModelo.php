<?php
 /**
 * Modelo DocumentosAdjuntosModelo
 *
 * Este archivo se complementa con el archivo   DocumentosAdjuntosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    DocumentosAdjuntosModelo
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
  namespace Agrodb\CertificadoFitosanitario\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class DocumentosAdjuntosModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idDocumentoAdjunto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $idCertificadoFitosanitario;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $tipoAdjunto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $rutaAdjunto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $rutaEnlaceAdjunto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $estadoAdjunto;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* 
		*/
		protected $fechaCreacionAdjunto;

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
	* Nombre de la tabla: documentos_adjuntos
	* 
	 */
	Private $tabla="documentos_adjuntos";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_documento_adjunto";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_certificado_fitosanitario"."documentos_adjuntos_id_documento_adjunto_seq'; 



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
		throw new \Exception('Clase Modelo: DocumentosAdjuntosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: DocumentosAdjuntosModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idDocumentoAdjunto
	*
	*
	*
	* @parámetro Integer $idDocumentoAdjunto
	* @return IdDocumentoAdjunto
	*/
	public function setIdDocumentoAdjunto($idDocumentoAdjunto)
	{
	  $this->idDocumentoAdjunto = (Integer) $idDocumentoAdjunto;
	    return $this;
	}

	/**
	* Get idDocumentoAdjunto
	*
	* @return null|Integer
	*/
	public function getIdDocumentoAdjunto()
	{
		return $this->idDocumentoAdjunto;
	}

	/**
	* Set idCertificadoFitosanitario
	*
	*
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
	* Set tipoAdjunto
	*
	*
	*
	* @parámetro String $tipoAdjunto
	* @return TipoAdjunto
	*/
	public function setTipoAdjunto($tipoAdjunto)
	{
	  $this->tipoAdjunto = (String) $tipoAdjunto;
	    return $this;
	}

	/**
	* Get tipoAdjunto
	*
	* @return null|String
	*/
	public function getTipoAdjunto()
	{
		return $this->tipoAdjunto;
	}

	/**
	* Set rutaAdjunto
	*
	*
	*
	* @parámetro String $rutaAdjunto
	* @return RutaAdjunto
	*/
	public function setRutaAdjunto($rutaAdjunto)
	{
	  $this->rutaAdjunto = (String) $rutaAdjunto;
	    return $this;
	}

	/**
	* Get rutaAdjunto
	*
	* @return null|String
	*/
	public function getRutaAdjunto()
	{
		return $this->rutaAdjunto;
	}

	/**
	* Set rutaEnlaceAdjunto
	*
	*
	*
	* @parámetro String $rutaEnlaceAdjunto
	* @return RutaEnlaceAdjunto
	*/
	public function setRutaEnlaceAdjunto($rutaEnlaceAdjunto)
	{
	  $this->rutaEnlaceAdjunto = (String) $rutaEnlaceAdjunto;
	    return $this;
	}

	/**
	* Get rutaEnlaceAdjunto
	*
	* @return null|String
	*/
	public function getRutaEnlaceAdjunto()
	{
		return $this->rutaEnlaceAdjunto;
	}

	/**
	* Set estadoAdjunto
	*
	*
	*
	* @parámetro String $estadoAdjunto
	* @return EstadoAdjunto
	*/
	public function setEstadoAdjunto($estadoAdjunto)
	{
	  $this->estadoAdjunto = (String) $estadoAdjunto;
	    return $this;
	}

	/**
	* Get estadoAdjunto
	*
	* @return null|String
	*/
	public function getEstadoAdjunto()
	{
		return $this->estadoAdjunto;
	}

	/**
	* Set fechaCreacionAdjunto
	*
	*
	*
	* @parámetro Date $fechaCreacionAdjunto
	* @return FechaCreacionAdjunto
	*/
	public function setFechaCreacionAdjunto($fechaCreacionAdjunto)
	{
	  $this->fechaCreacionAdjunto = (String) $fechaCreacionAdjunto;
	    return $this;
	}

	/**
	* Get fechaCreacionAdjunto
	*
	* @return null|Date
	*/
	public function getFechaCreacionAdjunto()
	{
		return $this->fechaCreacionAdjunto;
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
	* @return DocumentosAdjuntosModelo
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
