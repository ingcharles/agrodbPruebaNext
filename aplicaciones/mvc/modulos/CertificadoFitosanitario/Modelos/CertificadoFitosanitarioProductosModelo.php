<?php
 /**
 * Modelo CertificadoFitosanitarioProductosModelo
 *
 * Este archivo se complementa con el archivo   CertificadoFitosanitarioProductosLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    CertificadoFitosanitarioProductosModelo
 * @package CertificadoFitosanitario
 * @subpackage Modelos
 */
  namespace Agrodb\CertificadoFitosanitario\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class CertificadoFitosanitarioProductosModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único de la tabla
		*/
		protected $idCertificadoFitosanitarioProducto;
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
		* Campo que almacena el identificador nico de la tabla total_inspeccion_fitosanitaria
		*/
		protected $idTotalInspeccionFitosanitaria;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla subtipo_producto
		*/
		protected $idSubtipoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del subtipo de producto
		*/
		protected $nombreSubtipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla producto
		*/
		protected $idProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del producto
		*/
		protected $nombreProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad comercial
		*/
		protected $cantidadComercial;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla unidad_medida
		*/
		protected $idUnidadCantidadComercial;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo de la cantidad comercial
		*/
		protected $codigoUnidadCantidadComercial;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la unidad de medida Ejm:KILOGRAMO
		*/
		protected $nombreUnidadCantidadComercial;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el peso neto
		*/
		protected $pesoNeto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla unidad_medida
		*/
		protected $idUnidadPesoNeto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo del peso neto
		*/
		protected $codigoUnidadPesoNeto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la unidad de medida Ejm:KILOGRAMO
		*/
		protected $nombreUnidadPesoNeto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el peso bruto
		*/
		protected $pesoBruto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador de la tabla unidad_medida
		*/
		protected $idUnidadPesoBruto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo del peso bruto
		*/
		protected $codigoUnidadPesoBruto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la unidad de medida Ejm:KILOGRAMO
		*/
		protected $nombreUnidadPesoBruto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único de la tabla tipos_tratamiento
		*/
		protected $idTipoTratamiento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo del tipo de tratamiento
		*/
		protected $codigoTipoTratamiento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del tipo de tratamiento
		*/
		protected $nombreTipoTratamiento;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador único de la tabla tratamientos
		*/
		protected $idTratamiento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo de tratamiento
		*/
		protected $codigoTratamiento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del tratamiento
		*/
		protected $nombreTratamiento;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.unidades_medidas.
		*/
		protected $idDuracion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo de la duracion
		*/
		protected $codigoUnidadDuracion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la duracion
		*/
		protected $nombreDuracion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el valor de duracion
		*/
		protected $duracion;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.unidades_medidas.
		*/
		protected $idTemperatura;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo de la temperatura
		*/
		protected $codigoUnidadTemperatura;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la temperatura
		*/
		protected $nombreTemperatura;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el valor de temperatura
		*/
		protected $temperatura;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha de tratamiento
		*/
		protected $fechaTratamiento;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el producto quimico
		*/
		protected $productoQuimico;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.unidades_medidas
		*/
		protected $idConcentracion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la fecha en la que se inspecciono el producto
		*/
		protected $fechaInspeccion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo de la concentracion
		*/
		protected $codigoUnidadConcentracion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la concentracion
		*/
		protected $nombreConcentracion;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el valor de concentracion
		*/
		protected $concentracion;
		/**
		* @var Date
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la última fecha de revisión del centro de acopio
		*/
		protected $fechaRevision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el el último tipo de revisión del centro de acopio
		*/
		protected $tipoRevision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el último identificador que realiza la revisión del centro de acopio
		*/
		protected $identificadorRevision;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la última observación realizada al centro de acopio
		*/
		protected $observacionRevision;

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
	* Nombre de la tabla: certificado_fitosanitario_productos
	* 
	 */
	Private $tabla="certificado_fitosanitario_productos";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_certificado_fitosanitario_producto";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_certificado_fitosanitario"."certificado_fitosanitario_pro_id_certificado_fitosanitario__seq'; 



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
		throw new \Exception('Clase Modelo: CertificadoFitosanitarioProductosModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: CertificadoFitosanitarioProductosModelo. Propiedad especificada invalida: get'.$name);
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
	* Set idCertificadoFitosanitarioProducto
	*
	*Identificador único de la tabla
	*
	* @parámetro Integer $idCertificadoFitosanitarioProducto
	* @return IdCertificadoFitosanitarioProducto
	*/
	public function setIdCertificadoFitosanitarioProducto($idCertificadoFitosanitarioProducto)
	{
	  $this->idCertificadoFitosanitarioProducto = (Integer) $idCertificadoFitosanitarioProducto;
	    return $this;
	}

	/**
	* Get idCertificadoFitosanitarioProducto
	*
	* @return null|Integer
	*/
	public function getIdCertificadoFitosanitarioProducto()
	{
		return $this->idCertificadoFitosanitarioProducto;
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
	* Set idTotalInspeccionFitosanitaria
	*
	*Campo que almacena el identificador nico de la tabla total_inspeccion_fitosanitaria
	*
	* @parámetro Integer $idTotalInspeccionFitosanitaria
	* @return IdTotalInspeccionFitosanitaria
	*/
	public function setIdTotalInspeccionFitosanitaria($idTotalInspeccionFitosanitaria)
	{
	  $this->idTotalInspeccionFitosanitaria = (Integer) $idTotalInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get idTotalInspeccionFitosanitaria
	*
	* @return null|Integer
	*/
	public function getIdTotalInspeccionFitosanitaria()
	{
		return $this->idTotalInspeccionFitosanitaria;
	}

	/**
	* Set idSubtipoProducto
	*
	*Identificador de la tabla subtipo_producto
	*
	* @parámetro Integer $idSubtipoProducto
	* @return IdSubtipoProducto
	*/
	public function setIdSubtipoProducto($idSubtipoProducto)
	{
	  $this->idSubtipoProducto = (Integer) $idSubtipoProducto;
	    return $this;
	}

	/**
	* Get idSubtipoProducto
	*
	* @return null|Integer
	*/
	public function getIdSubtipoProducto()
	{
		return $this->idSubtipoProducto;
	}

	/**
	* Set nombreSubtipoProducto
	*
	*Campo que almacena el nombre del subtipo de producto
	*
	* @parámetro String $nombreSubtipoProducto
	* @return NombreSubtipoProducto
	*/
	public function setNombreSubtipoProducto($nombreSubtipoProducto)
	{
	  $this->nombreSubtipoProducto = (String) $nombreSubtipoProducto;
	    return $this;
	}

	/**
	* Get nombreSubtipoProducto
	*
	* @return null|String
	*/
	public function getNombreSubtipoProducto()
	{
		return $this->nombreSubtipoProducto;
	}

	/**
	* Set idProducto
	*
	*Identificador de la tabla producto
	*
	* @parámetro Integer $idProducto
	* @return IdProducto
	*/
	public function setIdProducto($idProducto)
	{
	  $this->idProducto = (Integer) $idProducto;
	    return $this;
	}

	/**
	* Get idProducto
	*
	* @return null|Integer
	*/
	public function getIdProducto()
	{
		return $this->idProducto;
	}

	/**
	* Set nombreProducto
	*
	*Campo que almacena el nombre del producto
	*
	* @parámetro String $nombreProducto
	* @return NombreProducto
	*/
	public function setNombreProducto($nombreProducto)
	{
	  $this->nombreProducto = (String) $nombreProducto;
	    return $this;
	}

	/**
	* Get nombreProducto
	*
	* @return null|String
	*/
	public function getNombreProducto()
	{
		return $this->nombreProducto;
	}

	/**
	* Set cantidadComercial
	*
	*Campo que almacena la cantidad comercial
	*
	* @parámetro String $cantidadComercial
	* @return CantidadComercial
	*/
	public function setCantidadComercial($cantidadComercial)
	{
	  $this->cantidadComercial = (String) $cantidadComercial;
	    return $this;
	}

	/**
	* Get cantidadComercial
	*
	* @return null|String
	*/
	public function getCantidadComercial()
	{
		return $this->cantidadComercial;
	}

	/**
	* Set idUnidadCantidadComercial
	*
	*Identificador de la tabla unidad_medida
	*
	* @parámetro Integer $idUnidadCantidadComercial
	* @return IdUnidadCantidadComercial
	*/
	public function setIdUnidadCantidadComercial($idUnidadCantidadComercial)
	{
	  $this->idUnidadCantidadComercial = (Integer) $idUnidadCantidadComercial;
	    return $this;
	}

	/**
	* Get idUnidadCantidadComercial
	*
	* @return null|Integer
	*/
	public function getIdUnidadCantidadComercial()
	{
		return $this->idUnidadCantidadComercial;
	}

	/**
	* Set codigoUnidadCantidadComercial
	*
	*Campo que almacena el codigo de la cantidad comercial
	*
	* @parámetro String $codigoUnidadCantidadComercial
	* @return CodigoUnidadCantidadComercial
	*/
	public function setCodigoUnidadCantidadComercial($codigoUnidadCantidadComercial)
	{
	  $this->codigoUnidadCantidadComercial = (String) $codigoUnidadCantidadComercial;
	    return $this;
	}

	/**
	* Get codigoUnidadCantidadComercial
	*
	* @return null|String
	*/
	public function getCodigoUnidadCantidadComercial()
	{
		return $this->codigoUnidadCantidadComercial;
	}

	/**
	* Set nombreUnidadCantidadComercial
	*
	*Campo que almacena el nombre de la unidad de medida Ejm:KILOGRAMO
	*
	* @parámetro String $nombreUnidadCantidadComercial
	* @return NombreUnidadCantidadComercial
	*/
	public function setNombreUnidadCantidadComercial($nombreUnidadCantidadComercial)
	{
	  $this->nombreUnidadCantidadComercial = (String) $nombreUnidadCantidadComercial;
	    return $this;
	}

	/**
	* Get nombreUnidadCantidadComercial
	*
	* @return null|String
	*/
	public function getNombreUnidadCantidadComercial()
	{
		return $this->nombreUnidadCantidadComercial;
	}

	/**
	* Set pesoNeto
	*
	*Campo que almacena el peso neto
	*
	* @parámetro String $pesoNeto
	* @return PesoNeto
	*/
	public function setPesoNeto($pesoNeto)
	{
	  $this->pesoNeto = (String) $pesoNeto;
	    return $this;
	}

	/**
	* Get pesoNeto
	*
	* @return null|String
	*/
	public function getPesoNeto()
	{
		return $this->pesoNeto;
	}

	/**
	* Set idUnidadPesoNeto
	*
	*Identificador de la tabla unidad_medida
	*
	* @parámetro Integer $idUnidadPesoNeto
	* @return IdUnidadPesoNeto
	*/
	public function setIdUnidadPesoNeto($idUnidadPesoNeto)
	{
	  $this->idUnidadPesoNeto = (Integer) $idUnidadPesoNeto;
	    return $this;
	}

	/**
	* Get idUnidadPesoNeto
	*
	* @return null|Integer
	*/
	public function getIdUnidadPesoNeto()
	{
		return $this->idUnidadPesoNeto;
	}

	/**
	* Set codigoUnidadPesoNeto
	*
	*Campo que almacena el codigo del peso neto
	*
	* @parámetro String $codigoUnidadPesoNeto
	* @return CodigoUnidadPesoNeto
	*/
	public function setCodigoUnidadPesoNeto($codigoUnidadPesoNeto)
	{
	  $this->codigoUnidadPesoNeto = (String) $codigoUnidadPesoNeto;
	    return $this;
	}

	/**
	* Get codigoUnidadPesoNeto
	*
	* @return null|String
	*/
	public function getCodigoUnidadPesoNeto()
	{
		return $this->codigoUnidadPesoNeto;
	}

	/**
	* Set nombreUnidadPesoNeto
	*
	*Campo que almacena el nombre de la unidad de medida Ejm:KILOGRAMO
	*
	* @parámetro String $nombreUnidadPesoNeto
	* @return NombreUnidadPesoNeto
	*/
	public function setNombreUnidadPesoNeto($nombreUnidadPesoNeto)
	{
	  $this->nombreUnidadPesoNeto = (String) $nombreUnidadPesoNeto;
	    return $this;
	}

	/**
	* Get nombreUnidadPesoNeto
	*
	* @return null|String
	*/
	public function getNombreUnidadPesoNeto()
	{
		return $this->nombreUnidadPesoNeto;
	}

	/**
	* Set pesoBruto
	*
	*Campo que almacena el peso bruto
	*
	* @parámetro String $pesoBruto
	* @return PesoBruto
	*/
	public function setPesoBruto($pesoBruto)
	{
	  $this->pesoBruto = (String) $pesoBruto;
	    return $this;
	}

	/**
	* Get pesoBruto
	*
	* @return null|String
	*/
	public function getPesoBruto()
	{
		return $this->pesoBruto;
	}

	/**
	* Set idUnidadPesoBruto
	*
	*Identificador de la tabla unidad_medida
	*
	* @parámetro Integer $idUnidadPesoBruto
	* @return IdUnidadPesoBruto
	*/
	public function setIdUnidadPesoBruto($idUnidadPesoBruto)
	{
	  $this->idUnidadPesoBruto = (Integer) $idUnidadPesoBruto;
	    return $this;
	}

	/**
	* Get idUnidadPesoBruto
	*
	* @return null|Integer
	*/
	public function getIdUnidadPesoBruto()
	{
		return $this->idUnidadPesoBruto;
	}

	/**
	* Set codigoUnidadPesoBruto
	*
	*Campo que almacena el codigo del peso bruto
	*
	* @parámetro String $codigoUnidadPesoBruto
	* @return CodigoUnidadPesoBruto
	*/
	public function setCodigoUnidadPesoBruto($codigoUnidadPesoBruto)
	{
	  $this->codigoUnidadPesoBruto = (String) $codigoUnidadPesoBruto;
	    return $this;
	}

	/**
	* Get codigoUnidadPesoBruto
	*
	* @return null|String
	*/
	public function getCodigoUnidadPesoBruto()
	{
		return $this->codigoUnidadPesoBruto;
	}

	/**
	* Set nombreUnidadPesoBruto
	*
	*Campo que almacena el nombre de la unidad de medida Ejm:KILOGRAMO
	*
	* @parámetro String $nombreUnidadPesoBruto
	* @return NombreUnidadPesoBruto
	*/
	public function setNombreUnidadPesoBruto($nombreUnidadPesoBruto)
	{
	  $this->nombreUnidadPesoBruto = (String) $nombreUnidadPesoBruto;
	    return $this;
	}

	/**
	* Get nombreUnidadPesoBruto
	*
	* @return null|String
	*/
	public function getNombreUnidadPesoBruto()
	{
		return $this->nombreUnidadPesoBruto;
	}

	/**
	* Set idTipoTratamiento
	*
	*Identificador único de la tabla tipos_tratamiento
	*
	* @parámetro Integer $idTipoTratamiento
	* @return IdTipoTratamiento
	*/
	public function setIdTipoTratamiento($idTipoTratamiento)
	{
	  $this->idTipoTratamiento = (Integer) $idTipoTratamiento;
	    return $this;
	}

	/**
	* Get idTipoTratamiento
	*
	* @return null|Integer
	*/
	public function getIdTipoTratamiento()
	{
		return $this->idTipoTratamiento;
	}

	/**
	* Set codigoTipoTratamiento
	*
	*Campo que almacena el codigo del tipo de tratamiento
	*
	* @parámetro String $codigoTipoTratamiento
	* @return CodigoTipoTratamiento
	*/
	public function setCodigoTipoTratamiento($codigoTipoTratamiento)
	{
	  $this->codigoTipoTratamiento = (String) $codigoTipoTratamiento;
	    return $this;
	}

	/**
	* Get codigoTipoTratamiento
	*
	* @return null|String
	*/
	public function getCodigoTipoTratamiento()
	{
		return $this->codigoTipoTratamiento;
	}

	/**
	* Set nombreTipoTratamiento
	*
	*Campo que almacena el nombre del tipo de tratamiento
	*
	* @parámetro String $nombreTipoTratamiento
	* @return NombreTipoTratamiento
	*/
	public function setNombreTipoTratamiento($nombreTipoTratamiento)
	{
	  $this->nombreTipoTratamiento = (String) $nombreTipoTratamiento;
	    return $this;
	}

	/**
	* Get nombreTipoTratamiento
	*
	* @return null|String
	*/
	public function getNombreTipoTratamiento()
	{
		return $this->nombreTipoTratamiento;
	}

	/**
	* Set idTratamiento
	*
	*Identificador único de la tabla tratamientos
	*
	* @parámetro Integer $idTratamiento
	* @return IdTratamiento
	*/
	public function setIdTratamiento($idTratamiento)
	{
	  $this->idTratamiento = (Integer) $idTratamiento;
	    return $this;
	}

	/**
	* Get idTratamiento
	*
	* @return null|Integer
	*/
	public function getIdTratamiento()
	{
		return $this->idTratamiento;
	}

	/**
	* Set codigoTratamiento
	*
	*Campo que almacena el codigo de tratamiento
	*
	* @parámetro String $codigoTratamiento
	* @return CodigoTratamiento
	*/
	public function setCodigoTratamiento($codigoTratamiento)
	{
	  $this->codigoTratamiento = (String) $codigoTratamiento;
	    return $this;
	}

	/**
	* Get codigoTratamiento
	*
	* @return null|String
	*/
	public function getCodigoTratamiento()
	{
		return $this->codigoTratamiento;
	}

	/**
	* Set nombreTratamiento
	*
	*Campo que almacena el nombre del tratamiento
	*
	* @parámetro String $nombreTratamiento
	* @return NombreTratamiento
	*/
	public function setNombreTratamiento($nombreTratamiento)
	{
	  $this->nombreTratamiento = (String) $nombreTratamiento;
	    return $this;
	}

	/**
	* Get nombreTratamiento
	*
	* @return null|String
	*/
	public function getNombreTratamiento()
	{
		return $this->nombreTratamiento;
	}

	/**
	* Set idDuracion
	*
	*Identificador unico de la tabla g_catalogos.unidades_medidas.
	*
	* @parámetro Integer $idDuracion
	* @return IdDuracion
	*/
	public function setIdDuracion($idDuracion)
	{
	  $this->idDuracion = (Integer) $idDuracion;
	    return $this;
	}

	/**
	* Get idDuracion
	*
	* @return null|Integer
	*/
	public function getIdDuracion()
	{
		return $this->idDuracion;
	}

	/**
	* Set codigoUnidadDuracion
	*
	*Campo que almacena el codigo de la duracion
	*
	* @parámetro String $codigoUnidadDuracion
	* @return CodigoUnidadDuracion
	*/
	public function setCodigoUnidadDuracion($codigoUnidadDuracion)
	{
	  $this->codigoUnidadDuracion = (String) $codigoUnidadDuracion;
	    return $this;
	}

	/**
	* Get codigoUnidadDuracion
	*
	* @return null|String
	*/
	public function getCodigoUnidadDuracion()
	{
		return $this->codigoUnidadDuracion;
	}

	/**
	* Set nombreDuracion
	*
	*Campo que almacena el nombre de la duracion
	*
	* @parámetro String $nombreDuracion
	* @return NombreDuracion
	*/
	public function setNombreDuracion($nombreDuracion)
	{
	  $this->nombreDuracion = (String) $nombreDuracion;
	    return $this;
	}

	/**
	* Get nombreDuracion
	*
	* @return null|String
	*/
	public function getNombreDuracion()
	{
		return $this->nombreDuracion;
	}

	/**
	* Set duracion
	*
	*Campo que almacena el valor de duracion
	*
	* @parámetro String $duracion
	* @return Duracion
	*/
	public function setDuracion($duracion)
	{
	  $this->duracion = (String) $duracion;
	    return $this;
	}

	/**
	* Get duracion
	*
	* @return null|String
	*/
	public function getDuracion()
	{
		return $this->duracion;
	}

	/**
	* Set idTemperatura
	*
	*Identificador unico de la tabla g_catalogos.unidades_medidas.
	*
	* @parámetro Integer $idTemperatura
	* @return IdTemperatura
	*/
	public function setIdTemperatura($idTemperatura)
	{
	  $this->idTemperatura = (Integer) $idTemperatura;
	    return $this;
	}

	/**
	* Get idTemperatura
	*
	* @return null|Integer
	*/
	public function getIdTemperatura()
	{
		return $this->idTemperatura;
	}

	/**
	* Set codigoUnidadTemperatura
	*
	*Campo que almacena el codigo de la temperatura
	*
	* @parámetro String $codigoUnidadTemperatura
	* @return CodigoUnidadTemperatura
	*/
	public function setCodigoUnidadTemperatura($codigoUnidadTemperatura)
	{
	  $this->codigoUnidadTemperatura = (String) $codigoUnidadTemperatura;
	    return $this;
	}

	/**
	* Get codigoUnidadTemperatura
	*
	* @return null|String
	*/
	public function getCodigoUnidadTemperatura()
	{
		return $this->codigoUnidadTemperatura;
	}

	/**
	* Set nombreTemperatura
	*
	*Campo que almacena el nombre de la temperatura
	*
	* @parámetro String $nombreTemperatura
	* @return NombreTemperatura
	*/
	public function setNombreTemperatura($nombreTemperatura)
	{
	  $this->nombreTemperatura = (String) $nombreTemperatura;
	    return $this;
	}

	/**
	* Get nombreTemperatura
	*
	* @return null|String
	*/
	public function getNombreTemperatura()
	{
		return $this->nombreTemperatura;
	}

	/**
	* Set temperatura
	*
	*Campo que almacena el valor de temperatura
	*
	* @parámetro String $temperatura
	* @return Temperatura
	*/
	public function setTemperatura($temperatura)
	{
	  $this->temperatura = (String) $temperatura;
	    return $this;
	}

	/**
	* Get temperatura
	*
	* @return null|String
	*/
	public function getTemperatura()
	{
		return $this->temperatura;
	}

	/**
	* Set fechaTratamiento
	*
	*Campo que almacena la fecha de tratamiento
	*
	* @parámetro Date $fechaTratamiento
	* @return FechaTratamiento
	*/
	public function setFechaTratamiento($fechaTratamiento)
	{
	  $this->fechaTratamiento = (String) $fechaTratamiento;
	    return $this;
	}

	/**
	* Get fechaTratamiento
	*
	* @return null|Date
	*/
	public function getFechaTratamiento()
	{
		return $this->fechaTratamiento;
	}

	/**
	* Set productoQuimico
	*
	*Campo que almacena el producto quimico
	*
	* @parámetro String $productoQuimico
	* @return ProductoQuimico
	*/
	public function setProductoQuimico($productoQuimico)
	{
	  $this->productoQuimico = (String) $productoQuimico;
	    return $this;
	}

	/**
	* Get productoQuimico
	*
	* @return null|String
	*/
	public function getProductoQuimico()
	{
		return $this->productoQuimico;
	}

	/**
	* Set idConcentracion
	*
	*Identificador unico de la tabla g_catalogos.unidades_medidas
	*
	* @parámetro Integer $idConcentracion
	* @return IdConcentracion
	*/
	public function setIdConcentracion($idConcentracion)
	{
	  $this->idConcentracion = (Integer) $idConcentracion;
	    return $this;
	}

	/**
	* Get idConcentracion
	*
	* @return null|Integer
	*/
	public function getIdConcentracion()
	{
		return $this->idConcentracion;
	}

	/**
	* Set fechaInspeccion
	*
	*Campo que almacena la fecha en la que se inspecciono el producto
	*
	* @parámetro Date $fechaInspeccion
	* @return FechaInspeccion
	*/
	public function setFechaInspeccion($fechaInspeccion)
	{
	  $this->fechaInspeccion = (String) $fechaInspeccion;
	    return $this;
	}

	/**
	* Get fechaInspeccion
	*
	* @return null|Date
	*/
	public function getFechaInspeccion()
	{
		return $this->fechaInspeccion;
	}

	/**
	* Set codigoUnidadConcentracion
	*
	*Campo que almacena el codigo de la concentracion
	*
	* @parámetro String $codigoUnidadConcentracion
	* @return CodigoUnidadConcentracion
	*/
	public function setCodigoUnidadConcentracion($codigoUnidadConcentracion)
	{
	  $this->codigoUnidadConcentracion = (String) $codigoUnidadConcentracion;
	    return $this;
	}

	/**
	* Get codigoUnidadConcentracion
	*
	* @return null|String
	*/
	public function getCodigoUnidadConcentracion()
	{
		return $this->codigoUnidadConcentracion;
	}

	/**
	* Set nombreConcentracion
	*
	*Campo que almacena el nombre de la concentracion
	*
	* @parámetro String $nombreConcentracion
	* @return NombreConcentracion
	*/
	public function setNombreConcentracion($nombreConcentracion)
	{
	  $this->nombreConcentracion = (String) $nombreConcentracion;
	    return $this;
	}

	/**
	* Get nombreConcentracion
	*
	* @return null|String
	*/
	public function getNombreConcentracion()
	{
		return $this->nombreConcentracion;
	}

	/**
	* Set concentracion
	*
	*Campo que almacena el valor de concentracion
	*
	* @parámetro String $concentracion
	* @return Concentracion
	*/
	public function setConcentracion($concentracion)
	{
	  $this->concentracion = (String) $concentracion;
	    return $this;
	}

	/**
	* Get concentracion
	*
	* @return null|String
	*/
	public function getConcentracion()
	{
		return $this->concentracion;
	}

	/**
	* Set fechaRevision
	*
	*Campo que almacena la última fecha de revisión del centro de acopio
	*
	* @parámetro Date $fechaRevision
	* @return FechaRevision
	*/
	public function setFechaRevision($fechaRevision)
	{
	  $this->fechaRevision = (String) $fechaRevision;
	    return $this;
	}

	/**
	* Get fechaRevision
	*
	* @return null|Date
	*/
	public function getFechaRevision()
	{
		return $this->fechaRevision;
	}

	/**
	* Set tipoRevision
	*
	*Campo que almacena el el último tipo de revisión del centro de acopio
	*
	* @parámetro String $tipoRevision
	* @return TipoRevision
	*/
	public function setTipoRevision($tipoRevision)
	{
	  $this->tipoRevision = (String) $tipoRevision;
	    return $this;
	}

	/**
	* Get tipoRevision
	*
	* @return null|String
	*/
	public function getTipoRevision()
	{
		return $this->tipoRevision;
	}

	/**
	* Set identificadorRevision
	*
	*Campo que almacena el último identificador que realiza la revisión del centro de acopio
	*
	* @parámetro String $identificadorRevision
	* @return IdentificadorRevision
	*/
	public function setIdentificadorRevision($identificadorRevision)
	{
	  $this->identificadorRevision = (String) $identificadorRevision;
	    return $this;
	}

	/**
	* Get identificadorRevision
	*
	* @return null|String
	*/
	public function getIdentificadorRevision()
	{
		return $this->identificadorRevision;
	}

	/**
	* Set observacionRevision
	*
	*Campo que almacena la última observación realizada al centro de acopio
	*
	* @parámetro String $observacionRevision
	* @return ObservacionRevision
	*/
	public function setObservacionRevision($observacionRevision)
	{
	  $this->observacionRevision = (String) $observacionRevision;
	    return $this;
	}

	/**
	* Get observacionRevision
	*
	* @return null|String
	*/
	public function getObservacionRevision()
	{
		return $this->observacionRevision;
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
	* @return CertificadoFitosanitarioProductosModelo
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
