<?php
 /**
 * Modelo ProductosInspeccionFitosanitariaModelo
 *
 * Este archivo se complementa con el archivo   ProductosInspeccionFitosanitariaLogicaNegocio.
 *
 * @author  AGROCALIDAD
 * @date    2022-07-21
 * @uses    ProductosInspeccionFitosanitariaModelo
 * @package InspeccionFitosanitaria
 * @subpackage Modelos
 */
  namespace Agrodb\InspeccionFitosanitaria\Modelos;
  
  use Agrodb\Core\ModeloBase;
  use Agrodb\Core\ValidarDatos;
 
class ProductosInspeccionFitosanitariaModelo extends ModeloBase 
{

		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla
		*/
		protected $idProductoInspeccionFitosanitaria;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_inspecciones_fitosanitarias.inspeccion_fitosanitaria
		*/
		protected $idInspeccionFitosanitaria;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena laidentificacion de productor
		*/
		protected $identificadorOperador;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_operadores.areas. Identifica el id del sitio
		*/
		protected $idSitio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del sitio
		*/
		protected $nombreSitio;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la provincia
		*/
		protected $nombreProvincia;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del canton
		*/
		protected $nombreCanton;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_operadores.areas. Identifica el id del area
		*/
		protected $idArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre del area
		*/
		protected $nombreArea;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el codigo del area
		*/
		protected $codigoArea;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.tipos_productos. Identifica el tipo de producto
		*/
		protected $idTipoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campoque almacena el nombre del tipo de producto
		*/
		protected $nombreTipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.subtipos_productos. Identifica el tipo de producto
		*/
		protected $idSubtipoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campoque almacena el nombre del subtipo de producto
		*/
		protected $nombreSubtipoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.productos. Identifica el producto
		*/
		protected $idProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campoque almacena el nombre del producto
		*/
		protected $nombreProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad de producto
		*/
		protected $cantidadProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificacor unico de la tabla g_catalogos.unidades_fitosanitarias
		*/
		protected $idUnidadCantidadProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la unidad de medidad de la cantidad
		*/
		protected $nombreUnidadCantidadProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el peso del producto
		*/
		protected $pesoProducto;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el identificacor unico de la tabla g_catalogos.unidades_fitosanitarias
		*/
		protected $idUnidadPesoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el nombre de la unidad de medidad del peso
		*/
		protected $nombreUnidadPesoProducto;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad aprobada
		*/
		protected $cantidadAprobada;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el peso aprobado
		*/
		protected $pesoAprobado;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena la cantidad inspeccionada
		*/
		protected $cantidadInspeccionada;
		/**
		* @var String
		* Campo requerido
		* Campo visible en el formulario
		* Campo que almacena el peso inspeccionado
		*/
		protected $pesoInspeccionado;
		/**
		* @var Integer
		* Campo requerido
		* Campo visible en el formulario
		* Identificador unico de la tabla g_catalogos.tipos_tratamiento. Identifica el tipo de tratamiento del producto
		*/
		protected $idTipoTratamiento;
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
		* Identificador unico de la tabla g_catalogos.tratamientos. Identifica el tratamiento del producto
		*/
		protected $idTratamiento;
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
		* Identificador unico de la tabla g_catalogos.unidades_medidas.
		*/
		protected $idConcentracion;
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
	* Campos del formulario 
	* @var array 
	 */
	Private $campos = Array();

	/**
	* Nombre del esquema 
	* 
	 */
	Private $esquema ="g_inspeccion_fitosanitaria";

	/**
	* Nombre de la tabla: productos_inspeccion_fitosanitaria
	* 
	 */
	Private $tabla="productos_inspeccion_fitosanitaria";

	/**
	*Clave primaria
*/
		 private $clavePrimaria = "id_producto_inspeccion_fitosanitaria";



	/**
	*Secuencia
*/
		 private $secuencial = 'g_inspeccion_fitosanitaria"."productos_inspeccion_fitosani_id_producto_inspeccion_fitosa_seq'; 



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
		throw new \Exception('Clase Modelo: ProductosInspeccionFitosanitariaModelo. Propiedad especificada invalida: set'.$name);
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
	  throw new \Exception('Clase Modelo: ProductosInspeccionFitosanitariaModelo. Propiedad especificada invalida: get'.$name);
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
	* Get g_inspeccion_fitosanitaria
	*
	* @return null|
	*/
	public function getEsquema()
	{
		 return $this->esquema;
	}

	/**
	* Set idProductoInspeccionFitosanitaria
	*
	*Identificador unico de la tabla
	*
	* @parámetro Integer $idProductoInspeccionFitosanitaria
	* @return IdProductoInspeccionFitosanitaria
	*/
	public function setIdProductoInspeccionFitosanitaria($idProductoInspeccionFitosanitaria)
	{
	  $this->idProductoInspeccionFitosanitaria = (Integer) $idProductoInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get idProductoInspeccionFitosanitaria
	*
	* @return null|Integer
	*/
	public function getIdProductoInspeccionFitosanitaria()
	{
		return $this->idProductoInspeccionFitosanitaria;
	}

	/**
	* Set idInspeccionFitosanitaria
	*
	*Identificador unico de la tabla g_inspecciones_fitosanitarias.inspeccion_fitosanitaria
	*
	* @parámetro Integer $idInspeccionFitosanitaria
	* @return IdInspeccionFitosanitaria
	*/
	public function setIdInspeccionFitosanitaria($idInspeccionFitosanitaria)
	{
	  $this->idInspeccionFitosanitaria = (Integer) $idInspeccionFitosanitaria;
	    return $this;
	}

	/**
	* Get idInspeccionFitosanitaria
	*
	* @return null|Integer
	*/
	public function getIdInspeccionFitosanitaria()
	{
		return $this->idInspeccionFitosanitaria;
	}

	/**
	* Set identificadorOperador
	*
	*Campo que almacena laidentificacion de productor
	*
	* @parámetro String $identificadorOperador
	* @return IdentificadorOperador
	*/
	public function setIdentificadorOperador($identificadorOperador)
	{
	  $this->identificadorOperador = (String) $identificadorOperador;
	    return $this;
	}

	/**
	* Get identificadorOperador
	*
	* @return null|String
	*/
	public function getIdentificadorOperador()
	{
		return $this->identificadorOperador;
	}

	/**
	* Set idSitio
	*
	*Identificador unico de la tabla g_operadores.areas. Identifica el id del sitio
	*
	* @parámetro Integer $idSitio
	* @return IdSitio
	*/
	public function setIdSitio($idSitio)
	{
	  $this->idSitio = (Integer) $idSitio;
	    return $this;
	}

	/**
	* Get idSitio
	*
	* @return null|Integer
	*/
	public function getIdSitio()
	{
		return $this->idSitio;
	}

	/**
	* Set nombreSitio
	*
	*Campo que almacena el nombre del sitio
	*
	* @parámetro String $nombreSitio
	* @return NombreSitio
	*/
	public function setNombreSitio($nombreSitio)
	{
	  $this->nombreSitio = (String) $nombreSitio;
	    return $this;
	}

	/**
	* Get nombreSitio
	*
	* @return null|String
	*/
	public function getNombreSitio()
	{
		return $this->nombreSitio;
	}

	/**
	* Set nombreProvincia
	*
	*Campo que almacena el nombre de la provincia
	*
	* @parámetro String $nombreProvincia
	* @return NombreProvincia
	*/
	public function setNombreProvincia($nombreProvincia)
	{
	  $this->nombreProvincia = (String) $nombreProvincia;
	    return $this;
	}

	/**
	* Get nombreProvincia
	*
	* @return null|String
	*/
	public function getNombreProvincia()
	{
		return $this->nombreProvincia;
	}

	/**
	* Set nombreCanton
	*
	*Campo que almacena el nombre del canton
	*
	* @parámetro String $nombreCanton
	* @return NombreCanton
	*/
	public function setNombreCanton($nombreCanton)
	{
	  $this->nombreCanton = (String) $nombreCanton;
	    return $this;
	}

	/**
	* Get nombreCanton
	*
	* @return null|String
	*/
	public function getNombreCanton()
	{
		return $this->nombreCanton;
	}

	/**
	* Set idArea
	*
	*Identificador unico de la tabla g_operadores.areas. Identifica el id del area
	*
	* @parámetro Integer $idArea
	* @return IdArea
	*/
	public function setIdArea($idArea)
	{
	  $this->idArea = (Integer) $idArea;
	    return $this;
	}

	/**
	* Get idArea
	*
	* @return null|Integer
	*/
	public function getIdArea()
	{
		return $this->idArea;
	}

	/**
	* Set nombreArea
	*
	*Campo que almacena el nombre del area
	*
	* @parámetro String $nombreArea
	* @return NombreArea
	*/
	public function setNombreArea($nombreArea)
	{
	  $this->nombreArea = (String) $nombreArea;
	    return $this;
	}

	/**
	* Get nombreArea
	*
	* @return null|String
	*/
	public function getNombreArea()
	{
		return $this->nombreArea;
	}

	/**
	* Set codigoArea
	*
	*Campo que almacena el codigo del area
	*
	* @parámetro String $codigoArea
	* @return CodigoArea
	*/
	public function setCodigoArea($codigoArea)
	{
	  $this->codigoArea = (String) $codigoArea;
	    return $this;
	}

	/**
	* Get codigoArea
	*
	* @return null|String
	*/
	public function getCodigoArea()
	{
		return $this->codigoArea;
	}

	/**
	* Set idTipoProducto
	*
	*Identificador unico de la tabla g_catalogos.tipos_productos. Identifica el tipo de producto
	*
	* @parámetro Integer $idTipoProducto
	* @return IdTipoProducto
	*/
	public function setIdTipoProducto($idTipoProducto)
	{
	  $this->idTipoProducto = (Integer) $idTipoProducto;
	    return $this;
	}

	/**
	* Get idTipoProducto
	*
	* @return null|Integer
	*/
	public function getIdTipoProducto()
	{
		return $this->idTipoProducto;
	}

	/**
	* Set nombreTipoProducto
	*
	*Campoque almacena el nombre del tipo de producto
	*
	* @parámetro String $nombreTipoProducto
	* @return NombreTipoProducto
	*/
	public function setNombreTipoProducto($nombreTipoProducto)
	{
	  $this->nombreTipoProducto = (String) $nombreTipoProducto;
	    return $this;
	}

	/**
	* Get nombreTipoProducto
	*
	* @return null|String
	*/
	public function getNombreTipoProducto()
	{
		return $this->nombreTipoProducto;
	}

	/**
	* Set idSubtipoProducto
	*
	*Identificador unico de la tabla g_catalogos.subtipos_productos. Identifica el tipo de producto
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
	*Campoque almacena el nombre del subtipo de producto
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
	*Identificador unico de la tabla g_catalogos.productos. Identifica el producto
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
	*Campoque almacena el nombre del producto
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
	* Set cantidadProducto
	*
	*Campo que almacena la cantidad de producto
	*
	* @parámetro String $cantidadProducto
	* @return CantidadProducto
	*/
	public function setCantidadProducto($cantidadProducto)
	{
	  $this->cantidadProducto = (String) $cantidadProducto;
	    return $this;
	}

	/**
	* Get cantidadProducto
	*
	* @return null|String
	*/
	public function getCantidadProducto()
	{
		return $this->cantidadProducto;
	}

	/**
	* Set idUnidadCantidadProducto
	*
	*Campo que almacena el identificacor unico de la tabla g_catalogos.unidades_fitosanitarias
	*
	* @parámetro Integer $idUnidadCantidadProducto
	* @return IdUnidadCantidadProducto
	*/
	public function setIdUnidadCantidadProducto($idUnidadCantidadProducto)
	{
	  $this->idUnidadCantidadProducto = (Integer) $idUnidadCantidadProducto;
	    return $this;
	}

	/**
	* Get idUnidadCantidadProducto
	*
	* @return null|Integer
	*/
	public function getIdUnidadCantidadProducto()
	{
		return $this->idUnidadCantidadProducto;
	}

	/**
	* Set nombreUnidadCantidadProducto
	*
	*Campo que almacena el nombre de la unidad de medidad de la cantidad
	*
	* @parámetro String $nombreUnidadCantidadProducto
	* @return NombreUnidadCantidadProducto
	*/
	public function setNombreUnidadCantidadProducto($nombreUnidadCantidadProducto)
	{
	  $this->nombreUnidadCantidadProducto = (String) $nombreUnidadCantidadProducto;
	    return $this;
	}

	/**
	* Get nombreUnidadCantidadProducto
	*
	* @return null|String
	*/
	public function getNombreUnidadCantidadProducto()
	{
		return $this->nombreUnidadCantidadProducto;
	}

	/**
	* Set pesoProducto
	*
	*Campo que almacena el peso del producto
	*
	* @parámetro String $pesoProducto
	* @return PesoProducto
	*/
	public function setPesoProducto($pesoProducto)
	{
	  $this->pesoProducto = (String) $pesoProducto;
	    return $this;
	}

	/**
	* Get pesoProducto
	*
	* @return null|String
	*/
	public function getPesoProducto()
	{
		return $this->pesoProducto;
	}

	/**
	* Set idUnidadPesoProducto
	*
	*Campo que almacena el identificacor unico de la tabla g_catalogos.unidades_fitosanitarias
	*
	* @parámetro Integer $idUnidadPesoProducto
	* @return IdUnidadPesoProducto
	*/
	public function setIdUnidadPesoProducto($idUnidadPesoProducto)
	{
	  $this->idUnidadPesoProducto = (Integer) $idUnidadPesoProducto;
	    return $this;
	}

	/**
	* Get idUnidadPesoProducto
	*
	* @return null|Integer
	*/
	public function getIdUnidadPesoProducto()
	{
		return $this->idUnidadPesoProducto;
	}

	/**
	* Set nombreUnidadPesoProducto
	*
	*Campo que almacena el nombre de la unidad de medidad del peso
	*
	* @parámetro String $nombreUnidadPesoProducto
	* @return NombreUnidadPesoProducto
	*/
	public function setNombreUnidadPesoProducto($nombreUnidadPesoProducto)
	{
	  $this->nombreUnidadPesoProducto = (String) $nombreUnidadPesoProducto;
	    return $this;
	}

	/**
	* Get nombreUnidadPesoProducto
	*
	* @return null|String
	*/
	public function getNombreUnidadPesoProducto()
	{
		return $this->nombreUnidadPesoProducto;
	}

	/**
	* Set cantidadAprobada
	*
	*Campo que almacena la cantidad aprobada
	*
	* @parámetro String $cantidadAprobada
	* @return CantidadAprobada
	*/
	public function setCantidadAprobada($cantidadAprobada)
	{
	  $this->cantidadAprobada = (String) $cantidadAprobada;
	    return $this;
	}

	/**
	* Get cantidadAprobada
	*
	* @return null|String
	*/
	public function getCantidadAprobada()
	{
		return $this->cantidadAprobada;
	}

	/**
	* Set pesoAprobado
	*
	*Campo que almacena el peso aprobado
	*
	* @parámetro String $pesoAprobado
	* @return PesoAprobado
	*/
	public function setPesoAprobado($pesoAprobado)
	{
	  $this->pesoAprobado = (String) $pesoAprobado;
	    return $this;
	}

	/**
	* Get pesoAprobado
	*
	* @return null|String
	*/
	public function getPesoAprobado()
	{
		return $this->pesoAprobado;
	}

	/**
	* Set cantidadInspeccionada
	*
	*Campo que almacena la cantidad inspeccionada
	*
	* @parámetro String $cantidadInspeccionada
	* @return CantidadInspeccionada
	*/
	public function setCantidadInspeccionada($cantidadInspeccionada)
	{
	  $this->cantidadInspeccionada = (String) $cantidadInspeccionada;
	    return $this;
	}

	/**
	* Get cantidadInspeccionada
	*
	* @return null|String
	*/
	public function getCantidadInspeccionada()
	{
		return $this->cantidadInspeccionada;
	}

	/**
	* Set pesoInspeccionado
	*
	*Campo que almacena el peso inspeccionado
	*
	* @parámetro String $pesoInspeccionado
	* @return PesoInspeccionado
	*/
	public function setPesoInspeccionado($pesoInspeccionado)
	{
	  $this->pesoInspeccionado = (String) $pesoInspeccionado;
	    return $this;
	}

	/**
	* Get pesoInspeccionado
	*
	* @return null|String
	*/
	public function getPesoInspeccionado()
	{
		return $this->pesoInspeccionado;
	}

	/**
	* Set idTipoTratamiento
	*
	*Identificador unico de la tabla g_catalogos.tipos_tratamiento. Identifica el tipo de tratamiento del producto
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
	*Identificador unico de la tabla g_catalogos.tratamientos. Identifica el tratamiento del producto
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
	*Identificador unico de la tabla g_catalogos.unidades_medidas.
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
	* @return ProductosInspeccionFitosanitariaModelo
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
